<?{

  /*
   *  GENERAL SETTINGS 
  */

   $this->language = "english";  // language to show zenTrack in 
                                 // (rename lists/english and translate to add a new langauage)
                                 // please pass your translations on to us, so we can add 
                                 // them to the project for others

   // see the php manual (http://www.php.net/manual/en/function.date.php) for all available date formatting
   // options [not yet implemented, planned for 2.1]
   $this->date_format_long = "M d, Y H:i";
   $this->date_format_short = "m-d-y";			     
   
  /*
   *  DIRECTORY SETTINGS 
  */
  
   // the root includes folder
   $this->libDir         = "/web/phpzen/sub/devtrack/includes";

   // the folder under includes holding utility files
   $this->listDir        = "/web/phpzen/sub/devtrack/includes/lists";
   
   // the folder under includes holding templates
   $this->templateDir    = "/web/phpzen/sub/devtrack/includes/templates";
   
   // the attachments folder under includes
   $this->attachmentsDir = "/web/phpzen/sub/devtrack/includes/attachments"; 

   
  /*
  **  RETRIEVAL SETTINGS
  */
   
   $this->get_tickets_columns = array(
				"id", 	        "title", 
				"priority",     "otime", 
				"ctime",        "project_id", 
				"est_hours",    "wkd_hours",
				"status"
				);    //specifies columns returned by get_tickets()

  /*
   *  DATABASE SETTINGS
  */

   // for oracle, the order of items may be changed
   // it may be that the entry will be:
   //      database_host: serverip:port#
   //      database_login: scott
   //      database_pass:  tiger
   //      database_intance: servicename
   // or:
   //      database_host: ""
   //      database_login: scott
   //      database_pass:  tiger
   //      database_intance: TNSName (try the TNSname here, then try the whole connection string!)      
   $this->database_type      = 'mysql';          //mysql,oracle,postgres,sqlserver
   $this->database_instance  = 'devtrack';	 //database name
   $this->database_login     = 'test';           //database login
   $this->database_password  = 'test';           //database password
   $this->database_host      = 'localhost';      //host name, if on same machine, 
                                                 //this is localhost

   $this->table_access           = 'ZENTRACK_ACCESS';           //access table
   $this->table_attachments      = 'ZENTRACK_ATTACHMENTS';      //attachments index
   $this->table_bins             = 'ZENTRACK_BINS';             //ticket bins
   $this->table_logs             = 'ZENTRACK_LOGS';             //log table
   $this->table_logs_archived    = 'ZENTRACK_LOGS_ARCHIVED';    //archived log table
   $this->table_preferences      = 'ZENTRACK_PREFERENCES';      //preferences for users
   $this->table_priorities       = 'ZENTRACK_PRIORITIES';       //priorities of tickets
   $this->table_settings         = 'ZENTRACK_SETTINGS';         //settings table
   $this->table_systems          = 'ZENTRACK_SYSTEMS';          //ticket systems   
   $this->table_tasks            = 'ZENTRACK_TASKS';            //task names
   $this->table_tickets          = 'ZENTRACK_TICKETS';          //data table
   $this->table_tickets_archived = 'ZENTRACK_TICKETS_ARCHIVED'; //archived ticket table
   $this->table_types            = 'ZENTRACK_TYPES';            //ticket types
   $this->table_users            = 'ZENTRACK_USERS';            //users table   


   // not yet implemented... but functional
   // these will be fully added in 2.1
   
   $this->table_translation_strings = 'ZENTRACK_TRANSLATION_STRINGS'; //pre-constructed strings
   $this->table_translation_words = 'ZENTRACK_TRANSLATION_WORDS';  //language dictionary
   
   
   /*
   **  DEBUG HELP
   */
   
   // not yet implemented (upcoming for 2.1)
   $this->debug = "on";  // on/off (shows debug information)
   $this->sql_debug = "off"; // on/off (shows all queries)
   
}?>
