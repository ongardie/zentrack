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
    <p>Les champs variables sont des champs qui peuvent �tre d�finis par
	votre organisation pour r�pondre aux besoins sp�ciaux.</p>
    
    <p>Les champs variables peuvent �tre des bool�ens (cases � cocher), des nombres,     des chaines de caract�res (champs texte), de larges plages de texte, ou des dates</p>
    
    <p>La gestion des champs variables est accessible � :
    <br><?=tr('Admin')?> -&gt; <?=tr('Ticket Administration')?> -&gt; <?=tr('Edit Variable Fields')?>.
  </td>
</tr>
<tr>
  <td class='titleCell'>La table des champs variables</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>La colonne de projets ou de fiches doit toujours �tre coch�e ou alors
	le champ variable ne sera visible nulle part.</p>
    
    Ce qui suit est une description de la page de gestion de champs varibles et de la fa�on     de proc�der pour les configurer :
     <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Champs</td>
        <td class='subTitle'>Description</td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Field Name')?></td>
        <td class='bars'>
          must match column in database
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Field Label')?></td>
        <td class='bars'>
          Texte � afficher � l'attention des utilisateurs du syst�me.
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Order')?></td>
        <td class='bars'>
          L'ordre d'affichage des champs variables (par d�faut : l'�tiquette)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Defaut')?></td>
        <td class='bars'>
          valeur par d�faut pour le champ (une cha�ne de caract�res valide)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Requis')?></td>
        <td class='bars'>
          ce champ est il obligatoire?
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Projets')?></td>
        <td class='bars'>
          affiche les champs utilis�s dans les projets
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Tickets')?></td>
        <td class='bars'>
          affiche ces champs dans les fiches
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Searches')?></td>
        <td class='bars'>
          montre ces champs dans la fen�tre de recherche
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Lists')?></td>
        <td class='bars'>
          not utilis� (reserv� pour une utilisation ult�rieure)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Custom')?></td>
        <td class='bars'>
          Montre ces champs dans l'onglet personnalis�
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Details')?></td>
        <td class='bars'>
          montre les champs dans l'onglet d�tails
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('New')?></td>
        <td class='bars'>
          Montre ce champs dans la fen�tre '<?=tr('Create New')?>' 
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('JS Validation')?></td>
        <td class='bars'>
          non utilis� (r�serv� pour une utilisation ult�rieure)
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td class='titleCell'>Ajout de nouveau champ variable</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Cette t�che exige une bonne compr�hension des bases de donn�es
	relationnelles.  Ne pas essayer ceci si vous n'�tes pas
	exp�riment�.  Au lieu de cela, contacter l'�quipe de projet et
	demander de l'aide.</p>
    
    <p>Des colonnes suppl�mentaires � la table de ZENTRACK_VARFIELD doivent
	�tre appel�es dans le format custom_ttttXX o� tttt repr�sente le
	type (menu, corde, nombre, bool�en, date, ou texte) et XX repr�sente
	le nombre cons�cutif (vous ne pouvez sauter aucun nombres).
    
    <p>Pour nos exemples ici, nous supposerons que nous voulons cr�er le
	nouveau champ <b>custom_menu3</b>.</p>
    
    <p><b>Step 1: SAUVEGARDE DE LA BASE DE DONNEES</b></p>
    <p>Cr�er une sauvegarde de  votre base de donn�es
	de tout ce que vous d�sirez garder.</p>
    
    <p><b>Step 2: Ouvrir l'interface de gestion SQL de votre choix</b></p>
    
    <p><b>Step 3: Cr�er des champs dans la base</b></p>
    <p>Mettre en oeuvre sur votre base de donn�e la commande �quivalente � :
    <br>alter table ZENTRACK_VARFIELD add column custom_menu3 varchar(255);
    
    <p><b>Step 4: Ajouter une nouvelle ligne �  ZENTRACK_VARFIELD_IDX</b></p>
    <p>Mettre en oeuvre sur votre base de donn�e la commande �quivalente � :</p>
    <br>insert into ZENTRACK_VARFIELD_IDX (field_name, field_label) VALUES('custom_menu3', 'Custom Menu 3');
    
    <p><b>Step 5: Connectez vous � zentrack</b></p>
    <p>Il vous faut clore la fen�tre de navigation, et, ouvrir une nouvelle fen�tre et     vous connectez en tant qu'administrateur.
    
    <p><b>Step 6: Modifiez les r�glages des champs variables</b></p>
    <p>Examinez les r�glages des champs variables, et modifiez les propri�t�s de vos nouveaux champs.
  </td>
</tr>
</table>
<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
