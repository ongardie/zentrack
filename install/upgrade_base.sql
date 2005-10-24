
-- REMOVE PHP FILES FROM UPLOAD TYPES ALLOWED
UPDATE ZENTRACK_SETTINGS SET value = 'txt,html,xls,pdf,jpg,gif,png,doc,wpd' WHERE name = 'attachment_types_allowed' AND value = 'txt,html,xls,pdf,jpg,gif,png,doc,wpd,php';
