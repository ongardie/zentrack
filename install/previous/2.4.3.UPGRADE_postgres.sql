
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (94,'level_create_proj','2','Access level required to create projects.');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (95,'use_euro_date','off','On if using European format(dd/mm/yyyy) instead of american(mm/dd/yyyy)');

UPDATE ZENTRACK_SETTINGS SET value = '2.4.3' WHERE name = 'version_xx';