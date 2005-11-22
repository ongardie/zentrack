
-- REMOVE PHP FILES FROM UPLOAD TYPES ALLOWED
UPDATE ZENTRACK_SETTINGS SET value = 'txt,html,xls,pdf,jpg,gif,png,doc,wpd' WHERE name = 'attachment_types_allowed' AND value = 'txt,html,xls,pdf,jpg,gif,png,doc,wpd,php';
-- Fix for error when creating new project
DELETE FROM ZENTRACK_FIELD_MAP WHERE which_view = 'project_create' and field_name = 'type_id';
-- Fix title field being too long and getting cut off
UPDATE ZENTRACK_FIELD_MAP SET  num_cols = '50' WHERE field_name = 'title';
