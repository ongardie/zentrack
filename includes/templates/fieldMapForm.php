<br>
<p class='error'><?
   $str = "<a href='$rootUrl/help/find.php?s=admin&p=fieldmap'>".tr('Documentation')."</a>";
   print tr("Please refer to the ? before using this feature", array($str));
 ?></p>
 
<form method='post' action='<?=$SCRIPT_NAME?>' name='fieldMapForm'>
<input type='hidden' name='TODO' value=''>

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

<table cellpadding="4" cellspacing="1" class='cell'>
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
  <td class='subTitle' width='30' align='center'><b><?=tr("ID")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Name")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Label")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Show")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Required")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Default")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Type")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Columns")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Rows")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Options")?></b></td>
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
  $class = $field['field_type'] == 'section'? 'altBars' : 'bars';
  print "<tr id='$f'>";
  // the field id (read only)
  fmfRow($field['field_map_id'],$class);
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
    print "<td class='altBars' colspan='5'>&nbsp;</td>";
  }
  else {
    if( $fprops['always_required'] ) {
      fmfRow(tr('yes'),$class);
    }
    else {
      $sel = $field['is_required']? ' checked' : '';
      fmfRow("<input type='checkbox' ".fmfName($f, 'is_required')." value='1'$sel>",$class);
    }
    // default value (text)
    if( $fprops['default'] ) {
      fmfRow("<input type='text' ".fmfName($f, 'default_val')
             ."value='".$zen->ffv($field['default_val'])."' size=10 maxlength=200>",$class);
    }
    else { fmfRow('n/a',$class); }
    // field type, not useful for fields which only have label as type
    // or for sections
    if( count($fprops['types']) == 1 && $fprops['types'][0] == 'label' ) {
      fmfRow($field['field_type']=='section'?'&nbsp;':fmfVal($field,'field_type'),$class);
    }
    else {
      $txt = "<select style='width:80px;' ".fmfName($f, 'field_type').">";
      foreach($fprops['types'] as $t) {
        $txt .= "<option value='$t'>$t</option>\n";
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
    $txt .= " width='16' height='16' alt='Move Up' title='Move Up' border='0'></a>";
    // control sort ordering by tracking what order these hidden fields arrive
    $txt .= "<input type='hidden' name='orderset[$f]' value='$fcount'>";
  if( $vprops['sections'] ) {
    if( $field['field_type'] == 'section' ) {
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
  
  print "</tr>\n";
  $fcount++;
  $prevSection = $field['field_type'] == 'section';
}
?>
<tr id='section0' style="display:none;">
  <td class='highlight'>30</td>
  <td class='highlight' islabel="islabel">section0</td>
  <td class='highlight'><input type='text' name='section0[field_label]' value='' size=15 maxlength=200></td>
  <td class='highlight'><input type='checkbox'  name='section0[is_visible]' value='1' onclick='return checkVisible(this)' checked></td>
  <td class='highlight' colspan='5'>&nbsp;</td>
  <td class='highlight'><a href='#' onClick='moveRowUp(this.parentNode);return false;' border='0' alt='Move Up' title='Move Up'><img src='/images/icon_arrow_up.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><a href='#' onClick='moveRowDown(this.parentNode);return false;' border='0' alt='Move Down' title='Move Down'><img src='/images/icon_arrow_down.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><input type='hidden' name='orderset[section0]' value='3'><a href='#' onClick='removeRow(this);return false;' border='0' alt='Remove Section' title='Remove Section'><img src='/images/icon_trash.gif' width='16' height='16' alt='Remove Section' title='Remove Section' border='0'></a></td>
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
      if( c.type == 'text' || c.type == 'checkbox' ) {
        c.setAttribute('name', c.getAttribute('name').replace('section0',newName));
        s += " - new name: "+c.name+"\n";
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
  var thisRow = tdCell.parentNode;
  var previousRow = thisRow.previousSibling;
  var parentNode = thisRow.parentNode;
  while( previousRow && previousRow.nodeName != "TR" ) {
    previousRow = previousRow.previousSibling;
  }
  if( !previousRow || previousRow.getAttribute("toofar") ) {
    parentNode.insertBefore(thisRow, document.getElementById("submitRow"));
    return;
  }
  parentNode.insertBefore(thisRow, previousRow);
}

function moveRowDown( tdCell ) {
  var thisRow = tdCell.parentNode;
  var nextRow = thisRow.nextSibling;
  var parentNode = thisRow.parentNode;
  while( nextRow && nextRow.nodeName != "TR" ) {
    nextRow = nextRow.nextSibling;
  }
  if( !nextRow || nextRow.getAttribute("toofar") ) {
    nextRow = thisRow;
    thisRow = parentNode.firstChild;
    while( thisRow.nodeName != "TR" || thisRow.getAttribute("toofar") ) {
      thisRow = thisRow.nextSibling;
    }
  }  
  parentNode.insertBefore(nextRow, thisRow);  
}

  function checkVisible( obj ) {
    var namePrefix = getNamePrefix(obj.name);
    var defName = namePrefix+'[default_val]';
    var reqName = namePrefix+'[is_required]';
    var defObj = document.fieldMapForm[defName];
    var reqObj = document.fieldMapForm[reqName];
    if( !defObj ) { alert("crap!"); }//debug
    if( defObj.value == null && reqObj.checked ) {
      alert("You cannot hide a required field unless it has a default value.");
      return false;
    }
    return true;
  }
  
  function getNamePrefix( nameStr ) {
    return nameStr.substr(0, obj.name.indexof('['))
  }
</script>