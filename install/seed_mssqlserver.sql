
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
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (74,'version_xx','2.5.0.2','The version of zentrack, this cannot be edited');
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
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (103,'retain_owner_pending','on','Keep owner data on tickets after
 a ticket is set to PENDING');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (104,'retain_owner_closed','on','Keep owner data on tickets after a ticket is set to CLOSED');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (105,'character_set','ISO-8859-15','Character set to be used');

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

