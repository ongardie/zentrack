<?

  /*
  **  HELP SECTION
  */

  include("help_header.php");
  
  $page_title = "Main Menu";
  include("$libDir/nav.php");

?>
  <br>
  <blockquote>
  <b>Welcome to <?=$zen->settings["system_name"]?> Help!</b>
  <ul>
    <b>General Information:</b>
    <ul>
      <a href='<?=$helpUrl?>/about.php'>About <?=$zen->settings["system_name"]?></a>
      <br><a href='<?=$helpUrl?>/gpl.php'>GPL License Agreement</a>
      <br><a href='http://www.zentrack.net'>The zenTrack Project</a>
    </ul>

    &nbsp;<br><b>User's Manual</b>
    <? renderTOC( 'users', true ); ?>

    &nbsp;<br><b>Administrator's Manual</b>
    <? renderTOC( 'admin', true ); ?>
    
    &nbsp;<br><b>More Assistance</b>
    <ul>
      <a href='<?=$helpUrl?>/support.php'>Support & Community</a>
      <br><a href='http://www.zentrack.net'>Zentrack Website</a>
    </ul>
  </ul>
  </blockquote>
<?
  include("$libDir/footer.php");
?>