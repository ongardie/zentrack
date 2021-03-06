<?

  /*
  **  HELP SECTION
  */

  $b = realpath(dirname(dirname(__FILE__)));
  include_once("$b/help_header.php");
  $page_title = tr("Main Menu");
  $onLoad[] = "color_functions.js";
  $onLoad[] = "js_color_picker_v2.js";
  include("$libDir/nav.php");

?>
  <div class='heading'><?=tr("Welcome to ? Help!",$zen->getSetting('system_name'))?></div>

  <div class='menubox'>
    <div><?=tr("Tutorial")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$helpUrl?>/tutorial.php'><?=tr("View the Tutorial")?></a>
    <span class='note'>
    <?=tr("New to ??  Try out the tutorial, which will explain everything you "
      ."need to know... except for the stuff it doesn't.", $zen->getSetting('system_name'));?>
    </span></p>
    <p onclick='mClk(this)'><a href='<?=$helpUrl?>/hotkeys.php'><?=tr("Hot Key Settings")?></a></p>
  </div>
    
  <div class='menubox'>
    <div><?=tr("User's Manual");?></div>
    <?
      // prints out an index of the user's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'users', true ); 
    ?>
  </div>

  <div class='menubox'>
    <div><?=tr("Administrator's Manual")?></div>
    <?
      // prints out an index of the administrator's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'admin', true ); 
    ?>
  </div>
    
  <div class='menubox'>
    <div><?=tr("Help and Support")?></div>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/modules/support/'><?=tr("Community")?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/modules/newbb/'><?=tr("Forums")?></a></p>
    <p onclick='mClk(this)'><a href='<?=$helpUrl?>/bugs.php'><?=tr("Reporting Bugs")?></a></p>
  </div>
    
  <div class='menubox'>
    <div>About Us</div>
    <p onclick='mClk(this)'><a href='<?=$helpUrl?>/about.php'>
      About <?=$zen->getSetting('system_name');?></a></p>
    <p onclick='mClk(this)'><a href='<?=$helpUrl?>/gpl.php'><?=tr("License")?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net'><?=tr("Website")?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/feedback/?subject=Feedback' 
      target='_blank'><?=tr("Feedback")?></a>
      <span class='note'><?=tr("Give us Feedback!")." ".tr("Tell us about the latest ?", 
        "<a href='http://kato.was-here.org/funnies/catattack.mpeg' 
          target='_blank'>".tr("cat attack")."</a>")?></span>
    </p>
  </div>
  
  <p>&nbsp;</p>
  
<?
  include("$libDir/footer.php");
?>