
DROP TABLE ZENTRACK_PREFERENCES;

CREATE TABLE ZENTRACK_PREFERENCES (
  user_id  int(12) NOT NULL default '0',
  prefname varchar(25),
  prefval  varchar(50),
  index (user_id)
) TYPE=MyISAM;
