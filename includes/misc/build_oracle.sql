--
-- Table structure for table 'ZENTRACK_ACCESS'
--

CREATE TABLE ZENTRACK_ACCESS (
  access_id number(12),
  user_id number(12) default NULL,
  bin_id number(12) default NULL,
  lvl   number(2) default NULL,
  notes varchar2(25) default NULL,
  CONSTRAINT access_pk PRIMARY KEY (access_id)
) ;

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachment_id number(12),
  log_id number(12) default NULL,
  ticket_id number(12) default NULL,
  name varchar2(25) default NULL,
  filename varchar2(250) default NULL,
  filetype varchar2(250) default NULL,
  description varchar2(100) default NULL,
  CONSTRAINT attachment_pk PRIMARY KEY (attachment_id)
) ;

--
-- Table structure for table 'ZENTRACK_BINS'
--

CREATE TABLE ZENTRACK_BINS (
  bid number(12),
  name varchar2(25) CONSTRAINT bins_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default 1,
  CONSTRAINT bin_pk PRIMARY KEY (bid)
) ;

--
-- Table structure for table 'ZENTRACK_LOGS'
--

CREATE TABLE ZENTRACK_LOGS (
  lid number(12),
  ticket_id number(12) DEFAULT 0 CONSTRAINT logs_ticket_id_not_null NOT NULL,
  user_id number(12) DEFAULT 0 CONSTRAINT logs_user_id_not_null NOT NULL,
  bin_id number(12) DEFAULT 0 CONSTRAINT logs_bin_id_not_null NOT NULL,
  created number(12) default NULL,
  action varchar2(25) default NULL,
  hours decimal(10,2) default NULL,
  entry varchar2(2000),
  CONSTRAINT logs_pk PRIMARY KEY (lid)
) ;

--
-- Table structure for table 'ZENTRACK_LOGS_ARCHIVED'
--

CREATE TABLE ZENTRACK_LOGS_ARCHIVED (
  lid number(12) default NULL,
  ticket_id number(12) default NULL,
  user_id number(12) default NULL,
  bin_id number(12) default NULL,
  created number(12) default NULL,
  action varchar2(25) default NULL,
  entry varchar2(2000)
) ;

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id number(12) DEFAULT 0,
  bin number(12) default NULL,
  log varchar2(255) default NULL,
  time varchar2(255) default NULL,
  close varchar2(255) default NULL,
  test varchar2(255) default NULL,
  CONSTRAINT preferences_pk PRIMARY KEY (user_id)
) ;

--
-- Table structure for table 'ZENTRACK_PRIORITIES'
--

CREATE TABLE ZENTRACK_PRIORITIES (
  pid number(12),
  name varchar2(25) CONSTRAINT priorities_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT priorities_pk PRIMARY KEY (pid)
) ;

--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_SETTINGS (
  setting_id number(12),
  name varchar2(25) default NULL,
  value varchar2(100) default NULL,
  description varchar2(200) default NULL,
  CONSTRAINT settings_pk PRIMARY KEY (setting_id)
) ;

--
-- Table structure for table 'ZENTRACK_SYSTEMS'
--

CREATE TABLE ZENTRACK_SYSTEMS (
  sid number(12),
  name varchar2(25) CONSTRAINT systems_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT systems_pk PRIMARY KEY (sid)
) ;

--
-- Table structure for table 'ZENTRACK_TASKS'
--

CREATE TABLE ZENTRACK_TASKS (
  task_id number(12),
  name varchar2(25) CONSTRAINT tasks_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT tasks_pk PRIMARY KEY (task_id)
) ;

--
-- Table structure for table 'ZENTRACK_TICKETS'
--

CREATE TABLE ZENTRACK_TICKETS (
  id number(12),
  title varchar2(50) default 'untitled' CONSTRAINT tickets_title_not_null NOT NULL,
  priority number(2) DEFAULT 0 CONSTRAINT tickets_priority_not_null NOT NULL,
  status varchar2(25) default 'OPEN' CONSTRAINT tickets_status_not_null NOT NULL,
  description varchar2(4000),
  otime number(12) default NULL,
  ctime number(12) default NULL,
  bin_id number(12) default NULL,
  type_id number(12) default NULL,
  user_id number(12) default NULL,
  system_id number(12) default NULL,
  creator_id number(12) default NULL,
  tested number(1) default 0,
  approved number(1) default 0,
  relations varchar2(255) default NULL,
  project_id number(12) default NULL,
  est_hours number(10,2) default 0.00,
  deadline number(12) default NULL,
  start_date number(12) default NULL,
  wkd_hours number(10,2) default 0.00,
  CONSTRAINT tickets_pk PRIMARY KEY (id)
) ;

--
-- Table structure for table 'ZENTRACK_TICKETS_ARCHIVED'
--

CREATE TABLE ZENTRACK_TICKETS_ARCHIVED (
  id number(12) default NULL,
  title varchar2(50) default NULL,
  priority number(2) default NULL,
  description varchar2(4000),
  otime number(12) default NULL,
  ctime number(12) default NULL,
  type_id varchar2(25) default NULL,
  system_id number(12) default NULL,
  relations varchar2(255) default NULL,
  project_id number(12) default NULL,
  est_hours decimal(10,2) default NULL,
  wkd_hours decimal(10,2) default NULL
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
--

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trans_id number(12),
  language varchar2(25) default NULL,
  identifier varchar2(25) default NULL,
  string varchar2(255) default NULL,
  CONSTRAINT trstr_pk PRIMARY KEY (trans_id)
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
--

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  word_id number(12),
  language varchar2(25) default NULL,
  identifier varchar2(50) default NULL,
  translation varchar2(50) default NULL,
  PRIMARY KEY (word_id)
) ;


--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
  type_id number(12),
  name varchar2(25) CONSTRAINT types_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT types_pk PRIMARY KEY (type_id)
) ;

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
  user_id number(12),
  login varchar2(25) default NULL,
  access_level number(2) default NULL,
  passwd varchar2(32) default NULL,
  lname varchar2(50) default NULL,
  fname varchar2(50) default NULL,
  initials varchar2(5) default NULL,
  email varchar2(100) default NULL,
  notes varchar2(255) default NULL,
  homebin number(12) default NULL,
  active number(1) default 1,
  CONSTRAINT users_pk PRIMARY KEY (user_id)
) ;


/*
**  CREATE SEQUENCES
*/

create sequence access_id_seq              start with 1001 nocache;
create sequence attachments_id_seq         start with 1001 nocache;
create sequence bins_id_seq                start with 1001 nocache;
create sequence logs_id_seq                start with 1001 nocache;
create sequence preferences_id_seq         start with 1001 nocache;
create sequence priorities_id_seq          start with 1001 nocache;
create sequence settings_id_seq            start with 1001 nocache;
create sequence systems_id_seq             start with 1001 nocache;
create sequence tasks_id_seq               start with 1001 nocache;
create sequence tickets_id_seq             start with 1001 nocache;
create sequence translation_strings_id_seq start with 1001 nocache;
create sequence translation_words_id_seq   start with 1001 nocache;
create sequence types_id_seq               start with 1001 nocache;
create sequence users_id_seq               start with 1001 nocache;

/*
**  CREATE INDICES
*/
CREATE INDEX TRANSLATION_LANGUAGE ON ZENTRACK_TRANSLATION_WORDS (language);
CREATE INDEX TRANSLATION_IDENTIFIER ON ZENTRACK_TRANSLATION_WORDS (identifier);
