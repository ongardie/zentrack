<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr><td class='cell'>Les fiches représentent le travail ou les tâches qui doivent être
effectués.  La fiche est essentiellement un support pour
suivre toute les informations liées à chaque tâche, et organiser ces
tâches en structure logique.

</td></tr>

<tr>
  <td class='titleCell'>Les champs d'une fiche</td>
</tr>
<tr><td class='cell'>

<p>Explications pour les champs qui apparaissent dans la vue d'une fiche:</p>

<ul>
  <p><b>Main Window</b></p>
  <li><b><?=tr('ID')?></b> - identifiant de suivi de la fiche
  <li><b><?=tr('Title')?></b> - un sommaire rapide du but et de la description du billet
  <li><b><?=tr('Elapsed')?></b> - la quantité de temps écoulé depuis que le billet a été
ouvert.  <li><b><?=tr('Opened')?></b> - Quand la fiche a été ouverte. (Créée)
  <li><b><?=tr('Deadline')?></b> - Quand le travail décrit par la fiche doit il être terminé.
  <li><b><?=tr('Priority')?></b> - L'importance relative de la fiche. (priorité)
  <li><b><?=tr('Owner')?></b> - La personne en charge de la fiche.
  
  <p><b><?=tr('Details')?> Tab</b></p>
  <li><b><?=tr('Bin')?></b> - Le casier dans lequel est enregistrée la fichie.
  <li><b><?=tr('Type')?></b> - le type de travail impliqué dans l'accomplissement de ce billet.  <li><b><?=tr('System')?></b> - système ou composant relatif où les travaux seront terminés.
  <li><b><?=tr('Closed')?></b> - quand le billet était fermé (si c'est approprié)
  <li><b><?=tr('Testing')?></b> - indique si des tests sont exigés avant que la fiche puisse être
fermée.
  <li><b><?=tr('Approval')?></b> - indique si l'approbation sera exigée avant que la fiche puisse être
fermée.
</ul>

 </td>
</tr>
<tr>
  <td class='titleCell'>Les onglets fiche</td>
</tr>
  <tr><td class='cell'>
    <p>Explication des onglets fiches:</p>
    <ul>
      <li><b><?=$tabs['details']?></b> - propriétés et informations détaillées sur les champs du billet
      <li><b><?=$tabs['custom']?></b>(Variable Fields) - des champs supplémentaires par votre organisation
      <li><b><?=$tabs['log']?></b> - le journal est utilisé pour enregistrer l'activité datée
      <li><b><?=$tabs['notify']?></b> - la liste des personnes destinataires du mécanisme d'information
      <li><b><?=$tabs['contacts']?></b> - la liste des contacts concernés par cette fiche
      <li><b><?=$tabs['related']?></b> - la liste des fiches en liaison avec la présente fiche
      <li><b><?=$tabs['attachments']?></b> - la liste des pièces jointes associées à la fiche
      <li><b><?=$tabs['system']?></b> - le journal système
		(contient des erreurs et des informations sur des commandes exécutées).  La date/heure du système 
		est également employée pour présenter des formulaires pour accomplir des actions.
    </ul>
  </td>
</tr>
<tr>
  <td class='titleCell'>Les actions sur une fiche</td>
</tr>
<tr><td class='cell'>
  <p>Explication des bouttons d'action relatifs à une fiche:</p>
  
  <ul>
  <li><b><?=tr('Accept')?></b> -  Appropriation d'une fiche.
Ceci permet de gérer la fiche et indique qui en est actuellement
responsable.
  
  <li><b><?=tr('Approve')?></b> -  représente une fin de connexion de
manager ou de surveillant qui a approuvé la fin de travail.
  
  <li><b><?=tr('Assign')?></b> -  Donner la propriété d'une fiche à un
utilisateur qui peut accéder au casier dans lequel elle est stockée.  Cette
action est seulement disponible avec des droits appropriés.
  
  <li><b><?=tr('Close')?></b> -  Indicates that work is completed on the ticket.  If the
  ticket is closed and testing or approval are required, it will be moved
  to a PENDING status until this work is complete.  When all testing and
  approval requirements are met, the ticket will move to a CLOSED state.
indique que des travaux sont terminés
sur la fiche.  Si la fiche est fermée et le test ou l'approbation
sont exigés, lui sera attribué un statut EN ATTENTE jusqu'à ce
que ce travail soit completement accompli.  Quand tous les besoins de test et
d'approbation sont acquis, le billet est placé dans un état
FERMÉ.  
  <li><b><?=tr('Edit')?></b> -  changer les propriétés d'une fiche.
Cette action est seulement à la disposition des utilisateurs avec des
droits appropriés.
  
  <li><b><?=tr('Email')?></b> -  permet  d'envoyer le contenu, ou un bref sommaire
d'une fiche  à un destinataire choisi, ou à la liste
de destinataires.
  
  <li><b><?=tr('Log')?></b> -  Permet l'enregistrement des différentes activités de la fichie.  
  Enregistrement des heures travaillées, aussi bien que des questions, les solutions, les notes, et
les informations générales au sujet de la tâche.
  
  <li><b><?=tr('Move')?></b> -  Change une fiche de casier, et libère la fiche de son appartenance.
  
  <li><b><?=tr('Print')?></b> -  Génére un état pratique destiné à l'impression.
  
  <li><b><?=tr('Reject')?></b> -  Renvoit le billet à l'expéditeur.
Ceci est conçu pour être employé si un billet est envoyé à la
personne ou au casier érroné, ou le travail n'est pas réalisable dans des
conditions que l'expéditeur doit corriger.  <br>&nbsp;<br>Si  aucun
expéditeur peut être déterminé, alors le système essayera de
renvoyer la fiche au créateur.  Si ceci n'est pas possible, alors le billet 
reviendra au casier d'où il a été assigné.
  
  <li><b><?=tr('Relate')?></b> -  Indique une relation entre deux fiches.  
  Ceci indique " voir également " la condition existe entre les
billets.
  
  <li><b><?=tr('Test')?></b> -  indique que le test a été accompli et
que le travail est satisfaisant.  Cette action est seulement à la
disposition des utilisateurs avec l'accès approprié.
  
  <li><b><?=tr('Yank')?></b> -  Prendre la propriété d'un billet tandis
qu'il est possédé par un autre utilisateur.  Cette action est
seulement à la disposition des utilisateurs avec l'accès approprié.
  </ul>
  </td>
</tr>
</table>
<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
