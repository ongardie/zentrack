	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, October 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	

	var MSIE = navigator.userAgent.indexOf('MSIE')>=0?true:false;
	var navigatorVersion = navigator.appVersion.replace(/.*?MSIE (\d\.\d).*/g,'$1')/1;
	
	var form_widget_amount_slider_handle = imageUrl+'/slider_handle.gif';
	var slider_handle_image_obj = false;
	var sliderObjectArray = new Array();
	var slider_counter = 0;
	var slideInProgress = false;
	var handle_start_x;
	var event_start_x;
	var currentSliderIndex;
	
	function form_widget_cancel_event()
	{
		return false;		
	}
	
	function getImageSliderHeight(){
		if(!slider_handle_image_obj){
			slider_handle_image_obj = new Image();
			slider_handle_image_obj.src = form_widget_amount_slider_handle;
		}
		if(slider_handle_image_obj.width>0){
			return;
		}else{
			setTimeout('getImageSliderHeight()',50);
		}
	}
	
	function positionSliderImage(e,theIndex,inputObj)
	{
		if(this)inputObj = this;
		if(!theIndex)theIndex = inputObj.getAttribute('sliderIndex');
		var handleImg = document.getElementById('slider_handle' + theIndex);
		var ratio = sliderObjectArray[theIndex]['width'] / (sliderObjectArray[theIndex]['max']-sliderObjectArray[theIndex]['min']);
		var currentValue = sliderObjectArray[theIndex]['formTarget'].value-sliderObjectArray[theIndex]['min'];		
		handleImg.style.left = currentValue * ratio + 'px';			
		setColorByRGB();
	}
	
	function adjustFormValue(theIndex)
	{
		var handleImg = document.getElementById('slider_handle' + theIndex);	
		var ratio = sliderObjectArray[theIndex]['width'] / (sliderObjectArray[theIndex]['max']-sliderObjectArray[theIndex]['min']);
		var currentPos = handleImg.style.left.replace('px','');
		sliderObjectArray[theIndex]['formTarget'].value = Math.round(currentPos / ratio) + sliderObjectArray[theIndex]['min'];
		
	}
		
	function initMoveSlider(e)
	{
	
		if(document.all)e = event;	
		slideInProgress = true;
		event_start_x = e.clientX;
		handle_start_x = this.style.left.replace('px','');
		currentSliderIndex = this.id.replace(/[^\d]/g,'');
		return false;
	}
	
	function startMoveSlider(e)
	{
		if(document.all)e = event;	
		if(!slideInProgress)return;	
		var leftPos = handle_start_x/1 + e.clientX/1 - event_start_x;
		if(leftPos<0)leftPos = 0;
		if(leftPos/1>sliderObjectArray[currentSliderIndex]['width'])leftPos = sliderObjectArray[currentSliderIndex]['width'];
		document.getElementById('slider_handle' + currentSliderIndex).style.left = leftPos + 'px';
		adjustFormValue(currentSliderIndex);
		if(sliderObjectArray[currentSliderIndex]['onchangeAction']){
			eval(sliderObjectArray[currentSliderIndex]['onchangeAction']);
		}
	}
	
	function stopMoveSlider()
	{
		slideInProgress = false;
	}
	
	
	function form_widget_amount_slider(targetElId,formTarget,width,min,max,onchangeAction)
	{
		if(!slider_handle_image_obj){
			getImageSliderHeight();		
		}
				
		slider_counter = slider_counter +1;
		sliderObjectArray[slider_counter] = new Array();
		sliderObjectArray[slider_counter] = {"width":width - slider_handle_image_obj.width,"min":min,"max":max,"formTarget":formTarget,"onchangeAction":onchangeAction};
		
		formTarget.setAttribute('sliderIndex',slider_counter);
		formTarget.onchange = positionSliderImage;
		var parentObj = document.createElement('DIV');
		parentObj.style.width = width + 'px';
		parentObj.style.height = '12px';	// The height of the image
		parentObj.style.position = 'relative';
		parentObj.id = 'slider_container' + slider_counter;
		document.getElementById(targetElId).appendChild(parentObj);
		
		var obj = document.createElement('DIV');
		obj.className = 'form_widget_amount_slider';
		obj.innerHTML = '<span></span>';
		obj.style.width = width + 'px';
		obj.id = 'slider_slider' + slider_counter;
		obj.style.position = 'absolute';
		obj.style.bottom = '0px';
		parentObj.appendChild(obj);
		
		var handleImg = document.createElement('IMG');
		handleImg.style.position = 'absolute';
		handleImg.style.left = '0px';
		handleImg.style.zIndex = 5;
		handleImg.src = slider_handle_image_obj.src;
		handleImg.id = 'slider_handle' + slider_counter;
		handleImg.onmousedown = initMoveSlider;
		if(document.body.onmouseup){
			if(document.body.onmouseup.toString().indexOf('stopMoveSlider')==-1){
				alert('You allready have an onmouseup event assigned to the body tag');
			}
		}else{
			document.body.onmouseup = stopMoveSlider;	
			document.body.onmousemove = startMoveSlider;	
		}
		handleImg.ondragstart = form_widget_cancel_event;
		parentObj.appendChild(handleImg);
		positionSliderImage(false,slider_counter);
	}
		

	
	var namedColors = new Array('AliceBlue','AntiqueWhite','Aqua','Aquamarine','Azure','Beige','Bisque','Black','BlanchedAlmond','Blue','BlueViolet','Brown',
	'BurlyWood','CadetBlue','Chartreuse','Chocolate','Coral','CornflowerBlue','Cornsilk','Crimson','Cyan','DarkBlue','DarkCyan','DarkGoldenRod','DarkGray',
	'DarkGreen','DarkKhaki','DarkMagenta','DarkOliveGreen','Darkorange','DarkOrchid','DarkRed','DarkSalmon','DarkSeaGreen','DarkSlateBlue','DarkSlateGray',
	'DarkTurquoise','DarkViolet','DeepPink','DeepSkyBlue','DimGray','DodgerBlue','Feldspar','FireBrick','FloralWhite','ForestGreen','Fuchsia','Gainsboro',
	'GhostWhite','Gold','GoldenRod','Gray','Green','GreenYellow','HoneyDew','HotPink','IndianRed','Indigo','Ivory','Khaki','Lavender','LavenderBlush',
	'LawnGreen','LemonChiffon','LightBlue','LightCoral','LightCyan','LightGoldenRodYellow','LightGrey','LightGreen','LightPink','LightSalmon','LightSeaGreen',
	'LightSkyBlue','LightSlateBlue','LightSlateGray','LightSteelBlue','LightYellow','Lime','LimeGreen','Linen','Magenta','Maroon','MediumAquaMarine',
	'MediumBlue','MediumOrchid','MediumPurple','MediumSeaGreen','MediumSlateBlue','MediumSpringGreen','MediumTurquoise','MediumVioletRed','MidnightBlue',
	'MintCream','MistyRose','Moccasin','NavajoWhite','Navy','OldLace','Olive','OliveDrab','Orange','OrangeRed','Orchid','PaleGoldenRod','PaleGreen',
	'PaleTurquoise','PaleVioletRed','PapayaWhip','PeachPuff','Peru','Pink','Plum','PowderBlue','Purple','Red','RosyBrown','RoyalBlue','SaddleBrown',
	'Salmon','SandyBrown','SeaGreen','SeaShell','Sienna','Silver','SkyBlue','SlateBlue','SlateGray','Snow','SpringGreen','SteelBlue','Tan','Teal','Thistle',
	'Tomato','Turquoise','Violet','VioletRed','Wheat','White','WhiteSmoke','Yellow','YellowGreen');
	
	 var namedColorRGB = new Array('#F0F8FF','#FAEBD7','#00FFFF','#7FFFD4','#F0FFFF','#F5F5DC','#FFE4C4','#000000','#FFEBCD','#0000FF','#8A2BE2','#A52A2A','#DEB887',
	'#5F9EA0','#7FFF00','#D2691E','#FF7F50','#6495ED','#FFF8DC','#DC143C','#00FFFF','#00008B','#008B8B','#B8860B','#A9A9A9','#006400','#BDB76B','#8B008B',
	'#556B2F','#FF8C00','#9932CC','#8B0000','#E9967A','#8FBC8F','#483D8B','#2F4F4F','#00CED1','#9400D3','#FF1493','#00BFFF','#696969','#1E90FF','#D19275',
	'#B22222','#FFFAF0','#228B22','#FF00FF','#DCDCDC','#F8F8FF','#FFD700','#DAA520','#808080','#008000','#ADFF2F','#F0FFF0','#FF69B4','#CD5C5C','#4B0082',
	'#FFFFF0','#F0E68C','#E6E6FA','#FFF0F5','#7CFC00','#FFFACD','#ADD8E6','#F08080','#E0FFFF','#FAFAD2','#D3D3D3','#90EE90','#FFB6C1','#FFA07A','#20B2AA',
	'#87CEFA','#8470FF','#778899','#B0C4DE','#FFFFE0','#00FF00','#32CD32','#FAF0E6','#FF00FF','#800000','#66CDAA','#0000CD','#BA55D3','#9370D8','#3CB371',
	'#7B68EE','#00FA9A','#48D1CC','#C71585','#191970','#F5FFFA','#FFE4E1','#FFE4B5','#FFDEAD','#000080','#FDF5E6','#808000','#6B8E23','#FFA500','#FF4500',
	'#DA70D6','#EEE8AA','#98FB98','#AFEEEE','#D87093','#FFEFD5','#FFDAB9','#CD853F','#FFC0CB','#DDA0DD','#B0E0E6','#800080','#FF0000','#BC8F8F','#4169E1',
	'#8B4513','#FA8072','#F4A460','#2E8B57','#FFF5EE','#A0522D','#C0C0C0','#87CEEB','#6A5ACD','#708090','#FFFAFA','#00FF7F','#4682B4','#D2B48C','#008080',
	'#D8BFD8','#FF6347','#40E0D0','#EE82EE','#D02090','#F5DEB3','#FFFFFF','#F5F5F5','#FFFF00','#9ACD32');	
	
  var webColorRGB = new Array(
    "#330000","#333300","#336600","#339900","#33CC00","#33FF00","#66FF00","#66CC00",
    "#669900","#666600","#663300","#660000","#FF0000","#FF3300","#FF6600","#FF9900",
    "#FFCC00","#FFFF00","#330033","#333333","#336633","#339933","#33CC33","#33FF33",
    "#66FF33","#66CC33","#669933","#666633","#663333","#660033","#FF0033","#FF3333",
    "#FF6633","#FF9933","#FFCC33","#FFFF33","#330066","#333366","#336666","#339966",
    "#33CC66","#33FF66","#66FF66","#66CC66","#669966","#666666","#663366","#660066",
    "#FF0066","#FF3366","#FF6666","#FF9966","#FFCC66","#FFFF66","#330099","#333399",
    "#336699","#339999","#33CC99","#33FF99","#66FF99","#66CC99","#669999","#666699",
    "#663399","#660099","#FF0099","#FF3399","#FF6699","#FF9999","#FFCC99","#FFFF99",
    "#3300CC","#3333CC","#3366CC","#3399CC","#33CCCC","#33FFCC","#66FFCC","#66CCCC",
    "#6699CC","#6666CC","#6633CC","#6600CC","#FF00CC","#FF33CC","#FF66CC","#FF99CC",
    "#FFCCCC","#FFFFCC","#3300FF","#3333FF","#3366FF","#3399FF","#33CCFF","#33FFFF",
    "#66FFFF","#66CCFF","#6699FF","#6666FF","#6633FF","#6600FF","#FF00FF","#FF33FF",
    "#FF66FF","#FF99FF","#FFCCFF","#FFFFFF","#0000FF","#0033FF","#0066FF","#0099FF",
    "#00CCFF","#00FFFF","#99FFFF","#99CCFF","#9999FF","#9966FF","#9933FF","#9900FF",
    "#CC00FF","#CC33FF","#CC66FF","#CC99FF","#CCCCFF","#CCFFFF","#0000CC","#0033CC",
    "#0066CC","#0099CC","#00CCCC","#00FFCC","#99FFCC","#99CCCC","#9999CC","#9966CC",
    "#9933CC","#9900CC","#CC00CC","#CC33CC","#CC66CC","#CC99CC","#CCCCCC","#CCFFCC",
    "#000099","#003399","#006699","#009999","#00CC99","#00FF99","#99FF99","#99CC99",
    "#999999","#996699","#993399","#990099","#CC0099","#CC3399","#CC6699","#CC9999",
    "#CCCC99","#CCFF99","#000066","#003366","#006666","#009966","#00CC66","#00FF66",
    "#99FF66","#99CC66","#999966","#996666","#993366","#990066","#CC0066","#CC3366",
    "#CC6666","#CC9966","#CCCC66","#CCFF66","#000033","#003333","#006633","#009933",
    "#00CC33","#00FF33","#99FF33","#99CC33","#999933","#996633","#993333","#990033",
    "#CC0033","#CC3333","#CC6633","#CC9933","#CCCC33","#CCFF33","#000000","#003300",
    "#006600","#009900","#00CC00","#00FF00","#99FF00","#99CC00","#999900","#996600",
    "#993300","#990000","#CC0000","#CC3300","#CC6600","#CC9900","#CCCC00","#CCFF00",
    "#000000","#111111","#222222","#333333","#444444","#555555","#666666","#777777",
    "#888888","#999999","#AAAAAA","#BBBBBB","#CCCCCC","#DDDDDD","#EEEEEE","#FFFFFF",
    "#444444","#444444");
	
	var color_picker_div = false;
	var color_picker_active_tab = false;
	var color_picker_form_field = false;
	var color_picker_active_input = false;
	function baseConverter (number,ob,nb) {
		number = number + "";
		number = number.toUpperCase();
		var list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var dec = 0;
		for (var i = 0; i <=  number.length; i++) {
			dec += (list.indexOf(number.charAt(i))) * (Math.pow(ob , (number.length - i - 1)));
		}
		number = "";
		var magnitude = Math.floor((Math.log(dec))/(Math.log(nb)));
		for (var i = magnitude; i >= 0; i--) {
			var amount = Math.floor(dec/Math.pow(nb,i));
			number = number + list.charAt(amount); 
			dec -= amount*(Math.pow(nb,i));
		}
		if(number.length==0)number=0;
		return number;
	}
	
	function colorPickerGetTopPos(inputObj)
	{
		
	  var returnValue = inputObj.offsetTop;
	  while((inputObj = inputObj.offsetParent) != null){
	  	returnValue += inputObj.offsetTop;
	  }
	  return returnValue;
	}
	
	function colorPickerGetLeftPos(inputObj)
	{
	  var returnValue = inputObj.offsetLeft;
	  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
	  return returnValue;
	}
	
	function cancelColorPickerEvent(){
		return false;
	}
	
	function showHideColorOptions(e,inputObj)
	{
		

		var thisObj = this;
		if(inputObj){
			var parentNode = inputObj.parentNode; 
			thisObj = inputObj;
		}else var parentNode = this.parentNode;
		var activeColorDiv = false;
		var subDiv = parentNode.getElementsByTagName('DIV')[0];
		counter=0;	
		var initZIndex = 10;	
		var contentDiv = document.getElementById('color_picker_content').getElementsByTagName('DIV')[0];
		do{			
			if(subDiv.tagName=='DIV' && subDiv.className!='colorPickerCloseButton'){
				if(subDiv==thisObj){
					thisObj.className='colorPickerTab_active';
					thisObj.style.zIndex = 50;
					var img = thisObj.getElementsByTagName('IMG')[0];
					img.src = imageUrl+"/tab_right_active.gif"
					img.src = img.src.replace(/inactive/,'active');							
					contentDiv.style.display='block';
					activeColorDiv = contentDiv;
				}else{
					subDiv.className = 'colorPickerTab_inactive';	
					var img = subDiv.getElementsByTagName('IMG')[0];
					img.src = imageUrl+"/tab_right_inactive.gif";
					if(activeColorDiv)
						subDiv.style.zIndex = initZIndex - counter;
					else
						subDiv.style.zIndex = counter;
					contentDiv.style.display='none';
				}
				counter++;
			}
			subDiv = subDiv.nextSibling;
			if(contentDiv.nextSibling)contentDiv = contentDiv.nextSibling;
		}while(subDiv);
		
		
		document.getElementById('colorPicker_statusBarTxt').innerHTML = '&nbsp;';


	}
	
	function createColorPickerTopRow(inputObj){
		//var tabs = ['RGB','Named colors','Color slider'];
    var tabs = ['RGB','Color slider'];
		//var tabWidths = [37,90,70];
    var tabWidths = [37,70];
		var div = document.createElement('DIV');
		div.className='colorPicker_topRow';
	
		inputObj.appendChild(div);	
		var currentWidth = 0;
		for(var no=0;no<tabs.length;no++){			
			
			var tabDiv = document.createElement('DIV');
			tabDiv.onselectstart = cancelColorPickerEvent;
			tabDiv.ondragstart = cancelColorPickerEvent;
			if(no==0){
				suffix = 'active'; 
				color_picker_active_tab = this;
			}else suffix = 'inactive';
			
			tabDiv.id = 'colorPickerTab' + no;
			tabDiv.onclick = showHideColorOptions;
			if(no==0)tabDiv.style.zIndex = 50; else tabDiv.style.zIndex = 1 + (tabs.length-no);
			tabDiv.style.left = currentWidth + 'px';
			tabDiv.style.position = 'absolute';
			tabDiv.className='colorPickerTab_' + suffix;
			var tabSpan = document.createElement('SPAN');
			tabSpan.innerHTML = tabs[no];
			tabDiv.appendChild(tabSpan);
			var tabImg = document.createElement('IMG');
			tabImg.src = imageUrl+"/tab_right_" + suffix + ".gif";
			tabDiv.appendChild(tabImg);
			div.appendChild(tabDiv);
			if(navigatorVersion<6 && MSIE){	/* Lower IE version fix */
				tabSpan.style.position = 'relative';
				tabImg.style.position = 'relative';
				tabImg.style.left = '-3px';		
				tabDiv.style.cursor = 'hand';	
			}			
			currentWidth = currentWidth + tabWidths[no];
		
		}
		
		var closeButton = document.createElement('DIV');
		closeButton.className='colorPickerCloseButton';
		closeButton.innerHTML = 'x';
		closeButton.onclick = closeColorPicker;
		closeButton.onmouseover = toggleCloseButton;
		closeButton.onmouseout = toggleOffCloseButton;
		div.appendChild(closeButton);
		
	}
	
	function toggleCloseButton()
	{
		this.style.color='#FFF';
		this.style.backgroundColor = '#317082';	
	}
	function toggleOffCloseButton()
	{
		this.style.color='';
		this.style.backgroundColor = '';			
		
	}
	function closeColorPicker()
	{
		
		color_picker_div.style.display='none';
	}
	function createWebColors(inputObj){
		var webColorDiv = document.createElement('DIV');
		webColorDiv.style.paddingTop = '1px';
    webColorDiv.style.width = MSIE? "200px" : "235px";
		inputObj.appendChild(webColorDiv);
    var i;
    for(i=0; i < webColorRGB.length; i++) {
      var color = webColorRGB[i];
      var div = document.createElement('DIV');
      div.style.backgroundColor=color;
      div.innerHTML = '<span></span>';
      div.className = 'colorSquare'; 
      div.title = color;	
      div.onclick = chooseColor;
      div.setAttribute('rgbColor',color);
      div.onmouseover = colorPickerShowStatusBarText;
      div.onmouseout = colorPickerHideStatusBarText;
      webColorDiv.appendChild(div);
    }
	}
		
/*	function createNamedColors(inputObj){
		var namedColorDiv = document.createElement('DIV');
		namedColorDiv.style.paddingTop = '1px';
		namedColorDiv.style.display='none';
		inputObj.appendChild(namedColorDiv);
		for(var no=0;no<namedColors.length;no++){
			var color = namedColorRGB[no];
			var div = document.createElement('DIV');
			div.style.backgroundColor=color;
			div.innerHTML = '<span></span>';
			div.className='colorSquare';
			div.title = namedColors[no];	
			div.onclick = chooseColor;
			div.onmouseover = colorPickerShowStatusBarText;
			div.onmouseout = colorPickerHideStatusBarText;
			div.setAttribute('rgbColor',color);
			namedColorDiv.appendChild(div);				
		}	
	
	}*/
	
	function colorPickerHideStatusBarText()
	{
		document.getElementById('colorPicker_statusBarTxt').innerHTML = '&nbsp;';
	}
	
	function colorPickerShowStatusBarText()
	{
		var txt = this.getAttribute('rgbColor');
		if(this.title.indexOf('#')<0)txt = txt + " (" + this.title + ")";
		document.getElementById('colorPicker_statusBarTxt').innerHTML = txt;	
	}
	
	function createAllColorDiv(inputObj){
		var allColorDiv = document.createElement('DIV');
		allColorDiv.style.display='none';
		allColorDiv.className = 'js_color_picker_allColorDiv';
		allColorDiv.style.paddingLeft = '3px';
		allColorDiv.style.paddingTop = '5px';
		allColorDiv.style.paddingBottom = '5px';
		inputObj.appendChild(allColorDiv);	
		
		var labelDiv = document.createElement('DIV');
		labelDiv.className='colorSliderLabel';
		labelDiv.innerHTML = 'R';
		allColorDiv.appendChild(labelDiv);	
		
		var innerDiv = document.createElement('DIV');
		innerDiv.className = 'colorSlider';
		innerDiv.id = 'sliderRedColor';		
		allColorDiv.appendChild(innerDiv);		
		
		var innerDivInput = document.createElement('DIV');
		innerDivInput.className='colorInput';
		
		var input = document.createElement('INPUT');
		input.id = 'js_color_picker_red_color';
		input.maxlength = 3;
		input.style.width = '48px';
		input.style.fontSize = '11px';
		input.name = 'redColor';
		input.value = 0;
		
		innerDivInput.appendChild(input);
		allColorDiv.appendChild(innerDivInput);

		var labelDiv = document.createElement('DIV');
		labelDiv.className='colorSliderLabel';
		labelDiv.innerHTML = 'G';
		allColorDiv.appendChild(labelDiv);	
				
		var innerDiv = document.createElement('DIV');
		innerDiv.className = 'colorSlider';
		innerDiv.id = 'sliderGreenColor';		
		allColorDiv.appendChild(innerDiv);		
		
		var innerDivInput = document.createElement('DIV');
		innerDivInput.className='colorInput';
		
		var input = document.createElement('INPUT');
		input.id = 'js_color_picker_green_color';
		input.maxlength = 3;
		input.style.width = '48px';
		input.style.fontSize = '11px';
		input.name = 'GreenColor';
		input.value = 0;
		
		innerDivInput.appendChild(input);
		allColorDiv.appendChild(innerDivInput);
		
		var labelDiv = document.createElement('DIV');
		labelDiv.className='colorSliderLabel';
		labelDiv.innerHTML = 'B';
		allColorDiv.appendChild(labelDiv);			
		var innerDiv = document.createElement('DIV');
		innerDiv.className = 'colorSlider';
		innerDiv.id = 'sliderBlueColor';		
		allColorDiv.appendChild(innerDiv);		
		
		var innerDivInput = document.createElement('DIV');
		innerDivInput.className='colorInput';
		
		var input = document.createElement('INPUT');
		input.id = 'js_color_picker_blue_color';
		input.maxlength = 3;
		input.style.width = '48px';
		input.style.fontSize = '11px';
		input.name = 'BlueColor';
		input.value = 0;
		
		innerDivInput.appendChild(input);
		allColorDiv.appendChild(innerDivInput);

	
		var colorPreview = document.createElement('DIV');
		colorPreview.className='colorPreviewDiv';
		colorPreview.id = 'colorPreview';
		colorPreview.style.backgroundColor = '#000000';
		colorPreview.innerHTML = '<span></span>';	
		colorPreview.title = 'Click on me to assign color';	
		allColorDiv.appendChild(colorPreview);
		colorPreview.onclick = chooseColorSlider;
		
		var colorCodeDiv = document.createElement('DIV');
		colorCodeDiv.className='colorCodeDiv';		
		var input = document.createElement('INPUT');
		input.id = 'js_color_picker_color_code';
		
		colorCodeDiv.appendChild(input);
		input.maxLength = 7;
		input.style.fontSize = '11px';
		input.style.width = '48px';		
		input.value = '#000000';
		input.onchange = setPreviewColorFromTxt;
		input.onblur = setPreviewColorFromTxt;
		allColorDiv.appendChild(colorCodeDiv);
		
		var clearingDiv = document.createElement('DIV');
		clearingDiv.style.clear = 'both';
		allColorDiv.appendChild(clearingDiv);
		
		
		form_widget_amount_slider('sliderRedColor',document.getElementById('js_color_picker_red_color'),170,0,255,"setColorByRGB()");
		form_widget_amount_slider('sliderGreenColor',document.getElementById('js_color_picker_green_color'),170,0,255,"setColorByRGB()");
		form_widget_amount_slider('sliderBlueColor',document.getElementById('js_color_picker_blue_color'),170,0,255,"setColorByRGB()");
	}
	
	function setPreviewColorFromTxt()
	{
		if(this.value.match(/\#[0-6A-F]{6}/g)){
			document.getElementById('colorPreview').style.backgroundColor=this.value;
			var r = this.value.substr(1,2);
			var g = this.value.substr(3,2);
			var b = this.value.substr(5,2);
			document.getElementById('js_color_picker_red_color').value = baseConverter(r,16,10);
			document.getElementById('js_color_picker_green_color').value = baseConverter(g,16,10);
			document.getElementById('js_color_picker_blue_color').value = baseConverter(b,16,10);
			
			positionSliderImage(false,1,document.getElementById('js_color_picker_red_color'));
			positionSliderImage(false,2,document.getElementById('js_color_picker_green_color'));
			positionSliderImage(false,3,document.getElementById('js_color_picker_blue_color'));
		}
		
	}
  
  function colorChanged( obj ) {
    var b = window.document.getElementById("showColorPicker_"+obj.name);
    if( b ) {
      if(obj.value.match(/\#[0-6A-Fa-f]{6}/g)){
        b.style.backgroundColor = obj.value;
      }
    }
  }
	
	function chooseColor()
	{
		color_picker_form_field.value = this.getAttribute('rgbColor');
    color_picker_active_input.style.backgroundColor = color_picker_form_field.value;
		color_picker_div.style.display='none';
	}
	
	function createStatusBar(inputObj)
	{
		var div = document.createElement('DIV');
		div.className='colorPicker_statusBar';	
		var innerSpan = document.createElement('SPAN');
		innerSpan.id = 'colorPicker_statusBarTxt';
		div.appendChild(innerSpan);
		inputObj.appendChild(div);
	}
	
	function chooseColorSlider()
	{
		color_picker_form_field.value = document.getElementById('js_color_picker_color_code').value;
    color_picker_active_input.style.backgroundColor = color_picker_form_field.value; 
		color_picker_div.style.display='none';		
	}
	
	
	function showColorPicker(inputObj,formField)
	{
		if(!color_picker_div){
			color_picker_div = document.createElement('DIV');
			color_picker_div.id = 'dhtmlgoodies_colorPicker';
			color_picker_div.style.display='none';
			document.body.appendChild(color_picker_div);
			createColorPickerTopRow(color_picker_div);			
			var contentDiv = document.createElement('DIV');
			contentDiv.id = 'color_picker_content';
			color_picker_div.appendChild(contentDiv);			
			createWebColors(contentDiv);
			//createNamedColors(contentDiv);
			createAllColorDiv(contentDiv);
			createStatusBar(color_picker_div);			
		}
		if(color_picker_div.style.display=='none' || color_picker_active_input!=inputObj)color_picker_div.style.display='block'; else color_picker_div.style.display='none';		
		color_picker_div.style.left = colorPickerGetLeftPos(inputObj) + 'px';
		color_picker_div.style.top = colorPickerGetTopPos(inputObj) + inputObj.offsetHeight + 2 + 'px';
		color_picker_form_field = formField;
		color_picker_active_input = inputObj;		
	}

	function setColorByRGB()
	{
		var r = document.getElementById('js_color_picker_red_color').value.replace(/[^\d]/,'');
		var g = document.getElementById('js_color_picker_green_color').value.replace(/[^\d]/,'');
		var b = document.getElementById('js_color_picker_blue_color').value.replace(/[^\d]/,'');		
		if(r/1>255)r=255;
		if(g/1>255)g=255;
		if(b/1>255)b=255;
		r = baseConverter(r,10,16) + '';
		g = baseConverter(g,10,16) + '';
		b = baseConverter(b,10,16) + '';
		if(r.length==1)r = '0' + r;
		if(g.length==1)g = '0' + g;
		if(b.length==1)b = '0' + b;

		document.getElementById('colorPreview').style.backgroundColor = '#' + r + g + b;
		document.getElementById('js_color_picker_color_code').value = '#' + r + g + b;		
	}	