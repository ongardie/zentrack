
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
   PRIMARY KEY (field_map_id)
);

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  1, 'ticket_create', 0,   1,   0,  0, 1, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  2, 'ticket_create', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  3, 'ticket_create', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  4, 'ticket_create', 0,   2,  50,  1, 1, 'label'   , 'status'     , 'Status'   , null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  5, 'ticket_create', 1, 199,  60, 10, 1, 'text'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  6, 'ticket_create', 1, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  7, 'ticket_create', 0,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  8, 'ticket_create', 1,  40,  50,  1, 1, 'menu'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  9, 'ticket_create', 1,  50,  50,  1, 1, 'menu'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 10, 'ticket_create', 1,  60,  50,  1, 1, 'menu'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 11, 'ticket_create', 1,  70,  50,  1, 0, 'searchbox', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 12, 'ticket_create', 0,  80,  50,  1, 1, 'label'    , 'creator_id' , 'Creator'   ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 13, 'ticket_create', 1,  90,   1,  1, 0, 'checkbox' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 14, 'ticket_create', 1, 94,   1,  1, 0, 'checkbox' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 15, 'ticket_create', 1, 98, 200,  1, 0, 'searchbox', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 16, 'ticket_create', 1,  10,  50,  1, 0, 'searchbox', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 17, 'ticket_create', 1, 120,   6,  1, 0, 'text'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 18, 'ticket_create', 1, 130,  20,  1, 0, 'date'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 19, 'ticket_create', 1, 140,  20,  1, 0, 'date'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 20, 'ticket_create', 0, 150,   6,  1, 0, 'text'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 21, 'ticket_create', 0, 160, 200,  1, 0, 'text'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 22, 'ticket_create', 0, 170, 200,  1, 0, 'text'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 23, 'ticket_create', 0, 180,  50,  4, 0, 'text'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 24, 'ticket_create', 0, 190,  10,  1, 0, 'text'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 25, 'ticket_create', 0, 200,  10,  1, 0, 'text'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 26, 'ticket_create', 0, 210,   1,  1, 0, 'text'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 27, 'ticket_create', 0, 220,   1,  1, 0, 'text'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 28, 'ticket_create', 0, 230, 100,  1, 0, 'menu'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 29, 'ticket_create', 0, 240, 100,  1, 0, 'menu'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  30, 'ticket_create',        1,     5,   100,     1, 'section'  , 'section1' , 'Properties' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  31, 'ticket_create',        1,   100,   100,     1, 'section'  , 'section2' , 'Time Table' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  33, 'ticket_create',        1,   190,   100,     1, 'section'  , 'section3' , 'Description');



-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
