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
    Les types de donn�es repr�sentent les propri�t�s de fiches dont l'administrateur
    
    <p>Un <?=tr('Bin')?> (dont il est parl� dans la section pr�c�dente) est un exemple
    
    <p>Les types de donn�es peuvent �tre g�r�s en allant �  
      <b><?=tr('Admin')?> -&gt; <?=tr('Data Types')?></b> et en choisissant de modifier  
      
    <p>La colonne '<?=tr('Order')?>' peut �tre utilis�e pour contr�ler l'ordre dans
  </td>    
</tr>
<tr>
  <td class='titleCell'>Retirer des �l�ments des types de donn�es</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Une fois cr��, l'�l�ment dans les table de type de donn�e 
    
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
    <p>Les �l�ments de priorit�s doivent avoir un ordre  de tri. Cette hierarchie
    
    <p>Les entr�es non uttilis�es ne n�cessitent pas d'ordre de tri, elles seront
    
    <p>Si la couleur de priorit� ne semble pas fonctionner correctement, verrifier
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>