#
# Dumping data for table 'ZENTRACK_ACCESS'
#

INSERT INTO ZENTRACK_ACCESS (aid, userID, binID, lvl, role) VALUES (1,2,2,1,NULL);
INSERT INTO ZENTRACK_ACCESS (aid, userID, binID, lvl, role) VALUES (2,2,3,1,NULL);
INSERT INTO ZENTRACK_ACCESS (aid, userID, binID, lvl, role) VALUES (3,2,3,2,NULL);
INSERT INTO ZENTRACK_ACCESS (aid, userID, binID, lvl, role) VALUES (4,2,4,1,NULL);
INSERT INTO ZENTRACK_ACCESS (aid, userID, binID, lvl, role) VALUES (5,2,3,1,NULL);

#
# Dumping data for table 'ZENTRACK_BINS'
#

INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (1,'Accounting',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (2,'Engineering',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (3,'Marketing',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (4,'IT',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (5,'Tech Support',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (6,'Human Resources',0,1);
INSERT INTO ZENTRACK_BINS (bid, name, priority, active) VALUES (7,'Test Bin',0,0);

#
# Dumping data for table 'ZENTRACK_LOGS'
#

INSERT INTO ZENTRACK_LOGS (lid, ticketID, userID, binID, created, action, hours, entry) VALUES (1,2,1,2,1019621210,'ACCEPTED',NULL,NULL);

#
# Dumping data for table 'ZENTRACK_LOGS_ARCHIVED'
#


#
# Dumping data for table 'ZENTRACK_PREFERENCES'
#


#
# Dumping data for table 'ZENTRACK_PRIORITIES'
#

INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (1,'Critical',5,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (2,'High',4,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (3,'Medium',3,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (4,'Low',2,1);
INSERT INTO ZENTRACK_PRIORITIES (pid, name, priority, active) VALUES (6,'None',1,1);

#
# Dumping data for table 'ZENTRACK_SETTINGS'
#

INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (1,'admin_email','root@localhost','The email address of the zenTrack administrator');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (2,'bot_name','zenBot','The system bots name');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (3,'allow_cview','on','Allow ticket creator to view the ticket, regardless of access');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (4,'allow_reject','on','Allow tickets to be rejected');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (5,'allow_yank','on','Allow tickets to be yanked');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (6,'allow_assign','on','Allow tickets to be assigned');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (7,'allow_accept','on','Allow tickets to be accepted');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (8,'allow_relate','on','Allow tickets to be related to one another');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (9,'attachment_max_size','20000','The maximum file size of an attachment (in Bytes)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (10,'attachment_text_types','php,txt,pl,cgi,asp,jsp,java,class,inc','Files with this extention will be displayed as text by the browser');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (11,'attachment_types_allowed','txt,html,xls,pdf,jpg,gif,png,doc,wpd,php','Comma seperated list.  Only these extensions may be uploaded.  Set to blank to allow all(security risk)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (12,'color_links','#006633','Color of links on the page');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (13,'color_grey','#666666','Greyed text color');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (14,'color_background','#FFFFFF','Color of normal bg');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (15,'color_text','#000000','Color of normal text');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (16,'color_alt_background','#99CCCC','Color of alternate bg');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (17,'color_alt_text','#006666','Color of alternate text');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (18,'color_title_background','#669999','Color of title cell bg');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (19,'color_title_text','#FFFFFF','Color of title cell text');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (20,'color_bars','#EAEAEA','Color of background in rows of data');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (21,'color_bar_text','#006666','Color of text in rows of data');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (22,'color_hot','#990000','Color of text when hot(critical/errors)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (23,'color_highlight','#CCFFCC','Color of background to highlight text');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (24,'color_hover','#00FF33','Color of links on mouseover (hover)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (25,'default_test_checked','on','Testing required defaults to yes');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (26,'default_aprv_checked','off','Approval required defaults to yes');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (27,'email_pending','on','Send email to tester/approver when email is pending');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (28,'email_reject','on','Send email to sender/creator when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (29,'email_assign','on','Send email to recipient when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (30,'email_arrival','on','Send email to bin owner when ticket arrives in bin');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (31,'email_created','on','Send email to bin owner when ticket is created');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (32,'email_closed','on','Send email to bin owner when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (33,'email_completed','on','Send email to bin owner when ticket is completed');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (34,'email_max_logs','40','Maximum logs to send via email.  Set to blank for unlimited');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (35,'font_size','12','Font size on pages, in pixels');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (36,'font_face','Arial, Helvetica','Font face to appear on pages, comma seperated list');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (37,'level_create','2','Level required to create a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (38,'level_hot','1','Priority level to consider hot(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (39,'level_highlight','2','Priority level to highlight(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (40,'level_user','2','Level required to perform worker/user tasks');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (41,'level_super','3','Level required to perform supervisor tasks');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (42,'level_settings','5','Level required to edit system settings');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (43,'level_accept','2','Level required to accept a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (44,'level_assign','3','Level required to assign a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (45,'level_yank','3','Level required to yank a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (46,'level_test','3','Level required to test a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (47,'level_approve','3','Level required to approve a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (48,'level_move','2','Level required to move a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (49,'level_view','0','Level required to view a bin');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (50,'level_edit','3','Level required to edit a ticket');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (51,'log_show_bins','on','Display current bin in log view');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (52,'log_show_time','on','Display time created in the log view');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (53,'log_show_user','on','Display creator in the log view');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (54,'log_show_att','on','Display attachments in the log view');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (55,'log_edit','on','Create a log when ticket is edited');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (56,'log_assign','on','Create a log when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (57,'log_accept','on','Create a log when ticket is accepted');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (58,'log_relate','on','Create a log when ticket is related');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (59,'log_reject','on','Create a log when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (60,'log_approve','on','Create a log when ticket is approved');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (61,'log_close','on','Create a log when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (62,'log_test','on','Create a log when ticket is tested');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (63,'log_move','on','Create a log when ticket is moved');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (64,'log_yank','on','Create a log when ticket is yanked');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (65,'log_pending','on','Create a log when status is set to pending');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (66,'log_attachment','on','Create a log entry when an attachment is added.');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (67,'system_name','zenTrack','Name of the zenTrack ticketing system displayed to users');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (68,'url_view_attachment','http://devtrack.phpzen.net/viewAttachment.php','Link to script which displays attachments in a secure manner (for server integrity)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (69,'url_view_log','/viewLog.php','Link to script which displays an individual log entry');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (70,'url_view_ticket','/ticket.php','Link to script which displays ticket information');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (71,'allow_pwd_save','off','Allows users to save password in a cookie(fairly secure/not available until v2.1)');
INSERT INTO ZENTRACK_SETTINGS (setID, name, value, description) VALUES (72,'check_pwd_simple','on','System will refuse lazy passwords');

#
# Dumping data for table 'ZENTRACK_SYSTEMS'
#

INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (1,'Apache',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (2,'Email',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (3,'Database',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (4,'Network',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (5,'PC',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (6,'Printer',0,1);
INSERT INTO ZENTRACK_SYSTEMS (sid, name, priority, active) VALUES (7,'Website',0,1);

#
# Dumping data for table 'ZENTRACK_TASKS'
#

INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (1,'Action Taken',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (2,'Debugging',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (3,'Implementation',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (4,'Note',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (5,'Planning',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (6,'Question',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (7,'Research',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (8,'Review',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (9,'Solution',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (10,'Testing',0,1);
INSERT INTO ZENTRACK_TASKS (taskID, name, priority, active) VALUES (11,'Work',0,1);

#
# Dumping data for table 'ZENTRACK_TICKETS'
#

INSERT INTO ZENTRACK_TICKETS (id, title, priority, status, description, otime, ctime, binID, typeID, userID, systemID, creatorID, tested, approved, relations, projectID, est_hours, deadline, start_date, wkd_hours) VALUES (1,'Welcome to zenTrack!!',2,'OPEN','Welcome to the zenTrack system!\r<br />\n\r<br />\nCongratulations, your install was successful.\r<br />\n\r<br />\nYou can find more help in the help section on this site, and online at http://zentrack.phpzen.net.\r<br />\n\r<br />\nYou can find support for your product at the sourceforge project: http://www.sourceforge.net/projects/zentrack',1019621097,NULL,2,5,NULL,7,1,0,0,NULL,NULL,0.00,NULL,NULL,0.00);
INSERT INTO ZENTRACK_TICKETS (id, title, priority, status, description, otime, ctime, binID, typeID, userID, systemID, creatorID, tested, approved, relations, projectID, est_hours, deadline, start_date, wkd_hours) VALUES (2,'CHANGE ADMIN PASSWORD',1,'OPEN','You need to change the admin password right away.\r<br />\n\r<br />\nIn addition, two other accounts, User, and Guest were created.  You will want to modify those or delete them as your system security and preferences determine.',1019621197,NULL,2,8,1,7,1,1,0,NULL,NULL,0.01,1022137200,NULL,0.00);

#
# Dumping data for table 'ZENTRACK_TRANSLATION_STRINGS'
#

INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (1,'english','log in','log in');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (2,'english','not required','not required');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (3,'english','view users','view users');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (4,'english','view projects','view projects');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (5,'english','view summary','view summary');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (6,'english','view user reports','view user reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (7,'english','view project reports','view project reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (8,'english','summary reports','summary reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (9,'english','tickets assigned to','tickets assigned to');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (10,'english','no tickets assigned to','no tickets assigned to');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (11,'english','no open tickets','no open tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (12,'english','filtered tickets','filtered tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (13,'english','administrate user access','administrate user access');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (14,'english','administrate users','administrate users');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (15,'english','administrate tickets','administrate tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (16,'english','phrase 1','open a new ticket');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (17,'english','phrase 2','please enter a new bin');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (18,'english','phrase 3','enter id\'s seperated by commas or carriage returns');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (trID, language, identifier, string) VALUES (19,'english','phrase 4','please read the administrator\'s manual before attempting to alter any settings.  altering these settings can result in severe consequences, without proper understanding.');

#
# Dumping data for table 'ZENTRACK_TRANSLATION_WORDS'
#

INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (1,'english','accept','accept');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (2,'english','all','all');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (3,'english','admin','admin');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (4,'english','approval','approved');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (5,'english','approved','approved');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (6,'english','assign','assign');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (7,'english','bin','bin');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (8,'english','calendar','calendar');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (9,'english','close','close');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (10,'english','created','created');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (11,'english','closed','closed');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (12,'english','comments','comments');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (13,'english','completed','completed');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (14,'english','configure','configure');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (15,'english','description','description');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (16,'english','detected','detected');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (17,'english','development','development');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (18,'english','edit','edit');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (19,'english','email','email');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (20,'english','errors','errors');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (21,'english','for','for');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (22,'english','general','general');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (23,'english','help','help');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (24,'english','in','in');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (25,'english','installation','installation');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (26,'english','log','log');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (27,'english','menu','menu');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (28,'english','move','move');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (29,'english','new','new');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (30,'english','number','number');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (31,'english','open','open');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (32,'english','opened','opened');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (33,'english','optional','optional');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (34,'english','options','options');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (35,'english','owned','owned');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (36,'english','owner','owner');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (37,'english','parent','parent');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (38,'english','pending','pending');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (39,'english','please','please');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (40,'english','pri','pri');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (41,'english','print','print');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (42,'english','priority','priority');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (43,'english','project','project');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (44,'english','projects','projects');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (45,'english','quick','quick');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (46,'english','related','related');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (47,'english','refresh','refresh');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (48,'english','reject','reject');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (49,'english','relate','relate');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (50,'english','required','required');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (51,'english','reports','reports');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (52,'english','save','save');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (53,'english','search','search');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (54,'english','searches','searches');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (55,'english','settings','settings');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (56,'english','status','status');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (57,'english','system','system');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (58,'english','tested','tested');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (59,'english','testing','testing');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (60,'english','ticket','ticket');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (61,'english','tickets','tickets');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (62,'english','time','time');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (63,'english','title','title');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (64,'english','to','to');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (65,'english','type','type');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (66,'english','view','view');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (67,'english','welcome','welcome');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (68,'english','yank','yank');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (69,'english','atc','atc');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (70,'english','etc','etc');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (71,'english','id','id');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (72,'english','na','n/a');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (wordID, language, identifier, translation) VALUES (73,'english','pid','pid');

#
# Dumping data for table 'ZENTRACK_TYPES'
#

INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (1,'Project',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (2,'Support Request',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (3,'Bug',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (4,'Enhancement',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (5,'Event Log',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (6,'Feature Request',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (7,'Service',0,1);
INSERT INTO ZENTRACK_TYPES (typeID, name, priority, active) VALUES (8,'Task',0,1);

#
# Dumping data for table 'ZENTRACK_USERS'
#

INSERT INTO ZENTRACK_USERS (uid, login, access, passwd, lname, fname, initials, email, notes, homebin, active) VALUES (1,'Administrator',5,'7b7bc2512ee1fedcd76bdc68926d4f7b','Administrator','zenTrack','ADMIN','root@localhost','This is the master login',2,2);
INSERT INTO ZENTRACK_USERS (uid, login, access, passwd, lname, fname, initials, email, notes, homebin, active) VALUES (2,'Guest',0,'adb831a7fdd83dd1e2a309ce7591dff8','Visitor','Guest','GUEST',NULL,NULL,2,1);
INSERT INTO ZENTRACK_USERS (uid, login, access, passwd, lname, fname, initials, email, notes, homebin, active) VALUES (3,'User',3,'8f9bfe9d1345237cb3b2b205864da075','User','Default','USER',NULL,'Default User Account',2,1);


