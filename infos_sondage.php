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
include 'fonctions.php';
if (file_exists('bandeaux_local.php'))
	include 'bandeaux_local.php';
else
	include 'bandeaux.php';


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

#tests
if (($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	$_SESSION["titre"]=$_POST["titre"];
	$_SESSION["nom"]=$_POST["nom"];
	$_SESSION["adresse"]=$_POST["adresse"];
	$_SESSION["commentaires"]=$_POST["commentaires"];
	if ($_POST["studsplus"]){$_SESSION["studsplus"]="+";}
	else {unset($_SESSION["studsplus"]);}
	
	if ($_POST["mailsonde"]){$_SESSION["mailsonde"]="yes";}
	else {unset($_SESSION["mailsonde"]);}	
	
	if(!eregi ("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{1,4}$",$_POST["adresse"])){
		$erreur_adresse="yes";
	}
	if (ereg("<|>|\"",$_POST["titre"])){
		$erreur_injection_titre="yes";
	}
	if (ereg("<|>|\"",$_POST["nom"])){
		$erreur_injection_nom="yes";
	}
	if (ereg("<|>|\"",$_POST["commentaires"])){
	$erreur_injection_commentaires="yes";
	}
}
#Si pas d'erreur dans l'adresse alors on change de page vers date ou autre
if (($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])&&$_POST["titre"]&&$_POST["nom"]&&$_POST["adresse"]&&!$erreur_adresse&&!$erreur_injection_titre&&!$erreur_injection_commentaires&&!$erreur_injection_nom){
	
	$_SESSION["titre"]=$_POST["titre"];
	$_SESSION["nom"]=$_POST["nom"];
	$_SESSION["adresse"]=$_POST["adresse"];
	$_SESSION["commentaires"]=$_POST["commentaires"];

	if ($_POST["studsplus"]){$_SESSION["studsplus"]="+";}
	else {unset($_SESSION["studsplus"]);}
	if ($_POST["mailsonde"]){$_SESSION["mailsonde"]="yes";}
	else {unset($_SESSION["mailsonde"]);}

	if ($_POST["creation_sondage_date"]||$_POST["creation_sondage_date_x"]){
		header("Location:choix_date.php");
		exit();
	}

	if ($_POST["creation_sondage_autre"]||$_POST["creation_sondage_autre_x"]){
		header("Location:choix_autre.php");
		exit();
	}
}

//bouton annuler
if ($_POST["annuler"]||$_POST["annuler_x"]){
	header("Location:index.php");
	exit();
}

//action si bouton intranet est activé. Entrée dans l'intranet
if ($_POST["intranet"]){

        header("Location:./admin/index.php");
        exit();
}

if ($_POST["contact"]){
        header("Location:contacts.php");
        exit();
}

if ($_POST["sources"]){
        header("Location:sources/sources.php");
        exit();
}

if ($_POST["exemple"]){
        header("Location:studs.php?sondage=aqg259dth55iuhwm");
        exit();
}

if ($_POST["apropos"]){
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

#bloquer la touche entrée
blocage_touche_entree();

echo '</head>'."\n";
echo '<body>'."\n";


//debut du formulaire
echo '<form name="formulaire" action="infos_sondage.php" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";

//En cas d'erreur, recuperation des variables deja entrées
if (($_POST["titre"]==""||$_POST["adresse"]==""||$_POST["nom"]=="")&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
		$_SESSION["titre"]=$_POST["titre"];
		$_SESSION["nom"]=$_POST["nom"];
		$_SESSION["adresse"]=$_POST["adresse"];
		$_SESSION["commentaires"]=$_POST["commentaires"];
		if ($_POST["studsplus"]){$_SESSION["studsplus"]="+";}
		else {unset($_SESSION["studsplus"]);}
		if ($_POST["mailsonde"]){$_SESSION["mailsonde"]="yes";}
		else {unset($_SESSION["mailsonde"]);}
}

//affichage des bandeaux de tete
logo();
bandeau_tete();
bandeau_titre_infos();
sous_bandeau();
 
echo '<div class=corps>'."\n";
echo '<br>'.$tt_infos_presentation.'<br><br>'."\n";

//Affichage des différents champs textes a remplir
echo '<table>'."\n";

echo '<tr><td>'.$tt_infos_champ_titre.'</td><td><input type="text" name="titre" size="40" maxlength="80" value="'.$_SESSION["titre"].'"></td>'."\n";
if (!$_SESSION["titre"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">$tt_infos_erreur_titre</font></td>"."\n";
}
elseif ($erreur_injection_titre){
		print "<td><font color=\"#FF0000\">$tt_infos_erreur_injection</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<tr><td>'.$tt_infos_champ_commentaires.'</td><td><textarea name="commentaires" rows="7" cols="40">'.$_SESSION["commentaires"].'</textarea></td>'."\n";
if ($erreur_injection_commentaires){
		print "<td><font color=\"#FF0000\">$tt_infos_erreur_injection</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<tr><td>'.$tt_infos_champ_nom.'</td><td>';
if (isset($_SERVER['REMOTE_USER']))
	echo '<input type="hidden" name="nom" size="40" maxlength="40" value="'.$_SESSION["nom"].'">'.$_SESSION["nom"].'</td>'."\n";
else
	echo '<input type="text" name="nom" size="40" maxlength="40" value="'.$_SESSION["nom"].'"></td>'."\n";
if (!$_SESSION["nom"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">$tt_infos_erreur_nom</font></td>"."\n";
}
elseif ($erreur_injection_nom){
		print "<td><font color=\"#FF0000\">$tt_infos_erreur_injection</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<tr><td>'.$tt_infos_champ_adressemail.'</td><td>';
if (isset($_SERVER['REMOTE_USER']))
	echo '<input type="hidden" name="adresse" size="40" maxlength="64" value="'.$_SESSION["adresse"].'">'.$_SESSION["adresse"].'</td>'."\n";
else
	echo '<input type="text" name="adresse" size="40" maxlength="64" value="'.$_SESSION["adresse"].'"></td>'."\n";
if (!$_SESSION["adresse"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">$tt_infos_erreur_adressemail </font></td>"."\n";
}
elseif ($erreur_adresse=="yes"&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">$tt_infos_erreur_mauvaise_adressemail</font></td>"."\n";
}
echo '</tr>'."\n";

echo '</table>'."\n";

//focus javascript sur le premier champ
echo '<script type="text/javascript">'."\n";
echo 'document.formulaire.titre.focus();'."\n";
echo '</script>'."\n";

echo '<br>'.$tt_infos_asterisque.'<br><br>'."\n";

#affichage du cochage par défaut
if (!$_SESSION["studsplus"]&&!$_POST["creation_sondage_date"]&&!$_POST["creation_sondage_autre"]&&!$_POST["creation_sondage_date_x"]&&!$_POST["creation_sondage_autre_x"]){$_SESSION["studsplus"]="+";}

if ($_SESSION["studsplus"]=="+"){$cocheplus="checked";}
echo '<input type=checkbox name=studsplus '.$cocheplus.'>'.$tt_infos_option_modifier.'<br>'."\n";
if ($_SESSION["mailsonde"]=="yes"){$cochemail="checked";}
echo '<input type=checkbox name=mailsonde '.$cochemail.'>'.$tt_infos_option_mailconfirme.'<br>'."\n";

//affichage des boutons pour choisir sondage date ou autre
echo '<br><table >'."\n";
echo '<tr><td>'.$tt_infos_choix_date.'</td><td></td> '."\n";
echo '<td><input type="image" name="creation_sondage_date" value="Trouver une date" src="images/calendar-32.png"></td></tr>'."\n";
echo '<tr><td>'.$tt_infos_choix_autre.'</td><td></td> '."\n";
echo '<td><input type="image" name="creation_sondage_autre" value="Faire un sondage" src="images/chart-32.png"></td></tr>'."\n";
echo '</table>'."\n";
echo '<br><br><br>'."\n";
echo '</div>'."\n";
echo '</form>'."\n";
//bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";
?>
