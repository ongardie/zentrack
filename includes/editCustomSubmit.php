<?
//if( !$zen->checkAccess($login_id,$ticket["bin_id"],"edit_custom") ) {
//  $errs[] = tr("You cannot edit a ticket's custom fields in this bin ");
//} else if( !$zen->actionApplicable($id,"edit_custom",$login_id) ) {
//  $errs[] = $zen->ptrans("Ticket #? cannot be edited in its current status",array($id));
//}
                                                                                                                             
  $page_tile = tr("Commit Edited Ticket's Custom Fields");
  $expand_admin = 1;
                                                                                                                             
  $fields = array();
                                                                                                                             
  $cfd=$zen->getCustomFields(1,$page_type,"C");
  foreach($cfd as $k => $v) {
    $varfield_type=ereg_replace("[^a-z_]", "", $k);
    switch($varfield_type) {
      case "custom_number":
        $cfv=($$k)?$$k : 0;
        $cft="int";
        break;
      case "custom_date":
        $cfv=($$k)?$zen->dateParse($$k) : "n/a";
        $cft="num";
        break;
      default:
        $cfv=$$k;
        $cft="text";
        break;
    }
    $fields[$k]=$cft;
    $$k=$cfv;
  }

  $zen->cleanInput($fields);
  if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
         $params["$f"] = $$f;
     }
     // update the ticket info
     $res = $zen->updateVarfieldVals($id,$params);
     // check for errors
     if( !$res ) {
   $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
     }
  }

  if( !$errs ) {
     add_system_messages(tr("Edited ticket's custom fields")." $id.");
     //header("Location:$rootUrl/ticket.php?id=$id&setmode=Custom");
     $setmode = "Custom";
     if( $zen->inProjectTypeIDs($bin_id) ) {
       include("../project.php");
     } else {
       include("../ticket.php");
     }
     exit;
  } else {
     include_once("$libDir/nav.php");
     $zen->print_errors($errs);
     $TODO = 'EDIT';
     if( $zen->inProjectTypeIDs($bin_id) )
       include("$templateDir/projectView.php");
     else
       include("$templateDir/ticketView.php");
     include("$libDir/footer.php");
  }
?>
