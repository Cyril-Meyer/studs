<?php

#Nom du serveur
putenv("NOMSERVEUR=studs.u-strasbg.fr");

#racine du serveur web
putenv("RACINESERVEUR=/www-root/studs");

#adresse mail de l'administrateur de la base
putenv("ADRESSEMAILADMIN=studs@dpt-info.u-strasbg.fr");

#nom de la base de donnees
putenv("BASE=studs");

#nom de l'utilisateur de la base
putenv("USERBASE=borghesi");

#nom du serveur de base de donnees
putenv("SERVEURBASE=localhost");

#nom du serveur de base de donnees
putenv("LANGUE=FR");

if (@file_exists('variables.local.php')) {
    include('variables.local.php');
}

?>
