<?php
session_start();

include 'fonctions.php';

$connect=connexion_base();

$sondage=pg_exec($connect, "select * from sondage where id_sondage ilike '$_SESSION[numsondage]'");
$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$_SESSION[numsondage]'");
$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$_SESSION[numsondage]' order by id_users");

$dsondage=pg_fetch_object($sondage,0);
$dsujet=pg_fetch_object($sujets,0);
$nbcolonnes=substr_count($dsujet->sujet,',')+1;

$toutsujet=explode(",",$dsujet->sujet);
$toutsujet=str_replace("�","'",$toutsujet);	

//affichage des sujets du sondage

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
 die();
?>