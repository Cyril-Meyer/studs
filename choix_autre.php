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


//si les variables de session ne sont pas valides, il y a une erreur
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
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> ".getenv('NOMAPPLICATION')."</A>."."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	//bandeau de pied
	bandeau_pied();
	echo '</body>'."\n";
	echo '</html>'."\n";

}
else {

	//partie creation du sondage dans la base SQL
	//On prépare les données pour les inserer dans la base
	if ($_POST["confirmecreation_x"]){ 

	//recuperation des données de champs textes
		for ($i=0;$i<$_SESSION["nbrecases"]+1;$i++){
			if ($_POST["choix"][$i]){
				$toutchoix.=',';
				$toutchoix.=str_replace(","," ",$_POST["choix"][$i]);
			}	
		}

		$toutchoix=str_replace("'","°",$toutchoix);
		$toutchoix=substr("$toutchoix",1);

		$_SESSION["toutchoix"]=$toutchoix;
		
		if ($_POST["champdatefin"]){
			$registredate=explode("/",$_POST["champdatefin"]);
			if (mktime(0,0,0,$registredate[1],$registredate[0],$registredate[2])>time()+250000){
				$_SESSION["champdatefin"]=mktime(0,0,0,$registredate[1],$registredate[0],$registredate[2]);
			}
		}
		else{
			$_SESSION["champdatefin"]=time()+15552000;
		}

		//format du sondage AUTRE
		$_SESSION["formatsondage"]="A".$_SESSION["studsplus"];

 		ajouter_sondage();

	}


	// recuperation des sujets pour sondage AUTRE
	for ($i=0;$i<$_SESSION["nbrecases"];$i++){
		if (!ereg("<|>|\"",$_POST["choix"][$i])){
			$_SESSION["choix$i"]=$_POST["choix"][$i];
		}
		else {$erreur_injection="yes";}
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
	if(!$_SESSION["nbrecases"]){
		$_SESSION["nbrecases"]=10;
	}
	if ($_POST["ajoutcases"]||$_POST["ajoutcases_x"]){
		$_SESSION["nbrecases"]=$_SESSION["nbrecases"]+5;
	}

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


	echo '<form name="formulaire" action="choix_autre.php#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	logo();
	bandeau_tete();
	bandeau_titre_autre();
	sous_bandeau_choix();
	
	echo '<div class=corps>'."\n";
	echo '<br>'.$tt_choixautre_presentation.'<br><br>'."\n";
	echo '<table>'."\n";

	//affichage des cases texte de formulaire
	for ($i=0;$i<$_SESSION["nbrecases"];$i++){
		$j=$i+1;
		echo '<tr><td>'.$tt_choixautre_champchoix.' '.$j.' : </td><td><input type="text" name="choix[]" size="40" maxlength="40" value="'.str_replace("\\","",$_SESSION["choix$i"]).'" id="choix'.$i.'"></td></tr>'."\n";
	}	

	echo '</table>'."\n";

	//focus javascript sur premiere case
	echo '<script type="text/javascript">'."\n";
	echo 'document.formulaire.choix0.focus();'."\n";
	echo '</script>'."\n";

	//ajout de cases supplementaires
	echo '<table><tr>'."\n";
	echo '<td>'.$tt_choixautre_ajoutcases.'</td><td><input type="image" name="ajoutcases" value="Retour" src="images/add-16.png"></td>'."\n";
	echo '</tr></table>'."\n";
	echo'<br>'."\n";

	echo '<table><tr>'."\n";
	echo '<td>'.$tt_choixautre_continuer.'</td><td><input type="image" name="fin_sondage_autre" value="Cr&eacute;er le sondage" src="images/next-32.png"></td>'."\n";
	echo '</tr></table>'."\n";

	//test de remplissage des cases
	for ($i=0;$i<$_SESSION["nbrecases"];$i++){
		if ($_POST["choix"][$i]!=""){$testremplissage="ok";}
	}

	//message d'erreur si aucun champ renseigné
	if ($testremplissage!="ok"&&($_POST["fin_sondage_autre"]||$_POST["fin_sondage_autre_x"])){
		print "<br><font color=\"#FF0000\">$tt_choixautre_erreurvide</font><br><br>"."\n";
		$erreur="yes";
	}

	if ($erreur_injection){
			print "<font color=#FF0000>$tt_choixautre_erreur_injection</font><br><br>\n";
	}
	
	if (($_POST["fin_sondage_autre"]||$_POST["fin_sondage_autre_x"])&&!$erreur&&!$erreur_injection){

		//demande de la date de fin du sondage

		echo '<br>'."\n";
		echo '<div class=presentationdatefin>'."\n";
		echo '<br>'.$tt_choixautre_presentationfin.'<br><br>'."\n";

		echo $tt_choixautre_presentationfindate.' : <input type="text" name="champdatefin" size="10" maxlength="10"> '.$tt_choixautre_presentationfinformat."\n";
		echo '</div>'."\n";
		echo '<div class=presentationdatefin>'."\n";
		echo '<font color=#FF0000>'.$tt_choixautre_presentationenvoimail.'</font>'."\n";
		echo '</div>'."\n";
		echo '<br>'."\n";

		echo '<table>'."\n";
		echo '<tr><td>'.$tt_choix_creation.'</td><td><input type="image" name="confirmecreation" value="Valider la cr&eacute;ation"i src="images/add.png"></td></tr>'."\n";
		echo '</table>'."\n";
	}


	//fin du formulaire et bandeau de pied
	echo '</form>'."\n";
	echo '<a name=bas></a>'."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	//bandeau de pied
	sur_bandeau_pied_mobile();
	bandeau_pied_mobile();

	echo '</body>'."\n";
	echo '</html>'."\n";

}

?>
