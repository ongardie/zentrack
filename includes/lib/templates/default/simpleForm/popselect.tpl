{*
        //todo
        //todo set source table and field
        //todo set dest table and field
        //todo pass criteria and reference
        //todo set label or title... have
        //todo popselect util take care of
        //todo permissions, form generation
        //todo and returning selected value
        //todo
        //todo use a standard format for our popup
        //todo field types:
        //todo    open new window,
        //todo    pass source/dest table/field by session
        //todo    pass calling form field via url
        //todo    have popup return value to form by reading
        //todo      field type and taking appropriate action
        //todo
        //todo probably include to handle javascript for returning
        //todo value and reading the incoming parms.
        //todo
*}
  {include file="simpleForm/fieldEvents.tpl" assign="eventText"}
  <input type="text"
    name="{$pval.name}"
    size="{$pval.len|default:20}" 
    maxlength="{$pval.size|default:200}" 
    value="{$pval.default|escape:html}">

  <input type="button" 
    name="{$pval.name}Button"
    value="..."
    {$eventText}>