<? 
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  $relations = $ticket['relations'];
  if( is_array($relations) ) {
    $relations = join(',',$relations);
  }
?>

<form method="post" action="<?=$SCRIPT_NAME?>" name='relateTicketForm'>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">
<input type="hidden" name="setmode" value="<?=$page_mode?>">

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?=tr("Relate Ticket")?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Enter Ticket IDs")?>
 </td>
</tr>
<tr>
 <td class='bars'>
<?
  $templateVars = array(
    'field_name'   => 'relations',
    'field_cols'   => '20',
    'field_max'    => '9999',
    'search_mode'  => 'ticket',
    'search_type'  => '',
    'form_name'    => 'relateTicketForm',
    'search_multi' => '1',
    'search_text'  => ''
  );
  $template = new ZenTemplate("$templateDir/fields/searchbox.template");
  $template->values( $templateVars );
  print $template->process();
  if( $relations ) {
    $vals = explode(',', $relations);
    print "<script>";
    foreach($vals as $v) {
      $ticket = $zen->get_ticket($v);
      $ttl = Zen::ffv($ticket['title']);
      print "addSearchboxVal('relateTicketForm', 'relations', '$v', '$ttl', true, false);\n";
    }
    print "</script>";
  }
?>
  </td>			     
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Comments")?> 
	&nbsp;<span class="small">(<?=tr("optional")?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Comments")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle">
  <? renderDivButtonFind('Relate'); ?>
  </td>
</tr>
<tr>
</table>

</form>
