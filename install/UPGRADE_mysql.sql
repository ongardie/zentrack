
--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--
CREATE TABLE ZENTRACK_FIELD_MAP (
   field_map_id INT(12) NOT NULL auto_increment,
   field_name   VARCHAR(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   is_visible   INT(1) default 0,
   which_view   VARCHAR(50) default 0,
   default_val  VARCHAR(255),
   sort_order   INT(4) default 0,
   field_type   VARCHAR(50),
   num_cols     INT(4) default 0,
   num_rows     INT(2) default 0,
   is_required  INT(1) default 0,
   PRIMARY KEY (field_map_id),
   INDEX (sort_order, field_label),
   INDEX (which_view)
);


-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
