#
# Table structure for table 'ZENTRACK_ACCESS'
#

CREATE TABLE ZENTRACK_ACCESS (
  access_id int(12) NOT NULL auto_increment,
  user_id int(12) default NULL,
  bin_id int(12) default NULL,
  lvl int(2) default NULL,
  notes varchar(25) default NULL,
  PRIMARY KEY (access_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_ATTACHMENTS'
#

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachment_id int(12) NOT NULL auto_increment,
  log_id int(12) default NULL,
  ticket_id int(12) default NULL,
  name varchar(25) default NULL,
  filename varchar(250) default NULL,
  filetype varchar(250) default NULL,
  description varchar(100) default NULL,
  PRIMARY KEY (attachment_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_BINS'
#

CREATE TABLE ZENTRACK_BINS (
  bid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default '1',
  PRIMARY KEY (bid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_LOGS'
#

CREATE TABLE ZENTRACK_LOGS (
  lid int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  user_id int(12) NOT NULL default '0',
  bin_id int(12) NOT NULL default '0',
  created int(12) default NULL,
  action varchar(25) default NULL,
  hours decimal(10,2) default NULL,
  entry text,
  PRIMARY KEY (lid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_LOGS_ARCHIVED'
#

CREATE TABLE ZENTRACK_LOGS_ARCHIVED (
  lid int(12) default NULL,
  ticket_id int(12) default NULL,
  user_id int(12) default NULL,
  bin_id int(12) default NULL,
  created int(12) default NULL,
  action varchar(25) default NULL,
  entry text
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_PREFERENCES'
#

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id int(12) NOT NULL default '0',
  bin int(12) default NULL,
  log varchar(255) default NULL,
  time varchar(255) default NULL,
  close varchar(255) default NULL,
  test varchar(255) default NULL,
  PRIMARY KEY (user_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_PRIORITIES'
#

CREATE TABLE ZENTRACK_PRIORITIES (
  pid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (pid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_SETTINGS'
#

CREATE TABLE ZENTRACK_SETTINGS (
  setting_id int(12) NOT NULL auto_increment,
  name varchar(25) default NULL,
  value varchar(100) default NULL,
  description varchar(200) default NULL,
  PRIMARY KEY (setting_id),
  KEY name(name)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_SYSTEMS'
#

CREATE TABLE ZENTRACK_SYSTEMS (
  sid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (sid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TASKS'
#

CREATE TABLE ZENTRACK_TASKS (
  task_id int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (task_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TICKETS'
#

CREATE TABLE ZENTRACK_TICKETS (
  id int(12) NOT NULL auto_increment,
  title varchar(50) NOT NULL default 'untitled',
  priority int(2) NOT NULL default '0',
  status varchar(25) NOT NULL default 'OPEN',
  description text,
  otime int(12) default NULL,
  ctime int(12) default NULL,
  bin_id int(12) default NULL,
  type_id int(12) default NULL,
  user_id int(12) default NULL,
  system_id int(12) default NULL,
  creator_id int(12) default NULL,
  tested int(1) default '0',
  approved int(1) default '0',
  relations varchar(255) default NULL,
  project_id int(12) default NULL,
  est_hours decimal(10,2) default '0.00',
  deadline int(12) default NULL,
  start_date int(12) default NULL,
  wkd_hours decimal(10,2) default '0.00',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TICKETS_ARCHIVED'
#

CREATE TABLE ZENTRACK_TICKETS_ARCHIVED (
  id int(12) default NULL,
  title varchar(50) default NULL,
  priority int(2) default NULL,
  description text,
  otime int(12) default NULL,
  ctime int(12) default NULL,
  type_id varchar(25) default NULL,
  system_id int(12) default NULL,
  relations varchar(255) default NULL,
  project_id int(12) default NULL,
  est_hours decimal(10,2) default NULL,
  wkd_hours decimal(10,2) default NULL
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TRANSLATION_STRINGS'
#

CREATE TABLE ZENTRACK_TRANSLATION_STRINGS (
  trans_id int(12) NOT NULL auto_increment,
  language varchar(25) default NULL,
  identifier varchar(25) default NULL,
  string varchar(255) default NULL,
  PRIMARY KEY (trans_id),
  KEY language(language)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TRANSLATION_WORDS'
#

CREATE TABLE ZENTRACK_TRANSLATION_WORDS (
  word_id int(12) NOT NULL auto_increment,
  language varchar(25) default NULL,
  identifier varchar(50) default NULL,
  translation varchar(50) default NULL,
  PRIMARY KEY (word_id),
  KEY language(language),
  KEY identifier(identifier)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TYPES'
#

CREATE TABLE ZENTRACK_TYPES (
  type_id int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (type_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_USERS'
#

CREATE TABLE ZENTRACK_USERS (
  user_id int(12) NOT NULL auto_increment,
  login varchar(25) default NULL,
  access_level int(2) default NULL,
  passphrase varchar(32) default NULL,
  lname varchar(50) default NULL,
  fname varchar(50) default NULL,
  initials varchar(5) default NULL,
  email varchar(100) default NULL,
  notes varchar(255) default NULL,
  homebin int(12) default NULL,
  active int(1) default '1',
  PRIMARY KEY (user_id)
) TYPE=MyISAM;