
CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id NUMERIC(12) IDENTITY(1,1) NOT NULL,
  behavior_name VARCHAR(100),
  group_id NUMERIC(12) NOT NULL,
  is_enabled NUMERIC(1),
  sort_order NUMERIC(3),
  PRIMARY KEY (behavior_id)
);


CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id NUMERIC(12) NOT NULL,
  field_name VARCHAR(50),
  comparator VARCHAR(2),
  match_value VARCHAR(255),
  sort_order NUMERIC(3)
);

CREATE TABLE ZENTRACK_GROUP (
  group_id NUMERIC(12) IDENTITY(1,1) NOT NULL,
  table_name VARCHAR(50) NOT NULL,
  group_name VARCHAR(100),
  descript VARCHAR(255),
  PRIMARY KEY (group_id)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id NUMERIC(12) NOT NULL,
  value VARCHAR(255),
  sort_order NUMERIC(3)
);


-- CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX values
CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id NUMERIC(12) NOT NULL,
  custom_string1 VARCHAR(255),
  custom_string2 VARCHAR(255),
  custom_string3 VARCHAR(255),
  custom_string4 VARCHAR(255),
  custom_number1 NUMERIC(20),
  custom_number2 NUMERIC(20),
  custom_date1 NUMERIC(12),
  custom_date2 NUMERIC(12),
  custom_text1 TEXT
);


CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name VARCHAR(25) NOT NULL,
  field_label VARCHAR(50),
  sort_order NUMERIC(3),
  is_required NUMERIC(1) default 0,
  use_for_project NUMERIC(1) default 0, 
  use_for_ticket NUMERIC(1) default 0,
  show_in_search NUMERIC(1) default 0,
  show_in_list NUMERIC(1) default 0,
  show_in_custom NUMERIC(1) default 0,
  show_in_detail NUMERIC(1) default 0,
  js_validation TEXT
);

CREATE NONCLUSTERED INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE NONCLUSTERED INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE NONCLUSTERED INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE NONCLUSTERED INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE NONCLUSTERED INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE NONCLUSTERED INDEX var_idx_idx ON ZENTRACK_VARFIELD_IDX (sort_order, field_name);

INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string1', 'Custom String 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string2', 'Custom String 2', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string3', 'Custom String 3', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_string4', 'Custom String 4', 1         );

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
