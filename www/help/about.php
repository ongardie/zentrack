<?

  /*
  **  HELP SECTION - ABOUT
  */

  include("help_header.php");

  $page_title = "About ".$zen->settings["system_name"];
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>
  <span class='bigBold'>About <?=$zen->settings["system_name"]?></span>
   
  <p><?=$zen->settings["system_name"]?> is an open source variant of the 
     <a href='http://sourceforge.net/projects/zentrack'>zenTrack project</a>. It
     is protected under the <a href='<?=$helpUrl?>/gpl.php'>GPL 2.0 License</a>.</p>

  <p>The system was originally written by <a href='http://kato.was-here.org'>Kato Richardson</a> (<a href='mailto:phpzen@users.sourceforge.net?subject=zenTrack'>phpzen@users.sourceforge.net</a>).  
  It is now maintained by Kato and an small, experienced group of developers through the 
  source forge foundry.</p>

  <p>Much more information about zenTrack can be found at the home page: <a href='http://www.zentrack.net'>http://www.zentrack.net</a>.</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>


