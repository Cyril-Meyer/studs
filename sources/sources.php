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

include '../bandeaux.php';
include '../variables.php';
session_start();

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
if ($_SESSION["langue"]==""){
        $_SESSION["langue"]=getenv('LANGUE');
}


//Choix de la langue
if ($_SESSION["langue"]=="FR"){ include '../lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include '../lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include '../lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include '../lang/es.inc';}

//action des boutons sous bandeaux
if ($_POST["intranet"]){
	header("Location:../admin/index.php");
exit();
}

if ($_POST["contact"]){
        header("Location:../contacts.php");
        exit();
}

if ($_POST["sources"]){
        header("Location:sources.php");
        exit();
}

if ($_POST["exemple"]){
        header("Location:../studs.php?sondage=aqg259dth55iuhwm");
        exit();
}

if ($_POST["apropos"]){
        header("Location:../apropos.php");
        exit();
}
//bouton annuler
if ($_POST["annuler"]||$_POST["annuler_x"]){
        header("Location:../index.php");
        exit();
}



echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
echo '<title>Sources '.getenv('NOMAPPLICATION').'</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<form name=formulaire action="sources.php" method="POST">'."\n";

sous_logo();
bandeau_tete();
bandeau_titre();
sous_bandeau();
echo '<div class=corpscentre>'."\n";
print "<H2>$tt_sources_lien".getenv('NOMAPPLICATION')."</H2><br><br>"."\n";
print "$tt_choix_page_erreur_retour <a href=\"../index.php\">".getenv('NOMAPPLICATION')."</A> "."\n";
echo '<br><br><br>'."\n";
echo '</div>'."\n";

echo '</form>'."\n";

// Affichage du bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";

?>
