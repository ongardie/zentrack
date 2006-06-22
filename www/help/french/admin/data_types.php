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
    Les types de donn�es repr�sentent les propri�t�s de fiches dont l'administrateur    est autoris� � modifier la liste des choix possibles.
    
    <p>Un <?=tr('Bin')?> (dont il est parl� dans la section pr�c�dente) est un exemple    de type de donn�es.
    
    <p>Les types de donn�es peuvent �tre g�r�s en allant �  
      <b><?=tr('Admin')?> -&gt; <?=tr('Data Types')?></b> et en choisissant de modifier        le type de donn�e appropri�.
      
    <p>La colonne '<?=tr('Order')?>' peut �tre utilis�e pour contr�ler l'ordre dans    lequel les �l�ments sont list�s. Le premier �l�ment dans la liste sera celui d�fini    comme devant �tre pris par d�faut quand ce type de donn�e figuer dans menu de choix.</p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Retirer des �l�ments des types de donn�es</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Une fois cr��, l'�l�ment dans les table de type de donn�e     ne peut �tre d�truit.</p>
    
    <p>Ceci afin de s'assurer que d'anciennes donn�es ne sont pas compromises en
	enlevant un type de donn�es qui est r�f�renc� ailleurs dans
	le syst�me.</p>
    
    <p>Heureusement, tout n'est pas perdu.  Le d�sastre peut �tre �vit�
	en renommant le casier de mani�re plus utile ou en d�cochant
	la case � cocher de ' <?=tr('Active')?> ', qui emp�chera le casier d'�tre
	employ� � l'avenir.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Priorit�s</td>
</tr>
<tr>
  <td class='cell'>
    <p>Les �l�ments de priorit�s doivent avoir un ordre  de tri. Cette hierarchie    doit �tre num�rot�e de fa�on cons�cutive.
    
    <p>Les entr�es non uttilis�es ne n�cessitent pas d'ordre de tri, elles seront    ignor�es.
    
    <p>Si la couleur de priorit� ne semble pas fonctionner correctement, verrifier    toujours la s�quence d'ordre de tri.
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
