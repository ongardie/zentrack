<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    Les contacts sont simplement des soci�t�s ou des individus qui peuvent �tre mis en relation
	� <?=$zen->getSetting('system_name')?>.
    
    <p>Une soci�t� contact peut avoir plusieurs individus "contact" qui lui soient associ�s.
    
    <p>Les contacts peuvent �tre li�s au fiches et utilis�s comme moyen de regrouper les fiches par 
    client ou soci�t�.
</tr>
<tr>
  <td class='titleCell'>Autorisation</td>
</tr>
<tr>
  <td class='cell'>
    
    <p>Les articles d'une autorisation repr�sentent les accords sp�cifiques ou les conditions associ�es 
    � l'autorisation.
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>