{*
  Special event handlers for form fields
*}
{if $pval.Blur ne ""} onBlur="{$pval.Blur}"{/if}
{if $pval.Change ne ""} onChange="{$pval.Change}"{/if}
{if $pval.Click ne ""} onClick="{$pval.Click}"{/if}
{if $pval.MouseOver ne ""} onClick="{$pval.OnMouseOver}"{/if}
{if $pval.MouseOut ne ""} onClick="{$pval.OnMouseOut}"{/if}
{$pval.other}
