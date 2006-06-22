<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>	Les options personnelles repr�sentent des articles qui peuvent �tre trouv�s dans l'onglet 	 '<?=tr('Options')?>'. Cela consiste en des r�glages accessibles � un utilisateur.
    
    <p><b><?=tr('Change Password')?></b> - Utiliser cette option pour modifier votre mot de passe de connexion.
    Votre identifiant de connexion ne peut �tre modifi� que par l'administrateur.
    
    <p><b><?=tr('Change Default Bin')?></b> - Cette option peut �tre utilis�e pour changer    le casier qui est charg� lorsque vous vous connectez, ainsi que le casier s�lectionn�     par d�faut lorsque vous cr�ez de nouvelles fiches.
    
    <p><b><?=tr('Change Language')?></b> - Vous pouvez changer la langue d'affichage     de l'application ici. Cela ne change que votre param�trage de langue, et n'affecte en rien    le param�trage des autres utilisateurs.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
