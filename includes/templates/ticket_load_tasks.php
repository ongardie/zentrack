<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  include_once("$libDir/sorting.php");
  $tickets = $zen->get_tickets(array('project_id'=>$id),$sortstring);
  $total_children = $zen->total_records;
  $hotkeys->loadSection('project_tasks');

  if( is_array($tickets) && count($tickets) > 0) {
    $master_view = $view;
    $view = 'project_tasks';
    include("$templateDir/listTickets.php");
    $view = $master_view;
  } else {
     print tr("No tickets have been added to this Project.");
  }
?>
  <table width="100%" cellpadding="2" cellspacing="2">
  <tr>
     <td width='100%'>&nbsp;</td>
     <td align="right">
     <form style='display:inline' name='newTicketHotkey' action="<?=$rootUrl?>/newTicket.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
     <? renderDivButtonFind('Add Ticket to Project'); ?>
     </form>
     </td>
     <td align='left'>
     <form style='display:inline' name='newProjectHotkey' action="<?=$rootUrl?>/newProject.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
     <? renderDivButtonFind('Create Sub-Project'); ?>
     </form>
     </td>
   </tr>    
   </table>





