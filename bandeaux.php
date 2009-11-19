<?php 
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Auteur : Guilhem BORGHESI
//Création : Février 2008
//
//borghesi@unistra.fr
//
//Ce logiciel est régi par la licence CeCILL-B soumise au droit français et
//respectant les principes de diffusion des logiciels libres. Vous pouvez
//utiliser, modifier et/ou redistribuer ce programme sous les conditions
//de la licence CeCILL-B telle que diffusée par le CEA, le CNRS et l'INRIA 
//sur le site "http://www.cecill.info".
//
//Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
//pris connaissance de la licence CeCILL-B, et que vous en avez accepté les
//termes. Vous pouvez trouver une copie de la licence dans le fichier LICENCE.
//
//==========================================================================
//
//Université de Strasbourg - Direction Informatique
//Author : Guilhem BORGHESI
//Creation : Feb 2008
//
//borghesi@unistra.fr
//
//This software is governed by the CeCILL-B license under French law and
//abiding by the rules of distribution of free software. You can  use, 
//modify and/ or redistribute the software under the terms of the CeCILL-B
//license as circulated by CEA, CNRS and INRIA at the following URL
//"http://www.cecill.info". 
//
//The fact that you are presently reading this means that you have had
//knowledge of the CeCILL-B license and that you accept its terms. You can
//find a copy of this license in the file LICENSE.
//
//==========================================================================

//le logo
function logo (){
	echo '<div class="logo"><img src="./'.getenv("LOGOBANDEAU").'" height=74 alt=logo></div>'."\n";
}
function sous_logo (){
	echo '<div class="logo"><img src="../'.getenv("LOGOBANDEAU").'" height=74 alt=logo></div>'."\n";
}


#le bandeau principal
function bandeau_tete(){
	echo '<div class="bandeau">'.getenv('NOMAPPLICATION').'</div>'."\n";
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
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'"><input type=submit class=boutonsousbandeau name=exemple value="'.$GLOBALS["tt_bouton_exemple"].'"><input type=submit class=boutonsousbandeau name=contact value="'.$GLOBALS["tt_bouton_contact"].'"><input type=submit class=boutonsousbandeau name=sources value="'.$GLOBALS["tt_bouton_sources"].'"><input type=submit class=boutonsousbandeau name=apropos value="'.$GLOBALS["tt_bouton_apropos"].'"><input type=submit class=boutonsousbandeau name=intranet value="'.$GLOBALS["tt_bouton_intranet"].'"><input type=submit class=boutonsousbandeaulangue name=france value="FR"><input type=submit class=boutonsousbandeaulangue name=espagne value="ES"><input type=submit class=boutonsousbandeaulangue name=germany value="DE"><input type=submit class=boutonsousbandeaulangue name=uk value="EN"></div>'."\n";
}
function sous_bandeau_admin(){
	echo '<div class="sousbandeau"><input type=submit class=boutonsousbandeau name=annuler value="'.$GLOBALS["tt_bouton_accueil"].'"><input type=submit class=boutonsousbandeau name=historique value="'.$GLOBALS["tt_bouton_historique"].'"><input type=submit class=boutonsousbandeau name=nettoyage value="'.$GLOBALS["tt_bouton_nettoyage"].'"><input type=submit class=boutonsousbandeaulangue name=france value="FR"><input type=submit class=boutonsousbandeaulangue name=espagne value="ES"><input type=submit class=boutonsousbandeaulangue name=germany value="DE"><input type=submit class=boutonsousbandeaulangue name=uk value="EN"></div>'."\n";
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
