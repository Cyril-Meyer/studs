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

include 'php2pdf/phpToPDF.php';
include 'fonctions.php';
include 'variables.php';

$connect=connexion_base();

$sondage=pg_exec($connect, "select * from sondage where id_sondage ilike '$_SESSION[numsondage]'");
$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$_SESSION[numsondage]'");
$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$_SESSION[numsondage]' order by id_users");

$dsondage=pg_fetch_object($sondage,0);
$dsujet=pg_fetch_object($sujets,0);
$nbcolonnes=substr_count($dsujet->sujet,',')+1;

$datereunion=explode("@",$_SESSION["meilleursujet"]);

//creation du fichier PDF
$PDF=new phpToPDF();
$PDF->AddPage();
$PDF->SetFont('Arial','',11);

//affichage de la date de convocation
$PDF->Text(140,30,"Le ".date("d/m/Y"));

$PDF->Image("./".getenv("LOGOLETTRE")."",20,20,65,40);

$PDF->SetFont('Arial','U',11);
$PDF->Text(40,120,"Objet : ");
$PDF->SetFont('Arial','',11);
$PDF->Text(55,120," Convocation");

$PDF->Text(55,140,"Bonjour,");

$PDF->Text(40,150,"Vous êtes conviés à la réunion \"".utf8_decode($dsondage->titre)."\".");
$lieureunion=str_replace("\\","",$_SESSION["lieureunion"]);

$PDF->SetFont('Arial','B',11);
$PDF->Text(40,170,"Informations sur la réunion");

$PDF->SetFont('Arial','',11);
$PDF->Text(60,180,"Date : ".date("d/m/Y", "$datereunion[0]")." à ".$datereunion[1]);
$PDF->Text(60,185,"Lieu :  ".utf8_decode($lieureunion));

$PDF->Text(55,220,"Cordialement,");

$PDF->Text(140,240,utf8_decode($dsondage->nom_admin));

$PDF->SetFont('Arial','B',8);
$PDF->Text(35,275,"Cette lettre de convocation a été générée automatiquement par ".getenv('NOMAPPLICATION')." sur ".get_server_name());

//Sortie
$PDF->Output();

?>
