
create sequence "behavior_id_seq"         start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
create sequence "group_id_seq"            start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE sequence "agreement_id_seq"        start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE sequence "agreement_item_id_seq"   start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE sequence "company_id_seq"          start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE sequence "employee_id_seq"         start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE sequence "related_contacts_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

--
-- Table structure for `zentrack_agreement`
--

CREATE TABLE ZENTRACK_AGREEMENT (
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

CREATE TABLE ZENTRACK_AGREEMENT_ITEM (
  item_id NUMBER(12) default nextval('"agreement_item_id_seq"') NOT NULL PRIMARY KEY,
  agree_id NUMBER(12) default NULL,
  name1 VARCHAR2(50) default NULL,
  description1 VARCHAR2(50) default NULL,
  odate NUMBER(12) default NULL,
  create_time NUMBER(12) default NULL,
  change_time NUMBER(12) default NULL,
  creator_id NUMBER(12) default NULL,
  change_id NUMBER(12) default NULL
)

--
-- Table structure for `zentrack_company`
--

CREATE TABLE ZENTRACK_COMPANY (
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
)

--
-- Table structure for `zentrack_employee`
--

CREATE TABLE ZENTRACK_EMPLOYEE (
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
)

--
-- Table structure for `zentrack_related_contacts`
--

CREATE TABLE ZENTRACK_RELATED_CONTACTS (
  clist_id NUMBER(12) default nextval('"related_contacts_id_seq"') NOT NULL PRIMARY KEY,
  ticket_id NUMBER(12) NOT NULL,
  cp_id NUMBER(12) default NULL,
  type NUMBER(12) default NULL
)

--
-- Behavior tables
--

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id int8 default nextval('"behavior_id_seq"') NOT NULL PRIMARY KEY,
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

--
-- Group tables
--

CREATE TABLE ZENTRACK_GROUP (
  group_id int8 default nextval('"group_id_seq"') NOT NULL PRIMARY KEY,
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

--
-- Variable Field tables
--

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


INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_menu2', 'Custom Menu 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string1', 'Custom String 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string2', 'Custom String 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_number1', 'Custom Number 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_number2', 'Custom Number 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_boolean1', 'Custom Boolean 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_boolean2', 'Custom Boolean 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_date1', 'Custom Date 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_date2', 'Custom Date 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_text1', 'Custom Text 1', 1         );

INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (96,'level_edit_varfields','2','Access level required to edit fields on the "custom" tab.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (97,'varfield_tab_name', 'Custom', 'Name to appear on the variable fields tab');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (98,'allow_htaccess', 'on', 'If on, will attempt to authenticate users based on apache htaccess (username and password must match ZT)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (99,'allow_contacts', 'on', 'Specify whether contacts will be used or not');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (100,'level_contacts','3','Level required to view the contacts');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (101,'paging_max_rows','20','Number of rows to display at a time');


-- CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5 RC2' WHERE setting_id=74;
