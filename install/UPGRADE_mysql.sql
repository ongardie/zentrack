
CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id int(12) NOT NULL auto_increment,
  behavior_name varchar(100),
  group_id int(12) NOT NULL,
  is_enabled int(1),
  sort_order int(3),
  field_name varchar(100),
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
  PRIMARY KEY (group_id),
  INDEX (group_name)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id int(12) NOT NULL,
  value varchar(255),
  sort_order int(3),
  INDEX (group_id, sort_order)
);

CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id int(12) NOT NULL,

  /* CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX */
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),

  custom_string1 varchar(255),
  custom_string2 varchar(255),

  custom_number1 int(20),
  custom_number2 int(20),

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
                           VALUES ('custom_date1', 'Custom Date 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_date2', 'Custom Date 2', 1         );

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_text1', 'Custom Text 1', 1         );
