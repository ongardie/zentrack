
#
# data for table 'ZENTRACK_BINS'
#

INSERT INTO ZENTRACK_BINS (name,active) VALUES ('Accounting'     ,1);
INSERT INTO ZENTRACK_BINS (name,active) VALUES ('Engineering'    ,1);
INSERT INTO ZENTRACK_BINS (name,active) VALUES ('Marketing'      ,1);
INSERT INTO ZENTRACK_BINS (name,active) VALUES ('IT'             ,1);
INSERT INTO ZENTRACK_BINS (name,active) VALUES ('Tech Support'   ,1);
INSERT INTO ZENTRACK_BINS (name,active) VALUES ('Human Resources',1);

#
# data for table 'ZENTRACK_PRIORITIES'
#

INSERT INTO ZENTRACK_PRIORITIES (name,priority) VALUES ('Critical',1);
INSERT INTO ZENTRACK_PRIORITIES (name,priority) VALUES ('High'    ,2);
INSERT INTO ZENTRACK_PRIORITIES (name,priority) VALUES ('Medium'  ,3);
INSERT INTO ZENTRACK_PRIORITIES (name,priority) VALUES ('Low'     ,4);
INSERT INTO ZENTRACK_PRIORITIES (name,priority) VALUES ('None'    ,5);

#
# data for table 'ZENTRACK_SYSTEMS'
#

INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Apache');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Email');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Database');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Network');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('PC');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Printer');
INSERT INTO ZENTRACK_SYSTEMS (name) VALUES ('Website');

#
# data for table 'ZENTRACK_TASKS'
#

INSERT INTO ZENTRACK_TASKS (name) VALUES ('Action Taken');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Debugging');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Implementation');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Note');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Planning');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Question');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Research');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Review');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Solution');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Testing');
INSERT INTO ZENTRACK_TASKS (name) VALUES ('Work');

#
# data for table 'ZENTRACK_TYPES'
#

INSERT INTO ZENTRACK_TYPES (name) VALUES ('Project');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Support Request');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Bug');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Enhancement');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Event Log');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Feature Request');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Service');
INSERT INTO ZENTRACK_TYPES (name) VALUES ('Task');

#
# data for table 'ZENTRACK_USERS'
#
 
INSERT INTO ZENTRACK_USERS (login,access,passwd,lname,fname,initials,email,notes,homebin,active) VALUES ('Administrator', 5, '7b7bc2512ee1fedcd76bdc68926d4f7b', 'Administrator','zenTrack','ADMIN','zentrack@havenshade.com', 'This is the master login',NULL,NULL);
INSERT INTO ZENTRACK_USERS (login,access,passwd,lname,fname,initials,email,notes,homebin,active) VALUES ('Guest'        , 0, 'adb831a7fdd83dd1e2a309ce7591dff8', 'Visitor','Guest','GUEST',NULL,NULL,2,1);
INSERT INTO ZENTRACK_USERS (login,access,passwd,lname,fname,initials,email,notes,homebin,active) VALUES ('User'         , 2, '8f9bfe9d1345237cb3b2b205864da075', 'User','Guest','USER','me@havenshade.com',NULL,2,1);

#
# data for table 'ZENTRACK_SETTINGS'
#

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('admin_email'   ,'zentrack@havenshade.com' ,'The email address of the zenTrack administrator');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('bot_name'      ,'zenBot'                  ,'The system bots name');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('allow_reject'  ,'on' ,'Allow tickets to be rejected');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('allow_yank'    ,'on' ,'Allow tickets to be yanked');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('allow_assign'  ,'on' ,'Allow tickets to be assigned');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('allow_accept'  ,'on' ,'Allow tickets to be accepted');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('allow_relate'  ,'on' ,'Allow tickets to be related to one another');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('attachment_max_size'      ,'10000','The maximum file size of an attachment (in Kilobytes/KB)');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('attachment_text_types'    ,'php,txt,pl,cgi,asp,jsp,java,class,inc','Files with this extention will be displayed as text by the browser');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('attachment_types_allowed' ,'txt,html,xls,pdf,jpg,gif,png,doc,wpd,php','Comma seperated list.  Only these extensions may be uploaded.  Set to blank to allow all(security risk)');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_links'           , '#006633','Color of links on the page');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_grey'            , '#666666','Greyed text color');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_background'      , '#FFFFFF','Color of normal bg');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_text'            , '#000000','Color of normal text');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_alt_background'  , '#99CCCC','Color of alternate bg');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_alt_text'        , '#006666','Color of alternate text');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_title_background', '#669999','Color of title cell bg');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_title_text'      , '#FFFFFF','Color of title cell text');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_bars'            , '#EAEAEA','Color of background in rows of data');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_bar_text'        , '#006666','Color of text in rows of data');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_hot'             , '#990000','Color of text when hot(critical/errors)');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_highlight'       , '#CCFFCC','Color of background to highlight text');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('color_hover'           , '#00FF33','Color of links on mouseover (hover)');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('default_test_checked', 'on' , 'Testing required defaults to yes');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('default_aprv_checked', 'off', 'Approval required defaults to yes');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_pending'  ,'on', 'Send email to tester/approver when email is pending');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_reject'   ,'on', 'Send email to sender/creator when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_assign'   ,'on', 'Send email to recipient when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_arrival'  ,'on', 'Send email to bin owner when ticket arrives in bin');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_created'  ,'on', 'Send email to bin owner when ticket is created');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_closed'   ,'on', 'Send email to bin owner when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_completed','on', 'Send email to bin owner when ticket is completed');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('email_max_logs' ,'40', 'Maximum logs to send via email.  Set to blank for unlimited');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('font_size', '12'              , 'Font size on pages, in pixels');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('font_face', 'Arial, Helvetica', 'Font face to appear on pages, comma seperated list');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_hot'      , '1', 'Priority level to consider hot(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_highlight', '2', 'Priority level to highlight(highest is 1)');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_user'     , '2', 'Level required to perform worker/user tasks');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_super'    , '3', 'Level required to perform supervisor tasks');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_settings' , '5', 'Level required to edit system settings');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_accept'   , '2', 'Level required to accept a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_assign'   , '3', 'Level required to assign a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_yank'     , '3', 'Level required to yank a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_test'     , '3', 'Level required to test a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_approve'  , '3', 'Level required to approve a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_move'     , '2', 'Level required to move a ticket');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_view'     , '1', 'Level required to view a bin');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('level_edit'     , '3', 'Level required to edit a ticket');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_show_bins' , 'on', 'Display current bin in log view');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_show_time' , 'on', 'Display time created in the log view');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_show_user' , 'on', 'Display creator in the log view');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_show_att'  , 'on', 'Display attachments in the log view');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_edit'      ,'on' ,'Create a log when ticket is edited');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_assign'    ,'on' ,'Create a log when ticket is assigned');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_accept'    ,'on' ,'Create a log when ticket is accepted');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_relate'    ,'on' ,'Create a log when ticket is related');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_reject'    ,'on' ,'Create a log when ticket is rejected');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_approve'   ,'on' ,'Create a log when ticket is approved');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_close'     ,'on' ,'Create a log when ticket is closed');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_test'      ,'on' ,'Create a log when ticket is tested');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_move'      ,'on' ,'Create a log when ticket is moved');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_yank'      ,'on' ,'Create a log when ticket is yanked');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_pending'   ,'on' ,'Create a log when status is set to pending');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('log_attachment','on' ,'Create a log entry when an attachment is added.');

INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('system_name', 'zenTrack', 'Name of the zenTrack ticketing system displayed to users');
 
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('url_view_attachment', 'http://devtrack.phpzen.net/viewAttachment.php','Link to script which displays attachments in a secure manner (for server integrity)');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('url_view_log'       , 'http://devtrack.phpzen.net/viewLog.php','Link to script which displays an individual log entry');
INSERT INTO ZENTRACK_SETTINGS (name,value,description) VALUES ('url_view_ticket'    , 'http://devtrack.phpzen.net/ticket.php','Link to script which displays ticket information');

#
# data for table 'ZENTRACK_TRANSLATION_STRINGS'
#

INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'log in', 'log in');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'not required', 'not required');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'view users', 'view users');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'view projects', 'view projects');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'view summary', 'view summary');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'view user reports', 'view user reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'view project reports', 'view project reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'summary reports', 'summary reports');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'tickets assigned to', 'tickets assigned to');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'no tickets assigned to', 'no tickets assigned to');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'no open tickets', 'no open tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'filtered tickets', 'filtered tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'administrate user access', 'administrate user access');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'administrate users', 'administrate users');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'administrate tickets', 'administrate tickets');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'phrase 1', 'open a new ticket');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'phrase 2', 'please enter a new bin');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'phrase 3', 'enter id\'s seperated by commas or carriage returns');
INSERT INTO ZENTRACK_TRANSLATION_STRINGS (language,identifier,string) VALUES ('english', 'phrase 4', 'please read the administrator\'s manual before attempting to alter any settings.  altering these settings can result in severe consequences, without proper understanding.');

#
# data for table 'ZENTRACK_TRANSLATION_WORDS'
#

INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'accept', 'accept');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'all', 'all');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'admin', 'admin');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'approval', 'approved');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'approved', 'approved');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'assign', 'assign');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'bin', 'bin');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'calendar', 'calendar');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'close', 'close');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'created', 'created');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'closed', 'closed');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'comments', 'comments');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'completed', 'completed');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'configure', 'configure');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'description', 'description');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'detected', 'detected');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'development', 'development');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'edit', 'edit');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'email', 'email');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'errors', 'errors');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'for', 'for');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'general', 'general');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'help', 'help');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'in', 'in');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'installation', 'installation');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'log', 'log');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'menu', 'menu');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'move', 'move');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'new', 'new');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'number', 'number');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'open', 'open');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'opened', 'opened');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'optional', 'optional');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'options', 'options');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'owned', 'owned');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'owner', 'owner');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'parent', 'parent');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'pending', 'pending');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'please', 'please');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'pri', 'pri');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'print', 'print');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'priority', 'priority');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'project', 'project');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'projects', 'projects');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'quick', 'quick');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'related', 'related');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'refresh', 'refresh');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'reject', 'reject');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'relate', 'relate');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'required', 'required');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'reports', 'reports');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'save', 'save');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'search', 'search');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'searches', 'searches');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'settings', 'settings');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'status', 'status');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'system', 'system');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'tested', 'tested');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'testing', 'testing');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'ticket', 'ticket');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'tickets', 'tickets');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'time', 'time');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'title', 'title');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'to', 'to');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'type', 'type');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'view', 'view');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'welcome', 'welcome');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'yank', 'yank');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'atc', 'atc');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'etc', 'etc');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'id', 'id');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'na', 'n/a');
INSERT INTO ZENTRACK_TRANSLATION_WORDS (language,identifier,translation) VALUES ('english', 'pid', 'pid');
