<?  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  include("help_header.php");

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

  <p>Please report bugs <a href="http://sourceforge.net/tracker/?group_id=22724&atid=376336">here</a>.  When
  submitting a bug report, or asking for support from the developers, you <b>must</b> set <em>$Debug_Mode</em>
  in the <em>www/header.php</em> file to <em>3</em> and paste the results in your report.  If you can't
  get zenTrack to run this far, <b>then you must submit your version info for zenTrack, your OS, your Browser,
  and your Server,</b> so that we can re-create the error.</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>
