<?php
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Auteur : Guilhem BORGHESI
//Création : Février 2008
//
//borghesi@unistra.fr
//
//Ce logiciel est régi par la licence CeCILL-B soumise au droit français et
//respectant les principes de diffusion des logiciels libres. Vous pouvez
//utiliser, modifier et/ou redistribuer ce programme sous les conditions
//de la licence CeCILL-B telle que diffusée par le CEA, le CNRS et l'INRIA 
//sur le site "http://www.cecill.info".
//
//Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
//pris connaissance de la licence CeCILL-B, et que vous en avez accepté les
//termes. Vous pouvez trouver une copie de la licence dans le fichier LICENCE.
//
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Author : Guilhem BORGHESI
//Creation : Feb 2008
//
//borghesi@unistra.fr
//
//This software is governed by the CeCILL-B license under French law and
//abiding by the rules of distribution of free software. You can  use, 
//modify and/ or redistribute the software under the terms of the CeCILL-B
//license as circulated by CEA, CNRS and INRIA at the following URL
//"http://www.cecill.info". 
//
//The fact that you are presently reading this means that you have had
//knowledge of the CeCILL-B license and that you accept its terms. You can
//find a copy of this license in the file LICENSE.
//
//==========================================================================

session_start();

include 'variables.php';
include 'bandeaux.php';

//changement de la langue
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

//Choix de la langue
if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}

// action du bouton annuler
if ($_POST["annuler"]){
        header("Location:index.php");
        exit();
}

	//affichage de la page
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	echo '<title>STUdS !</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";

    //debut du formulaire
    echo '<form name=formulaire action="apropos.php" method="POST">'."\n";

	//bandeaux de tete
	logo();
	bandeau_tete();
	bandeau_titre_apropos();
	sous_bandeau_light();

	//blablabla
	echo '<div class=corps>'."\n";

	echo '<b>'.$tt_apropos_techno.'</b><br><br>'."\n";
	echo '- <a href="http://www.php.net/">PHP</a> 5.2<br>'."\n";
	echo '- <a href="http://www.postgresql.org/">PostgreSQL</a> 8.0<br>'."\n";
	echo '- <a href="http://www.apache.org/">Apache</a> 2.2<br>'."\n";
	echo '- <a href="http://subversion.tigris.org/">Subversion</a> 1.5<br>'."\n";
	echo '- <a href="http://www.kigkonsult.se/iCalcreator/">iCalcreator</a> 2.4.3<br>'."\n";
	echo '- <a href="http://www.fpdf.org/">FPDF</a> 1.53<br>'."\n";
	echo '- Ic&ocirc;nes : <a href="http://deleket.deviantart.com/">Deleket</a> et <a href="http://dryicons.com">DryIcons</a><br><br>'."\n";
	
	echo '<b>'.$tt_apropos_compat.'</b><br><br>'."\n";
	echo '- <a href="http://www.mozilla.com/firefox/">Firefox</a> 2.0 <br>'."\n";
	echo '- <a href="http://www.opera.com/">Op&eacute;ra</a> 9 <br>'."\n";
	echo '- <a href="http://www.konqueror.org/">Konqueror</a> 3.5 <br>'."\n";
	echo '- <a href="http://www.jikos.cz/~mikulas/links/">Links</a> 2.2 <br>'."\n";
	echo '- <a href="http://www.apple.com/fr/safari/">Safari</a> 3.1 <br>'."\n";
	echo '- <a href="http://www.mozilla.com/firefox/">IE</a> 7 <br><br>'."\n";

	echo '<b>'.$tt_apropos_validation_titre.'</b><br><br>'."\n";
	echo $tt_apropos_validation."\n";
 	echo '<p>'."\n"; 
	echo '<img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Strict" height="31" width="88"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !">'."\n";
 	echo'</p>'."\n"; 

	echo '<b>'.$tt_apropos_merci_titre.'</b><br><br>'."\n";
	echo  $tt_apropos_merci.'<br><br>'."\n";

	echo '<b>Licence Logicielle de STUdS</b><br><br>'."\n";
	echo 'STUdS est plac&eacute; sous la <a href="http://www.cecill.info/licences.fr.html">licence CeCILL-B</a>.<br><br>'."\n";
	
	echo '<b>Les prochaines am&eacute;liorations de STUdS </b><br><br>'."\n";
	echo '- Passage de STUdS en encodage UTF8,<br>'."\n";
	echo '- Ajout des icones des menus dans toutes les pages et non pas seulement sur la page d\'acceuil,<br>'."\n";
	echo '- Correction d\'un bug lors du rajout d\'une colonne dans l\'interface d\'administration des sondages.<br><br>'."\n";
	
	echo 'Si quelquechose venait &agrave; vous manquer et ne pas appara&icirc;tre encore dans cette liste, vous pouvez m\'en faire part <a href="contacts.php">ici</a>. <br><br><br>'."\n";

	echo '<b>Les derni&egrave;res am&eacute;liorations de STUdS </b>'."\n";

	echo '<p class=textesouligne>Changelog version 0.6 (ao&ucirc;t 2009) : </p>'."\n";
	echo '- Mise sous la licence CeCILL-B du code source de STUdS,<br>'."\n";


	echo '<p class=textesouligne>Changelog version 0.5 (f&eacute;vrier 2009) : </p>'."\n";
	echo '- Traduction de STUdS en anglais, allemand et espagnol,<br>'."\n";
	echo '- Changement de la CSS avec ajout du logo de l\'Universit&eacute; de Strasbourg,<br>'."\n";
	echo '- Possibilité d\'ajouter un commentaire pour les sond&eacute;s.<br>'."\n";
	
	echo '<p class=textesouligne>Changelog version 0.4 (janvier 2009) : </p>'."\n";
	echo '- Possibilit&eacute; de faire un export PDF pour envoyer la lettre de convocation &agrave; la date de r&eacute;union,<br>'."\n";
	echo '- Possibilit&eacute; de rajouter des colonnes dans la partie administration de sondage,<br>'."\n";
	echo '- Correction de bugs d\'affichage avec les caract&egrave;res \' et " .<br>'."\n";

	echo '<p class=textesouligne>Changelog version 0.3 (novembre 2008) : </p>'."\n";
	echo '- Possibilit&eacute; de faire un export CSV pour exploiter le sondage dans un tableur,<br>'."\n";
	echo '- Mise en place d\'un repository Subversion pour partager les nouvelles versions de STUdS,<br>'."\n";
	echo '- Amélioration de la CSS pour un meilleur affichage,<br>'."\n";
	echo '- Modification du code source pour le rendre portable vers une autre machine.<br>'."\n";
	
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
	
	echo '</div>'."\n";
	
	sur_bandeau_pied_mobile();
	bandeau_pied_mobile();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

?>
