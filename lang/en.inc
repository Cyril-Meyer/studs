<?php

//Texte des bandeaux
$tt_bandeau_titre='Make your polls.';
$tt_bandeau_titre_infos='Poll creation (1 on 2)';
$tt_bandeau_titre_date='Poll dates (2 on 2)';
$tt_bandeau_titre_autre='Poll subjects (2 on 2)';
$tt_bandeau_titre_admin='Polls administrator';
$tt_bandeau_titre_contact='Contact us';
$tt_bandeau_titre_erreur='Error !';
$tt_bandeau_titre_apropos='A propos';
$tt_bandeau_pied='Universit&eacute; de Strasbourg. Creation : Guilhem BORGHESI. 2008-2009';

//texte des boutons dans sous_bandeau
$tt_bouton_accueil='Home';
$tt_bouton_exemple='Example';
$tt_bouton_contact='Contact';
$tt_bouton_sources='Sources';
$tt_bouton_apropos='A propos';
$tt_bouton_intranet='Admin';
$tt_bouton_historique='Logs';
$tt_bouton_retour='Back';

//Texte de index.php
$tt_index_titre='What is STUdS about ?';
$tt_index_presentation='Making polls for scheduling meetings or events quickly and easily. <br> You can as well make polls to determine what will be your meeting place, the meeting subjects or something like the country of your next holidays.';
$tt_index_bouton='Make a poll';

//texte de infos_sondage.php
$tt_infos_presentation='You are in the poll creation section. <br> Require fields cannot be left blank';
$tt_infos_champ_titre='Poll title * : ';
$tt_infos_champ_commentaires='Comments : ';
$tt_infos_champ_nom='Your name * : ';
$tt_infos_champ_adressemail='Your e-mail address * : ';
$tt_infos_asterisque='The fields marked with * are required !';
$tt_infos_option_modifier=' The voters can modify themself their vote.';
$tt_infos_option_mailconfirme=' You want to receive an email for each new vote.';
$tt_infos_choix_date='Schedule an event';
$tt_infos_choix_autre='Make a choice';
$tt_infos_erreur_titre='Enter a title';
$tt_infos_erreur_nom='Enter a name';
$tt_infos_erreur_adressemail='Enter an email address';
$tt_infos_erreur_injection='Characters < and > are not permitted';
$tt_infos_erreur_mauvaise_adressemail='The address is not correct ! (You should enter a valid email address in order to receive the link to your poll)';

//texte de choix_autre.php
$tt_choixautre_presentation='You have chosen to make a poll to make a choice between some subjects.<br>Enter the differents subjects to vote for :';
$tt_choixautre_champchoix='Choice';
$tt_choixautre_continuer='Next';
$tt_choixautre_ajoutcases='5 choices more';
$tt_choixautre_erreurvide='Enter at least one choice';
$tt_choixautre_erreur_injection='Characters \", < and > are not permitted';
$tt_choixautre_presentationfin='Your poll will be automatically removed in 6 months.<br> But you can fixed another destruction\'s date for it.';
$tt_choixautre_presentationfindate='Destruction date (optionnal)';
$tt_choixautre_presentationfinformat='(DD/MM/YYYY)';

$tt_choix_creation='Create the poll';
$tt_choix_page_erreur_titre='You haven\'t filled the first section of the poll creation.';
$tt_choix_page_erreur_retour='Back to the homepage of ';

//texte de choix_autre.php
$tt_choixdate_presentation='Select your dates amoung the free days (green). The selected days are in blue.<br> You can unselect a day previously selected by clicking again on it.';
$tt_choixdate_titreheure='Selected days';
$tt_choixdate_presentationheure='For each selected day, you can choose, or not, meeting hours in this format :<br>- empty,<br>- "8h", "8H" or "8:00" to give a meeting\'s start hour,<br>- "8-11", "8h-11h", "8H-11H" ou "8:00-11:00" to give a meeting\'s start and end hour,<br>- "8h15-11h15", "8H15-11H15" ou "8:15-11:15" for the same thing but with minutes.';
$tt_choixdate_titrecolonne='Time';
$tt_choixdate_erreur_format='Bad format !';
$tt_choixdate_erreur_choix='Enter more choices for the voters';
$tt_choixdate_bouton_effacer_jours='Remove all days';
$tt_choixdate_bouton_reporter='Copy hours of the first day';
$tt_choixdate_bouton_effacer_horaires='Remove all hours';
$tt_choixdate_continuer='Next';
$tt_choixdate_presentationfin='Your poll will be automatically removed 2 days after the last date of your poll.';
$tt_choixdate_presentationdatefin='Destruction\'s date';
$tt_choixdate_retour_horaires='Back to hours';

//traduction en francais ecrit des valeurs de mois
$tt_motmois_un="january";
$tt_motmois_deux="february";
$tt_motmois_trois="march";
$tt_motmois_quatre="april";
$tt_motmois_cinq="may";
$tt_motmois_six="june";
$tt_motmois_sept="july";
$tt_motmois_huit="august";
$tt_motmois_neuf="september";
$tt_motmois_dix="october";
$tt_motmois_onze="november";
$tt_motmois_douze="december";

//les jours
$tt_motjour_un="monday";
$tt_motjour_deux="tuesday";
$tt_motjour_trois="wednesday";
$tt_motjour_quatre="thursday";
$tt_motjour_cinq="friday";
$tt_motjour_six="saturday";
$tt_motjour_sept="sunday";

//studs.php
$tt_studs_erreur_titre='This poll doesn\'t exist !';
$tt_studs_auteur='Author of the poll';
$tt_studs_commentaires='Comments';
$tt_studs_presentation='If you want to vote in this poll, you have to give your name, choose between all the values the ones that are correct for you <br>(without paying attention to the choices of the others) and validate with the plus button at the end of the line.';
$tt_studs_somme='Addition';
$tt_studs_erreur_nomdeja='The name you\'ve chosed already exist in this poll !';
$tt_studs_erreur_injection='Characters "  \'  < et > are not permitted';
$tt_studs_a='for';
$tt_studs_erreur_nomvide='Enter a name !';
$tt_studs_meilleurchoix='The best choice for the moment is';
$tt_studs_meilleurchoix_pluriel='The bests choices for the moment are';
$tt_studs_meilleurchoix_avec='with';
$tt_studs_meilleurchoix_vote='vote';
$tt_studs_export='Export : Spreadsheet';
$tt_studs_agenda='Diary';
$tt_studs_mail_sujet='Poll\'s participation';
$tt_studs_mail_corps='has filled a line.\nYou can find your poll at the link';
$tt_studs_mail_merci='Thanks for your confidence.';

//adminstuds.php
$tt_adminstuds_mail_sujet_ajoutcolonne='[STUdS ADMINISTRATOR] New column in your poll';
$tt_adminstuds_mail_corps_ajoutcolonne="You have added a new column in your poll. \nYou can inform the voters of this change with this link";
$tt_adminstuds_mail_sujet_changetitre='[ADMINISTRATEUR STUdS] Changement du titre du sondage avec STUdS';
$tt_adminstuds_mail_corps_changetitre="Vous avez fait la modification du titre de votre sondage sur STUdS. \nVous pouvez modifier ce sondage au lien suivant";
$tt_adminstuds_mail_sujet_changecomm='[ADMINISTRATEUR STUdS] Changement des commentaires du sondage avec STUdS';
$tt_adminstuds_mail_corps_changecomm="Vous avez fait la modification des commentaires de votre sondage sur STUdS. \nVous pouvez modifier ce sondage au lien suivant";
$tt_adminstuds_mail_sujet_changemail='[ADMINISTRATEUR STUdS] Changement d\'adresse électronique de l\'administrateur avec STUdS';
$tt_adminstuds_mail_corps_changemail="Vous avez fait la modification de votre adresse mail sur STUdS. \nVous pouvez modifier ce sondage au lien suivant";
$tt_adminstuds_presentation='En tant qu\'administrateur, vous pouvez modifier toutes les lignes de ce sondage avec <img src="images/info.png" alt="Icone infos">.<br> Vous avez aussi la possibilit&eacute; d\'effacer une colonne ou une ligne avec <img src="images/cancel.png" alt="Annuler">. <br>Si vous avez oubli&eacute; de mettre un choix vous pouvez rajouter une colonne en cliquant sur <img src="images/add-16.png" alt="Annuler"> <br> en bout de ligne des noms de colonne. Vous pouvez enfin &eacute;galement modifier les informations <br>relatives &agrave; ce sondage comme le titre, les commentaires ou encore votre adresse &eacute;lectronique.';
$tt_adminstuds_erreur_date='La date choisie n\'est pas correcte !';
$tt_adminstuds_gestion_titre='Gestion de votre sondage';
$tt_adminstuds_gestion_chgttitre='Si vous souhaitez changer le titre du sondage';
$tt_adminstuds_gestion_pdf='Si vous souhaitez produire la lettre de convocation (en PDF), choississez un lieu de r&eacute;union et validez';
$tt_adminstuds_gestion_erreurpdf='Veuillez entrer un lieu de r&eacute;union !';
$tt_adminstuds_gestion_erreurtitre='Veuillez entrer un nouveau titre !';
$tt_adminstuds_gestion_commentaires='Si vous souhaitez changer les commentaires du sondage';
$tt_adminstuds_gestion_adressemail='Si vous souhaitez changer votre adresse de courrier &eacute;lectronique';
$tt_adminstuds_gestion_erreurmail='Veuillez une nouvelle adresse !';
$tt_adminstuds_gestion_suppressionsondage='Si vous souhaitez supprimer votre sondage';
$tt_adminstuds_gestion_bouton_suppressionsondage='Suppression du sondage';
$tt_adminstuds_gestion_confirmesuppression='Confirmer la suppression de votre sondage';
$tt_adminstuds_gestion_bouton_confirmesuppression='Je supprime ce sondage !';
$tt_adminstuds_gestion_bouton_annulesuppression='Je garde ce sondage !';
$tt_adminstuds_mail_sujet_supprimesondage='[ADMINISTRATEUR STUdS] Suppression de sondage avec STUdS';
$tt_adminstuds_mail_corps_supprimesondage="Vous avez fait la suppression d'un sondage sur STUdS. \nVous pouvez faire de nouveaux sondages au lien suivant";
$tt_adminstuds_suppression_titre='Votre sondage a &eacute;t&eacute; supprim&eacute; !';
$tt_adminstuds_ajoutcolonne_titre='Ajout de colonne';
$tt_adminstuds_ajoutcolonne_autre='Si vous souhaitez ajouter une colonne';
$tt_adminstuds_ajoutcolonne_date_presentation='Vous pouvez ajouter une date &agrave; votre sondage. Si la date existe d&eacute;j&agrave; et que vous ne voulez que rajouter un horaire,<br> mettez le jour en entier avec l\'horaire ou le cr&eacute;neau suppl&eacute;mentaire il sera int&eacute;gr&eacute; normalement au sondage existant.';
$tt_adminstuds_ajoutcolonne_date_invit='Pour ajouter une date';
$tt_adminstuds_ajoutcolonne_date_heuredebut='Pour ajouter un horaire de d&eacute;but (optionnel)';
$tt_adminstuds_ajoutcolonne_date_heurefin='Pour ajouter un horaire de fin (optionnel)';

//contacts.php
$tt_contacts_envoimail_titre='Votre message a bien &eacute;t&eacute; envoy&eacute; !';
$tt_contacts_presentation='Pour toutes questions ou suggestions relatives &agrave; STUdS vous pouvez laisser un message via ce formulaire.';
$tt_contacts_nom='Votre nom';
$tt_contacts_adressemail='Votre adresse (facultative)';
$tt_contacts_question='Question';
$tt_contacts_bouton_question='Envoyer votre question';
$tt_contacts_mail_sujet_admin='[CONTACT STUdS] Envoi de question STUdS';
$tt_contacts_mail_corps_admin='Vous avez une question d\'utilisateur de STUdS.';
$tt_contacts_mail_utilisateur_admin='Utilisateur';
$tt_contacts_mail_adresse_admin='Adresse utilisateur';
$tt_contacts_mail_message_admin='Message';
$tt_contacts_mail_sujet_user='[COPIE] Envoi de question STUdS';
$tt_contacts_mail_corps_user='Voici une copie de votre question dans STUdS';
$tt_contacts_mail_reponse_user='Nous allons prendre en compte votre message rapidement.';

//sources.php
$tt_sources_lien='Here are the <a href=\"studs.tar.gz\" target=_new>sources</a> of STUdS.';

//apropos.php
$tt_apropos_techno='Technologies utilis&eacute;es';
$tt_apropos_compat='Compatibilit&eacute;s des navigateurs';
$tt_apropos_validation_titre='Validations des pages';
$tt_apropos_validation='- Toutes les pages de STUdS disposent de la validation HTML 4.01 Strict du W3C. <br>- La CSS de STUdS dispose de la validation CSS 2.1 du W3C.';
$tt_apropos_merci_titre='Remerciements';
$tt_apropos_merci='- Pour leurs contributions techniques : Guy, Christophe, Julien et Pierre <br>- Pour leurs apports innovants : Romaric, Matthieu et Catherine<br>- Pour leurs am&eacute;liorations ergonomiques : Christine et Olivier <br>- Pour sa contribution mat&eacute;rielle : le D&eacute;partement d\'informatique de l\'Universit&eacute; de Strasbourg';

//admin/index.php
$tt_admin_nbresondage='sondages dans la base actuellement';
$tt_admin_confirmesuppression='Confirmer la suppression du sondage ';
$tt_admin_bouton_confirmesuppression='Je supprime ce sondage !';
$tt_admin_bouton_annulesuppression='Je garde ce sondage !';
$tt_admin_colonne_id='ID sondage';
$tt_admin_colonne_format='Format';
$tt_admin_colonne_titre='Titre';
$tt_admin_colonne_auteur='Auteur';
$tt_admin_colonne_datefin='Date d\'expiration';
$tt_admin_colonne_nbreuser='Nombre d\'utilisateurs';
$tt_admin_colonne_actions='Actions';
$tt_admin_lien_voir='Voir le sondage';
$tt_admin_lien_modifier='Modifier le sondage';
$tt_admin_bouton_supprimer='Supprimer le sondage';

?>
