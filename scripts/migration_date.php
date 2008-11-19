<?php

//ouverture de la connection avec la base SQL
$connect = pg_connect("host=localhost dbname=studs user=borghesi");


$sondage=pg_exec($connect, "select * from sondage where format='D' or format='D+'");

for ($i=0;$i<pg_numrows($sondage);$i++){
        $dsondage=pg_fetch_object($sondage,$i);
//	print "Pour le sondage ".$dsondage->id_sondage." ";
	$sujets=pg_exec($connect, "select sujet from sujet_studs where id_sondage='$dsondage->id_sondage'");
        $dsujets=pg_fetch_object($sujets,0);

	$nouvelledateaffiche="";
	$anciensujethoraires=explode(",",$dsujets->sujet);

	for ($j=0;$j<count($anciensujethoraires);$j++){


		if (eregi("@",$anciensujethoraires[$j])){

			$ancientsujet=explode("@",$anciensujethoraires[$j]);


			if (eregi("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$ancientsujet[0],$registredate)){

				$nouvelledate=mktime(0,0,0,$registredate[2],$registredate[1],$registredate[3]);

//				echo $ancientsujet[0].'@'.$ancientsujet[1].' ---> '.$nouvelledate.'@'.$ancientsujet[1].'<br> ';
				$nouvelledateaffiche.=$nouvelledate.'@'.$ancientsujet[1].',';


				}
			}

			else{

				if (eregi("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$anciensujethoraires[$j],$registredate)){
                                	$nouvelledate=mktime(0,0,0,$registredate[2],$registredate[1],$registredate[3]);
//					echo $anciensujethoraires[$j].' ---- > '.$nouvelledate.'<br>';
                                $nouvelledateaffiche.=$nouvelledate.',';

				}
			}
		}
		$nouvelledateaffiche=substr($nouvelledateaffiche,0,-1);
		print $dsujets->sujet.' donne  '.$nouvelledateaffiche.'\n\n';
//		pg_exec($connect,"update sujet_studs set sujet='$nouvelledateaffiche' where id_sondage='$dsondage->id_sondage'");

}


?>
