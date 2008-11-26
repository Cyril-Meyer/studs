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

$toutsujet=explode(",",$dsujet->sujet);
$toutsujet=str_replace("°","'",$toutsujet);	

//creation du fichier PDF
$PDF=new phpToPDF();
$PDF->AddPage();
$PDF->SetFont('Arial','B',16);

//affichage du titre du sondage


//affichage des sujets du sondage
$PDF->Text(40,10,utf8_decode($dsondage->titre));
$PDF->Write(10,"\n");


// Définition des propriétés du tableau.
$proprietesTableau = array(
	'TB_ALIGN' => 'C',
	'L_MARGIN' => 10,
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => '0.3',
	);

// Définition des propriétés du header du tableau.	
$proprieteHeader = array(
	'T_COLOR' => array(150,10,10),
	'T_SIZE' => 12,
	'T_FONT' => 'Arial',
	'T_ALIGN' => 'C',
	'V_ALIGN' => 'T',
	'T_TYPE' => 'B',
	'LN_SIZE' => 7,
	'BG_COLOR_COL0' => array(170, 240, 230),
	'BG_COLOR' => array(170, 240, 230),
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => 0.2,
	'BRD_TYPE' => '1',
	'BRD_TYPE_NEW_PAGE' => '',
	);

// Contenu du header du tableau.	
$contenuHeader = array(
	10, 10, 10,
	"", 
	"$toutsujet[0]",

	);

// Définition des propriétés du reste du contenu du tableau.	
$proprieteContenu = array(
	'T_COLOR' => array(0,0,0),
	'T_SIZE' => 10,
	'T_FONT' => 'Arial',
	'T_ALIGN_COL0' => 'L',
	'T_ALIGN' => 'R',
	'V_ALIGN' => 'M',
	'T_TYPE' => '',
	'LN_SIZE' => 6,
	'BG_COLOR_COL0' => array(245, 245, 150),
	'BG_COLOR' => array(255,255,255),
	'BRD_COLOR' => array(0,92,177),
	'BRD_SIZE' => 0.1,
	'BRD_TYPE' => '1',
	'BRD_TYPE_NEW_PAGE' => '',
	);	

// Contenu du tableau.	
$contenuTableau = array(
	"champ 1", 1, 2,
	"champ 2", 3, 4,
	"champ 3", 5, 6,
	"champ 4", 7, 8,
	);

// D'abord le PDF, puis les propriétés globales du tableau. 
// Ensuite, le header du tableau (propriétés et données) puis le contenu (propriétés et données)
$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

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