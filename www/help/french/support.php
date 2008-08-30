<?  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "Support";
  include("$libDir/nav.php");
?>

  <br>
  <blockquote>
  <span class='bigBold'>Support pour <?=$zen->getSetting("system_name")?></span>
  <p>Si vous ne trouvez pas la solution � votre probl�me dans le manuel, l'acc�s aux ressources suivants est    vivement recommand� :</p>
  
  <table border=0 cellspacing=5>
	<tr>
	  <td valign="top"><a href="http://sourceforge.net/mail/?group_id=22724">Liste de diffusion</a></td>
	  <td>La communaut� des utilisateurs Zen-track est un endroit id�al pour obtenir de l'aide.  D�lais de r�ponse
          habituellement entre 12 et 24 heures.</td>
	</tr>
        <tr valign="top">
	  <td valign="top"><a href="http://www.sourceforge.net/projects/zentrack">Le Projet</a></td>
	  <td>(voir les pages de support)  Vous y obtiendrez une r�ponse probablement dans l'heure, peut �tre sous quelques jours
           mais vous en obtiendrez une.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="http://www.zentrack.net/feedback">Contacts Page</a></td>
           <td>Si vous etes un testeur enregistr�, vous pouvez adresser un message �lectronique directement. Si vous ne l'�tes pas 
               vous aurez probablement plus de chances via la liste de diffusion.
           </td>
	</tr>
  </table>

  <p><a href='<?=$helpUrl?>/bugs.php'>Cliquez ici</a> pour obtenir des information sur les bogues!</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>
