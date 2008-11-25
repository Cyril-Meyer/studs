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
	bandeau_titre_version();
	sous_bandeau_light();

	//blablabla
	echo '<div class=corps>'."\n";

	echo '<b>Voila une liste des prochaines am&eacute;liorations de STUdS. </b><br><br>'."\n";
	echo '- Rien pour l\'instant<br><br>'."\n";
	
	echo 'Si quelquechose venait &agrave; vous manquer et ne pas appara&icirc;tre encore dans cette liste, vous pouvez m\'en faire part <a href="contacts.php">ici</a>. <br><br><br>'."\n";

	echo '<b>Voila la liste des derni&egrave;res am&eacute;liorations de STUdS. </b>'."\n";
	
	echo '<p class=textesouligne>Changelog version 0.3 (novembre 2008) : </p>'."\n";
	echo '- Possibilit&eacute; de faire un export CSV pour exploiter le sondage dans un tableur,<br>'."\n";
	echo '- Mise en place d\'un repository Subversion pour les nouvelles versions de STUdS,<br>'."\n";
	echo '- Amélioration de la CSS pour un meilleur affichage,<br>'."\n";
	echo '- Mise en conformit&eacute; de la CSS avec la charte graphique de l\'Universit&eacute; de Strasbourg,<br>'."\n";
	echo '- Modification du code source pour le rendre portable vers une autre machine,<br>'."\n";
	echo '- Mise sous la licence CeCILL-B du code source de STUdS.<br>'."\n";
	
	echo '<p class=textesouligne>Changelog version 0.2 (novembre 2008) : </p>'."\n";
	echo '- Lors de la cr&eacute;ation d\'un sondage DATE, classement des dates par ordre croissant,<br>'."\n";
	echo '- Lors de la cr&eacute;ation d\'un sondage DATE, accepter les horaires au format "8h" ou "8H",<br>'."\n";
	echo '- Lors de la cr&eacute;ation d\'un sondage DATE, possibilit&eacute de copier des horaires entre les dates,<br>'."\n";
	echo '- Lors d\'une modification de ligne, cocher les cases initialement choisies et non pas des cases vides,<br>'."\n";
	echo '- Changement du format d\'affichage des dates pour un formatage type : "Mardi 13/06",<br>'."\n";
	echo '- Meilleure visualisation des choix les plus vot&eacute;s,<br>'."\n";
	echo '- Possibilit&eacute; pour l\'administrateur du sondage de choisir de recevoir un mail d\'alerte &agrave; chaque participation d\'un sond&eacute;,<br>'."\n";
	echo '- Remplacement des boutons de formulaire par des images moins aust&egrave;res,<br>'."\n";
	echo '- Correction de quelques petits bugs d\'affichage,<br>'."\n";
	echo '- Possibilit&eacute; de rajouter des cases suppl&eacute;mentaires lors de la cr&eacute;ation d\'un sondage AUTRE,<br>'."\n";
	echo '- Possibilit&eacute; de rajouter des cases suppl&eacute;mentaires lors de la cr&eacute;ation d\'un sondage DATE.<br>'."\n";
	echo '<br><br>'."\n";
	echo '</div>'."\n";


	//bandeau de pied
	sur_bandeau_pied();
	bandeau_pied();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

?>
