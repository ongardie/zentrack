
{popup_init src="`$ini.paths.url_www`/js/overlib.js"}

<form name='{$name}' 
      method='{$method}' action='{$action}' 
      class='simpleForm'
     onSubmit="return standardValidation(this)">
{if isset($rows[0]) && isset($rows[0].hidden) }
 {foreach from=$rows[0].hidden item=fld}
   {include file="simpleForm/hidden.tpl" pval=$fld assign="fieldText"}
   {$fieldText}
 {/foreach}
{/if}
<table class='simpleForm' cellpadding=3 cellspacing=1>
{if $title != ""}
  <tr><th colspan='100%' class='simpleFormTitle'>{$title|tr}</th></tr>
{/if}

{if $description != ""}
  <tr><td colspan='100%' class='simpleFormDescription'>{$description|tr}</td></tr>
{/if}

<tr>
{foreach from=$rows[0].fields key=key item=field}
 {if $field.type != "skip"}
   <th class='rowFormHeading' valign='top' 
	{if $field.description}
           {popup caption="`$field.label`" text="`$field.description`"}
        {/if}>{$field.label|tr}
   </th>
 {/if}
{/foreach}
</tr>

{foreach from=$rows item=row}
  <tr>
  {foreach from=$row.fields key=key item=field}
   {if $field.type != "skip"}
   <td class='simpleFormCell' valign='top'>
    {include file="simpleForm/`$field.ftype`.tpl" assign="fieldText" pval=$field}
    {$fieldText}
   </td>
   {/if}
  {/foreach}
  </tr>
{/foreach}

<tr>
 <th colspan='100%' class='simpleFormTitle'><input type='submit' class='submit' value='{$submit|default:"Send"|tr}'></th>
</tr>
</table>
</form>

 <script language='javascript'>
{foreach from=$rows item=row}
 {if count($row.jsvals) gt 0}
  jsFormVals["{$name}"] = [
  {foreach name=jsvals from=$row.jsvals item=val}
    ['{$val[0]}', {$val[1]}, '{$val[2]}', '{$val[3]}', '{$val[4]}', '{$val[5]}']
    {if $smarty.foreach.jsvals.last ne true},{/if}
  {/foreach}
  ];
 {/if}
{/foreach}
 </script>
