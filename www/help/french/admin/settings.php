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
    <p>Le panneau de configuration contrôle mécanisme, l'aspect et le ressenti, et les     dispositifs globaux du système.</p>
    
    <p>Vous pouvez visualiser le panneau de configuration système en allant à :
    <br><?=tr('Admin')?> -&gt;
        <?=tr('Settings Administration')?> -&gt;
        <?=tr('Configuration Settings')?>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Sommaire des règlages.</td>
</tr>
<tr>
  <td class='cell'>
    <p>La plupart des règlages du système sont décrits en détail sur
	le panneau, tant et si bien qu'ici il n'est vraiment aucun besoin de réinventer
	la roue (nous ne sommes en tout cas, pas vraiment assez futés pour cette tâche).  
	Au lieu de cela, nous passerons en revue simplement certains des éléments 
	généralement utilisés et des considérations spéciales.</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Champ/Groupe</td>
        <td class='subTitle'>But</td>
      </tr>
      <tr>
        <td class='bars'>permet_*</td>
        <td class='bars'>
          Le champ permis peut être employé pour passer de diverses
			caractéristiques du système de on à off.
        </td>
      </tr>
      <tr>
        <td class='bars'>Ctrl_simple_psw</td>
        <td class='bars'>
          Si en fonciton, le système exigera des utilisateurs d'entrer les mots de
		passe qui contiennent des caractères qui ne soientpas des lettres tels que des
		nombres ou des symboles et exigent que la longueur du mot de passe soit 
		supérieure à 6 caractères..
        </td>
      </tr>
      <tr>
        <td class='bars'>couleur_*</td>
        <td class='bars'>
          Ces champs commandent l'aspect et la ressenti du site..
        </td>
      </tr>
      <tr>
        <td class='bars'>format_date_*</td>
        <td class='bars'>
          Commande le formatage et d'expression des dates.  Voir également
		l'utiisation de use_euro_date
          field.
        </td>
      </tr>
      <tr>
        <td class='bars'>defaut_*</td>
        <td class='bars'>
		Restitue les valeurs par défaut du formulaire.  Noter que les dates par
		défaut peuvent être laissées blanches pour que soient prises la valeur  
		blanc par défaut.
        </td>
      </tr>
      <tr>
        <td class='bars'>email_*</td>
        <td class='bars'>
          Contrôle quand et comment les courriels sont envoyés aux membres de la liste          d'information.
        </td>
      </tr>
      <tr>
        <td class='bars'>defaut_langage</td>
        <td class='bars'>
          Contrôle la langue par défaut qui est utilisée dans l'affichage. Les          utilisateurs peuvent changer cela dans le panneau de contrôle.
        </td>
      </tr>
      <tr>
        <td class='bars'>niveau_*</td>
        <td class='bars'>        Contrôle le niveau d'accès requis pour un utilisateur pour être autorisé        à accomplir une action donnée.
        </td>
      </tr>
      <tr>
        <td class='bars'>log_*</td>
        <td class='bars'>
          Contrôle si un dispositif donné, durant son activité, crée une entrée dans le journal.
        </td>
      </tr>
      <tr>
        <td class='bars'>raison_modification_obligatoire</td>
        <td class='bars'>
		Les activités de mise à jour des fiches peuvent faire l'objet d'un enregistrement
		dans le journal, si log_edit est à ON.		Mais si vous souhaitez obliger l'utilisateur à expliquer pourquoi la mise à jour		a lieu, il vous est nécessaire de placer raison_modification_obligatoire à ON aussi.		(Si log_edit est valorisé à OFF, alors raison_modification_obligatoire est ignoré).
        </td>
      </tr>
      <tr>
        <td class='bars'>paging_max_rows</td>
        <td class='bars'>
		Contrôle le nombre de lignes de données affichées lors des recherches et des 
		listes de fiches.        </td>
      </tr>
      <tr>
        <td class='bars'>priority_medium</td>
        <td class='bars'>
          Si cela est valorisé à zero, l'ombrage des priorité sera désactivé (          l'ombrage des priorité change la couleur des fiches dans la liste
		  en fonction de leur priorité).          
          <p>Valorisé cela à peu près à 1/2 du nombre total d'entrées de priorités           pour un ombrage optimal).
        </td>
      </tr>
      <tr>
        <td class='bars'>system_name</td>
        <td class='bars'>
          Utilisez cela pour remplacer le nom du système de suivi qui sera affiché           aux utilisateurs.
        </td>
      </tr>
      <tr>
        <td class='bars'>time_elapsed_unit</td>
        <td class='bars'>
		Contrôle l'untié de temps utilisée dans le champ durée sur une fiche. Les 
		valeurs correctes sont des choses telles que : seconds, minutes, hours, days, 
		month, etc.         </td>
      </tr>
      <tr>
        <td class='bars'>url_view_*</td>
        <td class='bars'>
		Peut être utilisé pour remplacer les pages utilisées pour visualiser les 
		pièces jointes et les fiches. C'est utilisé uniquement par des administrateurs
		avertis qui souhaitent modifier le système et créer des pages personnalisées 		de visualisation des pièces jointes          </td>
      </tr>
      <tr>
        <td class='bars'>use_euro_date</td>
        <td class='bars'>
          A l'état ON les dates sont examinée et mise en forme selon le format européen          (jj/mm/aaaa) plutôt que qu'au format des Etats Unis (mm/dd/yyyy). Tous les           autres formats de date ne sont pas concernés.
        </td>
      </tr>
      <tr>
        <td class='bars'>varfield_tab_name</td>
        <td class='bars'>
          Permet de fixer le nom l'onglet qui contient les champs variables (personnalisés).
        </td>
      </tr>
      <tr>
        <td class='bars'>version</td>
        <td class='bars'>
          Le numéro de la version courant de ZenTrack.
        </td>
      </tr>      
    </table>
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
