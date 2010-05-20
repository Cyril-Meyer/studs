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

// recuperation du numero de sondage admin (24 car.) dans l'URL
$numsondageadmin=$_GET["sondage"];
//on découpe le résultat pour avoir le numéro de sondage (16 car.)
$numsondage=substr($numsondageadmin, 0, 16);

//ouverture de la connection avec la base SQL
$connect=connexion_base();


if (preg_match(";[\w\d]{16};i",$numsondage)){

	$sondage=$connect->Execute("SELECT * FROM sondage WHERE id_sondage_admin = '$numsondageadmin'");
	$sujets=$connect->Execute("SELECT * FROM sujet_studs WHERE id_sondage='$numsondage'");
	$user_studs=$connect->Execute("SELECT * FROM user_studs WHERE id_sondage='$numsondage' order by id_users");

}

//verification de l'existence du sondage, s'il n'existe pas on met une page d'erreur
if (!$sondage || $sondage->RecordCount() != 1){
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
	print "<H2>" . _("This poll doesn't exist !") . "</H2><br><br>"."\n";
	print "" . _("Back to the homepage of ") . " <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>. "."\n";
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
	$dsujet=$sujets->FetchObject(false);
	$dsondage=$sondage->FetchObject(false);

	echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	logo();
	bandeau_tete();
	bandeau_titre();
	sous_bandeau();

	echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	
	echo '<div class=corpscentre>'."\n";
	print "<H2>" . _("Column's adding") . "</H2><br><br>"."\n";
	
	if ($dsondage->format=="A"||$dsondage->format=="A+"){
		echo _("Add a new column") .' :<br> <input type="text" name="nouvellecolonne" size="40"> <input type="image" name="ajoutercolonne" value="Ajouter une colonne" src="images/accept.png" alt="Valider"><br><br>'."\n";
	}
	else{
//ajout d'une date avec creneau horaire 
		echo _("You can add a new scheduling date to your poll.<br> If you just want to add a new hour to an existant date, put the same date and choose a new hour.") .'<br><br> '."\n";
		echo _("Add a date") .' :<br><br>'."\n";
		echo '<select name="nouveaujour"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=1;$i<32;$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.'</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";

		echo '<select name="nouveaumois"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		echo '<OPTION VALUE="1">'. _("january") .'</OPTION>'."\n";
		echo '<OPTION VALUE="2">'. _("february") .'</OPTION>'."\n";
		echo '<OPTION VALUE="3">'. _("march") .'</OPTION>'."\n";
		echo '<OPTION VALUE="4">'. _("april") .'</OPTION>'."\n";
		echo '<OPTION VALUE="5">'. _("may") .'</OPTION>'."\n";
		echo '<OPTION VALUE="6">'. _("june") .'</OPTION>'."\n";
		echo '<OPTION VALUE="7">'. _("july") .'</OPTION>'."\n";
		echo '<OPTION VALUE="8">'. _("august") .'</OPTION>'."\n";
		echo '<OPTION VALUE="9">'. _("september") .'</OPTION>'."\n";
		echo '<OPTION VALUE="10">'. _("october") .'</OPTION>'."\n";
		echo '<OPTION VALUE="11">'. _("november") .'</OPTION>'."\n";
		echo '<OPTION VALUE="12">'. _("december") .'</OPTION>'."\n";		
		echo '</SELECT>'."\n";

		
		echo '<select name="nouvelleannee"> '."\n";
		echo '<OPTION VALUE="vide"></OPTION>'."\n";
		for ($i=date("Y");$i<(date("Y")+5);$i++){
			echo '<OPTION VALUE="'.$i.'">'.$i.'</OPTION>'."\n";
		}
		echo '</SELECT>'."\n";
		echo '<br><br>'. _("Add a start hour (optional)") .' : <br><br>'."\n";
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
		echo '<br><br>'. _("Add a end hour (optional)") .' : <br><br>'."\n";
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
	$dsujet=$sujets->FetchObject(false);
	$dsondage=$sondage->FetchObject(false);

	//affichage des boutons d'effacement de colonne et des sujets

	$nbcolonnes=substr_count($dsujet->sujet,',')+1;
	$nblignes=$user_studs->RecordCount();

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
			$connect->Execute("INSERT INTO comments VALUES ('$numsondage','$_POST[comment]','$_POST[commentuser]')");
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

				while( $user=$user_studs->FetchNextObject(false)) {
						if ($_POST["nom"]==$user->nom){
							$erreur_prenom="yes";
						}
				}

				if (preg_match(';<|>|"|\';i', $_POST["nom"])){
					$erreur_injection="yes";
				}


				// Ecriture des choix de l'utilisateur dans la base
 				if (!$erreur_prenom&&!$erreur_injection){
					$nom=str_replace("'","°",$_POST["nom"]);
 					$connect->Execute("INSERT INTO user_studs VALUES ('$nom', '$numsondage', '$nouveauchoix')");
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
			$connect->Execute("UPDATE sujet_studs SET sujet = '$nouveauxsujets' WHERE id_sondage = '$numsondage' ");

			//envoi d'un mail pour prévenir l'administrateur du changement
			$adresseadmin=$dsondage->mail_admin;
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "" . _("[ADMINISTRATOR] New column for your poll").getenv('NOMAPPLICATION'), "" . _("You have added a new column in your poll. \nYou can inform the voters of this change with this link") . " : \n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n " . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);

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
					$connect->Execute("UPDATE sujet_studs SET sujet = '$dateinsertion' WHERE id_sondage = '$numsondage' ");
					if ($nouvelledate>$dsondage->date_fin){
						$date_fin=$nouvelledate+200000;
						$connect->Execute("UPDATE sondage SET date_fin = '$date_fin' WHERE id_sondage = '$numsondage' ");
					}
				}
				
				//mise a jour des reponses actuelles correspondant au sujet ajouté
				while ( $data=$user_studs->FetchNextObject(false)) {
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
					//mise a jour des reponses utilisateurs dans la base
					if (!$erreur_ajout_date){
						$connect->Execute("update user_studs set reponses='$newcar' where nom='$data->nom' and id_users=$data->id_users");
					}
					$newcar="";
				}
				
				//envoi d'un mail pour prévenir l'administrateur du changement
				$adresseadmin=$dsondage->mail_admin;

				$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
				mail ("$adresseadmin", "" . _("[ADMINISTRATOR] New column for your poll")., "" . _("You have added a new column in your poll. \nYou can inform the voters of this change with this link") . " : \n\n".get_server_name()."/studs.php?sondage=$numsondage \n\n " . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
				
			}
			else {$erreur_ajout_date="yes";}
		}
		
		//suppression de ligne dans la base
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["effaceligne$i"]||$_POST['effaceligne'.$i.'_x']){
				$compteur=0;
				while ($data=$user_studs->FetchNextObject(false)) {

					if ($compteur==$i){
 						$connect->Execute("delete from user_studs where nom = '$data->nom' and id_users = '$data->id_users'");
					}
					$compteur++;
				}
			}
		}

		//suppression d'un commentaire utilisateur

			$comment_user=$connect->Execute("select * from comments where id_sondage='$numsondage' order by id_comment");
			$i = 0;
			while ($dcomment = $comment_user->FetchNextObject(false)) {
				if ($_POST['suppressioncomment'.$i.'_x']){
					$connect->Execute("delete from comments where id_comment = '$dcomment->id_comment'");
				}
				$i++;
			}
		
		//on teste pour voir si une ligne doit etre modifiée
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
				$ligneamodifier=$i;
				$testligneamodifier="true";
			}
			//test pour voir si une ligne est a modifier
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
			while ( $data=$user_studs->FetchNextObject(false)) {
				//mise a jour des données de l'utilisateur dans la base SQL
				if ($compteur==$modifier){
					$connect->Execute("update user_studs set reponses='$nouveauchoix' where nom='$data->nom' and id_users='$data->id_users'");
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
				while ($data=$user_studs->FetchNextObject(false)) {

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
					$connect->Execute("update user_studs set reponses='$newcar' where nom='$data->nom' and id_users=$data->id_users");
					$newcar="";
				}
				//mise a jour des sujets dans la base
				$connect->Execute("update sujet_studs set sujet = '$nouveauxsujets' where id_sondage = '$numsondage' ");

			}

		}
		//si la valeur du nouveau titre est valide et que le bouton est activé
		if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]!=""){

			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "" . _("[ADMINISTRATOR] New title for your poll"). getenv('NOMAPPLICATION'), 
			      _("You have changed the title of your poll. \nYou can modify this poll with this link") .
			      " :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin \n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec le nouveau titre
			$nouveautitre=$_POST["nouveautitre"];
			$connect->Execute("update sondage set titre = '$nouveautitre' where id_sondage = '$numsondage' ");
		}

		//si le bouton est activé, quelque soit la valeur du champ textarea
		if ($_POST["boutonnouveauxcommentaires"]||$_POST["boutonnouveauxcommentaires_x"]){
			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$adresseadmin", "" . _("[ADMINISTRATOR] New comments for your poll").getenv('NOMAPPLICATION'), "" . _("You have changed the comments of your poll. \nYou can modify this poll with this link") . " :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin \n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec les nouveaux commentaires
			$nouveauxcommentaires=$_POST["nouveauxcommentaires"];
			$connect->Execute("update sondage set commentaires = '$nouveauxcommentaires' where id_sondage = '$numsondage' ");
		}

		//si la valeur de la nouvelle adresse est valide et que le bouton est activé
		if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]!=""){
			//envoi du mail pour prevenir l'admin de sondage
			$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
			mail ("$_POST[nouvelleadresse]", "" . _("[ADMINISTRATOR] New email address for your poll").getenv('NOMAPPLICATION'),
			      _("You have changed your email address in your poll. \nYou can modify this poll with this link") .
			      " :\n\n".get_server_name()."/adminstuds.php?sondage=$numsondageadmin\n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);
			//modification de la base SQL avec la nouvelle adresse
			$connect->Execute("update sondage set  mail_admin= '$_POST[nouvelleadresse]' where id_sondage = '$numsondage' ");

		}

		//recuperation des donnes de la base
		$sondage=$connect->Execute("select * from sondage where id_sondage_admin = '$numsondageadmin'");
		$sujets=$connect->Execute("select * from sujet_studs where id_sondage='$numsondage'");
		$user_studs=$connect->Execute("select * from user_studs where id_sondage='$numsondage' order by id_users");
		//on recupere les données et les sujets du sondage
		$dsujet=$sujets->FetchObject(false);
		$dsondage=$sondage->FetchObject(false);
	
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
		echo _("Initiator of the poll") .' : '.$dsondage->nom_admin.'<br>'."\n";

		//affichage des commentaires du sondage
		if ($dsondage->commentaires){
			echo '<br>'. _("Comments") .' :<br>'."\n";
            $commentaires=$dsondage->commentaires;
            $commentaires=str_replace("\\","",$commentaires);       
            echo $commentaires;
			echo '<br>'."\n";
		}
		echo '<br>'."\n";

		echo '</div>'."\n";

		echo '<div class="cadre"> '."\n";
		echo _("As poll administrator, you can change all the lines of this poll with <img src="images/info.png" alt="infos">.<br> You can, as well, remove a column or a line with <img src="images/cancel.png" alt="Cancel">. <br>You can also add a new column with <img src="images/add-16.png" alt="Add column">.<br> Finally, you can change the informations of this poll like the title, the comments or your email address.") ."\n";

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
			if ($_SESSION["langue"]=="FR"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="mois">'.date("F",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";}
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
			if ($_SESSION["langue"]=="FR"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="ES"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="EN"){echo '<td colspan='.$colspan.' class="jour">'.date("D jS",$toutsujet[$i]).'</td>'."\n";}
			if ($_SESSION["langue"]=="DE"){echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";}			
			$colspan=1;
		}
	}
	echo '<td class="jour"><input type="image" name="ajoutsujet" src="images/add-16.png"  alt="Icone ajout"></td>'."\n";
	echo '</tr>'."\n";
			//affichage des horaires	
	if (strpos('@',$dsujet->sujet) !== false){
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
		while ( $data=$user_studs->FetchNextObject(false)) {
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
              echo '<td align="right">'. _("Addition") .'</td>'."\n";

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
			print "<td colspan=10><font color=#FF0000>" . _("Enter a name !") . "</font>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_prenom){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>" . _("The name you've chosen already exist in this poll!") . "</font></td>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_injection){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>" . _("Characters \"  '  < et > are not permitted") . "</font></td>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_ajout_date){
			echo '<tr>'."\n";
			print "<td colspan=10><font color=#FF0000>" . _("The date is not correct !") . "</font></td>\n";
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
					if (strpos('@',$toutsujet[$i]) !== false){
						$toutsujetdate=explode("@",$toutsujet[$i]);
						if ($_SESSION["langue"]=="FR"){$meilleursujet.=strftime("%A %e %B %Y",$toutsujetdate[0]). ' ' . _("for")  .' ' . $toutsujetdate[1];}
						if ($_SESSION["langue"]=="ES"){$meilleursujet.=strftime("%A %e de %B %Y",$toutsujetdate[0]). ' ' . _("for")  . ' ' . $toutsujetdate[1];}
						if ($_SESSION["langue"]=="EN"){$meilleursujet.=date("l, F jS Y",$toutsujetdate[0])."  _("for")  ".$toutsujetdate[1];}
						if ($_SESSION["langue"]=="DE"){$meilleursujet.=strftime("%A, den %e. %B %Y",$toutsujetdate[0]). ' ' . _("for")  . ' ' . $toutsujetdate[1];}
					}
					else{
						if ($_SESSION["langue"]=="FR"){$meilleursujet.=strftime("%A %e %B %Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="ES"){$meilleursujet.=strftime("%A %e de %B %Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="EN"){$meilleursujet.=date("l, F jS Y",$toutsujet[$i]);}
						if ($_SESSION["langue"]=="DE"){$meilleursujet.=strftime("%A, den %e. %B %Y",$toutsujet[$i]);}
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
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\">" . _("The best choice at this time is") . " : <b>$meilleursujet </b>" . _("with") . " <b>$meilleurecolonne </b>" . _("vote") . "$pluriel.<br>\n";
		}
		elseif ($meilleurecolonne){
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\"> " . _("The bests choices at this time are") . " : <b>$meilleursujet </b>" . _("with") . " <b>$meilleurecolonne </b>" . _("vote") . "$pluriel.<br>\n";
		}

		echo '<br><br>'."\n";
		echo '</p>'."\n";
		echo '</form>'."\n";
		echo '<form name="formulaire2" action="adminstuds.php?sondage='.$numsondageadmin.'#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
		//Gestion du sondage
		echo '<div class=titregestionadmin>'. _("Poll's management") .' :</div>'."\n";
 		echo '<p class=affichageresultats>'."\n"; 
		echo '<br>'."\n";
	//Changer le titre du sondage
	$adresseadmin=$dsondage->mail_admin;
	echo _("Change the title") .' :<br> <input type="text" name="nouveautitre" size="40" value="'.$titre.'"> <input type="image" name="boutonnouveautitre" value="Changer le titre" src="images/accept.png" alt="Valider"><br><br>'."\n";


	if ($dsondage->format=="D"||$dsondage->format=="D+"){
		echo _("Generate the convocation letter (.PDF), choose the place to meet and validate") .'<br>';
		echo '<input type="text" name="lieureunion" size="100" value="'.$_SESSION["lieureunion"].'">';
		echo ' <input type="image" name="exportpdf" value="Export en PDF" src="images/accept.png" alt="Export PDF"><br><br>';
			$_SESSION["lieureunion"]=str_replace("\\","",$_SESSION["lieureunion"]);
			$_SESSION["meilleursujet"]=$meilleursujetexport;
	}
		
	if ($_POST["exportpdf_x"]&&!$_POST["lieureunion"]){
		echo '<font color="#FF0000">'. _("Enter a meeting place!") .'</font><br><br>'."\n";
	}
	
	//si la valeur du nouveau titre est invalide : message d'erreur
	if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]==""){
		echo '<font color="#FF0000">'. _("Enter a new title!") .'</font><br><br>'."\n";
	}

	//Changer les commentaires du sondage
	echo _("Change the comments") .' :<br> <textarea name="nouveauxcommentaires" rows="7" cols="40">'.$commentaires.'</textarea><br><input type="image" name="boutonnouveauxcommentaires" value="Changer les commentaires" src="images/accept.png" alt="Valider"><br><br>'."\n";


	//Changer l'adresse de l'administrateur
	echo _("Change your email address") .' :<br> <input type="text" name="nouvelleadresse" size="40" value="'.$dsondage->mail_admin.'"> <input type="image" name="boutonnouvelleadresse" value="Changer votre adresse" src="images/accept.png" alt="Valider"><br>'."\n";

	//si l'adresse est invalide ou le champ vide : message d'erreur
	if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]==""){
		echo '<font color="#FF0000">'. _("Enter a new email address!") .'</font><br><br>'."\n";

	}

		//affichage des commentaires des utilisateurs existants
	$comment_user=$connect->Execute("select * from comments where id_sondage='$numsondage' order by id_comment");
	if ($comment_user->RecordCount() != 0){

		print "<br><b>" . _("Comments") . " :</b><br>\n";
		$i = 0;
		while ( $dcomment=$comment_user->FetchNextObject(false)) {
			print "<input type=\"image\" name=\"suppressioncomment$i\" src=\"images/cancel.png\" alt=\"supprimer commentaires\"> $dcomment->usercomment : $dcomment->comment <br>";
			$i++;
		}
		echo '<br>';
	}
	
	if ($erreur_commentaire_vide=="yes"){
		print "<font color=#FF0000>" . _("Enter a name and a comment!") . "</font>";
	}
	
	//affichage de la case permettant de rajouter un commentaire par les utilisateurs
	print "<br>" . _("Add a comment in the poll") . " :<br>\n";
	echo _("Name") .' : <input type=text name="commentuser"><br>'."\n";
	echo '<textarea name="comment" rows="2" cols="40"></textarea>'."\n";
	echo '<input type="image" name="ajoutcomment" value="Ajouter un commentaire" src="images/accept.png" alt="Valider"><br>'."\n";
	
	//suppression du sondage
	echo '<br>'."\n";
	echo _("Remove your poll") .' : <input type="image" name="suppressionsondage" value="'. _("Remove the poll") .'" src="images/cancel.png" alt="Annuler"><br><br>'."\n";
	if ($_POST["suppressionsondage"]){

		echo _("Confirm removal of your poll") .' : <input type="submit" name="confirmesuppression" value="'. _("Remove this poll!") .'">'."\n";
		echo '<input type="submit" name="annullesuppression" value="'. _("Keep this poll!") .'"><br><br>'."\n";
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
	$dsujet=$sujets->FetchObject(false);
	$dsondage=$sondage->FetchObject(false);

	$adresseadmin=$dsondage->mail_admin;

        $nbuser=$user_studs->RecordCount();
        $date=date('H:i:s d/m/Y');

	//on ecrit dans le fichier de logs la suppression du sondage
        $fichier_log=fopen('admin/logs_studs.txt','a');
        fwrite($fichier_log,"[SUPPRESSION] $date\t$dsondage->id_sondage\t$dsondage->format\t$dsondage->nom_admin\t$dsondage->mail_admin\t$nbuser\t$dsujets->sujet\n");
        fclose($fichier_log);

	//envoi du mail a l'administrateur du sondage
	$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";
	mail ("$adresseadmin", "" . _("[ADMINISTRATOR] Removing of your poll").getenv('NOMAPPLICATION'), "" . _("You have removed your poll. \nYou can make new polls with this link") . " :\n\n".get_server_name()."/index.php \n\n" . _("Thanks for your confidence.") . "\n".getenv('NOMAPPLICATION'),$headers);

	//destruction des données dans la base SQL
	$connect->Execute('DELETE FROM sondage LEFT INNER JOIN sujet_studs ON sujet_studs.id_sondage = sondage.id_sondage '.
			  'LEFT INNER JOIN user_studs ON user_studs.id_sondage = sondage.id_sondage ' .
			  'LEFT INNER JOIN comments ON comments.id_sondage = sondage.id_sondage ' .
			  "WHERE id_sondage = '$numsondage' ");

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
	print "<H2>" . _("Your poll has been removed!") . "</H2><br><br>";
	print "" . _("Back to the homepage of ") . " <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>. "."\n";
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

