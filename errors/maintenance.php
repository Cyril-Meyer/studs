<?php

include '../bandeaux.php';

echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>Maintenance STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";
bandeau_tete();

echo '<div class=corps>'."\n";
print "<center><H2>L'application STUdS est pour l'instant en maintenance.<br> </H2>"."\n";
print "Merci de votre compr&eacute;hension. </center>"."\n";
echo '</div>'."\n";

// Affichage du bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";

?>