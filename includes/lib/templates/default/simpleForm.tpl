
<form name='{$name}' method='{$method}' action='{$action}' class='simpleForm'>
{foreach from=$hiddenfields item=fld}
  {include file="simpleForm/hidden.tpl" pval=$fld assign="fieldText"}
  {$fieldText}
{/foreach}
<table width='500'>
{if $title != ""}
  <tr><th colspan='2' class='simpleFormTitle'>{$title|tr}</th></tr>
{/if}

{if $description != ""}
  <tr><td colspan='2' class='simpleFormDescription'>{$description|tr}</td></tr>
{/if}

{foreach from=$fields item=rowval}
  <tr>
   <td class='simpleFormLabel'>{$rowval.label|tr}</td>
   <td class='simpleFormCell'>
    {include file="simpleForm/`$rowval.ftype`.tpl" pval=$rowval assign="fieldText"}
    {$fieldText}
    {if $showdescription == true && $rowval.description != ""}
      <div class="details">{$rowval.description|tr}</div>
    {/if}
   </td>
  </tr>
{/foreach}

<tr>
 <td colspan='2'><input type='submit' class='submit' value='{$submit|default:"Send"|tr}'></td>
</tr>
</table>
</form>