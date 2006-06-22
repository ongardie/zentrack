<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<div class='menubox'>
  <div><?=tr("Ou suis je?")?></div>
  <p class='note'><?=tr("The user's manual contains instructions on how to use\ncommon features of ?",
        $zen->getSetting('system_name'))?>.</p>
  <p class='note'>
  First time using <?=$zen->getSetting('system_name')?>?  
  Merci d'exp�rimenter  
  <a href='<?=$helpUrl?>/tutorial.php'><?=tr("Tutorial")?></a>!</p>
</div>

<div class='menubox'>
  <div><?=tr("Contents of User's Manual")?></div>
<?
  renderTOC('users', false);
?>
</div>

<div class='menubox'>
  <div><?=tr("What is ??", $zen->getSetting('system_name'))?></div>

  <p class='note'><?=$zen->getSetting('system_name')?> enregistre des informations � propos des t�ches et des projets pour votre soci�t�
  sous forme de fiches, et ainsi procure une interface pour g�rer qui est en charge d'une fiche et quel est l'�tat de la fiche.

  <p class='note'><?=$zen->getSetting('system_name')?> met �galement � disposition des informations utiles � propos d'une fiche  pour � la fois les intervenants sur le sujet d�crit par la fiche, et pour les gestionnaires du projet qui ont en charge la planification  et la synchronisation des projets en cours.</p>
</div>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
