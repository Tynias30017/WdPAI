--
-- PostgreSQL database dump
--

\restrict 4t9u5nUlmf8byYxwGcwCOKz75gK3bJGrLQO1NBax2Ste8i38wnpW9XQFTmjYY4V

-- Dumped from database version 15.18
-- Dumped by pg_dump version 15.18

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: determine_weight_category(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.determine_weight_category() RETURNS trigger
    LANGUAGE plpgsql
    AS $$ DECLARE cat_id integer; BEGIN SELECT id INTO cat_id FROM weight_categories WHERE max_weight >= NEW.body_weight ORDER BY max_weight ASC LIMIT 1; IF cat_id IS NULL THEN SELECT id INTO cat_id FROM weight_categories ORDER BY max_weight DESC LIMIT 1; END IF; NEW.weight_category_id := cat_id; RETURN NEW; END; $$;


ALTER FUNCTION public.determine_weight_category() OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: exercises; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.exercises (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.exercises OWNER TO root;

--
-- Name: user_profiles; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.user_profiles (
    user_id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    gender character varying(10),
    body_weight numeric(5,2),
    weight_category_id integer
);


ALTER TABLE public.user_profiles OWNER TO root;

--
-- Name: users; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password_hash character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    role character varying(50) DEFAULT 'user'::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO root;

--
-- Name: workout_sets; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.workout_sets (
    id integer NOT NULL,
    workout_id integer NOT NULL,
    exercise_id integer NOT NULL,
    weight numeric(6,2) NOT NULL,
    reps integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.workout_sets OWNER TO root;

--
-- Name: workouts; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.workouts (
    id integer NOT NULL,
    user_id integer NOT NULL,
    workout_date date NOT NULL,
    notes text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.workouts OWNER TO root;

--
-- Name: exercise_records; Type: VIEW; Schema: public; Owner: root
--

CREATE VIEW public.exercise_records AS
 SELECT u.id AS user_id,
    u.email,
    up.first_name,
    up.last_name,
    e.id AS exercise_id,
    e.name AS exercise_name,
    max(ws.weight) AS personal_record
   FROM ((((public.users u
     JOIN public.user_profiles up ON ((u.id = up.user_id)))
     JOIN public.workouts w ON ((u.id = w.user_id)))
     JOIN public.workout_sets ws ON ((w.id = ws.workout_id)))
     JOIN public.exercises e ON ((ws.exercise_id = e.id)))
  GROUP BY u.id, u.email, up.first_name, up.last_name, e.id, e.name;


ALTER TABLE public.exercise_records OWNER TO root;

--
-- Name: exercises_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.exercises_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.exercises_id_seq OWNER TO root;

--
-- Name: exercises_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.exercises_id_seq OWNED BY public.exercises.id;


--
-- Name: weight_categories; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.weight_categories (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    max_weight numeric(5,2) NOT NULL
);


ALTER TABLE public.weight_categories OWNER TO root;

--
-- Name: user_training_stats; Type: VIEW; Schema: public; Owner: root
--

CREATE VIEW public.user_training_stats AS
 SELECT u.id AS user_id,
    u.email,
    up.first_name,
    up.last_name,
    up.body_weight,
    wc.name AS weight_category_name,
    count(DISTINCT w.id) AS total_workouts,
    COALESCE(sum((ws.weight * (ws.reps)::numeric)), (0)::numeric) AS total_volume,
    COALESCE(max(ws.weight), (0)::numeric) AS max_weight_lifted
   FROM ((((public.users u
     LEFT JOIN public.user_profiles up ON ((u.id = up.user_id)))
     LEFT JOIN public.weight_categories wc ON ((up.weight_category_id = wc.id)))
     LEFT JOIN public.workouts w ON ((u.id = w.user_id)))
     LEFT JOIN public.workout_sets ws ON ((w.id = ws.workout_id)))
  GROUP BY u.id, u.email, up.first_name, up.last_name, up.body_weight, wc.name;


ALTER TABLE public.user_training_stats OWNER TO root;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO root;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: weight_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.weight_categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.weight_categories_id_seq OWNER TO root;

--
-- Name: weight_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.weight_categories_id_seq OWNED BY public.weight_categories.id;


--
-- Name: workout_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.workout_sets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.workout_sets_id_seq OWNER TO root;

--
-- Name: workout_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.workout_sets_id_seq OWNED BY public.workout_sets.id;


--
-- Name: workouts_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.workouts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.workouts_id_seq OWNER TO root;

--
-- Name: workouts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.workouts_id_seq OWNED BY public.workouts.id;


--
-- Name: exercises id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises ALTER COLUMN id SET DEFAULT nextval('public.exercises_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: weight_categories id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.weight_categories ALTER COLUMN id SET DEFAULT nextval('public.weight_categories_id_seq'::regclass);


--
-- Name: workout_sets id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_sets ALTER COLUMN id SET DEFAULT nextval('public.workout_sets_id_seq'::regclass);


--
-- Name: workouts id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts ALTER COLUMN id SET DEFAULT nextval('public.workouts_id_seq'::regclass);


--
-- Data for Name: exercises; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.exercises (id, name) FROM stdin;
1	Przysiad ze sztangą
2	Wyciskanie leżąc
3	Martwy ciąg
\.


--
-- Data for Name: user_profiles; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.user_profiles (user_id, first_name, last_name, gender, body_weight, weight_category_id) FROM stdin;
1	Jan	Kowalski	male	91.20	5
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.users (id, email, password_hash, created_at, role) FROM stdin;
1	qwer@qwer	$2y$10$XinrHUk/E1x4jvdqnf/c8.HuqSLzYat4vepiLw73cEl4IcYgmyQaS	2026-06-05 11:08:47.793976	admin
\.


--
-- Data for Name: weight_categories; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.weight_categories (id, name, max_weight) FROM stdin;
1	Do 59 kg	59.00
2	Do 66 kg	66.00
3	Do 74 kg	74.00
4	Do 83 kg	83.00
5	Do 93 kg	93.00
6	Do 105 kg	105.00
7	Do 120 kg	120.00
8	120+ kg	999.99
\.


--
-- Data for Name: workout_sets; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.workout_sets (id, workout_id, exercise_id, weight, reps, created_at) FROM stdin;
1	2	2	100.00	5	2026-06-05 11:25:37.857005
\.


--
-- Data for Name: workouts; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.workouts (id, user_id, workout_date, notes, created_at) FROM stdin;
1	1	2026-06-05	jest pompa	2026-06-05 11:18:49.074809
2	1	2026-06-05	2 trening	2026-06-05 11:24:49.620133
\.


--
-- Name: exercises_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.exercises_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: weight_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.weight_categories_id_seq', 8, true);


--
-- Name: workout_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.workout_sets_id_seq', 1, true);


--
-- Name: workouts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.workouts_id_seq', 2, true);


--
-- Name: exercises exercises_name_key; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises
    ADD CONSTRAINT exercises_name_key UNIQUE (name);


--
-- Name: exercises exercises_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.exercises
    ADD CONSTRAINT exercises_pkey PRIMARY KEY (id);


--
-- Name: user_profiles user_profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.user_profiles
    ADD CONSTRAINT user_profiles_pkey PRIMARY KEY (user_id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: weight_categories weight_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.weight_categories
    ADD CONSTRAINT weight_categories_pkey PRIMARY KEY (id);


--
-- Name: workout_sets workout_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_sets
    ADD CONSTRAINT workout_sets_pkey PRIMARY KEY (id);


--
-- Name: workouts workouts_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts
    ADD CONSTRAINT workouts_pkey PRIMARY KEY (id);


--
-- Name: user_profiles trigger_determine_weight_category; Type: TRIGGER; Schema: public; Owner: root
--

CREATE TRIGGER trigger_determine_weight_category BEFORE INSERT OR UPDATE ON public.user_profiles FOR EACH ROW EXECUTE FUNCTION public.determine_weight_category();


--
-- Name: user_profiles user_profiles_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.user_profiles
    ADD CONSTRAINT user_profiles_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: user_profiles user_profiles_weight_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.user_profiles
    ADD CONSTRAINT user_profiles_weight_category_id_fkey FOREIGN KEY (weight_category_id) REFERENCES public.weight_categories(id) ON DELETE SET NULL;


--
-- Name: workout_sets workout_sets_exercise_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_sets
    ADD CONSTRAINT workout_sets_exercise_id_fkey FOREIGN KEY (exercise_id) REFERENCES public.exercises(id) ON DELETE RESTRICT;


--
-- Name: workout_sets workout_sets_workout_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workout_sets
    ADD CONSTRAINT workout_sets_workout_id_fkey FOREIGN KEY (workout_id) REFERENCES public.workouts(id) ON DELETE CASCADE;


--
-- Name: workouts workouts_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.workouts
    ADD CONSTRAINT workouts_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict 4t9u5nUlmf8byYxwGcwCOKz75gK3bJGrLQO1NBax2Ste8i38wnpW9XQFTmjYY4V

