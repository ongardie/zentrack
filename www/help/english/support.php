<?  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "Support";
  include("$libDir/nav.php");
?>

  <br>
  <blockquote>
  <span class='bigBold'>Support for <?=$zen->settings["system_name"]?></span>
  <p>Much of the documentation for zenTrack is still under construction and changes from
  time to time.  For the latest information, please refer to the following pages:</p>
  <ul>
    <b>Documentation: <a href="http://docs.zentrack.net">http://docs.zentrack.net</a></b>
  </ul>
  <p>If the solution to your problem is not to be found in the manual, it is worthwhile trying one
  of the following places for some help:</p>
  
  <table border=0 cellspacing=5>
	<tr>
	  <td valign="top"><a href="http://sourceforge.net/mail/?group_id=22724">Mailing List</a></td>
	  <td>zentrack-users is a great place to get help.  Answers usually
          within 12-24 hours.</td>
	</tr>
        <tr valign="top">
	  <td valign="top"><a href="http://www.sourceforge.net/projects/zentrack">Online</a></td>
	  <td>(see the support pages)  This will get you a response, probably in hours, maybe in days, but
           you will get one.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="mailto:phpzen@users.sourceforge.net">E-mail</a></td>
           <td>If you are a registered tester, you can email me directly.  If you are not 
               a registered tester you will have better luck on the  mailing list.
           </td>
	</tr>
  </table>

  <p><a href='<?=$helpUrl?>/bugs.php'>Click here</a> for information about
  reporting bugs!</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>
