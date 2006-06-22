<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr><td class='cell'>Les fiches repr�sentent le travail ou les t�ches qui doivent �tre
effectu�s.  La fiche est essentiellement un support pour
suivre toute les informations li�es � chaque t�che, et organiser ces
t�ches en structure logique.

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
  <li><b><?=tr('Elapsed')?></b> - la quantit� de temps �coul� depuis que le billet a �t�
ouvert.  <li><b><?=tr('Opened')?></b> - Quand la fiche a �t� ouverte. (Cr��e)
  <li><b><?=tr('Deadline')?></b> - Quand le travail d�crit par la fiche doit il �tre termin�.
  <li><b><?=tr('Priority')?></b> - L'importance relative de la fiche. (priorit�)
  <li><b><?=tr('Owner')?></b> - La personne en charge de la fiche.
  
  <p><b><?=tr('Details')?> Tab</b></p>
  <li><b><?=tr('Bin')?></b> - Le casier dans lequel est enregistr�e la fichie.
  <li><b><?=tr('Type')?></b> - le type de travail impliqu� dans l'accomplissement de ce billet.  <li><b><?=tr('System')?></b> - syst�me ou composant relatif o� les travaux seront termin�s.
  <li><b><?=tr('Closed')?></b> - quand le billet �tait ferm� (si c'est appropri�)
  <li><b><?=tr('Testing')?></b> - indique si des tests sont exig�s avant que la fiche puisse �tre
ferm�e.
  <li><b><?=tr('Approval')?></b> - indique si l'approbation sera exig�e avant que la fiche puisse �tre
ferm�e.
</ul>

 </td>
</tr>
<tr>
  <td class='titleCell'>Les onglets fiche</td>
</tr>
  <tr><td class='cell'>
    <p>Explication des onglets fiches:</p>
    <ul>
      <li><b><?=$tabs['details']?></b> - propri�t�s et informations d�taill�es sur les champs du billet
      <li><b><?=$tabs['custom']?></b>(Variable Fields) - des champs suppl�mentaires par votre organisation
      <li><b><?=$tabs['log']?></b> - le journal est utilis� pour enregistrer l'activit� dat�e
      <li><b><?=$tabs['notify']?></b> - la liste des personnes destinataires du m�canisme d'information
      <li><b><?=$tabs['contacts']?></b> - la liste des contacts concern�s par cette fiche
      <li><b><?=$tabs['related']?></b> - la liste des fiches en liaison avec la pr�sente fiche
      <li><b><?=$tabs['attachments']?></b> - la liste des pi�ces jointes associ�es � la fiche
      <li><b><?=$tabs['system']?></b> - le journal syst�me
		(contient des erreurs et des informations sur des commandes ex�cut�es).  La date/heure du syst�me 
		est �galement employ�e pour pr�senter des formulaires pour accomplir des actions.
    </ul>
  </td>
</tr>
<tr>
  <td class='titleCell'>Les actions sur une fiche</td>
</tr>
<tr><td class='cell'>
  <p>Explication des bouttons d'action relatifs � une fiche:</p>
  
  <ul>
  <li><b><?=tr('Accept')?></b> -  Appropriation d'une fiche.
Ceci permet de g�rer la fiche et indique qui en est actuellement
responsable.
  
  <li><b><?=tr('Approve')?></b> -  repr�sente une fin de connexion de
manager ou de surveillant qui a approuv� la fin de travail.
  
  <li><b><?=tr('Assign')?></b> -  Donner la propri�t� d'une fiche � un
utilisateur qui peut acc�der au casier dans lequel elle est stock�e.  Cette
action est seulement disponible avec des droits appropri�s.
  
  <li><b><?=tr('Close')?></b> -  Indicates that work is completed on the ticket.  If the
  ticket is closed and testing or approval are required, it will be moved
  to a PENDING status until this work is complete.  When all testing and
  approval requirements are met, the ticket will move to a CLOSED state.
indique que des travaux sont termin�s
sur la fiche.  Si la fiche est ferm�e et le test ou l'approbation
sont exig�s, lui sera attribu� un statut EN ATTENTE jusqu'� ce
que ce travail soit completement accompli.  Quand tous les besoins de test et
d'approbation sont acquis, le billet est plac� dans un �tat
FERM�.  
  <li><b><?=tr('Edit')?></b> -  changer les propri�t�s d'une fiche.
Cette action est seulement � la disposition des utilisateurs avec des
droits appropri�s.
  
  <li><b><?=tr('Email')?></b> -  permet  d'envoyer le contenu, ou un bref sommaire
d'une fiche  � un destinataire choisi, ou � la liste
de destinataires.
  
  <li><b><?=tr('Log')?></b> -  Permet l'enregistrement des diff�rentes activit�s de la fichie.  
  Enregistrement des heures travaill�es, aussi bien que des questions, les solutions, les notes, et
les informations g�n�rales au sujet de la t�che.
  
  <li><b><?=tr('Move')?></b> -  Change une fiche de casier, et lib�re la fiche de son appartenance.
  
  <li><b><?=tr('Print')?></b> -  G�n�re un �tat pratique destin� � l'impression.
  
  <li><b><?=tr('Reject')?></b> -  Renvoit le billet � l'exp�diteur.
Ceci est con�u pour �tre employ� si un billet est envoy� � la
personne ou au casier �rron�, ou le travail n'est pas r�alisable dans des
conditions que l'exp�diteur doit corriger.  <br>&nbsp;<br>Si  aucun
exp�diteur peut �tre d�termin�, alors le syst�me essayera de
renvoyer la fiche au cr�ateur.  Si ceci n'est pas possible, alors le billet 
reviendra au casier d'o� il a �t� assign�.
  
  <li><b><?=tr('Relate')?></b> -  Indique une relation entre deux fiches.  
  Ceci indique " voir �galement " la condition existe entre les
billets.
  
  <li><b><?=tr('Test')?></b> -  indique que le test a �t� accompli et
que le travail est satisfaisant.  Cette action est seulement � la
disposition des utilisateurs avec l'acc�s appropri�.
  
  <li><b><?=tr('Yank')?></b> -  Prendre la propri�t� d'un billet tandis
qu'il est poss�d� par un autre utilisateur.  Cette action est
seulement � la disposition des utilisateurs avec l'acc�s appropri�.
  </ul>
  </td>
</tr>
</table>
<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
