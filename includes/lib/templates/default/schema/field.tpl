<!--
  The special variable {style} is set by the
  gen_schema_docs target for each row, and equals
  either 'rowA' or 'rowB' (alternating rows)

  The special variable {cell} is set by
  the gen_schema_docs target for each row, and
  equals either 'cellAbstract' or 'cellNormal', to indicate
  whether this cell was inherited or is part of this
  table.

  The styles for these two classes are set in header.template
-->
<tr class='{pval[style]}'>
 <td class='{pval[cell]}'>{if:pval[name]:pval[name]}</td>
 <td class='{pval[cell]}'>{pval[type]}</td>
 <td class='{pval[cell]}'>{pval[label]="&nbsp;"}&nbsp;</td>
 <td class='{pval[cell]}'>{pval[reference]="&nbsp;"}</td>
 <td class='{pval[cell]}'>{pval[ftype]}</td>
 <td class='{pval[cell]}'>{pval[order]="&nbsp;"}</td>
 <td class='{pval[cell]}'>
   {if:pval[description]:"<pre>"+pval[description]+"</pre>\n"}
   {if:pval[notnull]:"not null, "}
   {if:pval[unique]:"unique, "}
   {if:pval[required]:"required, "}
   {if:pval[custom]:"custom, "}
   {if:pval[size]:"size="+pval[size]+", "}
   {if:pval[namefield]:"namefield="+pval[namefield]+", "}
   {if:pval[default]:"<br>Default='"+pval[default]+"'\n"}
   {if:pval[criteria]:"<br>Criteria&#58;<pre>"+pval[criteria]+"</pre>\n"}
   &nbsp;
 </td>
</tr>