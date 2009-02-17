<?php
session_start();
include 'creation_sondage.php';
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
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>STUdS !</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	logo();
	bandeau_tete();
	bandeau_titre_erreur();
	echo '<div class=corpscentre>'."\n";
	print "<H2>$tt_choix_page_erreur_titre !</H2>"."\n";
	print "$tt_choix_page_erreur_retour <a href=\"index.php\"> STUdS</A>."."\n";
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
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>STUdS !</title>'."\n";
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
