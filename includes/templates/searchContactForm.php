<? if( !ZT_DEFINED ) { die("Illegal Access"); } 
  $hkc = $hotkeys->activateField("Companies", 'searchCompany', 'search_text');
  $hke = $hotkeys->activateField("Employees", 'searchEmployee', 'search_text');
  $hka = $hotkeys->activateField("Agreements", 'searchAgreement', 'search_text');
  $hki = $hotkeys->activateField("Items", 'searchItem', 'search_text');
?>


<form action="<?=($SCRIPT_NAME)?>" name="searchCompany">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?=tr("Search ?", $hkc->getLabel())?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="company">
	</td>
	<td class="bars">
		<input type="text" name="search_text" title="<?=$hkc->getTooltip()?>"
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?=($SCRIPT_NAME)?>" name="searchEmployee">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?=tr("Search ?", $hke->getLabel())?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="employee">
	</td>
	<td class="bars">
		<input type="text" name="search_text" title="<?=$hke->getTooltip()?>" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?=($SCRIPT_NAME)?>" name="searchAgreement">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?=tr("Search ?", $hka->getLabel())?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="agreement">
	</td>
	<td class="bars">
		<input type="text" name="search_text" title="<?=$hka->getTooltip()?>" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?=($SCRIPT_NAME)?>" name="searchItem">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?=tr("Search ?", $hki->getLabel())?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="item">
	</td>
	<td class="bars">
		<input type="text" name="search_text"  title="<?=$hki->getTooltip()?>"
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
  
</tr>
</table>
</form>