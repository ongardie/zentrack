
--
-- Table structure for `zentrack_agreement`
--

CREATE TABLE ZENTRACK_AGREEMENT (
  agree_id NUMERIC(12) NOT NULL,
  company_id NUMERIC(12) default NULL,
  contractnr VARCHAR(50) default NULL,
  title VARCHAR(50) default NULL,
  description TEXT,
  stime NUMERIC(12) default NULL,
  dtime NUMERIC(12) default NULL,
  status NUMERIC(2) default 1,
  create_time NUMERIC(12) default NULL,
  change_time NUMERIC(12) default NULL,
  creator_id NUMERIC(12) default NULL,
  change_id NUMERIC(12) default NULL,
  PRIMARY KEY (agree_id)
);

--
-- Table structure for `zentrack_agreement_item`
--

CREATE TABLE ZENTRACK_AGREEMENT_ITEM (
  item_id NUMERIC(12) NOT NULL ,
  agree_id NUMERIC(12) default NULL,
  name1 VARCHAR(50) default NULL,
  description1 VARCHAR(50) default NULL,
  odate NUMERIC(12) default NULL,
  create_time NUMERIC(12) default NULL,
  change_time NUMERIC(12) default NULL,
  creator_id NUMERIC(12) default NULL,
  change_id NUMERIC(12) default NULL,
  PRIMARY KEY (item_id)
);

--
-- Table structure for `zentrack_company`
--

CREATE TABLE ZENTRACK_COMPANY (
  company_id NUMERIC(12) NOT NULL,
  title VARCHAR(50) default NULL,
  office VARCHAR(50) default NULL,
  address1 VARCHAR(50) default NULL,
  address2 VARCHAR(50) default NULL,
  address3 VARCHAR(50) default NULL,
  postcode VARCHAR(50) default NULL,
  postcode2 VARCHAR(50) default NULL,
  pobox VARCHAR(50) default NULL,
  place VARCHAR(50) default NULL,
  telephone VARCHAR(20) default NULL,
  fax VARCHAR(20) default NULL,
  country VARCHAR(100) default NULL,
  email VARCHAR(100) default NULL,
  website VARCHAR(100) default NULL,
  description TEXT,
  create_time NUMERIC(12) default NULL,
  change_time NUMERIC(12) default NULL,
  creator_id NUMERIC(12) default NULL,
  change_id NUMERIC(12) default NULL,
  PRIMARY KEY (company_id)
);

--
-- Table structure for `zentrack_employee`
--

CREATE TABLE ZENTRACK_EMPLOYEE (
  person_id NUMERIC(12) NOT NULL,
  company_id NUMERIC(12) default NULL,
  fname VARCHAR(50) default NULL,
  lname VARCHAR(50) default NULL,
  initials VARCHAR(15) default NULL,
  jobtitle VARCHAR(50) default NULL,
  department VARCHAR(50) default NULL,
  email VARCHAR(100) default NULL,
  telephone VARCHAR(20) default NULL,
  mobiel VARCHAR(20) default NULL,
  inextern NUMERIC(2) default NULL,
  description TEXT,
  create_time NUMERIC(12) default NULL,
  change_time NUMERIC(12) default NULL,
  creator_id NUMERIC(12) default NULL,
  change_id NUMERIC(12) default NULL,
  PRIMARY KEY (person_id)
);

--
-- Table structure for `zentrack_related_contacts`
--

CREATE TABLE ZENTRACK_RELATED_CONTACTS (
  clist_id NUMERIC(12) NOT NULL,
  ticket_id NUMERIC(12) NOT NULL,
  cp_id NUMERIC(12) default NULL,
  type NUMERIC(12) default NULL,
  PRIMARY KEY  (clist_id)
);

--
-- Table structure for table 'ZENTRACK_ACCESS'
--

CREATE TABLE ZENTRACK_ACCESS (
 access_id NUMERIC(12) NOT NULL ,
 [user_id] NUMERIC(12) default NULL,
 bin_id NUMERIC(12) default NULL,
 lvl NUMERIC(12) default NULL,
 [notes] varchar(25) default NULL,
 PRIMARY KEY (access_id)
);

--
-- Table structure for table 'ZENTRACK_ATTACHMENTS'
--

CREATE TABLE ZENTRACK_ATTACHMENTS (
 attachment_id NUMERIC(12) NOT NULL ,
 log_id NUMERIC(12) default NULL,
 ticket_id NUMERIC(12) default NULL,
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
 bid NUMERIC(12) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority NUMERIC(12) default NULL,
 active NUMERIC(12) default '1',
 PRIMARY KEY (bid)
);

CREATE TABLE ZENTRACK_FIELD_MAP (
   field_map_id NUMERIC(12) NOT NULL,
   field_name   VARCHAR(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   is_visible   NUMERIC(1) default 0,
   which_view   VARCHAR(50) default 0,
   default_val  VARCHAR(255),
   sort_order   NUMERIC(4) default 0,
   field_type   VARCHAR(50),
   num_cols     NUMERIC(4) default 0,
   num_rows     NUMERIC(2) default 0,
   is_required  NUMERIC(1) default 0,
   PRIMARY KEY (field_map_id)
);

CREATE TABLE ZENTRACK_LOGS (
 lid NUMERIC(12) NOT NULL ,
 ticket_id NUMERIC(12) NOT NULL default '0',
 [user_id] NUMERIC(12) NOT NULL default '0',
 bin_id NUMERIC(12) NOT NULL default '0',
 created NUMERIC(12) default NULL,
 [action] varchar(25) default NULL,
 hours decimal(10,2) default NULL,
 entry text,
 PRIMARY KEY (lid)
);

--
-- Table structure for 'ZENTRACK_NOTIFY_LIST'
--

CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id NUMERIC(12) NOT NULL,
   ticket_id NUMERIC(12) NOT NULL,
   user_id NUMERIC(12) default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority NUMERIC(12) default NULL,
   notes varchar(255) default NULL,
   PRIMARY KEY (notify_id)
);

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
 [user_id] NUMERIC(12) NOT NULL default '0',
 prefname varchar(25) default NULL,
 prefval varchar(50) default NULL
);

--
-- Table structure for table 'ZENTRACK_PRIORITIES'
--

CREATE TABLE ZENTRACK_PRIORITIES (
 pid NUMERIC(12) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority NUMERIC(12) default NULL,
 active NUMERIC(12) default NULL,
 color varchar(25) default NULL,
 PRIMARY KEY (pid)
);

--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_SETTINGS (
 setting_id NUMERIC(12) NOT NULL ,
 [name] varchar(25) default NULL,
 value varchar(100) default NULL,
 [description] varchar(200) default NULL,
 PRIMARY KEY (setting_id)
);

--
-- Table structure for table 'ZENTRACK_SYSTEMS'
--

CREATE TABLE ZENTRACK_SYSTEMS (
 sid NUMERIC(12) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority NUMERIC(12) default NULL,
 active NUMERIC(12) default NULL,
 PRIMARY KEY (sid)
);

--
-- Table structure for table 'ZENTRACK_TASKS'
--

CREATE TABLE ZENTRACK_TASKS (
 task_id NUMERIC(12) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority NUMERIC(12) default NULL,
 active NUMERIC(12) default NULL,
 PRIMARY KEY (task_id)
);

--
-- Table structure for table 'ZENTRACK_TICKETS'
--

CREATE TABLE ZENTRACK_TICKETS (
 [id] NUMERIC(12) NOT NULL ,
 title varchar(250) NOT NULL default 'untitled',
 priority NUMERIC(12) NOT NULL default '0',
 status varchar(25) NOT NULL default 'OPEN',
 [description] text,
 otime NUMERIC(12) default NULL,
 ctime NUMERIC(12) default NULL,
 bin_id NUMERIC(12) default NULL,
 type_id NUMERIC(12) default NULL,
 [user_id] NUMERIC(12) default NULL,
 system_id NUMERIC(12) default NULL,
 creator_id NUMERIC(12) default NULL,
 tested NUMERIC(12) default '0',
 approved NUMERIC(12) default '0',
 relations varchar(255) default NULL,
 project_id NUMERIC(12) default NULL,
 est_hours decimal(10,2) default '0.00',
 deadline NUMERIC(12) default NULL,
 start_date NUMERIC(12) default NULL,
 wkd_hours decimal(10,2) default '0.00',
 PRIMARY KEY (id)
);

--
-- Table structure for table 'ZENTRACK_TYPES'
--

CREATE TABLE ZENTRACK_TYPES (
 type_id NUMERIC(12) NOT NULL ,
 [name] varchar(25) NOT NULL default '',
 priority NUMERIC(12) default NULL,
 active NUMERIC(12) default NULL,
 PRIMARY KEY (type_id)
);

--
-- Table structure for table 'ZENTRACK_USERS'
--

CREATE TABLE ZENTRACK_USERS (
 [user_id] NUMERIC(12) NOT NULL ,
 login varchar(25) default NULL,
 access_level NUMERIC(12) default NULL,
 passphrase varchar(32) default NULL,
 lname varchar(50) default NULL,
 fname varchar(50) default NULL,
 initials varchar(5) default NULL,
 email varchar(100) default NULL,
 notes varchar(255) default NULL,
 homebin NUMERIC(12) default NULL,
 active NUMERIC(12) default '1',
 PRIMARY KEY (user_id)
);

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id NUMERIC(12) NOT NULL,
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
  group_id NUMERIC(12) NOT NULL,
  table_name VARCHAR(50),
  group_name VARCHAR(100),
  descript VARCHAR(255),
  eval_type VARCHAR(10),
  eval_text TEXT,
  name_of_file VARCHAR(100),
  include_none NUMERIC(1),
  PRIMARY KEY (group_id)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMERIC(12) NOT NULL,
  field_value VARCHAR(255),
  sort_order NUMERIC(3)
);


CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMERIC(12) NOT NULL,
  custom_menu1 VARCHAR(255),
  custom_menu2 VARCHAR(255),
  custom_string1 VARCHAR(255),
  custom_string2 VARCHAR(255),
  custom_number1 NUMERIC(20),
  custom_number2 NUMERIC(20),
  custom_boolean1 NUMERIC(20),
  custom_boolean2 NUMERIC(20),
  custom_date1 NUMERIC(12),
  custom_date2 NUMERIC(12),
  custom_text1 TEXT
);


CREATE INDEX fldmap_sort ON ZENTRACK_FIELD_MAP(sort_order);
CREATE INDEX fldmap_label ON ZENTRACK_FIELD_MAP(field_label);
CREATE INDEX fldmap_both ON ZENTRACK_FIELD_MAP(sort_order,field_label);
CREATE NONCLUSTERED INDEX userprefs_user ON ZENTRACK_PREFERENCES(user_id);
CREATE NONCLUSTERED INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE NONCLUSTERED INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE NONCLUSTERED INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE NONCLUSTERED INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE NONCLUSTERED INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);

-- ADDED IN VERSION 2.6

CREATE TABLE ZENTRACK_VIEW_MAP (
  view_map_id NUMERIC(12) NOT NULL,
  vm_name VARCHAR(25) NOT NULL,
  vm_val  VARCHAR(50) default '',
  vm_type VARCHAR(12) NOT NULL,
  vm_order NUMERIC(4) default 0,
  which_view VARCHAR(50) NOT NULL,
  PRIMARY KEY (view_map_id)
);
CREATE TABLE ZENTRACK_VARFIELD_MULTI (
  multi_id NUMERIC(12) NOT NULL,
  ticket_id NUMERIC(12) NOT NULL default '0',
  field_name varchar(25) NOT NULL default '',
  field_value varchar(255) default NULL,
  PRIMARY KEY  (multi_id)
);
CREATE INDEX view_map_idx ON ZENTRACK_VIEW_MAP(which_view,vm_order);
CREATE INDEX vf_multi_idx ON ZENTRACK_VARFIELD_MULTI(ticket_id);



-- ADDED IN VERSION 2.6.0.1






-- ADDED IN VERSION 2.6.2




