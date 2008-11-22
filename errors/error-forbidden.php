<?php

include '../bandeaux.php';

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>Erreur STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";
bandeau_tete();
echo '<div class=corpscentre>'."\n";
print "<H2>Vous n'avez pas l'autorisation de voir ce r&eacute;pertoire.<br> </H2>Vous devez, pour cela, initier votre connexion depuis une machine de l'Universit&eacute;.<br> Si vous avez un compte &agrave; l'Universit&eacute;, vous pouvez &eacute;galement utiliser le <a href=\"https://www-crc.u-strasbg.fr/osiris/services/vpn\" target=_new>VPN s&eacute;curis&eacute;</a>.<br><br>"."\n";
print "Vous pouvez retourner &agrave; la page d'accueil de <a href=\"../index.php\"> STUdS</A>."."\n";
echo '</div>'."\n";


// Affichage du bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";

?>
