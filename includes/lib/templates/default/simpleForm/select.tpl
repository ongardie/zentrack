
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <select name='{$pval.name}'
    {if $multiple > 1 }size={$multiple}{/if}
    {$eventText}>
    {foreach from=$pval.choices item=$optval}
       <option value='{$optval.value}' {if $optval.selected == true}selected{/if} {$optval.style}>
         {$optval.label|default:$optval.value|tr}
       </option>
    {/foreach}
  </select>