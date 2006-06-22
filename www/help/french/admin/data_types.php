<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    Les types de données représentent les propriétés de fiches dont l'administrateur    est autorisé à modifier la liste des choix possibles.
    
    <p>Un <?=tr('Bin')?> (dont il est parlé dans la section précédente) est un exemple    de type de données.
    
    <p>Les types de données peuvent être gérés en allant à  
      <b><?=tr('Admin')?> -&gt; <?=tr('Data Types')?></b> et en choisissant de modifier        le type de donnée approprié.
      
    <p>La colonne '<?=tr('Order')?>' peut être utilisée pour contrôler l'ordre dans    lequel les éléments sont listés. Le premier élément dans la liste sera celui défini    comme devant être pris par défaut quand ce type de donnée figuer dans menu de choix.</p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Retirer des éléments des types de données</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Une fois créé, l'élément dans les table de type de donnée     ne peut être détruit.</p>
    
    <p>Ceci afin de s'assurer que d'anciennes données ne sont pas compromises en
	enlevant un type de données qui est référencé ailleurs dans
	le système.</p>
    
    <p>Heureusement, tout n'est pas perdu.  Le désastre peut être évité
	en renommant le casier de manière plus utile ou en décochant
	la case à cocher de ' <?=tr('Active')?> ', qui empêchera le casier d'être
	employé à l'avenir.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Priorités</td>
</tr>
<tr>
  <td class='cell'>
    <p>Les éléments de priorités doivent avoir un ordre  de tri. Cette hierarchie    doit être numérotée de façon consécutive.
    
    <p>Les entrées non uttilisées ne nécessitent pas d'ordre de tri, elles seront    ignorées.
    
    <p>Si la couleur de priorité ne semble pas fonctionner correctement, verrifier    toujours la séquence d'ordre de tri.
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
