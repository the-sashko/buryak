CREATE TYPE "admin_roles" AS ENUM ('admin', 'moderator');
CREATE TYPE "section_statuses" AS ENUM ('active', 'closed', 'hidden');
CREATE TYPE "share_types" AS ENUM ('push', 'telegram', 'twitter');

CREATE SEQUENCE admin_users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE sections_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE admin2section_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE ip2session_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE ban_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE media_types_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 5 CACHE 1;
CREATE SEQUENCE posts_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE post_citation_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE post_share_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."admin_users" (
    "id" numeric(11,0) DEFAULT nextval('admin_users_id_seq') NOT NULL,
    "name" character varying(32) NOT NULL,
    "email" character varying(128) NOT NULL,
    "pswd_hash" character varying(128) NOT NULL,
    "role" admin_roles NOT NULL,
    "is_active" boolean DEFAULT false NOT NULL,
    CONSTRAINT "admin_users_email" UNIQUE ("email"),
    CONSTRAINT "admin_users_email_pswd_hash" UNIQUE ("email", "pswd_hash"),
    CONSTRAINT "admin_users_email_pswd_hash_is_active" UNIQUE ("email", "pswd_hash", "is_active"),
    CONSTRAINT "admin_users_id" PRIMARY KEY ("id"),
    CONSTRAINT "admin_users_name" UNIQUE ("name")
) WITH (oids = false);

CREATE TABLE "public"."sections" (
    "id" numeric(11,0) DEFAULT nextval('sections_id_seq') NOT NULL,
    "slug" character varying(16) NOT NULL,
    "title" character varying(128) NOT NULL,
    "desription" character varying(255) NOT NULL,
    "age_restriction" numeric(2,0) DEFAULT '0' NOT NULL,
    "status" section_statuses NOT NULL,
    "sort" numeric(4,0) DEFAULT '0' NOT NULL,
    CONSTRAINT "sections_id" PRIMARY KEY ("id"),
    CONSTRAINT "sections_slug" UNIQUE ("slug"),
    CONSTRAINT "sections_slug_age_restriction" UNIQUE ("slug", "age_restriction"),
    CONSTRAINT "sections_slug_age_restriction_sort" UNIQUE ("slug", "age_restriction", "sort"),
    CONSTRAINT "sections_slug_age_restriction_status" UNIQUE ("slug", "age_restriction", "status"),
    CONSTRAINT "sections_slug_age_restriction_status_sort" UNIQUE ("slug", "age_restriction", "status", "sort"),
    CONSTRAINT "sections_slug_sort" UNIQUE ("slug", "sort"),
    CONSTRAINT "sections_slug_status" UNIQUE ("slug", "status")
) WITH (oids = false);

CREATE TABLE "public"."admin2section" (
    "id" integer DEFAULT nextval('admin2section_id_seq') NOT NULL,
    "id_admin" integer NOT NULL,
    "id_section" integer NOT NULL,
    CONSTRAINT "admin2section_id" PRIMARY KEY ("id"),
    CONSTRAINT "admin2section_id_admin_id_section" UNIQUE ("id_admin", "id_section"),
    CONSTRAINT "admin2section_id_admin_fkey" FOREIGN KEY (id_admin) REFERENCES admin_users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "admin2section_id_section_fkey" FOREIGN KEY (id_section) REFERENCES sections(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

CREATE TABLE "public"."sessions" (
    "id" integer DEFAULT nextval('sessions_id_seq') NOT NULL,
    "is_human" boolean DEFAULT true NOT NULL,
    "is_ban" boolean DEFAULT false NOT NULL,
    "cdate" timestamp DEFAULT now() NOT NULL,
    "mdate" timestamp,
    CONSTRAINT "sessions_id" PRIMARY KEY ("id"),
    CONSTRAINT "sessions_id_is_ban" UNIQUE ("id", "is_ban"),
    CONSTRAINT "sessions_id_is_human" UNIQUE ("id", "is_human"),
    CONSTRAINT "sessions_id_is_human_is_ban" UNIQUE ("id", "is_human", "is_ban")
) WITH (oids = false);

CREATE TABLE "public"."ip2session" (
    "id" integer DEFAULT nextval('ip2session_id_seq') NOT NULL,
    "id_session" integer NOT NULL,
    "ip" character varying(40) NOT NULL,
    CONSTRAINT "ip2session_id" PRIMARY KEY ("id"),
    CONSTRAINT "ip2session_id_session_ip" UNIQUE ("id_session", "ip"),
    CONSTRAINT "ip2session_ip" UNIQUE ("ip"),
    CONSTRAINT "ip2session_id_session_fkey" FOREIGN KEY (id_session) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

CREATE TABLE "public"."ban" (
    "id" integer DEFAULT nextval('ban_id_seq') NOT NULL,
    "id_session" integer NOT NULL,
    "id_admin" integer NOT NULL,
    "message" character varying(255) NOT NULL,
    "expire" timestamp,
    "is_active" boolean DEFAULT true NOT NULL,
    "cdate" timestamp DEFAULT now() NOT NULL,
    "mdate" timestamp,
    CONSTRAINT "ban_id" PRIMARY KEY ("id"),
    CONSTRAINT "ban_id_admin_fkey" FOREIGN KEY (id_admin) REFERENCES admin_users(id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE,
    CONSTRAINT "ban_id_session_fkey" FOREIGN KEY (id_session) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

CREATE TABLE "public"."media_types" (
    "id" numeric(11,0) DEFAULT nextval('media_types_id_seq') NOT NULL,
    "title" character varying(32) NOT NULL,
    "file_extention" character varying(8),
    CONSTRAINT "media_types_id" PRIMARY KEY ("id"),
    CONSTRAINT "media_types_title" UNIQUE ("title")
) WITH (oids = false);

CREATE TABLE "public"."posts" (
    "id" integer DEFAULT nextval('posts_id_seq') NOT NULL,
    "relative_code" integer NOT NULL,
    "id_section" integer NOT NULL,
    "id_parent" integer,
    "title" character varying(255) NOT NULL,
    "text" text NOT NULL,
    "media_path" character varying(255) NOT NULL,
    "media_name" character varying(32) NOT NULL,
    "id_media_type" integer NOT NULL,
    "pswd_hash" character varying(128) NOT NULL,
    "username" character varying(128) NOT NULL,
    "tripcode" character varying NOT NULL,
    "id_session" integer NOT NULL,
    "is_active" boolean DEFAULT true NOT NULL,
    "views" numeric(11,0) DEFAULT '0' NOT NULL,
    "cdate" timestamp DEFAULT now() NOT NULL,
    "mdate" timestamp,
    CONSTRAINT "posts_id" PRIMARY KEY ("id"),
    CONSTRAINT "posts_id_pswd_hash" UNIQUE ("id", "pswd_hash"),
    CONSTRAINT "posts_id_pswd_hash_cdate" UNIQUE ("id", "pswd_hash", "cdate"),
    CONSTRAINT "posts_id_pswd_hash_mdate" UNIQUE ("id", "pswd_hash", "mdate"),
    CONSTRAINT "posts_relative_code_id_section" UNIQUE ("relative_code", "id_section"),
    CONSTRAINT "posts_relative_code_id_section_cdate" UNIQUE ("relative_code", "id_section", "cdate"),
    CONSTRAINT "posts_relative_code_id_section_id_parent" UNIQUE ("relative_code", "id_section", "id_parent"),
    CONSTRAINT "posts_relative_code_id_section_is_active" UNIQUE ("relative_code", "id_section", "is_active"),
    CONSTRAINT "posts_relative_code_id_section_is_active_id_parent" UNIQUE ("relative_code", "id_section", "is_active", "id_parent"),
    CONSTRAINT "posts_relative_code_id_section_mdate" UNIQUE ("relative_code", "id_section", "mdate"),
    CONSTRAINT "posts_id_media_type_fkey" FOREIGN KEY (id_media_type) REFERENCES media_types(id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE,
    CONSTRAINT "posts_id_parent_fkey" FOREIGN KEY (id_parent) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE,
    CONSTRAINT "posts_id_section_fkey" FOREIGN KEY (id_section) REFERENCES sections(id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE,
    CONSTRAINT "posts_id_session_fkey" FOREIGN KEY (id_session) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE SET NULL NOT DEFERRABLE
) WITH (oids = false);

CREATE TABLE "public"."post_citation" (
    "id" integer DEFAULT nextval('post_citation_id_seq') NOT NULL,
    "id_post_from" integer NOT NULL,
    "id_post_to" integer NOT NULL,
    CONSTRAINT "post_citation_id" PRIMARY KEY ("id"),
    CONSTRAINT "post_citation_id_post_from_id_post_to" UNIQUE ("id_post_from", "id_post_to"),
    CONSTRAINT "post_citation_id_post_from_fkey" FOREIGN KEY (id_post_from) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "post_citation_id_post_to_fkey" FOREIGN KEY (id_post_to) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

CREATE TABLE "public"."post_share" (
    "id" integer DEFAULT nextval('post_share_id_seq') NOT NULL,
    "id_post" integer NOT NULL,
    "share_type" share_types NOT NULL,
    "cdate" timestamp NOT NULL,
    CONSTRAINT "post_share_id" PRIMARY KEY ("id"),
    CONSTRAINT "post_share_id_post_share_type" UNIQUE ("id_post", "share_type"),
    CONSTRAINT "post_share_id_post_fkey" FOREIGN KEY (id_post) REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);

CREATE INDEX "admin_users_is_active" ON "public"."admin_users" USING btree ("is_active");
CREATE INDEX "admin_users_pswd_hash" ON "public"."admin_users" USING btree ("pswd_hash");
CREATE INDEX "admin_users_role" ON "public"."admin_users" USING btree ("role");
CREATE INDEX "sections_age_restriction" ON "public"."sections" USING btree ("age_restriction");
CREATE INDEX "sections_age_restriction_sort" ON "public"."sections" USING btree ("age_restriction", "sort");
CREATE INDEX "sections_age_restriction_status" ON "public"."sections" USING btree ("age_restriction", "status");
CREATE INDEX "sections_sort" ON "public"."sections" USING btree ("sort");
CREATE INDEX "sections_status" ON "public"."sections" USING btree ("status");
CREATE INDEX "admin2section_id_admin" ON "public"."admin2section" USING btree ("id_admin");
CREATE INDEX "admin2section_id_section" ON "public"."admin2section" USING btree ("id_section");
CREATE INDEX "sessions_cdate" ON "public"."sessions" USING btree ("cdate");
CREATE INDEX "sessions_id_cdate_mdate" ON "public"."sessions" USING btree ("id", "cdate", "mdate");
CREATE INDEX "sessions_id_is_ban_cdate_mdate" ON "public"."sessions" USING btree ("id", "is_ban", "cdate", "mdate");
CREATE INDEX "sessions_is_ban" ON "public"."sessions" USING btree ("is_ban");
CREATE INDEX "sessions_is_human" ON "public"."sessions" USING btree ("is_human");
CREATE INDEX "sessions_mdate" ON "public"."sessions" USING btree ("mdate");
CREATE INDEX "ip2session_id_session" ON "public"."ip2session" USING btree ("id_session");
CREATE INDEX "ban_cdate" ON "public"."ban" USING btree ("cdate");
CREATE INDEX "ban_expire" ON "public"."ban" USING btree ("expire");
CREATE INDEX "ban_expire_is_active" ON "public"."ban" USING btree ("expire", "is_active");
CREATE INDEX "ban_id_admin" ON "public"."ban" USING btree ("id_admin");
CREATE INDEX "ban_id_admin_is_active" ON "public"."ban" USING btree ("id_admin", "is_active");
CREATE INDEX "ban_id_session" ON "public"."ban" USING btree ("id_session");
CREATE INDEX "ban_id_session_expire" ON "public"."ban" USING btree ("id_session", "expire");
CREATE INDEX "ban_id_session_expire_is_active" ON "public"."ban" USING btree ("id_session", "expire", "is_active");
CREATE INDEX "ban_is_active" ON "public"."ban" USING btree ("is_active");
CREATE INDEX "ban_mdate" ON "public"."ban" USING btree ("mdate");
CREATE INDEX "media_types_file_extention" ON "public"."media_types" USING btree ("file_extention");
CREATE INDEX "posts_cdate" ON "public"."posts" USING btree ("cdate");
CREATE INDEX "posts_id_media_type" ON "public"."posts" USING btree ("id_media_type");
CREATE INDEX "posts_id_parent" ON "public"."posts" USING btree ("id_parent");
CREATE INDEX "posts_id_section" ON "public"."posts" USING btree ("id_section");
CREATE INDEX "posts_id_session" ON "public"."posts" USING btree ("id_session");
CREATE INDEX "posts_is_active" ON "public"."posts" USING btree ("is_active");
CREATE INDEX "posts_mdate" ON "public"."posts" USING btree ("mdate");
CREATE INDEX "posts_pswd_hash" ON "public"."posts" USING btree ("pswd_hash");
CREATE INDEX "posts_relative_code" ON "public"."posts" USING btree ("relative_code");
CREATE INDEX "posts_views" ON "public"."posts" USING btree ("views");
CREATE INDEX "post_citation_id_post_from" ON "public"."post_citation" USING btree ("id_post_from");
CREATE INDEX "post_citation_id_post_to" ON "public"."post_citation" USING btree ("id_post_to");
CREATE INDEX "post_share_cdate" ON "public"."post_share" USING btree ("cdate");
CREATE INDEX "post_share_id_post" ON "public"."post_share" USING btree ("id_post");
CREATE INDEX "post_share_share_type" ON "public"."post_share" USING btree ("share_type");

INSERT INTO "media_types" ("id", "title", "file_extention") VALUES
(1, 'Empty',  NULL),
(2, 'Image (jpeg)', 'jpg'),
(3, 'Image (png)',  'png'),
(4, 'Image (gif)',  'gif'),
(5, 'Video (Youtube)',  NULL);