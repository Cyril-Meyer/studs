<?php
session_start();
include 'creation_sondage.php';
include 'bandeaux.php';


//si les variables de session ne sont pas valides, il y a une erreur
if (!$_SESSION["nom"]&&!$_SESSION["adresse"]&&!$_SESSION["commentaires"]&&!$_SESSION["mail"]){

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
	echo '<title>Erreur STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	bandeau_tete();
	bandeau_titre_erreur();
	echo '<div class=corpscentre>'."\n";
	print "<H2>Vous n'avez pas renseign&eacute; la premi&egrave;re page du sondage !</H2>"."\n";
	print "Retournez &agrave; la page d'accueil de <a href=\"index.php\"> STUdS</A>."."\n";
	echo '<br><br>'."\n";
	echo '</div>'."\n";
	//bandeau de pied
	bandeau_pied();
	echo '</body>'."\n";
	echo '</html>'."\n";

}
else {

	//partie creation du sondage dans la base SQL
	//On prépare les données pour les inserer dans la base
	if ($_POST["confirmecreation"]){ 

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
		if (!ereg("<|>",$_POST["choix"][$i])){
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
	echo '<title>STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	#bloquer la touche entrée
	blocage_touche_entree();

	echo '</head>'."\n";
	echo '<body>'."\n";


	echo '<form name="formulaire" action="choix_autre.php#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
	bandeau_tete();
	bandeau_titre_autre();
	sous_bandeau_choix();
	
	echo '<div class=corps>'."\n";
	print "Vous avez cr&eacute;&eacute; un sondage pour d&eacute;terminer un choix entre plusieurs choses."."\n";
	echo '<br><br>Entrez les diff&eacute;rents choix &agrave; proposer au vote:<br><br>'."\n";
	echo '<table>'."\n";

	//affichage des cases texte de formulaire
	for ($i=0;$i<$_SESSION["nbrecases"];$i++){
		$j=$i+1;
		echo '<tr><td>Choix '.$j.' : </td><td><input type="text" name="choix[]" size="40" maxlength="40" value="'.$_SESSION["choix$i"].'" id="choix'.$i.'"></td></tr>'."\n";
	}	

	echo '</table>'."\n";

	//focus javascript sur premiere case
	echo '<script type="text/javascript">'."\n";
	echo 'document.formulaire.choix0.focus();'."\n";
	echo '</script>'."\n";

	//ajout de cases supplementaires
	echo '<table><tr>'."\n";
	echo '<td>Pour ajouter 5 cases suppl&eacute;mentaires</td><td><input type="image" name="ajoutcases" value="Retour" src="images/add-16.png"></td>'."\n";
	echo '</tr></table>'."\n";
	echo'<br>'."\n";

	echo '<table><tr>'."\n";
	echo '<td>Continuer</td><td><input type="image" name="fin_sondage_autre" value="Cr&eacute;er le sondage" src="images/next-32.png"></td>'."\n";
	echo '</tr></table>'."\n";

	//test de remplissage des cases
	for ($i=0;$i<$_SESSION["nbrecases"];$i++){
		if ($_POST["choix"][$i]!=""){$testremplissage="ok";}
	}

	//message d'erreur si aucun champ renseigné
	if ($testremplissage!="ok"&&($_POST["fin_sondage_autre"]||$_POST["fin_sondage_autre_x"])){
		print "<br><font color=\"#FF0000\">Il faut remplir au moins un champ !</font><br><br>"."\n";
		$erreur="yes";
	}

	if ($erreur_injection){
			print "<font color=#FF0000>&nbsp;Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !</font><br><br>\n";
	}
	
	if (($_POST["fin_sondage_autre"]||$_POST["fin_sondage_autre_x"])&&!$erreur&&!$erreur_injection){

		//demande de la date de fin du sondage

		echo '<br>'."\n";
		echo '<div class=presentationdatefin>'."\n";
		echo '<br>Votre sondage sera automatiquement effac&eacute; dans 6 mois.<br> N&eacute;anmoins vous pouvez d&eacute;cider ci-dessous d\'une date plus rapproch&eacute;e pour la destruction de votre sondage.<br><br>'."\n";

		echo 'Date de fin (optionnelle) : <input type="text" name="champdatefin" size="10" maxlength="10"> (format: JJ/MM/AAAA)'."\n";
		echo '</div>'."\n";
		echo '<br>'."\n";

		echo '<table>'."\n";
		echo '<tr><td>Cr&eacute;er le sondage</td><td><input type="image" name="confirmecreation" value="Valider la cr&eacute;ation"i src="images/add.png"></td></tr>'."\n";
		echo '</table>'."\n";
	}


	//fin du formulaire et bandeau de pied
	echo '</form>'."\n";
	echo '<a name=bas></a>'."\n";
		echo '<br><br>'."\n";
	//bandeau de pied
	bandeau_pied_mobile();

	echo '</div>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";

}

?>
