<?{

  /*
  **  YOU MUST CONFIGURE $this->database_type in this file!!
  */

  /*
   *  GENERAL SETTINGS 
  */

   $this->language = "english";  // language to show zenTrack in 
                                 // (rename lists/english and translate to add a new langauage)
                                 // please pass your translations on to us, so we can add 
                                 // them to the project for others

   /*
   **  DATE SETTINGS
   */

   // see the php manual function strftime 
   // (http://www.php.net/manual/en/function.strftime.php)
   // for all of the options available to format 
   $this->date_fmt_long = '%A $d, %b %Y';
   $this->date_fmt_short = '%x';
   $this->time_fmt       = '%R';
   $this->date_and_time = $this->date_fmt_short." ".$this->time_fmt;

   // the elapsed unit tells what measure will be used
   // for the 'time elapsed' fields
   // this must be one of the following:
   // 'seconds', 'minutes', 'hours', 'days', 'weeks', 'months', 'years'
   $this->elapsed_unit = "hours";
   
   // WINDOWS USERS
   //
   // %T and %D will not work on Windows
   // search http://msdn.microsoft.com/ for strftime().
   // 
   // Control Panel->International Settings
   // You can set your locale and customize it
   // And locale-related PHP functions work perfectly

   // IF NEEDED, uncomment the following entry
   // and set it to your location.. use locale -a 
   // to see a list of possibilities
   // see the php manual for more info on setlocale()
   // setlocale(LC_TIME, "C");
   // setlocale(LC_TIME, "POSIX");
   // setlocale(LC_TIME, "en_US");  // U.S.
   // setlocale(LC_TIME, "fr_FR");  // french
   // setlocale(LC_TIME, "de_DE");  // german
   // setlocale(LC_TIME, "es_ES");  // spanish

   /*
   **  DEBUG / HELP / DEMO
   */

   $this->demo_mode = "off";  // on/off  on prevents users from changing passwords or altering
	                     // system configurations/user accounts (annoying demo stuff)   
   // not yet fully implemented (upcoming for 2.1)
   $this->debug = 3;         // 0-none, 1-footer debug messages, 2-common debug, 3-all debug
   

  /*
   *  DATABASE SETTINGS
  */

   // ORACLE USERS! the order of items may be changed
   // it may be that the entry will be:
   //      database_host: "serverip:port#"
   //      database_login: "scott"
   //      database_pass:  "tiger"
   //      database_intance: "servicename"
   // or:
   //      database_host: ""
   //      database_login: "scott"
   //      database_pass:  "tiger"
   //      database_intance: "TNSName"
   // hints for these entries:
   // - for Oracle 8 and later, use "oci8po" as database_type
   // - if using an Oracle Names Server, leave database_instance blank and put
   //   the database alias into database_host
   // - the same applies if you want to use a whole TNS connection string
   // - to connect to a local instance, you may leave the database_host blank
   // also... you may need to uncomment the following for oracle to work properly:
//   putenv("ORACLE_SID=ORACLE"); // the database instance
//   putenv("ORACLE_HOME=/opt/oracle/oracle/8.0.3"); // the oracle installation directory
//   putenv("TNS_ADMIN=/opt/oracle/product/8.1.5/network/admin"); // the directory of the tnsnames.ora file

   $this->database_type      = 'mysql';
	// the database types that can be used here are:
	//    mysql
	//    oracle
	//    oci8po (oracle 8i)
	//    mssql  (Microsoft SQL Server 7/2000)
	//  for more, see http://php.weblogs.com/ADOdb_manual#drivers
	//  (you may need to create your own includes/misc/*.sql files
	//  to set up your database structure when using a db other than
	//  Oracle 8i+ or MySQL. When you succeeded, we would be glad if
	//  you'ld share these files with us :-)

   $this->database_instance  = 'devtrack';	 //database name
   $this->database_login     = 'test';           //database login
   $this->database_password  = 'test';           //database passphrase
   $this->database_host      = 'localhost';      //host name, if on same machine, 
                                                 //this is localhost

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
   
   $this->table_translation_strings = 'ZENTRACK_TRANSLATION_STRINGS'; //pre-constructed strings
   $this->table_translation_words = 'ZENTRACK_TRANSLATION_WORDS';  //language dictionary

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

   // uncomment and set these to a typeID number to manually
   // specify which type ID should be used for projects and notes
   // two special instances in the database.  If nothing is specified
   // zentrack will find a bin name which contains the word "project"
   // and one which contains the word "note" and use those
   // $this->noteTypeID    = 0;
   // $this->projectTypeID = 0;
   
  /*
   *  DIRECTORY SETTINGS 
  */
  
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
