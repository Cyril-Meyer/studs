<?php
setlocale(LC_TIME, "fr_FR");
include 'variables.php';
include 'fonctions.php';
include 'bandeaux.php';

// recuperation du numero de sondage admin (24 car.) dans l'URL
$numsondageadmin=$_GET["sondage"];
//on découpe le résultat pour avoir le numéro de sondage (16 car.)
$numsondage=substr($numsondageadmin, 0, 16);

//ouverture de la connection avec la base SQL
$connect=connexion_base();


if (eregi("[a-z0-9]{16}",$numsondage)){

	$sondage=pg_exec($connect, "select * from sondage where id_sondage_admin ilike '$numsondageadmin'");
	$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$numsondage'");
	$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");

}

//verification de l'existence du sondage, s'il n'existe pas on met une page d'erreur
if (!$sondage||pg_numrows($sondage)=="0"){
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
	print "<H2>Ce sondage n'existe pas !</H2><br><br>"."\n";
	print "Vous pouvez retourner &agrave; la page d'accueil de <a href=\"index.php\"> STUdS</A>. "."\n";
	echo '<br><br><br><br>'."\n";
	echo '</div>'."\n";
	sur_bandeau_pied();
	bandeau_pied();
	
	echo'</body>'."\n";
	echo '</html>'."\n";
}

//s'il existe on affiche la page normale
else {

	//on recupere les données et les sujets du sondage
	$dsujet=pg_fetch_object($sujets,0);
	$dsondage=pg_fetch_object($sondage,0);

	//affichage des boutons d'effacement de colonne et des sujets

	$nbcolonnes=substr_count($dsujet->sujet,',')+1;
	$nblignes=pg_numrows($user_studs);

	//action du bouton d'annulation
	if ($_POST["annuler"]){
		header("Location:index.php");
		exit();
	}

	//si on annule la suppression
	if ($_POST["annulesuppression"]){

	}


	//si il n'y a pas suppression alors on peut afficher normalement le tableau
	if (!$_POST["confirmesuppression"]){

		//action si le bouton participer est cliqué
		if ($_POST["boutonp"]||$_POST["boutonp_x"]){
			//si on a un nom dans la case texte
			if ($_POST["nom"]){

				for ($i=0;$i<$nbcolonnes;$i++){
					//si la checkbox est cochée alors valeur est egale à 1
					if (isset($_POST["choix$i"])){
						$nouveauchoix.="1";
					}
					//sinon 0
					else {
						$nouveauchoix.="0";
					}
				}

				for ($compteur=0;$compteur<pg_numrows($user_studs);$compteur++){
	
						$user=pg_fetch_object($user_studs,$compteur);

						if ($_POST["nom"]==$user->nom){
							$erreur_prénom="yes";
						}
				}

				if (ereg("<|>", $_POST["nom"])){
					$erreur_injection="yes";
				}


				// Ecriture des choix de l'utilisateur dans la base
 				if (!$erreur_prénom&&!$erreur_injection){
					$nom=str_replace("'","°",$_POST["nom"]);
 					pg_query($connect,"insert into user_studs values ('$nom', '$numsondage', '$nouveauchoix')");
				}
			}

		}


		//action quand on ajoute une colonne au format DATE
		if ($_POST["ajoutercolonne"] && $_POST["nouvellecolonne"]!=""&&($dsondage->format=="A"||$dsondage->format=="A+")){

			$nouveauxsujets=$dsujet->sujet;

			//on rajoute la valeur a la fin de tous les sujets deje entrés
			$nouveauxsujets.=",";
			$nouveauxsujets.=str_replace(","," ",$_POST["nouvellecolonne"]);
			$nouveauxsujets=str_replace("'","°",$nouveauxsujets);

			//mise a jour avec les nouveaux sujets dans la base
			pg_query($connect,"update sujet_studs set sujet = '$nouveauxsujets' where id_sondage = '$numsondage' ");
			$reloadmodifier="yes";

			//envoi d'un mail pour prévenir l'administrateur du changement
			$adresseadmin=$dsondage->mail_admin;
			mail ("$adresseadmin", "[ADMINISTRATEUR STUdS] Ajout d'une nouvelle colonne au sondage STUdS", utf8_decode ("Vous avez ajouté une colonne à votre sondage sur STUdS. \n  Vous pouvez informer vos utilisateurs de ce changement en leur envoyant l'adresse suivante : \n\nhttps://dpt-info.u-strasbg.fr/studs/studs.php?sondage=$numsondage \n\n Merci de votre confiance !"));

		}

		
		//suppression de ligne dans la base
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["effaceligne$i"]||$_POST['effaceligne'.$i.'_x']){
				$compteur=0;
				while ($compteur<pg_numrows($user_studs)){

					$data=pg_fetch_object($user_studs,$compteur);

					if ($compteur==$i){
 						pg_query($connect,"delete from user_studs where nom = '$data->nom' and id_users = '$data->id_users'");
					}
					$compteur++;
				}
			}
		}


		//on teste pour voir si une ligne doit etre modifiée
		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
				$ligneamodifier=$i;
				$testligneamodifier="true";
			}
		}	


		//test pour voir si une ligne est a modifier

		for ($i=0;$i<$nblignes;$i++){
			if ($_POST["validermodifier$i"]){
				$modifier=$i;
				$testmodifier="true";
			}
		}

		//si le test est valide alors on affiche des checkbox pour entrer de nouvelles valeurs
		if ($testmodifier){

			for ($i=0;$i<$nbcolonnes;$i++){
				//recuperation des nouveaux choix de l'utilisateur
				if (isset($_POST["choix$i"])){
					$nouveauchoix.="1";
				}
				else {
					$nouveauchoix.="0";
				}
			}

			$compteur=0;
			while ($compteur<pg_numrows($user_studs)){

				$data=pg_fetch_object($user_studs,$compteur);
				//mise a jour des données de l'utilisateur dans la base SQL
				if ($compteur==$modifier){
					pg_query($connect,"update user_studs set reponses='$nouveauchoix' where nom='$data->nom' and id_users='$data->id_users'");
				}
				$compteur++;
			}
		}

		//suppression de colonnes dans la base
		for ($i=0;$i<$nbcolonnes;$i++){
			if ($_POST["effacecolonne$i"]||$_POST['effacecolonne'.$i.'_x']){
	
				$toutsujet=explode(",",$dsujet->sujet);
				$j=0;

				//parcours de tous les sujets actuels
				while ($toutsujet[$j]){
					//si le sujet n'est pas celui qui a été effacé alors on concatene
					if ($i!=$j){
						$nouveauxsujets.=',';
						$nouveauxsujets.=$toutsujet[$j];
					}
					$j++;
				}
				//on enleve la virgule au début
				$nouveauxsujets=substr("$nouveauxsujets",1);

				//nettoyage des reponses actuelles correspondant au sujet effacé
				$compteur = 0;
				while ($compteur<pg_numrows($user_studs)){

					$data=pg_fetch_object($user_studs,$compteur);

					$ensemblereponses=$data->reponses;
	
					//parcours de toutes les réponses actuelles
					for ($j=0;$j<$nbcolonnes;$j++){
						$car=substr($ensemblereponses,$j,1);
						//si les reponses ne concerne pas la colonne effacée, on concatene
						if ($i!=$j){
							$newcar.=$car;
						}
					}
	
					$compteur++;

					//mise a jour des reponses utilisateurs dans la base
					pg_query($connect,"update user_studs set reponses='$newcar' where nom='$data->nom' and id_users=$data->id_users");
					$newcar="";
				}
				//mise a jour des sujets dans la base
				pg_query($connect,"update sujet_studs set sujet = '$nouveauxsujets' where id_sondage = '$numsondage' ");

			}

		}
		//si la valeur du nouveau titre est valide et que le bouton est activé
		if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]!=""){

			//envoi du mail pour prevenir l'admin de sondage
			mail ("$adresseadmin", "[ADMINISTRATEUR STUdS] Changement du titre du sondage avec STUdS", utf8_decode ("Vous avez changé le titre de votre sondage sur STUdS. \n  Vous pouvez modifier ce sondage à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/adminstuds.php?sondage=$numsondageadmin \n\n Merci de votre confiance !"));
			//modification de la base SQL avec le nouveau titre
			$nouveautitre=utf8_encode($_POST["nouveautitre"]);
			pg_query($connect,"update sondage set titre = '$nouveautitre' where id_sondage = '$numsondage' ");
		}

		//si le bouton est activé, quelque soit la valeur du champ textarea
		if ($_POST["boutonnouveauxcommentaires"]||$_POST["boutonnouveauxcommentaires_x"]){
			//envoi du mail pour prevenir l'admin de sondage
			mail ("$adresseadmin", "[ADMINISTRATEUR STUdS] Changement des commentaires du sondage avec STUdS", utf8_decode ("Vous avez changé les commentaires de votre sondage sur STUdS. \n  Vous pouvez modifier ce sondage à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/adminstuds.php?sondage=$numsondageadmin \n\n Merci de votre confiance !"));
			//modification de la base SQL avec les nouveaux commentaires
			$nouveauxcommentaires=utf8_encode($_POST["nouveauxcommentaires"]);
			pg_query($connect,"update sondage set commentaires = '$nouveauxcommentaires' where id_sondage = '$numsondage' ");
		}

		//si la valeur de la nouvelle adresse est valide et que le bouton est activé
		if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]!=""){
			//envoi du mail pour prevenir l'admin de sondage
			mail ("$_POST[nouvelleadresse]", "[ADMINISTRATEUR STUdS] Changement d'adresse électronique de l'administrateur avec STUdS", utf8_decode ("Vous avez changé votre adresse électronique sur STUdS. \n Vous pouvez modifier ce sondage à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/adminstuds.php?sondage=$numsondageadmin\n\n Merci de votre confiance !"));
			//modification de la base SQL avec la nouvelle adresse
			pg_query($connect,"update sondage set  mail_admin= '$_POST[nouvelleadresse]' where id_sondage = '$numsondage' ");

		}

		//recuperation des donnes de la base
		$sondage=pg_exec($connect, "select * from sondage where id_sondage_admin ilike '$numsondageadmin'");
		$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$numsondage'");
		$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$numsondage' order by id_users");
		//on recupere les données et les sujets du sondage
		$dsujet=pg_fetch_object($sujets,0);
		$dsondage=pg_fetch_object($sondage,0);
	
		$toutsujet=explode(",",$dsujet->sujet);
		$toutsujet=str_replace("@","<br>",$toutsujet);
		$toutsujet=str_replace("°","'",$toutsujet);
		$nbcolonnes=substr_count($dsujet->sujet,',')+1;

/*DEBUT DE L'AFFICHAGE DE LA PAGE HTML*/
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
		echo '<html>'."\n";
		echo '<head>'."\n";
		echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
		echo '<title>ADMINISTRATEUR de sondage STUdS</title>'."\n";
		echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
		
		#bloquer la touche entrée
		blocage_touche_entree();

		echo '</head>'."\n";
		echo '<body>'."\n";

		//debut du formulaire et affichage des bandeaux
		echo '<form name="formulaire" action="adminstuds.php?sondage='.$numsondageadmin.'" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
		bandeau_tete();
		bandeau_titre();
		sous_bandeau_light();
	
		echo '<div class="presentationdate"> '."\n";

		//affichage du titre du sondage
		echo '<H2>'.utf8_decode($dsondage->titre).'</H2>'."\n";

		//affichage du nom de l'auteur du sondage
		echo 'Auteur du sondage : '.utf8_decode($dsondage->nom_admin).'<br>'."\n";

		//affichage des commentaires du sondage
		if ($dsondage->commentaires){
			echo '<br>Commentaires :<br>'."\n";
            $commentaires=$dsondage->commentaires;
            $commentaires=str_replace("\\","",$commentaires);       
            echo utf8_decode($commentaires);
			echo '<br>'."\n";
		}
		echo '<br>'."\n";

		echo '</div>'."\n";

		echo '<div class="cadre"> '."\n";
		echo 'En tant qu\'administrateur, vous pouvez modifier toutes les lignes de ce sondage avec <img src="images/info.png" alt="Icone infos">.<br> Vous avez aussi la possibilit&eacute; d\'effacer une colonne ou une ligne avec <img src="images/cancel.png" alt="Annuler">. Vous pouvez enfin &eacute;galement modifier les informations <br>relatives &agrave; ce sondage comme le titre, les commentaires ou encore votre adresse &eacute;lectronique.'."\n";

		echo '<br><br>'."\n";


		//debut de l'affichage de résultats
		echo '<table class="resultats">'."\n";

	//reformatage des données des sujets du sondage
	$toutsujet=explode(",",$dsujet->sujet);	
		
		echo '<tr>'."\n";
		echo '<td></td>'."\n";

		//boucle pour l'affichage des boutons de suppression de colonne
		for ($i=0;$toutsujet[$i];$i++){
			echo '<td class=somme><input type="image" name="effacecolonne'.$i.'" value="Effacer la colonne" src="images/cancel.png"></td>'."\n";
		}

		echo '</tr>'."\n";

		
//si le sondage est un sondage de date
if ($dsondage->format=="D"||$dsondage->format=="D+"){
	
//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";

	//affichage des années
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%Y",$toutsujet[$i])==strftime("%Y",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			echo '<td colspan='.$colspan.' class="annee">'.strftime("%Y",$toutsujet[$i]).'</td>'."\n";
			$colspan=1;
		}
	}
	echo '</tr>'."\n";
	echo '<tr>'."\n";	
	echo '<td></td>'."\n";
	//affichage des mois
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])&&strftime("%Y",$toutsujet[$i])==strftime("%Y",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			echo '<td colspan='.$colspan.' class="mois">'.strftime("%B",$toutsujet[$i]).'</td>'."\n";
			$colspan=1;
		}
	}
	echo '</tr>'."\n";
	echo '<tr>'."\n";		
	echo '<td></td>'."\n";
		//affichage des jours
	$colspan=1;
	for ($i=0;$i<count($toutsujet);$i++){
		if (strftime("%a %e",$toutsujet[$i])==strftime("%a %e",$toutsujet[$i+1])&&strftime("%B",$toutsujet[$i])==strftime("%B",$toutsujet[$i+1])){
			$colspan++;
		}
		else {
			echo '<td colspan='.$colspan.' class="jour">'.strftime("%a %e",$toutsujet[$i]).'</td>'."\n";
			$colspan=1;
		}
	}
	echo '</tr>'."\n";
			//affichage des horaires	
	if (eregi("@",$dsujet->sujet)){
		echo '<tr>'."\n";
		echo '<td></td>'."\n";
				
		for ($i=0;$toutsujet[$i];$i++){
			$heures=explode("@",$toutsujet[$i]);
			echo '<td class="heure">'.$heures[1].'</td>'."\n";
		}
		echo '</tr>'."\n";
	}
	
}

else {
	$toutsujet=str_replace("°","'",$toutsujet);	

//affichage des sujets du sondage
	echo '<tr>'."\n";
	echo '<td></td>'."\n";

	for ($i=0;$toutsujet[$i];$i++){
	
		echo '<td class="sujet">'.$toutsujet[$i].'</td>'."\n";
	}
	echo '</tr>'."\n";

}
		
		
		//affichage des resultats
		$somme[]=0;
		$compteur = 0;
		while ($compteur<pg_numrows($user_studs)){
			//recuperation des données
			$data=pg_fetch_object($user_studs,$compteur);
			$ensemblereponses=$data->reponses;
			
			//affichage du nom
			$nombase=str_replace("°","'",$data->nom);
			echo '<tr>'."\n";
			echo '<td class="nom">'.$nombase.'</td>'."\n";

			//si la ligne n'est pas a changer, on affiche les données
			if (!$testligneamodifier){
				for ($k=0;$k<$nbcolonnes;$k++){
					$car=substr($ensemblereponses,$k,1);
					if ($car=="1"){
						echo '<td class="ok">OK</td>'."\n";
						$somme[$k]++;
					}
					else {
						echo '<td class="non"></td>'."\n";
					}
				}
			}
			//sinon on remplace les choix de l'utilisateur par une ligne de checkbox pour recuperer de nouvelles valeurs
			else {
				//si c'est bien la ligne a modifier on met les checkbox
				if ($compteur=="$ligneamodifier"){
					for ($j=0;$j<$nbcolonnes;$j++){
							
						$car=substr($ensemblereponses,$j,1);
						if ($car=="1"){
							echo '<td class="vide"><input type="checkbox" name="choix'.$j.'" value="" checked></td>'."\n";
						}
						else {
							echo '<td class="vide"><input type="checkbox" name="choix'.$j.'" value=""></td>'."\n";
						}
					}
				}
				//sinon on affiche les lignes normales
				else {
					for ($k=0;$k<$nbcolonnes;$k++){
						$car=substr($ensemblereponses,$k,1);
						if ($car=="1"){
							echo '<td class="ok">OK</td>'."\n";
							$somme[$k]++;
						}
						else {
							echo '<td class="non"></td>'."\n";
						}
					}
				}

			}

                        //a la fin de chaque ligne se trouve les boutons modifier
                        if (!$testligneamodifier=="true"){
                	        echo '<td class=somme><input type="image" name="modifierligne'.$compteur.'" value="Modifier" src="images/info.png" alt="Icone infos"></td>'."\n";
                	        echo '<td class=somme><input type="image" name="effaceligne'.$compteur.'" value="Effacer" src="images/cancel.png"  alt="Icone efface"></td>'."\n";
                        }

                        //demande de confirmation pour modification de ligne
                       for ($i=0;$i<$nblignes;$i++){
				if ($_POST["modifierligne$i"]||$_POST['modifierligne'.$i.'_x']){
					if ($compteur==$i){
						echo '<td><input type="image" name="validermodifier'.$compteur.'" value="Valider la modification" src="images/accept.png"  alt="Icone valider"></td>'."\n";
					}
				}
			}



			$compteur++;
			echo '</tr>'."\n";

		}

		//affichage de la case vide de texte pour un nouvel utilisateur
		echo '<tr>'."\n";
		echo '<td class=nom>'."\n";
		echo '<input type=text name="nom"><br>'."\n";
		echo '</td>'."\n";

		//une ligne de checkbox pour le choix du nouvel utilisateur
		for ($i=0;$i<$nbcolonnes;$i++){
			echo '<td class="vide"><input type="checkbox" name="choix'.$i.'" value=""></td>'."\n";
		}
		// Affichage du bouton de formulaire pour inscrire un nouvel utilisateur dans la base
		echo '<td><input type="image" name="boutonp" value="Participer" src="images/add-24.png" alt="Ajouter"></td>'."\n";

		echo '</tr>'."\n";

               //determination du meilleur choix
               for ($i=0;$i<$nbcolonnes+1;$i++){
			if ($i=="0"){
				$meilleurecolonne=$somme[$i];
                        }
                        if ($somme[$i]>$meilleurecolonne){
                                $meilleurecolonne=$somme[$i];
                        }
                }

              //affichage de la ligne contenant les sommes de chaque colonne
              echo '<tr>'."\n";
              echo '<td align="right">Somme</td>'."\n";

              for ($i=0;$i<$nbcolonnes;$i++){
	              $affichesomme=$somme[$i];
        	      if ($affichesomme==""){$affichesomme="0";}
	              if ($somme[$i]==$meilleurecolonne){
        		      echo '<td class="somme">'.$affichesomme.'</td>'."\n";
	              }
        	      else {
		              echo '<td class="somme">'.$affichesomme.'</td>'."\n";
	              }
              }

	       echo '<tr>'."\n";
               echo '<td class="somme"></td>'."\n";
	               for ($i=0;$i<$nbcolonnes;$i++){
	                       if ($somme[$i]==$meilleurecolonne&&$somme[$i]){
	                               echo '<td class="somme"><img src="images/medaille.png" alt="Meilleur resultat"></td>'."\n";
	                       }
	                       else {
	                               echo '<td class="somme"></td>'."\n";
	                       }
                       }
               echo '</tr>'."\n";


		// S'il a oublié de remplir un nom
		if (($_POST["boutonp"]||$_POST["boutonp_x"])&&$_POST["nom"]=="") {
			echo '<tr>'."\n";
			print "<td colspan=3><font color=#FF0000>&nbsp;Il faut un nom !</font>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_prénom){
			echo '<tr>'."\n";
			print "<td colspan=3><font color=#FF0000>&nbsp;Le nom que vous avez choisi existe d&eacute;j&agrave; !</font></td>\n";
			echo '</tr>'."\n"; 
		}
		if ($erreur_injection){
			echo '<tr>'."\n";
			print "<td colspan=3><font color=#FF0000>&nbsp;Les caract&egrave;res \"<\" et \">\" ne sont pas autoris&eacute;s !</font></td>\n";
			echo '</tr>'."\n"; 
		}
		
		//fin du tableau
		echo '</table>'."\n";
		echo '</div>'."\n";

		//focus en javascript sur le champ texte pour le nom d'utilisateur
		echo '<script type="text/javascript">'."\n";
		echo 'document.formulaire.nom.focus();'."\n";
		echo '</script>'."\n";

		//recuperation des valeurs des sujets et adaptation pour affichage
		$toutsujet=explode(",",$dsujet->sujet);
		
	//recuperation des sujets des meilleures colonnes
	$compteursujet=0;
	for ($i=0;$i<$nbcolonnes;$i++){
		if ($somme[$i]==$meilleurecolonne){
			$meilleursujet.=", ";
			  	if ($dsondage->format=="D"||$dsondage->format=="D+"){
					$meilleursujetexport=$toutsujet[$i];
					if (eregi("@",$toutsujet[$i])){
						$toutsujetdate=explode("@",$toutsujet[$i]);
						$meilleursujet.=strftime("%A %e %B %Y",$toutsujetdate[0])." &agrave ".$toutsujetdate[1];
					}
					else{
						$meilleursujet.=strftime("%A %e %B %Y",$toutsujet[$i]);
					}
				}
				else{
					$meilleursujet.=$toutsujet[$i];
				}
			$compteursujet++;
		}
	}

		//adaptation pour affichage des valeurs
		$meilleursujet=substr("$meilleursujet",1);
		$meilleursujet=str_replace("°","'",$meilleursujet);

		//ajout du S si plusieurs votes
		if ($meilleurecolonne!="1"){$pluriel="s";}

		echo '<p class=affichageresultats>'."\n";
		//affichage de la phrase annoncant le meilleur sujet
		if ($compteursujet=="1"&&$meilleurecolonne){
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\"> Le meilleur choix pour l'instant est : <b>$meilleursujet </b>avec <b>$meilleurecolonne </b>vote$pluriel.<br>\n";
		}
		elseif ($meilleurecolonne){
			print "<img src=\"images/medaille.png\" alt=\"Meilleur resultat\"> Les meilleurs choix pour l'instant sont : <b>$meilleursujet </b>avec <b>$meilleurecolonne </b>vote$pluriel.<br>\n";
		}

		echo '<br><br>'."\n";
		echo '</p>'."\n";
		echo '</form>'."\n";
		echo '<form name="formulaire2" action="adminstuds.php?sondage='.$numsondageadmin.'#bas" method="POST" onkeypress="javascript:process_keypress(event)">'."\n";
		//Gestion du sondage
		echo '<div class=titregestionadmin>Gestion de votre sondage :</div>'."\n";
 		echo '<p class=affichageresultats>'."\n"; 
		echo '<br>'."\n";
	//Changer le titre du sondage
	$adresseadmin=$dsondage->mail_admin;
	echo 'Si vous souhaitez changer le titre du sondage :<br> <input type="text" name="nouveautitre" size="40" value="'.utf8_decode($dsondage->titre).'"> <input type="image" name="boutonnouveautitre" value="Changer le titre" src="images/accept.png" alt="Valider"><br><br>'."\n";


	if ($dsondage->format=="A"||$dsondage->format=="A+"){
		echo 'Si vous souhaitez ajouter une colonne :<br> <input type="text" name="nouvellecolonne" size="40"> <input type="image" name="ajoutercolonne" value="Ajouter une colonne" src="images/accept.png" alt="Valider"><br><br>'."\n";
	}
	
	//si la valeur du nouveau titre est invalide : message d'erreur
	if (($_POST["boutonnouveautitre"]||$_POST["boutonnouveautitre_x"]) && $_POST["nouveautitre"]==""){
		echo '<font color="#FF0000">Veuillez entrer un nouveau titre !</font><br><br>'."\n";
	}

	//Changer les commentaires du sondage
	echo 'Si vous souhaitez changer les commentaires du sondage :<br> <textarea name="nouveauxcommentaires" rows="7" cols="40">'.utf8_decode($dsondage->commentaires).'</textarea><br><input type="image" name="boutonnouveauxcommentaires" value="Changer les commentaires" src="images/accept.png" alt="Valider"><br><br>'."\n";


	//Changer l'adresse de l'administrateur
	echo 'Si vous souhaitez changer votre adresse de courrier &eacute;lectronique :<br> <input type="text" name="nouvelleadresse" size="40" value="'.$dsondage->mail_admin.'"> <input type="image" name="boutonnouvelleadresse" value="Changer votre adresse" src="images/accept.png" alt="Valider"><br><br>'."\n";

	//si l'adresse est invalide ou le champ vide : message d'erreur
	if (($_POST["boutonnouvelleadresse"]||$_POST["boutonnouvelleadresse_x"]) && $_POST["nouvelleadresse"]==""){
		echo '<font color="#FF0000">Veuillez une nouvelle adresse !</font><br><br>'."\n";

	}

	//suppression du sondage
	echo 'Si vous souhaitez supprimer votre sondage : <input type="image" name="suppressionsondage" value="Suppression du sondage" src="images/cancel.png" alt="Annuler"><br><br>'."\n";
	if ($_POST["suppressionsondage"]){

		echo 'Confirmer la suppression de votre sondage : <input type="submit" name="confirmesuppression" value="Je supprime ce sondage !">'."\n";
		echo '<input type="submit" name="annullesuppression" value="Je garde ce sondage !"><br><br>'."\n";
	}
	echo '<a name=bas></a>'."\n";
	echo '<br><br>'."\n";
	//fin de la partie GESTION et beandeau de pied
	echo '</p>'."\n";
	sur_bandeau_pied_mobile();
	bandeau_pied_mobile();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
}

//action si bouton confirmation de suppression est activé
if ($_POST["confirmesuppression"]){


	//on recupere les données et les sujets du sondage
	$dsujet=pg_fetch_object($sujets,0);
	$dsondage=pg_fetch_object($sondage,0);

	$adresseadmin=$dsondage->mail_admin;

        $nbuser=pg_numrows($user_studs);
        $date=date('H:i:s d/m/Y');

	//on ecrit dans le fichier de logs la suppression du sondage
        $fichier_log=fopen(getenv('RACINESERVEUR').'/admin/logs_studs.txt','a');
        fwrite($fichier_log,"[SUPPRESSION] $date\t$dsondage->id_sondage\t$dsondage->format\t$dsondage->nom_admin\t$dsondage->mail_admin\t$nbuser\t$dsujets->sujet\n");
        fclose($fichier_log);

	//envoi du mail a l'administrateur du sondage
	mail ("$adresseadmin", "[ADMINISTRATEUR STUdS] Suppression de sondage avec STUdS", utf8_decode ("Vous avez supprimé un sondage sur STUdS. \n Vous pouvez créer de nouveaux sondages à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/index.php \n\n Merci de votre confiance !"));

	//destruction des données dans la base SQL
	pg_query($connect,"delete from sondage where id_sondage = '$numsondage' ");
	pg_query($connect,"delete from user_studs where id_sondage = '$numsondage' ");
	pg_query($connect,"delete from sujet_studs where id_sondage = '$numsondage' ");

	//affichage de l'ecran de confirmation de suppression de sondage
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
	echo '<html>'."\n";
	echo '<head>'."\n";
	echo '<title>Suppression STUdS</title>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="style.css">'."\n";
	echo '</head>'."\n";
	echo '<body>'."\n";
	bandeau_tete();
	bandeau_titre();

	echo '<div class=corpscentre>'."\n";
	print "<H2>Votre sondage a &eacute;t&eacute; supprim&eacute; !</H2><br><br>";
	print "Vous pouvez retourner maintenant &agrave; la page d'accueil de <a href=\"index.php\"> STUdS</A>. "."\n";
	echo '<br><br><br>'."\n";
	echo '</div>'."\n";
	sur_bandeau_pied();
	bandeau_pied();
	echo '</form>'."\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
}

}
?>

