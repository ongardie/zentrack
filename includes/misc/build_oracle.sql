--
-- Table structure for table 'ZENTRACK_ACCESS'
--

CREATE TABLE ZENTRACK_ACCESS (
  aid int(12) NOT NULL auto_increment,
  userID int(12) default NULL,
  binID int(12) default NULL,
  lvl   int(2) default NULL,
  role varchar(25) default NULL,
  CONSTRAINT access_pk PRIMARY KEY (aid)
) ;

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachmentID int(12) NOT NULL auto_increment,
  logID int(12) default NULL,
  ticketID int(12) default NULL,
  name varchar(25) default NULL,
  filename varchar(250) default NULL,
  filetype varchar(250) default NULL,
  description varchar(100) default NULL,
  CONTRAINT attachment_pk PRIMARY KEY (attachmentID)
) ;

--
-- Table structure for table 'ZENTRACK_BINS'
--

CREATE TABLE ZENTRACK_BINS (
  bid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default '1',
  CONTRAINT bin_pk PRIMARY KEY (bid)
) ;

--
-- Table structure for table 'ZENTRACK_LOGS'
--

CREATE TABLE ZENTRACK_LOGS (
  lid int(12) NOT NULL auto_increment,
  ticketID int(12) NOT NULL default '0',
  userID int(12) NOT NULL default '0',
  binID int(12) NOT NULL default '0',
  created int(12) default NULL,
  action varchar(25) default NULL,
  hours decimal(10,2) default NULL,
  entry text,
  CONTRAINT logs_pk PRIMARY KEY (lid)
) ;

--
-- Table structure for table 'ZENTRACK_LOGS_ARCHIVED'
--

CREATE TABLE ZENTRACK_LOGS_ARCHIVED (
  lid int(12) default NULL,
  ticketID int(12) default NULL,
  userID int(12) default NULL,
  binID int(12) default NULL,
  created int(12) default NULL,
  action varchar(25) default NULL,
  entry text
) ;

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  userID int(12) NOT NULL default '0',
  bin int(12) default NULL,
  log varchar(255) default NULL,
  time varchar(255) default NULL,
  close varchar(255) default NULL,
  test varchar(255) default NULL,
  CONTRAINT preferences_pk PRIMARY KEY (userID)
) ;

--
-- Table structure for table 'ZENTRACK_PRIORITIES'
--

CREATE TABLE ZENTRACK_PRIORITIES (
  pid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  CONTRAINT priorities_pk PRIMARY KEY (pid)
) ;

--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_SETTINGS (
  setID int(12) NOT NULL auto_increment,
  name varchar(25) default NULL,
  value varchar(100) default NULL,
  description varchar(200) default NULL,
  CONTRAINT settings_pk PRIMARY KEY (setID)
) ;

--
-- Table structure for table 'ZENTRACK_SYSTEMS'
--

CREATE TABLE ZENTRACK_SYSTEMS (
  sid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  CONSTRAINT systems_pk PRIMARY KEY (sid)
) ;

--
-- Table structure for table 'ZENTRACK_TASKS'
--

CREATE TABLE ZENTRACK_TASKS (
  taskID int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  CONSTRAINT tasks_pk PRIMARY KEY (taskID)
) ;

--
-- Table structure for table 'ZENTRACK_TICKETS'
--

CREATE TABLE ZENTRACK_TICKETS (
  id int(12) NOT NULL auto_increment,
  title varchar(50) NOT NULL default 'untitled',
  priority int(2) NOT NULL default '0',
  status varchar(25) NOT NULL default 'OPEN',
  description text,
  otime int(12) default NULL,
  ctime int(12) default NULL,
  binID int(12) default NULL,
  typeID int(12) default NULL,
  userID int(12) default NULL,
  systemID int(12) default NULL,
  creatorID int(12) default NULL,
  tested int(1) default '0',
  approved int(1) default '0',
  relations varchar(255) default NULL,
  projectID int(12) default NULL,
  est_hours decimal(10,2) default '0.00',
  deadline int(12) default NULL,
  start_date int(12) default NULL,
  wkd_hours decimal(10,2) default '0.00',
  CONTRAINT tickets_pk PRIMARY KEY (id)
) ;

--
-- Table structure for table 'ZENTRACK_TICKETS_ARCHIVED'
--

CREATE TABLE ZENTRACK_TICKETS_ARCHIVED (
  id int(12) default NULL,
  title varchar(50) default NULL,
  priority int(2) default NULL,
  description text,
  otime int(12) default NULL,
  ctime int(12) default NULL,
  typeID varchar(25) default NULL,
  systemID int(12) default NULL,
  relations varchar(255) default NULL,
  projectID int(12) default NULL,
  est_hours decimal(10,2) default NULL,
  wkd_hours decimal(10,2) default NULL
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
--

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trID int(12) NOT NULL auto_increment,
  language varchar(25) default NULL,
  identifier varchar(25) default NULL,
  string varchar(255) default NULL,
  CONSTRAINT trstr_pk PRIMARY KEY (trID)
) ;

--
-- Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
--

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  wordID int(12) NOT NULL auto_increment,
  language varchar(25) default NULL,
  identifier varchar(50) default NULL,
  translation varchar(50) default NULL,
  PRIMARY KEY (wordID),
  KEY language(language),
  KEY identifier(identifier)
) ;

--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
  typeID int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  CONSTRAINT types_pk PRIMARY KEY (typeID)
) ;

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
  uid int(12) NOT NULL auto_increment,
  login varchar(25) default NULL,
  access int(2) default NULL,
  passwd varchar(32) default NULL,
  lname varchar(50) default NULL,
  fname varchar(50) default NULL,
  initials varchar(5) default NULL,
  email varchar(100) default NULL,
  notes varchar(255) default NULL,
  homebin int(12) default NULL,
  active int(1) default '1',
  CONSTRAINT users_pk PRIMARY KEY (uid)
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