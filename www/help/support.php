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
  time to time.  For the latest information, please refer to the following pages: -</p>
  <table border=0 align="center" cellspacing="5">
  	<tr>
	  <td>Documentation:</td>
	  <td><a href="http://zendocs.phpzen.net/bin/view/Zentrack/IndexPage">http://zendocs.phpzen.net/bin/view/Zentrack/IndexPage</a></td>
	</tr>
	<tr>
	  <td>FAQ</td>
	  <td><a href="http://zendocs.phpzen.net/bin/view/Zentrack/ZentrackFAQ">http://zendocs.phpzen.net/bin/view/Zentrack/ZentrackFAQ</a></td>
	</tr>
  </table>
  <p>If the solution to your problem is not to be found in the manual or in the FAQ, it is worthwhile trying one
  of the following places for some help: -</p>
  
  <table border=0 cellspacing=5>
    <tr valign="top">
	  <td valign="top"><a href="http://www.sourceforge.net/projects/zentrack">Online</a></td>
	  <td>(see the support pages)  This will get you a response, probably in hours, maybe in days, but
           you will get one.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="irc://irc.sourceforge.net/#zentrack">IRC</a></td>
	  <td>zentrack now has a home on irc.sourceforge.net, #zentrack, this may
   	      be a good place to find some help with more in depth issues.
          (usually a response in minutes, sometimes ignored)</td>
	</tr>
	<tr>
	  <td valign="top"><a href="http://sourceforge.net/mail/?group_id=22724">Mailing List</a></td>
	  <td>zentrack-users is a great place to get help.  Answers usually
          within 12 hours.  Never ignored.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="mailto:phpzen@users.sourceforge.net">E-mail</a></td>
	  <td>If you are a registered tester, you will get a reply, otherwise
          you may get a response if I'm bored, maybe in hours, maybe never</td>
	</tr>
  </table>

  <p>Please report bugs <a href="http://sourceforge.net/tracker/?group_id=22724&atid=376336">here</a>.  When
  submitting a bug report, or asking for support from the developers, you <b>must</b> set <em>$this->debug</em>
  in the <em>includes/configVars.php</em> file to <em>3</em> and paste the results in your report.  If you can't get zenTrack
  to run this far, <b>then you must submit your version info for zenTrack, your OS, your Browser, and your
  Server,</b> so that we can re-create the error.</p>

  </blockquote>
