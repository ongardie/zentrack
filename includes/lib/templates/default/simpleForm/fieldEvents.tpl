{*
  Special event handlers for form fields
*}
{if $pval.Blur ne ""} onBlur="{$pval.Blur}"{/if}
{if $pval.Change ne ""} onChange="{$pval.Change}"{/if}
{if $pval.Click ne ""} onClick="{$pval.Click}"{/if}
{if $pval.MouseOver ne ""} onClick="{$pval.MouseOver}"{/if}
{if $pval.MouseOut ne ""} onClick="{$pval.MouseOut}"{/if}
{$pval.other}
