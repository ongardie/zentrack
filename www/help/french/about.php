<?

  /*
  **  HELP SECTION - ABOUT
  */

  $b = dirname(__FILE__);
  include(dirname($b)."/help_header.php");

  $page_title = "About ".$zen->getSetting("system_name");
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>
  <span class='bigBold'>About <?=$zen->getSetting("system_name")?></span>
   
  <p><?=$zen->getSetting("system_name")?> est une variante "source libre" 
     <a href='http://sourceforge.net/projects/zentrack'>du projet zenTrack</a>. Il est     protégé par la   <a href='<?=$helpUrl?>/gpl.php'>Licence GPL 2.0 </a>.</p>

  <p>A l\'origine le projet a été écrit par <a href='http://kato.was-here.org'>Kato Richardson</a> 
  (<script>eLink('phpzen','users.sourceforge.net')</script>).  
  Il est désormais maintenu par Kato et un petit groupe de développeurs expérimentés de Source Forge founderie</p>

  <p>De plus amples informations sur zenTrack sont disponibles sur le site du projet : <a href='http://www.zentrack.net'>http://www.zentrack.net</a>.</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>


