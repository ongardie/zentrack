
# 
# Table structure for table 'ZENTRACK_NOTIFY_LIST' 
# 
CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id int(12) NOT NULL auto_increment,
   ticket_id int(12) NOT NULL,
   user_id int(12) default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority int(12) default NULL,
   notes varchar(255) default NULL,
   PRIMARY KEY (notify_id)
);


