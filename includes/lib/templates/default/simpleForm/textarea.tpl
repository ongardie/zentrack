
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <textarea 
    rows="{$pval[rows]|default:"4"}" 
    cols="{$pval[cols]|defalt:"30"}"
    {$eventText}
    >{$pval[default]|escape:html}</textarea>