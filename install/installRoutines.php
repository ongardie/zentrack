<?php
   
   /**
     **   This set or functions is to support user simplified installation.
     **   It is a work in progress, and should not be *used* in a production 
     **   environment yet.  You will notice that I am at bit chatty  with the
     **   code.   I prepher descriptive code,  I find that 
     **   $variable = $config_section["variable"] is much easier to follow
     **   and maintain over $v = $db[3].   You may change this as you
     **   will.    Please change this disclamer when you do.  
     **   You will also find that I did not use the database abstration 
     **   library.  This is an install script, and as such it should have 
     **   limited dependencies.
     ** 
     **   -- 06/04/03 wlt
     **/

   // copy a single file or directory.
   function my_copy($oldname, $newname) {
      if (is_file($oldname)) {
         $perms = fileperms($oldname);
         return copy($oldname, $newname) && chmod($newname, $perms);
      }
      else if (is_dir($oldname)) {
         my_dir_copy($oldname, $newname) ;
      }
      else {
         die("Cannot copy file: $oldname (it's neither a file nor a directory)");
      }
   }
   
   // Copy a directory.
   function my_dir_copy($oldname, $newname) {
      if (!is_dir($newname)) {
         mkdir($newname);
         chmod("$newname", 0777);
      }
     $dir = opendir($oldname);
     while($file = readdir($dir)) {
        if ($file == "." || $file == "..") {
           continue;
        }
        my_copy("$oldname/$file", "$newname/$file");
     }
     closedir($dir);
   }

   // Collect the information from the config.ini file
   function parseConfigFile() {
       // configuration sanity check still needed
       $configParams = parse_ini_file("config.ini",true);
       return $configParams;
   }
    
   // Install the database files and populate the database if needed
   function databaseSetup($database_section,$isUpgrade) {
       $db_type = $database_section["db_type"];

       switch ($db_type) {
           case "mysql":
               mysqlSetup($database_section,$isUpgrade);
               break;
           case "oci8po":
               oracleSetup($database_section,$isUpgrade);
               break;
           case "mssql":
               mssqlSetup($database_section,$isUpgrade);
               break;
           case "postgres":
               postgresSetup($database_section,$isUpgrade);
               break;
        }
   }
   
   // MySql setup 
   function mysqlSetup($database_section,$isUpgrade) {
       // Setup the variables from the config file.
       $db_host = $database_section["db_host"];
       $db_user = $database_section["db_user"];
       $db_password = $database_section["db_password"];
       $db_name = $database_section["db_name"];
  
       // Get the ins
       $query_text = getDbInstallQuery("mysql",$isUpgrade);
       
       $link = mysql_connect($db_host, $db_user, $db_password) or die("Could not connect: " . mysql_error());
       $result = mysql_query($query_text) or die("Invalid query: " . mysql_error());
       mysql_close($link);
       echo "=== > $query_text\n\n";
   }
   
   // Oracle setup
   function oracleSetup($database_section,$isUpgrade) {
       echo "... do oracle \n\n";
   }
   
   // MSSQL setup 
   function mssqlSetup($database_section,$isUpgrade) {
       echo "... do mssql \n\n";
   }
   
   // Postgres setup
   function postgresSetup($database_section,$isUpgrade) {
       echo "... do postgres \n\n";
   }
   
   // Get the appropriate database install/upgrade script
   function getDbInstallQuery($whichDB = '', $isUpgrade) {
       global $zentrack_path;
       
       $queryFile = "";

       // Pick the correct file
       switch ($whichDB) {
           case "mysql":
               if (!$isUpgrade) 
                   $queryFile = "$zentrack_path/install/build_mysql.sql";
               else 
                   $queryFile = "$zentrack_path/install/UPGRADE_mysql.sql";
               break;
           case "oci8po":
               break;
           case "mssql":
               break;
           case "postgres":
               break;
       }
       
       // Open and read in the file
      $fd = fopen("$queryFile", "rb") or die("Could not open the database install script!/n");
      $content = fread($fd, filesize($queryFile));
      fclose($fd);
      return $content;
   }
   
   // Setup the permissions
   function setupPerms($install_section,$isUpgrade) {
   
   }
   
   // Do the install
   function install() {
       global $zentrack_path;
       
       $configParams = parseConfigFile();
       extract($configParams);
 
       // Get the unix vs. DOS specific stuff
       $ds = DIRECTORY_SEPARATOR;
         
       // extract the nstallation Variables
       $zentrack_path = $installation_section["zentrack_path"];
       $symbolic = $installation_section["symbolic"];
       $www_path = $installation_section["symbolic"];

       // here is where the www directory currently lives
      $zen_link = $zentrack_path  . "/www";
      
      // Now place the web componet of zentrack where
      // and how they want it.  No symbolic link if not *nix
      if ($symbolic == true && $ds == "/")  {
          symlink($zen_link, $www_path) or die("\n\nError creating the symbolic link, please please correct and restart. \n\n.");
      }   
      else { 
          my_dir_copy($zen_link,$www_path) or die("\n\nError creating the www docs directory, please correct and restart. \n\n" );
      }
     
      // create the needed directories
      mkdir("$zentrack_path/includes/attachments",0777);
      mkdir("$zentrack_path/includes/logs",0777);
      mkdir("$zentrack_path/includes/cache",0777);
      
      // Do the database setup
      databaseSetup($database_section,false);
   }
    
   // Do an upgrade
   function upgrade() {
   } 
   
   function testMe() {
       $configParams = parseConfigFile();
       extract($configParams);
       databaseSetup($database_section,false);
   }
   
   // DEFINED VARIABLEs
   $zentrack_path = "";