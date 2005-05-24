<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
<?
$logs = $zen->get_logs($id);
if( is_array($logs) && count($logs) > 0) {
  print "<tr><td class='titleCell'>".tr("Log Entries");
  print "</td></tr>\n";
  $att = $zen->get_attachments($id,null,1);
  $i = 1;
  $sep = "\n--";
  foreach($logs as $l) {
    if( $i == 20 ) {
      print $title_row;
      $i = 1;
    }
    $lid = $l["lid"];
    $style = ($style == 'cell')? 'bars' : 'cell';
    //
    // the details
    print "<tr>\n";
    print "<td class='$style' style='color:".$zen->settings["color_text"]."'>";
    print $zen->showDateTime($l["created"]);
    print $sep.uptr($l["action"]);
    print "<br>".$zen->getBinName($l["bin_id"]);
    print $sep.$zen->formatName($l["user_id"],2);
    print (strlen($l["hours"]))? $sep.$l["hours"]." hrs":"";
    //
    // the log and attachments
    if( $l["entry"] ) {
      print "<br>\n";
      $l["entry"] = $zen->ffvText($l["entry"]);
      //$l["entry"] = preg_replace("#\&amp;#", "&", $l["entry"]);
      //	$l["entry"] = preg_replace("#(https?://[a-zA-Z0-9_/.-]+[a-zA-Z0-9\-_]+\.[a-z]{2,3}(/[a-zA-Z/\._\?=&0-9-]+))#", "<a href='\\1' target='_blank'>\\1</a>", $l["entry"]);
      $l["entry"] = preg_replace("|(https?://[a-zA-Z0-9_/.-]+(/[a-zA-Z0-9/\.,_\?=&;:#+$!~*%'()-]+[a-zA-Z0-9_=&#+~%-]))|",
      "<a href='\\1' target='_blank'>\\1</a>", $l["entry"]);
      $l["entry"] = preg_replace("#([^/])(www\.)([a-zA-Z_/.-]+[a-zA-Z])#", 
	    "\\1<a href='http://www.\\3' target='_blank'>www.\\3</a>", $l["entry"]);
      $l["entry"] = preg_replace("#^(www\.)([a-zA-Z_/.-]+[a-zA-Z])#", 
      "<a href='http://www.\\2' target='_blank'>www.\\2</a>", $l["entry"]);
      
      
      print $l["entry"];
    }
    if( is_array($att["$id"]["$lid"]) ) {
      print "<p><b>".uptr("Attachments").":</b><br>";
      foreach( $att["$id"]["$lid"] as $a ) {
        print "<a href='".$zen->settings["url_view_attachment"]
        ."?aid=$a[attachment_id]' ";
        print "target='_blank'>$a[name]</a>";
        print "<span class='small'>($a[description])</span><br>\n";
      }
    }
    print "</td></tr>\n";
    print "</td>\n";
    $i++;
  }	    
} else {
  print "<tr><td height='300' valign='top'>"
  .tr("The log is empty")."</td></tr>\n";
}
?>
</table>

