<?
  include("action_header.php");

  if( !$zen->checkAccess($login_id, $bin_id, 'varfield_edit') ) {
    $errs[] = tr("You cannot edit a ticket's custom fields in this bin");
  }
  else if( !$zen->actionApplicable($id, 'varfield_edit', $login_id) ) {
    $errs[] = tr("Ticket #? cannot be edited right now", array($id));
  }

  include("$libDir/editCustomSubmit.php");
?>
