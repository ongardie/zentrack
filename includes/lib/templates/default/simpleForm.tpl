
{popup_init src="`$ini.paths.url_www`/js/overlib.js"}

<form name='{$name}' 
      method='{$method}' action='{$action}' 
      class='simpleForm'{if count($jsvals) gt 0}
      onSubmit="return standardValidation(this)"{/if}>
{if isset($rows[0]) && isset($rows[0].hidden) }
 {foreach from=$rows[0].hidden item=fld}
   {include file="simpleForm/hidden.tpl" pval=$fld assign="fieldText"}
   {$fieldText}
 {/foreach}
{/if}
<table width='500' class='simpleForm' cellpadding=3 cellspacing=1>
{if $title != ""}
  <tr><th colspan='2' class='simpleFormTitle'>{$title|tr}</th></tr>
{/if}

{if $description != ""}
  <tr><td colspan='2' class='simpleFormDescription'>{$description|tr}</td></tr>
{/if}

{foreach from=$rows[0].fields item=rowval}
  <tr>
   <td class='simpleFormLabel' valign='top' 
	{if !$showdescription && $rowval.description}{popup caption="`$rowval.label`" text="`$rowval.description`"}{/if}>{$rowval.label|tr}</td>
   <td class='simpleFormCell' valign='top'>
    {include file="simpleForm/`$rowval.ftype`.tpl" assign="fieldText" pval=$rowval options=$options settext=$settext}
    {$fieldText}
    {if $showdescription == true && $rowval.description != ""}
      <div class="footnote">{$rowval.description|tr}</div>
    {/if}
   </td>
  </tr>
{/foreach}

<tr>
 <th colspan='2' class='simpleFormTitle'><input type='submit' class='submit' value='{$submit|default:"Send"|tr}'></th>
</tr>
</table>
</form>

{if count($rows[0].jsvals) gt 0}
 <script language='javascript'>
  var jsFormVals["{$name}"] = [
  {foreach name=jsvals from=$rows[0].jsvals item=val}
    ['{$val[0]}', {$val[1]}, '{$val[2]}', '{$val[3]}', '{$val[4]}', '{$val[5]}']
    {if $smarty.foreach.jsvals.last ne true},{/if}
  {/foreach}
  ];
 </script>
{/if}