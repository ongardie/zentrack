<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>	Les projets contiennent et regroupent des fiches traitant de domaines semblables.	Si, par exemple, construire un ordinateur était un projet, alors, la fiche liée à ce 	projet pourrait être l'achat des composants, leur assemblage, l'installation du système	d'exploitation et d'appliquer une modification précise. (Ce dernier point étant de haute	priorité.)
    <p>Un projet ne peut être clos, tant que toutes les fiches et tous les sous-projets qu'il 
    contient ne sont pas eux memes fermés.
    
    <p>Au delà de ces précisions, et de l'existance de l'onglet '<?=tr('Tasks')?>'
    fiches et projets sont techniquement deux notions identiques.
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
