
--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--
CREATE TABLE ZENTRACK_FIELD_MAP {
   field_map_id NUMBER(12) CONSTRAINT fldmap_notnull NOT NULL,
   field_name   VARCHAR2(25) CONSTRAINT fldmap_nm_notnull NOT NULL,
   field_label  VARCHAR2(255) default '',
   default_val  VARCHAR2(255),
   is_visible   NUMBER(1) default 0,
   sort_order   NUMBER(3) default 0,
   which_view   NUMBER(2) default 0,
   field_type   VARCHAR2(25),
   max_inp_len  NUMBER(2) default 0,
   num_rows     NUMBER(2) default 0,
   is_required  NUMBER(1) default 0,
   sys_locked   NUMBER(1) default 0,
   list_source  VARCHAR2(100),
   CONSTRAINT field_map_pk PRIMARY KEY (field_map_id)
}

CREATE INDEX fldmap_id ON ZENTRACK_FIELD_MAP(field_map_id);
CREATE INDEX fldmap_set ON ZENTRACK_FIELD_MAP(field_map_id, is_visible, sort_order, which_view);
CREATE INDEX fldmap_which ON ZENTRACK_FIELD_MAP(which_view);

create sequence field_map_id_seq start with 1001 nocache;

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
