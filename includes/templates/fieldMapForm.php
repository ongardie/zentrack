<?
  /**
    PREREQUISITES:
      $map - (ZenFieldMap) map object which can be used to retrieve default values
      $fields - (array) values from $map->getFieldMap($view);
      $zen - (ZenTrack)
  **/
?>
<br>
<p class='error'><?
   $str = "<a href='$rootUrl/help/find.php?s=admin&p=fieldmap'>".tr('Documentation')."</a>";
   print tr("Please refer to the ? before using this feature", array($str));
 ?></p>
 
<form method='post' action='<?=$SCRIPT_NAME?>' name='fieldMapForm'>
<input type='hidden' name='TODO' value='save'>
<input type='hidden' name='view' value='<?=$zen->ffv($view)?>'>

<p>
<nobr>
<b>Screen to Edit:</b>
&nbsp;
<select name='view'>
<?
foreach( getFmViewProps() as $k=>$v ) {
  if( !$v['disabled'] ) {
    $sel = $view == $k? " selected" : "";
    print "<option value='$k'$sel>$k</option>\n";
  }
}
?>
</select>
&nbsp;
<input type='submit' name='switchview' onclick='return setTodo("switch")' value='GO'>
</nobr>
<br><span class='note'><?=tr("Do not switch views without saving changes!")?></span>
</p>

<table cellpadding="4" cellspacing="1" class='cell' border=0>
<tr toofar="toofar">
  <td class='titleCell' align='center' colspan='10'>
    <b><?=tr("Edit field map for ?", $view)?></b>
  </td>
</tr>
<?
if( !is_array($fields) || !count($fields) || !$map || !$view ){
  print "<tr><td colspan='10' class='cell'>This view has no properties to configure</td></tr>\n";
}
else {
?>
<tr toofar="toofar">
  <td class='subTitle' align='center'><b><?=tr("Options")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Name")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Label")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Show")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Required")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Default")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Type")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Columns")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Rows")?></b></td>
</tr>

<?
function fmfRow( $text, $class ) {
  print "<td class='$class'>{$text}</td>";
}

function fmfName( $field_name, $key ) {
  return " name='{$field_name}[$key]' ";
}

function fmfVal( $field, $key ) {
  global $zen;
  return $zen->ffv($field[$key]);
}

$vprops = getFmViewProps($view);
$fcount=0;
$prevSection = false;
$typeprops = getFmTypeProps();
foreach($fields as $f=>$field) {
  // retrive configurable settings from database
  //$field = $map->getFieldFromMap($view, $f);

  // convert varfield names using fieldName() method
  // and get special properties for fields
  $fprops = getFmFieldProps($view, ZenFieldMap::fieldName($f));
  $tprops = $typeprops[$field['field_type']];
  
  // generate row of information
  $s = $field['is_visible']? 'bold' : 'disabled';
  $class = $field['field_type'] == 'section'? "altBars $s" : "bars $s";
  print "<tr id='$f'>";

  // create options row
  $txt = '';
    $fn = "document.fieldMapForm";
    // up arrow
    $txt .= "<a href='#' onClick='moveRowUp(this.parentNode);return false;'";
    $txt .= " border='0' alt='Move Up' title='Move Up'><img src='/images/icon_arrow_up.gif'";
    $txt .= " width='16' height='16' alt='Move Up' title='Move Up' border='0'></a>";
    // down arrow
    $txt .= "<a href='#' onClick='moveRowDown(this.parentNode);return false;'";
    $txt .= " border='0' alt='Move Down' title='Move Down'><img src='/images/icon_arrow_down.gif'";
    $txt .= " width='16' height='16' alt='Move Down' title='Move Down' border='0'></a>";
    // control sort ordering by tracking what order these hidden fields arrive
    $txt .= "<input type='hidden' name='orderset[$f]' value='$fcount'>";
  if( $vprops['sections'] ) {
    if( $field['field_type'] == 'section' && $field['field_name'] != 'elapsed' ) {
      // remove sections
      $txt .= "<a href='#' onClick='removeRow(this);return false;'";
      $txt .= " border='0' alt='Remove Section' title='Remove Section'><img src='/images/icon_trash.gif'";
      $txt .= " width='16' height='16' alt='Remove Section' title='Remove Section' border='0'></a>";
    }
    else {
      // add new sections
      $txt .= "<a href='#' onClick='addRow(this);return false;'";
      $txt .= " border='0' alt='Add Section' title='Add Section'><img src='/images/icon_add.gif'";
      $txt .= " width='16' height='16' alt='Add Section' title='Add Section' border='0'></a>";
    }
  }
  fmfRow($txt,$class);

  // the field name (read only)
  fmfRow($field['field_name'],$class);
  // the label (text)
  fmfRow("<input type='text' ".fmfName($f,'field_label')
        ."value='".fmfVal($field,'field_label')."' size=15 maxlength=200>",$class);
  // visibility (checkbox)
  $sel = $field['is_visible']? ' checked' : '';
  fmfRow("<input type='checkbox' ".fmfName($f, 'is_visible')
         ."value='1' onclick='return checkVisible(this)'$sel>",$class);
  // required, always required if this is a system based field
  if( $field['field_type'] == 'section' ) {
    $s = $field['is_visible']? 'bold' : 'disabled';
    print "<td class='altBars $s' colspan='5'>&nbsp;</td>";
  }
  else {
    if( $vprops['view_only'] ) {
      fmfRow(tr('n/a'),$class);
    }
    else if( $view == 'search_form' ) {
      fmfRow(tr('n/a'), $class);
    }
    else if( $fprops['always_required'] ) {
      fmfRow(tr('yes'),$class);
    }
    else {
      $sel = $field['is_required']? ' checked' : '';
      fmfRow("<input type='checkbox' ".fmfName($f, 'is_required')." value='1'$sel>",$class);
    }
    // default value (text)
    $txt = "n/a";
    if( $fprops['default'] && !$vprops['view_only'] ) {
      if( strpos($f,'custom_menu')===0 ) {
        // custom menus use the data groups as a selector, not a list of values
        $choices = $zen->getDataGroups();
      }
      else {
        $choices = $map->getChoices($view, $f);
      }
      //if( $f == 'custom_menu1' ) { Zen::printArray($choices); }
      if( is_array($choices) && count($choices) ) {
        $txt = "<select ".fmfName($f,'default_val').">";
        $txt .= "<option value=''>--</option>";
        foreach($choices as $k=>$v) {
          $sel = $field['default_val'] === $k? " selected" : "";
          $txt .= "<option value='$k'{$sel}>$v</option>";
        }
        $txt .= "</select>";
      }
      else {
        $txt = "<input type='text' ".fmfName($f, 'default_val')
               ."value='".$zen->ffv($field['default_val'])."' size=10 maxlength=200>";
      }
    }
    fmfRow($txt,$class);
    
    // field type, not useful for fields which only have label as type
    // or for sections
    if( count($fprops['types']) == 1 && $fprops['types'][0] == 'label' ) {
      fmfRow($field['field_type']=='section'?'&nbsp;':fmfVal($field,'field_type'),$class);
    }
    else {
      $txt = "<select style='width:80px;' ".fmfName($f, 'field_type').">";
      foreach($fprops['types'] as $t) {
        if( $view == 'search_form' && $t == 'checkbox' ) { continue; }
        $sel = ( $field['field_type'] == $t )? ' selected':'';
        $txt .= "<option value='$t'$sel>$t</option>\n";
      }
      $txt .= "</select>";
      fmfRow($txt,$class);
    }
    // number of columns
    fmfRow("<input type='text' ".fmfName($f, 'num_cols')
        ." value='".fmfVal($field,'num_cols')."' size='5' maxlength='4'>",$class);
    // number of rows
    $dorows = false;
    if( $fprops['types'] ) {
      foreach($fprops['types'] as $t) {
        if( $typeprops[$t]['multiple'] ) { $dorows = true; break; }
      }
    }
    if( $dorows ) {
      fmfRow("<input type='text' ".fmfName($f, 'num_rows')
          ." value='".fmfVal($field,'num_rows')."' size='3' maxlength='2'>",$class);
    }
    else { fmfRow('1',$class); }
  }
  
  print "</tr>\n";
  $fcount++;
  $prevSection = $field['field_type'] == 'section';
}
?>
<tr id='section0' style="display:none;">
  <td class='highlight'><input type='hidden' name='orderset[section0]' value='3'><a href='#' onClick='moveRowUp(this.parentNode);return false;' border='0' alt='Move Up' title='Move Up'><img src='/images/icon_arrow_up.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><a href='#' onClick='moveRowDown(this.parentNode);return false;' border='0' alt='Move Down' title='Move Down'><img src='/images/icon_arrow_down.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><a href='#' onClick='removeRow(this);return false;' border='0' alt='Remove Section' title='Remove Section'><img src='/images/icon_trash.gif' width='16' height='16' alt='Remove Section' title='Remove Section' border='0'></a></td>
  <td class='highlight' islabel="islabel">section0</td>
  <td class='highlight'><input type='text' name='section0[field_label]' value='' size=15 maxlength=200></td>
  <td class='highlight'><input type='checkbox'  name='section0[is_visible]' value='1' onclick='return checkVisible(this)' checked></td>
  <td class='highlight' colspan='5'>&nbsp;</td>
</tr>
<tr id="submitRow" toofar="toofar">
  <td class='cell' colspan='4'>
    <input type='submit' value='<?=uptr('save')?>' onClick="return setTodo('save');">
    &nbsp;
    <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('reset');">
  </td>
</tr>

<? } ?>

</table>
</form>

<script type='text/javascript'>

function setTodo( txt ) {
  document.fieldMapForm.TODO.value = txt;
  return true;
}

function addRow( obj ) {
  if( !confirm("Add a Section Here?") ) { return; }
  // determine what the next available section number is
  var x = 1;
  while( document.getElementById("section"+x) ) { x++; }
  var newName = "section"+x;
  var newSection = document.getElementById("section0").cloneNode(true);
  newSection.setAttribute("id",newName);
  for(var i=0; i < newSection.childNodes.length; i++) {
    var sect = newSection.childNodes[i];
    if( sect.getAttribute && sect.getAttribute("isLabel") ) {
      s += "set innerhtml for "+sect+"\n";
      sect.innerHTML = newName;
    }
    else if( sect.hasChildNodes() && sect.childNodes[0] ) {
      var c = sect.childNodes[0];
      if( c.type == 'text' || c.type == 'checkbox' || c.type == 'hidden' ) {
        c.setAttribute('name', c.getAttribute('name').replace('section0',newName));
        s += " - new name: "+c.name+"\n";
        if ( c.type == 'hidden' ) {
          var v1, v2;
          v1=parseFloat(document.fieldMapForm[ "orderset[" + obj.parentNode.parentNode.id + "]" ].value);
          var previousRow = obj.parentNode.parentNode.previousSibling;
          while( previousRow && previousRow.nodeName != "TR" ) {
            previousRow = previousRow.previousSibling;
          }
          if( !previousRow || previousRow.getAttribute("toofar") ) {
            v2=-1.0;
          } else {
            v2=parseFloat(document.fieldMapForm[ "orderset[" + previousRow.id + "]" ].value);
          }
          v=(v1 + v2) / 2.0;
          c.setAttribute('value',v);
        }
      }
    }
  }
  obj.parentNode.parentNode.parentNode.insertBefore(newSection, obj.parentNode.parentNode);
  newSection.style.display = "";
}

function removeRow( obj ) {
  if( !confirm("Remove this Section?") ) { return; }
  var thisNode = obj.parentNode.parentNode;
  thisNode.parentNode.removeChild(thisNode);
}

function moveRowUp( tdCell ) {
  var v1, v2;
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'subTitle' );  
  var previousRow = thisRow.previousSibling;
  var parentNode = thisRow.parentNode;
  while( previousRow && previousRow.nodeName != "TR" ) {
    previousRow = previousRow.previousSibling;
  }
  if( !previousRow || previousRow.getAttribute("toofar") ) {
    parentNode.insertBefore(thisRow, document.getElementById("submitRow"));
    //As this is now the last row, we can get the orderset value of it's new previous row
    previousRow = thisRow.previousSibling;
    while( (previousRow && previousRow.nodeName != "TR") || (previousRow && previousRow.id === "section0") ) {
      previousRow = previousRow.previousSibling;
    }
    //And set the current row's orderset value to it's previous row orderset value + 1
    v1=parseFloat(document.fieldMapForm[ "orderset[" + previousRow.id + "]" ].value);
    document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value=v1+1;
    return;
  }
  parentNode.insertBefore(thisRow, previousRow);
  //If it didn't cross the edge of the table, we just swap the orderset values:
  v1=parseFloat(document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value);
  v2=parseFloat(document.fieldMapForm[ "orderset[" + previousRow.id + "]" ].value);
  document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value=v2;
  document.fieldMapForm[ "orderset[" + previousRow.id + "]" ].value=v1;  
}

function quickHighlightRow( parentObj, s ) {
  for(var i=0; i < parentObj.childNodes.length; i++) {
    var obj = parentObj.childNodes[i];
    obj.id = parentObj.id + '-'+i;
    if( obj.nodeName != "TD" ) { continue; }
    objName = obj.id;
    if( obj.className ) {
      obj.className = obj.className + ' ' + s;
      setTimeout("var x = document.getElementById('"+objName+"'); x.className = x.className.substr(0,x.className.indexOf(' "+s+"'));",500);
    }
    else {
      obj.setAttribute('class', obj.getAttribute('class') + ' ' + s);
      setTimeout("var x = document.getElementById('"+objName+"'); x.setAttribute('class', x.getAttribute('class').substr(0,x.getAttribute('class').indexOf(' "+s+"')));",500);
    }
    
  }
}

function moveRowDown( tdCell ) {
  var v1, v2;
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'subTitle' );  
  var nextRow = thisRow.nextSibling;
  var parentNode = thisRow.parentNode;
  //while( nextRow && nextRow.nodeName != "TR" ) {
  while( (nextRow && nextRow.nodeName != "TR") || (nextRow && nextRow.id === "section0") ) {
    nextRow = nextRow.nextSibling;
  }
  if( !nextRow || nextRow.getAttribute("toofar") ) {
    nextRow = thisRow;
    thisRow = parentNode.firstChild;
    while( thisRow.nodeName != "TR" || thisRow.getAttribute("toofar") ) {
      thisRow = thisRow.nextSibling;
    }
    //We set the current row's orderset value to the first row's orderset -1
    v1=parseFloat(document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value);
    document.fieldMapForm[ "orderset[" + nextRow.id + "]" ].value=v1-1;
  } else {
    //We swap the orderset values:
    v1=parseFloat(document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value);
    v2=parseFloat(document.fieldMapForm[ "orderset[" + nextRow.id + "]" ].value);
    document.fieldMapForm[ "orderset[" + thisRow.id + "]" ].value=v2;
    document.fieldMapForm[ "orderset[" + nextRow.id + "]" ].value=v1;
  } 
  parentNode.insertBefore(nextRow, thisRow);  
}

function toggleRowColor( checkBox ) {
    // navigate to the TR tag for this row
    var trTag = checkBox.parentNode.parentNode;
    
    for(var i=0; i < trTag.childNodes.length; i++) {
      var obj = trTag.childNodes[i];
      if( obj.nodeName != "TD" ) { continue; }
      // perform the class switch
      if( obj.className ) {
        // determine what we are setting the style to based on checkbox
        obj.className = checkBox.checked? 
          obj.className.substr(0, obj.className.indexOf(" ")) + " bold" :
          obj.className.substr(0, obj.className.indexOf(" ")) + " disabled";
      }
      else {
        // determine what we are setting the style to based on checkbox
        var oldStyle = obj.getAttribute('class');
        obj.setAttribute('class', checkBox.checked? 
          oldStyle.substr(0, oldStyle.indexOf(" "))+" bold" : 
          oldStyle.substr(0, oldStyle.indexOf(" "))+" disabled" );
      }
    }
}

  function checkVisible( obj ) {
    var namePrefix = getNamePrefix(obj.name);
    var defName = namePrefix+'[default_val]';
    var reqName = namePrefix+'[is_required]';
    var defObj = document.fieldMapForm[defName];
    var reqObj = document.fieldMapForm[reqName];
    toggleRowColor( document.fieldMapForm[namePrefix+"[is_visible]"] );
    //if( !defObj ) { alert("crap!"); }//debug
    if( defObj && defObj.value == null && reqObj.checked ) {
      alert("You cannot hide a required field unless it has a default value.");
      return false;
    }
    return true;
  }
  
  function getNamePrefix( name ) {
    return name.substr(0, name.indexOf('['))
  }
</script>
