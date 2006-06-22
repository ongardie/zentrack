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
    <p>Le panneau de configuration contr�le m�canisme, l'aspect et le ressenti, et les     dispositifs globaux du syst�me.</p>
    
    <p>Vous pouvez visualiser le panneau de configuration syst�me en allant � :
    <br><?=tr('Admin')?> -&gt;
        <?=tr('Settings Administration')?> -&gt;
        <?=tr('Configuration Settings')?>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Sommaire des r�glages.</td>
</tr>
<tr>
  <td class='cell'>
    <p>La plupart des r�glages du syst�me sont d�crits en d�tail sur
	le panneau, tant et si bien qu'ici il n'est vraiment aucun besoin de r�inventer
	la roue (nous ne sommes en tout cas, pas vraiment assez fut�s pour cette t�che).  
	Au lieu de cela, nous passerons en revue simplement certains des �l�ments 
	g�n�ralement utilis�s et des consid�rations sp�ciales.</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Champ/Groupe</td>
        <td class='subTitle'>But</td>
      </tr>
      <tr>
        <td class='bars'>permet_*</td>
        <td class='bars'>
          Le champ permis peut �tre employ� pour passer de diverses
			caract�ristiques du syst�me de on � off.
        </td>
      </tr>
      <tr>
        <td class='bars'>Ctrl_simple_psw</td>
        <td class='bars'>
          Si en fonciton, le syst�me exigera des utilisateurs d'entrer les mots de
		passe qui contiennent des caract�res qui ne soientpas des lettres tels que des
		nombres ou des symboles et exigent que la longueur du mot de passe soit 
		sup�rieure � 6 caract�res..
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
          Commande le formatage et d'expression des dates.  Voir �galement
		l'utiisation de use_euro_date
          field.
        </td>
      </tr>
      <tr>
        <td class='bars'>defaut_*</td>
        <td class='bars'>
		Restitue les valeurs par d�faut du formulaire.  Noter que les dates par
		d�faut peuvent �tre laiss�es blanches pour que soient prises la valeur  
		blanc par d�faut.
        </td>
      </tr>
      <tr>
        <td class='bars'>email_*</td>
        <td class='bars'>
          Contr�le quand et comment les courriels sont envoy�s aux membres de la liste          d'information.
        </td>
      </tr>
      <tr>
        <td class='bars'>defaut_langage</td>
        <td class='bars'>
          Contr�le la langue par d�faut qui est utilis�e dans l'affichage. Les          utilisateurs peuvent changer cela dans le panneau de contr�le.
        </td>
      </tr>
      <tr>
        <td class='bars'>niveau_*</td>
        <td class='bars'>        Contr�le le niveau d'acc�s requis pour un utilisateur pour �tre autoris�        � accomplir une action donn�e.
        </td>
      </tr>
      <tr>
        <td class='bars'>log_*</td>
        <td class='bars'>
          Contr�le si un dispositif donn�, durant son activit�, cr�e une entr�e dans le journal.
        </td>
      </tr>
      <tr>
        <td class='bars'>raison_modification_obligatoire</td>
        <td class='bars'>
		Les activit�s de mise � jour des fiches peuvent faire l'objet d'un enregistrement
		dans le journal, si log_edit est � ON.		Mais si vous souhaitez obliger l'utilisateur � expliquer pourquoi la mise � jour		a lieu, il vous est n�cessaire de placer raison_modification_obligatoire � ON aussi.		(Si log_edit est valoris� � OFF, alors raison_modification_obligatoire est ignor�).
        </td>
      </tr>
      <tr>
        <td class='bars'>paging_max_rows</td>
        <td class='bars'>
		Contr�le le nombre de lignes de donn�es affich�es lors des recherches et des 
		listes de fiches.        </td>
      </tr>
      <tr>
        <td class='bars'>priority_medium</td>
        <td class='bars'>
          Si cela est valoris� � zero, l'ombrage des priorit� sera d�sactiv� (          l'ombrage des priorit� change la couleur des fiches dans la liste
		  en fonction de leur priorit�).          
          <p>Valoris� cela � peu pr�s � 1/2 du nombre total d'entr�es de priorit�s           pour un ombrage optimal).
        </td>
      </tr>
      <tr>
        <td class='bars'>system_name</td>
        <td class='bars'>
          Utilisez cela pour remplacer le nom du syst�me de suivi qui sera affich�           aux utilisateurs.
        </td>
      </tr>
      <tr>
        <td class='bars'>time_elapsed_unit</td>
        <td class='bars'>
		Contr�le l'unti� de temps utilis�e dans le champ dur�e sur une fiche. Les 
		valeurs correctes sont des choses telles que : seconds, minutes, hours, days, 
		month, etc.         </td>
      </tr>
      <tr>
        <td class='bars'>url_view_*</td>
        <td class='bars'>
		Peut �tre utilis� pour remplacer les pages utilis�es pour visualiser les 
		pi�ces jointes et les fiches. C'est utilis� uniquement par des administrateurs
		avertis qui souhaitent modifier le syst�me et cr�er des pages personnalis�es 		de visualisation des pi�ces jointes          </td>
      </tr>
      <tr>
        <td class='bars'>use_euro_date</td>
        <td class='bars'>
          A l'�tat ON les dates sont examin�e et mise en forme selon le format europ�en          (jj/mm/aaaa) plut�t que qu'au format des Etats Unis (mm/dd/yyyy). Tous les           autres formats de date ne sont pas concern�s.
        </td>
      </tr>
      <tr>
        <td class='bars'>varfield_tab_name</td>
        <td class='bars'>
          Permet de fixer le nom l'onglet qui contient les champs variables (personnalis�s).
        </td>
      </tr>
      <tr>
        <td class='bars'>version</td>
        <td class='bars'>
          Le num�ro de la version courant de ZenTrack.
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
