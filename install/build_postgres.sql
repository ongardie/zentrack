CREATE SEQUENCE "access_access_id_seq"    start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "attachments_attachment_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "bins_bid_seq"            start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "logs_lid_seq"            start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "priorities_pid_seq"      start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "settings_setting_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "systems_sid_seq"         start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "tasks_task_id_seq"       start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "tickets_id_seq"          start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "types_type_id_seq"       start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "users_user_id_seq"       start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "reports_id_seq"          start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "reports_temp_id_seq"     start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "notify_list_id_seq"      start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "behavior_id_seq"         start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "group_id_seq"            start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "agreement_id_seq"        start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "agreement_item_id_seq"   start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "company_id_seq"          start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "employee_id_seq"         start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE "related_contacts_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

--
-- Table structure for `zentrack_agreement`
--

CREATE TABLE zentrack_agreement (
  agree_id NUMBER(12) default nextval('"agreement_id_seq"') NOT NULL PRIMARY KEY,
  company_id NUMBER(12) default NULL,
  contractnr VARCHAR2(50) default NULL,
  title VARCHAR2(50) default NULL,
  description VARCHAR2(4000),
  stime NUMBER(12) default NULL,
  dtime NUMBER(12) default NULL,
  status NUMBER(2) default 1,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL
);

--
-- Table structure for `zentrack_agreement_item`
--

CREATE TABLE zentrack_agreement_item (
  item_id NUMBER(12) default nextval('"agreement_item_id_seq"') NOT NULL PRIMARY KEY,
  agree_id NUMBER(12) default NULL,
  name1 VARCHAR2(50) default NULL,
  description1 VARCHAR2(50) default NULL,
  odate NUMBER(12) default NULL,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL
);

--
-- Table structure for `zentrack_company`
--

CREATE TABLE zentrack_company (
  company_id NUMBER(12) default nextval('"company_id_seq"') NOT NULL PRIMARY KEY,
  title VARCHAR2(50) default NULL,
  office VARCHAR2(50) default NULL,
  address1 VARCHAR2(50) default NULL,
  address2 VARCHAR2(50) default NULL,
  address3 VARCHAR2(50) default NULL,
  postcode VARCHAR2(50) default NULL,
  postcode2 VARCHAR2(50) default NULL,
  pobox VARCHAR2(50) default NULL,
  place VARCHAR2(50) default NULL,
  telephone VARCHAR2(20) default NULL,
  fax VARCHAR2(20) default NULL,
  country VARCHAR2(100) default NULL,
  email VARCHAR2(100) default NULL,
  website VARCHAR2(100) default NULL,
  description VARCHAR2(4000) default NULL,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL
);

--
-- Table structure for `zentrack_employee`
--

CREATE TABLE zentrack_employee (
  person_id NUMBER(12) default nextval('"employee_id_seq"') NOT NULL PRIMARY KEY,
  company_id NUMBER(12) default NULL,
  fname VARCHAR2(50) default NULL,
  lname VARCHAR2(50) default NULL,
  initials VARCHAR2(15) default NULL,
  jobtitle VARCHAR2(50) default NULL,
  department VARCHAR2(50) default NULL,
  email VARCHAR2(100) default NULL,
  telephone VARCHAR2(20) default NULL,
  mobiel VARCHAR2(20) default NULL,
  inextern NUMBER(2) default NULL,
  description VARCHAR2(4000) default NULL,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL
);

--
-- Table structure for `zentrack_related_contacts`
--

CREATE TABLE zentrack_related_contacts (
  clist_id NUMBER(12) default nextval('"related_contacts_id_seq"') NOT NULL PRIMARY KEY,
  ticket_id NUMBER(12) NOT NULL,
  cp_id NUMBER(12) default NULL,
  type NUMBER(12) default NULL
);

--
-- Table structure for table 'ZENTRACK_ACCESS'
--
-- converted to postgreSQL by jofry@users.sourceforge.net
-- 05/03/02
--

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
-- Table structure for 'ZENTRACK_NOTIFY_LIST'
--

CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id int8 default nextval('"notify_id_seq"') NOT NULL PRIMARY KEY,
   ticket_id int8 NOT NULL,
   user_id int8 default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority int8 default NULL,
   notes varchar(255) default NULL
);

--
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id int8 default '0' NOT NULL,
  prefname varchar(25) default NULL,
  prefval  varchar(50) default NULL
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
   show_data_vals int2 default NULL
);

--
-- Release 2.5 new tables
--

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id int8 NOT NULL default nextval('"behavior_id_seq"') NOT NULL PRIMARY KEY,
  behavior_name varchar(100) default NULL,
  group_id int8 NOT NULL,
  is_enabled int2 default NULL,
  sort_order int4 default NULL,
  field_name varchar(100) default NULL,
  field_enabled int4 default NULL,
  match_all int2 default NULL
);

CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id int8 NOT NULL,
  field_name varchar(50) default NULL,
  field_operator varchar(2) default NULL,
  field_value varchar(255) default NULL,
  sort_order int8 default NULL
);

CREATE TABLE ZENTRACK_GROUP (
  group_id int8 NOT NULL default nextval('"group_id_seq"') NOT NULL PRIMARY KEY,
  table_name varchar(50) default NULL,
  group_name varchar(100) default NULL,
  descript varchar(255) default NULL,
  eval_type VARCHAR(10) default NULL,
  eval_text TEXT default NULL
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id int8 NOT NULL,
  field_value varchar(255) default NULL,
  sort_order int8 default NULL
);

CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id int8 NOT NULL,

  -- CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX
  custom_menu1 varchar(255) default NULL,
  custom_menu2 varchar(255) default NULL,

  custom_string1 varchar(255) default NULL,
  custom_string2 varchar(255) default NULL,

  custom_number1 int8 default NULL,
  custom_number2 int8 default NULL,

  custom_boolean1 int2 default NULL,
  custom_boolean2 int2 default NULL,

  custom_date1 int8 default NULL,
  custom_date2 int8 default NULL,

  custom_text1 text default NULL
);

CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name varchar(25) NOT NULL,
  field_label varchar(50) default NULL,
  field_value varchar(100) default NULL,
  sort_order int8 default NULL,
  is_required int2 default 0,
  use_for_project int2 default 0, 
  use_for_ticket int2 default 0,
  show_in_search int2 default 0,
  show_in_list int2 default 0,
  show_in_custom int2 default 0,
  show_in_detail int2 default 0,
  show_in_new int2 default 0,
  js_validation text default NULL

);
