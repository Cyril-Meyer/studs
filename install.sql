--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN9';
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.user_studs DROP CONSTRAINT user_studs_pkey;
ALTER TABLE ONLY public.sondage DROP CONSTRAINT sondage_pkey;
DROP TABLE public.user_studs;
DROP TABLE public.sujet_studs;
DROP TABLE public.sondage;
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: sondage; Type: TABLE; Schema: public; Owner: borghesi; Tablespace: 
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
-- Name: sujet_studs; Type: TABLE; Schema: public; Owner: borghesi; Tablespace: 
--

CREATE TABLE sujet_studs (
    id_sondage text,
    sujet text
);


--
-- Name: user_studs; Type: TABLE; Schema: public; Owner: borghesi; Tablespace: 
--

CREATE TABLE user_studs (
    nom text,
    id_sondage text,
    reponses text,
    id_users serial NOT NULL
);


--
-- Name: sondage_pkey; Type: CONSTRAINT; Schema: public; Owner: borghesi; Tablespace: 
--

ALTER TABLE ONLY sondage
    ADD CONSTRAINT sondage_pkey PRIMARY KEY (id_sondage);


--
-- Name: user_studs_pkey; Type: CONSTRAINT; Schema: public; Owner: borghesi; Tablespace: 
--

ALTER TABLE ONLY user_studs
    ADD CONSTRAINT user_studs_pkey PRIMARY KEY (id_users);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

