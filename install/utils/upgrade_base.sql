
CREATE INDEX zt_log_tid ON ZENTRACK_LOGS(ticket_id);
CREATE INDEX zt_log_action ON ZENTRACK_LOGS(action);
CREATE INDEX zt_ticket_pri ON ZENTRACK_TICKETS(priority);
CREATE INDEX zt_ticket_stat ON ZENTRACK_TICKETS (status);

create table ZENTRACK_ACTION (
  action_id   int(20)     not null,
  action_name varchar(50) not null,
  action_desc text default '',
  primary key (action_id)
);

INSERT INTO ZENTRACK_ACTION view_log, add_log, delete_log
INSERT INTO ZENTRACK_ACTION assign, accept, reject, test, view, create
INSERT INTO ZENTRACK_ACTION email_anyone, email_login, email_contact
INSERT INTO ZENTRACK_ACTION login_web, login_egate, login_contact
INSERT INTO ZENTRACK_ACTION attach, relate, test, approve
INSERT INTO ZENTRACK_ACTION tab_[1-9]

create table ZENTRACK_ROLE (
  role_id int(20) not null auto_increment,
  role_name varchar(50) not null,
  role_desc varchar(255) default '',
  primary key (role_id)
);

CREATE INDEX zt_role_idx ON ZENTRACK_ROLE(role_name);

create table ZENTRACK_ROLE_NODES {
  role_id   int(20) not null,
  bin_id    int(20) default 0,
  type_id   int(20) default 0,
  action_id int(20) default 0,
  allowit   int(1)  default 0
}

CREATE INDEX zt_role_nodes_rb_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id);
CREATE INDEX zt_role_nodes_rba_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,action_id);
CREATE INDEX zt_role_nodes_rbt_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,type_id);
CREATE INDEX zt_role_nodes_rbta_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,type_id,action_id);

INSERT INTO ZENTRACK_SETTINGS login_password_required
INSERT INTO ZENTRACK_SETTINGS egate_pin_required
INSERT INTO ZENTRACK_SETTINGS egate_allow_anonymous
INSERT INTO ZENTRACK_SETTINGS customers_can_login
INSERT INTO ZENTRACK_SETTINGS customers_require_password
INSERT INTO ZENTRACK_SETTINGS customers_label

CREATE TABLE ZENTRACK_LOGIN (
  login_id int(20) not null auto_increment,
  login_name varchar(255) not null,
  login_pass varchar(255) default '',
  login_source varchar(255) default '',
  login_type varchar(255) not null,
  primary key (login_id)
);

CREATE INDEX zt_login_idx ON ZENTRACK_LOGIN(login_name, login_pass);

DELETE FROM ZENTRACK_FIELD_MAP WHERE field_map_id = 106;


INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1034,'contacts', 'Contacts', 1, 'ticket_edit',NULL,'300','searchbox', 200, 1, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1035,'contacts', 'Contacts', 1, 'ticket_create',NULL,'300', 'searchbox', 200, 1, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1036,'approved','Approval','0','ticket_cview',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1037,'bin_id','Bin','0','ticket_cview',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1038,'creator_id','Creator','0','ticket_cview',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1039,'ctime','Close Time','0','ticket_cview',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1040,'custom_boolean1',NULL,'0','ticket_cview',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1041,'custom_boolean2',NULL,'0','ticket_cview',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1042,'custom_date1','Date 1','0','ticket_cview',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1043,'custom_date2','Date 2','0','ticket_cview',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1044,'custom_menu1',NULL,'0','ticket_cview',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1045,'custom_menu2',NULL,'0','ticket_cview',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1046,'custom_multi1', NULL, 0, 'ticket_cview', NULL, 100, 'label', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1047,'custom_multi2', NULL, 0, 'ticket_cview', NULL, 100, 'label', 50, 8, 0);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1048,'custom_number1',NULL,'0','ticket_cview',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1049,'custom_number2',NULL,'0','ticket_cview',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1050,'custom_string1',NULL,'0','ticket_cview',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1051,'custom_string2',NULL,'0','ticket_cview',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1052,'custom_text1',NULL,'0','ticket_cview',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1053,'deadline','Deadline','0','ticket_cview',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1054,'elapsed','Elapsed','0','ticket_cview',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1055,'est_hours','Estimated Hours','0','ticket_cview',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1056,'otime','Open Time','0','ticket_cview',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1057,'priority','Priority','0','ticket_cview',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1058,'project_id','Project','0','ticket_cview',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1059,'start_date','Start Date','0','ticket_cview',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1060,'status','Status','0','ticket_cview',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1061,'system_id','System','0','ticket_cview',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1062,'tested','Testing','0','ticket_cview',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1063,'type_id','Type','0','ticket_cview',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1064,'user_id','Owner','0','ticket_cview',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(1065,'wkd_hours','Hours Worked','0','ticket_cview',NULL,'18','label','10','1','0');
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(228, 'ticket_cview', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(229, 'ticket_cview', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(230, 'ticket_cview', 'label', 'Details', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(231, 'ticket_cview', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(232, 'ticket_cview', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(233, 'ticket_cview', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(234, 'ticket_cview', 'view_only', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(235, 'ticket_cview', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(236, 'ticket_cview', 'width', '50', 'text', 0);
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (123,'log_email_details','off','Include email details in log (if log_email is active too)');
