
-- 
-- Table structure for table 'ZENTRACK_REPORTS' 
-- 

CREATE TABLE ZENTRACK_REPORTS ( 
   report_id number(12) CONSTRAINT reports_id_not_null NOT NULL,
   report_name varchar2(100) default NULL, 
   report_type varchar2(25) default NULL, 
   date_selector varchar2(25) default NULL, 
   date_value number(3) default NULL, 
   date_range varchar2(12) default NULL, 
   date_low number(12) default NULL, 
   chart_title varchar2(255) default NULL, 
   chart_subtitle varchar2(255) default NULL, 
   chart_add_ttl number(1) default NULL, 
   chart_add_avg number(1) default NULL, 
   chart_type varchar2(25) default NULL, 
   chart_options varchar2(2000), 
   data_set varchar2(2000), 
   chart_combine number(1) default NULL, 
   text_output number(1) default NULL, 
   show_data_vals number(1) default NULL, 
  CONSTRAINT reports_pk PRIMARY KEY (report_id)
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_INDEX' 
-- 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
   report_id number(12) default NULL, 
   bid number(12) default NULL, 
   user_id number(12) default NULL 
);

-- 
-- Table structure for table 'ZENTRACK_REPORTS_TEMP' 
-- 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
   report_id number(12) CONSTRAINT reptemp_id_not_null NOT NULL, 
   report_name varchar2(100) default NULL, 
   report_type varchar2(25) default NULL, 
   date_selector varchar2(25) default NULL, 
   date_value number(3) default NULL, 
   date_range varchar2(12) default NULL, 
   date_low number(12) default NULL, 
   chart_title varchar2(255) default NULL, 
   chart_subtitle varchar2(255) default NULL, 
   chart_add_ttl number(1) default NULL, 
   chart_add_avg number(1) default NULL, 
   chart_type varchar2(25) default NULL, 
   chart_options varchar2(2000), 
   data_set varchar2(2000), 
   created datetime NOT NULL default '0000-00-00 00:00:00', 
   chart_combine number(1) default NULL, 
   text_output number(1) default NULL, 
   show_data_vals number(1) default NULL, 
   CONSTRAINT reptemp_pk PRIMARY KEY (report_id)
);

create sequence reports_id_seq             start with 1001 nocache;
create sequence reports_temp_id_seq        start with 1001 nocache;

CREATE INDEX REPINDEX_COMB ON ZENTRACK_REPORTS_INDEX (user_id,bid);

--
-- Load new settings to 'ZENTRACK_SETTINGS'
--

UPDATE ZENTRACK_SETTINGS SET value = '#000066' WHERE name = 'color_alt_text';
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (73,'level_reports','1','Level required to access and view reports'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (74,'version_xx','2.2.2','The version of zentrack, this cannot be edited'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (75,'date_fmt_long','%A %d, %b %Y','Long date format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (76,'date_fmt_short','%m/%d/%Y','Short Date Format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (77,'date_fmt_time','%H:%M','Time Format'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (78,'time_elapsed_unit','hours','Use hours, days, months, years, seconds, or weeks'); 
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (79,'language_default','english','This will be used in an upcoming version'); 
