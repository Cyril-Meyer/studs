<?php
session_start();

include 'variables.php';
include 'fonctions.php';

//Generer une chaine de caractere unique et aleatoire
function random($car) {
	$string = "";
	$chaine = "abcdefghijklmnopqrstuvwxyz123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}

function ajouter_sondage(){
	$sondage=random(16);
	$sondage_admin=$sondage.random(8);

if ($_SESSION["formatsondage"]=="A"||$_SESSION["formatsondage"]=="A+"){

	//extraction de la date de fin choisie
	if ($_SESSION["champdatefin"]){
		if ($_SESSION["champdatefin"]>time()+250000){
			$date_fin=$_SESSION["champdatefin"];
		}
	}
	else{$date_fin=time()+15552000;}
}

if ($_SESSION["formatsondage"]=="D"||$_SESSION["formatsondage"]=="D+"){

	//Calcul de la date de fin du sondage
	$taille_tableau=sizeof($_SESSION["totalchoixjour"])-1;
	$date_fin=$_SESSION["totalchoixjour"][$taille_tableau]+200000;
}

	$date=date('H:i:s d/m/Y');
	$headers="From: STUdS <studs@dpt-info.u-strasbg.fr>\r\n";

	$connect=connexion_base();
	
	pg_exec ($connect, "insert into sondage values('$sondage','$_SESSION[commentaires]', '$_SESSION[adresse]', '$_SESSION[nom]', '$_SESSION[titre]','$sondage_admin', '$date_fin', '$_SESSION[formatsondage]','$_SESSION[mailsonde]'  )");
	pg_exec($connect, "insert into sujet_studs values ('$sondage', '$_SESSION[toutchoix]' )");

	
	mail ("$_SESSION[adresse]", utf8_decode ("[STUdS][Pour diffusion aux sondés] Sondage : $_SESSION[titre]"), utf8_decode ("Ceci est le message qui doit être envoyé aux sondés. \nVous pouvez maintenant transmettre ce message à toutes les personnes susceptibles de participer au vote.\n\n$_SESSION[nom] vient de créer un sondage intitulé : \"$_SESSION[titre]\".\nMerci de bien vouloir remplir le sondage à l'adresse suivante :\n\nhttp://".getenv('NOMSERVEUR')."/studs.php?sondage=$sondage \n\nMerci de votre confiance,\nSTUdS !"),$headers);
	mail ("$_SESSION[adresse]", utf8_decode ("[STUdS][Réservé à l'auteur] Sondage : $_SESSION[titre]"), utf8_decode ("Ce message ne doit PAS être diffusé aux sondés. Il est réservé à l'auteur du sondage STUdS.\n\nVous avez créé un sondage sur STUdS. \nVous pouvez modifier ce sondage à l'adresse suivante :\n\nhttp://studs.u-strasbg.fr/adminstuds.php?sondage=$sondage_admin \n\nMerci de votre confiance,\nSTUdS !"),$headers);


	$fichier_log=fopen(getenv('RACINESERVEUR').'/admin/logs_studs.txt','a');
	fwrite($fichier_log,"   [CREATION] $date\t$sondage\t$_SESSION[formatsondage]\t$_SESSION[nom]\t$_SESSION[adresse]\t \t$_SESSION[toutchoix]\n");
	fclose($fichier_log);

	pg_close($connect);

	
	header("Location:studs.php?sondage=$sondage");

	exit();
	session_unset();
}	
?>
