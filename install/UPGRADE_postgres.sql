create sequence "behavior_id_seq" start 1001 increment 1 maxvalue 214783647 minvalue 1 cache 1;
create sequence "group_id_seq" start 1001 increment 1 maxvalue 214783647 minvalue 1 cache 1;

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
  table_name varchar(50) NOT NULL,
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


-- CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5 RC2' WHERE setting_id=74;
