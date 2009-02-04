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
$tt_adminstuds_mail_sujet_ajoutcolonne='[STUdS ADMINISTRATOR] New column for your poll';
$tt_adminstuds_mail_corps_ajoutcolonne="You have added a new column in your poll. \nYou can inform the voters of this change with this link";
$tt_adminstuds_mail_sujet_changetitre='[STUdS ADMINISTRATOR] New title for your poll';
$tt_adminstuds_mail_corps_changetitre="You have changed the title of your poll. \nYou can modify this poll with this link";
$tt_adminstuds_mail_sujet_changecomm='[STUdS ADMINISTRATOR] New comments for your poll';
$tt_adminstuds_mail_corps_changecomm="You have changed the comments of your poll. \nYou can modify this poll with this link";
$tt_adminstuds_mail_sujet_changemail='[STUdS ADMINISTRATOR] New email address for your poll';
$tt_adminstuds_mail_corps_changemail="You have changed your email address in your poll. \nYou van modify this poll with this link";
$tt_adminstuds_presentation='As poll administrator, you can change all the lines of this poll with <img src="images/info.png" alt="Icone infos">.<br> You can, as well, remove a column or a line with <img src="images/cancel.png" alt="Annuler">. <br>You can also add a new column with <img src="images/add-16.png" alt="Ajouter colonne">.<br> Finally, you can change the informations of this poll like the title, the comments or your email address.';
$tt_adminstuds_erreur_date='The date is not correct !';
$tt_adminstuds_gestion_titre='Poll\'s management';
$tt_adminstuds_gestion_chgttitre='Change the title';
$tt_adminstuds_gestion_pdf='Make the convocation letter (.PDF), choose the place to meet and validate';
$tt_adminstuds_gestion_erreurpdf='Enter a meeting place !';
$tt_adminstuds_gestion_erreurtitre='Enter a new title !';
$tt_adminstuds_gestion_commentaires='Change the comments';
$tt_adminstuds_gestion_adressemail='Change your email address';
$tt_adminstuds_gestion_erreurmail='Enter a new email address !';
$tt_adminstuds_gestion_suppressionsondage='Remove your poll';
$tt_adminstuds_gestion_bouton_suppressionsondage='Removing of your poll';
$tt_adminstuds_gestion_confirmesuppression='Validate the removing of your poll';
$tt_adminstuds_gestion_bouton_confirmesuppression='I remove this poll !';
$tt_adminstuds_gestion_bouton_annulesuppression='I keep this poll !';
$tt_adminstuds_mail_sujet_supprimesondage='[STUdS ADMINISTRATOR] Removing of your poll';
$tt_adminstuds_mail_corps_supprimesondage="You have removed your poll. \nYou can make new polls with this link";
$tt_adminstuds_suppression_titre='Your poll has been removed !';
$tt_adminstuds_ajoutcolonne_titre='Column\'s adding';
$tt_adminstuds_ajoutcolonne_autre='Add a new column';
$tt_adminstuds_ajoutcolonne_date_presentation='You can add a new scheduling date at your poll.<br> If you just want to add a new hour to an existant date, put the same date and choose a new hour.';
$tt_adminstuds_ajoutcolonne_date_invit='Add a date';
$tt_adminstuds_ajoutcolonne_date_heuredebut='Add a start hour (optional)';
$tt_adminstuds_ajoutcolonne_date_heurefin='Add a end hour (optional)';

//contacts.php
$tt_contacts_envoimail_titre='Your message has been sent !';
$tt_contacts_presentation='If you have questions about STUdS, you can send a message here.';
$tt_contacts_nom='Your name';
$tt_contacts_adressemail='Your email address (optional)';
$tt_contacts_question='Question';
$tt_contacts_bouton_question='Send your question';
$tt_contacts_mail_sujet_admin='[STUdS CONTACT] You have send a question';
$tt_contacts_mail_corps_admin='You have a question from a user.';
$tt_contacts_mail_utilisateur_admin='User';
$tt_contacts_mail_adresse_admin='User\'s email address';
$tt_contacts_mail_message_admin='Message';
$tt_contacts_mail_sujet_user='[COPY] Someone has sent a question';
$tt_contacts_mail_corps_user='Here is a copy of your question';
$tt_contacts_mail_reponse_user='We\'re going to answer your question shortly.';

//sources.php
$tt_sources_lien='Here are the <a href=\"studs.tar.gz\" target=_new>sources</a> of STUdS.';

//apropos.php
$tt_apropos_techno='Softwares inside';
$tt_apropos_compat='Browser compatibility';
$tt_apropos_validation_titre='HTML validation';
$tt_apropos_validation='- Every pages of STUdS are validate with the W3C HTML 4.01 Strict specification. <br>- The CSS of STUdS is validate with the W3C CSS 2.1 specification.';
$tt_apropos_merci_titre='Thanks';
$tt_apropos_merci='- For thier technical contributions : Guy, Christophe, Julien and Pierre <br>- For their innovating contributions : Romaric, Matthieu and Catherine<br>- For their ergonomics suggestions : Christine and Olivier <br>- For its material contribution : the D&eacute;partement d\'informatique of the Universit&eacute; de Strasbourg';

//admin/index.php
$tt_admin_nbresondage='polls in the database for the moment';
$tt_admin_confirmesuppression='Validate the removing of the poll ';
$tt_admin_bouton_confirmesuppression='I remove this poll !';
$tt_admin_bouton_annulesuppression='I keep this poll !';
$tt_admin_colonne_id='Poll ID';
$tt_admin_colonne_format='Format';
$tt_admin_colonne_titre='Title';
$tt_admin_colonne_auteur='Author';
$tt_admin_colonne_datefin='Expiration\'s date';
$tt_admin_colonne_nbreuser='Users';
$tt_admin_colonne_actions='Actions';
$tt_admin_lien_voir='See the poll';
$tt_admin_lien_modifier='Change the poll';
$tt_admin_bouton_supprimer='Remove the poll';

?>
