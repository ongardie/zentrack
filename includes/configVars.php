<?{

  /*
  **  ZENTRACK CONFIGURATION SETTINGS
  **
  **  These are probably fine as they are...
  **  We keep them here so that it is possible to
  **  run two copies of zenTrack from the same
  **  code base using different database entries
  **  
  **  You can have a look and change something if
  **  you need to.
  **  
  */

   global $Demo_Mode;
   global $Debug_Mode;
   global $Db_Host;
   global $Db_Type;
   global $Db_Instance;
   global $Db_Login;
   global $Db_Pass;
   

   $this->demo_mode = $Demo_Mode; 
   $this->debug = $Debug_Mode;  
   
   $this->database_type      = $Db_Type;
   $this->database_instance  = $Db_Instance;
   $this->database_login     = $Db_Login;   
   $this->database_password  = $Db_Pass;    
   $this->database_host      = $Db_Host;    
                                            
   $this->table_access           = 'ZENTRACK_ACCESS';           //access table
   $this->table_attachments      = 'ZENTRACK_ATTACHMENTS';      //attachments index
   $this->table_bins             = 'ZENTRACK_BINS';             //ticket bins
   $this->table_logs             = 'ZENTRACK_LOGS';             //log table
   $this->table_logs_archived    = 'ZENTRACK_LOGS_ARCHIVED';    //archived log table
   $this->table_preferences      = 'ZENTRACK_PREFERENCES';      //preferences for users
   $this->table_priorities       = 'ZENTRACK_PRIORITIES';       //priorities of tickets
   $this->table_reports          = 'ZENTRACK_REPORTS';          //reports table name
   $this->table_reports_temp     = 'ZENTRACK_REPORTS_TEMP';     //temporary report storage
   $this->table_reports_index    = 'ZENTRACK_REPORTS_INDEX';    //report ownership
   $this->table_settings         = 'ZENTRACK_SETTINGS';         //settings table
   $this->table_systems          = 'ZENTRACK_SYSTEMS';          //ticket systems   
   $this->table_tasks            = 'ZENTRACK_TASKS';            //task names
   $this->table_tickets          = 'ZENTRACK_TICKETS';          //data table
   $this->table_tickets_archived = 'ZENTRACK_TICKETS_ARCHIVED'; //archived ticket table
   $this->table_types            = 'ZENTRACK_TYPES';            //ticket types
   $this->table_users            = 'ZENTRACK_USERS';            //users table   

   // not yet implemented... but functional
   // these will be fully added in 2.1

   //pre-constructed strings
   $this->table_translation_strings = 'ZENTRACK_TRANSLATION_STRINGS'; 
   //language dictionary
   $this->table_translation_words = 'ZENTRACK_TRANSLATION_WORDS';  

   /*
   **  REPORTS
   */
   $this->cleanTempReports = 7;     // number of days to keep temporary reports
   $this->reportImageWidth = 640;   // width or report image
   $this->reportImageHeight = 540;  // height of report image

   /*
   **  MISC
   */   

   $this->defaultHighlight = array("<span class='highlight'>","</span>");

  /*
   *  DIRECTORY SETTINGS 
  */

   // the root includes folder
   global $libDir;
   $this->libDir = $libDir;   
  
   // the folder under includes holding utility files
   $this->listDir        = $this->libDir."/lists";
   
   // the folder under includes holding templates
   $this->templateDir    = $this->libDir."/templates";
   
   // the attachments folder under includes
   $this->attachmentsDir = $this->libDir."/attachments"; 


  /*
   *  MAIL SETTINGS
  */

  // hostname of the machine zenTrack is installed on
  // may be left blank if you can trust your web server to set up
  // $HOSTNAME correctly (Apache does)
  // $this->hostname = "machine.domain.com";

  // mail server (to whom we can deliver mail via SMTP)
  $this->smtpserver = "localhost";

  // default return path for bounced mails (should be replaced by the
  // email address of the logged-in user)
  $this->fromuser   = "me@domain.com";

}?>
