<?{

  /**
   **  ADD ENTRIES TO NOTIFY LIST
   **  
   **  Checks for duplicates and adds users/email addresses
   **  to a ticket's notify list
   */
  
  $action = "notify";  
  include("./action_header.php");
  
  if( $actionComplete == 1 ) {
    $ticket_id = $id;
    $priority = 1;
    // clean input vars
    $users = null;
    if( strlen($user_accts) ) {
      $users = split("[, \n]+", $user_accts);
    }
    if( strlen($unreg_name) ) {
      $unreg_name = strip_tags($unreg_name);
    }
    if( strlen($unreg_email) ) {
      $unreg_email = $zen->checkEmail($unreg_email);
    }

    if( !count($users) && (!strlen($unreg_name)||!strlen($unreg_email)) ) {
      $errs[] = "You must provide at least one registered user, or a valid name and email address";
    }

    if( !$errs ) {
      $i = 0;
      if( count($users) ) {
  foreach($users as $u) {
    if( !$zen->check_user_id($u) ) {
      $errs[] = "$u was not a valid user id";
    } else {
      $params = array("user_id"   => $u,
          "priority"  => $priority,
          "ticket_id" => $ticket_id);
      $res = $zen->add_to_notify_list($ticket_id, $params);
      if( $res && $res != "duplicate" ) {
        $i++;
      }
      else if( $res && $res == "duplicate" ) {
        add_system_messages("user_id $u already on notify "
         ."list for #$ticket-id");        
      }
    }
  }
      }
      if( strlen($unreg_name) && strlen($unreg_email) ) {
  $params = array("name"      => $unreg_name,
      "email"     => $unreg_email,
      "priority"  => $priority,
      "ticket_id" => $ticket_id);
  $res = $zen->add_to_notify_list($ticket_id,$params);
  if( $res && $res != "duplicate" ) {
    $i++;
  }
  else if( $res && $res == "duplicate" ) {
    add_system_messages("email $unreg_email already on notify "
           ."list for #$ticket-id");        
  }
      }
      if( $i > 0 ) {
  add_system_messages("$i entries added to #$ticket_id notification.");
  $setmode = "notify";
      } else {
  $errs[] = "System error: Notify list could not be updated ".$zen->db_error;
      }
    }
    if( $errs )
      add_system_messages( $errs, 'Error' );     
  }
  
  include("$libDir/nav.php");
  
  if( strtolower($zen->types["$type_id"]) == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");

}?>
