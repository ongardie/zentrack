
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <textarea
    name="{$pval.name}"
    cols="{$pval.cols|default:40}"
    rows="{$pval.rows|default:20}">{$pval.default|escape:html}</textarea>
  &nbsp;
  <input type="button" 
    name="{$pval.name}Button"
    value="..."
    {$eventText}>