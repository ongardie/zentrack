
--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--
CREATE TABLE ZENTRACK_FIELD_MAP {
   field_map_id INT(12) NOT NULL auto_increment,
   field_name   VARCHAR(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   default_val  VARCHAR(255),
   is_visible   INT(1) default 0,
   sort_order   INT(3) default 0,
   which_view   INT(2) default 0,
   field_type   VARCHAR(25),
   max_inp_len  INT(2) default 0,
   num_rows     INT(2) default 0,
   is_required  INT(1) default 0,
   sys_locked   INT(1) default 0,
   list_source  VARCHAR(100)
   PRIMARY KEY (field_map_id),
   INDEX (field_map_id, is_visible, sort_order, which_view),
   INDEX (which_view)
}

--                                    field_map_id    field_name       field_label  default_val  is_visible  sort_order    which_view   field_type  max_inp_len  num_rows  is_required  sys_locked  list_source
INSERT INTO ZENTRACK_FIELD_MAP VALUES(          1,     'spacer',        'Details',        NULL,          1,         10,      'create',    'spacer',           0,        0,           0,          0,          NULL );
INSERT INTO ZENTRACK_FIELD_MAP VALUES(          2,  'project_id',       'Project',        NULL,          1,         20,      'create', 'searchbox',          20,        1,           1,          1, 'PROJECT.project_id' );

!!!! NEED BETTER SPEC FOR SYS_LOCKED.. WHAT DOES THIS DO?  WHAT DO WE NEED TO PREVENT/ALLOW?

INSERT INTO ZENTRACK_FIELD_MAP VALUES(          1,     'spacer',  'Custom Fields',        NULL,          1,        100,      'create',    'spacer',           0,        0,           0,          0,          NULL );





INSERT INTO ZENTRACK_FIELD_MAP VALUES(          1,     'spacer',   'Requirements',        NULL,          1,        200,      'create',    'spacer',           0,        0,           0,          0,          NULL );





INSERT INTO ZENTRACK_FIELD_MAP VALUES(          1,     'spacer',    'Description',        NULL,          1,        300,      'create',    'spacer',           0,        0,           0,          0,          NULL );
INSERT INTO ZENTRACK_FIELD_MAP VALUES(          1, 'description',            NULL,        NULL,          1,        310,      'create',    'spacer',           0,        0,           0,          0,          NULL );


# Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
