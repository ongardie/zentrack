
UPDATE ZENTRACK_SETTINGS SET description = 'This must match one of the file names in the translations folder' WHERE setting_id = 79;
UPDATE ZENTRACK_SETTINGS SET description = 'Send email to tester/approver when ticket is pending' WHEN setting_id = 27;

UPDATE ZENTRACK_SETTINGS SET value = '2.4.1' WHERE name = 'version_xx';