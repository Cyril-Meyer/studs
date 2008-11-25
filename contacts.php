<?php
session_start();

include 'variables.php';
include 'bandeaux.php';

// action du bouton annuler
if ($_POST["annuler"]){
	header("Location:index.php");
	exit();
}


// action du bouton annuler
//if ($_POST["envoiquestion"]&&$_POST["nom"]!=""&&$_POST["question"]!=""&&(($_POST["adresse_mail"]!=""&&isset($_POST["accuse"]))||($_POST["adresse_mail"]==""&&!isset($_POST["accuse"]))||$_POST["adresse_mail"]!="")){
if ($_POST["envoiquestion"]&&$_POST["nom"]!=""&&$_POST["question"]!=""){

	$message=str_replace("\\","",$_POST["question"]);
	
	//envoi des mails
	mail (getenv('ADRESSEMAILADMIN'), "[CONTACT STUdS] Envoi de question STUdS", utf8_decode ("Vous avez une question d'utilisateur de STUdS. \nVoici la question :\n\nUtilisateur : $_POST[nom]\n\nAdresse utilisateur : $_POST[adresse_mail]\n\nMessage : $message "));
	if ($_POST["adresse_mail"]!=""){
		mail ("$_POST[adresse_mail]", "[COPIE] Envoi de question STUdS", utf8_decode ("Vous avez posé une question dans STUdS. \nVoici votre question :\n\n Message : $message \n\nNous allons vous répondre dans les plus brefs délais. \n\nMerci de votre confiance\nSTUdS !"));
	}

	//affichage de la page de confirmation d'envoi
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<title>Envoi STUdS</title>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";

	bandeau_tete();
	bandeau_titre();
	
	echo '<div class=corpscentre>'."\n";
	print "<H2>Votre message a bien &eacute;t&eacute; envoy&eacute; !</H2><br><br>"."\n";
	print "Vous pouvez retourner &agrave; la page d'accueil de <a href=\"index.php\"> STUdS</A>."."\n";
	echo '<br><br>'."\n";
	echo '</div>'."\n";
	sur_bandeau_pied();
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
	echo '<title>STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";

	//debut du formulaire
	echo '<form name=formulaire action="contacts.php" method="POST">'."\n";

	//bandeaux de tete
	bandeau_tete();
	bandeau_titre_contact();
	sous_bandeau_light();

	//blablabla
	echo '<div class=corps>'."\n";
	echo 'Pour toutes questions ou suggestions relatives &agrave; STUdS vous pouvez laisser un message via ce formulaire. <br><br>'."\n";

	echo 'Votre nom :<br>'."\n";
	echo '<input type="text" size="40" maxlength="64" name="nom" value="'.$_SESSION["nom"].'">';

	if ($_POST["envoiquestion"]&&$_SESSION["nom"]==""){
		echo ' <font color="#FF0000">&nbsp;Il faut remplir un nom !</font>';
	}

	echo '<br><br>'."\n";
	echo 'Votre adresse (facultative) :<br>'."\n";
	echo '<input type="text" size="40" maxlength="64" name="adresse_mail" value="'.$_SESSION["adresse_mail"].'">'."\n";


	echo '<br><br>';

	echo 'Question :<br>'."\n";
	echo '<textarea name="question" rows="7" cols="40">'.$_SESSION["question"].'</textarea>';

	if ($_POST["envoiquestion"]&&$_SESSION["question"]==""){
		echo ' <font color="#FF0000">&nbsp;Il faut poser une question !</font>';
	}

	echo '<br><br>'."\n";
	echo '<table>'."\n";
	echo '<tr><td>Envoyer votre question</td><td><input type="image" name="envoiquestion" value="Envoyer votre question" src="images/next-32.png"></td></tr>'."\n";
	echo '</table>'."\n";
	echo '<br><br>'."\n";
	echo '</div>'."\n";
	echo '</form>'."\n";

	//bandeau de pied
	sur_bandeau_pied();
	bandeau_pied();

	echo '</body>'."\n";
	echo '</html>'."\n";

}

?>
