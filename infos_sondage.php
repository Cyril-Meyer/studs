<?php
session_start();
include 'bandeaux.php';


#tests
if (($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	$_SESSION["titre"]=utf8_encode($_POST["titre"]);
	$_SESSION["nom"]=utf8_encode($_POST["nom"]);
	$_SESSION["adresse"]=utf8_encode($_POST["adresse"]);
	$_SESSION["commentaires"]=utf8_encode($_POST["commentaires"]);
	if ($_POST["studsplus"]){$_SESSION["studsplus"]="+";}
	else {unset($_SESSION["studsplus"]);}
	
	if ($_POST["mailsonde"]){$_SESSION["mailsonde"]="yes";}
	else {unset($_SESSION["mailsonde"]);}	
	
	if(!eregi ("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{1,4}$",$_POST["adresse"])){
		$erreur_adresse="yes";
	}
	if (ereg("<|>",$_POST["titre"])){
		$erreur_injection_titre="yes";
	}
	if (ereg("<|>",$_POST["nom"])){
		$erreur_injection_nom="yes";
	}
	if (ereg("<|>",$_POST["commentaires"])){
	$erreur_injection_commentaires="yes";
	}
}
#Si pas d'erreur dans l'adresse alors on change de page vers date ou autre
if (($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])&&$_POST["titre"]&&$_POST["nom"]&&$_POST["adresse"]&&!$erreur_adresse&&!$erreur_injection_titre&&!$erreur_injection_commentaires&&!$erreur_injection_nom){
	
	$_SESSION["titre"]=utf8_encode($_POST["titre"]);
	$_SESSION["nom"]=utf8_encode($_POST["nom"]);
	$_SESSION["adresse"]=utf8_encode($_POST["adresse"]);
	$_SESSION["commentaires"]=utf8_encode($_POST["commentaires"]);

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

//affichage de la page

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";

#bloquer la touche entrée
blocage_touche_entree();

echo '</head>'."\n";
echo '<body>'."\n";


//debut du formulaire
echo '<form name="formulaire" action="infos_sondage.php" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";

//En cas d'erreur, recuperation des variables deja entrées
if (($_POST["titre"]==""||$_POST["adresse"]==""||$_POST["nom"]=="")&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
		$_SESSION["titre"]=utf8_encode($_POST["titre"]);
		$_SESSION["nom"]=utf8_encode($_POST["nom"]);
		$_SESSION["adresse"]=utf8_encode($_POST["adresse"]);
		$_SESSION["commentaires"]=utf8_encode($_POST["commentaires"]);
		if ($_POST["studsplus"]){$_SESSION["studsplus"]="+";}
		else {unset($_SESSION["studsplus"]);}
		if ($_POST["mailsonde"]){$_SESSION["mailsonde"]="yes";}
		else {unset($_SESSION["mailsonde"]);}
}

//affichage des bandeaux de tete
bandeau_tete();
bandeau_titre_infos();
sous_bandeau_light();
 
echo '<div class=corps>'."\n";
print "<br>Vous avez choisi de cr&eacute;er un nouveau sondage !<br> Merci de remplir les champs obligatoires."."\n";

//Affichage des différents champs textes a remplir
echo '<table>'."\n";

echo '<br><tr><td>Titre du sondage * : </td><td><input type="text" name="titre" size="40" maxlength="40" value="'.utf8_decode($_SESSION["titre"]).'"></td>'."\n";
if (!$_SESSION["titre"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">Il faut remplir un titre !</font></td>"."\n";
}
elseif ($erreur_injection_titre){
		print "<td><font color=\"#FF0000\">Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<br><tr><td>Commentaires : </td><td><textarea name="commentaires" rows="7" cols="40" maxlength="40">'.utf8_decode($_SESSION["commentaires"]).'</textarea></td>'."\n";
if ($erreur_injection_commentaires){
		print "<td><font color=\"#FF0000\">Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<br><tr><td>Votre nom * : </td><td><input type="text" name="nom" size="40" maxlength="40" value="'.utf8_decode($_SESSION["nom"]).'"></td>'."\n";
if (!$_SESSION["nom"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">Il faut remplir un nom !</font></td>"."\n";
}
elseif ($erreur_injection_nom){
		print "<td><font color=\"#FF0000\">Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !</font></td><br>"."\n";
}
echo '</tr>'."\n";
echo '<tr><td>Votre adresse e-mail * : </td><td><input type="text" name="adresse" size="40" maxlength="64" value="'.utf8_decode($_SESSION["adresse"]).'"></td>'."\n";
if (!$_SESSION["adresse"]&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">Il faut remplir une adresse ! </font></td>"."\n";
}
elseif ($erreur_adresse=="yes"&&($_POST["creation_sondage_date"]||$_POST["creation_sondage_autre"]||$_POST["creation_sondage_date_x"]||$_POST["creation_sondage_autre_x"])){
	print "<td><font color=\"#FF0000\">L'adresse saisie n'est pas correcte !</font> (Il faut une adresse valide pour recevoir le lien vers le sondage)</td>"."\n";
}
echo '</tr>'."\n";

echo '</table>'."\n";

//focus javascript sur le premier champ
echo '<script type="text/javascript">'."\n";
echo 'document.formulaire.titre.focus();'."\n";
echo '</script>'."\n";

echo '<br><font size=-1>Les champs marqu&eacute;s d\'une &eacute;toile * sont obligatoires !</font><br><br>'."\n";

if ($_SESSION["studsplus"]=="+"){$cocheplus="checked";}
echo '<input type=checkbox name=studsplus '.$cocheplus.'> Vous souhaitez que les sond&eacute;s puissent modifier leur ligne eux-m&ecirc;mes.<br>'."\n";
if ($_SESSION["mailsonde"]=="yes"){$cochemail="checked";}
echo '<input type=checkbox name=mailsonde '.$cochemail.'> Vous souhaitez recevoir un mail &agrave; chaque participation d\'un sond&eacute;.<br>'."\n";

//affichage des boutons pour choisir sondage date ou autre
echo '<br><table ><tr>'."\n";
print "<tr><td>Sondage pour choisir une date</td><td></td> "."\n";
echo '<td><input type="image" name="creation_sondage_date" value="Trouver une date" src="images/calendar-32.png"></td></tr>'."\n";
echo '<tr><td>Autre sondage</td><td></td> '."\n";
echo '<td><input type="image" name="creation_sondage_autre" value="Faire un sondage" src="images/chart-32.png"></td></tr>'."\n";
echo '</table>'."\n";

echo '</div>'."\n";
echo '</form>'."\n";
//bandeau de pied
bandeau_pied();
echo '</body>'."\n";
echo '</html>'."\n";
?>