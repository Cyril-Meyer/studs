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

include_once('variables.php');
include_once('i18n.php');
include_once('adodb/adodb.inc.php');

function connexion_base(){
       $DB = NewADOConnection(getenv('BASE_TYPE'));
       $DB->Connect(getenv('SERVEURBASE'), getenv('USERBASE'),
		    getenv('USERPASSWD'), getenv('BASE'));
       return $DB;
}

function get_server_name() {
  $scheme = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https' : 'http';
	$url = sprintf("%s://%s%s", $scheme,
		      STUDS_URL,
		      dirname($_SERVER["SCRIPT_NAME"]));
	if (!preg_match("|/$|", $url)){
		$url = $url."/";        
	}
	return $url;
}

function get_sondage_from_id($id) {
  global $connect;
  // Ouverture de la base de données
  if(preg_match(";^[\w\d]{16}$;i",$id)) {
    $sondage=$connect->Execute('SELECT sondage.*,sujet_studs.sujet FROM sondage LEFT OUTER JOIN sujet_studs ON sondage.id_sondage = sujet_studs.id_sondage WHERE sondage.id_sondage = "' . $id . '"');
    $psondage = $sondage->FetchObject(false);
    $psondage->date_fin = strtotime($psondage->date_fin);
    return $psondage;
  }
  return false;
}

$connect=connexion_base();
?>
