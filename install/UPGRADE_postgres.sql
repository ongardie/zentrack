
--
-- ID SEQUENCES
--

CREATE SEQUENCE "reports_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;
CREATE SEQUENCE "reports_temp_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1  cache 1;

-- 
-- Table structure for table 'ZENTRACK_REPORTS' 
-- 

CREATE TABLE ZENTRACK_REPORTS ( 
   report_id int8 default nextval('"reports_id_seq"') NOT NULL PRIMARY KEY, 
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int(3) default NULL, 
   date_range varchar(12) default NULL, 
   date_low int8 default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int2 default NULL, 
   chart_add_avg int2 default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   chart_combine int2 default NULL, 
   text_output int2 default NULL, 
   show_data_vals int2 default NULL
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_INDEX' 
-- 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
   report_id int8 default NULL, 
   bid int8 default NULL, 
   user_id int8 default NULL 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_TEMP' 
-- 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
   report_id int8 default nextval('"reports_temp_id_seq"') NOT NULL PRIMARY KEY,
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int(3) default NULL, 
   date_range varchar(12) default NULL, 
   date_low int8 default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int2 default NULL, 
   chart_add_avg int2 default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   created datetime NOT NULL default '0000-00-00 00:00:00', 
   chart_combine int2 default NULL, 
   text_output int2 default NULL, 
   show_data_vals int2 default NULL, 
   PRIMARY KEY (report_id)
);

--
-- Load new settings to 'ZENTRACK_SETTINGS'
--

UPDATE ZENTRACK_SETTINGS SET value = '#000066' WHERE name = 'color_alt_text';
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (73,'level_reports','1','Level required to access and view reports'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (74,'version_xx','2.2','The version of zentrack, this cannot be edited'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (75,'date_fmt_long','%A %d, %b %Y','Long date format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (76,'date_fmt_short','%x','Short Date Format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (77,'date_fmt_time','%R','Time Format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (78,'time_elapsed_unit','hours','Use hours, days, months, years, seconds, or weeks'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (79,'language_default','english','This will be used in an upcoming version'); 
