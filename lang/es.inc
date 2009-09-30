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

//Texte des bandeaux
$tt_bandeau_titre='Encuestas para la universidad';
$tt_bandeau_titre_infos='Creaci&oacute;n de encuesta (1 de 2)';
$tt_bandeau_titre_date='Elecci&oacute;n de d&iacute;s (2 de 2)';
$tt_bandeau_titre_autre='Elecci&oacute;n de temas (2 de 2)';
$tt_bandeau_titre_admin='Administrador de la base';
$tt_bandeau_titre_contact='Cont&aacute;ctenos';
$tt_bandeau_titre_erreur='Error!';
$tt_bandeau_titre_apropos='Informaciones generales';
$tt_bandeau_pied='Universit&eacute; de Strasbourg. Creaci&oacute;n: Guilhem BORGHESI. 2008-2009';

//texte des boutons dans sous_bandeau
$tt_bouton_accueil='Inicio';
$tt_bouton_exemple='Ejemplo';
$tt_bouton_contact='Cont&aacute;ctenos';
$tt_bouton_sources='Fuentes';
$tt_bouton_apropos='Acerca de';
$tt_bouton_intranet='Admin';
$tt_bouton_historique='Hist&oacute;rico';
$tt_bouton_nettoyage='Limpieza';
$tt_bouton_retour='Retroceder';

//Texte de index.php
$tt_index_titre='&iquest;Para qu&eacute; sirve STUdS?';
$tt_index_presentation='Hacer encuestas para planificar un evento como una reun&iacute;n de trabajo o una sortida al cine. Sirve de definir la mejora fecha por todos. <br>Usted puede tambi&eacute;n utilizar STUdS para espicificar su preferencia entre pel&iacute;culas, destinos de viaje o cualquier otra selecci&oacute;n.';
$tt_index_bouton='Crear una encuesta';

//texte de infos_sondage.php
$tt_infos_presentation='Usted ha eligiendo de crear une nueva encuesta!<br> Gracias por completar los campos con una *.';
$tt_infos_champ_titre='T&iacute;tulo dela encuesta *: ';
$tt_infos_champ_commentaires='Comentarios : ';
$tt_infos_champ_nom='Su nombre *: ';
$tt_infos_champ_adressemail='Su direcci&oacute;n electr&oacute;nica *: ';
$tt_infos_asterisque='Los campos con una * estan obligatorios!';
$tt_infos_option_modifier=' Los encuentados pueden cambiar su l&iacute;nea ellos mismos.';
$tt_infos_option_mailconfirme=' Usted quiere recibir un correo elect&oacute;nico cada vez que alguien participe a la encuesta.';
$tt_infos_choix_date='Encuesta para planificar un evento';
$tt_infos_choix_autre='Encuesta para otras cosas';
$tt_infos_erreur_titre='Introducza un t&iacute;tulo';
$tt_infos_erreur_nom='Introduzca un nombre';
$tt_infos_erreur_adressemail='Introduzca una direcci&oacute;n electr&oacute;nica';
$tt_infos_erreur_injection='Los caracteres < > y " no estan autorizados!';
$tt_infos_erreur_mauvaise_adressemail='La direcci&oacute;n electr&oacute;nica no est&aacute; correcta! (Introduzca una direcci&oacute;n electr&oacute;nica valida para recibir el enlace de su encuesta)';

//texte de choix_autre.php
$tt_choixautre_presentation='Usted ha eligiendo de crear une nueva encuesta!<br>Introducza las differentes opciones :';
$tt_choixautre_champchoix='Opci&ograve;n';
$tt_choixautre_continuer='Seguir';
$tt_choixautre_ajoutcases='Para a&ntilde;adir 5 campos de texto';
$tt_choixautre_erreurvide='Introduzca por lo menos un campo!';
$tt_choixautre_erreur_injection='Los caracteres " < y > no estan autorizados!';
$tt_choixautre_presentationfin='Su encuesta ser&aacute; automaticamente borrado dentro de 6 meses.<br> Mientras, usted puede cambiar este fecha aqu&iacute;.';
$tt_choixautre_presentationfindate='Fecha de fin (opcional)';
$tt_choixautre_presentationfinformat='(DD/MM/AAAA)';
$tt_choixautre_presentationenvoimail='Cuando Usted confirmar&agrave; la creacion de su encuesta, Usted ser&agrave; automaticamente redigiriendo a la pagina de su encuesta. <br><br>Alora, Usted recibir&agrave; rapidamente uno correo electrinico conteniendo el enlace de su encuesta para darlo a los encuestados.';

$tt_choix_creation='Crear la encuesta';
$tt_choix_page_erreur_titre='Usted no habia llenado la primera pagina dela encuesta';
$tt_choix_page_erreur_retour='Retroceder al inicio de';

//texte de choix_autre.php
$tt_choixdate_presentation='Seleccionar sus fechas entre los d&iacute;as disponibles que aparecen en verde. Cuando son seleccionados los d&iacute;as aparecen en azul.<br> Usted puede egalemente borrar d&iacute;as en seleccionarlos de nuevo.';
$tt_choixdate_titreheure='D&iacute;as seleccionados';
$tt_choixdate_presentationheure='Para alg&uacute;n d&iacute;a que hab&iacute;a seleccionado, Usted puede escoger, o no, de horas de reuni&oacute;n con este formato:<br>- vac&iacute;o,<br>- "8h", "8H" o "8:00" para proponer una hora de principio de reuni&oacute;n,<br>- "8-11", "8h-11h", "8H-11H" o "8:00-11:00" para un hueco,<br>- "8h15-11h15", "8H15-11H15" o "8:15-11:15" para un hueco con minutos.';
$tt_choixdate_titrecolonne='Horario';
$tt_choixdate_erreur_format='Formato incorrecto !';
$tt_choixdate_erreur_choix='Introduzca m&aacute;s posibilidades por la encuesta!';
$tt_choixdate_bouton_effacer_jours='Borrar todos los d&iacute;as';
$tt_choixdate_bouton_reporter='Copiar los horarios del primer d&iacute;a';
$tt_choixdate_bouton_effacer_horaires='Borrar todos los horarios';
$tt_choixdate_continuer='Seguir';
$tt_choixdate_presentationfin='Su encuesta ser&aacute; automaticamente borrado 2 d&iacute;as desp&uacute;es de la &uacute;ltima fecha.';
$tt_choixdate_presentationdatefin='Fecha de borrado';
$tt_choixdate_retour_horaires='Retroceder a los horarios';

//traduction du fichier creation_sondage.php
$tt_creationsondage_titre_mail_sondes='Para enviar a los encuestados';
$tt_creationsondage_corps_sondage='Encuesta';
$tt_creationsondage_corps_debut="Eso es el mensaje que debe estar enviado ahora a los encuestados.";
$tt_creationsondage_corps_milieu='ha creado una encuesta titulado';
$tt_creationsondage_corps_fin='Gracias de llenar esta encuesta al enlace siguiente';
$tt_creationsondage_corps_merci='Gracias por su confianza';
$tt_creationsondage_titre_mail_admin='Reservado al autor';
$tt_creationsondage_corps_admin_debut="Este mensaje no debe estar enviado a los encuestados. Esta reservado al autor dela encuesta STUdS.\n\nUsted ha creado una encuesta STUdS. \nUsted puede editar esta encuesta al enlace siguiente";


//traduction en espagnol des valeurs de mois
$tt_motmois_un="enero";
$tt_motmois_deux="febrero";
$tt_motmois_trois="marzo";
$tt_motmois_quatre="abril";
$tt_motmois_cinq="mayo";
$tt_motmois_six="junio";
$tt_motmois_sept="julio";
$tt_motmois_huit="agosto";
$tt_motmois_neuf="septiembre";
$tt_motmois_dix="octubre";
$tt_motmois_onze="noviembre";
$tt_motmois_douze="diciembre";

//les jours
$tt_motjour_un="lunes";
$tt_motjour_deux="martes";
$tt_motjour_trois="mi&eacute;coles";
$tt_motjour_quatre="jueves";
$tt_motjour_cinq="vienes";
$tt_motjour_six="s&aacute;bado";
$tt_motjour_sept="domingo";

//studs.php
$tt_studs_erreur_titre='Este encuesta no existe!';
$tt_studs_auteur='Autor dela encuesta';
$tt_studs_commentaires='Commentarios';
$tt_studs_presentation='Para participar a esta encuesta, introduzca su nombre, elige todas las valores que son apriopriadas <br>(sin tener en cuenta los otros encuestados) y validar su seleccion con el bot&oacute;n verde a la fin de l&iacute;nea.';
$tt_studs_somme='Suma';
$tt_studs_erreur_nomdeja='El nombre entrado existe ya!';
$tt_studs_erreur_injection='Los caracteres " \' < y > no estan autorizados!';
$tt_studs_a='por';
$tt_studs_erreur_nomvide='Introduzca un nombre!';
$tt_studs_meilleurchoix='El mejor elecci&oacute;n por el momento esta';
$tt_studs_meilleurchoix_pluriel='Los mejores elecciones por el momento estan';
$tt_studs_meilleurchoix_avec='con';
$tt_studs_meilleurchoix_vote='voto';
$tt_studs_export='Exportar : Hoja de c&aacute;lculo';
$tt_studs_agenda='Agenda';
$tt_studs_mail_sujet='Participaci&oacute;n a la encuesta';
$tt_studs_mail_corps='acaba de llenar una l&iacute;nea.\nUsted puede retroceder a su encuesta con el enlace siguiente';
$tt_studs_mail_merci='Gracias por su confianza.';
$tt_studs_ajoutcommentaires='Dejar un comentario en la encuesta';
$tt_studs_ajoutcommentaires_nom='Su nombre';
$tt_studs_ajoutcommentaires_titre='Comentarios';
$tt_studs_commentaires_erreurvide='Introduzca su nombre y un comentario!';

//adminstuds.php
$tt_adminstuds_mail_sujet_ajoutcolonne='[ADMINISTRADOR STUdS] A&ntilde;ado de una nueva columna a la encuesta';
$tt_adminstuds_mail_corps_ajoutcolonne="Usted ha a&ntilde;ado una nueva columna en su encuesta. \nUsted puede informar sus usuarios de este cambio con el enlace siguiente";
$tt_adminstuds_mail_sujet_changetitre='[ADMINISTRADOR STUdS] Cambio del titulo dela encuesta';
$tt_adminstuds_mail_corps_changetitre="Usted ha a&ntilde;ado el titulo de su encuesta. \nUsted puede cambiar su encuesta al enlace siguiente";
$tt_adminstuds_mail_sujet_changecomm='[ADMINISTRADOR STUdS] Cambio des los comentarios dela encuesta';
$tt_adminstuds_mail_corps_changecomm="Usted ha cambiado los commentarios de su encuesta. \nUsted puede cambiar su encuesta al enlace siguiente";
$tt_adminstuds_mail_sujet_changemail='[ADMINISTRADOR STUdS] Cambio de su Direcci&oacute;n electr&oacute;nica';
$tt_adminstuds_mail_corps_changemail="Usted ha cambiado su direcci&oacute;n elestr&oacute;nica. \nUsted puede cambiar su encuesta al enlace siguiente";
$tt_adminstuds_presentation='En calidad de administrador, Usted puede cambiar todas la l&iacute;neas de este encuesta con <img src="images/info.png" alt="Icone infos">.<br> Usted puede tambi&eacute;n borrar una columna o una l&iacute;nea con <img src="images/cancel.png" alt="Annuler">. <br> Usted puede a&ntilde;adir une nueva columna con <img src="images/add-16.png" alt="Annuler"> <br>. Para acabar, Usted puede cambiar las informaciones relativas<br> a su encuesta como el titulo, los comentarios o ademas su direcci&oacute;n electr&oacute;nica.';
$tt_adminstuds_erreur_date='La fecha no esta correcta!';
$tt_adminstuds_gestion_titre='Administraci&oacute;n de su encuesta';
$tt_adminstuds_gestion_chgttitre='Cambiar el titulo dela encuesta';
$tt_adminstuds_gestion_pdf='Producir la letra de convocaci&oacute;n (en PDF), elige un lugar de reuni&oacute;n y valida';
$tt_adminstuds_gestion_erreurpdf='Introduzca un lugar de reuni&oacute;n !';
$tt_adminstuds_gestion_erreurtitre='Introduzca un nuevo titulo!';
$tt_adminstuds_gestion_commentaires='Cambiar los commentarios dela encuesta';
$tt_adminstuds_gestion_adressemail='Cambiar su direcci&oacute;n eletr&oacute;nica';
$tt_adminstuds_gestion_erreurmail='Introduzca una nuva direcci&oacute;n eletr&oacute;nica!';
$tt_adminstuds_gestion_suppressionsondage='Borrar su encuesta';
$tt_adminstuds_gestion_bouton_suppressionsondage='Borrada de encuesta';
$tt_adminstuds_gestion_confirmesuppression='Confirmar la borrada de su encuesta';
$tt_adminstuds_gestion_bouton_confirmesuppression='Borrar este encuesta!';
$tt_adminstuds_gestion_bouton_annulesuppression='Dejar este encuesta!';
$tt_adminstuds_mail_sujet_supprimesondage='[ADMINISTRADOR STUdS] Borrada de su encuesta';
$tt_adminstuds_mail_corps_supprimesondage="Usted ha sido la borrada de su encuesta. \nUsted puede hacer nuevas encuestas al enlace siguiente";
$tt_adminstuds_suppression_titre='Su encuesta ha sido borrado!';
$tt_adminstuds_ajoutcolonne_titre='A&ntilde;adido de columna';
$tt_adminstuds_ajoutcolonne_autre='Para a&ntilde;adir una columna';
$tt_adminstuds_ajoutcolonne_date_presentation='Usted puede a&ntilde;adir una fecha por su encuesta. Si la fecha existe ya y que usted vuele solamente a&ntilde;adire un horario,<br> pone la fecha entera con el nuevo horario o el nuevo hueco y fuera normalemente a&ntilde;ado a la encuesta.';
$tt_adminstuds_ajoutcolonne_date_invit='Para a&ntilde;adir una fecha';
$tt_adminstuds_ajoutcolonne_date_heuredebut='Para a&ntilde;adir un horario de principio (optional)';
$tt_adminstuds_ajoutcolonne_date_heurefin='Para a&ntilde;adir un horario de fin (optional)';

//contacts.php
$tt_contacts_envoimail_titre='Su mensaje ha sido buen expedido!';
$tt_contacts_presentation='Para todas preguntas relativo a STUdS, Usted puede dejar un mensaje con este pagina.';
$tt_contacts_nom='Su nombre';
$tt_contacts_adressemail='Su direcci&oacute;n electr&oacute;nica ';
$tt_contacts_question='Pregunta';
$tt_contacts_bouton_question='Enviar su pregunta';
$tt_contacts_mail_sujet_admin='[CONTACT STUdS] Envia de pregunta';
$tt_contacts_mail_corps_admin='Hay une pregunta de usuario de STUdS.';
$tt_contacts_mail_utilisateur_admin='Usuario';
$tt_contacts_mail_adresse_admin='Direcci&oacute;n electr&oacute;nica del usuario';
$tt_contacts_mail_message_admin='Mensaje';
$tt_contacts_mail_sujet_user='[COPIA] Envia de pregunta';
$tt_contacts_mail_corps_user='Eso es una copia de su pregunta en STUdS';
$tt_contacts_mail_reponse_user='Nos tomaremos en cuenta vuestro mensaje rapidamente.';

//sources.php
$tt_sources_lien='Las <a href="http://sourcesup.cru.fr/frs/?group_id=621">fuentes</a> de STUdS.';

//apropos.php
$tt_apropos_techno='Tecnolog&iacute;as utilisadas';
$tt_apropos_compat='Compatibilitad con los navegadores';
$tt_apropos_validation_titre='Validaci&oacute;n de las paginas';
$tt_apropos_validation='- Todas las paginas de STUdS son validadas HTML 4.01 Strict del W3C. <br>- La CSS de STUdS es validada CSS 2.1 del W3C.';
$tt_apropos_merci_titre='Gracias';
$tt_apropos_merci='- Para sus contribuciones t&eacute;cnicas : Guy, Christophe, Julien y Pierre <br>- Para sus appuertos inovadores : Romaric, Matthieu y Catherine<br>- Para sus ergonomicos apuertos : Christine y Olivier <br>- Para su contribuci&oacute;n material : el D&eacute;partement d\'informatique de l\'Universit&eacute; de Strasbourg';

//admin/index.php
$tt_admin_nbresondage='encuestas en la basa por el momento';
$tt_admin_confirmesuppression='Confirmar el borrado dela encuesta';
$tt_admin_bouton_confirmesuppression='Borrar su encuesta!';
$tt_admin_bouton_annulesuppression='Quedar su encuesta!';
$tt_admin_colonne_id='ID encuesta';
$tt_admin_colonne_format='Formato';
$tt_admin_colonne_titre='Titulo';
$tt_admin_colonne_auteur='Autor';
$tt_admin_colonne_datefin='Fecha de fin';
$tt_admin_colonne_nbreuser='Usuarios';
$tt_admin_colonne_actions='Acciones';
$tt_admin_lien_voir='Ver la encuesta';
$tt_admin_lien_modifier='Cambiar la encuesta';
$tt_admin_bouton_supprimer='Borrar la encuesta';

?>
