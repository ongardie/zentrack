
DROP TABLE ZENTRACK_PREFERENCES;

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id int8 default '0' NOT NULL,
  prefname varchar(25) default NULL,
  prefval  varchar(50) default NULL
);

