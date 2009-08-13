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

include 'variables.php';
include 'bandeaux.php';

//tests pour la langue
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

//Choix de la langue
if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}

// action du bouton annuler
if ($_POST["annuler"]){
	header("Location:index.php");
	exit();
}


// action du bouton annuler
if ($_POST["envoiquestion"]&&$_POST["nom"]!=""&&$_POST["question"]!=""){

	$message=str_replace("\\","",$_POST["question"]);
	
	//envoi des mails
	mail (getenv('ADRESSEMAILADMIN'), "$tt_contacts_mail_sujet_admin", utf8_decode ("$tt_contacts_mail_corps_admin\n\n$tt_contacts_mail_utilisateur_admin : ").$_POST["nom"].utf8_decode("\n\n$tt_contacts_mail_adresse_admin : $_POST[adresse_mail]\n\n$tt_contacts_mail_message_admin :").$message);
	if ($_POST["adresse_mail"]!=""){
		mail ("$_POST[adresse_mail]", "$tt_contacts_mail_sujet_user", utf8_decode ("$tt_contacts_mail_corps_user :\n\n").$message.utf8_decode(" \n\n$tt_contacts_mail_reponse_user\n\n$tt_studs_mail_merci\nSTUdS !"));
	}

	//affichage de la page de confirmation d'envoi
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<title>STUdS !</title>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	logo();
	bandeau_tete();
	bandeau_titre();
	
	echo '<div class=corpscentre>'."\n";
	print "<H2>$tt_contacts_envoimail_titre</H2><br><br>"."\n";
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> STUdS</A>."."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	
	bandeau_pied();

	session_unset();

}

else {
	$_SESSION["question"]=$_POST["question"];
	$_SESSION["nom"]=$_POST["nom"];
	$_SESSION["adresse_mail"]=$_POST["adresse_mail"];

	//affichage de la page
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>STUdS !</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";

	//debut du formulaire
	echo '<form name=formulaire action="contacts.php" method="POST">'."\n";

	//bandeaux de tete
	logo();
	bandeau_tete();
	bandeau_titre_contact();
	sous_bandeau_light();

	//blablabla
	echo '<div class=corps>'."\n";
	echo $tt_contacts_presentation.'<br><br>'."\n";

	echo $tt_contacts_nom.' :<br>'."\n";
	echo '<input type="text" size="40" maxlength="64" name="nom" value="'.$_SESSION["nom"].'">';

	if ($_POST["envoiquestion"]&&$_SESSION["nom"]==""){
		echo ' <font color="#FF0000">'.$tt_infos_erreur_nom.'</font>';
	}

	echo '<br><br>'."\n";
	echo $tt_contacts_adressemail.' :<br>'."\n";
	echo '<input type="text" size="40" maxlength="64" name="adresse_mail" value="'.$_SESSION["adresse_mail"].'">'."\n";


	echo '<br><br>';

	echo $tt_contacts_question.' :<br>'."\n";
	echo '<textarea name="question" rows="7" cols="40">'.$_SESSION["question"].'</textarea>';

	if ($_POST["envoiquestion"]&&$_SESSION["question"]==""){
		echo ' <font color="#FF0000">&nbsp;Il faut poser une question !</font>';
	}

	echo '<br><br><br>'."\n";
	echo '<table>'."\n";
	echo '<tr><td>'.$tt_contacts_bouton_question.'</td><td><input type="image" name="envoiquestion" value="Envoyer votre question" src="images/next-32.png"></td></tr>'."\n";
	echo '</table>'."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	echo '</form>'."\n";

	//bandeau de pied
	bandeau_pied();

	echo '</body>'."\n";
	echo '</html>'."\n";

}

?>
