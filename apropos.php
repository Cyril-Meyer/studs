<?php
session_start();

include 'variables.php';
include 'bandeaux.php';

// action du bouton annuler
if ($_POST["annuler"]){
        header("Location:index.php");
        exit();
}

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
    echo '<form name=formulaire action="versions.php" method="POST">'."\n";

	//bandeaux de tete
	bandeau_tete();
	bandeau_titre_apropos();
	sous_bandeau_light();

	//blablabla
	echo '<div class=corps>'."\n";

	echo '<b>Technologies utilis&eacute;es</b><br><br>'."\n";
	echo '- <a href="http://www.php.net/">PHP</a> 5.2<br>'."\n";
	echo '- <a href="http://www.postgresql.org/">PostgreSQL</a> 8.0<br>'."\n";
	echo '- <a href="http://www.apache.org/">Apache</a> 2.2<br>'."\n";
	echo '- <a href="http://subversion.tigris.org/">Subversion</a> 1.5<br>'."\n";
	echo '- <a href="http://www.kigkonsult.se/iCalcreator/">iCalcreator</a> 2.4.3<br>'."\n";
	echo '- <a href="http://www.fpdf.org/">FPDF</a> 1.53<br>'."\n";
	echo '- Ic&ocirc;nes : <a href="http://deleket.deviantart.com/">Deleket</a> et <a href="http://dryicons.com">DryIcons</a><br><br>'."\n";
	
	echo '<b>Compatibilit&eacute;s des navigateurs</b><br><br>'."\n";
	echo '- <a href="http://www.mozilla.com/firefox/">Firefox</a> 2.0 <br>'."\n";
	echo '- <a href="http://www.opera.com/">Op&eacute;ra</a> 9 <br>'."\n";
	echo '- <a href="http://www.konqueror.org/">Konqueror</a> 3.5 <br>'."\n";
	echo '- <a href="http://www.jikos.cz/~mikulas/links/">Links</a> 2.2 <br>'."\n";
	echo '- <a href="http://www.apple.com/fr/safari/">Safari</a> 3.1 <br>'."\n";
	echo '- <a href="http://www.mozilla.com/firefox/">IE</a> 7 <br><br>'."\n";

	echo '<b>Validations des pages</b><br><br>'."\n";
	echo '- Toutes les pages de STUdS disposent de la validation HTML 4.01 Strict du W3C. <br>'."\n";
	echo '- La CSS de STUdS dispose de la validation CSS 2.1 du W3C. '."\n";
 	echo '<p>'."\n"; 
	echo '<img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Strict" height="31" width="88"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !">'."\n";
 	echo'</p>'."\n"; 

	echo '<b>Remerciements</b><br><br>'."\n";
	echo '- Pour leurs contributions techniques : Guy, Christophe, Julien et Pierre <br>'."\n";
	echo '- Pour leurs apports innovants : Romaric, Matthieu et Catherine<br>'."\n";
	echo '- Pour leurs am&eacute;liorations ergonomiques : Christine et Olivier <br>'."\n";
	echo '- Pour sa contribution mat&eacute;rielle : le D&eacute;partement d\'informatique de l\'Universit&eacute; de Strasbourg <br><br>'."\n";
	
	echo '</div>'."\n";

	bandeau_pied();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

?>
