<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  CONTACT VIEW
  **
  **  Framework for the contact viewing screen
  **  Includes contact_buttonBox (the buttons)
  **  contact_box (the tabs)
  */
?>
 
 <table width="640" cellspacing="1" cellpadding="2">
 <tr>
    <td width="640" valign="top"><? include("$templateDir/contact_buttonBox.php"); ?></td>
  </tr>
  <tr>
    <td width="640" valign="top">
     <?
  		if ($setmode==all) {
	  		include("$templateDir/contact_allBox.php");
  		} else {
	  		include("$templateDir/contact_box.php");
  		}
  	 ?>
    </td>
  </tr>
</table>
