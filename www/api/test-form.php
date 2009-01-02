<?
  define("ZT_SECTION", "testapi");
  include("../header.php");
?><html>
<head>
<title>Test API Methods</title>
<style type='text/css'>

iframe {
  border: 1px solid #999;
  background-color: #aaa;
  font-family: monospace;
  font-size: x-small;
  width: 95%;
  height: 500px;
}

form {
  border-bottom: 10px solid #eee;
  padding: 10px;
  margin-bottom: 20px;
}

label {
  display: block;
  width: 100%;
  padding: 2px;
  margin-top: 5px;
}

fieldset {
  border: 1px solid #ddd;
  padding: 10px;
  float: left;
}

p { clear: both; }

legend { color: #aaa; }

input, select {
  margin-bottom: 5px;
}

</style>

<script type='text/javascript'>
function checkMethod(form) {
  var ff = form.elements['postget'];
  form.method = ff.options[ff.selectedIndex].value;
  
  // remove any previously added extra fields, for subsequent submits
  for(var i=0; i < form.elements.length; i++ ) {
    var e = form.elements[i];
    if( e.removeme ) { form.removeChild(e); }
  }
  
  // add extra fields as actual data in the form
  for(var i=0; i < 8; i++) {
    var fk = document.getElementById("addfield_"+i);
    var fv = document.getElementById("addval_"+i);
    if( fk.value ) {
      var e = document.createElement('input');
      e.type = 'hidden';
      e.value = fv.value;
      e.name = fk.value;
      e.removeme = 'removeme';
      form.appendChild(e);
    }
  }
  return true;
}
</script>
</head>
<body>

<div style='color:red; border: 1px solid red;'>This form isn't working in IE; Use FF</div>

<form target='resultFrame' action='test-submit.php?clear_session_cache=1' method='POST' onSubmit='return checkMethod(this);'>

<fieldset>
  <legend>Common Settings</legend>
<label for='action'>Action</label>
<select name='action' id='action'>
  <option>authenticate</option>
  <option>approve</option>
  <option>close</option>
  <option>config</option>
  <option>create</option>
  <option>list_users</option>
  <option>log</option>
  <option>notify_add</option>
  <option>notify_delete</option>
  <option>recent_logs</option>
  <option>search</option>
  <option>summary</option>
  <option>test</option>
  <option>translations</option>
  <option>view</option>
  <option>view_list</option>
  <option>view_log</option>
</select>
  
<label for='user'>user</label>
<input type='text' name='user' id='user' value='User'>

<label for='passphrase'>passphrase</label>
<input type='text' name='passphrase' id='passphrase'>

<label for='encpass'>encpass</label>
<input type='text' name='encpass' id='encpass'>
<br /><a target='_BLANK' href='http://www.zentrack.net/misc/md5.php'>get md5 encpass</a>

<label for='id'>id (ticket id)</label>
<input type='text' name='id' id='id' value='2'>
</fieldset>

<fieldset>
  <legend>Additional Fields</legend>

<table>
  <tr><th>Key</th><th>Value</th></tr>
<?
// changing the max value here (6) requires changing javascript above too!
for($i=0; $i<8; $i++) {
  print "<tr><td>";
  print "<input type='text' size='10' name='addfield_{$i}' id='addfield_{$i}'>";
  print "</td><td>";
  print "<input type='text' name='addval_{$i}' id='addval_{$i}'>";
  print "</td></tr>\n";
}
?>
</table>
</fieldset>

<fieldset>
  <legend>HTTP Format</legend>
<label for='postget'>Method</label>
<select id='postget' name='postget'><option selected>POST</option><option>GET</option></select>

<label for='format'>Method</label>
<select id='format' name='format'><option>xml</option><option>json</option></select>

<label for='debug'>Debug</label>
<input type='text' id='debug' name='debug' value='1' size='2'>

</fieldset>

<p><input type='submit' value='Call API [accesskey=c]' accesskey='c'></p>
</form>

<p>&nbsp;</p>
</body>
</html>