
{include file="schema/header.tpl" assign="headtext"}
{$headtext}

<p style='font-weight:bold; text-size: 125%'>TABLE: {$name}</p>

<p><b>Properties</b></p>
<ul>
{foreach key=index item=value from=$properties}
  <b>{$index}</b>: {$value}<br>
{/foreach}
</ul>
</p>

<p><b>Inherits</b>: 
{foreach item=value from=$inherits}
  <a href='{$value}.html'>{$value}</a>,&nbsp;
{/foreach}
</p>

<p><b>Fields</b></p>
<table cellspacing='0' cellpadding='2' border='1'>
<tr class='rowHeading'>
  <th>Name</th>
  <th>Data Type</th>
  <th>Label</th>
  <th>Foreign Key</th>
  <th>Form Type</th>
  <th>Order</th>
  <th>Notes</th>
</tr>
{foreach item=pval from=$fields}
  {include file="schema/field.tpl" pval=$pval}
{/foreach}

</table>

{include file="schema/footer.tpl" assign="foottext"}
{$foottext}