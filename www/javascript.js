<!--

function placeFocus(newFocalPoint) {
	newFocalPoint.focus();
}

function eLink(address, domain) {
  var full = address + "@" + domain;
  document.write("<a href='mailto:"+full+"'>"+full+"</a>");
}

//
//window functions
//

function popupWindow(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowScrolls(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowFull(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
	return(false);
}

function popupWindowCentered(loadpos, theName, w, h, scroll) {
  var winl = (screen.width - w) / 2;
  var wint = (screen.height - h) / 2;
  winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizab\
  le'
  win = window.open(loadpos, theName, winprops)
  if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
  return(false);
}

//
//table cell functions
//

function mOvr(src,clrOver,txtOver) {
	src.style.cursor = 'hand'; 
	src.style.backgroundColor = clrOver;
	if( txtOver != null &&  txtOver != "" ){
	  if( src.children && src.children.tags('A') && src.children.tags('A')[0] ) {
	    src.children.tags('A')[0].style.color = txtOver;
	  }
	}
}

function mOut(src,clrIn,txtIn) {
  src.style.cursor = 'default'; 
  src.style.backgroundColor = clrIn; 
  if( txtIn != null && txtIn != "" ){
    if( src.children && src.children.tags('A') && src.children.tags('A')[0] ) {
      src.children.tags('A')[0].style.color = txtIn;
    }
  }
}

function mClk(src) {
  if( src.childNodes ) {
    for( var i=0; i < src.childNodes.length; i++ ) {
      var n = src.childNodes[i];
      if( n.tagName == "A" ) {
        if( n.click ) { n.click(); }
        else { window.location = n.href; }
      }
    }
  }
}

function ticketClk( url ) {
  window.location = url;
  return false;
}

function mClassX( obj, classname, hand ) {
  if( hand ) { 
    obj.style.cursor = 'hand'; 
  }
  else {
    obj.style.cursor = 'default';
  }
  
  if( !classname && obj.oldStyle ) { classname = obj.oldStyle; }
  if( obj.className ) { obj.oldStyle = obj.className; }
  
  //refToElement.className = 'newclass', or refToElement.setAttribute('class', 'newclass')
  if( obj.setAttribute ) {
    obj.setAttribute('class',classname);
  }
  obj.className = classname;
}

function makeTimeString() {
  var date = new Date();
  return date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+"-"+date.getMilliseconds();
}

function mergeFunctions(fxn1, fxn2) {
  if( fxn1 ) {
    return function() {
      var fx = fxn1;
      var fy = fxn2;
      fx();
      fy();
    }
  }
  else {
    return fxn2;
  }
}

function checkMyBox(fieldName, event) {
  if( !event ) { event = window.event; }
  if( document.getElementById ) {
    var elem = document.getElementById(fieldName);
    if( elem ) {
      if( !event || !event.target || event.target.type != 'checkbox' ) {
        elem.checked = elem.checked? false : true;
      }
    }
    if( elem.parentNode ) { 
      elem.parentNode.parentNode.oldStyle = elem.checked? 'invalidCell' : 'cell'; 
    }    
  }
}

function quickHighlight( fieldName ) {
  var fieldObject = eval(fieldName);
  mClassX(fieldObject, 'mark');
  setTimeout("mClassX("+fieldName+")", 1000);
}

function undoHighlight( fieldObject ) {
  if( fieldObject.style ) { fieldObject.style.backgroundColor = ''; }  
}

function toggleField( fieldObj, disabledBoolean ) {
  fieldObj.disabled = disabledBoolean;
  if( !disabledBoolean ) {
    fieldObj.setAttribute('class', 'input');
    fieldObj.className = 'input';
  }
  else {       
    fieldObj.setAttribute('class', 'inputDisabled');
    fieldObj.className = 'inputDisabled';
  }       
}

/**
 * Admin Functions
 */
function addToOnload( newFxn ) {
  window.onload = mergeFunctions( newFxn, window.onload );
}

/**
 * Merges two functions
 */
function mergeFunctions( fxn1, fxn2 ) {
  return function() {
    var res = fxn1();
    if( res === false ) { return false; }
    res = fxn2();
    if( res === false ) { return false; }
    if( res === true ) { return true; }
  }
}

//-->
