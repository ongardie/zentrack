INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (102,'retain_owner_move','on','Keep owner data on tickets after a ticket is moved between bins');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (103,'retain_owner_pending','on','Keep owner data on tickets after a ticket is set to PENDING');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (104,'retain_owner_closed','on','Keep owner data on tickets after a ticket is set to CLOSED');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (105,'character_set','ISO-8859-15','Character set to be used');

-- Modify the version number
UPDATE ZENTRACK_SETTINGS SET value='2.5.0.2' WHERE setting_id=74;