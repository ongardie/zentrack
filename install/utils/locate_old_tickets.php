<?php

  if( !$argv || count($argv) < 2 ) {
    echo "\nUsage:\n\n./locate_old_tickets.php older_than_date\n\twhere older than date is any valid date format\n\teven '-1 month' or '-7 days'\n\n";
  }

  // get the system settings
  // and process them, but don't include
  // the headerInc.php file, just get
  // the setting values
  $file = file("../header.php");
  foreach($file as $f) {
    if( preg_match("/^ *([$]|set_locale)/", $f)) {
      eval($f);
    }
  }
  
  //initialize zen base object
  include_once("$libDir/zenTrack.class");
  $zen = new zenTrack( "$libDir/configVars.php" );
  
  $date = strtotime($argv[1]);
  
  $query = "select distinct id from ZENTRACK_TICKETS,ZENTRACK_LOGS where id = ticket_id AND $date <= created";
  $list = $zen->db_list($query);
  print_r($list);
  
  print "<pre>\n";
  print "<b>Query:</b>\n";
  print "$query\n";
  
  $query = " select id,title " 
      ." from ZENTRACK_TICKETS,ZENTRACK_LOGS "
      ." where id = ticket_id "
      ." and status = 'OPEN' ";
  if( is_array($list) && count($list) ) {
    $query .= " and id not in (".join(",",$list).") ";
  }
  $query .= " group by id,title";
  $tickets = $zen->db_query($query);

  print "\n\n<b>Second Query:</b>\n";
  print count($tickets)." tickets found: $query\n";
  
  print "\n\n<b>Values:</b>\n";

  for($i=0; $i<count($tickets); $i++) {
    $t = $tickets[$i];
    print "$t[0]\t$t[1]\n";    
  }
      
  print "</pre>\n";

?>