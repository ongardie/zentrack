{*
  Special event handlers for form fields
*}
{if $pval[onBlur] ne ""} onBlur="{$pval[onBlur]}"{/if}
{if $pval[onChange] ne ""} onChange="{$pval[onChange]}"{/if}
{if $pval[onClick] ne ""} onClick="{$pval[onClick]}"{/if}
{if $pval[onMouseOver] ne ""} onClick="{$pval[onOnMouseOver]}"{/if}
{if $pval[onMouseOut] ne ""} onClick="{$pval[onOnMouseOut]}"{/if}
{$pval[other]}
