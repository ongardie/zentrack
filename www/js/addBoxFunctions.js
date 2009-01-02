
Zen.Addbox = new Function();

Zen.Addbox.doAddbox = function( e ) {
  var b = YAHOO.util.Event.getTarget(e);
  var vals = b.id.split("_");
  var prefix = vals[0]+"_"+vals[1]+"_"+vals[2];
  var form = b.form;
  var hidden_field = document.getElementById(vals[2]);
  var input_field = document.getElementById(prefix+"_input");
  var div = document.getElementById(prefix);
  var v = input_field.value;
  if( !v ) { return; }
  
  // Define the callbacks for the asyncRequest
  var callbacks = {
    
    success : function (o) {
      Zen.Addbox.parseAddboxResponse(o,div,v);
    },
    failure : function (o) {
      if (!YAHOO.util.Connect.isCallInProgress(o)) {
        Zen.Addbox.failedAddbox(o,div,origValue);
      }
    },
    timeout : 3000
  }
  
  // Make the call to the server for JSON data
  YAHOO.util.Connect.asyncRequest('GET',rootUrl+"/misc/find_recipient.php?q="+v, callbacks);
  input_field.select();
};

Zen.Addbox.dropAddboxEntry = function( div, a, e ) {
  if( a.className != 'invalid' ) {
    var id = Zen.Addbox.findHiddenField(div.id);
    Zen.Addbox.dropFromField(id,e);
  }
  div.removeChild(a);
};

Zen.Addbox.parseAddboxResponse = function( o, div, origValue ) {
  YAHOO.log("RAW JSON DATA: " + o.responseText);
  
  // Process the JSON data returned from the server
  var messages = [];
  try {
    messages = YAHOO.lang.JSON.parse(o.responseText);
  }
  catch (x) {
    alert("JSON Parse failed!\n\n"+o.responseText);
    return;
  }
  
  YAHOO.log("PARSED DATA: " + YAHOO.lang.dump(messages));
  
  if( !messages.length ) {
    Zen.Addbox.failedAddbox(o,div,origValue);
    return;
  }
  
  // The returned data was parsed into an array of objects.
  // Add a P element for each received message
  for (var i = 0; i < messages.length; ++i) {
    Zen.Addbox.newAddboxEntry( div, messages[i] );
  }
};

Zen.Addbox.newAddboxEntry = function( div, m, isError ) {
  var txt = Zen.Addbox.getAddboxText(m);
  var id = Zen.Addbox.getAddboxId(m);
  var hiddenField = Zen.Addbox.findHiddenField(div.id);
  if( document.getElementById(id) ) {
    // this entry has already been added!
    return;
  }
  var a = document.createElement('a');
  a.id = id;
  a.onclick = function() { Zen.Addbox.dropAddboxEntry(div, a, m); }
  if( isError || !m.email ) {
    a.className = "invalid";
    setTimeout( a.onclick, 3000 );
  }
  else {
    Zen.Addbox.addToField(hiddenField, m);
  }
  var message_text = document.createTextNode(txt);
  a.appendChild(message_text);
  div.appendChild(a);
};

Zen.Addbox.getAddboxText = function( m ) {
  var e = m.email? m.email : "no-email";
  var txt = m.name? m.name + ' <' + e + '>' : e;
  if( m.text ) { txt += ' ('+m.text+')'; }
  if( m.type ) { txt += ' ['+m.type+']'; }
  return txt;
};

Zen.Addbox.getAddboxId = function( m ) {
  if( m.email ) { return "addbox_entry_"+m.email; }
  else if( m.name ) { return "addbox_entry_"+m.name; }
  else { return "addbox_entry_"+Zen.Addbox.getAddboxText(m).replace(/['"]/, ""); }
};

Zen.Addbox.failedAddbox = function( o, div, origValue ) {
  var m = { name: origValue, type: "invalid" };
  Zen.Addbox.newAddboxEntry( div, m, true );
};

Zen.Addbox.fieldVals = {};
Zen.Addbox.getFieldVals = function(id) {
  if( !Zen.Addbox.fieldVals[id] ) { Zen.Addbox.fieldVals[id] = []; }
  return Zen.Addbox.fieldVals[id];
}

Zen.Addbox.addToField = function(id, m) {
  var vals = Zen.Addbox.getFieldVals(id);
  var d = document.getElementById(id);
  vals[vals.length] = Zen.Addbox.getFieldValue(m);
  d.value = vals.join("\t");
}

Zen.Addbox.dropFromField = function(id, m) {
  var vals = Zen.Addbox.getFieldVals(id);
  var d = document.getElementById(id);
  var v = Zen.Addbox.getFieldValue(m);
  var newvals = [];
  for(var i=0; i < vals.length; i++) {
    if( vals[i] != v ) {
      newvals[newvals.length] = vals[i];
    }
  }
  Zen.Addbox.fieldVals[id] = newvals;
  d.value = newvals.join("\t");
}

Zen.Addbox.findHiddenField = function(divId) {
  // the div layer is split into three parts, addbox_form_field
  // we want to remove the addbox_ and form_ elements... since field
  // might actually contain an _, we can't just rely on split : (
  return divId.substr(divId.indexOf("_", divId.indexOf("_")+1)+1);
}

Zen.Addbox.getFieldValue = function( m ) {
  return m.name? m.name+"|"+m.email : m.email; //todo
}

Zen.Addbox.keyCheck = function(e, id) {
  var key = new KeyEvent(e);
  if( key.keyCode == 13 ) {
    var b = document.getElementById(id);
    b.click();
    return false;
  }
  return true;
}