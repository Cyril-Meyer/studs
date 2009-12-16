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

include 'variables.php';

function connexion_base(){

       $connectstr = "dbname=".getenv('BASE')." user=".getenv('USERBASE');
       if (getenv('SERVEURBASE') != '')
	       $connectstr .= " host=".getenv('SERVEURBASE');
       if (getenv('USERPASSWD') != '')
	       $connectstr .= " password=".getenv('USERPASSWD');
       return pg_connect($connectstr);
}

function blocage_touche_entree(){
	print "
	<script type=\"text/javascript\">
		if (document.layers)
		document.captureEvents(Event.KEYPRESS)

		function process_keypress(e) {
			if(window.event){
				if (window.event.type == \"keypress\" & window.event.keyCode == 13)
					return !(window.event.type == \"keypress\" & window.event.keyCode == 13);
				}
			if(e){
				if (e.type == \"keypress\" & e.keyCode == 13)
				return !e;
			}
		}
	document.onkeypress = process_keypress;
	</script>\n";
}

function get_server_name() {
       $scheme = $_SERVER["HTTPS"] == "on" ? "https" : "http";
	$url = sprintf("%s://%s%s", $scheme,
		      getenv('NOMSERVEUR'),
		      dirname($_SERVER["SCRIPT_NAME"]));
	if (!preg_match("|/$|", $url)){
		$url = $url."/";        
	}
	return $url;
}

?>
