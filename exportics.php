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
require_once 'iCalcreator/iCalcreator.class.php';

$meilleursujet=$_SESSION["meilleursujet"];


$v = new vcalendar(); // create a new calendar instance
$v->setConfig( 'unique_id', $_SESSION["numsondage"] ); // set Your unique id
$v->setProperty( 'method', 'PUBLISH' ); // required of some calendar software

$vevent = new vevent(); // create an event calendar component

if(ereg ("([0-9]{10})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>0, 'min'=>0, 'sec'=>0 ), array( 'VALUE' => 'DATE' ));
}

if(ereg ("([0-9]{10})@([0-9]{1,2}):([0-9]{1,2})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2], 'min'=>$registreics[3], 'sec'=>0 ));
	$vevent->setProperty( 'dtend', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2]+1, 'min'=>$registreics[3], 'sec'=>0 ));
}

if(eregi ("([0-9]{10})@([0-9]{1,2})h([0-9]{0,2})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2], 'min'=>$registreics[3], 'sec'=>0 ));
	$vevent->setProperty( 'dtend', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2]+1, 'min'=>$registreics[3], 'sec'=>0 ));
}

if(ereg ("([0-9]{10})@([0-9]{1,2}):([0-9]{1,2})-([0-9]{1,2}):([0-9]{1,2})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2], 'min'=>$registreics[3], 'sec'=>0 ));
	$vevent->setProperty( 'dtend', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[4], 'min'=>$registreics[5], 'sec'=>0 ));
}

if(eregi ("([0-9]{10})@([0-9]{1,2})h([0-9]{0,2})-([0-9]{1,2})h([0-9]{0,2})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2], 'min'=>$registreics[3], 'sec'=>0 ));
	$vevent->setProperty( 'dtend', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[4], 'min'=>$registreics[5], 'sec'=>0 ));
}

if(ereg ("([0-9]{10})@([0-9]{1,2})-([0-9]{1,2})", $meilleursujet, $registreics)){
	$vevent->setProperty( 'dtstart', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[2], 'min'=>0, 'sec'=>0 ));
	$vevent->setProperty( 'dtend', array( 'year'=>date("Y",$registreics[1]), 'month'=>date("n",$registreics[1]), 'day'=>date("j",$registreics[1]), 'hour'=>$registreics[3], 'min'=>0, 'sec'=>0 ));
}

$vevent->setProperty( 'summary', $_SESSION["sondagetitre"] );

$v->setComponent ( $vevent ); // add event to calendar
$v->setConfig( "language", "fr" );
$v->setConfig( "directory", "export" ); 
$v->setConfig( "filename", $_SESSION["numsondage"].".ics" ); // set file name

$v->returnCalendar(); 

?>
