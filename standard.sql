# HeidiSQL Dump 
#
# --------------------------------------------------------
# Host:                         127.0.0.1
# Database:                     ci_template
# Server version:               5.1.36-community-log
# Server OS:                    Win32
# Target compatibility:         ANSI SQL
# HeidiSQL version:             4.0
# Date/time:                    2009-11-16 22:13:47
# --------------------------------------------------------

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ANSI,NO_BACKSLASH_ESCAPES';*/
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;*/


DROP TABLE IF EXISTS "companies";

#
# Table structure for table 'companies'
#

CREATE TABLE "companies" (
  "id" int(10) unsigned NOT NULL AUTO_INCREMENT,
  "name" varchar(50) DEFAULT NULL,
  "address" varchar(50) DEFAULT NULL,
  "state" varchar(2) DEFAULT NULL,
  "zip" int(5) unsigned DEFAULT NULL,
  "active" int(1) unsigned DEFAULT NULL,
  PRIMARY KEY ("id")
);



#
# Dumping data for table 'companies'
#

# No data found.



DROP TABLE IF EXISTS "groups";

#
# Table structure for table 'groups'
#

CREATE TABLE "groups" (
  "id" tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  "name" varchar(20) NOT NULL,
  "description" varchar(100) NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=3;



#
# Dumping data for table 'groups'
#

LOCK TABLES "groups" WRITE;
/*!40000 ALTER TABLE "groups" DISABLE KEYS;*/
INSERT INTO "groups" ("id", "name", "description") VALUES
	(1,'admin','Administrator');
INSERT INTO "groups" ("id", "name", "description") VALUES
	(2,'members','General User');
/*!40000 ALTER TABLE "groups" ENABLE KEYS;*/
UNLOCK TABLES;


DROP TABLE IF EXISTS "pages";

#
# Table structure for table 'pages'
#

CREATE TABLE "pages" (
  "id" int(10) NOT NULL AUTO_INCREMENT,
  "title" varchar(50) DEFAULT NULL,
  "controller" varchar(50) DEFAULT NULL,
  "view" varchar(50) DEFAULT '',
  "url" varchar(50) DEFAULT NULL,
  "menu" varchar(50) DEFAULT NULL,
  "order" int(2) unsigned DEFAULT NULL,
  "require_login" int(1) unsigned DEFAULT '0',
  "group_id" int(10) unsigned DEFAULT '0',
  "parent_id" int(10) unsigned DEFAULT NULL,
  "active" int(1) unsigned DEFAULT '1',
  PRIMARY KEY ("id")
) AUTO_INCREMENT=17;



#
# Dumping data for table 'pages'
#

LOCK TABLES "pages" WRITE;
/*!40000 ALTER TABLE "pages" DISABLE KEYS;*/
INSERT INTO "pages" ("id", "title", "controller", "view", "url", "menu", "order", "require_login", "group_id", "parent_id", "active") VALUES
	(1,'Home','welcome','',NULL,'main','1','0','0',NULL,'1');
INSERT INTO "pages" ("id", "title", "controller", "view", "url", "menu", "order", "require_login", "group_id", "parent_id", "active") VALUES
	(16,'Admin Control Panel','admin','',NULL,NULL,NULL,'0','1',NULL,'1');
INSERT INTO "pages" ("id", "title", "controller", "view", "url", "menu", "order", "require_login", "group_id", "parent_id", "active") VALUES
	(9,'Home','welcome','',NULL,'bottom','0','1','0',NULL,'1');
/*!40000 ALTER TABLE "pages" ENABLE KEYS;*/
UNLOCK TABLES;


DROP TABLE IF EXISTS "users";

#
# Table structure for table 'users'
#

CREATE TABLE "users" (
  "id" mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  "group_id" mediumint(8) unsigned NOT NULL,
  "ip_address" char(16) NOT NULL,
  "firstName" varchar(50) DEFAULT NULL,
  "lastName" varchar(50) DEFAULT NULL,
  "username" varchar(15) NOT NULL,
  "password" varchar(40) NOT NULL,
  "email" varchar(40) NOT NULL,
  "company_id" int(10) unsigned DEFAULT '0',
  "plan_id" int(11) unsigned DEFAULT NULL,
  "activation_code" varchar(40) NOT NULL DEFAULT '0',
  "forgotten_password_code" varchar(40) NOT NULL DEFAULT '0',
  "notify" int(1) unsigned NOT NULL DEFAULT '0',
  "active" int(1) unsigned DEFAULT NULL,
  "company" varchar(50) DEFAULT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=14;



#
# Dumping data for table 'users'
#

LOCK TABLES "users" WRITE;
/*!40000 ALTER TABLE "users" DISABLE KEYS;*/
INSERT INTO "users" ("id", "group_id", "ip_address", "firstName", "lastName", "username", "password", "email", "company_id", "plan_id", "activation_code", "forgotten_password_code", "notify", "active", "company") VALUES
	('1','1','127.0.0.1','Ben','Edmunds','benedmunds','5afc24cf621620ad107527a332a01425446ab0ba','ben.edmunds@gmail.com','0',NULL,'','0','1','1',NULL);
/*!40000 ALTER TABLE "users" ENABLE KEYS;*/
UNLOCK TABLES;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE;*/
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;*/
