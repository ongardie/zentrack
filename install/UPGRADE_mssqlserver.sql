
--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--
CREATE TABLE ZENTRACK_FIELD_MAP {
   field_map_id NUMERIC(12) NOT NULL,
   field_name   VARCHAR2(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   default_val  VARCHAR(255),
   is_visible   NUMERIC(1) default 0,
   sort_order   NUMERIC(3) default 0,
   which_view   NUMERIC(2) default 0,
   field_type   VARCHAR(25),
   max_inp_len  NUMERIC(2) default 0,
   num_rows     NUMERIC(2) default 0,
   is_required  NUMERIC(1) default 0,
   sys_locked   NUMERIC(1) default 0,
   list_source  VARCHAR(100)
}

CREATE NONCLUSTERED INDEX fldmap_id ON ZENTRACK_FIELD_MAP(field_map_id);
CREATE NONCLUSTERED INDEX fldmap_set ON ZENTRACK_FIELD_MAP(field_map_id, is_visible, sort_order, which_view);
CREATE NONCLUSTERED INDEX fldmap_which ON ZENTRACK_FIELD_MAP(which_view);

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
