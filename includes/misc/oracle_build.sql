#
# Table structure for table 'ZENTRACK_ACCESS'
#

CREATE TABLE ZENTRACK_ACCESS (
  aid     number(12)     NOT NULL auto_increment,
  userID  number(12)     default NULL,
  binID   number(12)     default NULL,
  level   number(2)      default NULL,
  role    varchar(25) default NULL,
  CONSTRAINT access_pk PRIMARY KEY (aid)
) ;

#
# Table structure for table 'ZENTRACK_ATTACHMENTS'
#

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachmentID  number(12)      NOT NULL auto_increment,
  logID         number(12)      default NULL,
  ticketID      number(12)      default NULL,
  name          varchar(25)  default NULL,
  filename      varchar(250) default NULL,
  filetype      varchar(250) default NULL,
  description   varchar(100) default NULL,
  CONSTRAINT attachment_pk PRIMARY KEY (attachmentID)
) ;

#
# Table structure for table 'ZENTRACK_BINS'
#

CREATE TABLE ZENTRACK_BINS (
  bid      number(12)     NOT NULL auto_increment,
  name     varchar(25) NOT NULL default '',
  priority number(4)      default NULL,
  active   number(1)      default '1',
  CONSTRAINT bin_pk PRIMARY KEY (bid)
) ;

#
# Table structure for table 'ZENTRACK_LOGS'
#

CREATE TABLE ZENTRACK_LOGS (
  lid      number(12)       NOT NULL auto_increment,
  ticketID number(12)       NOT NULL default '0',
  userID   number(12)       NOT NULL default '0',
  binID    number(12)       NOT NULL default '0',
  created  number(12)       default NULL,
  action   varchar(25)   default NULL,
  hours    number(10,2) default NULL,
  entry    varchar(4000),
  CONSTRAINT logs_pk PRIMARY KEY (lid)
) ;

#
# Table structure for table 'ZENTRACK_LOGS_ARCHIVED'
#

CREATE TABLE ZENTRACK_LOGS_ARCHIVED (
  lid      number(12)     default NULL,
  ticketID number(12)     default NULL,
  userID   number(12)     default NULL,
  binID    number(12)     default NULL,
  created  number(12)     default NULL,
  action   varchar(25) default NULL,
  entry    varchar(4000)
) ;

#
# Table structure for table 'ZENTRACK_PREFERENCES'
#

CREATE TABLE ZENTRACK_PREFERENCES (
  userID number(12)      NOT NULL default '0',
  bin    number(12)      default NULL,
  log    varchar(255) default NULL,
  time   varchar(255) default NULL,
  close  varchar(255) default NULL,
  test   varchar(255) default NULL,
  CONSTRAINT preferences_pk PRIMARY KEY (userID)
) ;

#
# Table structure for table 'ZENTRACK_PRIORITIES'
#

CREATE TABLE ZENTRACK_PRIORITIES (
  pid      number(12)     NOT NULL auto_increment,
  name     varchar(25) NOT NULL default '',
  priority number(4)      default NULL,
  CONSTRAINT priorities_pk PRIMARY KEY (pid)
) ;

#
# Table structure for table 'ZENTRACK_SETTINGS'
#

CREATE TABLE ZENTRACK_SETTINGS (
  setID       number(12)      NOT NULL auto_increment,
  name        varchar(25)  default NULL,
  value       varchar(100) default NULL,
  description varchar(200) default NULL,
  CONSTRAINT settings_pk PRIMARY KEY (setID)
) ;

#
# Table structure for table 'ZENTRACK_SYSTEMS'
#

CREATE TABLE ZENTRACK_SYSTEMS (
  sid      number(12)     NOT NULL auto_increment,
  name     varchar(25) NOT NULL default '',
  priority number(4)      default NULL,
  CONSTRAINT systems_pk PRIMARY KEY (sid)
) ;

#
# Table structure for table 'ZENTRACK_TASKS'
#

CREATE TABLE ZENTRACK_TASKS (
  taskID   number(12)     NOT NULL auto_increment,
  name     varchar(25) NOT NULL default '',
  priority number(4)      default NULL,
  CONSTRAINT tasks_pk PRIMARY KEY (taskID)
) ;

#
# Table structure for table 'ZENTRACK_TICKETS'
#

CREATE TABLE ZENTRACK_TICKETS (
  id          number(12)       NOT NULL auto_increment,
  title       varchar(50)   NOT NULL default 'untitled',
  priority    number(2)        NOT NULL default '0',
  status      varchar(25)   NOT NULL default 'OPEN',
  description varchar(4000),
  otime       number(12)       default NULL,
  ctime       number(12)       default NULL,
  binID       number(12)       default NULL,
  typeID      number(12)       default NULL,
  userID      number(12)       default NULL,
  systemID    number(12)       default NULL,
  creatorID   number(12)       default NULL,
  tested      number(1)        default '0',
  approved    number(1)        default '0',
  relations   varchar(255)  default NULL,
  projectID   number(12)       default NULL,
  est_hours   number(10,2) default '0.00',
  deadline    number(12)       default NULL,
  start_date  number(12)       default NULL,
  wkd_hours   number(10,2) default '0.00',
  CONSTRAINT tickets_pk PRIMARY KEY (id)
) ;

#
# Table structure for table 'ZENTRACK_TICKETS_ARCHIVED'
#

CREATE TABLE ZENTRACK_TICKETS_ARCHIVED (
  id          number(12)       default NULL,
  title       varchar(50)   default NULL,
  priority    number(2)        default NULL,
  description varchar(4000),
  otime       number(12)       default NULL,
  ctime       number(12)       default NULL,
  typeID      varchar(25)   default NULL,
  systemID    number(12)       default NULL,
  relations   varchar(255)  default NULL,
  projectID   number(12)       default NULL,
  est_hours   number(10,2) default NULL,
  wkd_hours   number(10,2) default NULL
) ;

#
# Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
#

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trID       number(12)      NOT NULL auto_increment,
  language   varchar(25)  default NULL,
  identifier varchar(25)  default NULL,
  string     varchar(255) default NULL,
  CONSTRAINT strings_pk PRIMARY KEY (trID)
) ;

#
# Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
#

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  wordID      number(12)     NOT NULL auto_increment,
  language    varchar(25) default NULL,
  identifier  varchar(50) default NULL,
  translation varchar(50) default NULL,
  CONSTRAINT words_pk PRIMARY KEY (wordID)
) ;

#
# Table structure for table 'ZENTRACK_TYPES'
#

CREATE TABLE ZENTRACK_TYPES (
  typeID   number(12)     NOT NULL auto_increment,
  name     varchar(25)    NOT NULL default '',
  priority number(4)      default NULL,
  CONSTRAINT types_pk PRIMARY KEY (typeID)
) ;

#
# Table structure for table 'ZENTRACK_USERS'
#

CREATE TABLE ZENTRACK_USERS (
  uid      number(12)      NOT NULL auto_increment,
  login    varchar(25)  default NULL,
  access   number(2)       default NULL,
  passwd   varchar(32)  default NULL,
  lname    varchar(50)  default NULL,
  fname    varchar(50)  default NULL,
  initials varchar(5)   default NULL,
  email    varchar(100) default NULL,
  notes    varchar(255) default NULL,
  homebin  number(12)      default NULL,
  active   number(1)       default '1',
  CONSTRAINT users_pk PRIMARY KEY (uid)
) ;

/*
**  CREATE SEQUENCES
*/

create sequence seq_access_id start with 1001 nocache;
create sequence seq_attachments_id start with 1001 nocache;
create sequence seq_bins_id start with 1001 nocache;
create sequence seq_logs_id start with 1001 nocache;
create sequence seq_preferences_id start with 1001 nocache;
create sequence seq_priorities_id start with 1001 nocache;
create sequence seq_settings_id start with 1001 nocache;
create sequence seq_systems_id start with 1001 nocache;
create sequence seq_tasks_id start with 1001 nocache;
create sequence seq_tickets_id start with 1001 nocache;
create sequence seq_translation_strings_id start with 1001 nocache;
create sequence seq_translation_words_id start with 1001 nocache;
create sequence seq_types_id start with 1001 nocache;
create sequence seq_users_id start with 1001 nocache;
