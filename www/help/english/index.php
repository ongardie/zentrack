<?

  /*
  **  HELP SECTION
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");
  $page_title = tr("Main Menu");
  include("$libDir/nav.php");

?>
  <br>
  <blockquote>
  <b>Welcome to <?=$zen->settings["system_name"]?> Help!</b>
  <ul>
    <b>Tutorial</b>
    <ul>
      New to <?=$zen->settings['system_name']?>?  Try out the tutorial, which
      will explain everything you need to know... except for the stuff it doesn't.
      
      <p><a href='<?=$helpUrl?>/tutorial.php'>View the Tutorial</a></p>
    </ul>
    
    &nbsp;<br><b>User's Manual</b>
    <?
      // prints out an index of the user's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'users', true ); 
    ?>

    &nbsp;<br><b>Administrator's Manual</b>
    <?
      // prints out an index of the administrator's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'admin', true ); 
    ?>
    
    &nbsp;<br><b>Help and Support</b>
    <ul>
      <a href='<?=$helpUrl?>/support.php'>Support & Community</a>
      <br><a href='<?=$helpUrl?>/bugs.php'>Reporting Bugs</a>
      <br><a href='http://www.zentrack.net'>Zentrack Website</a>
    </ul>
    
    &nbsp;<br><b>About Us</b>
    <ul>
      <a href='<?=$helpUrl?>/about.php'>About <?=$zen->settings["system_name"]?></a>
      <br><a href='<?=$helpUrl?>/gpl.php'>License Agreement</a>
      <br><a href='http://www.zentrack.net'>The zenTrack Project</a>
    </ul>
    
    &nbsp;<br><b>Send Us Feedback!</b>
    <ul>
      <p>Be sure to give us some <a href='http://www.zentrack.net/feedback/?subject=Feedback' target='_blank'>feedback</a> about the the 
        the documentation, software, or the latest <a href='http://kato.was-here.org/funnies/catattack.mpeg' target='_blank'>cat attack</a>.
    </ul>

  </ul>
  </blockquote>
<?
  include("$libDir/footer.php");
?>