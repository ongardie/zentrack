<?

  include("help_header.php");

  $title = "About zenTrack";

  include("$libDir/nav.php");

?>&nbsp;
  <blockquote>
    <h3>zenTrack Ticket Tracking System</h3>
    <b>Version:</b> 2.0 (Oracle / Win32 Setup)
    <p>
    <b>Author:</b>  Michael Richardson
    <p>
    <b>Purpose:</b>  Provide bug / project tracking method for company wide use,
    with easy administration, configuration, and user access controls.
    <p>
    <b>Release Date:</b>  February 27th, 2001
    <br>
    <b>Previous Releases:</b>  None
    <P>
    <b>Usage Requirements:</b>
    <P>
    4.0 or better mozilla browser with Javascript 1.0 or better.
    <br>
    Internet Explorer 5.0 will produce most desireable results.
    <P>
    <b>To Do:</b>
    <ul>
       <li>Add time tracking - hours required, hours worked, etc.</li>
       <li>Add reporting - users vs. projects assigned and hours assigned</li>
       <li>Add preferences - view, sort, and default setup options for individual preference</li>
       <li>Add edit ticket - function to edit properties of a ticket</li>
       <li>Archive Functions - functions to archive ticket</li>
       <li>Finish help menus - some pages not complete</li>
       <li>Email functions - not installed yet</li>
    </ul>
    <P>
    <b>Known Bugs:</b>
    <ul>
    <b>Configuration Arrays:</b> There is a bug in the settings configuration menu that prevents
    an administrator from editing the name of an array entry (i.e. changing a bin name).
    This bug only affects the configuration settings which have multiple values.
    To avoid this, delete the value to be edited, and then add it with the new value.
    </ul>
  </blockquote>
<?

  include("$libDir/footer.php");
?>
