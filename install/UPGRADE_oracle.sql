
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
  custom_string1 varchar2(255),
  custom_string2 varchar2(255),
  custom_string3 varchar2(255),
  custom_string4 varchar2(255),
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
  js_validation VARCHAR2(2000)
);

create sequence behavior_id_seq       start with 1001 nocache;

CREATE INDEX group_idx ON ZENTRACK_GROUP (group_name);
CREATE INDEX grp_dtl_idx ON ZENTRACK_GROUP_DETAIL (group_id, sort_order);
CREATE INDEX varfield_tid_idx ON ZENTRACK_VARFIELD (ticket_id);
CREATE INDEX behavior_idx ON ZENTRACK_BEHAVIOR (is_enabled);
CREATE INDEX bdtl_idx ON ZENTRACK_BEHAVIOR_DETAIL (behavior_id);
CREATE INDEX var_idx_idx ON ZENTRACK_VARFIELD_IDX (sort_order, field_name);



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
