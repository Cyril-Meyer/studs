<?php

#le bandeau principal
function bandeau_tete(){
	echo '<div class="bandeau">STUdS !</div>'."\n";
}

#les bandeaux de titre
function bandeau_titre(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre"].'</div>'."\n";
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
	echo '<div class="bandeautitre">Informations g&eacute;n&eacute;rales</div>'."\n";
}

#Les sous-bandeaux contenant les boutons de navigation
function sous_bandeau(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value='.$GLOBALS["tt_bouton_accueil"].'><input type=submit class=boutonsousbandeau name=exemple value='.$GLOBALS["tt_bouton_exemple"].'><input type=submit class=boutonsousbandeau name=contact value='.$GLOBALS["tt_bouton_contact"].'><input type=submit class=boutonsousbandeau name=versions value='.$GLOBALS["tt_bouton_versions"].'><input type=submit class=boutonsousbandeau name=sources value='.$GLOBALS["tt_bouton_sources"].'><input type=submit class=boutonsousbandeau name=apropos value="'.$GLOBALS["tt_bouton_apropos"].'"><input type=image class=drapeausousbandeau alt=france src="images/france.png" name="france"><input type=image class=drapeausousbandeau alt=uk src="images/uk.png" name="uk"><input type=image class=drapeausousbandeau alt=deutschland src="images/germany.png" name="germany"><input type=submit class=boutonsousbandeaudroite name=intranet value='.$GLOBALS["tt_bouton_intranet"].'></div>'."\n";
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
	echo '<div class="bandeaupied">'.$GLOBALS["tt_bandeau_pied"].'</div>'."\n";
}
function sur_bandeau_pied_mobile(){
	echo '<div class="surbandeaupiedmobile"></div>'."\n";
}
function bandeau_pied_mobile(){
	echo '<div class="bandeaupiedmobile">'.$GLOBALS["tt_bandeau_pied"].'</div>'."\n";
}



?>
