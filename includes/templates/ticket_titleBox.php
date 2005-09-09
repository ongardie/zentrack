<? if( !ZT_DEFINED ) { die("Illegal Access"); }

 /**
  * The summary/top area of the ticket view screen
  *
  * REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  */
  $view = 'ticket_view_top';
  include("$templateDir/ticket_tab.php");
?>