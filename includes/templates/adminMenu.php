<br>
<ul>
  
  <b><?=tr("User Administration")?></b>
  <ul>
    <b><a href='<?=$rootUrl?>/admin/addUser.php'><?=tr("New User")?></a></b>
    <br><span class="small">(<?=tr("Create a new user account")?>)</span>
    <br><b><a href='<?=$rootUrl?>/admin/listUsers.php'><?=tr("Edit Users/Access")?></a></b>
    <br><span class="small">(<?=tr("Edit user accounts and permissions.")?>)</span>
  </ul>
      
  <br><b><?=tr("Ticket Administration")?></b>
  <ul>
    <b><a href='<?=$rootUrl?>/admin/editTicket.php'><?=tr("Edit Tickets")?></a></b>
    <br><span class="small">(<?=tr("Edit ticket information")?>)</span>
    <br><b><a href='<?=$rootUrl?>/admin/editCustom.php'><?=tr("Edit Variable Fields")?></a></b>
    <br><span class="small">(<?=tr("Custom defined fields for tickets.")?>)</span>
  </ul>

  <br><b><?=tr("Data Types")?></b>
  <ul>
      <b><a href='<?=$rootUrl?>/admin/bins.php'><?=tr("Edit Bins")?></a></b>
      <br><span class="small">(<?=tr("Bins are departments or groups that tickets belong to.")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/priorities.php'><?=tr("Edit Priorities")?></a></b>
      <br><span class="small">(<?=tr("Priorities represent the importance of an issue.")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/systems.php'><?=tr("Edit Systems")?></a></b>
      <br><span class="small">(<?=tr("Systems represent a component or area the ticket is specific to.")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/tasks.php'><?=tr("Edit Tasks")?></a></b>
      <br><span class="small">(<?=tr("Tasks represent types of log entries.")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/types.php'><?=tr("Edit Types")?></a></b>
      <br><span class="small">(<?=tr("Types represent the type of ticket activity.")?>)</span>
  </ul>
  
  <br><b><?=tr("Settings Administration")?></b>
  <ul>
      <b><a href='<?=$rootUrl?>/admin/groups.php'><?=tr("Edit Data Groups")?></a></b>
      <br><span class="small">(<?=tr("Data groups are a list created from a data type")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/behaviors.php'><?=tr("Edit Behaviors")?></a></b>
      <br><span class="small">(<?=tr("Behaviors let you specify how a field modification would affect other field of the current ticket.")?>)</span>
      <br><b><a href='<?=$rootUrl?>/admin/config.php'><?=tr("Configuration Settings")?></a></b>
      <br><span class="small">(<?=tr("Edit the zenTrack settings.  Consult the documentation before using this feature.")?>)</span>
  </ul>
  
</ul>
