--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id number(12)  CONSTRAINT notify_id_not_null NOT NULL,
   ticket_id number(12) NOT NULL,
   user_id number(12) default NULL,
   name varchar2(100) default NULL,
   email varchar2(150) default NULL,
   priority number(12) default NULL,
   notes varchar(255) default NULL,
   CONSTRAINT notify_pk PRIMARY KEY (notify_id)
);


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
-- Table structure for table 'ZENTRACK_PREFERENCES'
--

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id number(12) DEFAULT 0,
  prefname varchar2(25) default NULL,
  prefval  varchar2(50) default NULL
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
  passphrase varchar2(32) default NULL,
  lname varchar2(50) default NULL,
  fname varchar2(50) default NULL,
  initials varchar2(5) default NULL,
  email varchar2(100) default NULL,
  notes varchar2(255) default NULL,
  homebin number(12) default NULL,
  active number(1) default 1,
  CONSTRAINT users_pk PRIMARY KEY (user_id)
) ;

-- 
-- Table structure for table 'ZENTRACK_REPORTS' 
-- 

CREATE TABLE ZENTRACK_REPORTS ( 
   report_id number(12) CONSTRAINT reports_id_not_null NOT NULL,
   report_name varchar2(100) default NULL, 
   report_type varchar2(25) default NULL, 
   date_selector varchar2(25) default NULL, 
   date_value number(3) default NULL, 
   date_range varchar2(12) default NULL, 
   date_low number(12) default NULL, 
   chart_title varchar2(255) default NULL, 
   chart_subtitle varchar2(255) default NULL, 
   chart_add_ttl number(1) default NULL, 
   chart_add_avg number(1) default NULL, 
   chart_type varchar2(25) default NULL, 
   chart_options varchar2(2000), 
   data_set varchar2(2000), 
   chart_combine number(1) default NULL, 
   text_output number(1) default NULL, 
   show_data_vals number(1) default NULL, 
  CONSTRAINT reports_pk PRIMARY KEY (report_id)
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_INDEX' 
-- 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
   report_id number(12) default NULL, 
   bid number(12) default NULL, 
   user_id number(12) default NULL 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_TEMP' 
-- 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
   report_id number(12) CONSTRAINT reptemp_id_not_null NOT NULL, 
   report_name varchar2(100) default NULL, 
   report_type varchar2(25) default NULL, 
   date_selector varchar2(25) default NULL, 
   date_value number(3) default NULL, 
   date_range varchar2(12) default NULL, 
   date_low number(12) default NULL, 
   chart_title varchar2(255) default NULL, 
   chart_subtitle varchar2(255) default NULL, 
   chart_add_ttl number(1) default NULL, 
   chart_add_avg number(1) default NULL, 
   chart_type varchar2(25) default NULL, 
   chart_options varchar2(2000), 
   data_set varchar2(2000), 
   created date default to_date('1900-01-01','YYYY-MM-DD'), 
   chart_combine number(1) default NULL, 
   text_output number(1) default NULL, 
   show_data_vals number(1) default NULL, 
   CONSTRAINT reptemp_pk PRIMARY KEY (report_id)
);

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id NUMBER(12) CONSTRAINT bid_not_null NOT NULL,
  behavior_name varchar2(100),
  group_id NUMBER(12) NOT NULL,
  is_enabled NUMBER(1),
  sort_order NUMBER(3),
  field_name varchar2(100),
  match_all NUMBER(1),
  CONSTRAINT behavior_pk PRIMARY KEY (behavior_id)
);

CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id NUMBER(12) CONSTRAINT bdid_notnull NOT NULL,
  field_name varchar2(50),
  field_operator varchar2(2),
  field_value varchar2(255),
  sort_order NUMBER(3)
);

CREATE TABLE ZENTRACK_GROUP (
  group_id NUMBER(12) CONSTRAINT groupid_notnull NOT NULL,
  table_name varchar2(50) NOT NULL,
  group_name varchar2(100),
  descript varchar2(255),
  CONSTRAINT group_pk PRIMARY KEY (group_id)
);


CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMBER(12) CONSTRAINT grp_dtlid_notnull NOT NULL,
  value varchar2(255),
  sort_order NUMBER(3)
);


-- CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX values
CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMBER(12) CONSTRAINT varfld_tid_notnull NOT NULL,
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),
  custom_string1 varchar2(255),
  custom_string2 varchar2(255),
  custom_number1 NUMBER(20),
  custom_number2 NUMBER(20),
  custom_date1 NUMBER(12),
  custom_date2 NUMBER(12),
  custom_text1 VARCHAR2(4000)
);


CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name varchar2(25) CONSTRAINT varf_notnull NOT NULL,
  field_label varchar2(50),
  sort_order NUMBER(3),
  is_required NUMBER(1) default 0,
  use_for_project NUMBER(1) default 0, 
  use_for_ticket NUMBER(1) default 0,
  show_in_search NUMBER(1) default 0,
  show_in_list NUMBER(1) default 0,
  show_in_custom NUMBER(1) default 0,
  show_in_detail NUMBER(1) default 0,
  show_in_new    NUMBER(1) default 0,
  js_validation VARCHAR2(2000)
);

--
--  CREATE SEQUENCES
--

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
create sequence types_id_seq               start with 1001 nocache;
create sequence users_id_seq               start with 1001 nocache;
create sequence reports_id_seq             start with 1001 nocache;
create sequence reports_temp_id_seq        start with 1001 nocache;
create sequence behavior_id_seq            start with 1001 nocache;
create sequence group_id_seq               start with 1001 nocache;

--
--  CREATE INDICES
--

CREATE INDEX REPINDEX_COMB ON ZENTRACK_REPORTS_INDEX (user_id,bid);
CREATE INDEX USERPREF_USER ON ZENTRACK_PREFERENCES (user_id);
CREATE INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE INDEX var_idx_idx ON ZENTRACK_VARFIELD_IDX (sort_order, field_name);

