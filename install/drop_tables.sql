
--
-- FOR ORACLE
--

--DROP SEQUENCE ACCESS_ID_SEQ;              
--DROP SEQUENCE ATTACHMENTS_ID_SEQ;         
--DROP SEQUENCE BINS_ID_SEQ;                
--DROP SEQUENCE LOGS_ID_SEQ;                
--DROP SEQUENCE PREFERENCES_ID_SEQ;         
--DROP SEQUENCE PRIORITIES_ID_SEQ;          
--DROP SEQUENCE SETTINGS_ID_SEQ;            
--DROP SEQUENCE SYSTEMS_ID_SEQ;             
--DROP SEQUENCE TASKS_ID_SEQ;               
--DROP SEQUENCE TICKETS_ID_SEQ;             
--DROP SEQUENCE TRANSLATION_STRINGS_ID_SEQ; 
--DROP SEQUENCE TRANSLATION_WORDS_ID_SEQ;   
--DROP SEQUENCE TYPES_ID_SEQ;               
--DROP SEQUENCE USERS_ID_SEQ;               
--DROP SEQUENCE REPORTS_ID_SEQ;             
--DROP SEQUENCE REPORTS_TEMP_ID_SEQ;
--DROP SEQUENCE BEHAVIOR_ID_SEQ;

--
-- FOR POSTGRES
--

--DROP SEQUENCE "access_access_id_seq";
--DROP SEQUENCE "attachments_attachment_id_seq";
--DROP SEQUENCE "bins_bid_seq";
--DROP SEQUENCE "logs_lid_seq";
--DROP SEQUENCE "priorities_pid_seq";
--DROP SEQUENCE "settings_setting_id_seq";
--DROP SEQUENCE "systems_sid_seq";
--DROP SEQUENCE "tasks_task_id_seq";
--DROP SEQUENCE "tickets_id_seq";
--DROP SEQUENCE "translation_strings_trans_id_seq";
--DROP SEQUENCE "translation_words_word_id_seq";
--DROP SEQUENCE "types_type_id_seq";
--DROP SEQUENCE "users_user_id_seq";
--DROP SEQUENCE "reports_id_seq";
--DROP SEQUENCE "reports_temp_id_seq";
--DROP SEQUENCE "notify_id_seq";
--DROP SEQUENCE "behavior_id_seq";

--
-- FOR ALL
--
DROP TABLE ZENTRACK_ACCESS;
DROP TABLE ZENTRACK_ATTACHMENTS;
DROP TABLE ZENTRACK_BEHAVIOR;
DROP TABLE ZENTRACK_BEHAVIOR_DETAIL;
DROP TABLE ZENTRACK_BINS;
DROP TABLE ZENTRACK_GROUP;
DROP TABLE ZENTRACK_GROUP_DETAIL;
DROP TABLE ZENTRACK_LOGS;
DROP TABLE ZENTRACK_NOTIFY_LIST;
DROP TABLE ZENTRACK_PREFERENCES;
DROP TABLE ZENTRACK_PRIORITIES;
DROP TABLE ZENTRACK_REPORTS;
DROP TABLE ZENTRACK_REPORTS_INDEX;
DROP TABLE ZENTRACK_REPORTS_TEMP;
DROP TABLE ZENTRACK_SETTINGS;
DROP TABLE ZENTRACK_SYSTEMS;
DROP TABLE ZENTRACK_TASKS;
DROP TABLE ZENTRACK_TICKETS;
DROP TABLE ZENTRACK_TYPES;
DROP TABLE ZENTRACK_USERS;
DROP TABLE ZENTRACK_VARFIELD;
DROP TABLE ZENTRACK_VARFIELD_IDX;
