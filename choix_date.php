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

include 'creation_sondage.php';
if (file_exists('bandeaux_local.php'))
	include 'bandeaux_local.php';
else
	include 'bandeaux.php';


//Choix de langue
if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}


//si les variables de session ne snot pas valides, il y a une erreur
if (!$_SESSION["nom"]&&!$_SESSION["adresse"]&&!$_SESSION["commentaires"]&&!$_SESSION["mail"]){

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'."\n";
	echo '<title>'.getenv('NOMAPPLICATION').'</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	logo();
	bandeau_tete();
	bandeau_titre_erreur();
	echo '<div class=corpscentre>'."\n";
	print "<H2>$tt_choix_page_erreur_titre !</H2>"."\n";
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>. "."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	//bandeau de pied
	//sur_bandeau_pied();
	bandeau_pied();

	echo '</body>'."\n";
	echo '</html>'."\n";

}

//sinon on peut afficher le calendrier normalement
else {

//partie creation du sondage dans la base SQL
//On prépare les données pour les inserer dans la base
if ($_POST["confirmation"]||$_POST["confirmation_x"]){
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		if ($_SESSION["horaires$i"][0]==""&&$_SESSION["horaires$i"][1]==""&&$_SESSION["horaires$i"][2]==""&&$_SESSION["horaires$i"][3]==""&&$_SESSION["horaires$i"][4]==""){
					$choixdate.=",";
					$choixdate.=$_SESSION["totalchoixjour"][$i];
		}
		else{
			for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
				if ($_SESSION["horaires$i"][$j]!=""){
					$choixdate.=",";
					$choixdate.=$_SESSION["totalchoixjour"][$i];
					$choixdate.="@";
					$choixdate.=$_SESSION["horaires$i"][$j];
				}
			}
		}
	}
	$_SESSION["toutchoix"]=substr("$choixdate",1);

	ajouter_sondage();

}

//bouton annuler
if ($_POST["annuler"]||$_POST["annuler_x"]){
	header("Location:index.php");
	exit();
}

//bouton retour
if ($_POST["retour"]||$_POST["retour_x"]){
	header("Location:infos_sondage.php");
	exit();
}

//nombre de cases par défaut
if(!$_SESSION["nbrecaseshoraires"]){
	$_SESSION["nbrecaseshoraires"]=5;
}
if (($_POST["ajoutcases"]||$_POST["ajoutcases_x"])&&$_SESSION["nbrecaseshoraires"]==5){
	$_SESSION["nbrecaseshoraires"]=$_SESSION["nbrecaseshoraires"]+5;
}


//valeurs de la date du jour actuel
$jourAJ=date("j");
$moisAJ=date("n");
$anneeAJ=date("Y");

//mise a jour des valeurs de session si bouton retour a aujourd'hui
if ((!$_POST["anneeavant_x"]&&!$_POST["anneeapres_x"]&&!$_POST["moisavant_x"]&&!$_POST["moisapres_x"]&&!$_POST["choixjourajout"])&&!$_POST["choixjourretrait"]||($_POST["retourmois"]||$_POST["retourmois_x"])){
	$_SESSION["jour"]=date("j");
	$_SESSION["mois"]=date("n");
	$_SESSION["annee"]=date("Y");
}

//mise a jour des valeurs de session si mois avant
if ($_POST["moisavant"]||$_POST["moisavant_x"]){
	if ($_SESSION["mois"]==1){
		$_SESSION["mois"]=12;
		$_SESSION["annee"]=$_SESSION["annee"]-1;
	}
	else {
		$_SESSION["mois"]=$_SESSION["mois"]-1;
	}

	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}
}

//mise a jour des valeurs de session si mois apres
if ($_POST["moisapres"]||$_POST["moisapres_x"]){
	if ($_SESSION["mois"]==12){
		$_SESSION["mois"]=1;
		$_SESSION["annee"]=$_SESSION["annee"]+1;
	}
	else {
		$_SESSION["mois"]=$_SESSION["mois"]+1;
	}

	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}

}

//mise a jour des valeurs de session si annee avant
if ($_POST["anneeavant"]||$_POST["anneeavant_x"]){
		$_SESSION["annee"]=$_SESSION["annee"]-1;

	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}
}

//mise a jour des valeurs de session si annee apres
if ($_POST["anneeapres"]||$_POST["anneeapres_x"]){
		$_SESSION["annee"]=$_SESSION["annee"]+1;

	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}
}

//valeurs du nombre de jour dans le mois et du premier jour du mois
$nbrejourmois=date("t",mktime(0,0,0,$_SESSION["mois"],1,$_SESSION["annee"]));
$premierjourmois=date("N",mktime(0,0,0,$_SESSION["mois"],1,$_SESSION["annee"]))-1;

//le format du sondage est DATE
$_SESSION["formatsondage"]="D".$_SESSION["studsplus"];

//traduction en francais ecrit des valeurs de mois
if ($_SESSION["mois"]==1){$motmois=$tt_motmois_un;}
if ($_SESSION["mois"]==2){$motmois=$tt_motmois_deux;}
if ($_SESSION["mois"]==3){$motmois=$tt_motmois_trois;}
if ($_SESSION["mois"]==4){$motmois=$tt_motmois_quatre;}
if ($_SESSION["mois"]==5){$motmois=$tt_motmois_cinq;}
if ($_SESSION["mois"]==6){$motmois=$tt_motmois_six;}
if ($_SESSION["mois"]==7){$motmois=$tt_motmois_sept;}
if ($_SESSION["mois"]==8){$motmois=$tt_motmois_huit;}
if ($_SESSION["mois"]==9){$motmois=$tt_motmois_neuf;}
if ($_SESSION["mois"]==10){$motmois=$tt_motmois_dix;}
if ($_SESSION["mois"]==11){$motmois=$tt_motmois_onze;}
if ($_SESSION["mois"]==12){$motmois=$tt_motmois_douze;}

//debut de la page web
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

//Debut du formulaire et bandeaux de tete
echo '<form name=formulaire action="choix_date.php" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
logo();
bandeau_tete();
bandeau_titre_date();
sous_bandeau_choix();

//affichage de l'aide pour les jours
echo '<div class=bodydate>'."\n";
echo $tt_choixdate_presentation."\n";
echo '</div>'."\n";

//debut du tableau qui affiche le calendrier
echo '<div class=calendrier>'."\n";
echo '<table align=center>'."\n";
echo '<tr><td><input type=image name=anneeavant value="<<" src="images/rewind.png"></td><td><input type=image name=moisavant value="<" src="images/first.png"></td><td width=150px align=center> '.$motmois.' '.$_SESSION["annee"].' </td><td><input type=image name=moisapres value=">" src="images/last.png"></td><td><input type=image name=anneeapres value=">>" src="images/fforward.png"></td><td></td><td></td><td></td><td></td><td></td><td><input type=image name=retourmois value="Aujourd\'hui" src="images/reload.png"></td></tr>'."\n";
echo '</table>'."\n";
echo '<table>'."\n";

echo '<tr>'."\n";

//affichage des jours de la semaine en haut du tableau
echo '<td class=joursemaine>'.$tt_motjour_un.'</td><td class=joursemaine>'.$tt_motjour_deux.'</td><td class=joursemaine>'.$tt_motjour_trois.'</td><td class=joursemaine>'.$tt_motjour_quatre.'</td><td class=joursemaine>'.$tt_motjour_cinq.'</td><td class=jourwe>'.$tt_motjour_six.'</td><td class=jourwe>'.$tt_motjour_sept.'</td>'."\n";
echo '</tr>'."\n";


//ajout d'une entrée dans la variable de session qui contient toutes les dates
if ($_POST["choixjourajout"]){

	if (!$_SESSION["totalchoixjour"]){
		$_SESSION["totalchoixjour"]=array();
	}

// Test pour éviter les doublons dans la variable qui contient toutes les dates
	$journeuf="yes";
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){

		if ($_SESSION["totalchoixjour"][$i]==mktime (0,0,0,$_SESSION["mois"],$_POST["choixjourajout"][0],$_SESSION["annee"])){
			$journeuf="no";
		}
	}

// Si le test est passé, alors on insere la valeur dans la variable de session qui contient les dates
	if ($journeuf=="yes"){
	
		array_push ($_SESSION["totalchoixjour"],mktime (0,0,0,$_SESSION["mois"],$_POST["choixjourajout"][0],$_SESSION["annee"]));
		sort ($_SESSION["totalchoixjour"]);
		$cle=array_search (mktime (0,0,0,$_SESSION["mois"],$_POST["choixjourajout"][0],$_SESSION["annee"]),$_SESSION["totalchoixjour"]);

		
		//On sauvegarde les heures deja entrées
		for ($i=0;$i<$cle;$i++){
			for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
			}
		}
		for ($i=$cle;$i<count($_SESSION["totalchoixjour"]);$i++){
			$k=$i+1;
			for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
				$_SESSION["horaires$k"][$j]=$_POST["horaires$i"][$j];
			}
		}
		unset($_SESSION["horaires$cle"]);
	}
}

//retrait d'une entrée dans la variable de session qui contient toutes les dates
if ($_POST["choixjourretrait"]){

	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}

	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		if ($_SESSION["totalchoixjour"][$i]==mktime(0,0,0,$_SESSION["mois"],$_POST["choixjourretrait"][0],$_SESSION["annee"])){
			for ($j=$i;$j<count($_SESSION["totalchoixjour"]);$j++){
				$k=$j+1;
				$_SESSION["horaires$j"]=$_SESSION["horaires$k"];
			}
			array_splice($_SESSION["totalchoixjour"],$i,1);
		}
	}
}

//report des horaires dans toutes les cases
if ($_POST["reporterhoraires"]){
	$_SESSION["horaires0"]=$_POST["horaires0"];
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		$j=$i+1;
		$_SESSION["horaires$j"]=$_SESSION["horaires$i"];
	}
}

//report des horaires dans toutes les cases
if ($_POST["resethoraires"]){
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		unset ($_SESSION["horaires$i"]);
	}
}

// affichage du calendrier
echo '<tr>'."\n";

for ($i=0;$i<$nbrejourmois+$premierjourmois;$i++){

	$numerojour=$i-$premierjourmois+1;

// On saute a la ligne tous les 7 jours
	if (($i%7)==0&&$i!=0){
		echo '</tr><tr>'."\n";
	}

// On affiche les jours precedants en gris et incliquables
	if ($i<$premierjourmois){
		echo '<td class=avant></td>'."\n";
	}
	else{

		for ($j=0;$j<count($_SESSION["totalchoixjour"]);$j++){
			//affichage des boutons ROUGES
			if (date("j",$_SESSION["totalchoixjour"][$j])==$numerojour&&date("n",$_SESSION["totalchoixjour"][$j])==$_SESSION["mois"]&&date("Y",$_SESSION["totalchoixjour"][$j])==$_SESSION["annee"]){
				echo '<td align=center class=choisi><input type=submit class=boutonOFF name="choixjourretrait[]" value="'.$numerojour.'"></td>'."\n";
				$dejafait=$numerojour;
			}
		}
		//Si pas de bouton ROUGE alors on affiche un bouton VERT ou GRIS avec le numéro du jour dessus
		if ($dejafait!=$numerojour){

			//bouton vert
			if (($numerojour>=$jourAJ&&$_SESSION["mois"]==$moisAJ&&$_SESSION["annee"]==$anneeAJ)||($_SESSION["mois"]>$moisAJ&&$_SESSION["annee"]==$anneeAJ)||$_SESSION["annee"]>$anneeAJ){
				echo '<td align=center class=libre><input type=submit class=boutonON name="choixjourajout[]" value="'.$numerojour.'"></td>'."\n";
			}
			//bouton gris
			else{
				echo '<td class=avant>'.$numerojour.'</td>'."\n";
			}
		}
	}
}

//fin du tableau
echo '</tr>'."\n";
echo '</table>'."\n";
echo '</div>'."\n";

//traitement de l'entrée des heures dans les cases texte
if ($_POST["choixheures"]||$_POST["choixheures_x"]){
	
	//On sauvegarde les heures deja entrées
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
		}
	}	
	//affichage des horaires
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){

		//affichage des 5 cases horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){

			$case=$j+1;

			//si c'est un creneau type 8:00-11:00
			if (ereg("([0-9]{1,2}:[0-9]{2})-([0-9]{1,2}:[0-9]{2})",$_POST["horaires$i"][$j],$creneaux)){
				
				//on recupere les deux parties du ereg qu'on redécoupe autour des ":"
				$debutcreneau=explode(":",$creneaux[1]);
				$fincreneau=explode(":",$creneaux[2]);

					//comparaison des heures de fin et de debut
					//si correctes, on entre les données dans la variables de session
					if ($debutcreneau[0]<24&&$fincreneau[0]<24&&$debutcreneau[1]<60&&$fincreneau[1]<60&&($debutcreneau[0]<$fincreneau[0]||($debutcreneau[0]==$fincreneau[0]&&$debutcreneau[1]<$fincreneau[1]))){
						$_SESSION["horaires$i"][$j]=$creneaux[1].'-'.$creneaux[2];
					}
					//sinon message d'erreur et nettoyage de la case
					else {
						$errheure[$i][$j]="yes";
						$erreur="yes";
					}
			}

			//si c'est un creneau type 8h00-11h00
			elseif (eregi("^([0-9]{1,2}h[0-9]{0,2})-([0-9]{1,2}h[0-9]{0,2})$",$_POST["horaires$i"][$j],$creneaux)){
				
				//on recupere les deux parties du ereg qu'on redécoupe autour des "H"
				$debutcreneau=preg_split("/h/i",$creneaux[1]);
				$fincreneau=preg_split("/h/i",$creneaux[2]);

					//comparaison des heures de fin et de debut
					//si correctes, on entre les données dans la variables de session
					if ($debutcreneau[0]<24&&$fincreneau[0]<24&&$debutcreneau[1]<60&&$fincreneau[1]<60&&($debutcreneau[0]<$fincreneau[0]||($debutcreneau[0]==$fincreneau[0]&&$debutcreneau[1]<$fincreneau[1]))){
						$_SESSION["horaires$i"][$j]=$creneaux[1].'-'.$creneaux[2];
					}
					//sinon message d'erreur et nettoyage de la case
					else {
						$errheure[$i][$j]="yes";
						$erreur="yes";
					}
			}
			//si c'est une heure simple type 8:00
			elseif (ereg("^([0-9]{1,2}):([0-9]{2})$",$_POST["horaires$i"][$j],$heures)){
				//si valeures correctes, on entre les données dans la variables de session
				if ($heures[1]<24&&$heures[2]<60){
					$_SESSION["horaires$i"][$j]=$heures[0];
				}
				//sinon message d'erreur et nettoyage de la case
				else {
					$errheure[$i][$j]="yes";
					$erreur="yes";
				}
			}
			//si c'est une heure encore plus simple type 8h
			elseif (eregi("^([0-9]{1,2})h([0-9]{0,2})$",$_POST["horaires$i"][$j],$heures)){
				//si valeures correctes, on entre les données dans la variables de session
				if ($heures[1]<24&&$heures[2]<60){
					$_SESSION["horaires$i"][$j]=$heures[0];
				}
				//sinon message d'erreur et nettoyage de la case
				else {
					$errheure[$i][$j]="yes";
					$erreur="yes";
				}
			}
			//si c'est un creneau simple type 8-11
			elseif (ereg("^([0-9]{1,2})-([0-9]{1,2})$",$_POST["horaires$i"][$j],$heures)){
				//si valeures correctes, on entre les données dans la variables de session
				if ($heures[1]<$heures[2]&&$heures[1]<24&&$heures[2]<24){
					$_SESSION["horaires$i"][$j]=$heures[0];
				}
				//sinon message d'erreur et nettoyage de la case
				else {
					$errheure[$i][$j]="yes";
					$erreur="yes";
				}
			}

			//si c'est un creneau H type 8h-11h
			elseif (eregi("^([0-9]{1,2})h-([0-9]{1,2})h$",$_POST["horaires$i"][$j],$heures)){
				//si valeures correctes, on entre les données dans la variables de session
				if ($heures[1]<$heures[2]&&$heures[1]<24&&$heures[2]<24){
					$_SESSION["horaires$i"][$j]=$heures[0];
				}
				//sinon message d'erreur et nettoyage de la case
				else {
					$errheure[$i][$j]="yes";
					$erreur="yes";
				}
			}
			
			//Si la case est vide
			elseif ($_POST["horaires$i"][$j]==""){
					unset($_SESSION["horaires$i"][$j]);

			}
			//pour tout autre format, message d'erreur
			else{
				$errheure[$i][$j]="yes";
				$erreur="yes";
				$_SESSION["horaires$i"][$j]=$_POST["horaires$i"][$j];
			}
		}
	}
}
echo '<div class=bodydate>'."\n";

//affichage de tous les jours choisis
if ($_SESSION["totalchoixjour"]&&(!$_POST["choixheures_x"]||$erreur=="yes")){

	//affichage des jours
	echo '<br>'."\n";
	echo '<H2>'.$tt_choixdate_titreheure.' :</H2>'."\n";
	//affichage de l'aide pour les jours
	echo $tt_choixdate_presentationheure.'<br><br>'."\n";
	echo '<table>'."\n";

	echo '<tr>'."\n";
	echo '<td></td>'."\n";
	for ($i=0;$i<$_SESSION["nbrecaseshoraires"];$i++){
		$j=$i+1;
		echo '<td classe=somme>'.$tt_choixdate_titrecolonne.' '.$j.'</center></td>'."\n";
	}
	if ($_SESSION["nbrecaseshoraires"]<10){
		echo '<td classe=somme><input type="image" name="ajoutcases" src="images/add-16.png"></td>'."\n";
	}
	echo '</tr>'."\n";	

	//affichage de la liste des jours choisis
	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		echo '<tr>'."\n";
		if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");echo '<td>'.strftime("%A %e %B %Y",$_SESSION["totalchoixjour"][$i]).' : </td>'."\n";}
		if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");echo '<td>'.strftime("%A %e de %B %Y",$_SESSION["totalchoixjour"][$i]).' : </td>'."\n";}
		if ($_SESSION["langue"]=="EN"){echo '<td>'.date("l, F jS Y",$_SESSION["totalchoixjour"][$i]).' : </td>'."\n";}
		if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de');echo '<td>'.strftime("%A, den %e. %B %Y",$_SESSION["totalchoixjour"][$i]).' : </td>'."\n";}
		$affichageerreurfindeligne="no";
		//affichage des cases d'horaires
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			//si on voit une erreur, le fond de la case est rouge
			if ($errheure[$i][$j]=="yes"){
				echo '<td><input type=text size="10" maxlength="11" name=horaires'.$i.'[] value="'.$_SESSION["horaires$i"][$j].'" style="background-color:#FF6666;"></td>'."\n";
				$affichageerreurfindeligne="yes";
			}
			//sinon la case est vide normalement
			else {
				echo '<td><input type=text size="10" maxlength="11" name=horaires'.$i.'[] value="'.$_SESSION["horaires$i"][$j].'"></td>'."\n";
			}
		}
		if ($affichageerreurfindeligne=="yes"){
			echo '<td><b><font color=#FF0000>'.$tt_choixdate_erreur_format.'</font></b></td>'."\n";	
		}
		echo '</tr>'."\n";
	}
	echo '</table>'."\n";
	
	//affichage des boutons de formulaire pour annuler, effacer les jours ou créer le sondage
	echo '<table>'."\n";
	echo '<tr>'."\n";
	echo '<td><input type=submit name="reset" value="'.$tt_choixdate_bouton_effacer_jours.'"></td><td><input type=submit name="reporterhoraires" value="'.$tt_choixdate_bouton_reporter.'"></td><td><input type=submit name="resethoraires" value="'.$tt_choixdate_bouton_effacer_horaires.'"></td></tr>'."\n";
	echo'<tr><td><br></td></tr>'."\n";
	echo '<tr><td>'.$tt_choixdate_continuer.'</td><td><input type=image name="choixheures" value="'.$tt_choixdate_continuer.'" src="images/next-32.png"></td></tr>'."\n";
	echo '</table>'."\n";
	//si un seul jour et aucunes horaires choisies, : message d'erreur
	if (($_POST["choixheures"]||$_POST["choixheures_x"])&&(count($_SESSION["totalchoixjour"])=="1"&&$_POST["horaires0"][0]==""&&$_POST["horaires0"][1]==""&&$_POST["horaires0"][2]==""&&$_POST["horaires0"][3]==""&&$_POST["horaires0"][4]=="")){
			echo '<table><tr><td colspan=3><font color=#FF0000>'.$tt_choixdate_erreur_choix.'</font><br></td></tr></table>'."\n";
			$erreur="yes";
	}
}
	//s'il n'y a pas d'erreur et que le bouton de creation est activé, on demande confirmation
	if ($erreur!="yes"&&($_POST["choixheures"]||$_POST["choixheures_x"])){
		$taille_tableau=sizeof($_SESSION["totalchoixjour"])-1;
		$jour_arret=$_SESSION["totalchoixjour"][$taille_tableau]+200000;
		if ($_SESSION["langue"]=="FR"){setlocale(LC_TIME, "fr_FR.UTF8");$date_fin=strftime("%A %e %B %Y",$jour_arret);}
		if ($_SESSION["langue"]=="ES"){setlocale(LC_ALL, "es_ES.UTF8");$date_fin=strftime("%A %e de %B %Y",$jour_arret);}
		if ($_SESSION["langue"]=="EN"){$date_fin=date("l, F jS Y",$jour_arret);}
		if ($_SESSION["langue"]=="DE"){setlocale(LC_ALL, "de_DE");$date_fin=strftime("%A, den %e. %B %Y",$jour_arret);}
		echo '<br><div class=presentationdatefin>'.$tt_choixdate_presentationfin.'<br></td></tr><tr><td><br>'.$tt_choixdate_presentationdatefin.' : <b> '.$date_fin.'</b><br><br>'."\n";
		echo '</div>'."\n";
		echo '<div class=presentationdatefin>'."\n";
		echo '<font color=#FF0000>'.$tt_choixautre_presentationenvoimail.'</font>'."\n";
		echo'</div>'."\n";
		// echo'<p class=affichageexport>'."\n";
		// echo 'Pour finir la cr&eacute;ation du sondage, cliquez sur le bouton <img src="images/add-16.png" alt="ajout"> ci-dessous'."\n";
		// echo '</p>'."\n";
		echo '<table>'."\n";
		echo '<tr><td>'.$tt_choixdate_retour_horaires.'</td><td></td><td><input type=image name=retourhoraires src="images/back-32.png"></td></tr>'."\n";
		echo'<tr><td>'.$tt_choix_creation.'</td><td></td><td><input type=image name=confirmation value="Valider la cr&eacute;ation" src="images/add.png"></td></tr>'."\n";
		echo '</table>'."\n";
	}
	echo '</tr>'."\n";
	echo '</table>'."\n";

echo '<a name=bas></a>'."\n";
//fin du formulaire et bandeau de pied
echo '</form>'."\n";
//bandeau de pied
echo '<br><br><br><br>'."\n";

echo '</div>'."\n";
sur_bandeau_pied_mobile();
bandeau_pied_mobile();
echo '</body>'."\n";
echo '</html>'."\n";

//bouton de nettoyage de tous les jours choisis
if ($_POST["reset"]){

	for ($i=0;$i<count($_SESSION["totalchoixjour"]);$i++){
		for ($j=0;$j<$_SESSION["nbrecaseshoraires"];$j++){
			unset($_SESSION["horaires$i"][$j]);
		}
	}

	unset($_SESSION["totalchoixjour"]);
	unset($_SESSION["nbrecaseshoraires"]);
	echo '<meta http-equiv=refresh content="0">';
}

}

?>
