<?{

  /*
  **  REPORTS REPORT PAGE
  **  
  **  Creates report images
  **
  */
  
  include_once("./reports_header.php");
  
  // retrieve the params of the report
  include_once("$libDir/reportDataParser.php");  

  // this is for programmer testing.. it will remain at
  // least until the reports are out of beta, possibly forever
  if( $zen->debug == 98 || $zen->debug == -98 ) {
      print "<p><b>---DEBUG INFO---</b><pre>\n";
      print "report params:\n";
      print_r($params); 
      print "\n\nLabels:\n";
      print_r($date_labels);
      print "\n\nData:\n";
      print_r($data_array);
      print "</pre><b>---END DEBUG---</b></p>\n";
  }

  foreach($params["chart_options"] as $o) {
    $n = count($date_labels)+1;
    print "<table width='{$zen->reportImageWidth}'>\n";
    print "\t<tr>"      
      ."<td class='titleCell' align='center' colspan='$n'>"
      .$option_names["$o"]."</td></tr>\n";
    print "\t<tr>";
    print "<td class='subTitle'>".$report_type."</td>\n";
    foreach($date_labels as $d) {
      print "<td class='subTitle'>$d</td>";      
    }
    print "</tr>\n";
    foreach($params["data_set"] as $d) {
      print "\t<tr>\n";
      $row = ($row == 'cell')? 'bars' : 'cell';
      print "<td class='$row'>".$set_index["$d"]."</td>\n";
      for($i=0; $i<count($date_labels); $i++) {
	print "\t\t<td class='$row'>".$data_array["$o"]["$d"][$i]."</td>\n";
      }
      print "\t</tr>\n";
    }     
    print "</table><br>\n";
  }

}?>