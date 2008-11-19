<?php
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

