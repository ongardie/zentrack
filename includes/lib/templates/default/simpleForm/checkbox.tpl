 
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <input type="checkbox" 
    name="{$pval.name}"
    value="{$pval.checkval|default:1|escape:html}"
    {if $pval.default == true}checked{/if}
    {$eventText}>