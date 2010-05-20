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


include 'variables.php';
if (file_exists('bandeaux_local.php'))
	include 'bandeaux_local.php';
else
	include 'bandeaux.php';

session_start();


if (!isset($_POST["uk"])&&!isset($_POST["espagne"])&&!isset($_POST["germany"])&&!isset($_POST["france"])&&!isset($_POST["creation_sondage_x"])&&!isset($_POST["intranet"])&&!isset($_POST["contact"])&&!isset($_POST["sources"])&&!isset($_POST["exemple"])&&!isset($_POST["apropos"])){
	session_unset();
}

if (isset($_POST["uk"])){
	$_SESSION["langue"]="EN";
}
if (isset($_POST["germany"])){
	$_SESSION["langue"]="DE";
}
if (isset($_POST["france"])){
	$_SESSION["langue"]="FR";
}
if (isset($_POST["espagne"])){
	$_SESSION["langue"]="ES";
}

if (isset($_SESSION["langue"])==""){
	$_SESSION["langue"]=getenv('LANGUE');
}

if (isset($_SESSION["langue"]) && file_exists('lang/' . strtolower($_SESSION["langue"]) . '.inc'))
  include 'lang/' . strtolower($_SESSION["langue"]) . '.inc';

if (isset($_POST["creation_sondage"])||isset($_POST["creation_sondage_x"])){
	header("Location:infos_sondage.php");
	exit();
}

//action si bouton intranet est activé. Entrée dans l'intranet
if (isset($_POST["intranet"])){
	header("Location:admin/index.php");
	exit();
}

if (isset($_POST["contact"])){
	header("Location:contacts.php");
	exit();
}

if (isset($_POST["sources"])){
	header("Location:sources/sources.php");
	exit();
}

if (isset($_POST["exemple"])){
	header("Location:studs.php?sondage=aqg259dth55iuhwm");
	exit();
}

if (isset($_POST["apropos"])){
	header("Location:apropos.php");
	exit();
}

//affichage de la page
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

//debut du formulaire
echo '<form name=formulaire action="index.php" method="POST">'."\n";

//bandeaux de tete
logo();
bandeau_tete();
bandeau_titre();
sous_bandeau();

echo '<div class=corps>'."\n";

echo '<p><b>'.getenv('NOMAPPLICATION').'<br>'.$tt_index_titre.'</b></p>';
echo '<p>'.$tt_index_presentation.'</p>'."\n".'<br>'."\n";

echo '<table>'."\n";
echo'<tr><td><b>'.$tt_index_bouton.'</b></td><td></td><td><input type="image" name="creation_sondage" value="Faire un sondage" src="images/next-32.png"></td></tr>'."\n";
echo '</table>'."\n";
echo '<br>'."\n";
echo '<br><br>'."\n";
echo '</div>'."\n";
echo '</form>'."\n";
//bandeau de pied
//sur_bandeau_pied();
bandeau_pied();

echo '</body>'."\n";
echo '</html>'."\n";



?>
