
--
-- Load data for table 'ZENTRACK_ACCESS'
--

INSERT INTO ZENTRACK_ACCESS (access_id, user_id, bin_id, lvl, notes) VALUES (1,2,2,1,NULL);
INSERT INTO ZENTRACK_ACCESS (access_id, user_id, bin_id, lvl, notes) VALUES (2,2,3,1,NULL);
INSERT INTO ZENTRACK_ACCESS (access_id, user_id, bin_id, lvl, notes) VALUES (3,2,3,2,NULL);
INSERT INTO ZENTRACK_ACCESS (access_id, user_id, bin_id, lvl, notes) VALUES (4,2,4,1,NULL);
INSERT INTO ZENTRACK_ACCESS (access_id, user_id, bin_id, lvl, notes) VALUES (5,2,3,1,NULL);

--
-- Load data for table 'ZENTRACK_BINS'
--

INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (1,'Accounting',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (2,'Engineering',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (3,'Marketing',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (4,'IT',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (5,'Tech Support',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (6,'Human Resources',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (7,'Test Bin',0,0);

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  1, 'ticket_create', 0,   1,   8,  1, 0, 'label'   , 'id'         , 'ID'       , null        );
INSERT INTO ZENTRACK_FIELD_MAP(field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  2, 'ticket_create', 1,  20, 200,  1, 1, 'text'    , 'title'      , 'Title'    , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  3, 'ticket_create', 1,  30,  50,  1, 1, 'menu'    , 'priority'   , 'Priority' , null        );
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (  4, 'ticket_create', 0,   2,  50,  1, 0, 'label'   , 'status'     , 'Status'   , null      );
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
  ( 12, 'ticket_create', 0,  80,  50,  1, 0, 'label'    , 'creator_id' , 'Creator'   ,  null      );
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
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (192, 'ticket_close', 1, 10, 10, 1, 0, 'text', 'hours', 'Hours', 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (193, 'ticket_close', 1, 20, 80, 5, 1, 'textarea', 'comments', 'Comments', null);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id, which_view, is_visible, sort_order, num_cols, num_rows, is_required, field_type, field_name, field_label, default_val ) VALUES
  (194, 'ticket_close', 1, 30, 100, 1, 1, 'menu', 'custom_menu2', null, null);


--
-- Load data for table 'ZENTRACK_LOGS'
--

INSERT INTO ZENTRACK_LOGS (lid, ticket_id, user_id, bin_id, created, action, hours, entry) VALUES (1,2,1,2,1019621210,'ACCEPTED',NULL,NULL);

--
-- Load data for table 'ZENTRACK_PRIORITIES'
--

INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (1,'Critical',5,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (2,'High',4,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (3,'Medium',3,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (4,'Low',2,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (6,'None',1,1);

--
-- Load data for table 'ZENTRACK_SETTINGS'
--

INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (1,'admin_email','root@localhost','The email address of the zenTrack administrator');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (2,'bot_name','zenBot','The system bots name');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (3,'allow_cview','on','Allow ticket creator to view the ticket, regardless of access');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (4,'allow_reject','on','Allow tickets to be rejected');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (5,'allow_yank','on','Allow tickets to be yanked');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (6,'allow_assign','on','Allow tickets to be assigned');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (7,'allow_accept','on','Allow tickets to be accepted');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (8,'allow_relate','on','Allow tickets to be related to one another');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (9,'attachment_max_size','20000','The maximum file size of an attachment (in Bytes)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (10,'attachment_text_types','php,txt,pl,cgi,asp,jsp,java,class,inc','Files with this extention will be displayed as text by the browser');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (11,'attachment_types_allowed','txt,html,xls,pdf,jpg,gif,png,doc,wpd,php','Comma seperated list.  Only these extensions may be uploaded.  Set to 0 to allow all (WARNING:  this is a security risk!)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (12,'color_links','#006633','Color of links on the page');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (13,'color_grey','#666666','Greyed text color');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (14,'color_background','#FFFFFF','Color of normal bg');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (15,'color_text','#000000','Color of normal text');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (16,'color_alt_background','#99CCCC','Color of alternate bg');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (17,'color_alt_text','#000066','Color of alternate text');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (18,'color_title_background','#669999','Color of title cell bg');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (19,'color_title_text','#FFFFFF','Color of title cell text');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (20,'color_bars','#EAEAEA','Color of background in rows of data');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (21,'color_bar_text','#006666','Color of text in rows of data');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (22,'color_hot','#990000','Color of text when hot(critical/errors)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (23,'color_highlight','#CCFFCC','Color of background to highlight text');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (24,'color_hover','#00FF33','Color of links on mouseover (hover)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (25,'default_test_checked','on','Testing required defaults to yes');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (26,'default_aprv_checked','off','Approval required defaults to yes');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (27,'email_pending','on','Send email to tester/approver when ticket is pending');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (28,'email_reject','on','Send email to sender/creator when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (29,'email_assign','on','Send email to recipient when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (30,'email_arrival','on','Send email to bin owner when ticket arrives in bin');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (31,'email_created','on','Send email to bin owner when ticket is created');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (32,'email_closed','on','Send email to bin owner when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (33,'email_completed','on','Send email to bin owner when ticket is completed');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (34,'email_max_logs','40','Maximum logs to send via email.  Set to blank for unlimited');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (35,'font_size','12','Font size on pages, in pixels');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (36,'font_face','Arial, Helvetica','Font face to appear on pages, comma seperated list');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (37,'level_create','2','Level required to create a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (38,'level_hot','1','Priority level to consider hot(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (39,'level_highlight','2','Priority level to highlight(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (40,'level_user','2','Level required to perform worker/user tasks');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (41,'level_super','3','Level required to perform supervisor tasks');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (42,'level_settings','5','Level required to edit system settings');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (43,'level_accept','2','Level required to accept a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (44,'level_assign','3','Level required to assign a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (45,'level_yank','3','Level required to yank a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (46,'level_test','3','Level required to test a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (47,'level_approve','3','Level required to approve a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (48,'level_move','2','Level required to move a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (49,'level_view','0','Level required to view a bin');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (50,'level_edit','3','Level required to edit a ticket');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (51,'log_show_bins','on','Display current bin in log view');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (52,'log_show_time','on','Display time created in the log view');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (53,'log_show_user','on','Display creator in the log view');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (54,'log_show_att','on','Display attachments in the log view');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (55,'log_edit','on','Create a log when ticket is edited');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (56,'log_assign','on','Create a log when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (57,'log_accept','on','Create a log when ticket is accepted');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (58,'log_relate','on','Create a log when ticket is related');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (59,'log_reject','on','Create a log when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (60,'log_approve','on','Create a log when ticket is approved');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (61,'log_close','on','Create a log when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (62,'log_test','on','Create a log when ticket is tested');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (63,'log_move','on','Create a log when ticket is moved');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (64,'log_yank','on','Create a log when ticket is yanked');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (65,'log_pending','on','Create a log when status is set to pending');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (66,'log_attachment','on','Create a log entry when an attachment is added.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (67,'system_name','zenTrack','Name of the zenTrack ticketing system displayed to users');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (68,'url_view_attachment','viewAttachment.php','Link to script which displays attachments in a secure manner (for server integrity), no leading slash');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (70,'url_view_ticket','ticket.php','Link to script which displays ticket information, no leading slash');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (71,'allow_pwd_save','off','Allows user to save passphrase (not implemented yet)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (72,'check_pwd_simple','on','System will refuse lazy passwords');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (73,'level_reports','1','Level required to access and view reports');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (74,'version_xx','2.5.0.3','The version of zentrack, this cannot be edited');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (75,'date_fmt_long','%A %d, %b %Y','Long date format');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (76,'date_fmt_short','%m/%d/%Y','Short Date Format');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (77,'date_fmt_time','%H:%M','Time Format');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (78,'time_elapsed_unit','hours','Use hours, days, months, years, seconds, or weeks');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (79,'language_default','english','This is the language to display pages in, must match one of the filenames in includes/translations/');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (80,'default_deadline','+1 month','Format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (81,'default_start_date','+1 day','Format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (82,'email_interface_enabled','off', 'Use the email gateway');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (83,'default_notify_manager','on','Add bin manager to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (84,'default_notify_tester','on','Add bin tester to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (85,'default_notify_creator','on','Add ticket creator to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (86,'default_notify_owner','on','Add ticket owner to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (87,'sql_cache_time',0,'Number of seconds to cache db results, set to 0 to disable sql caching');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (88,'email_log','on','Send email when a log entry is created');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (89,'priority_medium','2','Median priority, pick number around 1/2 total priorities, set to 0 to disable coloring');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (90,'color_priority_low','#FFFFFF','Base color for low priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (91,'color_priority_med','#FFFFCC','Base color for medium priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (92,'color_priority_hi','#FF9999','Base color for high priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (93,'log_email','on','Create a log entry when tickets are emailed.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (94,'level_create_proj','2','Access level required to create projects.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (95,'use_euro_date','off','On if using European format(dd/mm/yyyy) instead of american(mm/dd/yyyy)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (96,'level_edit_varfields','2','Access level required to edit fields on the "custom" tab.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (97,'varfield_tab_name', 'Custom', 'Name to appear on the variable fields tab');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (98,'allow_htaccess', 'on', 'If on, will attempt to authenticate users based on apache htaccess (username and password must match ZT)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (99,'allow_contacts', 'on', 'Specify whether contacts will be used or not');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (100,'level_contacts','3','Level required to view the contacts');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (101,'paging_max_rows','20','Number of rows to display at a time');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (102,'retain_owner_move','on','Keep owner data on tickets after a ticket is moved between bins');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (103,'retain_owner_pending','on','Keep owner data on tickets after a ticket is set to PENDING');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (104,'retain_owner_closed','on','Keep owner data on tickets after a ticket is set to CLOSED');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (105,'character_set','ISO-8859-15','Character set to be used');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (106,'default_start_date_hours','on','Include hours in default start date for new tickets');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (107,'default_deadline_hours','on','Include hours in default deadline for new tickets');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (108,'edit_reason_required', 'off', 'Show a mandatory edit field to explain why the ticket is being edited');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (109,'email_accept', 'on', 'Send email to users in the notify list when ticket is accepted');

--
-- Load data for table 'ZENTRACK_SYSTEMS'
--

INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (1,'Apache',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (2,'Email',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (3,'Database',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (4,'Network',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (5,'PC',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (6,'Printer',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (7,'Website',0,1);

--
-- Load data for table 'ZENTRACK_TASKS'
--

INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (1,'Action Taken',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (2,'Debugging',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (3,'Implementation',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (4,'Note',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (5,'Planning',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (6,'Question',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (7,'Research',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (8,'Review',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (9,'Solution',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (10,'Testing',0,1);
INSERT INTO ZENTRACK_TASKS (task_id, name, priority, active) VALUES (11,'Work',0,1);

--
-- Load data for table 'ZENTRACK_TICKETS'
--

INSERT INTO ZENTRACK_TICKETS (id, title, priority, status, description, otime, ctime, bin_id, type_id, user_id, system_id, creator_id, tested, approved, relations, project_id, est_hours, deadline, start_date, wkd_hours) VALUES (1,'Welcome to zenTrack!!',2,'OPEN','Welcome to the zenTrack system!\r<br />\n\r<br />\nCongratulations, your install was successful.\r<br />\n\r<br />\nYou can find more help in the help section on this site, and online at http://zentrack.phpzen.net.\r<br />\n\r<br />\nYou can find support for your product at the sourceforge project: http://www.sourceforge.net/projects/zentrack',1019621097,NULL,2,5,2,7,1,0,0,NULL,NULL,0.00,NULL,NULL,0.10);
INSERT INTO ZENTRACK_TICKETS (id, title, priority, status, description, otime, ctime, bin_id, type_id, user_id, system_id, creator_id, tested, approved, relations, project_id, est_hours, deadline, start_date, wkd_hours) VALUES (2,'CHANGE ADMIN PASSWORD',1,'OPEN','You need to change the admin passphrase right away.\r<br />\n\r<br />\nIn addition, two other accounts, User, and Guest were created.  You will want to modify those or delete them as your system security and preferences determine.',1019621197,NULL,2,8,NULL,7,1,0,0,NULL,NULL,0.01,1022137200,NULL,1.00);

--
-- Load data for table 'ZENTRACK_TYPES'
--

INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (1,'Project',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (2,'Support Request',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (3,'Bug',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (4,'Enhancement',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (5,'Event Log',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (6,'Feature Request',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (7,'Service',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (8,'Task',0,1);
INSERT INTO ZENTRACK_TYPES (type_id, name, priority, active) VALUES (9,'Note',0,1);

--
-- Load data for table 'ZENTRACK_USERS'
--

INSERT INTO ZENTRACK_USERS (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) VALUES (1,'Administrator',5,'7b7bc2512ee1fedcd76bdc68926d4f7b','Administrator','zenTrack','ADMIN','root@localhost','This is the master login',2,2);
INSERT INTO ZENTRACK_USERS (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) VALUES (2,'Guest',0,'adb831a7fdd83dd1e2a309ce7591dff8','Visitor','Guest','GUEST',NULL,NULL,2,1);
INSERT INTO ZENTRACK_USERS (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) VALUES (3,'User',3,'8f9bfe9d1345237cb3b2b205864da075','User','Default','USER',NULL,'Default User Account',2,1);
INSERT INTO ZENTRACK_USERS (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) VALUES (4,'egate',2,NULL,'Gateway','Email','egate','zentrack@localhost','Email Gateway Account',1,0);


--
-- Load data for table 'ZENTRACK_VARFIELD_IDX'
--


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
                           VALUES ('custom_boolean1', 'Custom Boolean 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_boolean2', 'Custom Boolean 2', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_date1', 'Custom Date 1', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_date2', 'Custom Date 2', 1         );
INSERT INTO ZENTRACK_VARFIELD_IDX (field_name,       field_label,       sort_order) 
                           VALUES ('custom_text1', 'Custom Text 1', 1         );



/* CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE */
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;
