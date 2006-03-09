INSERT INTO ZENTRACK_SETTINGS ( setting_id , name , value, description ) VALUES (121, 'max_textbox_height', '200', 'Max height of textbox in ticket view');

-- new color settings
ALTER TABLE ZENTRACK_PRIORITIES ADD color varchar(25) default '';
UPDATE ZENTRACK_PRIORITIES SET color = '#FFFFFF' where name = 'None';
UPDATE ZENTRACK_PRIORITIES SET color = '#FFFFCC' where name = 'Low';
UPDATE ZENTRACK_PRIORITIES SET color = '#FFDDBB' where name = 'Medium';
UPDATE ZENTRACK_PRIORITIES SET color = '#FFBBAA' where name = 'High';
UPDATE ZENTRACK_PRIORITIES SET color = '#FF9999' where name = 'Critical';