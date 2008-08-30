<? if( $ticket['project_id'] ) { 
  $project = $zen->get_project($ticket['project_id']);
  $project_name = "#{$ticket['project_id']}: ".$zen->ffv($project['title']);
?>
<div class='borderBox'>
  <div class='borderLabel'><span><?=uptr("Project")?></span></div>
  <div class='borderContent' <?=$rollover_text?>><a href='<?=$rootUrl?>/project.php?id=<?=$ticket['project_id']?>'><?=$project_name?></a></div>
</div>
<br>
<? } ?>