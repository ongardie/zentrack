<!--
  
function placeFocus(newFocalPoint) {
	eval(newFocalPoint.focus());
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
	  src.children.tags('A')[0].style.color = txtOver;
	}
}

function mOut(src,clrIn,txtIn) {
    src.style.cursor = 'default'; 
    src.style.backgroundColor = clrIn; 
    if( txtIn != null && txtIn != "" ){
      src.children.tags('A')[0].style.color = txtIn;
   }
}

function mClk(src) {
  if( src.children.tags('A') && src.children.tags('A').length > 0 ) {
    src.children.tags('A')[0].click();
  }
  else if( src.children.tags('TD') && src.children.tags('TD').length > 0 ) {
    src.children.tags('TD')[0].children.tags('A')[0].click();
  }
}

function ticketClk( url ) {
  window.location = url;
}

function mClassX( obj, classname, hand ) {
  if( hand ) { 
     obj.style.cursor = 'hand'; 
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

//-->
