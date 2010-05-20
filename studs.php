<?php
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Auteur : Guilhem BORGHESI
//Création : Février 2008
//
//borghesi@unistra.fr
//
//Ce logiciel est régi par la licence CeCILL-B soumise au droit français et
//respectant les principes de diffusion des logiciels libres. Vous pouvez
//utiliser, modifier et/ou redistribuer ce programme sous les conditions
//de la licence CeCILL-B telle que diffusée par le CEA, le CNRS et l'INRIA 
//sur le site "http://www.cecill.info".
//
//Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
//pris connaissance de la licence CeCILL-B, et que vous en avez accepté les
//termes. Vous pouvez trouver une copie de la licence dans le fichier LICENCE.
//
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Author : Guilhem BORGHESI
//Creation : Feb 2008
//
//borghesi@unistra.fr
//
//This software is governed by the CeCILL-B license under French law and
//abiding by the rules of distribution of free software. You can  use, 
//modify and/ or redistribute the software under the terms of the CeCILL-B
//license as circulated by CEA, CNRS and INRIA at the following URL
//"http://www.cecill.info". 
//
//The fact that you are presently reading this means that you have had
//knowledge of the CeCILL-B license and that you accept its terms. You can
//find a copy of this license in the file LICENSE.
//
//==========================================================================

session_start();

if (file_exists('bandeaux_local.php'))
	include 'bandeaux_local.php';
else
	include 'bandeaux.php';
include 'fonctions.php';

// Le fichier studs.php sert a afficher les résultats d'un sondage à un simple utilisateur. 
// C'est également l'interface pour ajouter une valeur à un sondage deja créé.



//On récupère le numéro de sondage par le lien web.
$numsondage=$_GET["sondage"];

$dsondage = get_sondage_from_id($_SESSION['numsondage']);

//verification de l'existence du sondage
// S'il n'existe pas, il affiche une page d'erreur
if (!$dsondage) {

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	logo();
	bandeau_tete();
	bandeau_titre_erreur();
	echo '<div class=corpscentre>'."\n";
	print "<H2>" . _("This poll doesn't exist !") . "</H2>"."\n";
	print "" . _("Back to the homepage of ") . " <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>."."\n";
	echo '<br><br><br><br>'."\n";
	echo '</div>'."\n";
#	sur_bandeau_pied();
	bandeau_pied();
	
	echo '</body>'."\n";
	echo '</html>'."\n";
	die();
}

$user_studs=$connect->Execute("select * from user_studs where id_sondage='$numsondage' order by id_users");

	if ($_POST["exportics_x"]){
		header("Location:exportics.php");
		exit();

	}
	if ($_POST["exportcsv_x"]){
		$_SESSION["numsondage"]=$_GET["sondage"];
		header("Location:exportcsv.php");
		exit();

	}
	
	
	//quand on ajoute un commentaire utilisateur
	if ($_POST["ajoutcomment"]||$_POST["ajoutcomment_x"]){
		if ($_POST["comment"]!=""&&$_POST["commentuser"]!=""){
		  $connect->Execute("insert into comments values ('$numsondage','$_POST[comment]','$_POST[commentuser]')");
		}
		else {
			$erreur_commentaire_vide="yes";
		}
	}
	
	

//On récupere les données et les sujets du sondage
	$nbcolonnes=substr_count($dsondage->sujet,',')+1;
	$nblignes=$user_studs->RecordCount();

	// Action quand on clique le bouton participer
	if ($_POST["boutonp"]||$_POST["boutonp_x"]){
	//Si le nom est bien entré
		if ($_POST["nom"] && (!isset($_SERVER['REMOTE_USER']) ||($_POST["nom"] == $_SESSION["nom"]))) {
			for ($i=0;$i<$nbcolonnes;$i++){
				
				// Si la checkbox est enclenchée alors la valeur est 1
				if (isset($_POST["choix$i"])){
					$nouveauchoix.="1";
				}
				// sinon c'est 0
				else {
					$nouveauchoix.="0";
				}
			}

			while($user = $user_studs->FetchNextObject(false)) {

					if ($_POST["nom"]==$user->nom){
						$erreur_prenom="yes";
					}
			}

			if (preg_match(";[\<\>\"'\\];", $_POST["nom"])) {
				$erreur_injection="yes";
			}

			// Ecriture des choix de l'utilisateur dans la base
 			if (!$erreur_prenom&&!$erreur_injection){
				$nom=$_POST["nom"];
 				$connect->Execute("insert into user_studs values ('$nom', '$numsondage', '$nouveauchoix')");

				if ($dsondage->mailsonde == true || /* compatibility for non boolean DB */ $dsondage->mailsonde=="yes"){

					$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
					mail ("$dsondage->mail_admin", "[".getenv('NOMAPPLICATION')."] " . _("Poll's participation") . " : $dsondage->titre", "\"$nom\""."" . _("has filled a line.\nYou can find your poll at the link") . " :\n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
				}
			}
		}
	}
	
			//on teste pour voir si une ligne doit etre modifiée
		$testligneamodifier = $testmodifier = false;
		for ($i=0;$i<$nblignes;$i++){
			if (isset($_POST["modifierligne$i"]) || isset($_POST['modifierligne'.$i.'_x'])){
				$ligneamodifier=$i;
				$testligneamodifier=true;
			}
			//test pour voir si une ligne est a modifier
			if ($_POST['validermodifier'.$i.'_x']){
				$modifier=$i;
				$testmodifier=true;
			}
		}
		//si le test est valide alors on affiche des checkbox pour entrer de nouvelles valeurs
		if ($testmodifier){

			for ($i=0;$i<$nbcolonnes;$i++){
				//recuperation des nouveaux choix de l'utilisateur
				if (isset($_POST["choix$i"])){
					$nouveauchoix.="1";
				}
				else {
					$nouveauchoix.="0";
				}
			}

			$compteur=0;
			while ($data=$user_studs->FetchNextObject(false) ) {
				//mise a jour des données de l'utilisateur dans la base SQL
				if ($compteur==$modifier){
					$connect->Execute("update user_studs set reponses='$nouveauchoix' where nom='$data->nom' and id_users='$data->id_users'");
					if ($dsondage->mailsonde=="yes"){
						
						$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
						mail ("$dsondage->mail_admin", "[".getenv('NOMAPPLICATION')."] " . _("Poll's participation") . " : $dsondage->titre", "\"$data->nom\""."" . _("has filled a line.\nYou can find your poll at the link") . " :\n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
					}
				}
				$compteur++;
			}
		}
	
//recuperation des utilisateurs du sondage
	$user_studs=$connect->Execute("select * from user_studs where id_sondage='$numsondage' order by id_users");

// Affichage des balises standards et du titre de la page
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '<script type="text/javascript" src="block_enter.js"></script>';

	echo '</head>'."\n";
	echo '<body>'."\n";

// debut du formulaire et affichage des bandeanx
	echo '<form name="formulaire" action="studs.php?sondage='.$numsondage.'#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	logo();
 	bandeau_tete();
	bandeau_titre();
	sous_bandeau();
	echo '<div class="presentationdate"> '."\n";

//affichage du titre du sondage
        $titre=str_replace("\\","",$dsondage->titre);       
	echo '<H2>'.$titre.'</H2>'."\n";

//affichage du nom de l'auteur du sondage
	echo _("Initiator of the poll") .' : '.$dsondage->nom_admin.'<br><br>'."\n";

//affichage des commentaires du sondage
	if ($dsondage->commentaires){
		echo _("Comments") .' :<br>'."\n";
                $commentaires=$dsondage->commentaires;
                $commentaires=str_replace("\\","",$commentaires);       
                echo $commentaires;

		echo '<br>'."\n";
	}
	echo '<br>'."\n";
	echo '</div>'."\n";
	echo '<div class="cadre"> '."\n";

	echo _("If you want to vote in this poll, you have to give your name, choose the values that fit best for you<br>(without paying attention to the choices of the other voters) and validate with the plus button at the end of the line.") ."\n";

	echo '<br><br>'."\n";


// Debut de l'affichage des resultats du sondage
	echo '<table class="resultats">'."\n";

//reformatage des données des sujets du sondage
	$toutsujet=explode(",",$dsondage->sujet);

//si le sondage est un sondage de date
if ($dsondage->format=="D"||$dsondage->format=="D+"){
	
//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";

	//affichage des années
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%Y",$toutsujet[$i])==strftime("%Y",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			echo '<td colspan='.$colspan.' class="annee">'.strftime("%Y",$toutsujet[$i]).'</td>'."\n";
			$colspan=1;
		}
	}
	echo '</tr>'."\n";
	
	echo '<tr>'."\n";	
	echo '<td></td>'."\n";
	//affichage des mois
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])&&strftime("%Y",$toutsujet[$i])==strftime("%Y",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			if ($_SESSION["langue"]=="FR"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="mois">'.date("F",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			$colspan=1;
		}
	}
	echo '</tr>'."\n";

	echo '<tr>'."\n";		
	echo '<td></td>'."\n";
		//affichage des jours
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%a %e",$toutsujet[$i])==strftime("%a %e",$toutsujet[$i+1])&&strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			if ($_SESSION["langue"]=="FR"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="jour">'.date("D jS",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}			
			$colspan=1;
		}
	}
	echo '</tr>'."\n";
		//affichage des horaires	
	if (strpos('@',$dsondage->sujet) !== false){
		echo '<tr>'."\n";
		echo '<td></td>'."\n";
				
		for ($i=0;$toutsujet[$i];$i++){
			$heures=explode("@",$toutsujet[$i]);
			echo '<td class="heure">'.$heures[1].'</td>'."\n";
		}
		echo '</tr>'."\n";
	}
}

else {
	$toutsujet=str_replace("°","'",$toutsujet);	

//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";

	for ($i=0;$toutsujet[$i];$i++){
	
		echo '<td class="sujet">'.$toutsujet[$i].'</td>'."\n";
	}
	echo '</tr>'."\n";

}
	
//Usager pr�-authentifi� dans la miste?
	$user_mod = FALSE;
//affichage des resultats actuels
$somme = array();
	$compteur = 0;
	while ($data=$user_studs->FetchNextObject(false)) {

		echo '<tr>'."\n";
		echo '<td class="nom">';

// Le nom de l'utilisateur
		$nombase=str_replace("°","'",$data->nom);
		echo $nombase.'</td>'."\n";
// Les réponses qu'il a choisit
		$ensemblereponses=$data->reponses;
// ligne d'un usager pré-authentifié
		$mod_ok = !isset($_SERVER['REMOTE_USER']) || ($nombase == $_SESSION['nom']);
		$user_mod |= $mod_ok;
			//si la ligne n'est pas a changer, on affiche les données
			if (!$testligneamodifier){
				for ($k=0;$k<$nbcolonnes;$k++){
					$car=substr($ensemblereponses,$k,1);
					if ($car=="1"){
						echo '<td class="ok">OK</td>'."\n";
						$somme[$k]++;
					}
					else {
						echo '<td class="non"></td>'."\n";
					}
				}
			}
			//sinon on remplace les choix de l'utilisateur par une ligne de checkbox pour recuperer de nouvelles valeurs
			else {
				//si c'est bien la ligne a modifier on met les checkbox
				if ($compteur=="$ligneamodifier"){
					for ($j=0;$j<$nbcolonnes;$j++){
					  echo '<td class="vide"><input type="checkbox" name="choix'.$j.'" value="" ' .
					    substr($ensemblereponses,$j,1) == '1' ? 'checked="checked"' : '' . 
					    '></td>'."\n";
					}
				}
				//sinon on affiche les lignes normales
				else {
					for ($k=0;$k<$nbcolonnes;$k++){
						$car=substr($ensemblereponses,$k,1);
						if ($car=="1"){
							echo '<td class="ok">OK</td>'."\n";
							$somme[$k]++;
						}
						else {
							echo '<td class="non"></td>'."\n";
						}
					}
				}

			}
			
			//a la fin de chaque ligne se trouve les boutons modifier
			if (!$testligneamodifier && ($dsondage->format=="A+"||$dsondage->format=="D+") && $mod_ok){
				echo '<td class=casevide><input type="image" name="modifierligne'.$compteur.'" value="Modifier" src="images/info.png"></td>'."\n";
			}
			
			//demande de confirmation pour modification de ligne
			for ($i=0;$i<$nblignes;$i++){
				if (isset($_POST["modifierligne$i"])||isset($_POST['modifierligne'.$i.'_x'])){
					if ($compteur==$i){
						echo '<td class=casevide><input type="image" name="validermodifier'.$compteur.'" value="Valider la modification" src="images/accept.png" ></td>'."\n";
					}
				}
			}
			$compteur++;
			echo '</tr>'."\n";
	}
	
// affichage de la ligne pour un nouvel utilisateur
	if (!isset($_SERVER['REMOTE_USER']) || !$user_mod) {
		echo '<tr>'."\n";
		echo '<td class=nom>'."\n";
		if (isset($_SERVER['REMOTE_USER']))
			echo '<input type=hidden name="nom" value="'.
			      $_SESSION['nom'].'">'.$_SESSION['nom']."\n";
		else
			echo '<input type=text name="nom">'."\n";
		echo '</td>'."\n";

// affichage des cases de formulaire checkbox pour un nouveau choix
		for ($i=0;$i<$nbcolonnes;$i++){
			echo '<td class="vide"><input type="checkbox" name="choix'.$i.'" value=""></td>'."\n";
		}
		// Affichage du bouton de formulaire pour inscrire un nouvel utilisateur dans la base
		echo '<td><input type="image" name="boutonp" value="Participer" src="images/add-24.png"></td>'."\n";
		echo '</tr>'."\n";
	}

//determination de la meilleure date

// On cherche la meilleure colonne
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($i=="0"){
			$meilleurecolonne=$somme[$i];
		}
		if ($somme[$i]>$meilleurecolonne){
			$meilleurecolonne=$somme[$i];
		}
	}

// Affichage des différentes sommes des colonnes existantes
	echo '<tr>'."\n";
	echo '<td align="right">'. _("Addition") .'</td>'."\n";

	for ($i=0;$i<$nbcolonnes;$i++){
		$affichesomme=$somme[$i];
		if ($affichesomme==""){$affichesomme="0";}
		echo '<td class="somme">'.$affichesomme.'</td>'."\n";
	}
	echo '</tr>'."\n";
	
	echo '<tr>'."\n";
	echo '<td class="somme"></td>'."\n";
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($somme[$i]==$meilleurecolonne&&$somme[$i]){
			echo '<td class="somme"><img src="images/medaille.png" alt="Meilleur choix"></td>'."\n";
		}
		else {
			echo '<td class="somme"></td>'."\n";
		}

		}
	echo '</tr>'."\n";

	echo '</table>'."\n";
	echo '</div>'."\n";

	echo '<p class=affichageresultats>'."\n";
	// S'il a oublié de remplir un nom
	if ($_POST["boutonp_x"]&&$_POST["nom"]=="") {
			print "<font color=#FF0000>" . _("Enter a name !") . "</font>\n";
		}
	if ($erreur_prenom){
			print "<font color=#FF0000>" . _("The name you've chosen already exist in this poll!") . "</font>\n";
	}
	if ($erreur_injection){
			print "<font color=#FF0000>" . _("Characters \"  '  < et > are not permitted") . "</font>\n";
	}
	echo '<br>'."\n";
// Focus javascript sur la case de texte du formulaire
	echo '<script type="text/javascript">'."\n";
	echo 'document.formulaire.nom.focus();'."\n";
	echo '</script>'."\n";

// reformatage des données de la base pour les sujets
	$toutsujet=explode(",",$dsondage->sujet);
	$toutsujet=str_replace("°","'",$toutsujet);

// On compare le nombre de résultat avec le meilleur et si le résultat est égal
//  on concatene le resultat dans $meilleursujet

	$compteursujet=0;
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($somme[$i]==$meilleurecolonne){
			$meilleursujet.=", ";
			  	if ($dsondage->format=="D"||$dsondage->format=="D+"){
					$meilleursujetexport=$toutsujet[$i];
					if (strpos('@',$toutsujet[$i]) !== false){
						$toutsujetdate=explode("@",$toutsujet[$i]);
						$meilleursujet.=date(_("l, F jS Y") ,$toutsujetdate[0]) . " " . _("for"). " ".$toutsujetdate[1];
					}
					else
					  $meilleursujet.=date(_("l, F jS Y") ,$toutsujet[$i]);
				}
				else
				  $meilleursujet.=$toutsujet[$i];
				
			$compteursujet++;
		}
	}
	$meilleursujet=substr("$meilleursujet",1);

	// Affichage du meilleur choix

	if ($compteursujet=="1"&&$meilleurecolonne){
	  print "<img src=\"images/medaille.png\" alt=\"Meilleur choix\"> " . _("The best choice at this time is") . " : <b>$meilleursujet </b>" . _("with") . " <b>$meilleurecolonne </b>" . ($meilleurecolonne > 1) ? _("votes") : _("vote") . ".\n";
 	}
	elseif ($meilleurecolonne){
	  print "<img src=\"images/medaille.png\" alt=\"Meilleur choix\"> " . _("The bests choices at this time are") . " : <b>$meilleursujet </b>" . _("with") . " <b>$meilleurecolonne </b>" . ($meilleurecolonne > 1) ? _("votes") : _("vote") . ".\n";
	}
	
	echo '<br>';
	
	//affichage des commentaires des utilisateurs existants
	$comment_user=$connect->Execute("select * from comments where id_sondage='$numsondage' order by id_comment");
	if ($comment_user->RecordCount() != 0) {

		print "<br><b>" . _("Comments") . " :</b><br>\n";
		while( $dcomment=$comment_user->FetchRow()) {
			print "$dcomment->usercomment : $dcomment->comment <br>";
		}

	}
	
	if ($erreur_commentaire_vide=="yes"){
		print "<font color=#FF0000>" . _("Enter a name and a comment!") . "</font>";
	}
	
	//affichage de la case permettant de rajouter un commentaire par les utilisateurs
	print "<br>" . _("Add a comment in the poll") . " :<br>\n";
	echo _("Name") .' : ';
	if (isset($_SERVER['REMOTE_USER']))
		echo '<input type="hidden" name="commentuser" value="'.$_SESSION['nom'].'">'.$_SESSION['nom'].'<br>'."\n";
	else
		echo '<input type="text" name="commentuser"><br>'."\n";
	echo '<textarea name="comment" rows="2" cols="40"></textarea>'."\n";
	echo '<input type="image" name="ajoutcomment" value="Ajouter un commentaire" src="images/accept.png" alt="Valider"><br>'."\n";
	
	echo '<br><br>'."\n";
	echo '<p class=affichageexport>'."\n";
	echo _("Export: Spreadsheet") .' (.CSV) <input type="image" name="exportcsv" value="Export en CSV" src="images/csv.png" alt="Export CSV">  ';
 		if (($dsondage->format=="D"||$dsondage->format=="D+")&&$compteursujet=="1"&&$meilleurecolonne){
  			echo _("Agenda") .' (.ICS) :<input type="image" name="exportics" value="Export en iCal" src="images/ical.png" alt="Export iCal">';
  			$_SESSION["meilleursujet"]=$meilleursujetexport;
  			$_SESSION["numsondage"]=$numsondage;
  			$_SESSION["sondagetitre"]=$dsondage->titre;
  		}
	echo '<br><br>'."\n";
	echo '<a name=bas></a>'."\n";
	echo '</p>'."\n";

	sur_bandeau_pied_mobile();
	bandeau_pied_mobile();
	// Affichage du bandeau de pied
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

?>
