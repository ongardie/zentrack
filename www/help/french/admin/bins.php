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
    Les casiers sont utilisés pour organiser les fiches dans des groupes logiques et pour    controler l'acces des utilisateurs lors de leur visuallisation et modification des fiches.
    
    <p>Un casier peut correspondre à un départemenet, un groupe de travail, ou tout autre    structure organisationnelle pour votre activité.</p>
    
    <p>Les casiers sont gérés en allant sur 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Data Types')?> -&gt;
      <?=tr('Bins')?></b></p>
    
    <p>Les droits d'accès aux casiers sont gérés par : 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Edit Users')?> -&gt;
      Find User to Edit  -&gt;
      Access Link</b></p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Création et modifications de casiers</td>
</tr>
<tr>
  <td class='cell'>
    Le plus grand soin est de rigueur lors de la création et la modification des
	casiers.
    
    <p class='error'>Une fois créé un casier ne peut être détruit.</p>
    
    <p>Se reporter à Documentation des types de données (
    <a href='<?=$adminUrl?>/data_types.php'>section suivante</a>) 
    pour plus d'inofrmation sur la façon d'enlever les anciens types de données.</p>
    
  </td>
</tr>
<tr>
  <td class='titleCell'>Configuration d'accès : Un cas d'école</td>
</tr>
<tr>
  <td class='cell'>
    <p>Ce qui suit est un exemple simple de la façon créer un ensemble de
	casiers assez complexe et accéder à des priviledges pour un petit
	groupe d'utilisateurs.</p>
    
    <p>Notre compagnie d'essai, ci-après appelée ' Test Company A ' (la
	créativité!  le génie pur!)  contient trois groupes distincts,
	représentés par le groupe suivant des employés:</p>
    
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
      <td class='bars'>Manage à la fois John et Mark</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>Vendeur</td>
      <td class='bars'>Utilise le Système de suivi pour gérer les licenses et les
	contrats  client.</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>Programmeur</td>
      <td class='bars'>Développe le logiciel, fournit l'appui de niveau élevé pour le
		groupe de soutien de client, déteste les vendeurs, les tient pour des
		démons.</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>Suport client</td>
      <td class='bars'>Prend les appels téléphoniques et crée des demandes d'intervention pour les vendeurs
	et les développeurs.</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>Comptabilité</td>
      <td class='bars'>Doit avoir accès à tous les fichiers pour les besoins  de la
	facturation.  Assure la paie de tous, et veille à leur bonheur.
</td>
    </tr>
    </table>
    
    <p>Il est évident que nous ayons besoin de trois casiers, que nous
	appellerons des ventes, support, et développement.</p>
    
    <p>On peut facilement dériver quelques privilèges idéaux d'accès de
	cet exemple simpliste:</p>
    
    <table width='80%' align='center'>
    <tr>
      <td colspan='3' class='labelCell' align='center'>Privilèges idéaux</td>
    </tr>
    <tr>
      <td class='subTitle'>Utilisateur</td>
      <td class='subTitle'>Casiers accessibles</td>
      <td class='subTitle'>Notes</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>Ventes, Développement</td>
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
	de support, et Sue doit seulement pouvoir expédier des fiches aux
	casiers de ventes et de développement (ainsi à elle a besoin de
	l'accès en lecture.</p>
    
    <p>Mary, naturellement, n'a pas vraiment beaucoup d'autre utilisation du 
	système que de regarder des heures travaillées sur les divers
	projets.</p>
    
    Ainsi voici ce que nous devons réaliser afin d'organiser les droits d'accès
	au sein de Test Company A..
    
    <p><b>Step 1: Niveaux d'accès globaux</b></p>
    
    <p>Nous commençons notre périple par 
      <b><?=tr('Admin')?> -&gt;
      <?=tr('Settings Administration')?> -&gt;
      <?=tr('Configuration Settings')?></b>.  
	Ici nous éditerons les propriétés de level_* pour établir les besoins de Test Company A
      
    <table width='80%' align='center'>
    <tr><td colspan='3'  class='labelCell' align='center'>Paramètres et règlages</td></tr>
    <tr>
      <td class='subTitle'>règlage</td>
      <td class='subTitle'>nouvelle valeur</td>
      <td class='subTitle'>raison</td>
    </tr>
    <tr>
      <td class='bars'>niveau de visualisation</td>
      <td class='bars'>1</td>
      <td class='bars'>Annihile les droits de visualisaiton par défaut</td>
    </tr>
    <tr>
      <td class='bars'>Niveau tranfert</td>
      <td class='bars'>1</td>
      <td class='bars'>Quiconque avec des droites de visualisation peut maintenant déplacer une
	fiche</td>
    </tr>
    <tr>
      <td class='bars'>Niveau création</td>
      <td class='bars'>1</td>
      <td class='bars'>Quiconque avec des droites de visualisation peut maintenant créer une fiche</td>
    </tr>
    </table>
    
    <p>Une fois que nos priviledges globaux sont installés, nous procédons
	maintenant l' administration dess utilisateur, ce qui pourrait  faire que nos
	utilisateurs ressemblent à ceci :
    
    <table width='80%' align='center'>
    <tr><td colspan='5' class='labelCell' align='center'>Droits d'accès</td></tr>
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
    
    <p>Maintenant que nous avons installé nos utilisateurs correctement et les avons
	rendus opérationnels, il est trop dommage de tenir les ventes et les
	développeur à l'écart, dans la vraie vie ça ne serait pas si simple!</p>
    
  </td>    
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
