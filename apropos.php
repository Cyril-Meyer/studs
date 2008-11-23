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

	echo '<b>Technologies </b><br><br>'."\n";
	echo '- PHP 5.2<br>'."\n";
	echo '- PostgreSQL 8.0<br>'."\n";
	echo '- Subversion 1.5<br><br>'."\n";
	
	echo '<b>Validations</b><br><br>'."\n";
	echo '- Toutes les pages de STUdS disposent de la validation HTML 4.01 Strict. '."\n";
 	echo '<p>'."\n"; 
	echo '<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Strict" height="31" width="88"></a>'."\n";
 	echo'</p>'."\n"; 

	echo '<b>Questions</b><br><br>'."\n";
	echo 'Si vous avez une question &agrave; propos de STUdS, vous pouvez m\'en faire part <a href="contacts.php">ici</a>. <br><br><br>'."\n";	
	echo '</div>'."\n";

	//bandeau de pied
	bandeau_pied();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

?>