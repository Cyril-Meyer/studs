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

//Choix de la langue
if ($_SESSION["langue"]=="FR"){ include 'lang/fr.inc';}
if ($_SESSION["langue"]=="EN"){ include 'lang/en.inc';}
if ($_SESSION["langue"]=="DE"){ include 'lang/de.inc';}
if ($_SESSION["langue"]=="ES"){ include 'lang/es.inc';}

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
	$headers="From: ".getenv('NOMAPPLICATION')." <".getenv('ADRESSEMAILADMIN').">\r\nContent-Type: text/plain; charset=\"UTF-8\"\nContent-Transfer-Encoding: 8bit";

	$connect=connexion_base();

	pg_exec ($connect, "insert into sondage values('$sondage','$_SESSION[commentaires]', '$_SESSION[adresse]', '$_SESSION[nom]', '$_SESSION[titre]','$sondage_admin', '$date_fin', '$_SESSION[formatsondage]','$_SESSION[mailsonde]'  )");
	pg_exec($connect, "insert into sujet_studs values ('$sondage', '$_SESSION[toutchoix]' )");

	
	mail ("$_SESSION[adresse]", "[".getenv('NOMAPPLICATION')."][$tt_creationsondage_titre_mail_sondes] $tt_creationsondage_corps_sondage : ".stripslashes($_SESSION["titre"]), "$tt_creationsondage_corps_debut\n\n".stripslashes($_SESSION["nom"])." $tt_creationsondage_corps_milieu : \"".stripslashes($_SESSION["titre"])."\".\n$tt_creationsondage_corps_fin :\n\n".get_server_name()."studs.php?sondage=$sondage \n\n$tt_creationsondage_corps_merci,\n".getenv('NOMAPPLICATION'),$headers);
	mail ("$_SESSION[adresse]", "[".getenv('NOMAPPLICATION')."][$tt_creationsondage_titre_mail_admin] $tt_creationsondage_corps_sondage : ".stripslashes($_SESSION["titre"]), "$tt_creationsondage_corps_admin_debut :\n\n".get_server_name()."adminstuds.php?sondage=$sondage_admin \n\n$tt_creationsondage_corps_merci,\n".getenv('NOMAPPLICATION'),$headers);


	$fichier_log=fopen('admin/logs_studs.txt','a');
	fwrite($fichier_log,"   [CREATION] $date\t$sondage\t$_SESSION[formatsondage]\t$_SESSION[nom]\t$_SESSION[adresse]\t \t$_SESSION[toutchoix]\n");
	fclose($fichier_log);

	pg_close($connect);

	
	header("Location:studs.php?sondage=$sondage");

	exit();
	session_unset();
}	
?>
