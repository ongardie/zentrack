<html>
<head>
  <title>Nav Menu</title>
<style type="text/css">
{literal}
UL {
  padding-left: 10px;
  font-size: 90%;
}
{/literal}
</style>
</head>
<body>

<p><a href='menu.html' target='content'>Home</a></p>

<p><b>Tables</b></p>
<ul>
{foreach item=value from=$tables}
  <a href='{$value}.html' target='content'>{$value}</a><br>
{/foreach}
</ul>

<p>
<b>Abstract Tables</b>
 <br>
 <i>Abstract tables are included by inheritance to construct the real db tables</i>
</p>
<ul>
{foreach item=value from=$abstract}
  <a href='{$value}.html' target='content'>{$value}</a><br>
{/foreach}
</ul>

{include file="schema/footer.tpl" assign="foottext"}
{$foottext}