<?php

include '../bandeaux.php';
session_start();

//Choix de la langue
if ($_SESSION["langue"]=="FR"){ include '../lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include '../lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include '../lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include '../lang/es.inc';}

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>Sources STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";
logo();
bandeau_tete();
bandeau_titre();
echo '<div class=corpscentre>'."\n";
print "<H2>$tt_sources_lien</H2><br><br>"."\n";
print "$tt_choix_page_erreur_retour<a href=\"../index.php\"> STUdS</A>. "."\n";
echo '<br><br><br>'."\n";
echo '</div>'."\n";


// Affichage du bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";

?>
