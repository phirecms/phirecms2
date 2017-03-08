--
-- Phire CMS PostgreSQL Database
--

-- --------------------------------------------------------

--
-- Table structure for table "config"
--

DROP TABLE IF EXISTS "[{prefix}]config" CASCADE;
CREATE TABLE IF NOT EXISTS "[{prefix}]config" (
  "setting" varchar(255) NOT NULL,
  "value" text NOT NULL,
  PRIMARY KEY ("setting")
) ;

--
-- Dumping data for table "config"
--

INSERT INTO "[{prefix}]config" ("setting", "value") VALUES
('installed_on', '0000-00-00 00:00:00'),
('updated_on', '0000-00-00 00:00:00'),
('pagination', '25'),
('updates', '');

-- --------------------------------------------------------

--
-- Table structure for table "roles"
--

CREATE SEQUENCE role_id_seq START 2001;

DROP TABLE IF EXISTS "[{prefix}]roles" CASCADE;
CREATE TABLE IF NOT EXISTS "[{prefix}]roles" (
  "id" integer NOT NULL DEFAULT nextval('role_id_seq'),
  "parent_id" integer,
  "name" varchar(255) NOT NULL,
  "verification" integer,
  "approval" integer,
  "permissions" text,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_role_parent_id" FOREIGN KEY ("parent_id") REFERENCES "[{prefix}]roles" ("id") ON DELETE SET NULL ON UPDATE CASCADE
) ;

ALTER SEQUENCE role_id_seq OWNED BY "[{prefix}]roles"."id";
CREATE INDEX "role_name" ON "[{prefix}]roles" ("name");

--
-- Dumping data for table "roles"
--

INSERT INTO "[{prefix}]roles" ("parent_id", "name", "verification", "approval", "permissions") VALUES
(NULL, 'Admin', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table "users"
--

CREATE SEQUENCE user_id_seq START 1001;

DROP TABLE IF EXISTS "[{prefix}]users" CASCADE;
CREATE TABLE IF NOT EXISTS "[{prefix}]users" (
  "id" integer NOT NULL DEFAULT nextval('user_id_seq'),
  "role_id" integer,
  "username" varchar(255) NOT NULL,
  "password" varchar(255) NOT NULL,
  "email" varchar(255),
  "active" integer,
  "verified" integer,
  "last_login" timestamp,
  "last_ip" varchar(255),
  "last_ua" varchar(255),
  "total_logins" integer DEFAULT '0',
  "failed_attempts" integer DEFAULT '0',
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_user_role" FOREIGN KEY ("role_id") REFERENCES "[{prefix}]roles" ("id") ON DELETE CASCADE ON UPDATE CASCADE
) ;

ALTER SEQUENCE user_id_seq OWNED BY "[{prefix}]users"."id";
CREATE INDEX "role_id" ON "[{prefix}]users" ("role_id");
CREATE INDEX "username" ON "[{prefix}]users" ("username");

--  --------------------------------------------------------

--
-- Table structure for table "modules"
--

CREATE SEQUENCE module_id_seq START 3001;

DROP TABLE IF EXISTS "[{prefix}]modules" CASCADE;
CREATE TABLE IF NOT EXISTS "[{prefix}]modules" (
  "id" integer NOT NULL DEFAULT nextval('module_id_seq'),
  "file" varchar(255) NOT NULL,
  "folder" varchar(255) NOT NULL,
  "name" varchar(255) NOT NULL,
  "prefix" varchar(255) NOT NULL,
  "version" varchar(255) NOT NULL,
  "active" integer NOT NULL,
  "order" integer NOT NULL,
  "assets" text,
  "updates" text,
  "installed_on" timestamp,
  "updated_on" timestamp,
  PRIMARY KEY ("id")
) ;

ALTER SEQUENCE module_id_seq OWNED BY "[{prefix}]modules"."id";
CREATE INDEX "module_folder" ON "[{prefix}]modules" ("folder");