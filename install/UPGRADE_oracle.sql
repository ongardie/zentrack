--
-- Table structure for table 'ZENTRACK_SETTINGS'
--

CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id number(12)  CONSTRAINT notify_id_not_null NOT NULL,
   ticket_id number(12) NOT NULL,
   user_id number(12) default NULL,
   name varchar2(100) default NULL,
   email varchar2(150) default NULL,
   priority number(12) default NULL,
   notes varchar2(2000) default NULL,
   CONSTRAINT notify_pk PRIMARY KEY (notify_id)
);



