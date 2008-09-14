
function placeFocus(newFocalPoint) {
  if( isFormField(newFocalPoint) && !isEditableField(newFocalPoint) ) { return; }
  if( newFocalPoint.select ) { newFocalPoint.select(); }
  else if( newFocalPoint.focus ) { newFocalPoint.focus(); }
}

function eLink(address, domain) {
  var full = address + "@" + domain;
  document.write("<a href='mailto:"+full+"'>"+full+"</a>");
}

//
//window functions
//
var controlWindow;

function popupWindow(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width="+theWidth+",height="+theHieght);
  controlWindow.focus();
	return(false);
}

function popupWindowScrolls(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
  controlWindow.focus();
	return(false);
}

function popupWindowFull(loadpos, theName, theWidth, theHieght ) {
	controlWindow=window.open(loadpos,theName,"toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width="+theWidth+",height="+theHieght);
  controlWindow.focus();
	return(false);
}

function popupWindowCentered(loadpos, theName, w, h, scroll) {
  var winl = (screen.width - w) / 2;
  var wint = (screen.height - h) / 2;
  winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizab\
  le'
  win = window.open(loadpos, theName, winprops)
  win.focus();
  return(false);
}

//
//table cell functions
//

function mOvr(src,clrOver,txtOver) {
	src.style.cursor = 'pointer'; 
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
    //alert('child nodes');//debug
    for( var i=0; i < src.childNodes.length; i++ ) {
      var n = src.childNodes[i];
      //alert(n+"|"+n.nodeName);//debug
      if( n.nodeName == "A" ) {
        //alert(n);
        if( n.onclick ) {
          //alert('onclickage: '+n.onclick);//debug
          n.onclick();
          break;
        }
        else if( n.href != '#' ) {
          //alert('hrefage: '+n.href);//debug
          window.location = n.href;
          break;
        }
      }
    }
  }
}

function confirmSubmit(formObject, msg) {
  if( window.confirm(msg) && formObject ) {
    formObject.submit();
  }
}

function ticketClk( url, evt, popup ) {
  var src = getEventSrc(evt);
  // don't override links
  // be careful of IE images... they report an href stupidly
  if( src && !src.src && src.href && src.href != url ) { return true; }
  // this is an image inside a link, let it run too
  var u = src && src.src && src.parentNode && src.parentNode.href? src.parentNode.href : false;
  if( u && u != url ) { return true; }
  // let user check boxes
  if( src && src.type == 'checkbox' ) { return true; }
  // nothing wrong, so go for it
  if( popup ) { 
    popupWindowScrolls(url, url, 500, 500 );
    KeyEvent.closeOnEscape(controlWindow);
  }
  else { window.location = url; }
  return false;
}

function mClassX( obj, classname, hand ) {
  if( hand ) { 
    obj.style.cursor = 'pointer'; 
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

function setClassX( obj, classname ) {
  obj.oldStyle = classname;
  if( obj.setAttribute ) {
    obj.setAttribute('class',classname);
  }
  obj.className = classname;
}

function makeTimeString() {
  var date = new Date();
  return date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+"-"+date.getMilliseconds();
}

function getEventSrc( evt ) {
  if( !evt || (!evt.srcElement && !evt.target) ) { evt = window.event; }
  return src = (evt && evt.srcElement)? evt.srcElement : 
      (evt && evt.target)? evt.target : false;
}

function checkMyBox(fieldName, event) {
  if( window.document.getElementById ) {
    var elem = window.document.getElementById(fieldName);
    if( elem ) {
      var src = getEventSrc(event);
      if( !src || (src.type != 'checkbox' && !src.src && !src.href) ) {
        // it's not an image (for a link) or the checkbox itself
        // checking the checkbox causes it to double-check
        // checking on hrefs is altogether bad
        elem.checked = elem.checked? false : true;
      }
      return elem.checked;
    }
  }
}

function checkMyRow(fieldName, event, uncheckedStyle, checkedStyle) {
  if( !checkedStyle ) { checkedStyle = 'invalidBars'; }
  if( !uncheckedStyle ) { uncheckedStyle = 'bars'; }
  var elem = window.document.getElementById(fieldName);
  if( elem ) {
    var c = checkMyBox(fieldName, event);
    var p = elem.parentNode? elem.parentNode.parentNode : false;
    if( p && p.nodeName == "TR" ) {
      setClassX(p, c? checkedStyle : uncheckedStyle);
    }
  }
}

function quickHighlight( fieldName, divToShow ) {
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
  if( window.onload ) {
    window.onload = mergeFunctions( window.onload, newFxn, true );
  }
  else {
    window.onload = newFxn;
  }
}

/**
 * Merges two functions
 */

function mergeFunctions( fxn1, fxn2, skipReturn ) {
  if( !fxn1 ) { return fxn2; }
  if( !fxn2 ) { return fxn1; }
  return function() {
    var res = fxn1();
    if( !skipReturn && res === false ) { return false; }
    res = fxn2();
    if( !skipReturn ) {
      if( res === false ) { return false; }
      if( res === true ) { return true; }
    }
  }
}

function openHelpBox(divObj, relativeElement, offsetY) {
  if( typeof(offsetY) == 'undefined' ) { offsetY = 25; }
  var pos = getAbsolutePos(relativeElement);
  divObj.style.left = pos.x;
  divObj.style.top = pos.y + 25;
  divObj.style.display = 'block';
  //divObj.style.position = 'absolute';
  setTimeout("closeHelpBox('"+divObj.id+"')", 3000);
}

function closeHelpBox(divObjName) {
  var divObj = window.document.getElementById(divObjName);
  if( divObj.style.display == 'block' ) {
    divObj.style.display = 'none';
  }
}

function getAbsolutePos(el) {
	var SL = 0, ST = 0;
	var is_div = /^div$/i.test(el.tagName);
	if (is_div && el.scrollLeft)
		SL = el.scrollLeft;
	if (is_div && el.scrollTop)
		ST = el.scrollTop;
	var r = { x: el.offsetLeft - SL, y: el.offsetTop - ST };
	if (el.offsetParent) {
		var tmp = this.getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
};

function printWindow() {
  popupWindowScrolls(rootUrl+"/actions/print.php?id="+id,'printWindow', 700, 500);
  return false;
}

function toggleDebug( type ) {
  var debugObj = window.document.getElementById('debugContent');
  if( !debugObj || !debugObj.childNodes ) { return; }
  for(var i=0; i < debugObj.childNodes.length; i++) {
    var child = debugObj.childNodes[i];
    if( child.nodeName == 'LI' ) {
      var c = child.className? child.className : child.getAttribute? child.getAttribute('class') : null;
      child.style.display = (type == 'all' || c == type)? 'block' : 'none';
    }
  }
}

function appendUrl(k, v) {
  v = escape(v);
  var u = window.location.href;
  if( u.indexOf("?"+k+"=") > 0 ) {
    var re = new RegExp("[?]"+k+"=[^&]+");
    u = u.replace(re, "?"+k+"="+v);
  }
  else if( u.indexOf("&"+k+"=") > 0 ) {
    var re = new RegExp("&"+k+"=[^&]+");
    u = u.replace(re, "&"+k+"="+v);
  }
  else {
    u += u.indexOf("?") > 0? "&"+k+"="+v : "?"+k+"="+v;
  }
  return u;
}

function updateUrl(k, v) {
  window.location = appendUrl(k,v);
}

function submitForm( formNode ) {
  if( typeof(formNode) == "string" ) { formNode = window.document.forms[formNode]; }
  if( !formNode.onsubmit || formNode.onsubmit() ) { formNode.submit(); }
}

function submitThisForm( obj ) {
  var formNode = obj.parentNode;
  while(formNode && !formNode.submit && formNode.nodeName != "DOCUMENT") {
    //alert("formNode="+formNode+", formNode.nodeName="+formNode.nodeName);
    formNode = formNode.parentNode;
  };
  if( formNode.submit ) {
    //alert("submitting "+formNode+"["+formNode.name+":"+formNode.nodeName+"]");
    submitForm(formNode);
  };
}

function doNothing() { return false; }

function isEditableField( e ) {
  if( !e || !e.type ) { return false; }
  if( e.disabled ) { return false; }
  switch( e.type ) {
    case "checkbox":
    case "text":
    case "textarea":
    case "file":
    case "select":
    case "select-one":
    case "select-multiple":
    case "radio":
    case "password":
      return true;
  }  
  return false;
}

function isFormField( e ) {
  if( !e || !e.type ) { return false; }
  switch( e.type ) {
    case "checkbox":
    case "text":
    case "textarea":
    case "file":
    case "select":
    case "select-one":
    case "select-multiple":
    case "radio":
    case "button":
    case "submit":
    case "hidden":
    case "password":
    case "reset":
      return true;
  }  
  return false;
}

function fieldFocus(form, field) {
  var f = window.document.forms[form].elements[field];
  placeFocus(f);
}

function buttonClick(form, button) {
  var f = window.document.forms[form].elements[button];
  if( !f || f.disabled ) { return; }
  if( !f.click ) {
    if( f.onclick ) { f.onclick(); }
    return; 
  }
  f.click();
}

var searchboxRand = 0;
function openSearchbox(form, field, mode, type, multi) {
  var url = rootUrl+"/helpers/searchbox.php?form="+form+"&field="+field+"&mode="+mode+"&type="+type+"&multi="+multi;
  //alert(url);
  var w = 400;
  var h = 300;
  // generates a unique window id which will not accidentally be duplicated
  // when calling this from multiple windows
  var rand = "searchbox_"+window.name+"_"+searchboxRand++;
  if( mode == 'ticket' || mode == 'project' ) { w = 550; h = 450; }
  if( mode == 'contact') { w = 700; h = 350; }
  popupWindowScrolls(url, rand, w, h);
}

function getSearchbox(form, field) {
  return window.document.getElementById(searchboxId(form,field));
}

function getSearchboxNode(form, field, key) {
  return window.document.getElementById(searchboxNodeId(form,field,key));
}

function searchboxId(form, field) {
  return "searchbox_"+form+"_"+field;
}

function searchboxNodeId(form, field, key) {
  return "searchnode_"+form+"_"+field+"_"+key;
}

function clearSearchboxVals(form, field) {
  var f = window.document.forms[form].elements[field];
  var d = getSearchbox(form, field);
  if( !f.value ) { return; }
  var ids = f.value.split(',');
  var i;
  for(i=0; i < ids.length; i++) {
    delSearchboxVal(form, field, ids[i]);
  }
  f.value = '';
}

function delSearchboxVal(form, field, key) {
  var n = getSearchboxNode(form, field, key);
  var f = window.document.forms[form].elements[field];
  // remove node from innerHTML
  n.parentNode.removeChild(n);
  // remove value from hidden field
  if( f.value ) {
    var ids = f.value.split(',');
    var newval = '';
    var i;
    for(i=0; i < ids.length; i++) {
      if( ids[i] == key ) { continue; }
      newval += newval? ','+ids[i] : ids[i];
    }
    f.value = newval;
  }
  // set innerHTML to -none- if no values
  if( !f.value ) {
    var d = getSearchbox(form,field);
    d.innerHTML = '-none-';
    d.onclick = function() { window.document.getElementById(searchboxId(form,field)+'_button').onclick(); }
  }
}

function addSearchboxVal(form, field, key, text, multi, required) {
  var f = window.document.forms[form].elements[field];
  var d = getSearchbox(form,field);
  if( !multi ) { clearSearchboxVals(form, field); }
  if( f.value ) {
    var ids = f.value.split(',');
    for(var i=0; i < ids.length; i++) {
      // the key is already listed, don't add it twice
      if( ids[i] == key ) { return; }
    }
  }
  if( !f.value ) { d.innerHTML = ''; d.onclick = function() {}; }
  f.value = f.value? f.value + ',' + key : key;
  var n1 = window.document.createElement("DIV");
  var n2 = window.document.createElement("DIV");
  var n3 = window.document.createElement("DIV");
  n1.innerHTML = key;
  n2.innerHTML = text;
  setClassX(n1, 'searchbox_atom_c1');
  setClassX(n2, 'searchbox_atom_c2');
  n1.onmouseover = function() { mClassX(this, "searchbox_atom_c1 atomon", true); }
  n1.onmouseout  = function() { mClassX(this); }
  n2.onmouseover = function() { mClassX(this, "searchbox_atom_c2 atomon", true); }
  n2.onmouseout  = function() { mClassX(this); }
  var node = window.document.createElement("DIV");
  node.id = searchboxNodeId(form,field,key);
  if( !required ) {
    node.onclick = function() { delSearchboxVal(form, field, key); }
  }
  setClassX(node, 'searchbox_atom');
  node.appendChild(n1);
  node.appendChild(n2);
  d.appendChild(node);
}

function ZenUtils () {}

ZenUtils.getSourceElement = function( e ) {
  if( e.target ) {
    return e.target;
  }
  else if( e.srcElement ) {
    return e.srcElement;
  }
}

var recentHistoryTimer = false;
var recentHistoryDivs = new Object();

function setupHistoryDiv( element ) {
  element.onmouseover = function() { mouseOverRecentHistory(element.id); }
  element.onmouseout = function(event) { mouseOutRecentHistory(event, element.id); }
  //element.onblur = function() { alert("blurred"); }
}

function mouseOverRecentHistory( id ) {
  recentHistoryDivs[id] = true;
  if( recentHistoryTimer ) { return ; }
  recentHistoryTimer = window.setTimeout(function() { expandRecentHistory(id); }, 1000);
}

function mouseOutRecentHistory(event, id) {
  recentHistoryDivs[id] = false;
  window.setTimeout(function() { contractRecentHistory(id); }, 300);
}

function expandRecentHistory( id ) {
  var element = getDocumentElement(id);
  if( !element || element.className == 'recentHistoryHover' ) { return; }
  element.className = 'recentHistoryHover';
  element.style.width = "250px";
}

function contractRecentHistory( id ) {
  if( recentHistoryDivs[id] ) { return; }
  if( recentHistoryTimer ) { 
    window.clearTimeout(recentHistoryTimer);
    recentHistoryTimer = false;
  }
  var element = getDocumentElement(id);
  if( !element || element.className == 'recentHistory' ) { return; }
  element.className = 'recentHistory';
  element.style.width = "100px";
}

function getDocumentElement( id ) {
  if( !window.document || !window.document.getElementById ) { return null; }
  return window.document.getElementById(id);
}
