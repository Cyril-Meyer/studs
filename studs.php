<?php
session_start();
setlocale(LC_TIME, "fr_FR");
include 'bandeaux.php';
include 'fonctions.php';

// Le fichier studs.php sert a afficher les résultats d'un sondage à un simple utilisateur. 
// C'est également l'interface pour ajouter une valeur à un sondage deja créé.



//On récupère le numéro de sondage par le lien web.
$numsondage=$_GET["sondage"];

// Ouverture de la base de données
$connect=connexion_base();

if (eregi("[a-z0-9]{16}",$numsondage)){

	// récupération des données du sondage en fonction de la valeur passée dans l'URL
	$sondage=pg_exec($connect, "select * from sondage where id_sondage ilike '$numsondage'");
	$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$numsondage'");
	$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");

}

//verification de l'existence du sondage
// S'il n'existe pas, il affiche une page d'erreur
if (!$sondage||pg_numrows($sondage)=="0"){

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>Erreur STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	bandeau_tete();
	bandeau_titre_erreur();
	echo '<div class=corpscentre>'."\n";
	print "<H2>Ce sondage n'existe pas !</H2>"."\n";
	print "Vous pouvez retourner &agrave; la page d'accueil de <a href=\"index.php\"> STUdS</A>."."\n";
	echo '</div>'."\n";
	bandeau_pied();
	
	echo '</body>'."\n";
	echo '</html>'."\n";

}

// Sinon il affiche le sondage concerné
else {

	//bouton annuler
	if ($_POST["annuler"]){
		header("Location:index.php");
		exit();
	}


	if ($_POST["exportics_x"]){
		header("Location:exportics.php");
		exit();

	}
	if ($_POST["exportcsv"]){
		$_SESSION["numsondage"]=$_GET["sondage"];
		header("Location:exportcsv.php");
		exit();

	}



//On récupere les données et les sujets du sondage
	$dsondage=pg_fetch_object($sondage,0);
	$dsujet=pg_fetch_object($sujets,0);
	$nbcolonnes=substr_count($dsujet->sujet,',')+1;
	$nblignes=pg_numrows($user_studs);

	// Action quand on clique le bouton participer
	if ($_POST["boutonp"]||$_POST["boutonp_x"]){
	//Si le nom est bien entré
		if ($_POST["nom"]){
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

			for ($compteur=0;$compteur<pg_numrows($user_studs);$compteur++){

					$user=pg_fetch_object($user_studs,$compteur);

					if ($_POST["nom"]==$user->nom){
						$erreur_prénom="yes";
					}
			}

			if (ereg("<|>", $_POST["nom"])){
				$erreur_injection="yes";
			}

			// Ecriture des choix de l'utilisateur dans la base
 			if (!$erreur_prénom&&!$erreur_injection){
				$nom=str_replace("'","°",$_POST["nom"]);
 				pg_query($connect,"insert into user_studs values ('$nom', '$numsondage', '$nouveauchoix')");

#				$headers="From: STUdS <studs@dpt-info.u-strasbg.fr>\n";

				if ($dsondage->mailsonde=="yes"){
					mail ("$dsondage->mail_admin", utf8_decode ("[STUdS] Participation au sondage : $dsondage->titre"), utf8_decode ("\"$nom\" vient de compléter une ligne.\nVous pouvez retrouver votre sondage à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/studs.php?sondage=$numsondage \n\nMerci de votre confiance.\nSTUdS !"),$headers);
				}
			}
		}
	}
	
			//on teste pour voir si une ligne doit etre modifiée
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
				$ligneamodifier=$i;
				$testligneamodifier="true";
			}
		}	

			//test pour voir si une ligne est a modifier

		for ($i=0;$i<$nblignes;$i++){
			if ($_POST['validermodifier'.$i.'_x']){
				$modifier=$i;
				$testmodifier="true";
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
			while ($compteur<pg_numrows($user_studs)){

				$data=pg_fetch_object($user_studs,$compteur);
				//mise a jour des données de l'utilisateur dans la base SQL
				if ($compteur==$modifier){
					pg_query($connect,"update user_studs set reponses='$nouveauchoix' where nom='$data->nom' and id_users='$data->id_users'");
				}
				$compteur++;
			}
		}
	
//recuperation des utilisateurs du sondage
	$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");

// Affichage des balises standards et du titre de la page
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	#bloquer la touche entrée
	print "
	<script language=\"JavaScript\">
		if (document.layers)
		document.captureEvents(Event.KEYPRESS)

		function process_keypress(e) {
			if(window.event){
				if (window.event.type == \"keypress\" & window.event.keyCode == 13)
					return !(window.event.type == \"keypress\" & window.event.keyCode == 13);
				}
			if(e){
				if (e.type == \"keypress\" & e.keyCode == 13)
				return !e;
			}
		}
	document.onkeypress = process_keypress;
	</script>\n";

	echo '</head>'."\n";
	echo '<body>'."\n";

// debut du formulaire et affichage des bandeanx
	echo '<form name="formulaire" action="studs.php?sondage='.$numsondage.'#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
 	bandeau_tete();
	bandeau_titre();
	sous_bandeau_studs();
	echo '<div class="presentationdate"> '."\n";

//affichage du titre du sondage
	echo '<H2>'.utf8_decode($dsondage->titre).'</H2>'."\n";

//affichage du nom de l'auteur du sondage
	echo 'Auteur du sondage : '.utf8_decode($dsondage->nom_admin).'<br><br>'."\n";

//affichage des commentaires du sondage
	if ($dsondage->commentaires){
		echo 'Commentaires :<br>'."\n";
                $commentaires=$dsondage->commentaires;
                $commentaires=str_replace("\\","",$commentaires);       
                echo utf8_decode($commentaires);

		echo '<br>'."\n";
	}
	echo '<br>'."\n";
	echo '</div>'."\n";
	echo '<center><div class="cadre"> '."\n";

	echo 'Pour participer &agrave; ce sondage, veuillez entrer votre nom, choisir toutes les valeurs qui vous conviennent <br>(sans tenir compte des disponibilit&eacute;s des autres sond&eacute;s) et valider votre choix avec <img src="images/add-16.png">.'."\n";

	echo '<br><br>'."\n";


// Debut de l'affichage des resultats du sondage
	echo '<table class="resultats">'."\n";

//reformatage des données des sujets du sondage
	$toutsujet=explode(",",$dsujet->sujet);

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
			echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";
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
			echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";
			$colspan=1;
		}
	}
	echo '</tr>'."\n";

		//affichage des horaires	
	if (eregi("@",$dsujet->sujet)){
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
	
//affichage des resultats actuels
	$somme[]=0;
	$compteur = 0;
	while ($compteur<pg_numrows($user_studs)){

		echo '<tr>'."\n";
		echo '<td class="nom">';

		$data=pg_fetch_object($user_studs,$compteur);
// Le nom de l'utilisateur
		$nombase=str_replace("°","'",$data->nom);
		echo $nombase.'</td>'."\n";
// Les réponses qu'il a choisit
		$ensemblereponses=$data->reponses;

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
							
						$car=substr($ensemblereponses,$j,1);
						if ($car=="1"){
							echo '<td class="vide"><input type="checkbox" name="choix'.$j.'" value="" checked></td>'."\n";
						}
						else {
							echo '<td class="vide"><input type="checkbox" name="choix'.$j.'" value=""></td>'."\n";
						}
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
			if (!$testligneamodifier=="true"&&($dsondage->format=="A+"||$dsondage->format=="D+")){
				echo '<td class=casevide><input type="image" name="modifierligne'.$compteur.'" value="Modifier" src="images/info.png" width="16" height="16" border="0"></td>'."\n";
			}
			
			//demande de confirmation pour modification de ligne
			for ($i=0;$i<$nblignes;$i++){
				if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
					if ($compteur==$i){
						echo '<td class=casevide><input type="image" name="validermodifier'.$compteur.'" value="Valider la modification" src="images/accept.png" ></td>'."\n";
					}
				}
			}
			$compteur++;
			echo '</td>'."\n";
			echo '</tr>'."\n";
	}
	
// affichage de la ligne pour un nouvel utilisateur
	echo '<tr>'."\n";
	echo '<td class=nom>'."\n";
	echo '<input type=text name="nom">'."\n";
	echo '</td>'."\n";

// affichage des cases de formulaire checkbox pour un nouveau choix
	for ($i=0;$i<$nbcolonnes;$i++){
		echo '<td class="vide"><input type="checkbox" name="choix'.$i.'" value=""></td>'."\n";
	}
	// Affichage du bouton de formulaire pour inscrire un nouvel utilisateur dans la base
	echo '<td><input type="image" name="boutonp" value="Participer" src="images/add-24.png"></td>'."\n";
	echo '</tr>'."\n";

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
	echo '<td align="right">Somme</td>'."\n";

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
			echo '<td class="somme"><img src="images/medaille.png"></td>'."\n";
		}
		else {
			echo '<td class="somme"></td>'."\n";
		}

		}
	echo '</tr>'."\n";

	echo '</CENTER>'."\n";
	echo '</div>'."\n";
	echo '</table>'."\n";

// Focus javascript sur la case de texte du formulaire
	echo '<script type="text/javascript">'."\n";
	echo 'document.formulaire.nom.focus();'."\n";
	echo '</script>'."\n";

// reformatage des données de la base pour les sujets
	$toutsujet=explode(",",$dsujet->sujet);
	$toutsujet=str_replace("°","'",$toutsujet);

// On compare le nombre de résultat avec le meilleur et si le résultat est égal
//  on concatene le resultat dans $meilleursujet

	$compteursujet=0;
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($somme[$i]==$meilleurecolonne){
			$meilleursujet.=", ";
			  	if ($dsondage->format=="D"||$dsondage->format=="D+"){
					$meilleursujetexport=$toutsujet[$i];
					if (eregi("@",$toutsujet[$i])){
						$toutsujetdate=explode("@",$toutsujet[$i]);
						$meilleursujet.=strftime("%A %e %B %Y",$toutsujetdate[0])." &agrave ".$toutsujetdate[1];
					}
					else{
						$meilleursujet.=strftime("%A %e %B %Y",$toutsujet[$i]);
					}
				}
				else{
					$meilleursujet.=$toutsujet[$i];
				}
			$compteursujet++;
		}
	}
	$meilleursujet=substr("$meilleursujet",1);

	// Si le résultat est supérieur à 1 on rajoute un S
	if ($meilleurecolonne!="1"){$pluriel="s";}
	
	// Affichage du meilleur choix
	if ($compteursujet=="1"&&$meilleurecolonne){
			print "<BR><center><img src=\"images/medaille.png\"> Le meilleur choix pour l'instant est : <b>$meilleursujet </b>avec <b>$meilleurecolonne </b>vote$pluriel.\n";
  		if ($dsondage->format=="D"||$dsondage->format=="D+"){
  			echo ' (Export iCal :<input type="image" name="exportics" value="Export en iCal" src="images/ical.png">)';
  			$_SESSION["meilleursujet"]=$meilleursujetexport;
  			$_SESSION["numsondage"]=$numsondage;
  			$_SESSION["sondagetitre"]=$dsondage->titre;
  		}
		echo '</center>'."\n";
	}
	elseif ($meilleurecolonne){
		print "<BR><center><img src=\"images/medaille.png\"> Les meilleurs choix pour l'instant sont : <b>$meilleursujet </b>avec <b>$meilleurecolonne </b>vote$pluriel.</center>\n";
	}

	pg_close($connect);

	
	echo '<tr>'."\n";
	echo '<td><br></td>'."\n";
	echo '</tr>'."\n";
	echo '<tr>'."\n";
	// S'il a oublié de remplir un nom
	if ($_POST["boutonp_x"]&&$_POST["nom"]=="") {
			print "<td class=casevide colspan=2><font color=#FF0000>&nbsp;Vous n'avez pas saisi de nom !<br></font></td>\n";
		}
	if ($erreur_prénom){
			print "<td class=casevide colspan=3><font color=#FF0000>&nbsp;Le nom que vous avez choisi existe d&eacute;j&agrave; !<br></font></td>\n";
	}
	if ($erreur_injection){
			print "<td  class=casevide colspan=3><font color=#FF0000>&nbsp;Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !<br></font></td>\n";
	}
	echo '</tr>'."\n";

	echo '<br>'."\n";
	echo '<a name=bas></a>'."\n";
	echo '</div>'."\n";
	echo '</table>'."\n";
	bandeau_pied_mobile();
	// Affichage du bandeau de pied

	echo '</body>'."\n";
	echo '</html>'."\n";
}
?>