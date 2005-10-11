<!--

function KeyEvent( e ) {
  if( !e ) { return this; }
  
  // determine which control keys were pressed
  // replace undef with false, allowing for optional params
  this.ctrl = e && e.ctrlKey? true : false;
  this.alt = e && e.altKey? true : false;
  this.shift = e && e.shiftKey? true : false;
  this.source = KeyEvent.getSourceElement(e);

  // determine key which was pressed
  k = e.which? e.which : e.keyCode;
  this.keyCode = KeyEvent.generateKeyCode(k,this.shift);
  this.key = KeyEvent.generateKeyChar(this.keyCode);
}

KeyEvent.prototype.className = "KeyEvent";

/** 
 * Convert a string into a key event 
 *
 * The string is the name of a key, such as 'A', or 'ALT+SHIFT+Y' or 'CTRL+B'.  Note
 * that the SHIFT param must be included (capitalizing the letter is not sufficient) 
 */
KeyEvent.valueOf = function(s) {
  if( s+"" == "" ) { return null; }
  var parts = s.split("+");
  var k = '';
  var c = false;
  var s = false;
  var a = false;
  for(var i=0; i < parts.length; i++) {
    var x = parts[i].toUpperCase();
    if( x == 'CTRL' ) { c = true; }
    else if( x == 'ALT' ) { a = true; }
    else if( x == 'SHIFT' ) { s = true; }
    else { k = parts[i]; }
  }
  evt = new KeyEvent(null);
  evt.keyCode = KeyEvent.generateKeyCode(k.charCodeAt(0), s);
  evt.key = KeyEvent.generateKeyChar(evt.keyCode);
  evt.ctrl = c;
  evt.alt = a;
  evt.shift = s;
  return evt;
}

KeyEvent.keyCodeTranslations = {
  "41": 48, // ) to 0
  "33": 49, // ! to 1
  "64": 50, // @ to 2
  "35": 51, // # to 3
  "36": 52, // $ to 4
  "37": 53, // % to 5
  "94": 54, // ^ to 6
  "38": 55, // & to 7
  "42": 56, // * to 8
  "40": 57  // ( to 9
};

KeyEvent.generateKeyCode = function( keyCode, shift ) {
  if( KeyEvent.keyCodeTranslations[keyCode] ) {
    return KeyEvent.keyCodeTranslations[keyCode];
  }
  return keyCode;
}

KeyEvent.generateKeyChar = function( keyCode ) {
  return String.fromCharCode(keyCode).toUpperCase();
}

/** Convert a key event into a string, such as 'X', or 'CTRL+Y' or 'ALT+SHIFT+C' */
KeyEvent.prototype.toString = function() {
  var s = '';
  if( this.ctrl ) { s += 'CTRL'; }
  if( this.alt ) { s += this.ctrl? "+ALT" : "ALT"; }
  if( this.shift ) { s += (this.ctrl || this.alt)? "+SHIFT" : "SHIFT"; }
  if( s != "" ) { s += "+"; }
  s += this.key;
  return s;
}

/** An empty function that can be replaced to set an executable event */
KeyEvent.prototype.run = function() { alert("No run method has been declared for hot key: "+this.toString()); }

/** 
 * Determine if a particular key was pressed with given modifiers 
 * (accepts KeyEvent or a String)
 *
 * If key is a string, it is the name of a key, such as 'A', or 'ALT+SHIFT+Y' or 'CTRL+B'.  Note
 * that the SHIFT param must be included (capitalizing the letter is not sufficient) 
 */
KeyEvent.prototype.equals = function( k ) {
  if( !KeyEvent.isKeyEvent(k) ) { k = KeyEvent.valueOf( k ); }
  return k.key == this.key && k.alt == this.alt && k.shift == this.shift && k.ctrl == this.ctrl;
}

/**
 * Determine if there was a meta key pressed or if this is a straight keyboard
 * entry (which must be ignored in certain cases)
 */
KeyEvent.prototype.isMetaKey = function() {
  return this.alt || this.ctrl;
}

/** true if the object passed is not null, is an object, and has the className attribute of "KeyEvent" */
KeyEvent.isKeyEvent = function( suspectedObject ) {
  if( suspectedObject == null || !(typeof(suspectedObject) == "object") ) { return false; }
  return suspectedObject.className == "KeyEvent";
}

/**
 * Cancels key events when a key is let go of
 */
KeyEvent.cancelKey = function(keyPress) {
  var e = keyPress? keyPress : window.event;
  // ignore calls without an event
  if( !e ) { 
    if( debugOn ) { window.status = 'No event, keyup ignored'; }
    return; 
  }
  
  KeyEvent.hideHelp();
  ZenTabs.singleton.hide();
  
  // ignore control keys
  if( c == 18 ) { return; }

  // collect the keycode for validation
  var c = e.which? e.which : e.keyCode;

  // ignore keys without codes
  if( !c ) { 
    if( debugOn ) { window.status = 'No keycode, keyup ignored'; }
    return; 
  }
  
  // prevent toolbars from loading over hot keys
  var k = new KeyEvent(e);
  if( e && KeyEvent.findKey(k) ) {
    return false; 
  }
}

KeyEvent.hideHelp = function() {
  if( KeyEvent.showHelpOn > 0 ) {
    window.clearTimeout(KeyEvent.showHelpOn);
  }
  mClassX(window.document.getElementById('hotKeyHelp'),'hotKeyHelp invisible');
  KeyEvent.showHelpOn = false;
}

KeyEvent.showHelp = function() {
  if( !KeyEvent.showHelpOn ) { KeyEvent.showHelpOn = true; }
  mClassX(window.document.getElementById('hotKeyHelp'),'hotKeyHelp');
}

KeyEvent.showHelpOn = false;

/** 
 * Reads key events, tries to match with registered functions and run them. 
 * The function registered will be passed the KeyEvent and window Event each
 * time it is called.
 */
KeyEvent.getKey = function(keyPress) {
  if( KeyEvent.checkKey(keyPress) ) {
    return KeyEvent.keyPress(keyPress);
  }
  return true;
}

KeyEvent.keyPress = function(keyPress) {
  var k = new KeyEvent(keyPress? keyPress : window.event);
  if( debugOn ) { window.status = 'Caught key ['+k.keyCode+']'+k.toString(); }
  
  if( KeyEvent.targetsFormField(k) && !k.isMetaKey()) {
    // determine if we are in a form field and this is not a meta key
    // (if so, we ignore the event, because the user must be able to
    // type into the field)
    return true;
  }
  
  // determine if we have a key event registered
  var runKey = KeyEvent.findKey(k);
  if( runKey ) {
    if( debugOn ) { window.status = 'Matched key '+runKey.toString(); }
    return runKey.run(k, keyPress? keyPress : window.event);
  }
  return true;
}

KeyEvent.checkKey = function(keyPress) {
  var e = keyPress? keyPress : window.event;
  // ignore calls without an event
  if( !e ) { 
    if( debugOn ) { window.status = 'No event, keypress ignored'; }
    return;
  }
  
  // collect the keycode for validation
  var c = e.which? e.which : e.keyCode;
  // ignore keys without codes
  if( !c ) { 
    if( debugOn ) { window.status = 'No keycode, keypress ignored'; }
    return;
  }
  // ignore control keys
  if( c > 15 && c < 18 ) { 
    if( debugOn ) { window.status = 'Ignored control key '+c; }
    return;
  }
  else if( c == 18 ) {
    ZenTabs.singleton.start();
    if( !KeyEvent.showHelpOn ) {
      KeyEvent.showHelpOn = window.setTimeout('KeyEvent.showHelp()', 8000);
    }
    if( debugOn ) { window.status = 'Prepping showhelp: '+KeyEvent.showHelpOn; }
    return;
  }
  return true;
}

KeyEvent.findKey = function( k ) {
  var list = KeyEvent.listedEvents;
  for(var i=0; i < list.length; i++) {
    if( list[i].equals(k) ) {
      return list[i];
    }
  }
  return false;
}

KeyEvent.getSourceElement = function( e ) {
  if( e.target ) {
    return e.target;
  }
  else if( e.srcElement ) {
    return e.srcElement;
  }
}

KeyEvent.targetsFormField = function( keyEvent ) {
  var s = keyEvent.source;
  //alert('keyEvent.type|keyEvent.parent: '+s.type+"|"+s.parent);
  //alert('keyEvent.parent.type: '+s.parent.type);//debug
  if( s && s.parent && s.parent.type && s.parent.type == "form" ) {
    return true;
  }
  return false;
}


/** 
 * Generates a refresh event stored in a function
 */
KeyEvent.createLoadUrl = function( url ) {
  return function() {
    window.location = url; 
    return false;
  }
}

/**
 * Loads a new url
 */
KeyEvent.loadUrl = function(url) {
  window.location = url;
  return false;
}

/** 
 * Key name represents a key, such as 'A', or 'ALT+SHIFT+Y' or 'CTRL+B'.  Note
 * that the SHIFT param must be included (capitalizing the letter is not sufficient)
 */
KeyEvent.register = function(fxn, keyName) {
  var evt = KeyEvent.valueOf(keyName);
  evt.run = fxn;
  KeyEvent.listedEvents[KeyEvent.listedEvents.length] = evt;
}

KeyEvent.listedEvents = new Array();

function ZenTabs() {
  this.entries = new Array();
  this.visible = false;
  this.timeout = false;
}

ZenTabs.prototype.start = function() {
  if( this.visible ) { return; }
  if( this.timeout ) { return; }
  this.timeout = window.setTimeout('ZenTabs.singleton.show()', 1500);
}

ZenTabs.prototype.show = function() {
  if( this.visible ) { return; }
  if( this.timeout ) { window.clearTimeout(this.timeout); this.timeout = false; } 
  this.visible = true;
  for(var i=0; i < this.entries.length; i++) {
    window.document.getElementById(this.entries[i]).style.display = 'inline';
  }
}

ZenTabs.prototype.register = function(subToRegister) {
  this.entries[this.entries.length] = subToRegister;
}

ZenTabs.prototype.hide = function() {
  if( this.timeout ) { window.clearTimeout(this.timeout); this.timeout = false; }
  if( !this.visible ) { return; }
  this.visible = false;
  for(var i=0; i < this.entries.length; i++) {
    window.document.getElementById(this.entries[i]).style.display = 'none';
  }  
}

ZenTabs.singleton = new ZenTabs();
//-->