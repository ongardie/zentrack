

--

-- FIELD MAP WHICH DESCRIBES HOW FIELDS ARE RENDERED IN DIFFERENT VIEWS

--

CREATE TABLE ZENTRACK_FIELD_MAP (

   field_map_id NUMBER(12) CONSTRAINT fldmap_notnull NOT NULL,

   field_name   VARCHAR2(25) CONSTRAINT fldmap_nm_notnull NOT NULL,

   field_label  VARCHAR2(255) default '',

   is_visible   NUMBER(1) default 0,

   which_view   VARCHAR2(50) default 0,

   default_val  VARCHAR2(255),

   sort_order   NUMBER(4) default 0,

   field_type   VARCHAR2(50),

   num_cols     NUMBER(4) default 0,

   num_rows     NUMBER(2) default 0,

   is_required  NUMBER(1) default 0,

   CONSTRAINT field_map_pk PRIMARY KEY (field_map_id)

);



CREATE INDEX fldmap_sort ON ZENTRACK_FIELD_MAP(sort_order);

CREATE INDEX fldmap_label ON ZENTRACK_FIELD_MAP(label);

CREATE INDEX fldmap_both ON ZENTRACK_FIELD_MAP(sort_order,label);



create sequence field_map_id_seq start with 1001 nocache;



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
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('74','type_id','Type','0','project_create',NULL,'6','label','50','1','1');
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
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('106','type_id','Type','1','project_edit',NULL,'8','menu','50','1','1');
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
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('169','type_id','Type','0','project_list',NULL,'8','label','50','1',NULL);
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
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('274','custom_number1',NULL,'0','ticket_close','0','24','text','10','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('275','custom_number2',NULL,'0','ticket_close','0','25','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('276','custom_boolean1',NULL,'0','ticket_close',NULL,'26','checkbox','1','1','1');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('277','custom_boolean2',NULL,'0','ticket_close',NULL,'27','checkbox','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('278','custom_menu1',NULL,'0','ticket_close',NULL,'28','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('279','custom_menu2',NULL,'0','ticket_close',NULL,'29','menu','100','1','0');


-- Modify the version number

UPDATE ZENTRACK_SETTINGS SET value='2.5.0.3' WHERE setting_id=74;



-- Add new settings

INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (108,'edit_reason_required', 'off', 'Show a mandatory edit field to explain why the ticket is being edited');

INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (109,'email_accept', 'on', 'Send email to users in the notify list when ticket is accepted');


