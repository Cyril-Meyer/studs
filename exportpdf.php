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
$PDF->SetFont('Arial','B',12);

//affichage de la date de convocation
$PDF->Text(140,10,"Strasbourg, le ".date("d/m/Y"));
$PDF->Text(40,150,"Convocation � la r�union : ".utf8_decode($dsondage->titre));
$PDF->Text(20,160,"Vous �tes convi�s � la r�union organis�e par ".utf8_decode($dsondage->nom_admin).".");
$PDF->Text(20,170,"Cette r�union aura lieu le ".date("d/m/Y", "$datereunion[0]")." � ".$datereunion[1]);
$PDF->Text(20,180,"Le lieu de celle-ci sera : $_SESSION[lieureunion]");

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
	$nombase=str_replace("�","'",$data->nom);
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