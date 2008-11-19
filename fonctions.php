<?php

include 'variables.php';

function connexion_base(){

	return pg_connect("host=".getenv('SERVEURBASE')." dbname=".getenv('BASE')." user=".getenv('USERBASE'));
}


?>