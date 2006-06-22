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
  <p>Si vous ne trouvez pas la solution à votre problème dans le manuel, l'accès aux ressources suivants est    vivement recommandé :</p>
  
  <table border=0 cellspacing=5>
	<tr>
	  <td valign="top"><a href="http://sourceforge.net/mail/?group_id=22724">Liste de diffusion</a></td>
	  <td>La communauté des utilisateurs Zen-track est un endroit idéal pour obtenir de l'aide.  Délais de réponse
          habituellement entre 12 et 24 heures.</td>
	</tr>
        <tr valign="top">
	  <td valign="top"><a href="http://www.sourceforge.net/projects/zentrack">Le Projet</a></td>
	  <td>(voir les pages de support)  Vous y obtiendrez une réponse probablement dans l'heure, peut être sous quelques jours
           mais vous en obtiendrez une.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="http://www.zentrack.net/feedback">Contacts Page</a></td>
           <td>Si vous etes un testeur enregistré, vous pouvez adresser un message électronique directement. Si vous ne l'êtes pas 
               vous aurez probablement plus de chances via la liste de diffusion.
           </td>
	</tr>
  </table>

  <p><a href='<?=$helpUrl?>/bugs.php'>Cliquez ici</a> pour obtenir des information sur les bogues!</p>

  </blockquote>
<?
  include("$libDir/footer.php");
?>
