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
    
    <p><b><?=tr('Change Password')?></b> - Utiliser cette option pour modifier votre mot de passe de connexion.
    Votre identifiant de connexion ne peut �tre modifi� que par l'administrateur.
    
    <p><b><?=tr('Change Default Bin')?></b> - Cette option peut �tre utilis�e pour changer
    
    <p><b><?=tr('Change Language')?></b> - Vous pouvez changer la langue d'affichage 
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>