
--DROP TABLE ZENTRACK_FIELD_MAP;

--
-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS
--
CREATE TABLE ZENTRACK_FIELD_MAP (
   field_map_id NUMERIC(12) NOT NULL,
   field_name   VARCHAR(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   is_visible   NUMERIC(1) default 0,
   which_view   VARCHAR(50) default 0,
   default_val  VARCHAR(255),
   sort_order   NUMERIC(4) default 0,
   field_type   VARCHAR(50),
   num_cols     NUMERIC(4) default 0,
   num_rows     NUMERIC(2) default 0,
   is_required  NUMERIC(1) default 0,
   PRIMARY KEY (field_map_id)
);

CREATE INDEX fldmap_sort ON ZENTRACK_FIELD_MAP(sort_order);
CREATE INDEX fldmap_label ON ZENTRACK_FIELD_MAP(field_label);
CREATE INDEX fldmap_both ON ZENTRACK_FIELD_MAP(sort_order,field_label);

INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  2, 'ticket_create', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  3, 'ticket_create', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
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
  ( 13, 'ticket_create', 1,  90,   1,  1, 0, 'checkbox' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 14, 'ticket_create', 0, 94,   1,  1, 0, 'checkbox' , 'approved'  , 'Approval', null );
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

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 34, 'ticket_edit', 1,   1,   8,  1, 1, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 35, 'ticket_edit', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 36, 'ticket_edit', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 37, 'ticket_edit', 0,   2,  50,  1, 1, 'label'   , 'status'     , 'Status'   , null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 38, 'ticket_edit', 1, 199,  60, 10, 1, 'text'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 39, 'ticket_edit', 1, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 40, 'ticket_edit', 1,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 41, 'ticket_edit', 1,  40,  50,  1, 1, 'menu'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 42, 'ticket_edit', 1,  50,  50,  1, 1, 'menu'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 43, 'ticket_edit', 1,  60,  50,  1, 1, 'menu'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 44, 'ticket_edit', 1,  70,  50,  1, 0, 'searchbox', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 45, 'ticket_edit', 0,  80,  50,  1, 1, 'menu'    , 'creator_id' , 'Creator'   ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 46, 'ticket_edit', 1,  90,   1,  1, 0, 'menu' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 47, 'ticket_edit', 0, 94,   1,  1, 0, 'menu' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 48, 'ticket_edit', 1, 98, 200,  1, 0, 'searchbox', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 49, 'ticket_edit', 1,  10,  50,  1, 0, 'searchbox', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 50, 'ticket_edit', 1, 120,   6,  1, 0, 'text'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 51, 'ticket_edit', 1, 130,  20,  1, 0, 'date'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 52, 'ticket_edit', 1, 140,  20,  1, 0, 'date'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 53, 'ticket_edit', 0, 150,   6,  1, 0, 'text'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 54, 'ticket_edit', 0, 160, 200,  1, 0, 'text'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 55, 'ticket_edit', 0, 170, 200,  1, 0, 'text'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 56, 'ticket_edit', 0, 180,  50,  4, 0, 'text'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 57, 'ticket_edit', 0, 190,  10,  1, 0, 'text'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 58, 'ticket_edit', 0, 200,  10,  1, 0, 'text'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 59, 'ticket_edit', 0, 210,   1,  1, 0, 'text'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 60, 'ticket_edit', 0, 220,   1,  1, 0, 'text'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 61, 'ticket_edit', 0, 230, 100,  1, 0, 'menu'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 62, 'ticket_edit', 0, 240, 100,  1, 0, 'menu'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  63, 'ticket_edit',        1,     5,   100,     1, 'section'  , 'section1' , 'Properties' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  64, 'ticket_edit',        1,   100,   100,     1, 'section'  , 'section2' , 'Time Table' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  65, 'ticket_edit',        1,   190,   100,     1, 'section'  , 'section3' , 'Description');

INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 67, 'project_create', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 68, 'project_create', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 70, 'project_create', 1, 199,  60, 10, 1, 'text'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 71, 'project_create', 1, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 72, 'project_create', 0,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 73, 'project_create', 1,  40,  50,  1, 1, 'menu'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 74, 'project_create', 1,  50,  50,  1, 1, 'menu'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 75, 'project_create', 1,  60,  50,  1, 1, 'menu'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 76, 'project_create', 1,  70,  50,  1, 0, 'searchbox', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 78, 'project_create', 0,  90,   1,  1, 0, 'checkbox' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 79, 'project_create', 1, 94,   1,  1, 0, 'checkbox' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 80, 'project_create', 1, 98, 200,  1, 0, 'searchbox', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 81, 'project_create', 1,  10,  50,  1, 0, 'searchbox', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 82, 'project_create', 0, 120,   6,  1, 0, 'text'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 83, 'project_create', 1, 130,  20,  1, 0, 'date'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 84, 'project_create', 1, 140,  20,  1, 0, 'date'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 85, 'project_create', 0, 150,   6,  1, 0, 'text'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 86, 'project_create', 0, 160, 200,  1, 0, 'text'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 87, 'project_create', 0, 170, 200,  1, 0, 'text'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 88, 'project_create', 0, 180,  50,  4, 0, 'text'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 89, 'project_create', 0, 190,  10,  1, 0, 'text'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 90, 'project_create', 0, 200,  10,  1, 0, 'text'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 91, 'project_create', 0, 210,   1,  1, 0, 'text'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 92, 'project_create', 0, 220,   1,  1, 0, 'text'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 93, 'project_create', 0, 230, 100,  1, 0, 'menu'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 94, 'project_create', 0, 240, 100,  1, 0, 'menu'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  95, 'project_create',        1,     5,   100,     1, 'section'  , 'section1' , 'Properties' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  96, 'project_create',        1,   100,   100,     1, 'section'  , 'section2' , 'Time Table' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  (  97, 'project_create',        1,   190,   100,     1, 'section'  , 'section3' , 'Description');

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 98, 'project_edit', 1,   1,   8,  1, 1, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  ( 99, 'project_edit', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (100, 'project_edit', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (101, 'project_edit', 0,   2,  50,  1, 1, 'label'   , 'status'     , 'Status'   , null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (102, 'project_edit', 1, 199,  60, 10, 1, 'text'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (103, 'project_edit', 1, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (104, 'project_edit', 1,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (105, 'project_edit', 1,  40,  50,  1, 1, 'menu'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (106, 'project_edit', 1,  50,  50,  1, 1, 'menu'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (107, 'project_edit', 1,  60,  50,  1, 1, 'menu'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (108, 'project_edit', 1,  70,  50,  1, 0, 'searchbox', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (109, 'project_edit', 0,  80,  50,  1, 1, 'menu'    , 'creator_id' , 'Creator'   ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (110, 'project_edit', 0,  90,   1,  1, 0, 'menu' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (111, 'project_edit', 1, 94,   1,  1, 0, 'menu' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (112, 'project_edit', 1, 98, 200,  1, 0, 'searchbox', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (113, 'project_edit', 1,  10,  50,  1, 0, 'searchbox', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (114, 'project_edit', 0, 120,   6,  1, 0, 'text'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (115, 'project_edit', 1, 130,  20,  1, 0, 'date'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (116, 'project_edit', 1, 140,  20,  1, 0, 'date'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (117, 'project_edit', 0, 150,   6,  1, 0, 'text'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (118, 'project_edit', 0, 160, 200,  1, 0, 'text'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (119, 'project_edit', 0, 170, 200,  1, 0, 'text'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (120, 'project_edit', 0, 180,  50,  4, 0, 'text'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (121, 'project_edit', 0, 190,  10,  1, 0, 'text'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (122, 'project_edit', 0, 200,  10,  1, 0, 'text'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (123, 'project_edit', 0, 210,   1,  1, 0, 'text'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (124, 'project_edit', 0, 220,   1,  1, 0, 'text'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (125, 'project_edit', 0, 230, 100,  1, 0, 'menu'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (126, 'project_edit', 0, 240, 100,  1, 0, 'menu'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  ( 127, 'project_edit',        1,     5,   100,     1, 'section'  , 'section1' , 'Properties' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  ( 128, 'project_edit',        1,   100,   100,     1, 'section'  , 'section2' , 'Time Table' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, field_type, field_name, field_label) VALUES
  ( 129, 'project_edit',        1,   190,   100,     1, 'section'  , 'section3' , 'Description');

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (130, 'ticket_list', 1,   1,   8,  1, 1, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (131, 'ticket_list', 1,  20,  50,  1, 1, 'label'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (132, 'ticket_list', 1,  30,  50,  1, 1, 'label'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (133, 'ticket_list', 0,   2,  50,  1, 1, 'label'   , 'status'     , 'Status'   , null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (134, 'ticket_list', 0, 199,  60, 10, 1, 'label'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (135, 'ticket_list', 0, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (136, 'ticket_list', 0,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (137, 'ticket_list', 1,  40,  50,  1, 1, 'label'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (138, 'ticket_list', 1,  50,  50,  1, 1, 'label'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (139, 'ticket_list', 0,  60,  50,  1, 1, 'label'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (140, 'ticket_list', 1,  70,  50,  1, 0, 'label', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (141, 'ticket_list', 0,  80,  50,  1, 1, 'label'    , 'creator_id' , 'Creator'   ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (142, 'ticket_list', 0,  90,   1,  1, 0, 'label' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (143, 'ticket_list', 0, 94,   1,  1, 0, 'label' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (144, 'ticket_list', 0, 98, 200,  1, 0, 'label', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (145, 'ticket_list', 0,  10,  50,  1, 0, 'label', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (146, 'ticket_list', 0, 120,   6,  1, 0, 'label'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (147, 'ticket_list', 0, 130,  20,  1, 0, 'label'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (148, 'ticket_list', 0, 140,  20,  1, 0, 'label'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (149, 'ticket_list', 0, 150,   6,  1, 0, 'label'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (150, 'ticket_list', 0, 160, 200,  1, 0, 'label'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (151, 'ticket_list', 0, 170, 200,  1, 0, 'label'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (152, 'ticket_list', 0, 180,  50,  4, 0, 'label'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (153, 'ticket_list', 0, 190,  10,  1, 0, 'label'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (154, 'ticket_list', 0, 200,  10,  1, 0, 'label'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (155, 'ticket_list', 0, 210,   1,  1, 0, 'label'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (156, 'ticket_list', 0, 220,   1,  1, 0, 'label'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (157, 'ticket_list', 0, 230, 100,  1, 0, 'label'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (158, 'ticket_list', 0, 240, 100,  1, 0, 'label'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (160, 'ticket_list', 1, 250, 50, 1, 0, 'section', 'elapsed', 'Time', null);
  
  
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (161, 'project_list', 1,   1,   8,  1, 1, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (162, 'project_list', 1,  20,  50,  1, 1, 'label'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (163, 'project_list', 1,  30,  50,  1, 1, 'label'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (164, 'project_list', 0,   2,  50,  1, 1, 'label'   , 'status'     , 'Status'   , null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (165, 'project_list', 0, 199,  60, 10, 1, 'label'    , 'description', 'Description', null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (166, 'project_list', 0, 115,  20,  1, 1, 'label'   , 'otime'      , 'Open Time',   null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (167, 'project_list', 0,   3,  20,  1, 0, 'label'   , 'ctime'      , 'Close Time',  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (168, 'project_list', 1,  40,  50,  1, 1, 'label'    , 'bin_id'     , 'Bin'       ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (169, 'project_list', 0,  50,  50,  1, 1, 'label'    , 'type_id'    , 'Type'      ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (170, 'project_list', 0,  60,  50,  1, 1, 'label'    , 'system_id'  , 'System'    ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (171, 'project_list', 0,  70,  50,  1, 0, 'label', 'user_id'    , 'Owner'     ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (172, 'project_list', 0,  80,  50,  1, 1, 'label'    , 'creator_id' , 'Creator'   ,  null      );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (173, 'project_list', 0,  90,   1,  1, 0, 'label' , 'tested'    , 'Testing', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (174, 'project_list', 0, 94,   1,  1, 0, 'label' , 'approved'  , 'Approval', null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (175, 'project_list', 0, 98, 200,  1, 0, 'label', 'relations' , 'Related'  , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (176, 'project_list', 0,  10,  50,  1, 0, 'label', 'project_id', 'Project'          , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (177, 'project_list', 0, 120,   6,  1, 0, 'label'     , 'est_hours' , 'Estimated Hours' , null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (178, 'project_list', 1, 130,  20,  1, 0, 'label'     , 'start_date', 'Start Date'       , '+1 day' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (179, 'project_list', 1, 140,  20,  1, 0, 'label'     , 'deadline'  , 'Deadline'         , '+1 month' );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (180, 'project_list', 0, 150,   6,  1, 0, 'label'     , 'wkd_hours' , 'Hours Worked'     , 0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (181, 'project_list', 0, 160, 200,  1, 0, 'label'     , 'custom_string1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (182, 'project_list', 0, 170, 200,  1, 0, 'label'     , 'custom_string2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (183, 'project_list', 0, 180,  50,  4, 0, 'label'     , 'custom_text1'  , null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (184, 'project_list', 0, 190,  10,  1, 0, 'label'     , 'custom_number1', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (185, 'project_list', 0, 200,  10,  1, 0, 'label'     , 'custom_number2', null,    0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (186, 'project_list', 0, 210,   1,  1, 0, 'label'     , 'custom_boolean1', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (187, 'project_list', 0, 220,   1,  1, 0, 'label'     , 'custom_boolean2', null,   0 );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (188, 'project_list', 0, 230, 100,  1, 0, 'label'     , 'custom_menu1', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (189, 'project_list', 0, 240, 100,  1, 0, 'label'     , 'custom_menu2', null, null );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (191, 'project_list', 0, 250, 50, 1, 0, 'section', 'elapsed', 'Time', null);
  
-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;
