
--
-- Table structure for table 'ZENTRACK_ACCESS'
--

CREATE TABLE ZENTRACK_ACCESS (
 access_id int IDENTITY (1, 1) NOT NULL ,
 [user_id] int default NULL,
 bin_id int default NULL,
 lvl int default NULL,
 [notes] varchar(25) default NULL,
 PRIMARY KEY (access_id)
);

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
 attachment_id int IDENTITY (1, 1) NOT NULL ,
 log_id int default NULL,
 ticket_id int default NULL,
 name varchar(25) default NULL,
 filename varchar(250) default NULL,
 filetype varchar(250) default NULL,
 description varchar(100) default NULL,
 PRIMARY KEY (attachment_id)
);

-- 
-- Table structure for table 'ZENTRACK_BINS'
--

CREATE TABLE ZENTRACK_BINS (
 bid int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority int default NULL,
 active int default '1',
 PRIMARY KEY (bid)
);

--
-- Table structure for table 'ZENTRACK_LOGS'
--

CREATE TABLE ZENTRACK_LOGS (
 lid int IDENTITY (1, 1) NOT NULL ,
 ticket_id int NOT NULL default '0',
 [user_id] int NOT NULL default '0',
 bin_id int NOT NULL default '0',
 created int default NULL,
 [action] varchar(25) default NULL,
 hours decimal(10,2) default NULL,
 entry text,
 PRIMARY KEY (lid)
);

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
 [user_id] int NOT NULL default '0',
 prefname varchar(25) default NULL,
 prefval varchar(50) default NULL
);

--
-- Table structure for table 'ZENTRACK_PRIORITIES'
--

CREATE TABLE ZENTRACK_PRIORITIES (
 pid int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority int default NULL,
 active int default NULL,
 PRIMARY KEY (pid)
);

--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_SETTINGS (
 setting_id int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) default NULL,
 value varchar(100) default NULL,
 [description] varchar(200) default NULL,
 PRIMARY KEY (setting_id)
);

--
-- Table structure for table 'ZENTRACK_SYSTEMS'
--

CREATE TABLE ZENTRACK_SYSTEMS (
 sid int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority int default NULL,
 active int default NULL,
 PRIMARY KEY (sid)
);

--
-- Table structure for table 'ZENTRACK_TASKS'
--

CREATE TABLE ZENTRACK_TASKS (
 task_id int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority int default NULL,
 active int default NULL,
 PRIMARY KEY (task_id)
);

--
-- Table structure for table 'ZENTRACK_TICKETS'
--

CREATE TABLE ZENTRACK_TICKETS (
 [id] int IDENTITY (1, 1) NOT NULL ,
 title varchar(50) NOT NULL default 'untitled',
 priority int NOT NULL default '0',
 status varchar(25) NOT NULL default 'OPEN',
 [description] text,
 otime int default NULL,
 ctime int default NULL,
 bin_id int default NULL,
 type_id int default NULL,
 [user_id] int default NULL,
 system_id int default NULL,
 creator_id int default NULL,
 tested int default '0',
 approved int default '0',
 relations varchar(255) default NULL,
 project_id int default NULL,
 est_hours decimal(10,2) default '0.00',
 deadline int default NULL,
 start_date int default NULL,
 wkd_hours decimal(10,2) default '0.00',
 PRIMARY KEY (id)
);

--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
 type_id int IDENTITY (1, 1) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority int default NULL,
 active int default NULL,
 PRIMARY KEY (type_id)
);

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
 [user_id] int IDENTITY (1, 1) NOT NULL ,
 login varchar(25) default NULL,
 access_level int default NULL,
 passphrase varchar(32) default NULL,
 lname varchar(50) default NULL,
 fname varchar(50) default NULL,
 initials varchar(5) default NULL,
 email varchar(100) default NULL,
 notes varchar(255) default NULL,
 homebin int default NULL,
 active int default '1',
 PRIMARY KEY (user_id)
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS' 
-- 

CREATE TABLE ZENTRACK_REPORTS ( 
  report_id int IDENTITY (1, 1) NOT NULL ,
  report_name varchar(100) default NULL, 
  report_type varchar(25) default NULL, 
  date_selector varchar(25) default NULL, 
  date_value int default NULL, 
  date_range varchar(12) default NULL, 
  date_low int default NULL, 
  chart_title varchar(255) default NULL, 
  chart_subtitle varchar(255) default NULL, 
  chart_add_ttl int default NULL, 
  chart_add_avg int default NULL, 
  chart_type varchar(25) default NULL, 
  chart_options text, 
  data_set text, 
  chart_combine int default NULL, 
  text_output int default NULL, 
  show_data_vals int default NULL, 
  PRIMARY KEY (report_id) 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_INDEX' 
-- 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
  report_id int default NULL, 
  bid int default NULL, 
  [user_id] int default NULL 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_TEMP' 
-- 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
  report_id int IDENTITY (1, 1) NOT NULL ,
  report_name varchar(100) default NULL, 
  report_type varchar(25) default NULL, 
  date_selector varchar(25) default NULL, 
  date_value int default NULL, 
  date_range varchar(12) default NULL, 
  date_low int default NULL, 
  chart_title varchar(255) default NULL, 
  chart_subtitle varchar(255) default NULL, 
  chart_add_ttl int default NULL, 
  chart_add_avg int default NULL, 
  chart_type varchar(25) default NULL, 
  chart_options text, 
  data_set text, 
  created datetime NOT NULL default '0000-00-00 00:00:00', 
  chart_combine int default NULL, 
  text_output int default NULL, 
  show_data_vals int default NULL, 
  PRIMARY KEY (report_id), 
--  KEY tempreports_created(created) 
);

create nonclustered index tempreports_created on ZENTRACK_REPORTS_TEMP(created) ;
create nonclustered index userprefs_user on ZENTRACK_PREFERENCES(user_id);