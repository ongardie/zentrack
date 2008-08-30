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
    Les casiers sont utilis�s pour organiser les fiches dans des groupes logiques et pour    controler l'acces des utilisateurs lors de leur visuallisation et modification des fiches.
    
    <p>Un casier peut correspondre � un d�partemenet, un groupe de travail, ou tout autre    structure organisationnelle pour votre activit�.</p>
    
    <p>Les casiers sont g�r�s en allant sur 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Data Types')?> -&gt;
      <?=tr('Bins')?></b></p>
    
    <p>Les droits d'acc�s aux casiers sont g�r�s par : 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Edit Users')?> -&gt;
      Find User to Edit  -&gt;
      Access Link</b></p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Cr�ation et modifications de casiers</td>
</tr>
<tr>
  <td class='cell'>
    Le plus grand soin est de rigueur lors de la cr�ation et la modification des
	casiers.
    
    <p class='error'>Une fois cr�� un casier ne peut �tre d�truit.</p>
    
    <p>Se reporter � Documentation des types de donn�es (
    <a href='<?=$adminUrl?>/data_types.php'>section suivante</a>) 
    pour plus d'inofrmation sur la fa�on d'enlever les anciens types de donn�es.</p>
    
  </td>
</tr>
<tr>
  <td class='titleCell'>Configuration d'acc�s : Un cas d'�cole</td>
</tr>
<tr>
  <td class='cell'>
    <p>Ce qui suit est un exemple simple de la fa�on cr�er un ensemble de
	casiers assez complexe et acc�der � des priviledges pour un petit
	groupe d'utilisateurs.</p>
    
    <p>Notre compagnie d'essai, ci-apr�s appel�e ' Test Company A ' (la
	cr�ativit�!  le g�nie pur!)  contient trois groupes distincts,
	repr�sent�s par le groupe suivant des employ�s:</p>
    
    <table width='80%' align='center'>
    <tr>
      <td colspan='3' class='labelCell' align='center'>Exemple d'utilisateurs</td>
    </tr>
    <tr>
      <td class='subTitle'>Nom</td>
      <td class='subTitle'>Fonction</td>
      <td class='subTitle'>Notes</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>Manager</td>
      <td class='bars'>Manage � la fois John et Mark</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>Vendeur</td>
      <td class='bars'>Utilise le Syst�me de suivi pour g�rer les licenses et les
	contrats  client.</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>Programmeur</td>
      <td class='bars'>D�veloppe le logiciel, fournit l'appui de niveau �lev� pour le
		groupe de soutien de client, d�teste les vendeurs, les tient pour des
		d�mons.</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>Suport client</td>
      <td class='bars'>Prend les appels t�l�phoniques et cr�e des demandes d'intervention pour les vendeurs
	et les d�veloppeurs.</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>Comptabilit�</td>
      <td class='bars'>Doit avoir acc�s � tous les fichiers pour les besoins  de la
	facturation.  Assure la paie de tous, et veille � leur bonheur.
</td>
    </tr>
    </table>
    
    <p>Il est �vident que nous ayons besoin de trois casiers, que nous
	appellerons des ventes, support, et d�veloppement.</p>
    
    <p>On peut facilement d�river quelques privil�ges id�aux d'acc�s de
	cet exemple simpliste:</p>
    
    <table width='80%' align='center'>
    <tr>
      <td colspan='3' class='labelCell' align='center'>Privil�ges id�aux</td>
    </tr>
    <tr>
      <td class='subTitle'>Utilisateur</td>
      <td class='subTitle'>Casiers accessibles</td>
      <td class='subTitle'>Notes</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>Ventes, D�veloppement</td>
      <td class='bars'>&nbsp;</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>Ventes</td>
      <td class='bars'>&nbsp;</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>Support, Developpement</td>
      <td class='bars'>Lecture seule pour le support</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>Support, Ventes, Developpement</td>
      <td class='bars'>Lecture seule pour Ventes et Developpement</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>Tous les casiers</td>
      <td class='bars'>Lecture seule</td>
    </tr>
    </table>
    
    <p>Mark doit seulement pouvoir regarder les fiches dans le casier
	de support, et Sue doit seulement pouvoir exp�dier des fiches aux
	casiers de ventes et de d�veloppement (ainsi � elle a besoin de
	l'acc�s en lecture.</p>
    
    <p>Mary, naturellement, n'a pas vraiment beaucoup d'autre utilisation du 
	syst�me que de regarder des heures travaill�es sur les divers
	projets.</p>
    
    Ainsi voici ce que nous devons r�aliser afin d'organiser les droits d'acc�s
	au sein de Test Company A..
    
    <p><b>Step 1: Niveaux d'acc�s globaux</b></p>
    
    <p>Nous commen�ons notre p�riple par 
      <b><?=tr('Admin')?> -&gt;
      <?=tr('Settings Administration')?> -&gt;
      <?=tr('Configuration Settings')?></b>.  
	Ici nous �diterons les propri�t�s de level_* pour �tablir les besoins de Test Company A
      
    <table width='80%' align='center'>
    <tr><td colspan='3'  class='labelCell' align='center'>Param�tres et r�glages</td></tr>
    <tr>
      <td class='subTitle'>r�glage</td>
      <td class='subTitle'>nouvelle valeur</td>
      <td class='subTitle'>raison</td>
    </tr>
    <tr>
      <td class='bars'>niveau de visualisation</td>
      <td class='bars'>1</td>
      <td class='bars'>Annihile les droits de visualisaiton par d�faut</td>
    </tr>
    <tr>
      <td class='bars'>Niveau tranfert</td>
      <td class='bars'>1</td>
      <td class='bars'>Quiconque avec des droites de visualisation peut maintenant d�placer une
	fiche</td>
    </tr>
    <tr>
      <td class='bars'>Niveau cr�ation</td>
      <td class='bars'>1</td>
      <td class='bars'>Quiconque avec des droites de visualisation peut maintenant cr�er une fiche</td>
    </tr>
    </table>
    
    <p>Une fois que nos priviledges globaux sont install�s, nous proc�dons
	maintenant l' administration dess utilisateur, ce qui pourrait  faire que nos
	utilisateurs ressemblent � ceci :
    
    <table width='80%' align='center'>
    <tr><td colspan='5' class='labelCell' align='center'>Droits d'acc�s</td></tr>
    <tr>
      <td class='subTitle'>Utilisateur</td>
      <td class='subTitle'>Defaut</td>
      <td class='subTitle'>Ventes</td>
      <td class='subTitle'>Support</td>
      <td class='subTitle'>Developpement</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>2</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>1</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>0</td>
      <td class='bars'>2</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>0</td>
      <td class='bars'>-</td>
      <td class='bars'>2</td>
      <td class='bars'>1</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>1</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>2</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>1</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
    </tr>
    </table>
    
    <p>Maintenant que nous avons install� nos utilisateurs correctement et les avons
	rendus op�rationnels, il est trop dommage de tenir les ventes et les
	d�veloppeur � l'�cart, dans la vraie vie �a ne serait pas si simple!</p>
    
  </td>    
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
