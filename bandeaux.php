<?php

function bandeau_tete(){
	echo '<div class="bandeau">STUdS !</div>'."\n";
}
function sous_bandeau_tete_infos(){
	echo '<div class="sous_bandeau_tete">Cr&eacute;ation de sondage 1/2</div>'."\n";
}


function sous_bandeau(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil> <input type=submit class=boutonsousbandeau name=exemple value=Exemple> <input type=submit class=boutonsousbandeau name=contact value=Contact><input type=submit class=boutonsousbandeau name=versions value=Versions> <input type=submit class=boutonsousbandeau name=sources value=Sources> <input type=submit class=boutonsousbandeau name=intranet value=Intranet></div>'."\n";
}
function sous_bandeau_light(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil></div>'."\n";
}
function sous_bandeau_studs(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=exportcsv value="Export CSV"></div>'."\n";
}
function sous_bandeau_admin(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=historique value=Historique></div>'."\n";
}
function sous_bandeau_choix(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=retour value=Retour></div>'."\n";
}


function bandeau_pied(){
	echo '<div class="bandeaupied">Universit&eacute; Louis Pasteur - Strasbourg - Cr&eacute;ation : Guilhem BORGHESI - 2008</div>'."\n";
}
function bandeau_pied_mobile(){
	echo '<div class="bandeaupiedmobile">Universit&eacute; Louis Pasteur - Strasbourg - Cr&eacute;ation : Guilhem BORGHESI - 2008</div>'."\n";
}



?>