
/**
 * Move the focus to a given form field
 *
 * Checks to make sure field exists and is not disabled
 */
function placeFocus(formField) {
  if( formField && !formField.disabled ) {
    formField.focus();
  }
}

/**
 * Popup a new window
 *
 * The only required parameter is the loadpos, all others can be
 * defaulted by this method.
 *  (string)loadpos: url to load
 *  (string)name: name of popup
 *  (int)width: width of popup
 *  (int)height: height of popup
 *  (string)scrolls: 'yes' or 'no'
 *  (string)resizable: 'yes' or 'no'
 *  (string)menus: 'yes' or 'no' (this is all of them)
 *
 * Returns: false.. so that this can be used with a backup link, such as:
 *    <a href='myurl.html' onClick='return popupWindow(this.href)'>click</a>
 * 
 * In the example above, the link will run the onClick() method... if for some reason it fails
 * then the href="..." will run, opening the link in the current window.
 */
function popupWindow(loadpos, name, width, height, scroll, resizable, menus, xloc, yloc ) {
  if( !name ) { name = 'popup'; }
  if( !width ) { width = '200'; }
  if( !height ) { height = '200'; }
  if( !resizable ) { resizable = 'yes'; }
  if( !scroll ) { scroll = 'no'; }
  if( !menus ) { menus = 'no'; }
  if( xloc ) { xloc = "left="+xloc; }
  else { xloc = ""; }
  if( yloc ) { yloc = "top="+yloc; }
  else { yloc = ""; }
  controlWindow=window.open(loadpos,name,
			    "toolbar="+menus+",location="+menus+",directories="+menus+","
			    +"status="+menus+",menubar="+menus+",scrollbars="+scroll+","
			    +"resizable="+resizable+",width="+width+",height="+hieght);
  controlWindow.opener = this;
  controlWindow.window.focus();
  return(false);
}

/**
 * Create a popupWindow, center the window on the screen
 */
function popupWindowCentered(loadpos, name, w, h, scroll, resizable) {
  var x = (screen.width - w) / 2;
  var y = (screen.height - h) / 2;
  return popupWindow(loadpos, name, w, h, scroll, resizable, 'no', x, y);
}

/**
 * Create a popup window centered on the mouse
 */
function popupWindowAtMouse(winEvent, loadpos, name, w, h, scroll, resizable) {
  var x = 200;
  var y = 200;
  if( winEvent || window.event ) {
    // this locates the window at the mouse point if the window.event is available
    x = (winEvent)? winEvent.screenX : window.event.screenX;
    y = (winEvent)? winEvent.screenY : window.event.screenY;
  }
  return popupWindow(loadpos, name, w, h, scroll, resizable, 'no', x, y);
}

/**
 * Perform visual effects on a mouse over event
 *  - src is the td cell, form field, or object that will be affected
 *  - clrOver background color
 *  - txtOver new text color (if this is a cell and it contains a link)
 */
function mOvr(src,clrOver,txtOver) {
  src.style.cursor = 'hand'; 
  src.style.backgroundColor = clrOver;
  if( txtOver != null &&  txtOver != "" && src.children && src.children.tags ) {
    if( src.children.tags('A') && src.children.tags('A').length > 0 ) {
      src.children.tags('A')[0].style.color = txtOver;
    }
  }
}


/**
 * Perform visual effects on a mouse out event
 *  - src is the td cell, form field, or object that will be affected
 *  - clrIn background color
 *  - txtIn new text color (if this is a cell and it contains a link)
 */
function mOut(src,clrIn,txtIn) {
  src.style.cursor = 'default'; 
  src.style.backgroundColor = clrIn; 
  if( txtIn != null && txtIn != "" && src.children && src.children.tags ) {
    if( src.children.tags('A') && src.children.tags('A').length > 0 ) {
      src.children.tags('A')[0].style.color = txtIn;
    }
  }
}

/**
 * Click on a link inside a table cell when the cell is clicked
 *  - src is the td tag or tr tag clicked on
 *  - returns a boolean value true if click succeeded (for recursive use)
 */
function mClk(src) {
  var tags;
  // make sure the browser supports this feature
  if( src.children && src.children.tags ) {
    srcTags = src.children.tags;
    if( srcTags('A') && srcTags('A').length > 0 ) {
      // look for an anchor tag and try to click on it
      srcTags('A')[0].click();
      return true;
    }
    else if( srcTags('TD') ) {
      // if no anchor tag is found, see if we are in the <tr>
      // tag and traverse the TD tags
      var i = 0;
      while( i < srcTags('TD').length ) {
	if( mClk(srcTags('TD')[i]) ) { return true; }
      }
    }
  }
  return false;
}

/**
 * Focus on a form cell when the td cell it is in gets click on
 *  - src is the td cell or tr cell clicked on
 */
//todo
//todo
//todo
//todo
//todo
//todo

/**
 * Change the class='..' attribute of an object
 *  - obj is the object reference
 *  - class name is the new class name
 *  - cursorStyle is what to do with cursor (optional)
 */
function switchStyleDef( obj, classname, cursorStyle ) {
  if( cursorStyle ) { 
     obj.style.cursor = cursorStyle 
  }
  else {
     obj.style.cursor = 'default';
  }
  //refToElement.className = 'newclass', or refToElement.setAttribute('class', 'newclass')
  if( obj.className ) {
    obj.className = classname;
  }
  else {
    obj.setAttribute('class',classname);
  }
}

/**
 * Generate an email address that will prevent spamming
 */
function eLink(address, domain) {
  var full = address + "@" + domain;
  document.write("<a href='mailto:"+full+"'>"+full+"</a>");
}

/**
 * Toggles checking of checklists
 *
 *  fieldObj - the checkbox used to "check all"
 *  checklistName - the name of the checklist
 */
function checklistToggle( fieldObj, checklistName ) {
  var i=0;
  var s = checklistName + "["+i+"]";
  var formObj = locateForm(fieldObj);
  while( formObj[s] ) {
    formObj[s].checked = fieldObj.checked;
    i++;
    s = checklistName + "["+i+"]";
  }
} 

/**
 * Locate the form containing a given field
 *
 *  fieldObj - the field to locate in the DOM
 */
function locateForm(fieldObj) {
  if( fieldObj.parentNode && fieldObj.parentNode.action  ) {
    return fieldObj.parentNode;
  }
  else {
    var name = fieldObj.name;
    for(var i=0; i < document.forms.length; i++) {
      var form = document.forms[i];
      if( form[name] && form[name].value == fieldObj.value ) {
	return form;
      }
    }
  }
  return null;
}

/**
 * Set overlib properties
 */

// This variable determines if you want to use CSS or inline definitions.
// CSSOFF=no CSS    CSSSTYLE=use CSS inline styles    CSSCLASS=use classes
var ol_css = 53;

// Main background class (eqv of fgcolor)
// This is only used if CSS is set to use classes (ol_css = CSSCLASS)
var ol_fgclass = "overlibMainBg";

// Frame background class (eqv of bgcolor)
// This is only used if CSS is set to use classes (ol_css = CSSCLASS)
var ol_bgclass = "overlibFrameBg";

// Main font class
// This is only used if CSS is set to use classes (ol_css = CSSCLASS)
var ol_textfontclass = "overlibMainFont";

// Caption font class
// This is only used if CSS is set to use classes (ol_css = CSSCLASS)
var ol_captionfontclass = "overlibCaptionFont";

// Close font class
// This is only used if CSS is set to use classes (ol_css = CSSCLASS)
var ol_closefontclass = "overlibCloseFont";

