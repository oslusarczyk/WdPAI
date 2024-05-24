--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2 (Debian 16.2-1.pgdg120+2)
-- Dumped by pg_dump version 16.2

-- Started on 2024-05-24 22:47:29 UTC

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
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3414 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 229 (class 1255 OID 32883)
-- Name: update_reservation_price(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.update_reservation_price() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE 
	price INT;
	duration INT;

BEGIN
	 IF NEW.reservation_end_date <= NEW.reservation_start_date THEN
        RAISE EXCEPTION 'wrong date';
    END IF;
	
	SELECT price_per_day INTO price
	FROM cars
	WHERE car_id = NEW.car_id;

	duration := NEW.reservation_end_date - NEW.reservation_start_date;

	NEW.reservation_price := price * duration;

	RETURN NEW;
END;$$;


ALTER FUNCTION public.update_reservation_price() OWNER TO docker;

--
-- TOC entry 227 (class 1259 OID 57550)
-- Name: all_cars; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.all_cars AS
SELECT
    NULL::integer AS car_id,
    NULL::character varying(32) AS brand_name,
    NULL::character varying(64) AS model,
    NULL::integer AS price_per_day,
    NULL::integer AS seats_available,
    NULL::character varying(128) AS photo,
    NULL::integer AS production_year,
    NULL::character varying[] AS locations,
    NULL::text AS car_description;


ALTER VIEW public.all_cars OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 218 (class 1259 OID 24617)
-- Name: brands; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.brands (
    brand_id integer NOT NULL,
    brand_name character varying(32) NOT NULL
);


ALTER TABLE public.brands OWNER TO docker;

--
-- TOC entry 226 (class 1259 OID 57499)
-- Name: brands_brand_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.brands_brand_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.brands_brand_id_seq OWNER TO docker;

--
-- TOC entry 3415 (class 0 OID 0)
-- Dependencies: 226
-- Name: brands_brand_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.brands_brand_id_seq OWNED BY public.brands.brand_id;


--
-- TOC entry 220 (class 1259 OID 24627)
-- Name: cars; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.cars (
    car_id integer NOT NULL,
    brand_id integer NOT NULL,
    model character varying(64) NOT NULL,
    price_per_day integer NOT NULL,
    seats_available integer NOT NULL,
    photo character varying(128) NOT NULL,
    production_year integer NOT NULL,
    car_description text NOT NULL
);


ALTER TABLE public.cars OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 24625)
-- Name: cars_cars_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.cars_cars_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cars_cars_id_seq OWNER TO docker;

--
-- TOC entry 3416 (class 0 OID 0)
-- Dependencies: 219
-- Name: cars_cars_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.cars_cars_id_seq OWNED BY public.cars.car_id;


--
-- TOC entry 222 (class 1259 OID 24664)
-- Name: cars_locations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.cars_locations (
    id integer NOT NULL,
    car_id integer NOT NULL,
    location_id integer NOT NULL
);


ALTER TABLE public.cars_locations OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 24663)
-- Name: cars_locations_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.cars_locations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cars_locations_id_seq OWNER TO docker;

--
-- TOC entry 3417 (class 0 OID 0)
-- Dependencies: 221
-- Name: cars_locations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.cars_locations_id_seq OWNED BY public.cars_locations.id;


--
-- TOC entry 217 (class 1259 OID 24608)
-- Name: locations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.locations (
    location_id integer NOT NULL,
    location_name character varying(64) NOT NULL
);


ALTER TABLE public.locations OWNER TO docker;

--
-- TOC entry 225 (class 1259 OID 57447)
-- Name: locations_location_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.locations_location_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.locations_location_id_seq OWNER TO docker;

--
-- TOC entry 3418 (class 0 OID 0)
-- Dependencies: 225
-- Name: locations_location_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.locations_location_id_seq OWNED BY public.locations.location_id;


--
-- TOC entry 224 (class 1259 OID 32853)
-- Name: reservations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.reservations (
    reservation_id integer NOT NULL,
    user_id integer NOT NULL,
    car_id integer NOT NULL,
    location_id integer NOT NULL,
    reservation_start_date date NOT NULL,
    reservation_end_date date NOT NULL,
    reservation_price integer NOT NULL,
    reservation_status character varying(32) DEFAULT 'pending'::character varying
);


ALTER TABLE public.reservations OWNER TO docker;

--
-- TOC entry 216 (class 1259 OID 16406)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(128) NOT NULL,
    password character varying(256) NOT NULL,
    has_admin_privileges boolean DEFAULT false NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 228 (class 1259 OID 57555)
-- Name: reservation_view; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.reservation_view AS
 SELECT reservations.reservation_id,
    concat(brands.brand_name, ' ', cars.model) AS car_name,
    locations.location_name,
    cars.photo,
    reservations.reservation_start_date,
    reservations.reservation_end_date,
    reservations.reservation_price,
    reservations.reservation_status,
    users.email
   FROM ((((public.reservations
     JOIN public.users ON ((users.id = reservations.user_id)))
     JOIN public.locations ON ((locations.location_id = reservations.location_id)))
     JOIN public.cars ON ((cars.car_id = reservations.car_id)))
     JOIN public.brands ON ((cars.brand_id = brands.brand_id)));


ALTER VIEW public.reservation_view OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 32852)
-- Name: reservations_reservation_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.reservations_reservation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reservations_reservation_id_seq OWNER TO docker;

--
-- TOC entry 3419 (class 0 OID 0)
-- Dependencies: 223
-- Name: reservations_reservation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.reservations_reservation_id_seq OWNED BY public.reservations.reservation_id;


--
-- TOC entry 215 (class 1259 OID 16405)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO docker;

--
-- TOC entry 3420 (class 0 OID 0)
-- Dependencies: 215
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3240 (class 2604 OID 57500)
-- Name: brands brand_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.brands ALTER COLUMN brand_id SET DEFAULT nextval('public.brands_brand_id_seq'::regclass);


--
-- TOC entry 3241 (class 2604 OID 24630)
-- Name: cars car_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars ALTER COLUMN car_id SET DEFAULT nextval('public.cars_cars_id_seq'::regclass);


--
-- TOC entry 3242 (class 2604 OID 24667)
-- Name: cars_locations id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars_locations ALTER COLUMN id SET DEFAULT nextval('public.cars_locations_id_seq'::regclass);


--
-- TOC entry 3239 (class 2604 OID 57448)
-- Name: locations location_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.locations ALTER COLUMN location_id SET DEFAULT nextval('public.locations_location_id_seq'::regclass);


--
-- TOC entry 3243 (class 2604 OID 32856)
-- Name: reservations reservation_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations ALTER COLUMN reservation_id SET DEFAULT nextval('public.reservations_reservation_id_seq'::regclass);


--
-- TOC entry 3237 (class 2604 OID 16409)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3250 (class 2606 OID 57505)
-- Name: brands brands_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.brands
    ADD CONSTRAINT brands_pkey PRIMARY KEY (brand_id);


--
-- TOC entry 3254 (class 2606 OID 24669)
-- Name: cars_locations cars_locations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars_locations
    ADD CONSTRAINT cars_locations_pkey PRIMARY KEY (id);


--
-- TOC entry 3252 (class 2606 OID 24635)
-- Name: cars cars_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_pkey PRIMARY KEY (car_id);


--
-- TOC entry 3248 (class 2606 OID 57453)
-- Name: locations locations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (location_id);


--
-- TOC entry 3256 (class 2606 OID 32858)
-- Name: reservations reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pkey PRIMARY KEY (reservation_id);


--
-- TOC entry 3246 (class 2606 OID 16414)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3407 (class 2618 OID 57553)
-- Name: all_cars _RETURN; Type: RULE; Schema: public; Owner: docker
--

CREATE OR REPLACE VIEW public.all_cars AS
 SELECT cars.car_id,
    brands.brand_name,
    cars.model,
    cars.price_per_day,
    cars.seats_available,
    cars.photo,
    cars.production_year,
    array_agg(locations.location_name) AS locations,
    cars.car_description
   FROM (((public.cars
     LEFT JOIN public.cars_locations ON ((cars.car_id = cars_locations.car_id)))
     LEFT JOIN public.locations ON ((cars_locations.location_id = locations.location_id)))
     LEFT JOIN public.brands ON ((cars.brand_id = brands.brand_id)))
  GROUP BY cars.car_id, brands.brand_name
  ORDER BY cars.car_id;


--
-- TOC entry 3263 (class 2620 OID 32885)
-- Name: reservations update_price; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER update_price BEFORE INSERT ON public.reservations FOR EACH ROW EXECUTE FUNCTION public.update_reservation_price();


--
-- TOC entry 3258 (class 2606 OID 49241)
-- Name: cars_locations car; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars_locations
    ADD CONSTRAINT car FOREIGN KEY (car_id) REFERENCES public.cars(car_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3257 (class 2606 OID 57545)
-- Name: cars cars_brand_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars
    ADD CONSTRAINT cars_brand_id_fkey FOREIGN KEY (brand_id) REFERENCES public.brands(brand_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3259 (class 2606 OID 57459)
-- Name: cars_locations cars_locations_location_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.cars_locations
    ADD CONSTRAINT cars_locations_location_id_fkey FOREIGN KEY (location_id) REFERENCES public.locations(location_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3260 (class 2606 OID 49251)
-- Name: reservations reservations_car_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_car_id_fkey FOREIGN KEY (car_id) REFERENCES public.cars(car_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3261 (class 2606 OID 57454)
-- Name: reservations reservations_location_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_location_id_fkey FOREIGN KEY (location_id) REFERENCES public.locations(location_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3262 (class 2606 OID 49261)
-- Name: reservations reservations_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


-- Completed on 2024-05-24 22:47:30 UTC

--
-- PostgreSQL database dump complete
--

