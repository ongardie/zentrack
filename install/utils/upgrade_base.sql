
-- Create notify recipients from the ticket create screen, see devtrack #431 
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1066,'notify', 'Notify', 1, 'project_create',NULL,'305', 'addbox', 50, 1, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1067,'notify', 'Notify', 1, 'ticket_create',NULL,'305', 'addbox', 50, 1, 0);

CREATE INDEX zt_user_init_idx ON ZENTRACK_USERS(initials);
CREATE INDEX zt_user_name_idx ON ZENTRACK_USERS(fname,lname);
CREATE INDEX zt_user_email_idx ON ZENTRACK_USERS(email);
CREATE INDEX zt_comp_title_idx ON ZENTRACK_COMPANY(title);
CREATE INDEX zt_comp_email_idx ON ZENTRACK_COMPANY(email);
CREATE INDEX zt_emp_name_idx ON ZENTRACK_EMPLOYEE(fname,lname);
CREATE INDEX zt_notf_name_idx ON ZENTRACK_NOTIFY_LIST(name);
CREATE INDEX zt_notf_email_idx ON ZENTRACK_NOTIFY_LIST(email);

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1068','id','ID','1','api_view',NULL,'1','label','8','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1069','title','Summary','1','api_view',NULL,'20','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1070','priority','Priority','1','api_view',NULL,'30','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1071','status','Status','1','api_view',NULL,'2','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1072','description','Details','1','api_view',NULL,'199','label','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1073','otime','Open Time','1','api_view',NULL,'115','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1074','ctime','Close Time','1','api_view',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1075','bin_id','Bin','1','api_view',NULL,'40','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1076','type_id','Type','1','api_view',NULL,'50','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1077','system_id','System','0','api_view',NULL,'60','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1078','user_id','Owner','1','api_view',NULL,'70','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1079','creator_id','Creator','1','api_view',NULL,'80','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1080','tested','Testing','0','api_view',NULL,'90','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1081','approved','Approval','0','api_view',NULL,'94','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1082','relations','Related','0','api_view',NULL,'98','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1083','project_id','Project','1','api_view',NULL,'10','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1084','est_hours','Estimated Hours','0','api_view',NULL,'120','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1085','start_date','Start Date','0','api_view',NULL,'130','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1086','deadline','Deadline','0','api_view',NULL,'140','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1087','wkd_hours','Hours Worked','0','api_view',NULL,'150','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1088','custom_string1',NULL,'0','api_view',NULL,'160','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1089','custom_string2',NULL,'0','api_view',NULL,'170','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1090','custom_text1',NULL,'0','api_view',NULL,'180','label','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1091','custom_number1',NULL,'0','api_view',NULL,'190','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1092','custom_number2',NULL,'0','api_view',NULL,'200','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1093','custom_boolean1',NULL,'0','api_view',NULL,'210','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1094','custom_boolean2',NULL,'0','api_view',NULL,'220','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1095','custom_menu1',NULL,'0','api_view',NULL,'230','label','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('1096','custom_menu2',NULL,'0','api_view',NULL,'240','label','100','1','0');

INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(264, 'api_view', 'sections', '0', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(265, 'api_view', 'show_totals', '0', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(266, 'api_view', 'view_only', '0', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(267, 'api_view', 'access_level', 'level_view', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(278, 'api_view', 'user_filter', 'public', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(279, 'api_view', 'user_filter_homebin', '1', 'checkbox', 0);
