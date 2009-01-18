<?php
session_start();

include 'php2pdf/phpToPDF.php';
include 'fonctions.php';

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
$PDF->Text(140,30,"Strasbourg, le ".date("d/m/Y"));

$PDF->Image("./images/logo_uds.jpg",20,20,65,40);

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
$PDF->Text(60,185,"Lieu :  ".$lieureunion);

$PDF->Text(55,220,"Cordialement,");

$PDF->Text(140,240,utf8_decode($dsondage->nom_admin));

$PDF->SetFont('Arial','B',8);
$PDF->Text(35,275,"Cette lettre de convocation a été générée automatiquement par STUdS sur http://studs.u-strasbg.fr");

//Sortie
$PDF->Output();

?>