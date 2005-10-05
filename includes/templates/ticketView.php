<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  /*
  **  TICKET VIEW
  **
  **  Framework for the ticket view.  Includes the top area, tabs,
  **  tabs, and actions.
  **
  **  REQUIREMENTS:
  **    $view - (String)the current view (ticket_view or project_view)
  **    $map - (ZenFieldMap)
  **    $zen - (zenTrack)
  **    $ticket - (array)the ticket properties from get_ticket or get_project
  **    $page_mode - (string)page to load (ticket_tab_2, close, etc.. validate this!)
  */
  
  preg_match("@^(project|ticket)_view$@", $view);
  $page_type = $matches[1];
  $id = $ticket['id'];
  $type_id = $ticket['type_id'];
  $pageUrl = $page_type == 'project'? $projectUrl : $ticketUrl;
  $viewProps = $map->getViewProps($view);
?>
<table class='barborder' width='100%' height='100%' cellpadding="0" cellspacing="0">
<tr>
  <td class='tbar indent boxpad'><?=$zen->ffv(tr($zen->getTypeName($type_id)))?> #<?=$id?>
  <?
  if( $map->getViewProp('ticket_view_top','show_summary_inline') ) {
    print ": ".$zen->ffvText($ticket['title']);
  }
  ?>
  </td>
</tr>
<tr>
  <td class='indent boxpad'>
  <?
    $boxview = 'ticket_view_top';
    include("$templateDir/ticket_box.php"); 
  ?>
  </td>
</tr>
<tr>
  <td class='tbar indent tabpad'><? include("$templateDir/ticket_tabs.php") ?></td>
</tr>
<tr>
  <td class='indent boxpad' valign='top' height='100%'><?
    if( file_exists("$templateDir/actions/$page_mode.php") ) {
      include("$templateDir/ticket_action.php");
    }
    else if( preg_match("/^{$page_type}_tab_[0-9]$/", $page_mode) ) {
      $tabs = $map->getTabs($page_type, $login_id, $bin_id);
      if( !array_key_exists($page_mode, $tabs) ) {
        print tr("You cannot cannot view this feature.");
      }
      else {
        $boxview = $page_mode;
        if( !$map->getViewProp($page_mode, 'view_only') ) {
          include("$templateDir/ticket_editBox.php");
        }
        else {
          include("$templateDir/ticket_box.php");
        }
      }
    }
    else {
      print tr("Invalid page mode requested");
    }
  ?></td>
</tr>
<tr>
  <td class='tbar indent'><? include("$templateDir/ticket_actions.php")?></td>
</tr>
</table>