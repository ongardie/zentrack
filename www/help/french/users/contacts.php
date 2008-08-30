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
    Les contacts sont simplement des sociétés ou des individus qui peuvent être mis en relation    avec les fiche, ou placés dans les listes d'information, mais n'ayant pas à se connecter
	à <?=$zen->getSetting('system_name')?>.
    
    <p>Une société contact peut avoir plusieurs individus "contact" qui lui soient associés.
    
    <p>Les contacts peuvent être liés au fiches et utilisés comme moyen de regrouper les fiches par 
    client ou société.  </td>
</tr>
<tr>
  <td class='titleCell'>Autorisation</td>
</tr>
<tr>
  <td class='cell'>	Les autorisations représentent des contrats, des accords de support, ou autres accords entre	votre organisation et un contact.
    
    <p>Les articles d'une autorisation représentent les accords spécifiques ou les conditions associées 
    à l'autorisation.  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
