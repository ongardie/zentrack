--
-- Table structure for table 'ZENTRACK_ACCESS'
--
-- converted to postgreSQL by jofry@users.sourceforge.net
-- 05/03/02
--

--DROP SEQUENCE "access_access_id_seq";
--DROP SEQUENCE "attachments_attachment_id_seq";
--DROP SEQUENCE "bins_bid_seq";
--DROP SEQUENCE "logs_lid_seq";
--DROP SEQUENCE "priorities_pid_seq";
--DROP SEQUENCE "settings_setting_id_seq";
--DROP SEQUENCE "systems_sid_seq";
--DROP SEQUENCE "tasks_task_id_seq";
--DROP SEQUENCE "tickets_id_seq";
--DROP SEQUENCE "translation_strings_trans_id_seq";
--DROP SEQUENCE "translation_words_word_id_seq";
--DROP SEQUENCE "types_type_id_seq";
--DROP SEQUENCE "users_user_id_seq";
--DROP SEQUENCE "reports_id_seq";
--DROP SEQUENCE "reports_temp_id_seq";
--DROP SEQUENCE "notify_id_seq";

--DROP TABLE ZENTRACK_ACCESS;
--DROP TABLE ZENTRACK_ATTACHMENTS;
--DROP TABLE ZENTRACK_BINS;
--DROP TABLE ZENTRACK_LOGS;
--DROP TABLE ZENTRACK_LOGS_ARCHIVED;
--DROP TABLE ZENTRACK_PREFERENCES;
--DROP TABLE ZENTRACK_PRIORITIES;
--DROP TABLE ZENTRACK_SETTINGS;
--DROP TABLE ZENTRACK_SYSTEMS;
--DROP TABLE ZENTRACK_TASKS;
--DROP TABLE ZENTRACK_TICKETS;
--DROP TABLE ZENTRACK_TICKETS_ARCHIVED;
--DROP TABLE ZENTRACK_TRANSLATION_STRINGS;
--DROP TABLE ZENTRACK_TRANSLATION_WORDS;
--DROP TABLE ZENTRACK_TYPES;
--DROP TABLE ZENTRACK_USERS;
--DROP TABLE ZENTRACK_REPORTS;
--DROP TABLE ZENTRACK_REPORTS_TEMP;
--DROP TABLE ZENTRACK_REPORTS_INDEX;
--DROP TABLE ZENTRACK_NOTIFY_LIST;

CREATE SEQUENCE "access_access_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "attachments_attachment_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "bins_bid_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "logs_lid_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "priorities_pid_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "settings_setting_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "systems_sid_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "tasks_task_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "tickets_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "translation_strings_trans_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "translation_words_word_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "types_type_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "users_user_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "reports_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "reports_temp_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "notify_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id int8 default nextval('"notify_id_seq"') NOT NULL PRIMARY KEY,
   ticket_id int(12) NOT NULL,
   user_id int(12) default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority int(12) default NULL,
   notes varchar(255) default NULL
);

CREATE TABLE ZENTRACK_ACCESS (
  access_id int8 default nextval('"access_id_seq"') NOT NULL PRIMARY KEY,
  user_id int8 default NULL,
  bin_id int8 default NULL,
  lvl int2 default NULL,
  notes varchar(25) default NULL
);

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachment_id int8 default nextval('"attachments_id_seq"') NOT NULL PRIMARY KEY,
  log_id int8 default NULL,
  ticket_id int8 default NULL,
  name varchar(25) default NULL,
  filename varchar(250) default NULL,
  filetype varchar(250) default NULL,
  description varchar(100) default NULL
);

--
-- Table structure for table 'ZENTRACK_BINS'
--

CREATE TABLE ZENTRACK_BINS (
  bid int8 default nextval('"bins_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL default '',
  priority int8 default NULL,
  active int2 default '1'
);

--
-- Table structure for table 'ZENTRACK_LOGS'
--

CREATE TABLE ZENTRACK_LOGS (
  lid int8  default nextval('"logs_id_seq"') NOT NULL PRIMARY KEY,
  ticket_id int8 NOT NULL default '0',
  user_id int8 NOT NULL default '0',
  bin_id int8 NOT NULL default '0',
  created int8 default NULL,
  action varchar(25) default NULL,
  hours decimal(10,2) default NULL,
  entry text
);

--
-- Table structure for table 'ZENTRACK_LOGS_ARCHIVED'
--

CREATE TABLE ZENTRACK_LOGS_ARCHIVED (
  lid int8 default NULL,
  ticket_id int8 default NULL,
  user_id int8 default NULL,
  bin_id int8 default NULL,
  created int8 default NULL,
  action varchar(25) default NULL,
  entry text
);

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id int8 default '0' NOT NULL PRIMARY KEY,
  bin int8 default NULL,
  log varchar(255) default NULL,
  time varchar(255) default NULL,
  "close" varchar(255) default NULL,
  test varchar(255) default NULL
);

--
-- Table structure for table 'ZENTRACK_PRIORITIES'
--

CREATE TABLE ZENTRACK_PRIORITIES (
  pid int8 default nextval('"priorities_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL default '',
  priority int8 default NULL,
  active int2 default NULL
);

--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_SETTINGS (
  setting_id int8 default nextval('"settings_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) default NULL,
  value varchar(100) default NULL,
  description varchar(200) default NULL
--  KEY name(name)
);

--
-- Table structure for table 'ZENTRACK_SYSTEMS'
--

CREATE TABLE ZENTRACK_SYSTEMS (
  sid int8 default nextval('"systems_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL default '',
  priority int8 default NULL,
  active int2 default NULL
);

--
-- Table structure for table 'ZENTRACK_TASKS'
--

CREATE TABLE ZENTRACK_TASKS (
  task_id int8 default nextval('"tasks_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL default '',
  priority int8 default NULL,
  active int2 default NULL
);

--
-- Table structure for table 'ZENTRACK_TICKETS'
--

CREATE TABLE ZENTRACK_TICKETS (
  id int8 default nextval('"tickets_id_seq"') NOT NULL PRIMARY KEY,
  title varchar(50) NOT NULL default 'untitled',
  priority int2 NOT NULL default '0',
  status varchar(25) NOT NULL default 'OPEN',
  description text,
  otime int8 default NULL,
  ctime int8 default NULL,
  bin_id int8 default NULL,
  type_id int8 default NULL,
  user_id int8 default NULL,
  system_id int8 default NULL,
  creator_id int8 default NULL,
  tested int2 default '0',
  approved int2 default '0',
  relations varchar(255) default NULL,
  project_id int8 default NULL,
  est_hours decimal(10,2) default '0.00',
  deadline int8 default NULL,
  start_date int8 default NULL,
  wkd_hours decimal(10,2) default '0.00'
);

--
-- Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
--

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trans_id int8 default nextval('"translation_strings_id_seq"') NOT NULL PRIMARY KEY,
  language varchar(25) default NULL,
  identifier varchar(25) default NULL,
  string varchar(255) default NULL
--  KEY language(language)
);

--
-- Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
--

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  word_id int8 default nextval('"translation_words_id_seq"') NOT NULL PRIMARY KEY,
  language varchar(25) default NULL,
  identifier varchar(50) default NULL,
  translation varchar(50) default NULL
--  KEY language(language),
--  KEY identifier(identifier)
);

--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
  type_id int8 default nextval('"types_id_seq"') NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL default '',
  priority int8 default NULL,
  active int2 default NULL
);

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
  user_id int8 default nextval('"users_id_seq"') NOT NULL PRIMARY KEY,
  login varchar(25) default NULL,
  access_level int2 default NULL,
  passphrase varchar(32) default NULL,
  lname varchar(50) default NULL,
  fname varchar(50) default NULL,
  initials varchar(5) default NULL,
  email varchar(100) default NULL,
  notes varchar(255) default NULL,
  homebin int8 default NULL,
  active int2 default '1'
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS' 
-- 

CREATE TABLE ZENTRACK_REPORTS ( 
   report_id int8 default nextval('"reports_id_seq"') NOT NULL PRIMARY KEY, 
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int8 default NULL, 
   date_range varchar(12) default NULL, 
   date_low int8 default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int2 default NULL, 
   chart_add_avg int2 default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   chart_combine int2 default NULL, 
   text_output int2 default NULL, 
   show_data_vals int2 default NULL
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_INDEX' 
-- 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
   report_id int8 default NULL, 
   bid int8 default NULL, 
   user_id int8 default NULL 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_TEMP' 
-- 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
   report_id int8 default nextval('"reports_temp_id_seq"') NOT NULL PRIMARY KEY,
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int8 default NULL, 
   date_range varchar(12) default NULL, 
   date_low int8 default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int2 default NULL, 
   chart_add_avg int2 default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   created timestamp default NULL,
   chart_combine int2 default NULL, 
   text_output int2 default NULL, 
   show_data_vals int2 default NULL, 
   PRIMARY KEY (report_id)
);

