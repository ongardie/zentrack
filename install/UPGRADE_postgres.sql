
--
-- ID SEQUENCES
--
CREATE SEQUENCE "notify_id_seq" start 1001 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

--
-- TABLE STRUCTURE FOR ZENTRACK_NOTIFY_LIST
-- 
CREATE TABLE ZENTRACK_NOTIFY_LIST (
   notify_id int8 default nextval('"notify_id_seq"') NOT NULL PRIMARY KEY,
   ticket_id int(12) NOT NULL,
   user_id int(12) default NULL,
   name varchar(100) default NULL,
   email varchar(150) default NULL,
   priority int(12) default NULL,
   notes text default NULL
);


