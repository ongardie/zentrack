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
    Les contacts sont simplement des soci�t�s ou des individus qui peuvent �tre mis en relation    avec les fiche, ou plac�s dans les listes d'information, mais n'ayant pas � se connecter
	� <?=$zen->getSetting('system_name')?>.
    
    <p>Une soci�t� contact peut avoir plusieurs individus "contact" qui lui soient associ�s.
    
    <p>Les contacts peuvent �tre li�s au fiches et utilis�s comme moyen de regrouper les fiches par 
    client ou soci�t�.  </td>
</tr>
<tr>
  <td class='titleCell'>Autorisation</td>
</tr>
<tr>
  <td class='cell'>	Les autorisations repr�sentent des contrats, des accords de support, ou autres accords entre	votre organisation et un contact.
    
    <p>Les articles d'une autorisation repr�sentent les accords sp�cifiques ou les conditions associ�es 
    � l'autorisation.  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
