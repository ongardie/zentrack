
--
-- Table structure for `zentrack_agreement`
--

CREATE TABLE zentrack_agreement (
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

CREATE TABLE zentrack_agreement_item (
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

CREATE TABLE zentrack_company (
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

CREATE TABLE zentrack_employee (
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

--
-- Table structure for `zentrack_related_contacts`
--

CREATE TABLE zentrack_related_contacts (
  clist_id NUMBER(12) CONSTRAINT relatedcont_pk_notnull NOT NULL,
  ticket_id NUMBER(12) CONSTRAINT relatedcont_tid_notnull NOT NULL,
  cp_id NUMBER(12) default NULL,
  type NUMBER(12) default NULL,
  CONSTRAINT relatedcontr_pk1 PRIMARY KEY  (clist_id)
);

--
-- Table structure for behaviors
--

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

--
-- Table structure for groups
--

CREATE TABLE ZENTRACK_GROUP (
  group_id NUMBER(12) CONSTRAINT groupid_notnull NOT NULL,
  table_name varchar2(50) NOT NULL,
  group_name varchar2(100),
  descript varchar2(255),
  eval_type VARCHAR2(10),
  eval_text VARCHAR2(4000),
  CONSTRAINT group_pk PRIMARY KEY (group_id)
);


CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMBER(12) CONSTRAINT grp_dtlid_notnull NOT NULL,
  value varchar2(255),
  sort_order NUMBER(3)
);

--
-- Table structure for Variable Fields
-- CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX values
--
CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMBER(12) CONSTRAINT varfld_tid_notnull NOT NULL,
  custom_menu1 VARCHAR2(255),
  custom_menu2 VARCHAR2(255),
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
  js_validation VARCHAR2(4000)
);

CREATE sequence behavior_id_seq         start with 1001 nocache;
CREATE sequence group_id_seq            start with 1001 nocache;
CREATE sequence agreement_id_seq        start with 1001 nocache;
CREATE sequence agreement_item_id_seq   start with 1001 nocache;
CREATE sequence company_id_seq          start with 1001 nocache;
CREATE sequence employee_id_seq         start with 1001 nocache;
CREATE sequence related_contacts_id_seq start with 1001 nocache;

CREATE INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE INDEX var_idx_idx ON ZENTRACK_VARFIELD_IDX (sort_order, field_name);


INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_menu1', 'Custom Menu 1', 1         );
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

-- CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;

-- Change the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5 RC2' WHERE setting_id=74;


