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
    <p>Un projet ne peut �tre clos, tant que toutes les fiches et tous les sous-projets qu'il 
    contient ne sont pas eux memes ferm�s.
    
    <p>Au del� de ces pr�cisions, et de l'existance de l'onglet '<?=tr('Tasks')?>'
    fiches et projets sont techniquement deux notions identiques.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>