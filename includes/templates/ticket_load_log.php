<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<div class='borderBox'>
  <div class='borderLabel'><span><?=uptr("Log History")?></span></div>
  <form><input type='checkbox' name='checkit' value='1' onclick='toggleLogs(this.checked);'>&nbsp;<?=tr("Display system entries");?></form>
  <div id='logSet' class='borderContent'>
<?
$logs = $zen->get_logs($id);
if( is_array($logs) && count($logs) > 0) {
  $att = $zen->get_attachments($id,null,1);
  $i = 1;
  $sep = ",&nbsp;";
  foreach($logs as $l) {
    if( $i == 20 ) {
      print $title_row;
      $i = 1;
    }
    $lid = $l["lid"];
    $style = ($style == 'cell')? 'bars' : 'cell';
    $thing = $l['user_id'] == 0? " sysaction='sysaction' style='display:none'" : '';
    // the details
    print "<div class='bars' $thing>";
    print "<b>".$zen->showDateTime($l["created"])." - ".uptr($l["action"])."</b>";
    print "<div class='tiny'>";
    print tr("Bin: ").$zen->getBinName($l["bin_id"]);
    print $sep.tr("User: ").$zen->formatName($l["user_id"],2);
    print (strlen($l["hours"]))? $sep.tr("Hours: ").$l['hours']:"";
    print "</div>";
    print "</div>";

    // the log and attachments
    if( $l["entry"] ) {
      print "<div class='cell' $thing>";
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
      print "</div>\n";
    }
    if( is_array($att["$id"]["$lid"]) ) {
      print "<div class='cell' $thing>";
      print "<b>".uptr("Attachments").":</b><br>";
      foreach( $att["$id"]["$lid"] as $a ) {
        print "<a href='".$zen->getSetting("url_view_attachment")."?aid={$a['attachment_id']}' ";
        print "target='_blank'>{$a['name']}</a>";
        print "<span class='small'>{$a['description']}</span><br>\n";
      }
      print "</div>\n";
    }

    $i++;
  }	    
} else {
  print "<div>".tr("The log is empty")."</div>\n";
}
?>
</div></div>
<br>
<script type='text/javascript'>
function toggleLogs(b) {
  var s = b? '' : 'none';
  var container = window.document.getElementById('logSet');
  for(var i=0; i < container.childNodes.length; i++) {
    var node = container.childNodes[i];
    if( i.sysaction == 'sysaction' ) {
      i.style.display = s;
    }
  }
}
</script>