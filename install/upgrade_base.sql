
DELETE FROM ZENTRACK_FIELD_MAP where which_view = 'ticket_custom' OR which_view = 'project_custom';
DELETE FROM ZENTRACK_SETTINGS WHERE name = 'varfield_tab_name';

-- new entries for custom_date in field map

-- PROJECT_CREATE
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(282,'custom_date1','Date 1','0','project_create',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(283,'custom_date2','Date 2','0','project_create',NULL,'31','date','20','1','0');

-- PROJECT_EDIT
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(284,'custom_date1','Date 1','0','project_edit',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(285,'custom_date2','Date 2','0','project_edit',NULL,'31','date','20','1','0');

-- PROJECT_LIST
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(286,'custom_date1','Date 1','0','project_list',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(287,'custom_date2','Date 2','0','project_list',NULL,'31','date','20','1','0');

-- PROJECT_LIST_FILTERS
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(288,'bin_id','Bin','1','project_list_filters',NULL,'10','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(289,'creator_id','Creator','0','project_list_filters',NULL,'50','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(290,'custom_menu1',NULL,'0','project_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(291,'custom_menu2',NULL,'0','project_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(292,'priority','Priority','1','project_list_filters',NULL,'30','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(293,'status','Status','1','project_list_filters','OPEN,PENDING','20','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(294,'system_id','System','0','project_list_filters',NULL,'60','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(295,'user_id','Owner','1','project_list_filters',NULL,'40','menu','20','1','0');

-- PROJECT_TAB_1
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(296,'approved','Approval','0','project_tab_1',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(297,'bin_id','Bin','0','project_tab_1',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(298,'creator_id','Creator','0','project_tab_1',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(299,'ctime','Close Time','0','project_tab_1',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(300,'custom_boolean1',NULL,'0','project_tab_1',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(301,'custom_boolean2',NULL,'0','project_tab_1',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(302,'custom_date1','Date 1','0','project_tab_1',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(303,'custom_date2','Date 2','0','project_tab_1',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(304,'custom_menu1',NULL,'0','project_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(305,'custom_menu2',NULL,'0','project_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(306,'custom_number1',NULL,'0','project_tab_1',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(307,'custom_number2',NULL,'0','project_tab_1',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(308,'custom_string1',NULL,'0','project_tab_1',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(309,'custom_string2',NULL,'0','project_tab_1',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(310,'custom_text1',NULL,'0','project_tab_1',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(311,'deadline','Deadline','0','project_tab_1',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(312,'elapsed','Elapsed','0','project_tab_1',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(313,'est_hours','Estimated Hours','0','project_tab_1',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(314,'otime','Open Time','0','project_tab_1',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(315,'priority','Priority','0','project_tab_1',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(316,'project_id','Project','0','project_tab_1',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(317,'start_date','Start Date','0','project_tab_1',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(318,'status','Status','0','project_tab_1',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(319,'system_id','System','0','project_tab_1',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(320,'tested','Testing','0','project_tab_1',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(321,'type_id','Type','0','project_tab_1',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(322,'user_id','Owner','0','project_tab_1',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(323,'wkd_hours','Hours Worked','0','project_tab_1',NULL,'18','label','10','1','0');

-- PROJECT_TAB_2
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(324,'approved','Approval','1','project_tab_2',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(325,'bin_id','Bin','1','project_tab_2',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(326,'creator_id','Creator','0','project_tab_2',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(327,'ctime','Close Time','0','project_tab_2',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(328,'custom_boolean1',NULL,'0','project_tab_2',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(329,'custom_boolean2',NULL,'0','project_tab_2',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(330,'custom_date1','Date 1','0','project_tab_2',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(331,'custom_date2','Date 2','0','project_tab_2',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(332,'custom_menu1',NULL,'0','project_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(333,'custom_menu2',NULL,'0','project_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(334,'custom_number1',NULL,'0','project_tab_2',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(335,'custom_number2',NULL,'0','project_tab_2',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(336,'custom_string1',NULL,'0','project_tab_2',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(337,'custom_string2',NULL,'0','project_tab_2',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(338,'custom_text1',NULL,'0','project_tab_2',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(339,'deadline','Deadline','0','project_tab_2',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(340,'elapsed','Elapsed','0','project_tab_2',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(341,'est_hours','Estimated Hours','0','project_tab_2',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(342,'otime','Open Time','0','project_tab_2',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(343,'priority','Priority','0','project_tab_2',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(344,'project_id','Project','0','project_tab_2',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(345,'start_date','Start Date','0','project_tab_2',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(346,'status','Status','0','project_tab_2',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(347,'system_id','System','1','project_tab_2',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(348,'tested','Testing','1','project_tab_2',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(349,'type_id','Type','1','project_tab_2',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(350,'user_id','Owner','0','project_tab_2',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(351,'wkd_hours','Hours Worked','0','project_tab_2',NULL,'18','label','10','1','0');

-- PROJECT_TAB_3
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(352,'approved','Approval','0','project_tab_3',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(353,'bin_id','Bin','0','project_tab_3',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(354,'creator_id','Creator','0','project_tab_3',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(355,'ctime','Close Time','0','project_tab_3',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(356,'custom_boolean1',NULL,'0','project_tab_3',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(357,'custom_boolean2',NULL,'0','project_tab_3',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(358,'custom_date1','Date 1','0','project_tab_3',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(359,'custom_date2','Date 2','0','project_tab_3',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(360,'custom_menu1',NULL,'0','project_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(361,'custom_menu2',NULL,'0','project_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(362,'custom_number1',NULL,'0','project_tab_3',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(363,'custom_number2',NULL,'0','project_tab_3',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(364,'custom_string1',NULL,'0','project_tab_3',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(365,'custom_string2',NULL,'0','project_tab_3',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(366,'custom_text1',NULL,'0','project_tab_3',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(367,'deadline','Deadline','0','project_tab_3',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(368,'elapsed','Elapsed','0','project_tab_3',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(369,'est_hours','Estimated Hours','0','project_tab_3',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(370,'otime','Open Time','0','project_tab_3',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(371,'priority','Priority','0','project_tab_3',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(372,'project_id','Project','0','project_tab_3',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(373,'start_date','Start Date','0','project_tab_3',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(374,'status','Status','0','project_tab_3',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(375,'system_id','System','0','project_tab_3',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(376,'tested','Testing','0','project_tab_3',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(377,'type_id','Type','0','project_tab_3',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(378,'user_id','Owner','0','project_tab_3',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(379,'wkd_hours','Hours Worked','0','project_tab_3',NULL,'18','label','10','1','0');

-- PROJECT_TAB_4
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(380,'approved','Approval','0','project_tab_4',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(381,'bin_id','Bin','0','project_tab_4',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(382,'creator_id','Creator','0','project_tab_4',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(383,'ctime','Close Time','0','project_tab_4',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(384,'custom_boolean1',NULL,'0','project_tab_4',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(385,'custom_boolean2',NULL,'0','project_tab_4',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(386,'custom_date1','Date 1','0','project_tab_4',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(387,'custom_date2','Date 2','0','project_tab_4',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(388,'custom_menu1',NULL,'0','project_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(389,'custom_menu2',NULL,'0','project_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(390,'custom_number1',NULL,'0','project_tab_4',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(391,'custom_number2',NULL,'0','project_tab_4',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(392,'custom_string1',NULL,'0','project_tab_4',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(393,'custom_string2',NULL,'0','project_tab_4',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(394,'custom_text1',NULL,'0','project_tab_4',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(395,'deadline','Deadline','0','project_tab_4',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(396,'elapsed','Elapsed','0','project_tab_4',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(397,'est_hours','Estimated Hours','0','project_tab_4',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(398,'otime','Open Time','0','project_tab_4',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(399,'priority','Priority','0','project_tab_4',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(400,'project_id','Project','0','project_tab_4',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(401,'start_date','Start Date','0','project_tab_4',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(402,'status','Status','0','project_tab_4',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(403,'system_id','System','0','project_tab_4',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(404,'tested','Testing','0','project_tab_4',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(405,'type_id','Type','0','project_tab_4',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(406,'user_id','Owner','0','project_tab_4',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(407,'wkd_hours','Hours Worked','0','project_tab_4',NULL,'18','label','10','1','0');

-- PROJECT_TAB_5
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(408,'approved','Approval','0','project_tab_5',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(409,'bin_id','Bin','0','project_tab_5',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(410,'creator_id','Creator','0','project_tab_5',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(411,'ctime','Close Time','0','project_tab_5',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(412,'custom_boolean1',NULL,'0','project_tab_5',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(413,'custom_boolean2',NULL,'0','project_tab_5',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(414,'custom_date1','Date 1','0','project_tab_5',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(415,'custom_date2','Date 2','0','project_tab_5',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(416,'custom_menu1',NULL,'0','project_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(417,'custom_menu2',NULL,'0','project_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(418,'custom_number1',NULL,'0','project_tab_5',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(419,'custom_number2',NULL,'0','project_tab_5',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(420,'custom_string1',NULL,'0','project_tab_5',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(421,'custom_string2',NULL,'0','project_tab_5',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(422,'custom_text1',NULL,'0','project_tab_5',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(423,'deadline','Deadline','0','project_tab_5',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(424,'elapsed','Elapsed','0','project_tab_5',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(425,'est_hours','Estimated Hours','0','project_tab_5',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(426,'otime','Open Time','0','project_tab_5',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(427,'priority','Priority','0','project_tab_5',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(428,'project_id','Project','0','project_tab_5',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(429,'start_date','Start Date','0','project_tab_5',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(430,'status','Status','0','project_tab_5',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(431,'system_id','System','0','project_tab_5',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(432,'tested','Testing','0','project_tab_5',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(433,'type_id','Type','0','project_tab_5',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(434,'user_id','Owner','0','project_tab_5',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(435,'wkd_hours','Hours Worked','0','project_tab_5',NULL,'18','label','10','1','0');

-- PROJECT_TAB_6
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(436,'approved','Approval','0','project_tab_6',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(437,'bin_id','Bin','0','project_tab_6',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(438,'creator_id','Creator','0','project_tab_6',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(439,'ctime','Close Time','0','project_tab_6',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(440,'custom_boolean1',NULL,'0','project_tab_6',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(441,'custom_boolean2',NULL,'0','project_tab_6',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(442,'custom_date1','Date 1','0','project_tab_6',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(443,'custom_date2','Date 2','0','project_tab_6',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(444,'custom_menu1',NULL,'0','project_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(445,'custom_menu2',NULL,'0','project_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(446,'custom_number1',NULL,'0','project_tab_6',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(447,'custom_number2',NULL,'0','project_tab_6',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(448,'custom_string1',NULL,'0','project_tab_6',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(449,'custom_string2',NULL,'0','project_tab_6',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(450,'custom_text1',NULL,'0','project_tab_6',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(451,'deadline','Deadline','0','project_tab_6',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(452,'elapsed','Elapsed','0','project_tab_6',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(453,'est_hours','Estimated Hours','0','project_tab_6',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(454,'otime','Open Time','0','project_tab_6',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(455,'priority','Priority','0','project_tab_6',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(456,'project_id','Project','0','project_tab_6',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(457,'start_date','Start Date','0','project_tab_6',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(458,'status','Status','0','project_tab_6',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(459,'system_id','System','0','project_tab_6',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(460,'tested','Testing','0','project_tab_6',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(461,'type_id','Type','0','project_tab_6',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(462,'user_id','Owner','0','project_tab_6',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(463,'wkd_hours','Hours Worked','0','project_tab_6',NULL,'18','label','10','1','0');

-- PROJECT_TAB_7
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(464,'approved','Approval','0','project_tab_7',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(465,'bin_id','Bin','0','project_tab_7',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(466,'creator_id','Creator','0','project_tab_7',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(467,'ctime','Close Time','0','project_tab_7',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(468,'custom_boolean1',NULL,'0','project_tab_7',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(469,'custom_boolean2',NULL,'0','project_tab_7',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(470,'custom_date1','Date 1','0','project_tab_7',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(471,'custom_date2','Date 2','0','project_tab_7',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(472,'custom_menu1',NULL,'0','project_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(473,'custom_menu2',NULL,'0','project_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(474,'custom_number1',NULL,'0','project_tab_7',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(475,'custom_number2',NULL,'0','project_tab_7',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(476,'custom_string1',NULL,'0','project_tab_7',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(477,'custom_string2',NULL,'0','project_tab_7',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(478,'custom_text1',NULL,'0','project_tab_7',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(479,'deadline','Deadline','0','project_tab_7',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(480,'elapsed','Elapsed','0','project_tab_7',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(481,'est_hours','Estimated Hours','0','project_tab_7',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(482,'otime','Open Time','0','project_tab_7',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(483,'priority','Priority','0','project_tab_7',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(484,'project_id','Project','0','project_tab_7',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(485,'start_date','Start Date','0','project_tab_7',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(486,'status','Status','0','project_tab_7',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(487,'system_id','System','0','project_tab_7',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(488,'tested','Testing','0','project_tab_7',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(489,'type_id','Type','0','project_tab_7',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(490,'user_id','Owner','0','project_tab_7',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(491,'wkd_hours','Hours Worked','0','project_tab_7',NULL,'18','label','10','1','0');

-- PROJECT_TAB_8
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(492,'approved','Approval','0','project_tab_8',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(493,'bin_id','Bin','0','project_tab_8',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(494,'creator_id','Creator','0','project_tab_8',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(495,'ctime','Close Time','0','project_tab_8',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(496,'custom_boolean1',NULL,'0','project_tab_8',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(497,'custom_boolean2',NULL,'0','project_tab_8',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(498,'custom_date1','Date 1','0','project_tab_8',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(499,'custom_date2','Date 2','0','project_tab_8',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(500,'custom_menu1',NULL,'0','project_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(501,'custom_menu2',NULL,'0','project_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(502,'custom_number1',NULL,'0','project_tab_8',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(503,'custom_number2',NULL,'0','project_tab_8',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(504,'custom_string1',NULL,'0','project_tab_8',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(505,'custom_string2',NULL,'0','project_tab_8',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(506,'custom_text1',NULL,'0','project_tab_8',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(507,'deadline','Deadline','0','project_tab_8',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(508,'elapsed','Elapsed','0','project_tab_8',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(509,'est_hours','Estimated Hours','0','project_tab_8',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(510,'otime','Open Time','0','project_tab_8',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(511,'priority','Priority','0','project_tab_8',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(512,'project_id','Project','0','project_tab_8',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(513,'start_date','Start Date','0','project_tab_8',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(514,'status','Status','0','project_tab_8',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(515,'system_id','System','0','project_tab_8',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(516,'tested','Testing','0','project_tab_8',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(517,'type_id','Type','0','project_tab_8',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(518,'user_id','Owner','0','project_tab_8',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(519,'wkd_hours','Hours Worked','0','project_tab_8',NULL,'18','label','10','1','0');

-- PROJECT_TASKS
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(520,'approved','Approval','0','project_tasks',NULL,'13','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(521,'bin_id','Bin','0','project_tasks',NULL,'7','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(522,'creator_id','Creator','0','project_tasks',NULL,'11','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(523,'ctime','Close Time','0','project_tasks',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(524,'custom_boolean1',NULL,'0','project_tasks',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(525,'custom_boolean2',NULL,'0','project_tasks',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(526,'custom_date1','Date 1','0','project_tasks',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(527,'custom_date2','Date 2','0','project_tasks',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(528,'custom_menu1',NULL,'0','project_tasks',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(529,'custom_menu2',NULL,'0','project_tasks',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(530,'custom_number1',NULL,'0','project_tasks',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(531,'custom_number2',NULL,'0','project_tasks',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(532,'custom_string1',NULL,'0','project_tasks',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(533,'custom_string2',NULL,'0','project_tasks',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(534,'custom_text1',NULL,'0','project_tasks',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(535,'deadline','Deadline','0','project_tasks','+1 month','18','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(536,'description','Details','0','project_tasks',NULL,'24','label','60','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(537,'elapsed','Time','0','project_tasks',NULL,'30','section',NULL,'1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(538,'est_hours','Estimated Hours','1','project_tasks',NULL,'16','label','6','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(539,'id','ID','1','project_tasks',NULL,'1','label','8','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(540,'otime','Open Time','0','project_tasks',NULL,'15','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(541,'priority','Priority','1','project_tasks',NULL,'6','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(542,'project_id','Project','0','project_tasks',NULL,'4','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(543,'relations','Related','0','project_tasks',NULL,'14','label','200','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(544,'start_date','Start Date','0','project_tasks','+1 day','17','label','20','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(545,'status','Status','1','project_tasks',NULL,'2','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(546,'system_id','System','0','project_tasks',NULL,'9','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(547,'tested','Testing','0','project_tasks',NULL,'12','label','1','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(548,'title','Summary','1','project_tasks',NULL,'5','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(549,'type_id','Type','1','project_tasks',NULL,'8','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(550,'user_id','Owner','0','project_tasks',NULL,'10','label','50','1',NULL);
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(551,'wkd_hours','Hours Worked','1','project_tasks','0','19','label','6','1',NULL);

-- SEARCH_FORM
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(552,'custom_date1','Date 1','0','search_form',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(553,'custom_date2','Date 2','0','search_form',NULL,'31','date','20','1','0');

-- SEARCH_LIST
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(554,'custom_date1','Date 1','0','search_list',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(555,'custom_date2','Date 2','0','search_list',NULL,'31','date','20','1','0');

-- TICKET_CLOSE
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(556,'custom_date1','Date 1','0','ticket_close',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(557,'custom_date2','Date 2','0','ticket_close',NULL,'31','date','20','1','0');

-- TICKET_CREATE
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(558,'custom_date1','Date 1','0','ticket_create',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(559,'custom_date2','Date 2','0','ticket_create',NULL,'31','date','20','1','0');

-- TICKET_EDIT
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(560,'custom_date1','Date 1','0','ticket_edit',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(561,'custom_date2','Date 2','0','ticket_edit',NULL,'31','date','20','1','0');

-- TICKET_LIST
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(562,'custom_date1','Date 1','0','ticket_list',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(563,'custom_date2','Date 2','0','ticket_list',NULL,'31','date','20','1','0');

-- TICKET_LIST_FILTERS
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(564,'bin_id','Bin','1','ticket_list_filters',NULL,'10','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(565,'creator_id','Creator','0','ticket_list_filters',NULL,'70','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(566,'custom_menu1',NULL,'0','ticket_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(567,'custom_menu2',NULL,'0','ticket_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(568,'priority','Priority','1','ticket_list_filters',NULL,'20','menu','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(569,'status','Status','1','ticket_list_filters','OPEN,PENDING','30','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(570,'system_id','System','0','ticket_list_filters',NULL,'60','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(571,'type_id','Type','1','ticket_list_filters',NULL,'50','menu','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(572,'user_id','Owner','1','ticket_list_filters',NULL,'40','menu','20','1','0');

-- TICKET_TAB_1
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(573,'approved','Approval','0','ticket_tab_1',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(574,'bin_id','Bin','0','ticket_tab_1',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(575,'creator_id','Creator','0','ticket_tab_1',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(576,'ctime','Close Time','0','ticket_tab_1',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(577,'custom_boolean1',NULL,'0','ticket_tab_1',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(578,'custom_boolean2',NULL,'0','ticket_tab_1',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(579,'custom_date1','Date 1','0','ticket_tab_1',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(580,'custom_date2','Date 2','0','ticket_tab_1',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(581,'custom_menu1',NULL,'0','ticket_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(582,'custom_menu2',NULL,'0','ticket_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(583,'custom_number1',NULL,'0','ticket_tab_1',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(584,'custom_number2',NULL,'0','ticket_tab_1',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(585,'custom_string1',NULL,'0','ticket_tab_1',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(586,'custom_string2',NULL,'0','ticket_tab_1',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(587,'custom_text1',NULL,'0','ticket_tab_1',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(588,'deadline','Deadline','0','ticket_tab_1',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(589,'elapsed','Elapsed','0','ticket_tab_1',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(590,'est_hours','Estimated Hours','0','ticket_tab_1',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(591,'otime','Open Time','0','ticket_tab_1',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(592,'priority','Priority','0','ticket_tab_1',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(593,'project_id','Project','0','ticket_tab_1',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(594,'start_date','Start Date','0','ticket_tab_1',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(595,'status','Status','0','ticket_tab_1',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(596,'system_id','System','0','ticket_tab_1',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(597,'tested','Testing','0','ticket_tab_1',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(598,'type_id','Type','0','ticket_tab_1',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(599,'user_id','Owner','0','ticket_tab_1',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(600,'wkd_hours','Hours Worked','0','ticket_tab_1',NULL,'18','label','10','1','0');

-- TICKET_TAB_2
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(601,'approved','Approval','1','ticket_tab_2',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(602,'bin_id','Bin','1','ticket_tab_2',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(603,'creator_id','Creator','0','ticket_tab_2',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(604,'ctime','Close Time','0','ticket_tab_2',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(605,'custom_boolean1',NULL,'0','ticket_tab_2',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(606,'custom_boolean2',NULL,'0','ticket_tab_2',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(607,'custom_date1','Date 1','0','ticket_tab_2',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(608,'custom_date2','Date 2','0','ticket_tab_2',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(609,'custom_menu1',NULL,'0','ticket_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(610,'custom_menu2',NULL,'0','ticket_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(611,'custom_number1',NULL,'0','ticket_tab_2',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(612,'custom_number2',NULL,'0','ticket_tab_2',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(613,'custom_string1',NULL,'0','ticket_tab_2',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(614,'custom_string2',NULL,'0','ticket_tab_2',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(615,'custom_text1',NULL,'0','ticket_tab_2',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(616,'deadline','Deadline','0','ticket_tab_2',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(617,'elapsed','Elapsed','0','ticket_tab_2',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(618,'est_hours','Estimated Hours','0','ticket_tab_2',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(619,'otime','Open Time','0','ticket_tab_2',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(620,'priority','Priority','0','ticket_tab_2',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(621,'project_id','Project','0','ticket_tab_2',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(622,'start_date','Start Date','0','ticket_tab_2',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(623,'status','Status','0','ticket_tab_2',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(624,'system_id','System','1','ticket_tab_2',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(625,'tested','Testing','1','ticket_tab_2',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(626,'type_id','Type','1','ticket_tab_2',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(627,'user_id','Owner','0','ticket_tab_2',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(628,'wkd_hours','Hours Worked','0','ticket_tab_2',NULL,'18','label','10','1','0');

-- TICKET_TAB_3
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(629,'approved','Approval','0','ticket_tab_3',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(630,'bin_id','Bin','0','ticket_tab_3',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(631,'creator_id','Creator','0','ticket_tab_3',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(632,'ctime','Close Time','0','ticket_tab_3',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(633,'custom_boolean1',NULL,'0','ticket_tab_3',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(634,'custom_boolean2',NULL,'0','ticket_tab_3',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(635,'custom_date1','Date 1','0','ticket_tab_3',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(636,'custom_date2','Date 2','0','ticket_tab_3',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(637,'custom_menu1',NULL,'0','ticket_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(638,'custom_menu2',NULL,'0','ticket_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(639,'custom_number1',NULL,'0','ticket_tab_3',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(640,'custom_number2',NULL,'0','ticket_tab_3',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(641,'custom_string1',NULL,'0','ticket_tab_3',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(642,'custom_string2',NULL,'0','ticket_tab_3',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(643,'custom_text1',NULL,'0','ticket_tab_3',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(644,'deadline','Deadline','0','ticket_tab_3',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(645,'elapsed','Elapsed','0','ticket_tab_3',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(646,'est_hours','Estimated Hours','0','ticket_tab_3',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(647,'otime','Open Time','0','ticket_tab_3',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(648,'priority','Priority','0','ticket_tab_3',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(649,'project_id','Project','0','ticket_tab_3',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(650,'start_date','Start Date','0','ticket_tab_3',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(651,'status','Status','0','ticket_tab_3',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(652,'system_id','System','0','ticket_tab_3',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(653,'tested','Testing','0','ticket_tab_3',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(654,'type_id','Type','0','ticket_tab_3',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(655,'user_id','Owner','0','ticket_tab_3',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(656,'wkd_hours','Hours Worked','0','ticket_tab_3',NULL,'18','label','10','1','0');

-- TICKET_TAB_4
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(657,'approved','Approval','0','ticket_tab_4',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(658,'bin_id','Bin','0','ticket_tab_4',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(659,'creator_id','Creator','0','ticket_tab_4',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(660,'ctime','Close Time','0','ticket_tab_4',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(661,'custom_boolean1',NULL,'0','ticket_tab_4',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(662,'custom_boolean2',NULL,'0','ticket_tab_4',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(663,'custom_date1','Date 1','0','ticket_tab_4',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(664,'custom_date2','Date 2','0','ticket_tab_4',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(665,'custom_menu1',NULL,'0','ticket_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(666,'custom_menu2',NULL,'0','ticket_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(667,'custom_number1',NULL,'0','ticket_tab_4',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(668,'custom_number2',NULL,'0','ticket_tab_4',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(669,'custom_string1',NULL,'0','ticket_tab_4',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(670,'custom_string2',NULL,'0','ticket_tab_4',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(671,'custom_text1',NULL,'0','ticket_tab_4',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(672,'deadline','Deadline','0','ticket_tab_4',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(673,'elapsed','Elapsed','0','ticket_tab_4',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(674,'est_hours','Estimated Hours','0','ticket_tab_4',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(675,'otime','Open Time','0','ticket_tab_4',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(676,'priority','Priority','0','ticket_tab_4',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(677,'project_id','Project','0','ticket_tab_4',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(678,'start_date','Start Date','0','ticket_tab_4',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(679,'status','Status','0','ticket_tab_4',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(680,'system_id','System','0','ticket_tab_4',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(681,'tested','Testing','0','ticket_tab_4',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(682,'type_id','Type','0','ticket_tab_4',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(683,'user_id','Owner','0','ticket_tab_4',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(684,'wkd_hours','Hours Worked','0','ticket_tab_4',NULL,'18','label','10','1','0');

-- TICKET_TAB_5
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(685,'approved','Approval','0','ticket_tab_5',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(686,'bin_id','Bin','0','ticket_tab_5',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(687,'creator_id','Creator','0','ticket_tab_5',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(688,'ctime','Close Time','0','ticket_tab_5',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(689,'custom_boolean1',NULL,'0','ticket_tab_5',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(690,'custom_boolean2',NULL,'0','ticket_tab_5',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(691,'custom_date1','Date 1','0','ticket_tab_5',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(692,'custom_date2','Date 2','0','ticket_tab_5',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(693,'custom_menu1',NULL,'0','ticket_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(694,'custom_menu2',NULL,'0','ticket_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(695,'custom_number1',NULL,'0','ticket_tab_5',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(696,'custom_number2',NULL,'0','ticket_tab_5',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(697,'custom_string1',NULL,'0','ticket_tab_5',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(698,'custom_string2',NULL,'0','ticket_tab_5',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(699,'custom_text1',NULL,'0','ticket_tab_5',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(700,'deadline','Deadline','0','ticket_tab_5',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(701,'elapsed','Elapsed','0','ticket_tab_5',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(702,'est_hours','Estimated Hours','0','ticket_tab_5',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(703,'otime','Open Time','0','ticket_tab_5',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(704,'priority','Priority','0','ticket_tab_5',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(705,'project_id','Project','0','ticket_tab_5',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(706,'start_date','Start Date','0','ticket_tab_5',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(707,'status','Status','0','ticket_tab_5',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(708,'system_id','System','0','ticket_tab_5',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(709,'tested','Testing','0','ticket_tab_5',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(710,'type_id','Type','0','ticket_tab_5',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(711,'user_id','Owner','0','ticket_tab_5',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(712,'wkd_hours','Hours Worked','0','ticket_tab_5',NULL,'18','label','10','1','0');

-- TICKET_TAB_6
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(713,'approved','Approval','0','ticket_tab_6',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(714,'bin_id','Bin','0','ticket_tab_6',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(715,'creator_id','Creator','0','ticket_tab_6',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(716,'ctime','Close Time','0','ticket_tab_6',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(717,'custom_boolean1',NULL,'0','ticket_tab_6',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(718,'custom_boolean2',NULL,'0','ticket_tab_6',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(719,'custom_date1','Date 1','0','ticket_tab_6',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(720,'custom_date2','Date 2','0','ticket_tab_6',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(721,'custom_menu1',NULL,'0','ticket_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(722,'custom_menu2',NULL,'0','ticket_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(723,'custom_number1',NULL,'0','ticket_tab_6',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(724,'custom_number2',NULL,'0','ticket_tab_6',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(725,'custom_string1',NULL,'0','ticket_tab_6',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(726,'custom_string2',NULL,'0','ticket_tab_6',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(727,'custom_text1',NULL,'0','ticket_tab_6',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(728,'deadline','Deadline','0','ticket_tab_6',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(729,'elapsed','Elapsed','0','ticket_tab_6',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(730,'est_hours','Estimated Hours','0','ticket_tab_6',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(731,'otime','Open Time','0','ticket_tab_6',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(732,'priority','Priority','0','ticket_tab_6',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(733,'project_id','Project','0','ticket_tab_6',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(734,'start_date','Start Date','0','ticket_tab_6',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(735,'status','Status','0','ticket_tab_6',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(736,'system_id','System','0','ticket_tab_6',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(737,'tested','Testing','0','ticket_tab_6',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(738,'type_id','Type','0','ticket_tab_6',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(739,'user_id','Owner','0','ticket_tab_6',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(740,'wkd_hours','Hours Worked','0','ticket_tab_6',NULL,'18','label','10','1','0');

-- TICKET_TAB_7
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(741,'approved','Approval','0','ticket_tab_7',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(742,'bin_id','Bin','0','ticket_tab_7',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(743,'creator_id','Creator','0','ticket_tab_7',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(744,'ctime','Close Time','0','ticket_tab_7',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(745,'custom_boolean1',NULL,'0','ticket_tab_7',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(746,'custom_boolean2',NULL,'0','ticket_tab_7',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(747,'custom_date1','Date 1','0','ticket_tab_7',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(748,'custom_date2','Date 2','0','ticket_tab_7',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(749,'custom_menu1',NULL,'0','ticket_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(750,'custom_menu2',NULL,'0','ticket_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(751,'custom_number1',NULL,'0','ticket_tab_7',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(752,'custom_number2',NULL,'0','ticket_tab_7',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(753,'custom_string1',NULL,'0','ticket_tab_7',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(754,'custom_string2',NULL,'0','ticket_tab_7',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(755,'custom_text1',NULL,'0','ticket_tab_7',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(756,'deadline','Deadline','0','ticket_tab_7',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(757,'elapsed','Elapsed','0','ticket_tab_7',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(758,'est_hours','Estimated Hours','0','ticket_tab_7',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(759,'otime','Open Time','0','ticket_tab_7',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(760,'priority','Priority','0','ticket_tab_7',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(761,'project_id','Project','0','ticket_tab_7',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(762,'start_date','Start Date','0','ticket_tab_7',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(763,'status','Status','0','ticket_tab_7',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(764,'system_id','System','0','ticket_tab_7',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(765,'tested','Testing','0','ticket_tab_7',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(766,'type_id','Type','0','ticket_tab_7',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(767,'user_id','Owner','0','ticket_tab_7',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(768,'wkd_hours','Hours Worked','0','ticket_tab_7',NULL,'18','label','10','1','0');

-- TICKET_TAB_8
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(769,'approved','Approval','0','ticket_tab_8',NULL,'30','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(770,'bin_id','Bin','0','ticket_tab_8',NULL,'22','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(771,'creator_id','Creator','0','ticket_tab_8',NULL,'56','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(772,'ctime','Close Time','0','ticket_tab_8',NULL,'20','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(773,'custom_boolean1',NULL,'0','ticket_tab_8',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(774,'custom_boolean2',NULL,'0','ticket_tab_8',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(775,'custom_date1','Date 1','0','ticket_tab_8',NULL,'52','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(776,'custom_date2','Date 2','0','ticket_tab_8',NULL,'50','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(777,'custom_menu1',NULL,'0','ticket_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(778,'custom_menu2',NULL,'0','ticket_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(779,'custom_number1',NULL,'0','ticket_tab_8',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(780,'custom_number2',NULL,'0','ticket_tab_8',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(781,'custom_string1',NULL,'0','ticket_tab_8',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(782,'custom_string2',NULL,'0','ticket_tab_8',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(783,'custom_text1',NULL,'0','ticket_tab_8',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(784,'deadline','Deadline','0','ticket_tab_8',NULL,'12','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(785,'elapsed','Elapsed','0','ticket_tab_8',NULL,'14','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(786,'est_hours','Estimated Hours','0','ticket_tab_8',NULL,'16','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(787,'otime','Open Time','0','ticket_tab_8',NULL,'8','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(788,'priority','Priority','0','ticket_tab_8',NULL,'2','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(789,'project_id','Project','0','ticket_tab_8',NULL,'32','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(790,'start_date','Start Date','0','ticket_tab_8',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(791,'status','Status','0','ticket_tab_8',NULL,'4','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(792,'system_id','System','0','ticket_tab_8',NULL,'26','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(793,'tested','Testing','0','ticket_tab_8',NULL,'28','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(794,'type_id','Type','0','ticket_tab_8',NULL,'24','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(795,'user_id','Owner','0','ticket_tab_8',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(796,'wkd_hours','Hours Worked','0','ticket_tab_8',NULL,'18','label','10','1','0');

-- TICKET_VIEW_TOP
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(797,'approved','Approval','0','ticket_view_top',NULL,'15','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(798,'bin_id','Bin','0','ticket_view_top',NULL,'11','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(799,'ctime','Close Time','0','ticket_view_top',NULL,'10','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(800,'custom_boolean1',NULL,'0','ticket_view_top',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(801,'custom_boolean2',NULL,'0','ticket_view_top',NULL,'100','label','1','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(802,'custom_date1','Date 1','0','ticket_view_top',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(803,'custom_date2','Date 2','0','ticket_view_top',NULL,'31','date','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(804,'custom_menu1',NULL,'0','ticket_view_top',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(805,'custom_menu2',NULL,'0','ticket_view_top',NULL,'100','menu','100','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(806,'custom_number1',NULL,'0','ticket_view_top',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(807,'custom_number2',NULL,'0','ticket_view_top',NULL,'100','text','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(808,'custom_string1',NULL,'0','ticket_view_top',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(809,'custom_string2',NULL,'0','ticket_view_top',NULL,'100','text','200','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(810,'custom_text1',NULL,'0','ticket_view_top',NULL,'100','text','50','4','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(811,'deadline','Deadline','1','ticket_view_top',NULL,'6','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(812,'elapsed','Elapsed','0','ticket_view_top',NULL,'7','section','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(813,'est_hours','Estimated Hours','1','ticket_view_top',NULL,'8','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(814,'otime','Open Time','1','ticket_view_top',NULL,'4','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(815,'priority','Priority','1','ticket_view_top',NULL,'1','label','50','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(816,'project_id','Project','0','ticket_view_top',NULL,'16','label','30','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(817,'start_date','Start Date','1','ticket_view_top',NULL,'5','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(818,'status','Status','1','ticket_view_top',NULL,'2','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(819,'system_id','System','0','ticket_view_top',NULL,'13','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(820,'tested','Testing','0','ticket_view_top',NULL,'14','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(821,'type_id','Type','0','ticket_view_top',NULL,'12','label','10','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(822,'user_id','Owner','1','ticket_view_top',NULL,'3','label','20','1','0');
INSERT INTO ZENTRACK_FIELD_MAP (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(823,'wkd_hours','Hours Worked','1','ticket_view_top',NULL,'9','label','10','1','0');

-- new setting for auto-login from system account
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (111, 'use_system_auth', 'off', 'If on, this setting will check for an apache login (.htaccess) or windows system authentication and attempt an auto-login');

-- new color settings for ui improvements
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (112, 'color_bar_darker', '#D3D3D3', 'A contrast area for bars');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (113, 'color_bar_darkest', '#CCCCCC', 'A higher contrast offset for bars');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (114, 'color_bar_border', '#999999', 'Outline for the bar areas');

UPDATE ZENTRACK_SETTINGS SET value = '#000000' WHERE name = 'color_bar_text' AND value='#006666'; 

-- new setting to control number of items stored in history list
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (115, 'recently_viewed_max', '5', 'Max items in recently viewed list');

-- setting to turn on/off attachments
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (116, 'allow_upload', 'on', 'If off, attachments will be disabled');

-- settings for hot key help windows and hints
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (117, 'hotkeys_alternate_hints', 0, 'If hot key help (when alt is held down) boxes overlap because they are too long, set this to On');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (118, 'hotkeys_hint_delay', 1200, 'Delay before showing hotkey hint boxes(0 = off)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (119, 'hotkeys_help_delay', 8000, 'Delay before showing hotkey help window (0 = off)');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (120, 'worked_hours_decimal', 2, 'Number of decimal places to show for hours worked/estimated');

-- new table for field maps
CREATE TABLE ZENTRACK_VIEW_MAP (
  view_map_id INT(12) NOT NULL auto_increment,
  vm_name VARCHAR(25) NOT NULL,
  vm_val  VARCHAR(50) default '',
  vm_type VARCHAR(12) NOT NULL,
  vm_order INT(4) default 0,
  which_view VARCHAR(50) NOT NULL,
  PRIMARY KEY (view_map_id)
);

CREATE INDEX view_map_idx ON ZENTRACK_VIEW_MAP(which_view,vm_order);
CREATE SEQUENCE view_map_id_seq 1001;

-- new data for the field map extra table

-- PROJECT_CLOSE
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(1, 'project_close', 'access_level', 'level_user', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(2, 'project_close', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(3, 'project_close', 'sections', '1', 'hidden', 0);

-- PROJECT_CREATE
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(4, 'project_create', 'access_level', 'level_create_proj', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(5, 'project_create', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(6, 'project_create', 'sections', '1', 'hidden', 0);

-- PROJECT_EDIT
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(7, 'project_edit', 'access_level', 'level_edit', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(8, 'project_edit', 'admin_view', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(9, 'project_edit', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(10, 'project_edit', 'sections', '1', 'hidden', 0);

-- PROJECT_LIST
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(11, 'project_list', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(12, 'project_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(13, 'project_list', 'view_only', '1', 'label', 0);

-- PROJECT_LIST_FILTERS
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(14, 'project_list_filters', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(15, 'project_list_filters', 'any_option', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(16, 'project_list_filters', 'multiple', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(17, 'project_list_filters', 'view_only', '0', 'label', 0);

-- PROJECT_TAB_1
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(18, 'project_tab_1', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(19, 'project_tab_1', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(20, 'project_tab_1', 'label', 'Tasks', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(21, 'project_tab_1', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(22, 'project_tab_1', 'preload', 'tasks', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(23, 'project_tab_1', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(24, 'project_tab_1', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(25, 'project_tab_1', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(26, 'project_tab_1', 'width', '50', 'text', 0);

-- PROJECT_TAB_2
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(27, 'project_tab_2', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(28, 'project_tab_2', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(29, 'project_tab_2', 'label', 'Details', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(30, 'project_tab_2', 'postload', 'details,log', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(31, 'project_tab_2', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(32, 'project_tab_2', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(33, 'project_tab_2', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(34, 'project_tab_2', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(35, 'project_tab_2', 'width', '50', 'text', 0);

-- PROJECT_TAB_3
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(36, 'project_tab_3', 'access_level', 'level_edit', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(37, 'project_tab_3', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(38, 'project_tab_3', 'label', 'Props', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(39, 'project_tab_3', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(40, 'project_tab_3', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(41, 'project_tab_3', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(42, 'project_tab_3', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(43, 'project_tab_3', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(44, 'project_tab_3', 'width', '50', 'text', 0);

-- PROJECT_TAB_4
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(45, 'project_tab_4', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(46, 'project_tab_4', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(47, 'project_tab_4', 'label', 'Contacts', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(48, 'project_tab_4', 'postload', 'contacts', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(49, 'project_tab_4', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(50, 'project_tab_4', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(51, 'project_tab_4', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(52, 'project_tab_4', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(53, 'project_tab_4', 'width', '50', 'text', 0);

-- PROJECT_TAB_5
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(54, 'project_tab_5', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(55, 'project_tab_5', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(56, 'project_tab_5', 'label', 'Notify', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(57, 'project_tab_5', 'postload', 'notify', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(58, 'project_tab_5', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(59, 'project_tab_5', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(60, 'project_tab_5', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(61, 'project_tab_5', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(62, 'project_tab_5', 'width', '50', 'text', 0);

-- PROJECT_TAB_6
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(63, 'project_tab_6', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(64, 'project_tab_6', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(65, 'project_tab_6', 'label', 'Attachments', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(66, 'project_tab_6', 'postload', 'attachments', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(67, 'project_tab_6', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(68, 'project_tab_6', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(69, 'project_tab_6', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(70, 'project_tab_6', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(71, 'project_tab_6', 'width', '50', 'text', 0);

-- PROJECT_TAB_7
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(72, 'project_tab_7', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(73, 'project_tab_7', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(74, 'project_tab_7', 'label', 'Related', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(75, 'project_tab_7', 'postload', 'related', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(76, 'project_tab_7', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(77, 'project_tab_7', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(78, 'project_tab_7', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(79, 'project_tab_7', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(80, 'project_tab_7', 'width', '50', 'text', 0);

-- PROJECT_TAB_8
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(81, 'project_tab_8', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(82, 'project_tab_8', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(83, 'project_tab_8', 'label', 'Other', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(84, 'project_tab_8', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(85, 'project_tab_8', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(86, 'project_tab_8', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(87, 'project_tab_8', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(88, 'project_tab_8', 'visible', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(89, 'project_tab_8', 'width', '50', 'text', 0);

-- PROJECT_TASKS
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(90, 'project_tasks', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(91, 'project_tasks', 'sections', '0', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(92, 'project_tasks', 'show_totals', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(93, 'project_tasks', 'view_only', '1', 'label', 0);

-- PROJECT_VIEW_TOP
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(94, 'project_view_top', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(95, 'project_view_top', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(96, 'project_view_top', 'move_actions_up', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(97, 'project_view_top', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(98, 'project_view_top', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(99, 'project_view_top', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(100, 'project_view_top', 'show_summary_inline', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(101, 'project_view_top', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(102, 'project_view_top', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(103, 'project_view_top', 'width', '50', 'text', 0);

-- SEARCH_FORM
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(104, 'search_form', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(105, 'search_form', 'admin_view', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(106, 'search_form', 'any_option', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(107, 'search_form', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(108, 'search_form', 'multiple', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(109, 'search_form', 'sections', '0', 'hidden', 0);

-- SEARCH_LIST
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(110, 'search_list', 'sections', '0', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(111, 'search_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(112, 'search_list', 'view_only', '1', 'label', 0);

-- TICKET_CLOSE
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(113, 'ticket_close', 'access_level', 'level_user', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(114, 'ticket_close', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(115, 'ticket_close', 'sections', '1', 'hidden', 0);

-- TICKET_CREATE
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(116, 'ticket_create', 'access_level', 'level_create', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(117, 'ticket_create', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(118, 'ticket_create', 'sections', '1', 'hidden', 0);

-- TICKET_EDIT
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(119, 'ticket_edit', 'access_level', 'level_edit', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(120, 'ticket_edit', 'admin_view', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(121, 'ticket_edit', 'has_behaviors', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(122, 'ticket_edit', 'sections', '1', 'hidden', 0);

-- TICKET_LIST
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(123, 'ticket_list', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(124, 'ticket_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(125, 'ticket_list', 'view_only', '1', 'label', 0);

-- TICKET_LIST_FILTERS
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(126, 'ticket_list_filters', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(127, 'ticket_list_filters', 'any_option', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(128, 'ticket_list_filters', 'multiple', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(129, 'ticket_list_filters', 'view_only', '0', 'label', 0);

-- TICKET_TAB_1
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(130, 'ticket_tab_1', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(131, 'ticket_tab_1', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(132, 'ticket_tab_1', 'label', 'Details', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(133, 'ticket_tab_1', 'postload', 'details,log', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(134, 'ticket_tab_1', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(135, 'ticket_tab_1', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(136, 'ticket_tab_1', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(137, 'ticket_tab_1', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(138, 'ticket_tab_1', 'width', '50', 'text', 0);

-- TICKET_TAB_2
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(139, 'ticket_tab_2', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(140, 'ticket_tab_2', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(141, 'ticket_tab_2', 'label', 'Props', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(142, 'ticket_tab_2', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(143, 'ticket_tab_2', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(144, 'ticket_tab_2', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(145, 'ticket_tab_2', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(146, 'ticket_tab_2', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(147, 'ticket_tab_2', 'width', '50', 'text', 0);

-- TICKET_TAB_3
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(148, 'ticket_tab_3', 'access_level', 'level_edit', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(149, 'ticket_tab_3', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(150, 'ticket_tab_3', 'label', 'Edit', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(151, 'ticket_tab_3', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(152, 'ticket_tab_3', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(153, 'ticket_tab_3', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(154, 'ticket_tab_3', 'view_only', '0', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(155, 'ticket_tab_3', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(156, 'ticket_tab_3', 'width', '50', 'text', 0);

-- TICKET_TAB_4
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(157, 'ticket_tab_4', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(158, 'ticket_tab_4', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(159, 'ticket_tab_4', 'label', 'Contacts', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(160, 'ticket_tab_4', 'postload', 'contacts', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(161, 'ticket_tab_4', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(162, 'ticket_tab_4', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(163, 'ticket_tab_4', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(164, 'ticket_tab_4', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(165, 'ticket_tab_4', 'width', '50', 'text', 0);

-- TICKET_TAB_5
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(166, 'ticket_tab_5', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(167, 'ticket_tab_5', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(168, 'ticket_tab_5', 'label', 'Notify', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(169, 'ticket_tab_5', 'postload', 'notify', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(170, 'ticket_tab_5', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(171, 'ticket_tab_5', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(172, 'ticket_tab_5', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(173, 'ticket_tab_5', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(174, 'ticket_tab_5', 'width', '50', 'text', 0);

-- TICKET_TAB_6
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(175, 'ticket_tab_6', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(176, 'ticket_tab_6', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(177, 'ticket_tab_6', 'label', 'Attachments', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(178, 'ticket_tab_6', 'postload', 'attachments', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(179, 'ticket_tab_6', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(180, 'ticket_tab_6', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(181, 'ticket_tab_6', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(182, 'ticket_tab_6', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(183, 'ticket_tab_6', 'width', '50', 'text', 0);

-- TICKET_TAB_7
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(184, 'ticket_tab_7', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(185, 'ticket_tab_7', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(186, 'ticket_tab_7', 'label', 'Related', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(187, 'ticket_tab_7', 'postload', 'related', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(188, 'ticket_tab_7', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(189, 'ticket_tab_7', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(190, 'ticket_tab_7', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(191, 'ticket_tab_7', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(192, 'ticket_tab_7', 'width', '50', 'text', 0);

-- TICKET_TAB_8
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(193, 'ticket_tab_8', 'access_level', 'level_view', 'access', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(194, 'ticket_tab_8', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(195, 'ticket_tab_8', 'label', 'Other', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(196, 'ticket_tab_8', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(197, 'ticket_tab_8', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(198, 'ticket_tab_8', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(199, 'ticket_tab_8', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(200, 'ticket_tab_8', 'visible', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(201, 'ticket_tab_8', 'width', '50', 'text', 0);

-- TICKET_VIEW_TOP
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(202, 'ticket_view_top', 'access_level', 'level_view', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(203, 'ticket_view_top', 'columns', '10', 'text', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(204, 'ticket_view_top', 'move_actions_up', '0', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(205, 'ticket_view_top', 'postload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(206, 'ticket_view_top', 'preload', '', 'load', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(207, 'ticket_view_top', 'sections', '1', 'hidden', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(208, 'ticket_view_top', 'show_summary_inline', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(209, 'ticket_view_top', 'view_only', '1', 'label', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(210, 'ticket_view_top', 'visible', '1', 'checkbox', 0);
INSERT INTO ZENTRACK_VIEW_MAP (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(211, 'ticket_view_top', 'width', '50', 'text', 0);

CREATE TABLE ZENTRACK_VARFIELD_MULTI (
  multi_id int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  field_name varchar(25) NOT NULL default '',
  field_value varchar(255) default NULL,
  PRIMARY KEY  (multi_id)
);

CREATE INDEX vf_multi_idx ON ZENTRACK_VARFIELD_MULTI(ticket_id);
CREATE SEQUENCE varfield_multi_id_seq 1001;
