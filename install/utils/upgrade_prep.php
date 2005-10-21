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
  *  - enter primary keys on a seperate line (not as part of a column definition)
  *      my_pk_field int(12) NOT NULL,
  *      PRIMARY KEY(my_pk_field)
  *
  * Create Sequence:
  *  - place auto_increment into the column and add a CREATE SEQUENCE.
  *  - this script will decide which one to use in the final version based on database
  *  - always do both!
  *
  * Other Limitations:
  *  - do not create indexes in tables, do them all as CREATE INDEX statements
  *  - do not attempt alter table or modify column statements
  */
  
  
  //////////////////////////////////
  ////////////////////////////////////////////////////////////////////
  // FUNCTIONS
  ////////////////////////////////////////////////////////////////////
  //////////////////////////////////
  
  function dlog( $text, $important = false ) {
    if( $important || $GLOBALS['verbose'] ) {
      print $important? "\n$text\n" : "  - $text\n";
    }
  }
  
  function strip( $text ) {
    if( !preg_match('@^["\'].*[\'"]$@', $text) ) {
      // it must begin and end with quote
      return $text;
    }
    return preg_replace('@^[\'"]@', '', preg_replace('@[\'"]$@', '', $text));
  }
  
  function backup( $file ) {
    $dir = dirname($file);
    $f = basename($file);
    $bdir = $GLOBALS['bdir'];
    $newfile = "$bdir/$f.".date('Y-m-d-H-i');
    $sep = ''; $c = '';
    while( file_exists($newfile.$sep.$c) ) {
      $c++;
      $sep = '.';
    }
    $newfile = $newfile.$sep.$c;
    $t = "creating backup file: $newfile...";
    $res = copy($file, $newfile);
    dlog( $res? "{$t}success" : "{$t}failed" );
    return $res;
  }
  
  /**
  * Reads a seed file and adjusts the version number
  */
  function adjSeedfile( $dir, $file, $old, $new ) {
    dlog("Adjusting version $old to $new in $file",true);
    $c = file_get_contents("$dir/$file");
    $contents = preg_replace("/'version_xx', *'$old'/", "'version_xx','$new'", $c);
    if( $c != $contents ) {
      if( !backup("$dir/$file") ) {
        dlog("skipped (could not back up)");
        return;
      }
      $fh = fopen("$dir/$file",'w');
      fputs($fh,$contents);
      fclose($fh);
    }
    else {
      dlog("version already set to $new");
    }
  }
  
  /**
  * Handle postgres numeric fields during regexp replaces
  */
  function doPostgresInt( $val ) {
    if( $val <= 2 ) { return 'int2'; }
    else { return 'int8'; }
  }
  
  function newUpgradeFile( $dir, $file, $new, $base_text ) {
    global $sql_replacements;
    dlog("Creating new upgrade file: $dir/$file",true);
    
    // try to handle sql specifics for various databases
    $s = strpos($file,'_')+1;
    $e = strpos($file,'.');
    $type = substr($file, $s, ($e-$s));
    if( $base_text ) {
      dlog("translating base text");
      $matches = $sql_replacements[$type][0];
      $rep = $sql_replacements[$type][1];
      $base_text = preg_replace($matches, $rep, $base_text); 
    }
    else { dlog("no base text"); }
    
    // create the file
    dlog("writing file $dir/$file");
    $fh = fopen("$dir/$file", 'w');
    fputs($fh, "$base_text\n-- Modify the version number\nUPDATE ZENTRACK_SETTINGS SET value='$new' WHERE setting_id=74;\n");
    fclose($fh);
  }
  
  /**
  * Moves existing upgrade file to previous/ folder
  */
  function moveUpgradeFile( $dir, $file, $old ) {
    $name = "previous/$old.$file";
    dlog("Moving old upgrade file: $file to $name", true);
    if( file_exists("$dir/$file") ) {
      if( file_exists("$dir/$name") ) {
        backup("$dir/$name");
        unlink("$dir/$name");
      }
      $res = rename("$dir/$file", "$dir/$name");
      if( !$res ) {
        dlog("!!ERROR!! Failed to move $file to $old", true);
      }
    }
    else {
      dlog("file does not exist, skipping");
    }
  }
  
  
  //////////////////////////////////
  ////////////////////////////////////////////////////////////////////
  // SQL TRANSLATIONS
  ////////////////////////////////////////////////////////////////////
  //////////////////////////////////
  
  
  /**
  * Creates a new upgrade file
  */
  $sql_replacements = array(
  'mysql' => array(array(),array()), 
  'mssqlserver' => array(array(), array()), 
  'postgres' => array(array(), array()), 
  'oracle' => array(array(), array())
  );
  
  $sql_replacements['mysql'][0][] = '/CREATE SEQUENCE[^;]+;/';
  $sql_replacements['mysql'][1][] = '';
  
  $sql_replacements['mssqlserver'][0][] = '/int *[(] *([0-9,]+) *[)]/i';
  $sql_replacements['mssqlserver'][1][] = 'NUMERIC(\\1)';
  $sql_replacements['mssqlserver'][0][] = '/^ *INDEX.*/i';
  $sql_replacements['mssqlserver'][1][] = '';
  $sql_replacements['mssqlserver'][0][] = '/CREATE SEQUENCE[^;]+;/';
  $sql_replacements['mssqlserver'][1][] = '';
  $sql_replacements['mssqlserver'][0][] = "/\\\\'/";
  $sql_replacements['mssqlserver'][1][] = "''";
  $sql_replacements['mssqlserver'][0][] = '/ *auto_increment/';
  $sql_replacements['mssqlserver'][1][] = '';
  $sql_replacements['mssqlserver'][0][] = "/`([^'`]+)`/";
  $sql_replacements['mssqlserver'][1][] = '[\\1]';
  
  $sql_replacements['oracle'][0][] = '/int *[(] *([0-9,]+) *[)]/i';
  $sql_replacements['oracle'][1][] = 'NUMBER(\\1)';
  $sql_replacements['oracle'][0][] = '/VARCHAR/i';
  $sql_replacements['oracle'][1][] = 'VARCHAR2';
  $sql_replacements['oracle'][0][] = '/\bTEXT\b/i';
  $sql_replacements['oracle'][1][] = 'VARCHAR2(4000)';
  $sql_replacements['oracle'][0][] = '/PRIMARY KEY *[(] *([^)]+) *[)]/i';
  $sql_replacements['oracle'][1][] = 'CONSTRAINT \\1_pk1 PRIMARY KEY (\\1)';
  $sql_replacements['oracle'][0][] = '/^ *INDEX.*/i';
  $sql_replacements['oracle'][1][] = '';
  $sql_replacements['oracle'][0][] = '/CREATE SEQUENCE *( *[a-zA-Z0-9_]+ *) +( *[0-9]+ *)/';
  $sql_replacements['oracle'][1][] = 'CREATE SEQUENCE \\1 start with \\2 nocache';
  $sql_replacements['oracle'][0][] = "/\\\\'/";
  $sql_replacements['oracle'][1][] = "''";
  $sql_replacements['oracle'][0][] = '/ *auto_increment/';
  $sql_replacements['oracle'][1][] = '';
  $sql_replacements['mssqlserver'][0][] = "/`([^'`]+)`/";
  $sql_replacements['mssqlserver'][1][] = '"\\1"';
  
  $sql_replacements['postgres'][0][] = '/^ *INDEX.*/i';
  $sql_replacements['postgres'][1][] = '';
  $sql_replacements['postgres'][0][] = '/int *[(] *([0-9,]+) *[)]/ie';
  $sql_replacements['postgres'][1][] = "doPostgresInt('\\1')";
  $sql_replacements['postgres'][0][] = '/ *auto_increment/';
  $sql_replacements['postgres'][1][] = '';
  $sql_replacements['postgres'][0][] = '/CREATE SEQUENCE *( *[a-zA-Z0-9_]+ *) +( *[0-9]+ *)/';
  $sql_replacements['postgres'][1][] = 'CREATE SEQUENCE \\1 start \\2 increment 1 maxvalue 2147483647 minvalue 1 cache 1';
  $sql_replacements['postgres'][0][] = "/`([^'`]+)`/";
  $sql_replacements['postgres'][1][] = '"\\1"';
  
  
  
  //////////////////////////////////
  ////////////////////////////////////////////////////////////////////
  // CONFIGURATION / VALIDATION
  ////////////////////////////////////////////////////////////////////
  //////////////////////////////////
  
  
  
  /**
  * Check for proper arguments and return help message if not provided
  */
  if( !$argv || count($argv) < 3 ) {
    print "\nUsage:  php upgrade.php old_version new_version [..options..]\n";
    print "\t-v                   verbose output\n";
    print "\t-d=/some/directory   specify install directory\n";
    print "\t-b=/some/directory   specify location for backup files\n";
    exit;
  }
  
  $verbose = false;
  $dir = dirname(dirname(__FILE__));
  $bdir = false;
  
  array_shift($argv);
  $old = strip(array_shift($argv));
  $new = strip(array_shift($argv));
  while( count($argv) ) {
    $val = strip(array_shift($argv));
    if( $val == '-v' ) {
      $verbose = true;
    }
    else if( preg_match('@^-d=["\']?([^\'"-]+)["\']?$@', $val, $matches) ) {
      $dir = trim($matches[1]);
    }
    else if( preg_match('@^-b=["\']?([^\'"-]+)["\']?$@', $val, $matches) ) {
      $bdir = trim($matches[1]);
    }
  }
  if( !$bdir ) { $bdir = $dir; }
  $dir = realpath($dir);
  $bdir = realpath($bdir);
  
  dlog("Starting up...",true);
  dlog("old_version: $old");
  dlog("new_version: $new");
  dlog("dlog: ".($verbose? 'true' : 'false'));
  dlog("install directory: $dir");
  dlog("backup directory: $bdir");
  
  
  dlog("Configuring...",true);
  
  // insure we are using the cli sapi (security)
  dlog("checking for cli binary");
  if( !preg_match("/cli/", php_sapi_name()) ) {
    die("This script is only meant to be used as a command line utility (cli), you are trying to use a ".php_sapi_name()." binary.\n\n");
  }
  
  // determine where the install dir is
  dlog("checking the install directory");
  if( !preg_match('@install$@',$dir) || !is_dir($dir) ) {
    die("$dir doesn't appear to be a valid install folder\n\n");
  }
  
  // see if there is any upgrade sql to drop into the newly created files
  $t = "checking for upgrade_base.sql...";
  if( file_exists("$dir/upgrade_base.sql") ) {
    dlog("{$t}found");
    $base_text = file_get_contents("$dir/upgrade_base.sql");
  }
  else {
    dlog("{$t}not found, no base text");
    $base_text = false; 
  }
  
  
  //////////////////////////////////
  ////////////////////////////////////////////////////////////////////
  // PROCESSING FILES
  ////////////////////////////////////////////////////////////////////
  //////////////////////////////////
  
  
  
  $upgrade_files = array();
  $seed_files = array();
  $previous_files = array();
  
  dlog("Checking $dir for upgrade files", true);
  $dh = opendir($dir);
  while( $file = readdir($dh) ) {
    $t = "checking \"$file\"...";
    if( strpos($file, 'UPGRADE_') === 0 ) {
      dlog($t."upgrade script, replacing");
      $upgrade_files[] = $file;
      $previous_files[] = "$old.$file";
      moveUpgradeFile($dir, $file, $old);
      newUpgradeFile($dir, $file, $new, $base_text);
    }
    else if( strpos($file, 'seed_') === 0 ) {
      dlog($t."seed script, updating");
      $seed_files[] = $file;
      adjSeedFile($dir, $file, $old, $new);
    }
    else {
      dlog($t."skipped");
    }
  }
  
  $build_files = array();
  foreach($sql_replacements as $db=>$vals) {
    dlog("Updating $db build/seed files from upgrade data",true);
    $buildfile = "build_{$db}.sql";
    $seedfile = "seed_{$db}.sql";
    $upgradefile = "UPGRADE_{$db}.sql";
    
    // check the upgrade file status
    if( !file_exists("$dir/$upgradefile") ) {
      dlog("  !!ERROR!! upgrade file missing", true);
      continue;
    }
    
    // parse upgrade file and get data to add
    dlog("collecting upgrade contents");
    $contents = file_get_contents("$dir/$upgradefile");
    dlog("finding inserts");
    preg_match_all("/(INSERT INTO.+) *\n/m", $contents, $inserts, PREG_PATTERN_ORDER);
    dlog("finding sequences");
    preg_match_all("/(CREATE SEQUENCE[^;]+;)/", $contents, $sequences, PREG_PATTERN_ORDER);
    dlog("finding tables");
    preg_match_all("/(CREATE TABLE[^;]+;)/", $contents, $tables, PREG_PATTERN_ORDER);
    dlog("finding indices");
    preg_match_all("/(CREATE INDEX[^;]+;)/", $contents, $indices, PREG_PATTERN_ORDER);
    
    // append values to the buildfile
    if( !file_exists("$dir/$buildfile") ) {
      dlog("  !!ERROR!! build file missing", true);
    }
    else {
      $build_files[] = $buildfile;
      backup( "$dir/$buildfile" );
      dlog("writing buildfile");
      $fp = fopen("$dir/$buildfile", 'a');
      fputs($fp, "\n\n-- ADDED IN VERSION $new\n\n");
      fputs($fp, join("\n", $tables[1])."\n");
      fputs($fp, join("\n", $indices[1])."\n");
      fputs($fp, join("\n", $sequences[1])."\n");
      fclose($fp);
    }
    
    // append values to the seed file
    if( !file_exists("$dir/$seedfile") ) {
      dlog("  !!ERROR!! seed file missing", true);
    }
    else {
      backup( "$dir/$seedfile" );
      dlog("writing seed file");
      $fp = fopen("$dir/$seedfile", 'a');
      fputs($fp, "\n\n-- ADDED IN VERSION $new\n\n");
      fputs($fp, join("\n", $inserts[1])."\n");
      fclose($fp);
    }
  }
  
  dlog("Updating UPGRADE.readme version",true);
  $text = file_get_contents(realpath("$dir/../UPGRADE.readme"));
  $text = preg_replace("/UPGRADE INSTRUCTIONS FOR VERSION $old/", "UPGRADE INSTRUCTIONS FOR VERSION $new", $text);
  $fh = fopen("$dir/../UPGRADE.readme",'w');
  fputs($fh,$text);
  fclose($fh);
  
  
  //////////////////////////////////
  ////////////////////////////////////////////////////////////////////
  // CLEAN UP
  ////////////////////////////////////////////////////////////////////
  //////////////////////////////////
  
  
  print "\n---------------------------------\n";
  print "    ADD TO CHANGELOG\n";
  print "\n---------------------------------\n";
  print date('Y-m-d').", kato\n";
  print "  Prepared install/upgrade docs and scripts\n";
  print "    - zentrack_2/UPGRADE.readme \n";
  foreach($build_files as $f) {
    print "    - zentrack_2/install/$f \n";
  }
  foreach($seed_files as $f) {
    print "    - zentrack_2/install/$f \n";
  }
  foreach($upgrade_files as $f) {
    print "    - zentrack_2/install/$f \n";
  }
  foreach($previous_files as $f) {
    print "    - zentrack_2/install/previous/$f 1.1\n";
  }
  print "\n---------------------------------\n";
  
  print "\nfinished!";
  
  print "\n\n ";
?>