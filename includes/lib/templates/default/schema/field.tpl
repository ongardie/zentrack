{*
  The special variable 'style' is set by the
  gen_schema_docs target for each row, and equals
  either 'rowA' or 'rowB' (alternating rows)

  The special variable 'cell' is set by
  the gen_schema_docs target for each row, and
  equals either 'cellAbstract' or 'cellNormal', to indicate
  whether this cell was inherited or is part of this
  table.

  The styles for these two classes are set in header.template
*}
<tr class='{$pval.style}'>
 <td class='{$pval.cell}'>{$pval.name|default:"&nbsp;"}</td>
 <td class='{$pval.cell}'>{$pval.type}</td>
 <td class='{$pval.cell}'>{$pval.label|default:"&nbsp;"}</td>
 <td class='{$pval.cell}'>{$pval.reference|default:"&nbsp;"}</td>
 <td class='{$pval.cell}'>{$pval.ftype}</td>
 <td class='{$pval.cell}'>{$pval.order|default:"&nbsp;"}</td>
 <td class='{$pval.cell}'>
   {if $pval.description ne ""}<pre>{$pval.description}</pre>{/if}
   {if $pval.notnull ne ""}not null, "{/if}
   {if $pval.unique ne ""}unique, "{/if}
   {if $pval.required ne ""}required, "{/if}
   {if $pval.custom ne ""}custom, "{/if}
   {if $pval.size ne ""}size={$pval.size}, "{/if}
   {if $pval.namefield ne ""}namefield={$pval.namefield}, "{/if}
   {if $pval.default ne ""}<br>Default='{$pval.default}'{/if}
   {if $pval.criteria ne ""}
     <br>Criteria:<pre>{$pval.criteria}</pre>
   {/if}
   &nbsp;
 </td>
</tr>