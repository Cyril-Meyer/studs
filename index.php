<?php

include 'bandeaux.php';

session_start();
//session_unset();


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

if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}

//action si bouton intranet est activé. Entrée dans l'intranet
if ($_POST["intranet"]){

	header("Location:./admin/index.php");
	exit();
}

if ($_POST["creation_sondage"]||$_POST["creation_sondage_x"]){

	header("Location:infos_sondage.php");
	exit();
}

if ($_POST["contact"]){
	header("Location:contacts.php");
	exit();
}
if ($_POST["versions"]){
	header("Location:versions.php");
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

//affichage de la page
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>Page d\'accueil de STUdS !</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

//debut du formulaire
echo '<form name=formulaire action="index.php" method="POST">'."\n";

//bandeaux de tete
bandeau_tete();
bandeau_titre();
sous_bandeau();

echo '<div class=corps>'."\n";

echo '<p><b>'.$tt_index_titre.'</b></p>';
echo '<p>'.$tt_index_presentation.'</p>'."\n".'<br>'."\n";

echo '<table>'."\n";
echo'<tr><td><b>'.$tt_index_bouton.'</b></td><td></td><td><input type="image" name="creation_sondage" value="Faire un sondage" src="images/next-32.png"></td></tr>'."\n";
echo '</table>'."\n";
echo '<br>'."\n";
echo '<br><br>'."\n";
echo '</div>'."\n";
echo '</form>'."\n";
//bandeau de pied
//sur_bandeau_pied();
bandeau_pied();

echo '</body>'."\n";
echo '</html>'."\n";



?>
