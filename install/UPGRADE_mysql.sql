
CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id int(12) NOT NULL auto_increment,
  behavior_name varchar(100),
  group_id int(12) NOT NULL,
  is_enabled int(1),
  sort_order int(3),
  field_name varchar(100),
  field_enabled int(1),
  match_all int(1),
  PRIMARY KEY (behavior_id),
  INDEX (is_enabled)
);

CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id int(12) NOT NULL,
  field_name varchar(50),
  field_operator varchar(2),
  field_value varchar(255),
  sort_order int(3)
);

CREATE TABLE ZENTRACK_GROUP (
  group_id int(12) NOT NULL auto_increment,
  table_name varchar(50) NOT NULL,
  group_name varchar(100),
  descript varchar(255),
  eval_type VARCHAR(10),
  eval_text TEXT,
  PRIMARY KEY (group_id),
  INDEX (group_name)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id int(12) NOT NULL,
  field_value varchar(255),
  sort_order int(3),
  INDEX (group_id, sort_order)
);

CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id int(12) NOT NULL,

  /* CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX #
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),

  custom_string1 varchar(255),
  custom_string2 varchar(255),

  custom_number1 int(20),
  custom_number2 int(20),

  custom_boolean1 int(1),
  custom_boolean2 int(1),

  custom_date1 int(12),
  custom_date2 int(12),

  custom_text1 text,

  INDEX (ticket_id)
);

CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name varchar(25) NOT NULL,
  field_label varchar(50),
  field_value varchar(100),
  sort_order int(3),
  is_required int(1) default 0,
  use_for_project int(1) default 0, 
  use_for_ticket int(1) default 0,
  show_in_search int(1) default 0,
  show_in_list int(1) default 0,
  show_in_custom int(1) default 0,
  show_in_detail int(1) default 0,
  show_in_new    int(1) default 0,
  js_validation text,
  INDEX (sort_order, field_name)
);

#
# Table structure for `zentrack_agreement`
#

CREATE TABLE zentrack_agreement (
  agree_id int(12) NOT NULL auto_increment,
  company_id int(12) default NULL,
  contractnr varchar(50) default NULL,
  title varchar(50) default NULL,
  description text,
  stime int(12) default NULL,
  dtime int(12) default NULL,
  status int(2) default '1',
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (agree_id)
);

#
# Table structure for `zentrack_agreement_item`
#

CREATE TABLE zentrack_agreement_item (
  item_id int(12) NOT NULL auto_increment,
  agree_id int(12) default NULL,
  name1 varchar(50) default NULL,
  description1 varchar(50) default NULL,
  odate int(12) default NULL,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (item_id)
);

#
# Table structure for `zentrack_company`
#

CREATE TABLE zentrack_company (
  company_id int(12) NOT NULL auto_increment,
  title varchar(50) default NULL,
  office varchar(50) default NULL,
  address1 varchar(50) default NULL,
  address2 varchar(50) default NULL,
  address3 varchar(50) default NULL,
  postcode varchar(50) default NULL,
  postcode2 varchar(50) default NULL,
  pobox varchar(50) default NULL,
  place varchar(50) default NULL,
  telephone varchar(20) default NULL,
  fax varchar(20) default NULL,
  country varchar(100) default NULL,
  email varchar(100) default NULL,
  website varchar(100) default NULL,
  description text,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (company_id)
);

#
# Table structure for `zentrack_employee`
#

CREATE TABLE zentrack_employee (
  person_id int(12) NOT NULL auto_increment,
  company_id int(12) default NULL,
  fname varchar(50) default NULL,
  lname varchar(50) default NULL,
  initials varchar(15) default NULL,
  jobtitle varchar(50) default NULL,
  department varchar(50) default NULL,
  email varchar(100) default NULL,
  telephone varchar(20) default NULL,
  mobiel varchar(20) default NULL,
  inextern int(2) default NULL,
  description text,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (person_id)
);

#
# Table structure for `zentrack_related_contacts`
#

CREATE TABLE zentrack_related_contacts (
  clist_id int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  cp_id int(12) default NULL,
  type int(12) default NULL,
  PRIMARY KEY  (clist_id)
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

# CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE */
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;

# Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5 RC2' WHERE setting_id=74;


