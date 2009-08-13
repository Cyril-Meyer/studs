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
