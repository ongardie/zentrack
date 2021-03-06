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
  **    $id - (integer)id of the ticket to view
  **    $ticket - (array)the ticket properties from get_ticket or get_project
  **    $varfields - (array)variable field values for the ticket
  **    $page_mode - (string)page to load (ticket_tab_2, close, etc.. validate this!)
  **    $page_type - either 'ticket' or 'project'
  */
  if( !$page_type ) {
    preg_match("@^(project|ticket)_view$@", $view);
    $page_type = $matches[1];
  }
  $id = $ticket['id'];
  $type_id = $ticket['type_id'];
  $pageUrl = $page_type == 'project'? $projectUrl : $ticketUrl;
?><table class='barborder' width='100%' cellpadding="0" cellspacing="0">
<tr>
  <td class='subTitle padded' valign='bottom'><? //tbar padded indent ridge
  if( $map->getViewProp('ticket_view_top','move_actions_up') ) {
  ?><table width='100%' cellpadding='0' cellspacing='0'><tr><td class='tbar' valign='bottom'>
    <?=$zen->ffv(tr($zen->getTypeName($type_id)))?> #<?=$id?><?
    if( $map->getViewProp('ticket_view_top','show_summary_inline') ) {
      print ": ".$zen->ffvText($ticket['title']);
    }
  ?></td><td align='right'><?
    include("$templateDir/ticket_actions.php");
  ?></td></tr></table><?
  }
  else {
    print $zen->ffv(tr($zen->getTypeName($type_id)))." #$id";
    if( $map->getViewProp("{$page_type}_view_top",'show_summary_inline') ) {
      print ": ".$zen->ffvText($ticket['title']);
    }
  }
  ?></td>
</tr>
<tr>
  <td class='indent boxpad'><?
    $boxview = "{$page_type}_view_top";
    include("$templateDir/ticket_box.php");
  ?></td>
</tr>
<tr>
  <td class='tbar indent tabpad lip'><? include("$templateDir/ticket_tabs.php") ?></td>
</tr>
<tr>
  <td class='indent boxpad' valign='top' height='225'><?
    if( isset($action) ) { $action = preg_replace('@[^0-9a-zA-Z_-]@', '', $action); }
    if( isset($action) && file_exists("$templateDir/actions/$action.php") ) {
      print "<div class='actionFormBox'>";
      include("$templateDir/ticket_action.php");
      print "</div>";
    }
    else if( preg_match("/^{$page_type}_tab_[0-9]$/", $page_mode) ) {
      $tabs = $map->getTabs($page_type, $login_id, $ticket['bin_id']);
      if( !array_key_exists($page_mode, $tabs) || !$map->getViewProp($page_mode,'visible') ) {
        if ( ! $zen->checkCreator($login_id,$id) ) {
          print "<div class='error'>".tr("Invalid page mode requested: ? ($login_id,$id)", $zen->ffv($page_mode))."</div>";
        } else {
          $zen->addDebug('ticketView','Ticket_box not allowed for ticket_cview.',3);
        }
      }
      else {
        $boxview = $page_mode;
        include("$templateDir/ticket_box.php");
      }
    }
    else {
      if ( ! $zen->checkCreator($login_id,$id) ) {
        print "<div class='error'>".tr("Invalid page mode requested: ? ($login_id,$id)", $zen->ffv($page_mode))."</div>";
      } else {
        $zen->addDebug('ticketView','Ticket_box not allowed for ticket_cview.',3);
      }
    }
  ?></td>
</tr>
<?
 if( !$map->getViewProp('ticket_view_top','move_actions_up') ) {
?>
<tr>
  <td class='tbar padded ridge'><? include("$templateDir/ticket_actions.php")?></td>
</tr>
 <? } ?>
</table>
