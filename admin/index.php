<?php

include '../variables.php';
include '../fonctions.php';
include '../bandeaux.php';

// Ce fichier index.php se trouve dans le sous-repertoire ADMIN de Studs. Il sert à afficher l'intranet de studs 
// pour modifier les sondages directement sans avoir reçu les mails. C'est l'interface d'aministration
// de l'application.

// action du bouton annuler
if ($_POST["annuler"]){
	header("Location:../index.php");
	exit();
}

if ($_POST["historique"]){
	header("Location:logs_studs.txt");
	exit();
}

// Affichage des balises standards
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\n";
echo '<html>'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">'."\n";
echo '<title>ADMINISTRATEUR de la base STUdS</title>'."\n";
echo '<link rel="stylesheet" type="text/css" href="../style.css">'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

//Affichage des bandeaux et début du formulaire
echo '<form action="index.php" method="POST">'."\n";
bandeau_tete();
bandeau_titre_admin();
sous_bandeau_admin();

// ouverture de la base de données
$connect=connexion_base();

$sondage=pg_exec($connect, "select * from sondage");

// Nbre de sondages
$nbsondages=pg_numrows($sondage);

echo'<div class=corps>'."\n";

echo 'Il y a actuellement '.$nbsondages.' sondages dans la base<br><br>'."\n";

// Test et affichage du bouton de confirmation en cas de suppression de sondage
for ($i=0;$i<$nbsondages;$i++){
 	if ($_POST["supprimersondage$i"]){
 		$dsondage=pg_fetch_object($sondage,$i);
		echo '<table>'."\n";
 		echo '<tr><td bgcolor="#EE0000" colspan=11>Confirmer la suppression du sondage "'.$dsondage->id_sondage.'" : <input type="submit" name="confirmesuppression'.$i.'" value="Je supprime ce sondage !">'."\n";
 		echo '<input type="submit" name="annullesuppression" value="Je garde ce sondage !"></td></tr>'."\n";
		echo '</table>'."\n";
		echo '<br>'."\n";
 	}

}

// tableau qui affiche tous les sondages de la base
echo '<table border=1>'."\n";	

echo '<tr align=center><td>ID</td><td>Format</td><td>Titre</td><td>Cr&eacute;ateur</td><td>Mail</td><td>Date d\'expiration</td><td>Sujets</td><td>Nombre d\'utilisateurs</td><td colspan=3>Actions</td>'."\n";


for ($i=0;$i<$nbsondages;$i++){

	$dsondage=pg_fetch_object($sondage,$i);

	$sujets=pg_exec($connect, "select * from sujet_studs where id_sondage='$dsondage->id_sondage'");
	$dsujets=pg_fetch_object($sujets,0);

	$user_studs=pg_exec($connect, "select * from user_studs where id_sondage='$dsondage->id_sondage'");
	$nbuser=pg_numrows($user_studs);

	echo '<tr align=center><td>'.$dsondage->id_sondage.'</td><td>'.$dsondage->format.'</td><td>'.utf8_decode($dsondage->titre).'</td><td>'.utf8_decode($dsondage->nom_admin).'</td><td>'.$dsondage->mail_admin.'</td>';
	
	if ($dsondage->date_fin>time()){
		echo '<td>'.date("d/m/y",$dsondage->date_fin).'</td>';
	}
	else{
		echo '<td><font color=#FF0000>'.date("d/m/y",$dsondage->date_fin).'</font></td>';
	}
	
	echo'<td>'.$nbuser.'</td>'."\n";

	echo '<td><a href="../studs.php?sondage='.$dsondage->id_sondage.'" target=_new>Voir le sondage</a></td>'."\n";
	echo '<td><a href="../adminstuds.php?sondage='.$dsondage->id_sondage_admin.'" target=_new>Modifier le sondage</a></td>'."\n";
	echo '<td><input type="submit" name="supprimersondage'.$i.'" value="Supprimer le sondage"></td>'."\n";

	echo '</tr>'."\n";
}
echo'</div>'."\n";
// fin du formulaire et de la page web
echo '</form>'."\n";
echo '</table>'."\n";	

echo '</body>'."\n";
echo '</html>'."\n";

// Traitement de la confirmation de suppression
for ($i=0;$i<$nbsondages;$i++){
	if ($_POST["confirmesuppression$i"]){

		$dsondage=pg_fetch_object($sondage,$i);

		$date=date('H:i:s d/m/Y');

		// requetes SQL qui font le ménage dans la base
		pg_query($connect,"delete from sondage where id_sondage = '$dsondage->id_sondage' ");
		pg_query($connect,"delete from user_studs where id_sondage = '$dsondage->id_sondage' ");
		pg_query($connect,"delete from sujet_studs where id_sondage = '$dsondage->id_sondage' ");

		// ecriture des traces dans le fichier de logs
	        $fichier_log=fopen(getenv('RACINESERVEUR').'/admin/logs_studs.txt','a');
	        fwrite($fichier_log,"[SUPPRESSION] $date\t$dsondage->id_sondage\t$dsondage->format\t$dsondage->nom_admin\t$dsondage->mail_admin\t$nbuser\t$dsujets->sujet\n");
	        fclose($fichier_log);

		// rafraichissement de la page
		echo '<meta http-equiv=refresh content="0">';		
	}
}

// si on annule la suppression, rafraichissement de la page
if ($_POST["annulesuppression"]){
	echo '<meta http-equiv=refresh content="0">';
}

?>