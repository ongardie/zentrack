
UPDATE ZENTRACK_SETTINGS SET description = 'This must match one of the file names in the translations folder' WHERE setting_id = 79;
UPDATE ZENTRACK_SETTINGS SET description = 'Send email to tester/approver when ticket is pending' WHERE setting_id = 27;
UPDATE ZENTRACK_SETTINGS SET description) = 'Comma seperated list.  Only these extensions may be uploaded.  Set to 0 to allow all (WARNING:  this is a security risk!)') WHERE setting_id = 11;

UPDATE ZENTRACK_SETTINGS SET value = '2.4.1' WHERE name = 'version_xx';