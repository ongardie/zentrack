
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <input type="text"
    name="{$pval.name}"
    size="{$pval.len|default:"20"}" 
    maxlength="{$pval.size|default:"200"}" 
    value="{$pval.default|escape:html}">

  <input type="button" 
    name="{$pval.name}Button"
    value="..."
    {$eventText}>