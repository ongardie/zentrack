<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>	Les options personnelles représentent des articles qui peuvent être trouvés dans l'onglet 	 '<?=tr('Options')?>'. Cela consiste en des règlages accessibles à un utilisateur.
    
    <p><b><?=tr('Change Password')?></b> - Utiliser cette option pour modifier votre mot de passe de connexion.
    Votre identifiant de connexion ne peut être modifié que par l'administrateur.
    
    <p><b><?=tr('Change Default Bin')?></b> - Cette option peut être utilisée pour changer    le casier qui est chargé lorsque vous vous connectez, ainsi que le casier sélectionné     par défaut lorsque vous créez de nouvelles fiches.
    
    <p><b><?=tr('Change Language')?></b> - Vous pouvez changer la langue d'affichage     de l'application ici. Cela ne change que votre paramètrage de langue, et n'affecte en rien    le paramètrage des autres utilisateurs.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
