
--
-- Table structure for `zentrack_agreement`
--

CREATE TABLE ZENTRACK_AGREEMENT (
  agree_id NUMBER(12) CONSTRAINT agree_id_notnull NOT NULL,
  company_id NUMBER(12) default NULL,
  contractnr VARCHAR2(50) default NULL,
  title VARCHAR2(50) default NULL,
  description VARCHAR2(4000) default NULL,
  stime NUMBER(12) default NULL,
  dtime NUMBER(12) default NULL,
  status NUMBER(2) default 1,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL,
  CONSTRAINT agree_pk1 PRIMARY KEY (agree_id)
);

--
-- Table structure for `zentrack_agreement_item`
--

CREATE TABLE ZENTRACK_AGREEMENT_ITEM (
  item_id NUMBER(12) CONSTRAINT agree_item_pk_notnull NOT NULL ,
  agree_id NUMBER(12) default NULL,
  name1 VARCHAR2(50) default NULL,
  description1 VARCHAR2(50) default NULL,
  odate NUMBER(12) default NULL,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL,
  CONSTRAINT agree_item_pk1 PRIMARY KEY (item_id)
);

--
-- Table structure for `zentrack_company`
--

CREATE TABLE ZENTRACK_COMPANY (
  company_id NUMBER(12) CONSTRAINT company_pk_notnull NOT NULL,
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
  change_id NUMBER(12) default NULL,
  CONSTRAINT company_pk1 PRIMARY KEY (company_id)
);

--
-- Table structure for `zentrack_employee`
--

CREATE TABLE ZENTRACK_EMPLOYEE (
  person_id NUMBER(12) CONSTRAINT employee_pk_notnull NOT NULL,
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
  change_id NUMBER(12) default NULL,
  CONSTRAINT employee_pk1 PRIMARY KEY (person_id)
);

CREATE TABLE ZENTRACK_FIELD_MAP (
   field_map_id NUMBER(12) CONSTRAINT fldmap_notnull NOT NULL,
   field_name   VARCHAR2(25) CONSTRAINT fldmap_nm_notnull NOT NULL,
   field_label  VARCHAR2(255) default '',
   is_visible   NUMBER(1) default 0,
   which_view   VARCHAR2(50) default 0,
   default_val  VARCHAR2(255),
   sort_order   NUMBER(4) default 0,
   field_type   VARCHAR2(50),
   num_cols     NUMBER(4) default 0,
   num_rows     NUMBER(2) default 0,
   is_required  NUMBER(1) default 0,
   CONSTRAINT field_map_pk PRIMARY KEY (field_map_id)
);

--
-- Table structure for `zentrack_related_contacts`
--

CREATE TABLE ZENTRACK_RELATED_CONTACTS (
  clist_id NUMBER(12) CONSTRAINT relatedcont_pk_notnull NOT NULL,
  ticket_id NUMBER(12) CONSTRAINT relatedcont_tid_notnull NOT NULL,
  cp_id NUMBER(12) default NULL,
  type NUMBER(12) default NULL,
  CONSTRAINT relatedcontr_pk1 PRIMARY KEY  (clist_id)
);


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
  color varchar2(25) default NULL,
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
  title varchar2(250) default 'untitled' CONSTRAINT tickets_title_not_null NOT NULL,
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

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id NUMBER(12) CONSTRAINT bid_not_null NOT NULL,
  behavior_name varchar2(100),
  group_id NUMBER(12) NOT NULL,
  is_enabled NUMBER(1),
  sort_order NUMBER(3),
  field_name varchar2(100),
  field_enabled NUMBER(1),
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
  table_name varchar2(50),
  group_name varchar2(100),
  descript varchar2(255),
  eval_type VARCHAR2(10),
  eval_text VARCHAR2(4000),
  name_of_file VARCHAR2(100),
  include_none NUMBER(1),
  CONSTRAINT group_pk PRIMARY KEY (group_id)
);


CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMBER(12) CONSTRAINT grp_dtlid_notnull NOT NULL,
  field_value varchar2(255),
  sort_order NUMBER(3)
);


CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMBER(12) CONSTRAINT varfld_tid_notnull NOT NULL,
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),
  custom_string1 varchar2(255),
  custom_string2 varchar2(255),
  custom_number1 NUMBER(20),
  custom_number2 NUMBER(20),
  custom_boolean1 NUMBER(1),
  custom_boolean2 NUMBER(1),
  custom_date1 NUMBER(12),
  custom_date2 NUMBER(12),
  custom_text1 VARCHAR2(4000)
);

--
--  CREATE SEQUENCES
--

create sequence access_id_seq              start with 1001 nocache;
create sequence attachments_id_seq         start with 1001 nocache;
create sequence bins_id_seq                start with 1001 nocache;
create sequence field_map_id_seq           start with 1001 nocache;
create sequence logs_id_seq                start with 1001 nocache;
create sequence preferences_id_seq         start with 1001 nocache;
create sequence priorities_id_seq          start with 1001 nocache;
create sequence settings_id_seq            start with 1001 nocache;
create sequence systems_id_seq             start with 1001 nocache;
create sequence tasks_id_seq               start with 1001 nocache;
create sequence tickets_id_seq             start with 1001 nocache;
create sequence types_id_seq               start with 1001 nocache;
create sequence users_id_seq               start with 1001 nocache;
create sequence behavior_id_seq            start with 1001 nocache;
create sequence group_id_seq               start with 1001 nocache;
create sequence agreement_id_seq           start with 1001 nocache;
create sequence agreement_item_id_seq      start with 1001 nocache;
create sequence company_id_seq             start with 1001 nocache;
create sequence employee_id_seq            start with 1001 nocache;
create sequence related_contacts_id_seq    start with 1001 nocache;

--
--  CREATE INDICES
--


-- ADDED IN VERSION 2.6

CREATE TABLE ZENTRACK_VIEW_MAP (
  view_map_id NUMBER(12) NOT NULL,
  vm_name VARCHAR2(25) NOT NULL,
  vm_val  VARCHAR2(50) default '',
  vm_type VARCHAR2(12) NOT NULL,
  vm_order NUMBER(4) default 0,
  which_view VARCHAR2(50) NOT NULL,
  CONSTRAINT view_map_id_pk1 PRIMARY KEY (view_map_id)
);

CREATE TABLE ZENTRACK_VARFIELD_MULTI (
  multi_id NUMBER(12) NOT NULL,
  ticket_id NUMBER(12) default '0',
  field_name VARCHAR2(25) default '',
  field_value VARCHAR2(255) default NULL,
  CONSTRAINT multi_id_pk1 PRIMARY KEY (multi_id)
);

CREATE SEQUENCE view_map_id_seq start with 1001 nocache;
CREATE SEQUENCE varfield_multi_id_seq start with 1001 nocache;



-- ADDED IN VERSION 2.6.3
CREATE INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE INDEX fldmap_both ON ZENTRACK_FIELD_MAP(sort_order,field_label);
CREATE INDEX fldmap_label ON ZENTRACK_FIELD_MAP(field_label);
CREATE INDEX fldmap_sort ON ZENTRACK_FIELD_MAP(sort_order);
CREATE INDEX USERPREF_USER ON ZENTRACK_PREFERENCES (user_id);
CREATE INDEX vf_multi_idx ON ZENTRACK_VARFIELD_MULTI(ticket_id);
CREATE INDEX view_map_idx ON ZENTRACK_VIEW_MAP(which_view,vm_order);
CREATE INDEX zt_log_action ON ZENTRACK_LOGS(action);
CREATE INDEX zt_log_tid ON ZENTRACK_LOGS(ticket_id);
CREATE INDEX zt_tk_pri_idx ON ZENTRACK_TICKETS(priority);
CREATE INDEX zt_tk_status_idx ON ZENTRACK_TICKETS(status);
CREATE INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);


-- ADDED IN VERSION 2.6.4


CREATE INDEX zt_user_init_idx ON ZENTRACK_USERS(initials);
CREATE INDEX zt_user_name_idx ON ZENTRACK_USERS(fname,lname);
CREATE INDEX zt_user_email_idx ON ZENTRACK_USERS(email);
CREATE INDEX zt_comp_title_idx ON ZENTRACK_COMPANY(title);
CREATE INDEX zt_comp_email_idx ON ZENTRACK_COMPANY(email);
CREATE INDEX zt_emp_name_idx ON ZENTRACK_EMPLOYEE(fname,lname);
CREATE INDEX zt_notf_name_idx ON ZENTRACK_NOTIFY_LIST(name);
CREATE INDEX zt_notf_email_idx ON ZENTRACK_NOTIFY_LIST(email);

