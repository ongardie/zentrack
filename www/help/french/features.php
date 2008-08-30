<?

  /*
  **  HELP SECTION - FEATURES
  */

  $b = dirname(dirname(__FILE__));
  include("$b/help_header.php");

  $page_title = "About ".$zen->getSetting("system_name");
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>
  <span class='bigBold'>Fontionalités <?=$zen->getSetting("system_name")?></span>

  <p><b>(Cette page doit encore évoluer jusqu'à devenir ce qu'elle doit être.  Ce sera  fait avant la version  (2.1) de zenTrack.)</b></p>
   
  <p>Le site, <?=$HTTP_HOST." / ".$zen->getSetting("system_name")?>, est une variante du projet "source libre" 
     <a href='http://sourceforge.net/projects/zentrack'>zenTrack </a>. Il
     est protégé par la <a href='<?=$helpUrl?>/gpl.php'>licence GPL 2.0 </a>.</p>

  <p>A l'origine le système a été conçu par <a href='http://kato.was-here.org'>Michael 
   "Kato" Richardson</a> (<a href='mailto:phpzen@users.sourceforge.net?subject=zenTrack'>phpzen@users.sourceforge.net</a>).  
  Il est désormais maintenu par Kato, et une petie équipe de développeurs au sein de la Source Forge foundery.</p>

  <ul>
    <li><a href='<?=$helpUrl?>/features.php'>Survol, possibilités et limitations</a>
    <li><a href='<?=$helpUrl?>/future.php'>Futurs plans pour le projet de zenTrack</a>
  </ul>


  </blockquote>
<?
  include("$libDir/footer.php");
?>


