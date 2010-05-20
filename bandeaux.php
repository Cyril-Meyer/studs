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
	echo '<div class="bandeautitre">'. _("Make your polls") .'</div>'."\n";
}
function bandeau_titre_infos(){
	echo '<div class="bandeautitre">'. _("Poll creation (1 on 2)") .'</div>'."\n";
}
function bandeau_titre_date(){
	echo '<div class="bandeautitre">'. _("Poll dates (2 on 2)") .'</div>'."\n";
}
function bandeau_titre_autre(){
	echo '<div class="bandeautitre">'. _("Poll subjects (2 on 2)") .'</div>'."\n";
}
function bandeau_titre_admin(){
	echo '<div class="bandeautitre">'. _("Polls administrator") .'</div>'."\n";
}
function bandeau_titre_contact(){
	echo '<div class="bandeautitre">'. _("Contact us") .'</div>'."\n";
}
function bandeau_titre_version(){
	echo '<div class="bandeautitre">'.$GLOBALS["tt_bandeau_titre_version"].'</div>'."\n";
}
function bandeau_titre_erreur(){
	echo '<div class="bandeautitre">'. _("Error!") .'</div>'."\n";
}
function bandeau_titre_apropos(){
	echo '<div class="bandeautitre">'. _("About") .'</div>'."\n";
}

function liste_lang() {
  global $ALLOWED_LANGUAGES;
  $str = '';
  foreach ($ALLOWED_LANGUAGES as $k => $v )
    $str .= '<a href="?lang=' . $k . '" class="boutonsousbandeaulangue" >' . $v . '</a>' . "\n" ;
  return $str;
}

#Les sous-bandeaux contenant les boutons de navigation
function sous_bandeau(){
  echo '<div class="sousbandeau">' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/index.php">'. _("Home") .'</a>' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/studs.php?sondage=aqg259dth55iuhwm">'. _("Example") .'</a>' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/contacts.php">'. _("Contact") .'</a>' .
    //'<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/sources/sources.php">'. _("Sources") .'</a>' . //not implemented
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/apropos.php">'. _("About") .'</a>' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/admin/index.php">'. _("Admin") .'</a>' .
    liste_lang() . '</div>'."\n";
}
function sous_bandeau_admin(){
  echo '<div class="sousbandeau">' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/index.php">'. _("Home") .'</a>' .
    '<input type=submit class=boutonsousbandeau name=historique value="'. _("Logs") .'">' .
    '<input type=submit class=boutonsousbandeau name=nettoyage value="'. _("Cleaning") .'">' . liste_lang() .'</div>'."\n";
}
function sous_bandeau_choix(){
  echo '<div class="sousbandeau">' .
    '<a class="boutonsousbandeau" href="' . STUDS_URL. '/' . STUDS_DIR . '/index.php">'. _("Home") .'</a>' .
    '<input type=submit class=boutonsousbandeau name=retour value="'. _("Back") .'">' .
    '</div>'."\n";
}


#les bandeaux de pied
function sur_bandeau_pied(){
	echo '<div class="surbandeaupied"></div>'."\n";
}
function bandeau_pied(){
	echo '<div class="bandeaupied">'. _("Universit&eacute; de Strasbourg. Creation: Guilhem BORGHESI. 2008-2009") .'</div>'."\n";
}
function sur_bandeau_pied_mobile(){
	echo '<div class="surbandeaupiedmobile"></div>'."\n";
}
function bandeau_pied_mobile(){
	echo '<div class="bandeaupiedmobile">'. _("Universit&eacute; de Strasbourg. Creation: Guilhem BORGHESI. 2008-2009") .'</div>'."\n";
}



?>
