
#
# Table structure for `zentrack_agreement`
#

CREATE TABLE ZENTRACK_AGREEMENT (
  agree_id int(12) NOT NULL auto_increment,
  company_id int(12) default NULL,
  contractnr varchar(50) default NULL,
  title varchar(50) default NULL,
  description text,
  stime int(12) default NULL,
  dtime int(12) default NULL,
  status int(2) default '1',
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (agree_id)
);

#
# Table structure for `zentrack_agreement_item`
#

CREATE TABLE ZENTRACK_AGREEMENT_ITEM (
  item_id int(12) NOT NULL auto_increment,
  agree_id int(12) default NULL,
  name1 varchar(50) default NULL,
  description1 varchar(50) default NULL,
  odate int(12) default NULL,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (item_id)
);

#
# Table structure for `zentrack_company`
#

CREATE TABLE ZENTRACK_COMPANY (
  company_id int(12) NOT NULL auto_increment,
  title varchar(50) default NULL,
  office varchar(50) default NULL,
  address1 varchar(50) default NULL,
  address2 varchar(50) default NULL,
  address3 varchar(50) default NULL,
  postcode varchar(50) default NULL,
  postcode2 varchar(50) default NULL,
  pobox varchar(50) default NULL,
  place varchar(50) default NULL,
  telephone varchar(20) default NULL,
  fax varchar(20) default NULL,
  country varchar(100) default NULL,
  email varchar(100) default NULL,
  website varchar(100) default NULL,
  description text,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (company_id)
);

#
# Table structure for `zentrack_employee`
#

CREATE TABLE ZENTRACK_EMPLOYEE (
  person_id int(12) NOT NULL auto_increment,
  company_id int(12) default NULL,
  fname varchar(50) default NULL,
  lname varchar(50) default NULL,
  initials varchar(15) default NULL,
  jobtitle varchar(50) default NULL,
  department varchar(50) default NULL,
  email varchar(100) default NULL,
  telephone varchar(20) default NULL,
  mobiel varchar(20) default NULL,
  inextern int(2) default NULL,
  description text,
  create_time int(12) default NULL,
  change_time int(12) default NULL,
  creator_id int(12) default NULL,
  change_id int(12) default NULL,
  PRIMARY KEY  (person_id)
);

#
# Table structure for `zentrack_related_contacts`
#

CREATE TABLE ZENTRACK_RELATED_CONTACTS (
  clist_id int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  cp_id int(12) default NULL,
  type int(12) default NULL,
  PRIMARY KEY  (clist_id)
);

#
# Table structure for table 'ZENTRACK_NOTIFY_LIST'
#
CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id int(12) NOT NULL auto_increment,
   ticket_id int(12) NOT NULL,
   user_id int(12) default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority int(12) default NULL,
   notes varchar(255) default NULL,
   PRIMARY KEY (notify_id)
);

#
# Table structure for table 'ZENTRACK_ACCESS'
#

CREATE TABLE ZENTRACK_ACCESS (
  access_id int(12) NOT NULL auto_increment,
  user_id int(12) default NULL,
  bin_id int(12) default NULL,
  lvl int(2) default NULL,
  notes varchar(25) default NULL,
  PRIMARY KEY (access_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_ATTACHMENTS'
#

CREATE TABLE ZENTRACK_ATTACHMENTS (
  attachment_id int(12) NOT NULL auto_increment,
  log_id int(12) default NULL,
  ticket_id int(12) default NULL,
  name varchar(25) default NULL,
  filename varchar(250) default NULL,
  filetype varchar(250) default NULL,
  description varchar(100) default NULL,
  PRIMARY KEY (attachment_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_BINS'
#

CREATE TABLE ZENTRACK_BINS (
  bid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default '1',
  PRIMARY KEY (bid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_LOGS'
#

CREATE TABLE ZENTRACK_LOGS (
  lid int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  user_id int(12) NOT NULL default '0',
  bin_id int(12) NOT NULL default '0',
  created int(12) default NULL,
  action varchar(25) default NULL,
  hours decimal(10,2) default NULL,
  entry text,
  PRIMARY KEY (lid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_PREFERENCES'
#

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id  int(12) NOT NULL default '0',
  prefname varchar(25),
  prefval  varchar(50),
  index (user_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_PRIORITIES'
#

CREATE TABLE ZENTRACK_PRIORITIES (
  pid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (pid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_SETTINGS'
#

CREATE TABLE ZENTRACK_SETTINGS (
  setting_id int(12) NOT NULL auto_increment,
  name varchar(25) default NULL,
  value varchar(100) default NULL,
  description varchar(200) default NULL,
  PRIMARY KEY (setting_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_SYSTEMS'
#

CREATE TABLE ZENTRACK_SYSTEMS (
  sid int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (sid)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TASKS'
#

CREATE TABLE ZENTRACK_TASKS (
  task_id int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (task_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TICKETS'
#

CREATE TABLE ZENTRACK_TICKETS (
  id int(12) NOT NULL auto_increment,
  title varchar(50) NOT NULL default 'untitled',
  priority int(2) NOT NULL default '0',
  status varchar(25) NOT NULL default 'OPEN',
  description text,
  otime int(12) default NULL,
  ctime int(12) default NULL,
  bin_id int(12) default NULL,
  type_id int(12) default NULL,
  user_id int(12) default NULL,
  system_id int(12) default NULL,
  creator_id int(12) default NULL,
  tested int(1) default '0',
  approved int(1) default '0',
  relations varchar(255) default NULL,
  project_id int(12) default NULL,
  est_hours decimal(10,2) default '0.00',
  deadline int(12) default NULL,
  start_date int(12) default NULL,
  wkd_hours decimal(10,2) default '0.00',
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_TYPES'
#

CREATE TABLE ZENTRACK_TYPES (
  type_id int(12) NOT NULL auto_increment,
  name varchar(25) NOT NULL default '',
  priority int(4) default NULL,
  active int(1) default NULL,
  PRIMARY KEY (type_id)
) TYPE=MyISAM;

#
# Table structure for table 'ZENTRACK_USERS'
#

CREATE TABLE ZENTRACK_USERS (
  user_id int(12) NOT NULL auto_increment,
  login varchar(25) default NULL,
  access_level int(2) default NULL,
  passphrase varchar(32) default NULL,
  lname varchar(50) default NULL,
  fname varchar(50) default NULL,
  initials varchar(5) default NULL,
  email varchar(100) default NULL,
  notes varchar(255) default NULL,
  homebin int(12) default NULL,
  active int(1) default '1',
  PRIMARY KEY (user_id)
) TYPE=MyISAM;

# 
# Table structure for table 'ZENTRACK_REPORTS' 
# 

CREATE TABLE ZENTRACK_REPORTS ( 
   report_id int(12) NOT NULL auto_increment, 
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int(3) default NULL, 
   date_range varchar(12) default NULL, 
   date_low int(12) default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int(1) default NULL, 
   chart_add_avg int(1) default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   chart_combine int(1) default NULL, 
   text_output int(1) default NULL, 
   show_data_vals int(1) default NULL, 
   PRIMARY KEY (report_id) 
);

# 
# Table structure for table 'ZENTRACK_REPORTS_INDEX' 
# 

CREATE TABLE ZENTRACK_REPORTS_INDEX ( 
   report_id int(12) default NULL, 
   bid int(12) default NULL, 
   user_id int(12) default NULL 
);

# 
# Table structure for table 'ZENTRACK_REPORTS_TEMP' 
# 

CREATE TABLE ZENTRACK_REPORTS_TEMP ( 
   report_id int(12) NOT NULL auto_increment, 
   report_name varchar(100) default NULL, 
   report_type varchar(25) default NULL, 
   date_selector varchar(25) default NULL, 
   date_value int(3) default NULL, 
   date_range varchar(12) default NULL, 
   date_low int(12) default NULL, 
   chart_title varchar(255) default NULL, 
   chart_subtitle varchar(255) default NULL, 
   chart_add_ttl int(1) default NULL, 
   chart_add_avg int(1) default NULL, 
   chart_type varchar(25) default NULL, 
   chart_options text, 
   data_set text, 
   created datetime NOT NULL default '0000-00-00 00:00:00', 
   chart_combine int(1) default NULL, 
   text_output int(1) default NULL, 
   show_data_vals int(1) default NULL, 
   PRIMARY KEY (report_id), 
   KEY tempreports_created(created) 
);

#
# Release 2.5 new tables
#

CREATE TABLE ZENTRACK_BEHAVIOR (
  behavior_id int(12) NOT NULL auto_increment,
  behavior_name varchar(100),
  group_id int(12) NOT NULL,
  is_enabled int(1),
  sort_order int(3),
  field_name varchar(100),
  field_enabled int(1),
  match_all int(1),
  PRIMARY KEY (behavior_id),
  INDEX (is_enabled)
);

CREATE TABLE ZENTRACK_BEHAVIOR_DETAIL (
  behavior_id int(12) NOT NULL,
  field_name varchar(50),
  field_operator varchar(2),
  field_value varchar(255),
  sort_order int(3)
);

CREATE TABLE ZENTRACK_GROUP (
  group_id int(12) NOT NULL auto_increment,
  table_name varchar(50),
  group_name varchar(100),
  descript varchar(255),
  eval_type VARCHAR(10),
  eval_text TEXT,
  name_of_file VARCHAR(100),
  include_none int(1),
  PRIMARY KEY (group_id),
  INDEX (group_name)
);

CREATE TABLE ZENTRACK_GROUP_DETAIL (
  group_id int(12) NOT NULL,
  field_value varchar(255),
  sort_order int(3),
  INDEX (group_id, sort_order)
);

CREATE TABLE ZENTRACK_VARFIELD (
  ticket_id int(12) NOT NULL,

  /* CHANGES HERE MUST BE REFLECTED IN the values for ZENTRACK_VARFIELD_IDX */
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),

  custom_string1 varchar(255),
  custom_string2 varchar(255),

  custom_number1 int(20),
  custom_number2 int(20),

  custom_boolean1 int(1),
  custom_boolean2 int(1),

  custom_date1 int(12),
  custom_date2 int(12),

  custom_text1 text,

  INDEX (ticket_id)
);

CREATE TABLE ZENTRACK_VARFIELD_IDX (
  field_name varchar(25) NOT NULL,
  field_label varchar(50),
  field_value varchar(100),
  sort_order int(3),
  is_required int(1) default 0,
  use_for_project int(1) default 0, 
  use_for_ticket int(1) default 0,
  show_in_search int(1) default 0,
  show_in_list int(1) default 0,
  show_in_custom int(1) default 0,
  show_in_detail int(1) default 0,
  show_in_new    int(1) default 0,
  js_validation text,
  INDEX (sort_order, field_name)
);

