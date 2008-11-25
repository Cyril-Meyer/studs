<?php

include '../bandeaux.php';

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>Sources STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";
bandeau_tete();
echo '<div class=corpscentre>'."\n";
print "<H2>Voila les <a href=\"studs.tar.gz\" target=_new>sources</a> de StUdS.</H2><br><br>"."\n";
print "Vous pouvez retourner &agrave; la page d'accueil de <a href=\"../index.php\"> STUdS</A>. "."\n";
echo '<br><br>'."\n";
echo '</div>'."\n";


// Affichage du bandeau de pied
sur_bandeau_pied();
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";

?>