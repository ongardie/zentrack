--
-- Table structure for table 'ZENTRACK_ACCESS'
--

CREATE TABLE ZENTRACK_ACCESS (
  accessID number(12),
  userID number(12) default NULL,
  binID number(12) default NULL,
  lvl   number(2) default NULL,
  role varchar2(25) default NULL,
  CONSTRAINT access_pk PRIMARY KEY (accessID)
) ;

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachmentID number(12),
  logID number(12) default NULL,
  ticketID number(12) default NULL,
  name varchar2(25) default NULL,
  filename varchar2(250) default NULL,
  filetype varchar2(250) default NULL,
  description varchar2(100) default NULL,
  CONSTRAINT attachment_pk PRIMARY KEY (attachmentID)
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
  ticketID number(12) DEFAULT 0 CONSTRAINT logs_ticketID_not_null NOT NULL,
  userID number(12) DEFAULT 0 CONSTRAINT logs_userID_not_null NOT NULL,
  binID number(12) DEFAULT 0 CONSTRAINT logs_binID_not_null NOT NULL,
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
  ticketID number(12) default NULL,
  userID number(12) default NULL,
  binID number(12) default NULL,
  created number(12) default NULL,
  action varchar2(25) default NULL,
  entry varchar2(2000)
) ;

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  userID number(12) DEFAULT 0,
  bin number(12) default NULL,
  log varchar2(255) default NULL,
  time varchar2(255) default NULL,
  close varchar2(255) default NULL,
  test varchar2(255) default NULL,
  CONSTRAINT preferences_pk PRIMARY KEY (userID)
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
  setID number(12),
  name varchar2(25) default NULL,
  value varchar2(100) default NULL,
  description varchar2(200) default NULL,
  CONSTRAINT settings_pk PRIMARY KEY (setID)
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
  taskID number(12),
  name varchar2(25) CONSTRAINT tasks_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT tasks_pk PRIMARY KEY (taskID)
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
  binID number(12) default NULL,
  typeID number(12) default NULL,
  userID number(12) default NULL,
  systemID number(12) default NULL,
  creatorID number(12) default NULL,
  tested number(1) default 0,
  approved number(1) default 0,
  relations varchar2(255) default NULL,
  projectID number(12) default NULL,
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
  typeID varchar2(25) default NULL,
  systemID number(12) default NULL,
  relations varchar2(255) default NULL,
  projectID number(12) default NULL,
  est_hours decimal(10,2) default NULL,
  wkd_hours decimal(10,2) default NULL
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
--

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trID number(12),
  language varchar2(25) default NULL,
  identifier varchar2(25) default NULL,
  string varchar2(255) default NULL,
  CONSTRAINT trstr_pk PRIMARY KEY (trID)
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
--

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  wordID number(12),
  language varchar2(25) default NULL,
  identifier varchar2(50) default NULL,
  translation varchar2(50) default NULL,
  PRIMARY KEY (wordID)
) ;


--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
  typeID number(12),
  name varchar2(25) CONSTRAINT types_name_not_null NOT NULL,
  priority number(4) default NULL,
  active number(1) default NULL,
  CONSTRAINT types_pk PRIMARY KEY (typeID)
) ;

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
  userID number(12),
  login varchar2(25) default NULL,
  accessLevel number(2) default NULL,
  passwd varchar2(32) default NULL,
  lname varchar2(50) default NULL,
  fname varchar2(50) default NULL,
  initials varchar2(5) default NULL,
  email varchar2(100) default NULL,
  notes varchar2(255) default NULL,
  homebin number(12) default NULL,
  active number(1) default 1,
  CONSTRAINT users_pk PRIMARY KEY (userID)
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
