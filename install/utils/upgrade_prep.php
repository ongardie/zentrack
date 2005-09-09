<?
  /**
   * Prepares a build for upgrade procedures by:
   *  - copying current upgrade files into the install/previous directory
   *  - creating new upgrade files with an updated version number
   *  - adjusting version number in seed files
   *
   * Properties are added as follows:
   *  - CREATE TABLE { .. use mysql specification .. }
   *  - PRIMARY KEY (see below)
   *  - CREATE SEQUENCE sequence_name start_number (see below)
   *  - CREATE INDEX name ON table(fields);
   *
   * Escaping quotes:
   *  - use \' to escape, this will be converted according to the db
   *
   * Comments:
   *  -- my comment here (do not use /* my comment ...)
   *
   * Primary Keys:
   *  - ???
   *
   * Create Sequence:
   *  - place auto_increment into the column and add a CREATE SEQUENCE.
   *  - this script will decide which one to use in the final version based on database
   *
   * Other Limitations:
   *  - do not create indexes in tables, do them all as CREATE INDEX statements
   *  - do not attempt alter table or modify column statements
   */
   
   /**
    * Check for proper arguments and return help message if not provided
    */
    if( !$argv || count($argv) != 3 ) {
      print "\nUsage:  php upgrade.php old_version new_version\n";
      exit;
    }
    $old_version = $argv[1];
    $new_version = $argv[2];
   
   /**
    * Reads a seed file and adjusts the version number
    */
   function adjSeedfile( $dir, $file, $old_version, $new_version ) {
     print "Adjusting verion number for $file: $old_version -> $new_version\n";
     $contents = file_get_contents("$dir/$file");
     $contents = preg_replace("/'version_xx', *'$old_version'/", "'version_xx','$new_version'", $contents);
     $fh = fopen("$dir/$file",'w');
     fputs($fh,$contents);
     fclose($fh);
   }
   
   /**
    * Handle postgres numeric fields during regexp replaces
    */
   function doPostgresInt( $val ) {
     if( $val <= 2 ) { return 'int2'; }
     else { return 'int8'; }
   }
   
   /**
    * Creates a new upgrade file
    */
    $sql_replacements = array(
      'mysql' => array(array(),array()), 
      'mssqlserver' => array(array(), array()), 
      'postgres' => array(array(), array()), 
      'oracle' => array(array(), array())
    );
    
    $sql_replacements['mysql'][0][] = '/CREATE SEQUENCE.*/';
    $sql_replacements['mysql'][1][] = '';
    
    $sql_replacements['mssqlserver'][0][] = '/int[(]([0-9,]+)[)]/i';
    $sql_replacements['mssqlserver'][1][] = 'NUMERIC(\\1)';
    $sql_replacements['mssqlserver'][0][] = '/"([^"]+)"/i';
    $sql_replacements['mssqlserver'][1][] = '[\\1]';
    $sql_replacements['mssqlserver'][0][] = '/ *INDEX.*/i';
    $sql_replacements['mssqlserver'][1][] = '';
    $sql_replacements['mssqlserver'][0][] = '/CREATE SEQUENCE.*/';
    $sql_replacements['mssqlserver'][1][] = '';
    $sql_replacements['mssqlserver'][0][] = "/\\\\'/";
    $sql_replacements['mssqlserver'][1][] = "''";
    $sql_replacements['mssqlserver'][0][] = ' auto_increment';
    $sql_replacements['mssqlserver'][1][] = '';
    
    $sql_replacements['oracle'][0][] = '/int[(]([0-9,]+)[)]/i';
    $sql_replacements['oracle'][1][] = 'NUMBER(\\1)';
    $sql_replacements['oracle'][0][] = '/VARCHAR/i';
    $sql_replacements['oracle'][1][] = 'VARCHAR2';
    $sql_replacements['oracle'][0][] = '/\bTEXT\b/i';
    $sql_replacements['oracle'][1][] = 'VARCHAR2(4000)';
    $sql_replacements['oracle'][0][] = '/PRIMARY KEY[(]([^)]+)[)]/i';
    $sql_replacements['oracle'][1][] = 'CONSTRAINT \\1_pk1 PRIMARY KEY (\\1)';
    $sql_replacements['oracle'][0][] = '/ *INDEX.*/i';
    $sql_replacements['oracle'][1][] = '';
    $sql_replacements['oracle'][0][] = '/CREATE SEQUENCE ([a-zA-Z0-9_]+) ([0-9]+)/';
    $sql_replacements['oracle'][1][] = 'CREATE SEQUENCE \\1 start with \\2 nocache';
    $sql_replacements['oracle'][0][] = "/\\\\'/";
    $sql_replacements['oracle'][1][] = "''";
    $sql_replacements['oracle'][0][] = ' auto_increment';
    $sql_replacements['oracle'][1][] = '';

    $sql_replacements['postgres'][0][] = '/ *INDEX.*/i';
    $sql_replacements['postgres'][1][] = '';
    $sql_replacements['postgres'][0][] = '/int[(]([0-9,]+)[)]/ie';
    $sql_replacements['postgres'][1][] = "doPostgresInt('\\1')";
    $sql_replacements['postgres'][0][] = ' auto_increment';
    $sql_replacements['postgres'][1][] = '';
    $sql_replacements['postgres'][0][] = '/CREATE SEQUENCE ([a-zA-Z0-9_]+) ([0-9]+)/';
    $sql_replacements['postgres'][1][] = 'CREATE SEQUENCE \\1 start \\2 increment 1 maxvalue 2147483647 minvalue 1 cache 1';

  function newUpgradeFile( $dir, $file, $new_version, $base_text ) {
     global $sql_replacements;
     print "Creating new upgrade file: $file\n";
     
     // try to handle sql specifics for various databases
     $type = substr($file, 7);
     if( $base_text ) {
       $match = $sql_matches[$type][0];
       $rep = $sql_matches[$type][1];
       $base_text = preg_replace($matches, $rep, $base_text); 
     }
     
     // create the file
     $fh = fopen("$dir/$file", 'w');
     fputs($fh, "$base_text\n-- Modify the version number\nUPDATE ZENTRACK_SETTINGS SET value='$new_version' WHERE setting_id=74;\n");
     fclose($fh);
   }
   
   /**
    * Moves existing upgrade file to previous/ folder
    */
   function moveUpgradeFile( $dir, $file, $old_version ) {
     $name = "previous/$old_version.$file";
     $res = rename("$dir/$file", "$dir/$name");
     print "Copying $file to $name: ".($res? 'success' : 'FAILED!!!!')."\n";
   }

  // insure we are using the cli sapi (security)
  if( $verbose ) { print "Checking for cli binary\n"; }
  if( !preg_match("/cli/", php_sapi_name()) ) {
    die("This script is only meant to be used as a command line utility (cli), you are trying to use a ".php_sapi_name()." binary.");
  }
   
   // determine where the install dir is
   $dir = dirname(dirname(__FILE__));   
   if( !preg_match('@install$@',$dir) ) {
     print "$dir doesn't appear to be an install folder... unable to continue\n";
     exit;
   }
   
   // see if there is any upgrade sql to drop into the newly created files
   if( file_exists("$dir/upgrade_base.sql") ) {
     $base_text = file_get_contents("$dir/upgrade_base.sql");
   }
   else { $base_text = false; }
   
   $upgrade_files = array();
   $seed_files = array();
   $previous_files = array();
   
   $dh = opendir($dir);
   while( $file = readdir($dh) ) {
     if( strpos($file, 'UPGRADE_') === 0 ) {
       $upgrade_files[] = $file;
       $previous_files[] = "$old_version.$file";
       moveUpgradeFile($dir, $file, $old_version);
       newUpgradeFile($dir, $file, $new_version, $base_text);
     }
     else if( strpos($file, 'seed_') === 0 ) {
       $seed_files[] = $file;
       adjSeedFile($dir, $file, $old_version, $new_version);
     }
     else {
       print " - skipped $file\n";
     }
   }
   
   print "Updating UPGRADE.readme version\n";
   $text = file_get_contents("$dir/UPGRADE.readme");
   $text = preg_replace("UPGRADE INSTRUCTIONS FOR VERSION $old_version", "UPGRADE INSTRUCTIONS FOR VERSION $new_version");
   $fh = fopen("$dir/UPGRADE.readme",'w');
   fputs($fh,$text);
   fclose($fh);
   
   print "\n---------------------------------\n";
   print "    ADD TO CHANGELOG\n";
   print "\n---------------------------------\n";
   print date('Y-m-d').", kato\n";
   print "  Prepared install/upgrade docs and scripts\n";
   print "    - zentrack_2/install/UPGRADE.readme \n";
   foreach($upgrade_files as $f) {
     print "    - zentrack_2/install/$f \n";
   }
   foreach($seed_files as $f) {
     print "    - zentrack_2/install/$f \n";
   }
   foreach($previous_files as $f) {
     print "    - zentrack_2/install/previous/$f 1.1\n";
   }
   print "\n---------------------------------\n";
?>