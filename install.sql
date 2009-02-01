--
-- PostgreSQL database dump
--

--
-- Name: sondage; Type: TABLE;
--

CREATE TABLE sondage (
    id_sondage text NOT NULL,
    commentaires text,
    mail_admin text,
    nom_admin text,
    titre text,
    id_sondage_admin text,
    date_fin text,
    format text,
    mailsonde text
);


--
-- Name: sujet_studs; Type: TABLE;
--

CREATE TABLE sujet_studs (
    id_sondage text,
    sujet text
);


--
-- Name: user_studs; Type: TABLE;
--

CREATE TABLE user_studs (
    nom text,
    id_sondage text,
    reponses text,
    id_users serial NOT NULL
);


--
-- Data for Name: sondage; Type: TABLE DATA;
--

COPY sondage (id_sondage, commentaires, mail_admin, nom_admin, titre, id_sondage_admin, date_fin, format, mailsonde) FROM stdin;
aqg259dth55iuhwm	Repas de Noel du service	Stephanie@saillard.com	Stephanie	Repas de Noel	aqg259dth55iuhwmy9d8jlwk	1327100361	D+	
\.


--
-- Data for Name: sujet_studs; Type: TABLE DATA;
--

COPY sujet_studs (id_sondage, sujet) FROM stdin;
aqg259dth55iuhwm	1225839600@12h,1225839600@19h,1226012400@12h,1226012400@19h,1226876400@12h,1226876400@19h,1227049200@12h,1227049200@19h,1227826800@12h,1227826800@19h
\.


--
-- Data for Name: user_studs; Type: TABLE DATA;
--

COPY user_studs (nom, id_sondage, reponses, id_users) FROM stdin;
marcel	aqg259dth55iuhwm	0110111101	933
paul	aqg259dth55iuhwm	1011010111	935
sophie	aqg259dth55iuhwm	1110110000	945
barack	aqg259dth55iuhwm	0110000	948
takashi	aqg259dth55iuhwm	0000110100	951
albert	aqg259dth55iuhwm	1010110	975
alfred	aqg259dth55iuhwm	0110010	1135
marcs	aqg259dth55iuhwm	0100001010	1143
laure	aqg259dth55iuhwm	0011000	1347
benda	aqg259dth55iuhwm	1101101100	1667
Albert	aqg259dth55iuhwm	1111110011	1668
\.


--
-- Name: sondage_pkey; Type: CONSTRAINT;
--

ALTER TABLE ONLY sondage
    ADD CONSTRAINT sondage_pkey PRIMARY KEY (id_sondage);


--
-- Name: user_studs_pkey; Type: CONSTRAINT;
--

ALTER TABLE ONLY user_studs
    ADD CONSTRAINT user_studs_pkey PRIMARY KEY (id_users);

