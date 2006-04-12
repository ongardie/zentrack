
-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.6.2' WHERE setting_id=74;

-- Add field map entries for search helpers
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(940,'approved','Approval','0','searchbox_project',NULL,'94','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(941,'bin_id','Bin','1','searchbox_project',NULL,'40','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(942,'creator_id','Creator','0','searchbox_project',NULL,'80','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(943,'ctime','Close Time','0','searchbox_project',NULL,'3','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(944,'custom_boolean1',NULL,'0','searchbox_project',NULL,'210','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(945,'custom_boolean2',NULL,'0','searchbox_project',NULL,'220','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(946,'custom_menu1',NULL,'0','searchbox_project',NULL,'230','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(947,'custom_menu2',NULL,'0','searchbox_project',NULL,'240','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(948, 'custom_multi1', NULL, 0, 'searchbox_project', NULL, '260', 'menu', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(949, 'custom_multi2', NULL, 0, 'searchbox_project', NULL, '250', 'menu', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(950,'custom_number1',NULL,'0','searchbox_project',NULL,'190','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(951,'custom_number2',NULL,'0','searchbox_project',NULL,'200','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(952,'custom_string1',NULL,'0','searchbox_project',NULL,'160','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(953,'custom_string2',NULL,'0','searchbox_project',NULL,'170','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(954,'custom_text1',NULL,'0','searchbox_project',NULL,'180','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(955,'deadline','Deadline','0','searchbox_project',NULL,'140','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(956,'description','Details','0','searchbox_project',NULL,'199','text','60','10','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(957,'est_hours','Estimated Hours','0','searchbox_project',NULL,'120','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(958,'otime','Open Time','0','searchbox_project',NULL,'115','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(959,'priority','Priority','1','searchbox_project',NULL,'30','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(960,'project_id','Project','0','searchbox_project',NULL,'10','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(961,'start_date','Start Date','0','searchbox_project',NULL,'130','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(962,'status','Status','1','searchbox_project','OPEN','2','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(963,'system_id','System','1','searchbox_project',NULL,'60','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(964,'tested','Testing','0','searchbox_project',NULL,'90','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(965,'title','Summary','1','searchbox_project',NULL,'20','text','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(966,'user_id','Owner','1','searchbox_project',NULL,'70','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(967,'wkd_hours','Hours Worked','0','searchbox_project',NULL,'150','text','6','1','0');

-- SEARCHBOX_TICKET
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(968,'approved','Approval','0','searchbox_ticket',NULL,'94','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(969,'bin_id','Bin','1','searchbox_ticket',NULL,'40','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(970,'creator_id','Creator','0','searchbox_ticket',NULL,'80','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(971,'ctime','Close Time','0','searchbox_ticket',NULL,'3','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(972,'custom_boolean1',NULL,'0','searchbox_ticket',NULL,'210','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(973,'custom_boolean2',NULL,'0','searchbox_ticket',NULL,'220','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(974,'custom_menu1',NULL,'0','searchbox_ticket',NULL,'230','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(975,'custom_menu2',NULL,'0','searchbox_ticket',NULL,'240','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(976, 'custom_multi1', NULL, 0, 'searchbox_ticket', NULL, '260', 'menu', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(977, 'custom_multi2', NULL, 0, 'searchbox_ticket', NULL, '250', 'menu', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(978,'custom_number1',NULL,'0','searchbox_ticket',NULL,'190','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(979,'custom_number2',NULL,'0','searchbox_ticket',NULL,'200','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(980,'custom_string1',NULL,'0','searchbox_ticket',NULL,'160','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(981,'custom_string2',NULL,'0','searchbox_ticket',NULL,'170','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(982,'custom_text1',NULL,'0','searchbox_ticket',NULL,'180','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(983,'deadline','Deadline','0','searchbox_ticket',NULL,'140','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(984,'description','Details','0','searchbox_ticket',NULL,'199','text','60','10','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(985,'est_hours','Estimated Hours','0','searchbox_ticket',NULL,'120','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(986,'otime','Open Time','0','searchbox_ticket',NULL,'115','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(987,'priority','Priority','1','searchbox_ticket',NULL,'30','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(988,'project_id','Project','0','searchbox_ticket',NULL,'10','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(989,'start_date','Start Date','0','searchbox_ticket',NULL,'130','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(990,'status','Status','1','searchbox_ticket','OPEN','2','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(991,'system_id','System','1','searchbox_ticket',NULL,'60','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(992,'tested','Testing','0','searchbox_ticket',NULL,'90','radio','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(993,'title','Summary','1','searchbox_ticket',NULL,'20','text','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(994,'type_id','Type','1','searchbox_ticket',NULL,'50','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(995,'user_id','Owner','1','searchbox_ticket',NULL,'70','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(996,'wkd_hours','Hours Worked','0','searchbox_ticket',NULL,'150','text','6','1','0');

-- add view properties for search helpers
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(212, 'searchbox_project', 'access_level', 'level_view', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(213, 'searchbox_ticket', 'access_level', 'level_view', 'hidden', 0);

-- HIDDEN
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(214, 'searchbox_project', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(215, 'searchbox_ticket', 'sections', '1', 'hidden', 0);

-- LABEL
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(216, 'searchbox_project', 'table', 'ZENTRACK_TICKETS', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(217, 'searchbox_ticket', 'table', 'ZENTRACK_TICKETS', 'hidden', 0);

-- TEXT
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(218, 'searchbox_project', 'label', 'Find Projects', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(219, 'searchbox_ticket', 'label', 'Find Tickets', 'text', 0);

-- ANY OPTION
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(220, 'searchbox_project', 'any_option', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(221, 'searchbox_ticket', 'any_option', '1', 'hidden', 0);
