<?  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "Reporting Bugs";
  include("$libDir/nav.php");
?>

  <br>
  <p class='bigbold'>Etape pour signaler un bug.</p>
  
  <b>Faire la description d'un bug est simplifié</b>
  <blockquote>
    <p><b>1. Placer l'application en mode debug</b>:  ouvrir www/header.php et paramétrer 
      $Debug_Overview = 1.  Cela provoquera la rédaction d'un rapport d'erreur      à la fin de la page.
    
    <p><b>2. Cliquer sur le bouton 'Signaler un bug' </b>:  Au sein du rapport d'incident
    se trouve un bouton pour signaler l'incident.  Cliquer sur le bouton
    et soumettre le formulaire avec vos commentaires.
    
  </blockquote>
  
  <b>Signaler un bug manuellement</b>
  <blockquote>
    S'il vous est absolument impossible de fair fonctionner l'application, vous pouvez     signaler l'anomalie manuellement en suivant les étapes suivantes :
    
    <p><b>1. Rassembler les informations systèmes.</b>: Indiquer votre systeme d'exploitation, la version de php,
    la version de zenTrack , le type et la version du gestionaire de base de donnée,    ainsi qu'un minimum d'informations à propos du serveur apache!
    
    <p><b>2. Signaler votre anomalie</b>: S'il vous plait signaler votre anomalie à  <a href="http://sourceforge.net/tracker/?group_id=22724&atid=376336"> cliquer ici</a>.
    
    <p>Si le serveur Source Forge n'était pas en fonction, alors vous pouvez le signaler via notre forum utilisateur:
    <a href='http://www.zentrack.net/modules/newbb/' target='_blank'>lien vers le forum</a>.</p>  
  </blockquote>
<?
  include("$libDir/footer.php");
?>
