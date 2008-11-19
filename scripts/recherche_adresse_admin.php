<?php

//ouverture de la connection avec la base SQL
$connect = pg_connect("host=localhost dbname=studs user=borghesi");


$sondage=pg_exec($connect, "select distinct mail_admin from sondage ");

for ($i=0;$i<pg_numrows($sondage);$i++){
        $dsondage=pg_fetch_object($sondage,$i);


	print "$dsondage->mail_admin, ";
//	print "$dsondage->mail_admin\n";


}


?>
