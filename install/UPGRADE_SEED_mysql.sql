
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (89,'priority_medium','2','Median priority, pick number around 1/2 total priorities, set to 0 to disable coloring');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (90,'color_priority_low','#FFFFFF','Base color for low priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (91,'color_priority_med','#FFFFCC','Base color for medium priority items');
INSERT INTO ZENTRACK_SETTINGS (setting_id, name, value, description) VALUES (92,'color_priority_hi','#FF9999','Base color for high priority items');

UPDATE ZENTRACK_SETTINGS SET value = '2.4.1' WHERE name = 'version_xx';
