<?
  include("./help_header.php");

  $page_title = "GPL 2.0 Liscence";
  include("$libDir/nav.php");
?>
<br>
<table width="500" align="center">
<tr>
<td>

<? print nl2br(join("\n",file("$libDir/misc/LISCENCE-GPL-2.0"))); ?>

</td>
</tr>
</table>
<?
  include("$libDir/footer.php");
?>













