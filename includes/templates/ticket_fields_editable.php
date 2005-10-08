<table>
<? if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  FIELDS EDITABLE
  **
  **  Renders fields in ticket view window for editing
  **
  **  REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  *   $boxview - (string)view to be loaded from field map
  *   $ticket - values for all columns in the ticket we are viewing
  */

  $td = true;
  $formview = $boxview;
  $form_name = 'edit_ticket';
  include("$templateDir/form_fields.php");
  
  print "<p>save button goes here</p>\n";

?>
</table>