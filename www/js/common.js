
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
 * The only required parameter is the loadpos, all others can be generated
 *  - loadpos: url to load
 *  - name: name of popup
 *  - width: width of popup
 *  - height: height of popup
 *  - scrolls: 'yes' or 'no'
 *  - resizable: 'yes' or 'no'
 *  - menus: 'yes' or 'no' (this is all of them)
 *
 * Returns: false.. so that this can be used with a backup link
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
  if( txtOver != null &&  txtOver != "" ){
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
  if( txtIn != null && txtIn != "" ){
    if( src.children.tags('A') && src.children.tags('A').length > 0 ) {
      src.children.tags('A')[0].style.color = txtIn;
    }
  }
}

/**
 * Click on a link inside a table cell when the cell is clicked
 *  - src is the td tag or tr tag clicked on
 */
function mClk(src) {
  if( src.children.tags('A') && src.children.tags('A').length > 0 ) {
    src.children.tags('A')[0].click();
  }
  else if( src.children.tags('TD') && src.children.tags('TD').length > 0 ) {
    var elem = src.children.tags('TD')[0];
    if( elem.children && elem.children.tags('A') && elem.children.tags('A').length > 0 ) {
      elem.children.tags('A')[0].click();
    }
  }
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

