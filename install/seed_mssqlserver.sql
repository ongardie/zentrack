
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

INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('2','title','Title','1','ticket_create',NULL,'2','text','200','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('3','priority','Priority','1','ticket_create',NULL,'4','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('5','description','Description','1','ticket_create',NULL,'24','text','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('6','otime','Open Time','0','ticket_create',NULL,'13','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('7','ctime','Close Time','0','ticket_create',NULL,'14','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('8','bin_id','Bin','1','ticket_create',NULL,'5','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('9','type_id','Type','1','ticket_create',NULL,'6','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('10','system_id','System','1','ticket_create',NULL,'7','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('11','user_id','Owner','1','ticket_create',NULL,'8','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('13','tested','Testing','1','ticket_create',NULL,'9','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('14','approved','Approval','1','ticket_create',NULL,'10','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('15','relations','Related','0','ticket_create',NULL,'11','searchbox','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('16','project_id','Project','1','ticket_create',NULL,'1','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('17','est_hours','Estimated Hours','1','ticket_create',NULL,'17','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('18','start_date','Start Date','1','ticket_create','+1 day','15','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('19','deadline','Deadline','1','ticket_create','+1 month','16','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('20','wkd_hours','Hours Worked','0','ticket_create','0','18','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('21','custom_string1',NULL,'0','ticket_create',NULL,'19','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('22','custom_string2',NULL,'0','ticket_create',NULL,'20','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('23','custom_text1',NULL,'0','ticket_create',NULL,'21','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('24','custom_number1',NULL,'0','ticket_create','0','22','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('25','custom_number2',NULL,'0','ticket_create','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('26','custom_boolean1',NULL,'0','ticket_create',NULL,'26','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('27','custom_boolean2',NULL,'0','ticket_create',NULL,'27','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('28','custom_menu1',NULL,'0','ticket_create',NULL,'28','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('29','custom_menu2',NULL,'0','ticket_create',NULL,'29','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('30','section1','Properties','1','ticket_create',NULL,'3','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('31','section2','Time Table','1','ticket_create',NULL,'12','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('33','section3','Description','1','ticket_create',NULL,'23','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('34','id','ID','1','ticket_edit',NULL,'1','label','8','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('35','title','Title','1','ticket_edit',NULL,'3','text','200','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('36','priority','Priority','1','ticket_edit',NULL,'6','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('37','status','Status','1','ticket_edit',NULL,'4','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('38','description','Description','1','ticket_edit',NULL,'27','text','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('39','otime','Open Time','1','ticket_edit',NULL,'16','date','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('40','ctime','Close Time','0','ticket_edit',NULL,'17','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('41','bin_id','Bin','1','ticket_edit',NULL,'7','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('42','type_id','Type','1','ticket_edit',NULL,'8','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('43','system_id','System','1','ticket_edit',NULL,'9','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('44','user_id','Owner','1','ticket_edit',NULL,'10','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('45','creator_id','Creator','1','ticket_edit',NULL,'11','searchbox','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('46','tested','Testing','1','ticket_edit',NULL,'12','menu','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('47','approved','Approval','0','ticket_edit',NULL,'13','menu','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('48','relations','Related','1','ticket_edit',NULL,'14','searchbox','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('49','project_id','Project','1','ticket_edit',NULL,'2','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('50','est_hours','Estimated Hours','1','ticket_edit',NULL,'18','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('51','start_date','Start Date','1','ticket_edit',NULL,'19','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('52','deadline','Deadline','1','ticket_edit',NULL,'20','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('53','wkd_hours','Hours Worked','0','ticket_edit','0','21','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('54','custom_string1',NULL,'0','ticket_edit',NULL,'22','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('55','custom_string2',NULL,'0','ticket_edit',NULL,'23','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('56','custom_text1',NULL,'0','ticket_edit',NULL,'24','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('57','custom_number1',NULL,'0','ticket_edit','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('58','custom_number2',NULL,'0','ticket_edit','0','28','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('59','custom_boolean1',NULL,'0','ticket_edit',NULL,'29','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('60','custom_boolean2',NULL,'0','ticket_edit',NULL,'30','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('61','custom_menu1',NULL,'0','ticket_edit',NULL,'31','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('62','custom_menu2',NULL,'0','ticket_edit',NULL,'32','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('63','section1','Properties','1','ticket_edit',NULL,'5','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('64','section2','Time Table','1','ticket_edit',NULL,'15','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('65','section3','Description','1','ticket_edit',NULL,'26','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('67','title','Title','1','project_create',NULL,'3','text','200','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('68','priority','Priority','1','project_create',NULL,'4','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('70','description','Description','1','project_create',NULL,'24','text','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('71','otime','Open Time','1','project_create',NULL,'13','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('72','ctime','Close Time','0','project_create',NULL,'14','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('73','bin_id','Bin','1','project_create',NULL,'5','menu','50','1','1');
--INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('74','type_id','Type','0','project_create',NULL,'6','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('75','system_id','System','1','project_create',NULL,'7','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('76','user_id','Owner','1','project_create',NULL,'8','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('78','tested','Testing','0','project_create',NULL,'9','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('79','approved','Approval','0','project_create',NULL,'10','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('80','relations','Related','0','project_create',NULL,'11','searchbox','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('81','project_id','Parent Project','1','project_create',NULL,'2','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('82','est_hours','Estimated Hours','0','project_create',NULL,'15','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('83','start_date','Start Date','1','project_create','+1 day','16','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('84','deadline','Deadline','1','project_create','+1 month','17','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('85','wkd_hours','Hours Worked','0','project_create','0','18','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('86','custom_string1',NULL,'0','project_create',NULL,'19','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('87','custom_string2',NULL,'0','project_create',NULL,'20','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('88','custom_text1',NULL,'0','project_create',NULL,'21','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('89','custom_number1',NULL,'0','project_create','0','22','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('90','custom_number2',NULL,'0','project_create','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('91','custom_boolean1',NULL,'0','project_create',NULL,'26','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('92','custom_boolean2',NULL,'0','project_create',NULL,'27','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('93','custom_menu1',NULL,'0','project_create',NULL,'28','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('94','custom_menu2',NULL,'0','project_create',NULL,'29','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('95','section1','Properties','1','project_create',NULL,'1','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('96','section2','Time Table','1','project_create',NULL,'12','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('97','section3','Description','1','project_create',NULL,'23','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('98','id','ID','1','project_edit',NULL,'1','label','8','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('99','title','Title','1','project_edit',NULL,'4','text','200','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('100','priority','Priority','1','project_edit',NULL,'6','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('101','status','Status','0','project_edit',NULL,'2','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('102','description','Description','1','project_edit',NULL,'27','text','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('103','otime','Open Time','0','project_edit',NULL,'16','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('104','ctime','Close Time','0','project_edit',NULL,'17','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('105','bin_id','Bin','1','project_edit',NULL,'7','menu','50','1','1');
--INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('106','type_id','Type','1','project_edit',NULL,'8','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('107','system_id','System','1','project_edit',NULL,'9','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('108','user_id','Owner','1','project_edit',NULL,'10','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('109','creator_id','Creator','0','project_edit',NULL,'11','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('110','tested','Testing','0','project_edit',NULL,'12','menu','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('111','approved','Approval','1','project_edit',NULL,'13','menu','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('112','relations','Related','1','project_edit',NULL,'14','searchbox','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('113','project_id','Project','1','project_edit',NULL,'3','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('114','est_hours','Estimated Hours','0','project_edit',NULL,'18','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('115','start_date','Start Date','1','project_edit','+1 day','19','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('116','deadline','Deadline','1','project_edit','+1 month','20','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('117','wkd_hours','Hours Worked','0','project_edit','0','21','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('118','custom_string1',NULL,'0','project_edit',NULL,'22','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('119','custom_string2',NULL,'0','project_edit',NULL,'23','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('120','custom_text1',NULL,'0','project_edit',NULL,'24','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('121','custom_number1',NULL,'0','project_edit','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('122','custom_number2',NULL,'0','project_edit','0','28','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('123','custom_boolean1',NULL,'0','project_edit',NULL,'29','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('124','custom_boolean2',NULL,'0','project_edit',NULL,'30','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('125','custom_menu1',NULL,'0','project_edit',NULL,'31','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('126','custom_menu2',NULL,'0','project_edit',NULL,'32','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('127','section1','Properties','1','project_edit',NULL,'5','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('128','section2','Time Table','1','project_edit',NULL,'15','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('129','section3','Description','1','project_edit',NULL,'26','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('130','id','ID','1','ticket_list',NULL,'1','label','8','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('131','title','Title','1','ticket_list',NULL,'20','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('132','priority','Priority','1','ticket_list',NULL,'30','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('133','status','Status','0','ticket_list',NULL,'2','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('134','description','Description','0','ticket_list',NULL,'199','label','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('135','otime','Open Time','0','ticket_list',NULL,'115','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('136','ctime','Close Time','0','ticket_list',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('137','bin_id','Bin','1','ticket_list',NULL,'40','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('138','type_id','Type','1','ticket_list',NULL,'50','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('139','system_id','System','0','ticket_list',NULL,'60','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('140','user_id','Owner','1','ticket_list',NULL,'70','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('141','creator_id','Creator','0','ticket_list',NULL,'80','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('142','tested','Testing','0','ticket_list',NULL,'90','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('143','approved','Approval','0','ticket_list',NULL,'94','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('144','relations','Related','0','ticket_list',NULL,'98','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('145','project_id','Project','0','ticket_list',NULL,'10','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('146','est_hours','Estimated Hours','0','ticket_list',NULL,'120','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('147','start_date','Start Date','0','ticket_list','+1 day','130','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('148','deadline','Deadline','0','ticket_list','+1 month','140','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('149','wkd_hours','Hours Worked','0','ticket_list','0','150','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('150','custom_string1',NULL,'0','ticket_list',NULL,'160','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('151','custom_string2',NULL,'0','ticket_list',NULL,'170','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('152','custom_text1',NULL,'0','ticket_list',NULL,'180','label','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('153','custom_number1',NULL,'0','ticket_list','0','190','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('154','custom_number2',NULL,'0','ticket_list','0','200','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('155','custom_boolean1',NULL,'0','ticket_list','0','210','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('156','custom_boolean2',NULL,'0','ticket_list','0','220','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('157','custom_menu1',NULL,'0','ticket_list',NULL,'230','label','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('158','custom_menu2',NULL,'0','ticket_list',NULL,'240','label','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('160','elapsed','Time','1','ticket_list',NULL,'250','section','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('161','id','ID','1','project_list',NULL,'1','label','8','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('162','title','Title','1','project_list',NULL,'5','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('163','priority','Priority','1','project_list',NULL,'6','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('164','status','Status','0','project_list',NULL,'2','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('165','description','Description','0','project_list',NULL,'24','label','60','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('166','otime','Open Time','0','project_list',NULL,'15','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('167','ctime','Close Time','0','project_list',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('168','bin_id','Bin','1','project_list',NULL,'7','label','50','1',NULL);
--INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('169','type_id','Type','0','project_list',NULL,'8','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('170','system_id','System','0','project_list',NULL,'9','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('171','user_id','Owner','0','project_list',NULL,'10','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('172','creator_id','Creator','0','project_list',NULL,'11','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('173','tested','Testing','0','project_list',NULL,'12','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('174','approved','Approval','0','project_list',NULL,'13','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('175','relations','Related','0','project_list',NULL,'14','label','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('176','project_id','Project','0','project_list',NULL,'4','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('177','est_hours','Estimated Hours','0','project_list',NULL,'16','label','6','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('178','start_date','Start Date','1','project_list','+1 day','17','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('179','deadline','Deadline','1','project_list','+1 month','18','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('180','wkd_hours','Hours Worked','0','project_list','0','19','label','6','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('181','custom_string1',NULL,'0','project_list',NULL,'20','label','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('182','custom_string2',NULL,'0','project_list',NULL,'21','label','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('183','custom_text1',NULL,'0','project_list',NULL,'22','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('184','custom_number1',NULL,'0','project_list','0','23','label','10','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('185','custom_number2',NULL,'0','project_list','0','25','label','10','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('186','custom_boolean1',NULL,'0','project_list','0','26','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('187','custom_boolean2',NULL,'0','project_list','0','27','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('188','custom_menu1',NULL,'0','project_list',NULL,'28','label','100','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('189','custom_menu2',NULL,'0','project_list',NULL,'29','label','100','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('191','elapsed','Time','0','project_list',NULL,'30','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('192','id','ID','1','search_list',NULL,'1','label','8','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('193','title','Title','1','search_list',NULL,'20','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('194','priority','Priority','1','search_list',NULL,'30','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('195','status','Status','0','search_list',NULL,'2','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('196','description','Description','0','search_list',NULL,'199','label','60','10','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('197','otime','Open Time','0','search_list',NULL,'115','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('198','ctime','Close Time','0','search_list',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('199','bin_id','Bin','1','search_list',NULL,'40','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('200','type_id','Type','1','search_list',NULL,'50','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('201','system_id','System','0','search_list',NULL,'60','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('202','user_id','Owner','1','search_list',NULL,'70','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('203','creator_id','Creator','0','search_list',NULL,'80','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('204','tested','Testing','0','search_list',NULL,'90','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('205','approved','Approval','0','search_list',NULL,'94','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('206','relations','Related','0','search_list',NULL,'98','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('207','project_id','Project','0','search_list',NULL,'10','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('208','est_hours','Estimated Hours','0','search_list',NULL,'120','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('209','start_date','Start Date','0','search_list','+1 day','130','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('210','deadline','Deadline','0','search_list','+1 month','140','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('211','wkd_hours','Hours Worked','0','search_list','0','150','label','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('212','custom_string1',NULL,'0','search_list',NULL,'160','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('213','custom_string2',NULL,'0','search_list',NULL,'170','label','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('214','custom_text1',NULL,'0','search_list',NULL,'180','label','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('215','custom_number1',NULL,'0','search_list','0','190','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('216','custom_number2',NULL,'0','search_list','0','200','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('217','custom_boolean1',NULL,'0','search_list','0','210','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('218','custom_boolean2',NULL,'0','search_list','0','220','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('219','custom_menu1',NULL,'0','search_list',NULL,'230','label','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('220','custom_menu2',NULL,'0','search_list',NULL,'240','label','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('221','elapsed','Time','1','search_list',NULL,'250','section','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('223','title','Title','1','search_form',NULL,'1','text','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('224','priority','Priority','1','search_form',NULL,'9','menu','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('225','status','Status','1','search_form',NULL,'10','menu','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('226','description','Description','1','search_form',NULL,'2','text','60','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('227','otime','Open Time','1','search_form',NULL,'15','date','20',NULL,NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('228','ctime','Close Time','1','search_form',NULL,'16','date','20',NULL,NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('229','bin_id','Bin','1','search_form',NULL,'8','menu','50','4',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('230','type_id','Type','1','search_form',NULL,'11','menu','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('231','system_id','System','1','search_form',NULL,'12','menu','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('232','user_id','Owner','1','search_form',NULL,'13','searchbox','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('233','creator_id','Creator','1','search_form',NULL,'14','searchbox','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('234','tested','Testing','1','search_form',NULL,'22','radio','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('235','approved','Approval','1','search_form',NULL,'21','menu','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('236','relations','Related','0','search_form',NULL,'24','searchbox','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('237','project_id','Project','0','search_form',NULL,'23','searchbox','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('238','est_hours','Estimated Hours','0','search_form',NULL,'19','text','6','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('239','start_date','Start Date','1','search_form',NULL,'17','date','20',NULL,NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('240','deadline','Deadline','1','search_form',NULL,'18','date','20',NULL,NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('241','wkd_hours','Hours Worked','0','search_form','0','20','text','6','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('242','custom_string1',NULL,'0','search_form',NULL,'3','text','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('243','custom_string2','22','1','search_form','aa','4','text','4','2',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('244','custom_text1',NULL,'0','search_form',NULL,'5','text','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('245','custom_number1',NULL,'0','search_form','0','6','text','10','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('246','custom_number2',NULL,'0','search_form','0','7','text','10','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('247','custom_boolean1','true or false','1','search_form','0','25','menu','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('248','custom_boolean2',NULL,'0','search_form','0','26','menu','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('249','custom_menu1',NULL,'0','search_form',NULL,'27','menu','100','4',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('250','custom_menu2',NULL,'0','search_form',NULL,'28','menu','100','4',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('251','id','ID','0','ticket_close',NULL,'1','label','8','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('252','title','Title','0','ticket_close',NULL,'5','text','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('253','priority','Priority','0','ticket_close',NULL,'6','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('254','status','Status','0','ticket_close',NULL,'2','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('255','description','Description','0','ticket_close',NULL,'20','text','60','10','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('256','otime','Open Time','0','ticket_close',NULL,'15','label','20','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('257','ctime','Close Time','0','ticket_close',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('258','bin_id','Bin','0','ticket_close',NULL,'7','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('259','type_id','Type','0','ticket_close',NULL,'8','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('260','system_id','System','0','ticket_close',NULL,'9','menu','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('261','user_id','Owner','0','ticket_close',NULL,'10','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('262','creator_id','Creator','0','ticket_close',NULL,'11','label','50','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('263','tested','Testing','0','ticket_close',NULL,'12','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('264','approved','Approval','0','ticket_close',NULL,'13','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('265','relations','Related','0','ticket_close',NULL,'14','searchbox','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('266','project_id','Project','0','ticket_close',NULL,'4','searchbox','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('267','est_hours','Estimated Hours','0','ticket_close',NULL,'16','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('268','start_date','Start Date','0','ticket_close','+1 day','17','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('269','deadline','Deadline','0','ticket_close','+1 month','18','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('270','wkd_hours','Hours Worked','0','ticket_close','0','19','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('271','custom_string1',NULL,'0','ticket_close',NULL,'21','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('272','custom_string2',NULL,'0','ticket_close',NULL,'22','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('273','custom_text1',NULL,'0','ticket_close',NULL,'23','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('274','custom_number1',NULL,'0','ticket_close','0','24','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('275','custom_number2',NULL,'0','ticket_close','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('276','custom_boolean1',NULL,'0','ticket_close',NULL,'26','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('277','custom_boolean2',NULL,'0','ticket_close',NULL,'27','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('278','custom_menu1',NULL,'0','ticket_close',NULL,'28','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('279','custom_menu2',NULL,'0','ticket_close',NULL,'29','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('280','hours','Hours','1','ticket_close',NULL,'30','text','6','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('281','comments','Comments','1','ticket_close',NULL,'31','text','60','10','1');


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
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (74,'version_xx','2.5.5','The version of zentrack, this cannot be edited');
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
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (96,'level_edit_varfields','2','Access level required to edit fields on the variable fields tab.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (97,'varfield_tab_name', 'Custom', 'Name to appear on the variable fields tab');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (98,'allow_htaccess', 'on', 'If on, will attempt to authenticate users based on apache htaccess (username and password must match ZT)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (99,'allow_contacts', 'on', 'Specify whether contacts will be used or not');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (100,'level_contacts','3','Level required to view the contacts');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (101,'paging_max_rows','20','Number of rows to display at a time');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (102,'retain_owner_move','on','Keep owner data on tickets after a ticket is moved between bins');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (103,'retain_owner_pending','on','Keep owner data on tickets after a ticket is set to PENDING');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (104,'retain_owner_closed','on','Keep owner data on tickets after a ticket is set to CLOSED');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (105,'character_set','ISO-8859-15','Character set to be used (<a href="http://us3.php.net/manual/en/function.htmlspecialchars.php">reference</a>)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (106,'default_start_date_hours','on','Include hours in default start date for new tickets');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (107,'default_deadline_hours','on','Include hours in default deadline for new tickets');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (108,'edit_reason_required', 'off', 'Show a mandatory edit field to explain why the ticket is being edited');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (109,'email_accept', 'on', 'Send email to users in the notify list when ticket is accepted');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (110, 'ctime_on_pending', 'off', 'Set this to on if you want tickets to set ctime when changed to pending');

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


-- CREATE AN ENTRY FOR EACH EXISTING TICKET IN THE VARFIELDS TABLE
INSERT INTO ZENTRACK_VARFIELD (ticket_id) SELECT id FROM ZENTRACK_TICKETS;

