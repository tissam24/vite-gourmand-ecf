--
-- PostgreSQL database dump
--

\restrict 7ZZfuT8fXwjoKkqTb4Bpez5g1xCkXidVdkWgGiWLe7ZzM01GuZKWqX0RTS0bnBf

-- Dumped from database version 16.13 (Homebrew)
-- Dumped by pg_dump version 18.2

-- Started on 2026-05-21 15:42:55 CEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 220 (class 1259 OID 16414)
-- Name: menus; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.menus (
    id integer NOT NULL,
    title character varying(150) NOT NULL,
    description text,
    theme character varying(100),
    regime character varying(100),
    min_people integer NOT NULL,
    price numeric(10,2) NOT NULL,
    stock integer DEFAULT 0,
    conditions text,
    image character varying(255)
);


ALTER TABLE public.menus OWNER TO tissam;

--
-- TOC entry 219 (class 1259 OID 16413)
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.menus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO tissam;

--
-- TOC entry 3879 (class 0 OID 0)
-- Dependencies: 219
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- TOC entry 226 (class 1259 OID 16467)
-- Name: opening_hours; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.opening_hours (
    id integer NOT NULL,
    day_name character varying(50),
    hours character varying(100)
);


ALTER TABLE public.opening_hours OWNER TO tissam;

--
-- TOC entry 225 (class 1259 OID 16466)
-- Name: opening_hours_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.opening_hours_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.opening_hours_id_seq OWNER TO tissam;

--
-- TOC entry 3880 (class 0 OID 0)
-- Dependencies: 225
-- Name: opening_hours_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.opening_hours_id_seq OWNED BY public.opening_hours.id;


--
-- TOC entry 222 (class 1259 OID 16424)
-- Name: orders; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    user_id integer,
    menu_id integer,
    status character varying(100) DEFAULT 'en attente'::character varying,
    delivery_address text,
    delivery_date date,
    total_price numeric(10,2),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    email character varying(255),
    phone character varying(50),
    address text,
    event_date date,
    comment text,
    event_time time without time zone,
    people integer,
    cancel_method character varying(50),
    cancel_reason text,
    contact_method character varying(50)
);


ALTER TABLE public.orders OWNER TO tissam;

--
-- TOC entry 221 (class 1259 OID 16423)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO tissam;

--
-- TOC entry 3881 (class 0 OID 0)
-- Dependencies: 221
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 224 (class 1259 OID 16445)
-- Name: reviews; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.reviews (
    id integer NOT NULL,
    user_id integer,
    order_id integer,
    rating integer,
    comment text,
    validated boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reviews_rating_check CHECK (((rating >= 1) AND (rating <= 5)))
);


ALTER TABLE public.reviews OWNER TO tissam;

--
-- TOC entry 223 (class 1259 OID 16444)
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reviews_id_seq OWNER TO tissam;

--
-- TOC entry 3882 (class 0 OID 0)
-- Dependencies: 223
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- TOC entry 216 (class 1259 OID 16390)
-- Name: roles; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);


ALTER TABLE public.roles OWNER TO tissam;

--
-- TOC entry 215 (class 1259 OID 16389)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO tissam;

--
-- TOC entry 3883 (class 0 OID 0)
-- Dependencies: 215
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 218 (class 1259 OID 16397)
-- Name: users; Type: TABLE; Schema: public; Owner: tissam
--

CREATE TABLE public.users (
    id integer NOT NULL,
    firstname character varying(100) NOT NULL,
    lastname character varying(100) NOT NULL,
    email character varying(150) NOT NULL,
    password character varying(255) NOT NULL,
    phone character varying(20),
    address text,
    role_id integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    is_active boolean DEFAULT true,
    reset_token character varying(255),
    reset_expires timestamp without time zone
);


ALTER TABLE public.users OWNER TO tissam;

--
-- TOC entry 217 (class 1259 OID 16396)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: tissam
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO tissam;

--
-- TOC entry 3884 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tissam
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3702 (class 2604 OID 16417)
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- TOC entry 3710 (class 2604 OID 16470)
-- Name: opening_hours id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.opening_hours ALTER COLUMN id SET DEFAULT nextval('public.opening_hours_id_seq'::regclass);


--
-- TOC entry 3704 (class 2604 OID 16427)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 3707 (class 2604 OID 16448)
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- TOC entry 3698 (class 2604 OID 16393)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 3699 (class 2604 OID 16400)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3719 (class 2606 OID 16422)
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- TOC entry 3725 (class 2606 OID 16472)
-- Name: opening_hours opening_hours_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.opening_hours
    ADD CONSTRAINT opening_hours_pkey PRIMARY KEY (id);


--
-- TOC entry 3721 (class 2606 OID 16433)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 3723 (class 2606 OID 16455)
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 3713 (class 2606 OID 16395)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 3715 (class 2606 OID 16407)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3717 (class 2606 OID 16405)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3727 (class 2606 OID 16439)
-- Name: orders orders_menu_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES public.menus(id);


--
-- TOC entry 3728 (class 2606 OID 16434)
-- Name: orders orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3729 (class 2606 OID 16461)
-- Name: reviews reviews_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id);


--
-- TOC entry 3730 (class 2606 OID 16456)
-- Name: reviews reviews_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 3726 (class 2606 OID 16408)
-- Name: users users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: tissam
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(id);


-- Completed on 2026-05-21 15:42:55 CEST

--
-- PostgreSQL database dump complete
--

\unrestrict 7ZZfuT8fXwjoKkqTb4Bpez5g1xCkXidVdkWgGiWLe7ZzM01GuZKWqX0RTS0bnBf

