<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  /**
   * Collect search results and generate html output
   *
   * REQUIREMENTS:
   *    $sb - (ZenSearchBox)searchbox instance to use
   *    $_POST - contains the search results from ZenSearchBox::renderFormFields()
   *    $searchbox_mode - the page mode (corresponding to 'type' in includes/templates/searchbox_type.php)
   *    $searchbox_type - if the page_mode is "datatype", then this must contain a valid data type to use
   *    $searchbox_form - the form in window.opener to return values to
   *    $searchbox_field - the field in window.opener to return values to
   *    $searchbox_multi - true if multiple values are allowed (false if only one value can be selected)
   *
   * POST EFFECTS:
   *    $searchbox_results - (boolean)true if some results were printed
   */
  //$sb =& ZenSearchBox::getInstance($templateDir, $searchbox_mode, $searchbox_multi, $searchbox_type);
  $res = $sb->getSearchResults();
  $searchbox_results = $res->rows() > 0;
  $labels = $res->labels();
  if( !$searchbox_results ) { 
    print "<div class='error'>".tr("There were no results for your search.")."</div>";
  }
  else {
    print "<table width='100%' cellspacing='1' cellpadding='4'>\n";
    print "<tr>\n";
    foreach( $labels as $l ) {
      print "<td class='headerCell'>".Zen::ffv($l)."</td>";
    }
    print "</tr>\n";
    $row = false;
    $i = 0;
    foreach( $res->vals() as $v ) {
      $id = Zen::ffv($res->id($v));
      $label = Zen::ffv($res->label($v));
      $rowid = "row$id";
      $m = " onclick='pickRow(\"$rowid\",event,this)' "
          ." onmouseover='mClassX(this, \"bars darker\", true)' "
          ." onmouseout='mClassX(this)' ";
      print "<tr class='bars' $m>";
      foreach($res->cols() as $c) {
        print "  <td>".Zen::ffv($v[$c])."</td>\n";
      }
      print "<input type='hidden' name='$rowid' id='$rowid' value='$id'>";
      print "<input type='hidden' name='{$rowid}_label' id='{$rowid}_label' value='$label'>";
      print "</tr>\n";
    }
    if( $searchbox_multi ) {
      print "<tr><td colspan='".count($labels)."'>";
      print "<input type='button' onclick='closeWindow()' value='".Zen::ffv(tr("Close Window"))."'>\n";
      print "</td></tr>\n";
    }
    print "</table>\n";
  }
?>