
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (80,'default_deadline','+1 month','Format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (81,'default_start_date','+1 day','Format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (82,'email_interface_enabled','off', 'Use the email gateway');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (83,'default_notify_manager','on','Add bin manager to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (84,'default_notify_tester','on','Add bin tester to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (85,'default_notify_creator','on','Add ticket creator to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (86,'default_notify_owner','on','Add ticket owner to notify list by default.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (87,'sql_cache_time',0,'Number of seconds to cache db results, set to 0 to disable sql caching');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (88,'email_log','on','Send email when a log entry is created');

UPDATE ZENTRACK_SETTINGS SET value = '2.3.2' WHERE name = 'version_xx';

INSERT INTO ZENTRACK_USERS (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) VALUES (4,'egate',2,NULL,'Gateway','Email','egate','zentrack@havenshade.com','Email Gateway Account',1,0);