
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


CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id NUMERIC(12) IDENTITY(1,1) NOT NULL,
  behavior_name VARCHAR(100),
  group_id NUMERIC(12) NOT NULL,
  is_enabled NUMERIC(1),
  sort_order NUMERIC(3),
  field_name varchar(100),
  field_enabled NUMERIC(1),
  match_all NUMERIC(1),
  PRIMARY KEY (behavior_id)
);


CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id NUMERIC(12) NOT NULL,
  field_name VARCHAR(50),
  field_operator VARCHAR(2),
  field_value VARCHAR(255),
  sort_order NUMERIC(3)
);

CREATE TABLE ZENTRACK_GROUP (
  group_id NUMERIC(12) IDENTITY(1,1) NOT NULL,
  table_name VARCHAR(50) NOT NULL,
  group_name VARCHAR(100),
  descript VARCHAR(255),
  eval_type VARCHAR(10),
  eval_text TEXT,
  PRIMARY KEY (group_id)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMERIC(12) NOT NULL,
  field_value VARCHAR(255),
  sort_order NUMERIC(3)
);


-- CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX values
CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMERIC(12) NOT NULL,
  custom_menu1 VARCHAR(255),
  custom_menu2 VARCHAR(255),
  custom_string1 VARCHAR(255),
  custom_string2 VARCHAR(255),
  custom_number1 NUMERIC(20),
  custom_number2 NUMERIC(20),
  custom_date1 NUMERIC(12),
  custom_date2 NUMERIC(12),
  custom_text1 TEXT
);


CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name VARCHAR(25) NOT NULL,
  field_label VARCHAR(50),
  field_value VARCHAR(200),
  sort_order NUMERIC(3),
  is_required NUMERIC(1) default 0,
  use_for_project NUMERIC(1) default 0, 
  use_for_ticket NUMERIC(1) default 0,
  show_in_search NUMERIC(1) default 0,
  show_in_list NUMERIC(1) default 0,
  show_in_custom NUMERIC(1) default 0,
  show_in_detail NUMERIC(1) default 0,
  show_in_new    NUMERIC(1) default 0,
  js_validation TEXT
);

CREATE NONCLUSTERED INDEX tempreports_created ON ZENTRACK_REPORTS_TEMP(created) ;
CREATE NONCLUSTERED INDEX userprefs_user ON ZENTRACK_PREFERENCES(user_id);
CREATE NONCLUSTERED INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE NONCLUSTERED INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE NONCLUSTERED INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE NONCLUSTERED INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE NONCLUSTERED INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE NONCLUSTERED INDEX var_idx_idx ON ZENTRACK_VARFIELD_IDX (sort_order, field_name);

