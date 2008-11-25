<?php
session_start();

include 'bandeaux.php';
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
//blablabla
print "<p><b>A quoi sert STUdS ?</b></p><p>A faire des sondages pour que vous puissiez trouver une date de r&eacute;union qui convienne &agrave; toutes les personnes concern&eacute;es. <br>Vous pouvez &eacute;galement utiliser STUdS pour d&eacute;terminer &agrave; plusieurs un choix quelconque comme un lieu de RV, un th&egrave;me de r&eacute;union ou la marque de votre prochaine machine &agrave; caf&eacute;.</p>\n";

echo '<br>'."\n";

echo '<table>'."\n";
echo'<tr><td><b>Cr&eacute;er un sondage</b></td><td></td><td><input type="image" name="creation_sondage" value="Faire un sondage" src="images/next-32.png"></td></tr>'."\n";
echo '</table>'."\n";
echo '<br>'."\n";
echo '<br>'."\n";
echo '</div>'."\n";
echo '</form>'."\n";
//bandeau de pied
sur_bandeau_pied();
bandeau_pied();

echo '</body>'."\n";
echo '</html>'."\n";

session_unset();


?>