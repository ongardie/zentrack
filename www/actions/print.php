<?
  
  $action = "print";
  include("action_header.php");

  if( !is_array($ticket) ) {
	  die("Ticket not found.  Unable to load");
  }

  $tid = $ticket["type_id"];
  $user_id = $ticket["user_id"];
  $title = ($zen->types["$tid"] == "Project")? strtoupper($zen->settings["system_name"])." PROJECT REPORT" : strtoupper($zen->settings["system_name"])." ".strtoupper($zen->types["$tid"])." REPORT";
  $ticketroj = ($zen->types["$tid"] == "Project")? 1 : '';
  if( $ticket["project_id"] ) {
     $parent = $zen->get_ticket($ticket["project_id"] );
  }

?>
<html>
<head>
<title><?=$title?></title>
</head>

<body onLoad="window.print()">
<table width=500 cellpadding=2 cellspacing=0 border=0>
<tr>
  <td colspan=4>
    <b><?=$title?></b>
  </td>
</tr>
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
<tr>
  <td colspan=4>
    <b><?=$id?> - <?=$ticket["title"]?>
  </td>
</tr>
<? if( is_array($parent) ) { ?>
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
<tr>
  <td>
	  <b>Project:</b>
  </td>
  <td colspan=3>
    <b><?=$parent["id"]?> - <?=$parent["title"]?>
  </td>
</tr>	  
<? } ?>
  
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
  
<? if( $ticketroj ) { ?>

<tr>
  <td colspan=4>
	  <b>TASKS FOR COMPLETION:</b>
     <ul>
<? if( is_array($ticket["children"]) ) { ?>     
     <table width=400 cellpadding=2 cellspacing=0 border=1>
     <tr>
     <td>
     <b>ID</b>
     </td>
     <td>
     <b>Title</b>
     </td>
     <td>
     <b>Status</b>
     </td>
     <td>
     <b>ETC</b>
     </td>
     <td>
     <b>ATC</b>
     </td>
     </tr>
     <?
       $total_etc = $total_wkd = 0;
       foreach($ticket["children"] as $a) {
	  if( $zen->types["$a[type_id]"] == "Project" ) {
	     list($a["est_hours"],$a["wkd_hours"]) = $zen->getProjectHours($a["id"]);
	  }
	  $total_etc += $a["est_hours"];
	  $total_wkd += $a["wkd_hours"];
	  $percent = $zen->percentWorked( $a["est_hours"], $a["wkd_hours"] );
	  if( strlen($percent) ) {
	     $percent = " ($percent%)";
	  }
	  print "<tr>\n";
	  print "\t<td>$a[id]</td>\n";
	  print "\t<td>$a[title]</td>\n";
	  print "\t<td>$a[status]</td>\n";
	  print ($a["est_hours"] > 0)? "\t<td>$a[est_hours]</td>\n" : "<td>&nbsp;</td>\n";
	  print ($a["wkd_hours"] > 0)? "\t<td>$a[wkd_hours]$percent</td>\n" : "<td>&nbsp;</td>\n";
	  print "</tr>\n";
       }
   ?>
     <tr>
     <td  colspan=3 align=right><b>Totals</b></td>
     <td ><b><?=$total_etc?></b></td>
     <td ><b><?=$total_wkd?></b></td>
     </tr>
     </table>
     <?
     
  } else {
	 print "No Tasks Assigned to this Project";  
  }
?>
     </ul>
     </td>
     </tr>	  
<? } ?>

<tr>
  <td  width=50>
    <b>Status:</b>
  </td>
  <td  width=150>
  <?=($ticket["status"])? $ticket["status"] : "ARCHIVED"; ?>
  </td>
  <td  width=50>
    <b>Bin:</b>
  </td>
  <td  width=250>
    <?=$zen->bins["$ticket[bin_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b>Priority:</b>
  </td>
  <td>
  <?=($ticket["priority"])? $zen->priorities["$ticket[priority]"] : "none"; ?>
  </td>
  <td >
    <b>Type:</b>
  </td>
  <td >
    <?=$zen->types["$ticket[type_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b>Created:</b>
  </td>
  <td>
  <?=($ticket["otime"])? $zen->showDateTime($ticket["otime"],'M') : "n/a"?>
  </td>
  <td >
    <b>System:</b>
  </td>
  <td >
    <?=$zen->systems["$ticket[system_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b>Elapsed:</b>
  </td>
  <td>
  <?=round($zen->dateDiff($ticket["ctime"],$ticket["otime"],'hours'),1)?> hours
  </td>
  <td >
    <b>Est. Hrs:</b>
  </td>
  <td >
    <?=($ticket["est_hours"] > 0)? "$ticket[est_hours] (".$zen->percentWorked($ticket["est_hours"],$ticket["wkd_hours"])."% complete)" : "n/a"; ?>
  </td>
</tr>
  
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>  
  
<tr>
  <td  colspan=4>
    <b>DESCRIPTION</b>
    <ul>
      <?=nl2br(htmlspecialchars(stripslashes($ticket["description"])))?>
    </ul>
  </td>
</tr>
  
<tr>
  <td colspan=4>
	  <b>RELATED TICKETS:</b>
     <ul>
<?
  if( $ticket["related"] ) {
     $rel = explode(",",$ticket["related"]);
     foreach($rel as $r) {
	$t = $zen->get_ticket($r);
	print "$t[id] - $t[title] ($rootUrl/ticket.php?id=$t[id])<br>\n";
     }
  } else {
     print "No Related Tickets";  
  }
?>
	  </ul>
  </td>
</tr>	  

<tr>
  <td >
    <b>Testing:</b>
  </td>
  <td  colspan=3>
    <?
      if( !$ticket["tested"] ) {
	 print "Not Required";
      } else {
	 print ($ticket["tested"] == 1)? "Required" : "Completed";	
      }
    ?>
  </td>
</tr>

<tr>
  <td >
    <b>Approval:</b>
  </td>
  <td  colspan=3>
  <?
    if( !$ticket["approved"] ) {
       print "Not Required";
    } else {
       print ($ticket["approved"] == 1)? "Required" : "Completed";	
    }
  ?>
  </td>
</tr>

<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>  
  
<tr>
  <td colspan=4>
    <b>LOG</b>
    <ul>
<?
  $logs = $zen->get_logs($id);
  if( !is_array($logs) ) {
     print "No Log Entries";	  
  } else {
     foreach( $logs as $l ) {
	print ($l["entry"])? 
	  $zen->showDateTime($l["created"])."  "
	  .$l["action"]."-"
	  .$zen->formatName($l["user_id"])
	  ."-".$zen->bins["$l[bin_id]"]
	  .":<br><i>".nl2br(htmlentities(stripslashes($l["entry"])))."</i><P>"
	  : 
	  $zen->showDateTime($l["created"])."  "
	  .$l["action"]."-"
	  .$zen->formatName($l["user_id"])
	  ."-".$zen->bins["$l[bin_id]"]."<P>";
     }                 
  }
?>
    </ul>
  </td>
</tr>
</table>
  
</body>
</html>
