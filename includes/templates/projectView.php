<?
  /*
  **  PROJECT VIEW
  **
  **  Framework for the project viewing screen
  **  Includes ticket_actionBar (the buttons)
  **  ticket_titleBox (the important details)
  **  and ticket_box (which is the tabbed section below the buttons)
  */
  
  // add the "tasks" tab to the bar
  array_unshift($tabs,"Tasks");

?><table width="640" cellspacing="1" cellpadding="2">
  <tr>
    <td width="80" valign="top"><? include("$templateDir/ticket_actionBar.php"); ?></td>
    <td width="560" valign="top"><? include("$templateDir/ticket_titleBox.php"); ?></td>
  </tr>
  <tr>
    <td colspan="2" width="640" valign="top"><? include("$templateDir/ticket_box.php"); ?></td>
  </tr>
</table>
