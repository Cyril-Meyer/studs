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

//setlocale(LC_TIME, "fr_FR");
include 'variables.php';
include 'fonctions.php';
if (file_exists('bandeaux_local.php'))
	include 'bandeaux_local.php';
else
	include 'bandeaux.php';


if ($_POST["uk"]){
	$_SESSION["langue"]="EN";
}

if ($_POST["germany"]){
	$_SESSION["langue"]="DE";
}

if ($_POST["france"]){
	$_SESSION["langue"]="FR";
}
if ($_POST["espagne"]){
	$_SESSION["langue"]="ES";
}

if ($_SESSION["langue"]==""){
	$_SESSION["langue"]=getenv('LANGUE');
}

if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}


// recuperation du numero de sondage admin (24 car.) dans l'URL
$numsondageadmin=$_GET["sondage"];
//on découpe le résultat pour avoir le numéro de sondage (16 car.)
$numsondage=substr($numsondageadmin, 0, 16);

//ouverture de la connection avec la base SQL
$connect=connexion_base();


if (eregi("[a-z0-9]{16}",$numsondage)){

	$sondage=pg_exec($connect, "select * from sondage where id_sondage_admin ilike '$numsondageadmin'");
	$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$numsondage'");
	$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");

}

//verification de l'existence du sondage, s'il n'existe pas on met une page d'erreur
if (!$sondage||pg_numrows($sondage)=="0"){
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
	print "<H2>$tt_studs_erreur_titre</H2><br><br>"."\n";
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>. "."\n";
	echo '<br><br><br><br>'."\n";
	echo '</div>'."\n";
#	sur_bandeau_pied();
	bandeau_pied();
	
	echo'</body>'."\n";
	echo '</html>'."\n";
}

elseif ($_POST["ajoutsujet_x"]||$_POST["ajoutsujet"]){

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	
	//on recupere les données et les sujets du sondage
	$dsujet=pg_fetch_object($sujets,0);
	$dsondage=pg_fetch_object($sondage,0);

	echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	logo();
	bandeau_tete();
	bandeau_titre();
	sous_bandeau();

	echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	
	echo '<div class=corpscentre>'."\n";
	print "<H2>$tt_adminstuds_ajoutcolonne_titre</H2><br><br>"."\n";
	
	if ($dsondage->format=="A"||$dsondage->format=="A+"){
		echo $tt_adminstuds_ajoutcolonne_autre.' :<br> <input type="text" name="nouvellecolonne" size="40"> <input type="image" name="ajoutercolonne" value="Ajouter une colonne" src="images/accept.png" alt="Valider"><br><br>'."\n";
	}
	else{
//ajout d'une date avec creneau horaire 
		echo $tt_adminstuds_ajoutcolonne_date_presentation.'<br><br> '."\n";
		echo $tt_adminstuds_ajoutcolonne_date_invit.' :<br><br>'."\n";
		echo '<select name="nouveaujour"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=1;$i<32;$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.'</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";

		echo '<select name="nouveaumois"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		echo '<OPTION VALUE="1">'.$tt_motmois_un.'</OPTION>'."\n";
		echo '<OPTION VALUE="2">'.$tt_motmois_deux.'</OPTION>'."\n";
		echo '<OPTION VALUE="3">'.$tt_motmois_trois.'</OPTION>'."\n";
		echo '<OPTION VALUE="4">'.$tt_motmois_quatre.'</OPTION>'."\n";
		echo '<OPTION VALUE="5">'.$tt_motmois_cinq.'</OPTION>'."\n";
		echo '<OPTION VALUE="6">'.$tt_motmois_six.'</OPTION>'."\n";
		echo '<OPTION VALUE="7">'.$tt_motmois_sept.'</OPTION>'."\n";
		echo '<OPTION VALUE="8">'.$tt_motmois_huit.'</OPTION>'."\n";
		echo '<OPTION VALUE="9">'.$tt_motmois_neuf.'</OPTION>'."\n";
		echo '<OPTION VALUE="10">'.$tt_motmois_dix.'</OPTION>'."\n";
		echo '<OPTION VALUE="11">'.$tt_motmois_onze.'</OPTION>'."\n";
		echo '<OPTION VALUE="12">'.$tt_motmois_douze.'</OPTION>'."\n";		
		echo '</SELECT>'."\n";

		
		echo '<select name="nouvelleannee"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=date("Y");$i<(date("Y")+5);$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.'</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";
		echo '<br><br>'.$tt_adminstuds_ajoutcolonne_date_heuredebut.' : <br><br>'."\n";
		echo '<select name="nouvelleheuredebut"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=7;$i<22;$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.' H</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";
		echo '<select name="nouvelleminutedebut"> '."\n";
			echo '<OPTION VALUE="vide"></OPTION>'."\n";
			echo '<OPTION VALUE="00">00</OPTION>'."\n";
			echo '<OPTION VALUE="15">15</OPTION>'."\n";
			echo '<OPTION VALUE="30">30</OPTION>'."\n";
			echo '<OPTION VALUE="45">45</OPTION>'."\n";
		echo '</SELECT>'."\n";
		echo '<br><br>'.$tt_adminstuds_ajoutcolonne_date_heurefin.' : <br><br>'."\n";
		echo '<select name="nouvelleheurefin"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=7;$i<22;$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.' H</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";
		echo '<select name="nouvelleminutefin"> '."\n";
			echo '<OPTION VALUE="vide"></OPTION>'."\n";
			echo '<OPTION VALUE="00">00</OPTION>'."\n";
			echo '<OPTION VALUE="15">15</OPTION>'."\n";
			echo '<OPTION VALUE="30">30</OPTION>'."\n";
			echo '<OPTION VALUE="45">45</OPTION>'."\n";
		echo '</SELECT>'."\n";


		echo '<br><br><input type="image" name="retoursondage" value="Retourner au sondage" src="images/cancel.png"> '."\n";
		echo' <input type="image" name="ajoutercolonne" value="Ajouter une colonne" src="images/accept.png" alt="Valider">'."\n";
	
	}

	echo '</form>'."\n";
	echo '<br><br><br><br>'."\n";
	echo '</div>'."\n";

	bandeau_pied();
	
	echo'</body>'."\n";
	echo '</html>'."\n";
	
	}

//s'il existe on affiche la page normale
else {

	//on recupere les données et les sujets du sondage
	$dsujet=pg_fetch_object($sujets,0);
	$dsondage=pg_fetch_object($sondage,0);

	//affichage des boutons d'effacement de colonne et des sujets

	$nbcolonnes=substr_count($dsujet->sujet,',')+1;
	$nblignes=pg_numrows($user_studs);

	//action du bouton d'annulation
	if ($_POST["annuler"]){
		header("Location:index.php");
		exit();
	}

	//action si bouton intranet est activé. Entrée dans l'intranet
	if ($_POST["intranet"]){

        	header("Location:./admin/index.php");
	        exit();
	}

	if ($_POST["contact"]){
        	header("Location:contacts.php");
	        exit();
	}

	if ($_POST["sources"]){
        	header("Location:sources/sources.php");
	        exit();
	}

	if ($_POST["exemple"]){
        	header("Location:studs.php?sondage=aqg259dth55iuhwm");
	        exit();
	}

	if ($_POST["apropos"]){
        	header("Location:apropos.php");
	        exit();
	}

	//si on annule la suppression
	if ($_POST["annulesuppression"]){

	}
	
	if ($_POST["exportpdf_x"]&&$_POST["lieureunion"]){
		$_SESSION["numsondage"]=$numsondage;
		$_SESSION["lieureunion"]=str_replace("\\","",$_SESSION["lieureunion"]);
		$_SESSION["lieureunion"]=$_POST["lieureunion"];
		header("Location:exportpdf.php");
		exit();
	}

	
	//quand on ajoute un commentaire utilisateur
	if ($_POST["ajoutcomment"]||$_POST["ajoutcomment_x"]){
		if ($_POST["comment"]!=""&&$_POST["commentuser"]!=""){
			pg_query($connect,"insert into comments values ('$numsondage','$_POST[comment]','$_POST[commentuser]')");
		}
		else {
			$erreur_commentaire_vide="yes";
		}
	}
	
	
	//si il n'y a pas suppression alors on peut afficher normalement le tableau
	if (!$_POST["confirmesuppression"]){

		//action si le bouton participer est cliqué
		if ($_POST["boutonp"]||$_POST["boutonp_x"]){
			//si on a un nom dans la case texte
			if ($_POST["nom"]){

				for ($i=0;$i<$nbcolonnes;$i++){
					//si la checkbox est cochée alors valeur est egale à 1
					if (isset($_POST["choix$i"])){
						$nouveauchoix.="1";
					}
					//sinon 0
					else {
						$nouveauchoix.="0";
					}
				}

				for ($compteur=0;$compteur<pg_numrows($user_studs);$compteur++){
	
						$user=pg_fetch_object($user_studs,$compteur);

						if ($_POST["nom"]==$user->nom){
							$erreur_prenom="yes";
						}
				}

				if (ereg("<|>|\"|'", $_POST["nom"])){
					$erreur_injection="yes";
				}


				// Ecriture des choix de l'utilisateur dans la base
 				if (!$erreur_prenom&&!$erreur_injection){
					$nom=str_replace("'","°",$_POST["nom"]);
 					pg_query($connect,"insert into user_studs values ('$nom', '$numsondage', '$nouveauchoix')");
				}
			}

		}


		//action quand on ajoute une colonne au format AUTRE
		if ($_POST["ajoutercolonne_x"] && $_POST["nouvellecolonne"]!=""&&($dsondage->format=="A"||$dsondage->format=="A+")){

			$nouveauxsujets=$dsujet->sujet;

			//on rajoute la valeur a la fin de tous les sujets deja entrés
			$nouveauxsujets.=",";
			$nouveauxsujets.=str_replace(","," ",$_POST["nouvellecolonne"]);
			$nouveauxsujets=str_replace("'","°",$nouveauxsujets);

			//mise a jour avec les nouveaux sujets dans la base
			pg_query($connect,"update sujet_studs set sujet = '$nouveauxsujets' where id_sondage = '$numsondage' ");

			//envoi d'un mail pour prévenir l'administrateur du changement
			$adresseadmin=$dsondage->mail_admin;
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "$tt_adminstuds_mail_sujet_ajoutcolonne".getenv('NOMAPPLICATION'), "$tt_adminstuds_mail_corps_ajoutcolonne : \n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n $tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);

		}

		//action quand on ajoute une colonne au format DATE
		if ($_POST["ajoutercolonne_x"] &&($dsondage->format=="D"||$dsondage->format=="D+")){

			$nouveauxsujets=$dsujet->sujet;

			if ($_POST["nouveaujour"]!="vide"&&$_POST["nouveaumois"]!="vide"&&$_POST["nouvelleannee"]!="vide"){
			
				$nouvelledate=mktime(0,0,0,$_POST["nouveaumois"],$_POST["nouveaujour"],$_POST["nouvelleannee"]);
			
				if ($_POST["nouvelleheuredebut"]!="vide"){
			
					$nouvelledate.="@";
					$nouvelledate.=$_POST["nouvelleheuredebut"];
					$nouvelledate.="h";
					
					if ($_POST["nouvelleminutedebut"]!="vide"){
						$nouvelledate.=$_POST["nouvelleminutedebut"];
					}
				}
				if ($_POST["nouvelleheurefin"]!="vide"){
					$nouvelledate.="-";
					$nouvelledate.=$_POST["nouvelleheurefin"];
					$nouvelledate.="h";
					
					if ($_POST["nouvelleminutefin"]!="vide"){
						$nouvelledate.=$_POST["nouvelleminutefin"];
					}
				}
				if($_POST["nouvelleheuredebut"]=="vide"||($_POST["nouvelleheuredebut"]&&$_POST["nouvelleheurefin"]&&(($_POST["nouvelleheuredebut"]<$_POST["nouvelleheurefin"])||(($_POST["nouvelleheuredebut"]==$_POST["nouvelleheurefin"])&&($_POST["nouvelleminutedebut"]<$_POST["nouvelleminutefin"]))))){
				
				}
				else {$erreur_ajout_date="yes";}
				
				//on rajoute la valeur dans les valeurs
				$datesbase=explode(",",$dsujet->sujet);
				$taillebase=sizeof($datesbase);
				
				//recherche de l'endroit de l'insertion de la nouvelle date dans les dates deja entrées dans le tableau
					
						if ($nouvelledate<$datesbase[0]){
							$cleinsertion=0;
						}
						elseif ($nouvelledate>$datesbase[$taillebase-1]){
							$cleinsertion=count($datesbase);
						}
						else{
							for ($i=0;$i<count($datesbase);$i++){
							$j=$i+1;
								 if ($nouvelledate>$datesbase[$i]&&$nouvelledate<$datesbase[$j]){
								 $cleinsertion=$j;
								}
							 }	
						 }
				

				array_splice($datesbase,$cleinsertion,0,$nouvelledate);

				$cle=array_search ($nouvelledate,$datesbase);
				
				for ($i=0;$i<count($datesbase);$i++){
					$dateinsertion.=",";
					$dateinsertion.=$datesbase[$i];
				}
				
				$dateinsertion=substr("$dateinsertion",1);
				
				//mise a jour avec les nouveaux sujets dans la base
				if (!$erreur_ajout_date){
					pg_query($connect,"update sujet_studs set sujet = '$dateinsertion' where id_sondage = '$numsondage' ");
					if ($nouvelledate>$dsondage->date_fin){
						$date_fin=$nouvelledate+200000;
						pg_query($connect,"update sondage set date_fin = '$date_fin' where id_sondage = '$numsondage' ");
					}
				}
				
				//mise a jour des reponses actuelles correspondant au sujet ajouté
				$compteur = 0;
				while ($compteur<pg_numrows($user_studs)){
					
					$data=pg_fetch_object($user_studs,$compteur);
					$ensemblereponses=$data->reponses;
					
					//parcours de toutes les réponses actuelles
					for ($j=0;$j<$nbcolonnes;$j++){
						$car=substr($ensemblereponses,$j,1);
						
						//si les reponses ne concerne pas la colonne ajoutée, on concatene
						if ($j==$cle){
							$newcar.="0";
						}
						$newcar.=$car;
					}
					$compteur++;
					//mise a jour des reponses utilisateurs dans la base
					if (!$erreur_ajout_date){
						pg_query($connect,"update user_studs set reponses='$newcar' where nom='$data->nom' and id_users=$data->id_users");
					}
					$newcar="";
				}
				
				//envoi d'un mail pour prévenir l'administrateur du changement
				$adresseadmin=$dsondage->mail_admin;

				$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
				mail ("$adresseadmin", "$tt_adminstuds_mail_sujet_ajoutcolonne", "$tt_adminstuds_mail_corps_ajoutcolonne : \n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n $tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);
				
			}
			else {$erreur_ajout_date="yes";}
		}
		
		//suppression de ligne dans la base
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["effaceligne$i"]||$_POST['effaceligne'.$i.'_x']){
				$compteur=0;
				while ($compteur<pg_numrows($user_studs)){

					$data=pg_fetch_object($user_studs,$compteur);

					if ($compteur==$i){
 						pg_query($connect,"delete from user_studs where nom = '$data->nom' and id_users = '$data->id_users'");
					}
					$compteur++;
				}
			}
		}

		//suppression d'un commentaire utilisateur

			$comment_user=pg_exec($connect, "select * from comments where id_sondage='$numsondage' order by id_comment");
			for ($i=0;$i<pg_numrows($comment_user);$i++){
				$dcomment=pg_fetch_object($comment_user,$i);
				if ($_POST['suppressioncomment'.$i.'_x']){
					pg_query ($connect,"delete from comments where id_comment = '$dcomment->id_comment'");
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
			if ($_POST["validermodifier$i"]){
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

		//suppression de colonnes dans la base
		for ($i=0;$i<$nbcolonnes;$i++){
			if (($_POST["effacecolonne$i"]||$_POST['effacecolonne'.$i.'_x'])&&$nbcolonnes>1){
	
				$toutsujet=explode(",",$dsujet->sujet);
				$j=0;

				//parcours de tous les sujets actuels
				while ($toutsujet[$j]){
					//si le sujet n'est pas celui qui a été effacé alors on concatene
					if ($i!=$j){
						$nouveauxsujets.=',';
						$nouveauxsujets.=$toutsujet[$j];
					}
					$j++;
				}
				//on enleve la virgule au début
				$nouveauxsujets=substr("$nouveauxsujets",1);

				//nettoyage des reponses actuelles correspondant au sujet effacé
				$compteur = 0;
				while ($compteur<pg_numrows($user_studs)){

					$data=pg_fetch_object($user_studs,$compteur);

					$ensemblereponses=$data->reponses;
	
					//parcours de toutes les réponses actuelles
					for ($j=0;$j<$nbcolonnes;$j++){
						$car=substr($ensemblereponses,$j,1);
						//si les reponses ne concerne pas la colonne effacée, on concatene
						if ($i!=$j){
							$newcar.=$car;
						}
					}
	
					$compteur++;

					//mise a jour des reponses utilisateurs dans la base
					pg_query($connect,"update user_studs set reponses='$newcar' where nom='$data->nom' and id_users=$data->id_users");
					$newcar="";
				}
				//mise a jour des sujets dans la base
				pg_query($connect,"update sujet_studs set sujet = '$nouveauxsujets' where id_sondage = '$numsondage' ");

			}

		}
		//si la valeur du nouveau titre est valide et que le bouton est activé
		if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]!=""){

			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "$tt_adminstuds_mail_sujet_changetitre".getenv('NOMAPPLICATION'), "$tt_adminstuds_mail_corps_changetitre :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin \n\n$tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec le nouveau titre
			$nouveautitre=$_POST["nouveautitre"];
			pg_query($connect,"update sondage set titre = '$nouveautitre' where id_sondage = '$numsondage' ");
		}

		//si le bouton est activé, quelque soit la valeur du champ textarea
		if ($_POST["boutonnouveauxcommentaires"]||$_POST["boutonnouveauxcommentaires_x"]){
			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "$tt_adminstuds_mail_sujet_changecomm".getenv('NOMAPPLICATION'), "$tt_adminstuds_mail_corps_changecomm :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin \n\n$tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec les nouveaux commentaires
			$nouveauxcommentaires=$_POST["nouveauxcommentaires"];
			pg_query($connect,"update sondage set commentaires = '$nouveauxcommentaires' where id_sondage = '$numsondage' ");
		}

		//si la valeur de la nouvelle adresse est valide et que le bouton est activé
		if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]!=""){
			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$_POST[nouvelleadresse]", "$tt_adminstuds_mail_sujet_changemail".getenv('NOMAPPLICATION'), "$tt_adminstuds_mail_corps_changemail :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin\n\n$tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec la nouvelle adresse
			pg_query($connect,"update sondage set  mail_admin= '$_POST[nouvelleadresse]' where id_sondage = '$numsondage' ");

		}

		//recuperation des donnes de la base
		$sondage=pg_exec($connect, "select * from sondage where id_sondage_admin ilike '$numsondageadmin'");
		$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$numsondage'");
		$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");
		//on recupere les données et les sujets du sondage
		$dsujet=pg_fetch_object($sujets,0);
		$dsondage=pg_fetch_object($sondage,0);
	
		$toutsujet=explode(",",$dsujet->sujet);
		$toutsujet=str_replace("@","<br>",$toutsujet);
		$toutsujet=str_replace("°","'",$toutsujet);
		$nbcolonnes=substr_count($dsujet->sujet,',')+1;

/*DEBUT DE L'AFFICHAGE DE LA PAGE HTML*/
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
		echo '<html>'."\n";
		echo '<head>'."\n";
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
		echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
		echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
		
		#bloquer la touche entrée
		blocage_touche_entree();

		echo '</head>'."\n";
		echo '<body>'."\n";

		//debut du formulaire et affichage des bandeaux
		echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
		logo();
		bandeau_tete();
		bandeau_titre();
		sous_bandeau();
	
		echo '<div class="presentationdate"> '."\n";

		//affichage du titre du sondage
		$titre=str_replace("\\","",$dsondage->titre);       
		echo '<H2>'.$titre.'</H2>'."\n";

		//affichage du nom de l'auteur du sondage
		echo $tt_studs_auteur.' : '.$dsondage->nom_admin.'<br>'."\n";

		//affichage des commentaires du sondage
		if ($dsondage->commentaires){
			echo '<br>'.$tt_studs_commentaires.' :<br>'."\n";
            $commentaires=$dsondage->commentaires;
            $commentaires=str_replace("\\","",$commentaires);       
            echo $commentaires;
			echo '<br>'."\n";
		}
		echo '<br>'."\n";

		echo '</div>'."\n";

		echo '<div class="cadre"> '."\n";
		echo $tt_adminstuds_presentation."\n";

		echo '<br><br>'."\n";

		//debut de l'affichage de résultats
		echo '<table class="resultats">'."\n";

	//reformatage des données des sujets du sondage
	$toutsujet=explode(",",$dsujet->sujet);	
		
		echo '<tr>'."\n";
		echo '<td></td>'."\n";
		echo '<td></td>'."\n";

		//boucle pour l'affichage des boutons de suppression de colonne
		for ($i=0;$toutsujet[$i];$i++){
			echo '<td class=somme><input type="image" name="effacecolonne'.$i.'" value="Effacer la colonne" src="images/cancel.png"></td>'."\n";
		}
		echo '</tr>'."\n";
		
//si le sondage est un sondage de date
if ($dsondage->format=="D"||$dsondage->format=="D+"){
	
//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";
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
	echo '<td class="annee"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
	echo '</tr>'."\n";
	echo '<tr>'."\n";	
	echo '<td></td>'."\n";
	echo '<td></td>'."\n";
	//affichage des mois
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])&&strftime("%Y",$toutsujet[$i])==strftime("%Y",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="mois">'.date("F",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, "de_DE");echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			$colspan=1;
		}
	}

	echo '<td class="mois"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
	echo '</tr>'."\n";
	echo '<tr>'."\n";		
	echo '<td></td>'."\n";
	echo '<td></td>'."\n";
		//affichage des jours
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%a %e",$toutsujet[$i])==strftime("%a %e",$toutsujet[$i+1])&&strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="jour">'.date("D jS",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, "de_DE");echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}			
			$colspan=1;
		}
	}
	echo '<td class="jour"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
	echo '</tr>'."\n";
			//affichage des horaires	
	if (eregi("@",$dsujet->sujet)){
		echo '<tr>'."\n";
		echo '<td></td>'."\n";
		echo '<td></td>'."\n";
				
		for ($i=0;$toutsujet[$i];$i++){
			$heures=explode("@",$toutsujet[$i]);
			echo '<td class="heure">'.$heures[1].'</td>'."\n";
		}
		echo '<td class="heure"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
		echo '</tr>'."\n";
	}
	
}

else {
	$toutsujet=str_replace("°","'",$toutsujet);	

//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";
	echo '<td></td>'."\n";

	for ($i=0;$toutsujet[$i];$i++){
	
		echo '<td class="sujet">'.$toutsujet[$i].'</td>'."\n";
	}
	echo '<td class="sujet"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
	echo '</tr>'."\n";

}
		
		
		//affichage des resultats
		$somme[]=0;
		$compteur = 0;
		while ($compteur<pg_numrows($user_studs)){
			//recuperation des données
			$data=pg_fetch_object($user_studs,$compteur);
			$ensemblereponses=$data->reponses;

			echo '<tr>'."\n";
			
       	        echo '<td><input type="image" name="effaceligne'.$compteur.'" value="Effacer" src="images/cancel.png"  alt="Icone efface"></td>'."\n";
  

			//affichage du nom
			$nombase=str_replace("°","'",$data->nom);

			echo '<td class="nom">'.$nombase.'</td>'."\n";

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
                        if (!$testligneamodifier=="true"){
                	        echo '<td class=somme><input type="image" name="modifierligne'.$compteur.'" value="Modifier" src="images/info.png" alt="Icone infos"></td>'."\n";
                        }

                        //demande de confirmation pour modification de ligne
                       for ($i=0;$i<$nblignes;$i++){
				if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
					if ($compteur==$i){
						echo '<td><input type="image" name="validermodifier'.$compteur.'" value="Valider la modification" src="images/accept.png"  alt="Icone valider"></td>'."\n";
					}
				}
			}



			$compteur++;
			echo '</tr>'."\n";

		}

		//affichage de la case vide de texte pour un nouvel utilisateur
		echo '<tr>'."\n";
		echo '<td></td>'."\n";
		echo '<td class=nom>'."\n";
		echo '<input type=text name="nom"><br>'."\n";
		echo '</td>'."\n";

		//une ligne de checkbox pour le choix du nouvel utilisateur
		for ($i=0;$i<$nbcolonnes;$i++){
			echo '<td class="vide"><input type="checkbox" name="choix'.$i.'" value=""></td>'."\n";
		}
		// Affichage du bouton de formulaire pour inscrire un nouvel utilisateur dans la base
		echo '<td><input type="image" name="boutonp" value="Participer" src="images/add-24.png" alt="Ajouter"></td>'."\n";

		echo '</tr>'."\n";

               //determination du meilleur choix
               for ($i=0;$i<$nbcolonnes+1;$i++){
			if ($i=="0"){
				$meilleurecolonne=$somme[$i];
                        }
                        if ($somme[$i]>$meilleurecolonne){
                                $meilleurecolonne=$somme[$i];
                        }
                }

              //affichage de la ligne contenant les sommes de chaque colonne
              echo '<tr>'."\n";
			  echo '<td></td>'."\n";
              echo '<td align="right">'.$tt_studs_somme.'</td>'."\n";

              for ($i=0;$i<$nbcolonnes;$i++){
	              $affichesomme=$somme[$i];
        	      if ($affichesomme==""){$affichesomme="0";}
	              if ($somme[$i]==$meilleurecolonne){
        		      echo '<td class="somme">'.$affichesomme.'</td>'."\n";
	              }
        	      else {
		              echo '<td class="somme">'.$affichesomme.'</td>'."\n";
	              }
              }

	       echo '<tr>'."\n";
		   echo '<td></td>'."\n";
               echo '<td class="somme"></td>'."\n";
	               for ($i=0;$i<$nbcolonnes;$i++){
	                       if ($somme[$i]==$meilleurecolonne&&$somme[$i]){
	                               echo '<td class="somme"><img src="images/medaille.png" alt="Meilleur resultat"></td>'."\n";
	                       }
	                       else {
	                               echo '<td class="somme"></td>'."\n";
	                       }
                       }
               echo '</tr>'."\n";


		// S'il a oublié de remplir un nom
		if (($_POST["boutonp"]||$_POST["boutonp_x"])&&$_POST["nom"]=="") {
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>$tt_studs_erreur_nomvide</font>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_prenom){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>$tt_studs_erreur_nomdeja</font></td>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_injection){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>$tt_studs_erreur_injection</font></td>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_ajout_date){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>$tt_adminstuds_erreur_date</font></td>\n";
			echo '</tr>'."\n"; 
		}
		//fin du tableau
		echo '</table>'."\n";
		echo '</div>'."\n";

		//focus en javascript sur le champ texte pour le nom d'utilisateur
		echo '<script type="text/javascript">'."\n";
		echo 'document.formulaire.nom.focus();'."\n";
		echo '</script>'."\n";

		//recuperation des valeurs des sujets et adaptation pour affichage
		$toutsujet=explode(",",$dsujet->sujet);
		
	//recuperation des sujets des meilleures colonnes
	$compteursujet=0;
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($somme[$i]==$meilleurecolonne){
			$meilleursujet.=", ";
			  	if ($dsondage->format=="D"||$dsondage->format=="D+"){
					$meilleursujetexport=$toutsujet[$i];
					if (eregi("@",$toutsujet[$i])){
						$toutsujetdate=explode("@",$toutsujet[$i]);
						if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");$meilleursujet.=strftime("%A %e %B %Y",$toutsujetdate[0])." $tt_studs_a ".$toutsujetdate[1];}
						if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");$meilleursujet.=strftime("%A %e de %B %Y",$toutsujetdate[0])." $tt_studs_a ".$toutsujetdate[1];}
						if ($_SESSION["langue"]=="EN"){$meilleursujet.=date("l, F jS Y",$toutsujetdate[0])." $tt_studs_a ".$toutsujetdate[1];}
						if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, "de_DE");$meilleursujet.=strftime("%A, den %e. %B %Y",$toutsujetdate[0])." $tt_studs_a ".$toutsujetdate[1];}
					}
					else{
						if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");$meilleursujet.=strftime("%A %e %B %Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");$meilleursujet.=strftime("%A %e de %B %Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="EN"){$meilleursujet.=date("l, F jS Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, "de_DE");$meilleursujet.=strftime("%A, den %e. %B %Y",$toutsujet[$i]);}
					}
				}
				else{
					$meilleursujet.=$toutsujet[$i];
				}
			$compteursujet++;
		}
	}

		//adaptation pour affichage des valeurs
		$meilleursujet=substr("$meilleursujet",1);
		$meilleursujet=str_replace("°","'",$meilleursujet);

		//ajout du S si plusieurs votes
		if ($meilleurecolonne!="1"&&($_SESSION["langue"]=="FR"||$_SESSION["langue"]=="EN"||$_SESSION["langue"]=="ES")){$pluriel="s";}
		if ($meilleurecolonne!="1"&&$_SESSION["langue"]=="DE"){$pluriel="n";}

		echo '<p class=affichageresultats>'."\n";
		//affichage de la phrase annoncant le meilleur sujet
		if ($compteursujet=="1"&&$meilleurecolonne){
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\">$tt_studs_meilleurchoix : <b>$meilleursujet </b>$tt_studs_meilleurchoix_avec <b>$meilleurecolonne </b>$tt_studs_meilleurchoix_vote$pluriel.<br>\n";
		}
		elseif ($meilleurecolonne){
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\"> $tt_studs_meilleurchoix_pluriel : <b>$meilleursujet </b>$tt_studs_meilleurchoix_avec <b>$meilleurecolonne </b>$tt_studs_meilleurchoix_vote$pluriel.<br>\n";
		}

		echo '<br><br>'."\n";
		echo '</p>'."\n";
		echo '</form>'."\n";
		echo '<form name="formulaire2" action="adminstuds.php?sondage='.$numsondageadmin.'#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
		//Gestion du sondage
		echo '<div class=titregestionadmin>'.$tt_adminstuds_gestion_titre.' :</div>'."\n";
 		echo '<p class=affichageresultats>'."\n"; 
		echo '<br>'."\n";
	//Changer le titre du sondage
	$adresseadmin=$dsondage->mail_admin;
	echo $tt_adminstuds_gestion_chgttitre.' :<br> <input type="text" name="nouveautitre" size="40" value="'.$titre.'"> <input type="image" name="boutonnouveautitre" value="Changer le titre" src="images/accept.png" alt="Valider"><br><br>'."\n";


	if ($dsondage->format=="D"||$dsondage->format=="D+"){
		echo $tt_adminstuds_gestion_pdf.'<br>';
		echo '<input type="text" name="lieureunion" size="100" value="'.$_SESSION["lieureunion"].'">';
		echo ' <input type="image" name="exportpdf" value="Export en PDF" src="images/accept.png" alt="Export PDF"><br><br>';
			$_SESSION["lieureunion"]=str_replace("\\","",$_SESSION["lieureunion"]);
			$_SESSION["meilleursujet"]=$meilleursujetexport;
	}
		
	if ($_POST["exportpdf_x"]&&!$_POST["lieureunion"]){
		echo '<font color="#FF0000">'.$tt_adminstuds_gestion_erreurpdf.'</font><br><br>'."\n";
	}
	
	//si la valeur du nouveau titre est invalide : message d'erreur
	if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]==""){
		echo '<font color="#FF0000">'.$tt_adminstuds_gestion_erreurtitre.'</font><br><br>'."\n";
	}

	//Changer les commentaires du sondage
	echo  $tt_adminstuds_gestion_commentaires.' :<br> <textarea name="nouveauxcommentaires" rows="7" cols="40">'.$commentaires.'</textarea><br><input type="image" name="boutonnouveauxcommentaires" value="Changer les commentaires" src="images/accept.png" alt="Valider"><br><br>'."\n";


	//Changer l'adresse de l'administrateur
	echo $tt_adminstuds_gestion_adressemail.' :<br> <input type="text" name="nouvelleadresse" size="40" value="'.$dsondage->mail_admin.'"> <input type="image" name="boutonnouvelleadresse" value="Changer votre adresse" src="images/accept.png" alt="Valider"><br>'."\n";

	//si l'adresse est invalide ou le champ vide : message d'erreur
	if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]==""){
		echo '<font color="#FF0000">'.$tt_adminstuds_gestion_erreurmail.'</font><br><br>'."\n";

	}

		//affichage des commentaires des utilisateurs existants
		$comment_user=pg_exec($connect, "select * from comments where id_sondage='$numsondage' order by id_comment");
	if (pg_numrows($comment_user)!=0){

		print "<br><b>$tt_studs_ajoutcommentaires_titre :</b><br>\n";
		for ($i=0;$i<pg_numrows($comment_user);$i++){
			$dcomment=pg_fetch_object($comment_user,$i);
			print "<input type=\"image\" name=\"suppressioncomment$i\" src=\"images/cancel.png\" alt=\"supprimer commentaires\"> $dcomment->usercomment : $dcomment->comment <br>";
		}
		echo '<br>';
	}
	
	if ($erreur_commentaire_vide=="yes"){
		print "<font color=#FF0000>$tt_studs_commentaires_erreurvide</font>";
	}
	
	//affichage de la case permettant de rajouter un commentaire par les utilisateurs
	print "<br>$tt_studs_ajoutcommentaires :<br>\n";
	echo $tt_studs_ajoutcommentaires_nom.' : <input type=text name="commentuser"><br>'."\n";
	echo '<textarea name="comment" rows="2" cols="40"></textarea>'."\n";
	echo '<input type="image" name="ajoutcomment" value="Ajouter un commentaire" src="images/accept.png" alt="Valider"><br>'."\n";
	
	//suppression du sondage
	echo '<br>'."\n";
	echo $tt_adminstuds_gestion_suppressionsondage.' : <input type="image" name="suppressionsondage" value="'.$tt_adminstuds_gestion_bouton_suppressionsondage.'" src="images/cancel.png" alt="Annuler"><br><br>'."\n";
	if ($_POST["suppressionsondage"]){

		echo $tt_adminstuds_gestion_confirmesuppression.' : <input type="submit" name="confirmesuppression" value="'.$tt_adminstuds_gestion_bouton_confirmesuppression.'">'."\n";
		echo '<input type="submit" name="annullesuppression" value="'.$tt_adminstuds_gestion_bouton_annulesuppression.'"><br><br>'."\n";
	}
	echo '<a name=bas></a>'."\n";
	echo '<br><br>'."\n";
	//fin de la partie GESTION et beandeau de pied
	echo '</p>'."\n";
	sur_bandeau_pied_mobile();
	bandeau_pied_mobile();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
}

//action si bouton confirmation de suppression est activé
if ($_POST["confirmesuppression"]){


	//on recupere les données et les sujets du sondage
	$dsujet=pg_fetch_object($sujets,0);
	$dsondage=pg_fetch_object($sondage,0);

	$adresseadmin=$dsondage->mail_admin;

        $nbuser=pg_numrows($user_studs);
        $date=date('H:i:s d/m/Y');

	//on ecrit dans le fichier de logs la suppression du sondage
        $fichier_log=fopen('admin/logs_studs.txt','a');
        fwrite($fichier_log,"[SUPPRESSION] $date\t$dsondage->id_sondage\t$dsondage->format\t$dsondage->nom_admin\t$dsondage->mail_admin\t$nbuser\t$dsujets->sujet\n");
        fclose($fichier_log);

	//envoi du mail a l'administrateur du sondage
	$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
	mail ("$adresseadmin", "$tt_adminstuds_mail_sujet_supprimesondage".getenv('NOMAPPLICATION'), "$tt_adminstuds_mail_corps_supprimesondage :\n\n".get_server_name()."/index.php \n\n$tt_studs_mail_merci\n".getenv('NOMAPPLICATION'),$headers);

	//destruction des données dans la base SQL
	pg_query($connect,"delete from sondage where id_sondage = '$numsondage' ");
	pg_query($connect,"delete from user_studs where id_sondage = '$numsondage' ");
	pg_query($connect,"delete from sujet_studs where id_sondage = '$numsondage' ");
	pg_query($connect,"delete from comments where id_sondage = '$numsondage' ");

	//affichage de l'ecran de confirmation de suppression de sondage
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	logo();
	bandeau_tete();
	bandeau_titre();

	echo '<div class=corpscentre>'."\n";
	print "<H2>$tt_adminstuds_suppression_titre</H2><br><br>";
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>. "."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	sur_bandeau_pied();
	bandeau_pied();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
}

}
?>

