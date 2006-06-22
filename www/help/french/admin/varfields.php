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
    <p>Les champs variables sont des champs qui peuvent être définis par
	votre organisation pour répondre aux besoins spéciaux.</p>
    
    <p>Les champs variables peuvent être des booléens (cases à cocher), des nombres,     des chaines de caractères (champs texte), de larges plages de texte, ou des dates</p>
    
    <p>La gestion des champs variables est accessible à :
    <br><?=tr('Admin')?> -&gt; <?=tr('Ticket Administration')?> -&gt; <?=tr('Edit Variable Fields')?>.
  </td>
</tr>
<tr>
  <td class='titleCell'>La table des champs variables</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>La colonne de projets ou de fiches doit toujours être cochée ou alors
	le champ variable ne sera visible nulle part.</p>
    
    Ce qui suit est une description de la page de gestion de champs varibles et de la façon     de procéder pour les configurer :
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
          Texte à afficher à l'attention des utilisateurs du système.
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Order')?></td>
        <td class='bars'>
          L'ordre d'affichage des champs variables (par défaut : l'étiquette)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Defaut')?></td>
        <td class='bars'>
          valeur par défaut pour le champ (une chaîne de caractères valide)
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
          affiche les champs utilisés dans les projets
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
          montre ces champs dans la fenêtre de recherche
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Lists')?></td>
        <td class='bars'>
          not utilisé (reservé pour une utilisation ultérieure)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Custom')?></td>
        <td class='bars'>
          Montre ces champs dans l'onglet personnalisé
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Details')?></td>
        <td class='bars'>
          montre les champs dans l'onglet détails
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('New')?></td>
        <td class='bars'>
          Montre ce champs dans la fenêtre '<?=tr('Create New')?>' 
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('JS Validation')?></td>
        <td class='bars'>
          non utilisé (réservé pour une utilisation ultérieure)
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
    <p class='error'>Cette tâche exige une bonne compréhension des bases de données
	relationnelles.  Ne pas essayer ceci si vous n'êtes pas
	expérimenté.  Au lieu de cela, contacter l'équipe de projet et
	demander de l'aide.</p>
    
    <p>Des colonnes supplémentaires à la table de ZENTRACK_VARFIELD doivent
	être appelées dans le format custom_ttttXX où tttt représente le
	type (menu, corde, nombre, booléen, date, ou texte) et XX représente
	le nombre consécutif (vous ne pouvez sauter aucun nombres).
    
    <p>Pour nos exemples ici, nous supposerons que nous voulons créer le
	nouveau champ <b>custom_menu3</b>.</p>
    
    <p><b>Step 1: SAUVEGARDE DE LA BASE DE DONNEES</b></p>
    <p>Créer une sauvegarde de  votre base de données
	de tout ce que vous désirez garder.</p>
    
    <p><b>Step 2: Ouvrir l'interface de gestion SQL de votre choix</b></p>
    
    <p><b>Step 3: Créer des champs dans la base</b></p>
    <p>Mettre en oeuvre sur votre base de donnée la commande équivalente à :
    <br>alter table ZENTRACK_VARFIELD add column custom_menu3 varchar(255);
    
    <p><b>Step 4: Ajouter une nouvelle ligne à  ZENTRACK_VARFIELD_IDX</b></p>
    <p>Mettre en oeuvre sur votre base de donnée la commande équivalente à :</p>
    <br>insert into ZENTRACK_VARFIELD_IDX (field_name, field_label) VALUES('custom_menu3', 'Custom Menu 3');
    
    <p><b>Step 5: Connectez vous à zentrack</b></p>
    <p>Il vous faut clore la fenêtre de navigation, et, ouvrir une nouvelle fenêtre et     vous connectez en tant qu'administrateur.
    
    <p><b>Step 6: Modifiez les règlages des champs variables</b></p>
    <p>Examinez les règlages des champs variables, et modifiez les propriétés de vos nouveaux champs.
  </td>
</tr>
</table>
<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
