<?
/**
 * This file depends on the $_GET['formset'] value to provide a list
 * of forms that will be managed.  If that list is not
 * provided than this javascript will be of little use.
 *
 * The form names can simply be separated by a space (or a single form name is fine)
 */

  include_once(dirname(__FILE__)."/header.php");  
  $behaviors = $zen->getBehaviorList();
?>
//<pre>

/**
 * Create a behavior map entry
 */
function BehaviorMapEntry(group_id, name, matchall, field, disabled) {
  this.group_id = group_id;
  this.name = name;
  this.matchall = matchall;
  this.field = field;
  this.fields = new Array();
  this.disabled = disabled;
}

BehaviorMapEntry.prototype.addField = function(name, operator, value) {
  this.fields[ this.fields.length ] = new BehaviorMapField( name, operator, value );    
}

/**
 * Create a field in a behavior map
 */
function BehaviorMapField(name, operator, value) {
  this.name = name;
  this.operator = operator;
  // always store value in lower case for case insensitive matching
  this.value = value == null? '' : value.toLowerCase();
}

/**
 * Create a group map entry
 */
function GroupMapEntry(id, name, table, evalType, evalText) {
  this.id = id;
  this.name = name;
  this.table = table;
  this.evalType = evalType;
  this.evalText = evalText;
  this.fields = new Array();
}

GroupMapEntry.prototype.addField = function(value, label) {
  if( !label ) { label = value; }
  this.fields[ this.fields.length ] = new GroupMapField( value, label );    
}

function GroupMapField(value, label) {
  this.value = value;
  this.label = label;
}

/**
 * Behavior map stores all behavior info.
 */
var behaviorMap = new Array();
<?
$fields = array();
if( is_array($behaviors) ) {
  foreach($behaviors as $b) {
    $bid = $b['behavior_id'];

    // generate the behaviorMap entry
    print "behaviorMap['$bid'] = new BehaviorMapEntry(";
    print $zen->fixJsVal($b['group_id']);
    print ",".$zen->fixJsVal($b['behavior_name']);
    print ",".$zen->fixJsVal($b['match_all']);
    print ",".$zen->fixJsVal($b['field_name']);
    print ",".($b['field_enabled']? 'false' : 'true');
    print ");\n";

    if( is_array($b['fields']) ) {
      foreach($b['fields'] as $f) {
	$fkey = $f['field_name'];
	// store the field to behavior mappings for use later
	if( !is_array($fields["$fkey"]) ) { $fields["$fkey"] = array(); }
	if( !in_array($bid, $fields["$fkey"]) ) {
	  $fields["$fkey"][] = $bid;
	}

	// here we are going to try to parse the field values into
	// a simple integer date that can be used for comparisons
	$val = $f['field_value'];
	if( strpos($f['field_name'], '_date') > 0 ) {
	  // can't be the first character, so 0 is not a concern
	  $val = $zen->dateParse($val);
	}
	
	// create the behavior fields objects
	print "  behaviorMap['$bid'].addField(";
	print $zen->fixJsVal($f['field_name']);
	print ",".$zen->fixJsVal($f['field_operator']);
	print ",".$zen->fixJsVal($val);
	print ");\n";
      }
    }
  }
}
?>

/**
 * Field map stores a list of behaviors which might be triggered
 * by a given field, so that when the field is edited, we can review
 * and trigger behavior events accordingly.
 */
var fieldMap = new Array();
<?
foreach($fields as $k=>$v) {
  print "fieldMap['{$k}'] = [".join(",",$v)."];\n";
}
?>

/**
 * Group map stores the group values which will be used by behaviors
 * to repopulate field values.
 */
var groupMap = new Array();
<?
$groups = $_SESSION['data_groups'];
if( is_array($groups) ) {
  foreach($groups as $g) {
    $k = $g['group_id'];
    // create the groupMap entry for this element
    print "groupMap['$k'] = new GroupMapEntry($k";
    print ','.$zen->fixJsVal($g['group_name']);
    print ','.$zen->fixJsVal($g['table_name']);
    print ','.$zen->fixJsVal($g['eval_type']);
    // encode the eval text to prevent corrupting
    // the javascript syntax
    print ", '".rawurlencode($g['eval_text'])."'";
    print ");\n";
    for($i=0; $i < count($g['fields']); $i++) {
      // add all fields used for matching to the group map entry
      $f = $g['fields'][$i];
      print "  groupMap['$k'].addField(";
      print $zen->fixJsVal($f['field_value']);
      print ','.$zen->fixJsVal($f['label']);
      print ");\n";
    }
  }
}
?>

// stores a list of fields which have been edited by a given run, so that
// we do not enter a recursive loop
var behaviorFlags = new Array();

// used for debugging this javascript set
var behaviorDebugMessages = new Array();

// set this to 1 to enable debuggins
var useBehaviorDebug = <?= $Debug_Mode ?>;

// stores a list of the most recently entered values for a given field
// this prevents updating a list with the values it already contains
// and also prevents inifinite loops
var behaviorHistoryMap = new Array();

/**
 * When a field value is changed, we will run it through
 * the fieldChangedBehavior() method and see if any behaviors
 * should be triggered.
 */
function fieldChangedBehavior( fieldObject ) {
  // debugging
  var fieldName = fieldObject? fieldObject.form.name+"."+fieldObject.name : "null";
  behaviorDebug(3, "(fieldChangedBehavior)"+fieldName);

  // clear any previously set flags
  clearBehaviorFlags();
  
  // recursively check behaviors for this field
  runFieldBehaviors( fieldObject );

  // output debug
  printBehaviorDebug();
}

/**
 * Checks a field to see if it should be triggered, runs recursively,
 * triggering subsequent events based on fields changed until either
 * no more behaviors can be triggered.
 *
 * The caller is expected to handle the clearing of the field flags
 * after completion, since this method doesn't know at what point
 * it is ok to clear them.
 */
function runFieldBehaviors( fieldObject ) {
  // generate a useful name for debugging
  var formName = fieldObject? fieldObject.form.name : "-null-";
  var fieldName = fieldObject? formName+"."+fieldObject.name : "-null-";

  // insure that this is a valid field and that it has
  // associated behaviors mapped in the fieldMap
  if( fieldObject && fieldObject.name && fieldMap[ fieldObject.name ] ) {
    behaviorDebug(3, "(runFieldBehaviors)reviewing behaviors for "+fieldName);

    // extract the associated behaviors and check each one
    // to see if it should be triggered.
    // We also count on the checkBehaviorStatus() method to
    // prevent infinite recursion.
    var behaviors = fieldMap[ fieldObject.name ];
    for(var i=0; i < behaviors.length; i++) {
      var behavior_id = behaviors[i];
      if( checkBehaviorStatus(fieldObject.form, behavior_id) ) {
	// when the method is triggered, the field it changed
	// may trigger a behavior in turn, so we will
	// use recursion to check that field as well
	var fieldAffected = executeBehavior(fieldObject.form, behavior_id);	
	var newFieldName = formName+"."+fieldAffected;
	behaviorDebug(3, "(runFieldBehaviors)updated field: ["+behavior_id+"]"+newFieldName);

	// fieldObject.form is a reference to the form object (Read Only)
	// which contains this field
	runFieldBehaviors( fieldObject.form[fieldAffected] );
      }
    }
    return true;
  }
  else {
    // just for debugging
    behaviorDebug(3, "(runFieldBehaviors)field ignored -- no behaviors: "+fieldName);
  }
  return false;
}

/**
 * Execute a behavior.  We flag all fields changed and insure
 * that they cannot be recursively edited by behaviors (to prevent
 * inifinite loops)
 *
 * This method returns the field affected by the behavior.
 */
function executeBehavior( formObj, behaviorId ) {
  behaviorDebug(3, "(executeBehavior)executing behavior "+behaviorId+"->"+formObj.name);
  var behavior = behaviorMap[ behaviorId ];
  var group = groupMap[ behavior.group_id ];
  
  if( !behavior || !group ) {
    behaviorDebug(1, "(executeBehavior)Behavior/group invalid: ["+behaviorId+"]");
    return false;
  }

  var fieldObj = formObj[ behavior.field ];
  if( !fieldObj ) {
    behaviorDebug(1, "(executeBehavior)Behavior field invalid: "+formObj.name+"."+behavior.field);
    return false;
  }

  // note that this behavior was executed
  // this may be true even if we don't get
  // a return value from setFormValsUsingGroup
  // because it may already contain the values
  // we attempt to set there
  addBehaviorFlag( behavior.field );

  // store field modified
  var fieldModified = false;

  // only return field if it exists and was changed
  if( setFormValsUsingGroup(fieldObj, group) ) {
    fieldModified = behavior.field;
  }

  // disable/enable field as appropriate
  fieldObj.disabled = behavior.disabled? true : false;

  if( fieldObj.disabled ) {
    mClassX(fieldObj, 'inputDisabled');
  }
  else {
    mClassX(fieldObj, 'input');
  }

  return fieldModified;
}

/**
 * Set the values of a form field to the list provided
 */
function setFormValsUsingGroup( fieldObj, group ) {
  // we keep a history to avoid redundantly setting the values if they
  // already are and to prevent infinite loops
  if( behaviorHistoryMap[ fieldObj.name ] == group.id && group.evalType != 'Javascript' ) {
    behaviorDebug(3, "(setFormValsUsingGroup)field "+fieldObj.name
		  +" is already set to "+group.name+" (skipping)");
    return false;
  }

  // record the group_id that we have used to generate the field's
  // current entries
  behaviorHistoryMap[ fieldObj.name ] = group.id;

  // handle javascript eval type
  if( group.evalType == 'Javascript' ) {
    // we encode the eval text so it won't cause erros in js
    // so we unencode it here and then replace occurences
    // of {form} with the form name
    var f = 'window.document.'+fieldObj.form.name;
    var vals = evalJsString( unescape(group.evalText).replace( /\{form\}/, f) );
    
    // clear any existing values from fields array
    group.fields = new Array();
    
    // only bother if vals were returned
    if( vals != null && vals.length > 0 ) {
      if( vals[0] && vals[0].value ) {
	// if each value of the array is a label/value pair
	// add the labels and values
	for( k in vals ) {
	  group.addField( vals[0].value, vals[0].label );
	}
      }
      else {
	// otherwise just set the values
	for( var i=0; i < vals.length; i++ ) {
	  group.addField( vals[i] );
	}
      }
    }
  }
  
  // set the field values
  behaviorDebug(3, "(setFormValsUsingGroup)updating "+fieldObj.name
		+" using "+group.name+"["+fieldObj.type+"]");
  switch( fieldObj.type ) {
  case "checkbox":
    if( group.fields[0].value ) {
      fieldObj.checked = true;
    }
    break;
  case "button":
  case "submit":
  case "text":
  case "textarea":
    fieldObj.value = group.fields[0].value;
    break;
  case "select":
  case "select-one":
  case "select-multiple":
    if( fieldObj.selectedIndex ) {
      // store the currently selected value and try to reproduce in a minute
      var oldValue = fieldObj.options[ fieldObj.selectedIndex ].value;
    }
    fieldObj.length = 0;
    for(var i=0; i < group.fields.length; i++) {
      var f = group.fields[i];
      behaviorDebug(3, "(setFormValsUsingGroup)Setting option "+i+" to ["+f.label+"]"+f.value);
      fieldObj.options[i] = new Option();
      fieldObj.options[i].text = f.label;
      fieldObj.options[i].value = f.value;
      // try to set to the same value if possible
      if( f.value == oldValue ) {
	fieldObj.options[i].selected = true;
      }
    }
    break;
  //case "radio":
  //case "file":
  //case "hidden":
  //case "password":
  //case "reset":
  default:
    behaviorDebug(1, "(setFormValsUsingGroup)Invalid field type: "+fieldObj.name+"["+fieldObj.type+"]");
    return false;
  }

  return true;
}

/**
 * Adds a field to the list of fields updated to prevent recursive looping
 */
function addBehaviorFlag( fieldName ) {
  if( fieldName ) {
    behaviorDebug(3, "Set behaviorFlag: "+fieldName);
    behaviorFlags[ fieldName ] = 1;
  }
}

/**
 * Clears out the list of fields that have been updated during a run
 * of behavior triggers
 */
function clearBehaviorFlags() {
  behaviorDebug(3, "(clearBehaviorFlags)all clear");
  behaviorFlags = new Array();
}

/**
 * Checks to see if conditions have been met to trigger a behavior
 */
function checkBehaviorStatus( formObject, behaviorId ) {
  // retrieve the behavior info
  var behavior = behaviorMap[ behaviorId ];

  // just a quick check for integrity
  if( !behavior ) {
    behaviorDebug(1, "(checkBehaviorStatus)Behavior id not found: "+behaviorId);
  }

  // debugging
  var formName = formObject.name? formObject.name : "-anonymous form-";
  behaviorDebug(3, "(checkBehaviorStatus)Checking status: ["
		+formName+"]"+behavior.name);

  // make sure this behaviors field isn't listed in the
  // flagged fields.  If it is, we return false to avoid
  // infinite recursion.
  if( behaviorFlags[ behavior.field ] ) { 
    behaviorDebug(2, "(checkBehaviorStatus)Behavior ignored -- field modified already: ["
		  +behavior.field+"]"+behavior.name);
    return false; 
  }

  // if there are no fields to match, then the behavior always runs.
  if( behavior.fields.length < 1 ) {
    behaviorDebug(3, "(checkBehaviorStatus)Always true -- no fields: "+behavior.name);
    return true;
  }

  // otherwise, we will check the fields and their 
  // match conditions, insuring that we monitor the 
  // "and" or "or" behavior specified.
  for(var i=0; i < behavior.fields.length; i++) {
    var f = behavior.fields[i];
    var matched = matchBehaviorCriteria( formObject, f );
    behaviorDebug(3, f.name+" "+f.operator+" "+f.value+" ["+matched+"]");

    // if matchall is set, then we must match every field
    // to succeed
    if( behavior.matchall && !matched ) { 
      return false; 
    }
    // otherwise, any match is a success
    if( !behavior.matchall && matched ) { 
      return true; 
    }
  }

  // in the event that we fall through, the return value
  // is true for matchall cases (all were matched) and false
  // otherwise (because none matched)
  return behavior.matchall;
}

/**
 * Matches a single field value against behavior criteria
 */
function matchBehaviorCriteria( formObject, behaviorMapField ) {
  var formField = formObject[ behaviorMapField.name ];

  // if the field doesn't exist, it didn't match
  if( !formField ) { 
    behaviorDebug(1, "(matchBehaviorCriteria)Field not found in form: "
		  +behaviorMapField.name);
    return false; 
  }

  fieldVal = getFormFieldValue(formField,behaviorMapField).toLowerCase();

  // otherwise, evaluate the match and deal accordingly
  switch( behaviorMapField.operator ) {
  case "eq":
    // equals
    return behaviorMapField.value == fieldVal;
  case "ne":
    // not equal
    return behaviorMapField.value != fieldVal;
  case "co":
    // contains
    return fieldVal.indexOf(behaviorMapField.value) > -1;
  case "nc":
    // does not contain
    return fieldVal.indexOf(behaviorMapField.value) < 0;
  case "sw":
    // starts with
    return fieldVal.indexOf(behaviorMapField.value) == 0;
  case "ew":
    // ends with
    var len1 = behaviorMapField.value.length;
    var len2 = fieldVal.length;
    var len3 = len2-len1;
    return len3 >= 0 &&
      fieldVal.substr(len3,len1) == behaviorMapField.value;
  case "gt":
    // greater than
    return fieldVal > behaviorMapField.value;
  case "lt":
    // less than
    return fieldVal < behaviorMapField.value;
  case "ge":
    // greater than or equal
    return fieldVal >= behaviorMapField.value;
  case "le":
    // less than or equal
    return fieldVal <= behaviorMapField.value;
  case "js":
    // evaluate js code
    var f = 'window.document.'+formField.form.name;
    behaviorMapField.value.replace(/\{form\}/, f);
    behaviorMapField.value.replace(/\{field\}/, f+'.'+formField.name);
    return eval(behaviorMapField.value);
  default:
    behaviorDebug(1, "Invalid comparator: "+behaviorMap.operator);
    return false;
  }
  
}

/**
 * Creates a debug message for behaviors
 */
function behaviorDebug( errorLevel, str ) {
  if( useBehaviorDebug >= errorLevel ) {
    str = "["+makeTimeString()+"] "+str;
    behaviorDebugMessages[ behaviorDebugMessages.length ] = [errorLevel, str];
  }
}

/**
 * Prints out debug messages
 */
function printBehaviorDebug() {
  var divBox = document.getElementById? document.getElementById("behaviorDebugDiv") : null;
  if( divBox ) {
    // generate or append our debug info to be placed in the div layer.
    var msg = divBox.innerHTML;
    if( !msg ) { msg = "<p>-----BEHAVIORS -----</p>\n"; }
    for(var i=0; i < behaviorDebugMessages.length; i++) {
      var m = behaviorDebugMessages[i];
      var lvl;
      if( divBox ) {
	switch(m[0]) {
	case 1:
	  lvl = "error";
	  break;
	case 2:
	  lvl = "";
	  break;
	default:
	  lvl = "note";
	}
	msg += "<span class='"+lvl+"'>"+m[1]+"</span>";
      }
      msg += "<br>\n";
    }
    divBox.innerHTML = msg;
  }
  behaviorDebugMessages = new Array();
}

/**
 * When the page loads, we want to check to see if any behaviors
 * should be run based on the loaded values and load corresponding
 * behavior info.
 */
function pageLoadedBehavior() {
  // debug output
  behaviorDebug(3, "(pageLoadedBehavior)running");
  
  // clear the behavior flags from any previous uses
  clearBehaviorFlags();

  var behaviorFormSet = new Array(<?
    if( $_GET['formset'] ) {
      $sep = false;
      foreach(explode(',',$_GET['formset']) as $b) {
	if( $sep ) { print ","; }
	print "window.document.".$zen->checkAlphaNum($b,'_.');
	$sep = true;
      }
    }
  ?>);

  // iterate over form elements and check for behaviors
  for( var x=0; x < behaviorFormSet.length; x++ ) {
    if( !behaviorFormSet[x] || !behaviorFormSet[x].elements ) {
      behaviorDebug(1, "(pageLoadedBehavior)invalid form: "+(behaviorFormSet[x]? behaviorFormSet[x].name : 'undefined'));
      continue;
    }
    behaviorDebug(3, "(pageLoadedBehavior)loading form: "+behaviorFormSet[x].name);
    for( var i=0; i < behaviorFormSet[x].elements.length; i++ ) {
      if( fieldMap[ behaviorFormSet[x].elements[i].name ] ) {
	setBehaviorOnChange( behaviorFormSet[x].elements[i] );
      }
      runFieldBehaviors( behaviorFormSet[x].elements[i] );
    }
  }

  // output debug
  printBehaviorDebug();
}

/**
 * Generate a function to handle onchange events for us
 */
function setBehaviorOnChange( formElement ) {
  var oldFun = formElement.onchange;
  formElement.onchange = genBehaviorFunction( formElement, oldFun );
}

/**
 * This extra method is needed to handle scoping problems with
 * creating anonymous functions
 */
function genBehaviorFunction( fieldObject, oldFunction ) {
  return function() {
    var x = null;
    if( oldFunction ) {
      x = oldFunction();
    }
    fieldChangedBehavior(fieldObject);
    if (typeof(x) == 'boolean') { return x; }
  }
}

/**
 * Return a form field value by detrmining the field type and extracting value
 */
function getFormFieldValue( formField, behaviorMapField ) {
  switch( formField.type ) {
  case "checkbox":
    return formField.checked;
  case "radio":
    for(var i=0; i < formField.length; i++) {
      if( formField[i].checked ) { return formField[i].value; }
    }
    return null;
  case "select":
  case "select-one":
  case "select-multiple":
    if( formField.selectedIndex < 0 ) { return null; }
    if( probablyNumericComparator(behaviorMapField) ) {
      return formField[ formField.selectedIndex ].value;
    }
    else {
      return formField[ formField.selectedIndex ].text;
    }
  default:
    // test for date values and try to do something sensible
    // with these so that they are useful
    if( behaviorMapField.name.indexOf("_date") > 0 ) {
      //can't begin with this, so zero is not a concern
      if( formField.value.match(/[^0-9]/) >= 0 ) {
	var val = Date.parse(formField.value);
	if( val > 0 ) { return val; }
      }
    }
    return formField.value;
  }
}

/**
 * Determine if a field should be matched on the numeric value or the string label
 */
function probablyNumericComparator( behaviorMapField ) {
  if( !isIntegerValue(behaviorMapField.value) ) { return false; }
  var op = behaviorMapField.operator;
  if( op == "eq" || op == "ne" || op == "gt" || op == "lt" || op == "ge" || op == "le" ) {   
    return true; 
  }
  return false;
}

/**
 * Determine if a value contains only numbers and is probably a valid id
 */
function isIntegerValue( val ) {
  return val.search(/[^0-9]/) < 0 && parseInt(val) > 0;
}

/**
 * Evaluate js code and return results
 */
function evalJsString( s ) {
  eval( s );
  return x;
}

window.onload = mergeFunctions( window.onload, pageLoadedBehavior );

//</pre>