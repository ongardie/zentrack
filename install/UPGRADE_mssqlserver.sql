
DROP TABLE ZENTRACK_PREFERENCES;

CREATE TABLE ZENTRACK_PREFERENCES (
 [user_id] int NOT NULL default '0',
 prefname varchar(25) default NULL,
 prefval varchar(50) default NULL
);

create nonclustered index userprefs_user on ZENTRACK_PREFERENCES(user_id);