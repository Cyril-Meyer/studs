<?php
#le bandeau principal
function bandeau_tete(){
	echo '<div class="bandeau">STUdS !</div>'."\n";
}

#les bandeaux de titre
function bandeau_titre(){
	echo '<div class="bandeautitre">Sondage Trivial pour l\'Universit&eacute; de Strabourg</div>'."\n";
}
function bandeau_titre_infos(){
	echo '<div class="bandeautitre">Cr&eacute;ation de sondage (1 sur 2)</div>'."\n";
}
function bandeau_titre_date(){
	echo '<div class="bandeautitre">Choix des dates (2 sur 2)</div>'."\n";
}
function bandeau_titre_autre(){
	echo '<div class="bandeautitre">Choix des sujets (2 sur 2)</div>'."\n";
}
function bandeau_titre_admin(){
	echo '<div class="bandeautitre">Administrateur de la base</div>'."\n";
}
function bandeau_titre_contact(){
	echo '<div class="bandeautitre">Nous contacter</div>'."\n";
}
function bandeau_titre_version(){
	echo '<div class="bandeautitre">Les diff&eacute;rentes versions et les am&eacute;liorations pr&eacute;vues</div>'."\n";
}
function bandeau_titre_erreur(){
	echo '<div class="bandeautitre">Erreur !</div>'."\n";
}
function bandeau_titre_apropos(){
	echo '<div class="bandeautitre">Informations sur l\'application</div>'."\n";
}

#Les sous-bandeaux contenant les boutons de navigation
function sous_bandeau(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=exemple value=Exemple><input type=submit class=boutonsousbandeau name=contact value=Contact><input type=submit class=boutonsousbandeau name=versions value=Versions><input type=submit class=boutonsousbandeau name=sources value=Sources><input type=submit class=boutonsousbandeau name=apropos value="A propos"><input type=submit class=boutonsousbandeaudroite name=intranet value=Intranet></div>'."\n";
}
function sous_bandeau_light(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil></div>'."\n";
}
function sous_bandeau_admin(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=historique value=Historique></div>'."\n";
}
function sous_bandeau_choix(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value=Accueil><input type=submit class=boutonsousbandeau name=retour value=Retour></div>'."\n";
}


#les bandeaux de pied
function sur_bandeau_pied(){
	echo '<div class="surbandeaupied"></div>'."\n";
}
function bandeau_pied(){
	echo '<div class="bandeaupied">Universit&eacute; de Strasbourg - Cr&eacute;ation : Guilhem BORGHESI - 2008</div>'."\n";
}
function bandeau_pied_mobile(){
	echo '<div class="bandeaupiedmobile">Universit&eacute; de Strasbourg - Cr&eacute;ation : Guilhem BORGHESI - 2008</div>'."\n";
}



?>