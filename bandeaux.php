<?php

//le logo
function logo (){
	echo '<div class="logo"><img src="images/logo_uds_bandeau.gif" height=74></div>'."\n";
}

#le bandeau principal
function bandeau_tete(){
	echo '<div class="bandeau">STUdS !</div>'."\n";
}

#les bandeaux de titre
function bandeau_titre(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre"].'</div>'."\n";
}
function bandeau_titre_infos(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_infos"].'</div>'."\n";
}
function bandeau_titre_date(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_date"].'</div>'."\n";
}
function bandeau_titre_autre(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_autre"].'</div>'."\n";
}
function bandeau_titre_admin(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_admin"].'</div>'."\n";
}
function bandeau_titre_contact(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_contact"].'</div>'."\n";
}
function bandeau_titre_version(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_version"].'</div>'."\n";
}
function bandeau_titre_erreur(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_erreur"].'</div>'."\n";
}
function bandeau_titre_apropos(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_apropos"].'</div>'."\n";
}

#Les sous-bandeaux contenant les boutons de navigation
function sous_bandeau(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'"><input type=submit class=boutonsousbandeau name=exemple value="'.$GLOBALS["tt_bouton_exemple"].'"><input type=submit class=boutonsousbandeau name=contact value="'.$GLOBALS["tt_bouton_contact"].'"><input type=submit class=boutonsousbandeau name=versions value="'.$GLOBALS["tt_bouton_versions"].'"><input type=submit class=boutonsousbandeau name=sources value="'.$GLOBALS["tt_bouton_sources"].'"><input type=submit class=boutonsousbandeau name=apropos value="'.$GLOBALS["tt_bouton_apropos"].'">'.$GLOBALS["tt_bandeau_langue"].'<input type=submit class=boutonsousbandeaulangue name=france value="FR"><input type=submit class=boutonsousbandeaulangue name=uk value="EN"><input type=submit class=boutonsousbandeaulangue name=germany value="DE"><input type=submit class=boutonsousbandeaulangue name=espagne value="ES"><input type=submit class=boutonsousbandeaudroite name=intranet value="'.$GLOBALS["tt_bouton_intranet"].'"></div>'."\n";
}
function sous_bandeau_light(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'">'.$GLOBALS["tt_bandeau_langue"].'<input type=submit class=boutonsousbandeaulangue name=france value="FR"><input type=submit class=boutonsousbandeaulangue name=uk value="EN"><input type=submit class=boutonsousbandeaulangue name=germany value="DE"><input type=submit class=boutonsousbandeaulangue name=espagne value="ES"></div>'."\n";
}
function sous_bandeau_admin(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'"><input type=submit class=boutonsousbandeau name=historique value="'.$GLOBALS["tt_bouton_historique"].'">'.$GLOBALS["tt_bandeau_langue"].'<input type=submit class=boutonsousbandeaulangue name=france value="FR"><input type=submit class=boutonsousbandeaulangue name=uk value="EN"><input type=submit class=boutonsousbandeaulangue name=germany value="DE"><input type=submit class=boutonsousbandeaulangue name=espagne value="ES"></div>'."\n";
}
function sous_bandeau_choix(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'"><input type=submit class=boutonsousbandeau name=retour value="'.$GLOBALS["tt_bouton_retour"].'"></div>'."\n";
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
