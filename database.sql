-- Role: "hv-user"
-- DROP ROLE IF EXISTS "hv-user";

CREATE ROLE "hv-user" WITH
  LOGIN
  NOSUPERUSER
  INHERIT
  NOCREATEDB
  NOCREATEROLE
  NOREPLICATION
  ENCRYPTED PASSWORD 'SCRAM-SHA-256$4096:32nJRYJtCm8POw0CKRVowA==$6AvPv6f7Sukwpa4CmFhVcP+kSQvHAt0RmgmzK8p76mg=:+0JJsNURs8jj61DoiWb/XRY0Q4U7e252xmjwfJD33l8=';
  

-- Table: public.Visites
CREATE TABLE "Visites" (
    "idVisite" integer NOT NULL,
    "ipAddress" character varying(15) NOT NULL,
    "geoLatitude" character varying(7),
    "geoLongitude" character varying(7),
    "geoCountryCode" character varying(2),
    "userAgent" text,
    "createdAt" timestamp with time zone DEFAULT now()
);

ALTER TABLE public."Visites" OWNER TO "hv-user";

CREATE SEQUENCE "Visites_idVisite_seq" START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
ALTER TABLE public."Visites_idVisite_seq" OWNER TO "hv-user";
ALTER SEQUENCE "Visites_idVisite_seq" OWNED BY "Visites"."idVisite";
ALTER TABLE ONLY "Visites" ALTER COLUMN "idVisite" SET DEFAULT nextval('"Visites_idVisite_seq"'::regclass);

ALTER TABLE ONLY "Visites" ADD CONSTRAINT "Visites_pkey" PRIMARY KEY ("idVisite");