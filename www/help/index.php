<?

  /*
  **  HELP SECTION
  */

  include("./help_header.php");
  
  $page_title = "Main Menu";
  include("$libDir/nav.php");

?>
  <br>
  <blockquote>
  <b>Welcome to <?=$zen->settings["system_name"]?> Help!</b>

  <p>Thanks for downloading the 2.0 beta version!  The help menus are being developed, and 
  will be refined and released with the live 2.0 install.  Until then, please use our 
  <a href='http://www.sourceforge.net/projects/zentrack/'>source forge project system</a> 
  to obtain assistance and report errors.

  <ul>
    <b>General Information:</b>
    <ul>
      <a href='<?=$helpUrl?>/about.php'>About <?=$zen->settings["system_name"]?></a>
      <br><a href='<?=$helpUrl?>/gpl.php'>GPL License Agreement</a>
      <br>Overview, Capabilities and Limitations
      <br><a href='<?=$helpUrl?>/future.php'>Future Plans</a>
      <br><a href='http://sourceforge.net/projects/zentrack'>The zenTrack Project</a>
    </ul>
    <b>User Help:</b>
    <ul>
      Beginners Tutorial
      <br>Creating Tickets
      <br>Ticket Features
      <br>Generating Reports
    </ul>

    <b>Administrator Help</b>
    <ul>
      Administrating Users
      <br>Configuring the System
      <br><a href='<?=$helpUrl?>/install.php'>Installation</a>
      <br><a href='<?=$helpUrl?>/api.php'>API (documentation of the class objects)</a>
    </ul>
  </ul>
  </blockquote>
<?
  include("$libDir/footer.php");
?>
