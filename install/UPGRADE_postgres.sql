
--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--

CREATE SEQUENCE "field_map_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

CREATE TABLE ZENTRACK_FIELD_MAP {
   field_map_id int8 default nextval('"field_map_id_seq"') NOT NULL PRIMARY KEY,
   field_name   VARCHAR(25) NOT NULL DEFAULT '',
   field_label  VARCHAR(255) default '',
   default_val  VARCHAR(255) DEFAULT NULL,
   is_visible   int8 default 0,
   sort_order   int8 default 0,
   which_view   int8 default 0,
   field_type   VARCHAR(25) DEFAULT NULL,
   max_inp_len  int8 default 0,
   num_rows     int8 default 0,
   is_required  int8 default 0,
   sys_locked   int8 default 0,
   list_source  VARCHAR(100) DEFAULT NULL
}

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
