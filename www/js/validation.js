
/**
 * Determine if an entry contains a numeric value or not
 *  - val is not a form field, it is the (string)value from the field(i.e. formField.value)
 */
function isNumeric( val ) {
  return !isNaN(parseFloat(val));
}

/**
 * Perform standard form validation using form_name and jsFormVals[form_name]
 * to determine fields to check and expected values.  The values of the
 * jsFormVals array entries are:
 *   0 - field name
 *   1 - required? 1 or 0
 *   2 - dataType, corresponds to meta data types (see db spec)
 *   3 - formType, form field type (see db spec)
 *   4 - label, label for this field
 */
function standardValidation( formName ) {
  // retrieve the fields to validate from
  // the jsFormVals container
  var fieldProps = jsFormVals[formName];

  // assume that if we don't find any jsFormVals for this
  // form, that we must not have anything to validate and
  // allow the user to continue
  if( !fieldProps ) {
    return true;
  }

  // a place to store errors
  var errors = new Array();

  // make sure there are values to check
  if( fieldProps && fieldProps.length > 0 ) {
    var i=0;
    for(i=0; i<fieldProps.length; i++) {
      var fieldName = fieldProps[i][0];
      var fieldObj = document.forms[formName][fieldName]; 

      // if we have found an existing field, then
      // run the validation
      if( fieldObj ) {

	// make sure the field is not disabled 
	// (user can't very well fix validation)
	if( fieldObj.disabled ) { continue; }

	if( fieldProps[1] && fieldObj.value == "" ) {
	  // see if the field is required
	  errors[errors.length] = ["field required: "+fieldProps[4], fieldObj]; 
	}
	else if( fieldObj.value ) {
	  // see if the value provided is valid
	  switch( fieldProps[2] ) {
	  case 'byte':
	  case 'shortint':
	  case 'integer':
	  case 'primarykey':
	  case 'decimal':
	  case 'long':
	    if( !isNumeric(fieldObj.value) ) {
	      errors[errors.length] = ["Not a valid number: "+fieldProps[4], fieldObj];
	    }
	  case 'email':
	    if( !fieldObj.value.match(/^[_a-z0-9]+(\.[_a-z0-9]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]+$/) ) {
	      errors[errors.length] = ["Invalid email address: "+fieldProps[4], fieldObj];
	    }
	    break;
	  case 'date':
	    //if( Date.parse(fieldObj.value) < 1 ) {
	    //  errors[] = ["Invalid date format: "+fieldProps[4], fieldObj];
	    //}
	    if( !checkDate(fieldObj) ) {
	      errors[errors.length] = ["Invalid date: "+fieldProps[4], fieldObj];
	    }
	    break;
	  default:
	    // all other cases are strings, so these entries are fine
	    break;
	  }
	}
      }
    }

    if( errors.length > 0 ) {
      // if there are any errors then cancel the submit,
      // highlight all of the fields with errors,
      // print out an error list, and set the focus
      // to the first field with an error
      var str = "There were problems with your entries:\n-----------------\n";
      for(var i=0; i < errors.length; i++) {
	str += errors[i][0]+"\n";
	switchStyleDef(errors[i][1], 'highlight');
	errors[i][1].onBlur = errors[i][1].onBlur? 
	  errors[i][1].onBlur+";switchStyleDef(this,'normal')" : "switchStyleDef(this,'normal')";
      }
      alert(str);
      errors[0][1].focus();
      return false;
    }
  }

  // if we made it this far, everything is fine
  return true;
}

var jsFormVals = new Array();

<!-- Original:  Mike Welagen (welagenm@hotmail.com), modified by Kato -->
var strDatestyle = "US"; // this is overridden in nav.php for euro dates
function checkDate(objName) {
  var strDate;
  var strDateArray;
  var strDay;
  var strMonth;
  var strYear;
  var intday;
  var intMonth;
  var intYear;
  var booFound = false;
  var datefield = objName;
  var strSeparatorArray = new Array("-"," ","/",".");
  var intElementNr;
  var err = 0;
  var strMonthArray = new Array(12);
  strMonthArray[0] = "Jan";
  strMonthArray[1] = "Feb";
  strMonthArray[2] = "Mar";
  strMonthArray[3] = "Apr";
  strMonthArray[4] = "May";
  strMonthArray[5] = "Jun";
  strMonthArray[6] = "Jul";
  strMonthArray[7] = "Aug";
  strMonthArray[8] = "Sep";
  strMonthArray[9] = "Oct";
  strMonthArray[10] = "Nov";
  strMonthArray[11] = "Dec";
  strDate = datefield.value;
  if (strDate.length < 1) {
    return true;
  }
  for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
    if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
      strDateArray = strDate.split(strSeparatorArray[intElementNr]);
      if (strDateArray.length != 3) {
	err = 1;
	return false;
      }
      else {
	strDay = strDateArray[0];
	strMonth = strDateArray[1];
	strYear = strDateArray[2];
      }
      booFound = true;
    }
  }
  if (booFound == false) {
    if (strDate.length>5) {
      strDay = strDate.substr(0, 2);
      strMonth = strDate.substr(2, 2);
      strYear = strDate.substr(4);
    }
  }
  if (strYear.length == 2) {
    strYear = '20' + strYear;
  }
  // US style
  if (strDatestyle == "US") {
    strTemp = strDay;
    strDay = strMonth;
    strMonth = strTemp;
  }
  intday = parseInt(strDay, 10);
  if (isNaN(intday)) {
    err = 2;
    return false;
  }
  intMonth = parseInt(strMonth, 10);
  if (isNaN(intMonth)) {
    for (i = 0;i<12;i++) {
      if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
	intMonth = i+1;
	strMonth = strMonthArray[i];
	i = 12;
      }
    }
    if (isNaN(intMonth)) {
      err = 3;
      return false;
    }
  }
  intYear = parseInt(strYear, 10);
  if (isNaN(intYear)) {
    err = 4;
    return false;
  }
  if (intMonth>12 || intMonth<1) {
    err = 5;
    return false;
  }
  if ((intMonth == 1 || intMonth == 3 
       || intMonth == 5 || intMonth == 7 
       || intMonth == 8 || intMonth == 10 
       || intMonth == 12) && (intday > 31 || intday < 1)) {
    err = 6;
    return false;
  }
  if ((intMonth == 4 || intMonth == 6 || intMonth == 9 
       || intMonth == 11) && (intday > 30 || intday < 1)) {
    err = 7;
    return false;
  }
  if (intMonth == 2) {
    if (intday < 1) {
      err = 8;
      return false;
    }
    if (LeapYear(intYear) == true) {
      if (intday > 29) {
	err = 9;
	return false;
      }
    }
    else {
      if (intday > 28) {
	err = 10;
	return false;
      }
    }
  }
  if (strDatestyle == "US") {
    datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
  }
  else {
    datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
  }
  return true;
}

function LeapYear(intYear) {
  if (intYear % 100 == 0) {
    if (intYear % 400 == 0) { return true; }
  }
  else {
    if ((intYear % 4) == 0) { return true; }
  }
  return false;
}
