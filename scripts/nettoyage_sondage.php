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

include '../fonctions.php';
include '../variables.php';

//recuperation de la date
$date_courante=date("U");
$date_humaine=date('H:i:s d/m/Y');


//ouverture de la connection avec la base SQL
$connect=connexion_base();

$sondage=pg_exec($connect, "select * from sondage");

for ($compteur=0;$compteur<pg_numrows($sondage);$compteur++){

	$dsondage=pg_fetch_object($sondage,$compteur);

	if ($date_courante>$dsondage->date_fin){

		//destruction des données dans la base 
		pg_query($connect,"delete from sondage where id_sondage = '$dsondage->id_sondage' ");
		pg_query($connect,"delete from user_studs where id_sondage = '$dsondage->id_sondage' ");
		pg_query($connect,"delete from sujet_studs where id_sondage = '$dsondage->id_sondage' ");
		pg_query($connect,"delete from comments where id_sondage = '$dsondage->id_sondage' ");

               // ecriture des traces dans le fichier de logs
               $fichier_log=fopen('../admin/logs_studs.txt','a');
               fwrite($fichier_log,"[SUPPRESSION] $date_humaine\t$dsondage->id_sondage\t$dsondage->format\t$dsondage->nom_admin\t$dsondage->mail_admin\t\n");
               fclose($fichier_log);


	}


}

?>
