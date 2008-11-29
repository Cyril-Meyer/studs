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
$PDF->Text(40,90,"De la part de ".utf8_decode($dsondage->nom_admin)."");

$PDF->SetFont('Arial','U',11);
$PDF->Text(40,150,"Objet : ");
$PDF->SetFont('Arial','',11);
$PDF->Text(55,150," Convocation");

$PDF->Text(40,160,"Vous êtes conviés à la réunion \"".utf8_decode($dsondage->titre)."\".");
$PDF->Text(40,165,"Cette réunion aura lieu le ".date("d/m/Y", "$datereunion[0]")." à ".$datereunion[1]);
$lieureunion=str_replace("\\","",$_SESSION["lieureunion"]);
$PDF->Text(40,170,"Le lieu de celle-ci sera : $lieureunion");

$PDF->Text(40,200,"Cordialement,");

$PDF->Text(140,240,utf8_decode($dsondage->nom_admin));

$PDF->SetFont('Arial','B',8);
$PDF->Text(35,275,"Cette lettre de convocation a été générée automatiquement par STUdS sur http://studs.u-strasbg.fr");

//Sortie
$PDF->Output();


/* 
$input.=";";
for ($i=0;$toutsujet[$i];$i++){
	if ($dsondage->format=="D"||$dsondage->format=="D+"){
		$input.='"'.date("j/n/Y",$toutsujet[$i]).'";';
	}
	else{
		$input.='"'.$toutsujet[$i].'";';
	}
}
$input.="\r\n";

if (eregi("@",$dsujet->sujet)){
	$input.=";";
	for ($i=0;$toutsujet[$i];$i++){
		$heures=explode("@",$toutsujet[$i]);
		$input.='"'.$heures[1].'";';
	}
	$input.="\r\n";
}

$compteur = 0;
while ($compteur<pg_numrows($user_studs)){

	$data=pg_fetch_object($user_studs,$compteur);
// Le nom de l'utilisateur
	$nombase=str_replace("°","'",$data->nom);
	$input.='"'.$nombase.'";';
//affichage des resultats
	$ensemblereponses=$data->reponses;
	for ($k=0;$k<$nbcolonnes;$k++){
		$car=substr($ensemblereponses,$k,1);
		if ($car=="1"){
			$input.='"OK";';
			$somme[$k]++;
		}
		else {
			$input.='"";';
		}
	}
	$input.="\r\n";
	$compteur++;
}

$filesize = strlen( $input );
$filename=$_SESSION["numsondage"].".csv";

 header( 'Content-Type: text/csv; charset=utf-8' );
 header( 'Content-Length: '.$filesize );
 header( 'Content-Disposition: attachment; filename="'.$filename.'"' );
 header( 'Cache-Control: max-age=10' );
echo $input;
 die(); */
?>