
UPDATE ZENTRACK_SETTINGS SET description = 'The language displayed by default, must match a filename in includes/translations' WHERE name='language_default';
UPDATE ZENTRACK_SETTINGS SET description = 'Send email to tester/approver when ticket is pending' WHERE name = 'email_pending';
UPDATE ZENTRACK_SETTINGS SET description = 'Comma seperated list.  Only these extensions may be uploaded.  Set to 0 to allow all (WARNING:  this is a security risk!)' WHERE name='attachment_types_allowed';

INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (89,'priority_medium','2','Median priority, pick number around 1/2 total priorities, set to 0 to disable coloring');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (90,'color_priority_low','#FFFFFF','Base color for low priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (91,'color_priority_med','#FFFFCC','Base color for medium priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (92,'color_priority_hi','#FF9999','Base color for high priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (93,'log_email','on','Create a log entry when tickets are emailed.');

UPDATE ZENTRACK_SETTINGS SET value = '2.4.1' WHERE name = 'version_xx';
