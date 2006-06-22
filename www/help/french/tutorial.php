<?
  $b = dirname(dirname(__FILE__));
  include("$b/help_header.php");

  $page_section = tr("Manuel utilisateur");  
  include("$libDir/nav.php");

  $tutDir = "$templateDir/tutorial/$helpLang";
  
  $tutUrl = "$helpUrl/tutorial.php";
  $sections = array(
     'introduction'    => 'Introduction',
     'login'           => 'Connexion',
     'view_tickets'    => 'Visualisation',
     'ownership'       => 'Proprité',
     'log_ticket'      => 'Entrées au journal',
     'bins'            => 'Casier',
     'close_ticket'    => 'Fermeture de fiche',
     'add_attachment'  => 'Pièces jointes',
     'notify_list'     => 'Liste d\'information',
     'relate_ticket'   => 'Liaison de fiche',
     'create_ticket'   => 'Nouvelle fiche',
     'use_project'     => 'Utilisation de projet',
     'contacts'        => 'Contacts',
     'closure'         => 'Fermeture'
  );
  
?>

<table width='100%'>
<tr>
  <td width='125' valign='top'>
    <a href='<?=$helpUrl?>/index.php'>Back to Help</a><br>
    <?
    $linktext = '';
    $title = 'Introduction';
    $s = array_key_exists('s',$_GET)? $_GET['s'] : 'introduction';
    $s = $zen->checkAlphaNum($s);
    $save = null;
    foreach($sections as $k=>$v) {
      // if flagged, this is the next link
      if( $save === 0 ) { $save = $k; }
      if( $s == $k ) {
        // we are on the current page
        $title = $v;
        $linktext .= "<b>&gt; $v</b>"; 
        // flag for the next go around
        $save = 0;
      }
      else {
        // create a link
        $linktext .= "<a href='$tutUrl?s=$k'>$v</a>";        
      }
      $linktext .= "<br>\n";
    }
    
    print $linktext;
    ?>
  </td>
  <td class='content' valign='top'>
    <?
      include("$tutDir/$s.php");
      if( $save ) {
        print "<p align='right'><b><a href='$tutUrl?s=$save'>Next: ";
        print $sections[$save];
        print "&nbsp;&gt;&gt;</b></a></p>\n";
      }
    ?>
  </td>
</tr>
</table>

<? 
  include("$libDir/footer.php"); 
?>
