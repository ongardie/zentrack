{*
  Generate a list of checkboxes
*}
 
<input type="checkbox" name="{$pval.name}_toggle" value="toggler" 
   onClick="checklistToggle(this, '{$pval.name}')"><b>Check All</b><br>

  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
{foreach name=checklist from=$pval.choices item=cval}
  <input type="checkbox"
    name="{$pval.name}[{$smarty.foreach.checklist.iteration - 1}]"
    value="{$cval.value|escape:html}"
    {if $cval.selected}checked{/if}
    {$eventText}><br>
{/foreach}