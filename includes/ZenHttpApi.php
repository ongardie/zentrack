<?

/**
 * Reads parms from _GET or _POST and generates transactions, based on
 * the action specified by caller.
 */
class ZenHttpApi {
  
  /**
   * A basic factory pattern which abstracts the implementation details
   * and allows easy updates in the future, such as expanding this to
   * use different classes for xml and json
   *
   * This method automatically calls authenticate()!!
   *
   * @param string $format either 'xml' or 'json' for now
   * @return ZenHttpApi instance
   */
  function getInstance($format) {
    global $zen;
    global $map;
    $api = new ZenHttpApi($format, $zen, $map);
    $api->authenticate(false);
    return $api;
  }
  
  /**
   * Constructor
   * @param string $format
   * @param zenTrack $zen
   * @param ZenFieldMap $map
   */
  function ZenHttpApi($format, &$zen, &$map) {
    $this->format = $format;
    $this->authed = false;
    $this->zen = $zen;
    $this->map = $map;
    $this->actions = array();
    // parse class and determine implemented action names
    foreach( get_class_methods($this) as $m ) {
      if( preg_match("@^_api_([\w_]+)$@", $m, $matches) ) {
        $this->actions[] = $matches[1];
      }
    }
  }
  
  /**
   * Shortcut to call an action. The action must be one of the api calls
   * described at http://dev.zentrack.net/devwiki/index.php?title=ZT_API
   * @param string $action see description
   * @return mixed
   */
  function doAction($action) {
    // replace 'help' commands with the 'test' command
    if( $action == 'help' ) { $action = 'test'; }
    
    // check for actions requiring a post op and return a meaningful message
    // if the client tries a get instead
    if( empty($_POST) && !in_array($action, $this->actions_gettable) ) {
      return $this->_errTrxn("{$action} must be called via POST");
    }
    
    // check for actions requiring authentication (most of them) and make sure we're authenticated
    if( !$this->authed && !in_array($action, $this->actions_noauth) ) {
      return $this->_errTrxn("Invalid authentication");
    }
    
    // check to make sure authenticated user is allowed to perform action provided
    if( ($e = $this->_checkAccess($action)) !== true ) {
      return $e;
    }
    
    // strip invalid chars and avoid XSS attacks
    $action = preg_replace('/\W/', '', $action);
    $m = "_api_{$action}";
    if( !$action ) {
      return $this->_errTrxn("Must declare an action");
    }
    else if( method_exists($this, $m) ) {
      return $this->$m();
    }
    else {
      return $this->_errTrxn("Invalid action: $action");
    }
  }
  
  /**
   * Authenticate user login. If not successful,
   * returns a transaction that can be sent to client informing them of the error
   *
   * <p>Calling this method multiple times does not hurt, nor does it authenticate
   * more than once.
   *
   * @param boolean $trxn if called internally, no need to build trxn, so setting this to false skips it
   * @return mixed (string)trxn if $trxn = true or (boolean)true if authenticated
   */
  function authenticate($trxn) {
    if( !$this->user ) {
      
      // look up user and perform authtication, but only if it hasn't already
      // been tried
      $u = $this->getParm('user', true);
      $p = $this->getParm('encpass');
      if( !$p ) { $p = md5($this->getParm('passphrase', true)); }
      
      if( $u ) {
        $this->user = $this->zen->get_user_by_login($u);
        $this->user['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $this->user['homebinname'] = $this->zen->getBinName($this->user['homebin']);
        $this->uid = $this->user['user_id'];
        $this->ubins = $this->zen->getUsersBins($this->uid);

        //don't send this back to client ever!
        $encp = $this->user['passphrase'];
        unset($this->user['passphrase']); 
        if( $this->user && strlen($p) && $p == $encp) {
          $this->authed = true;
        }
      }
    }
    
    if( $trxn ) {
      // this is an actual API call to authenticate, so return results
      // never reveal which one is invalid! never return user object without a login first!
      return $this->_generateTransaction(
        ($this->authed ? "Authenticated" : "Invalid username or password"),
        $this->authed,
        $this->authed? $this->user : null);
    }
    else { 
      // this is just an internal auth, so no results needed
      return $this->authed;
    }
  }
  
  function _api_authenticate() {
    return $this->authenticate(true);
  }
  
  /**
   * Approve a ticket
   *
   * @return string formatted transaction string
   */
  function _api_approve() {
    //todo: make this work with contacts
    $comments = $this->getParm('text');
    $id = $this->getNumParm('id', true);
    $res = $this->zen->approve_ticket($id, $this->uid, $comments);
    return $this->_generateTransaction("Approve Ticket",($res? true : false),false,$id);
  }
  
  /**
   * Close a ticket
   *
   * @return string formatted transaction string
   */
  function _api_close() {
    //todo: make this work with contacts
    $comments = $this->getParm('text');
    $hours = $this->getNumParm('hours');
    $id = $this->getNumParm('id', true);
    $res = $this->zen->close_ticket($id, $this->uid, $hours, $comments);
    return $this->_generateTransaction("Close Ticket",($res? true : false),false,$id);
  }

  /**
   * Returns configuration settings as described in the API; a list of
   * commands that can be called and the ZT version number, etc.
   *
   * @return string formatted transaction string
   */
  function _api_config() {
    $vals = array();
    $vals = $this->_getDataTypes();
    $vals['version'] = $this->zen->getSetting("version_xx");
    $vals['actions'] = $this->actions;
    $vals['ticket_fields'] = $this->_getApiFields();
    return $this->_generateTransaction("System Config", true, $vals);
  }

  /**
   * Create a new ticket
   *
   * @return string formatted transaction string
   */
  function _api_create() {
    //check user is allowed to do this
    $bin_id = $this->getIdParm('bin', 'bins', true);
    if( !$bin_id ) { return $this->_errTrxn("No valid bin provided"); }
    else if( !$this->zen->checkAccess($this->uid, $bin_id, 'create') ) {
      return $this->_errTrxn("User not allowed to create tickets in this bin");
    }
    
    $errs = array();
    $custom = array();
    $contacts = array();
    $vals = array(
        'creator_id' => $this->uid,
        'bin_id'     => $bin_id,
        'otime'      => time() );
    $api_fields = $this->_getApiFields();
    $ticket_fields = $this->_getApiFields('ticket_create');
    foreach($ticket_fields as $f=>$fld) {
      // skip vals we created above, if they contain data
      //todo: make contacts and notify work here
      if( !empty($vals[$f]) || $f == 'notify' || $f == 'contacts' ) { continue; }

      // we check to make sure all the required create fields are in the api,
      // otherwise there's a problem we don't know how to resolve (user must
      // fill in a field but isn't allowed to view it)
      if( !array_key_exists($f, $api_fields) ) {
        if( $fld['required'] ) {
          Zen::addDebug("ZenHttpApi::create", "A required field for ticket create($f) is not in the api_view field map", 1);
        }
        continue;
      }
      
      if( $f != 'project_id' && strpos($f, '_id') === strlen($f)-3 ) {
        $type = substr($f, 0, -3)."s";
        $val = $this->getIdParm($f, $type, $fld['required']);
      }
      else if( $f == 'priority' ) {
        $val = $this->getIdParm($f, 'priorities', $fld['required']);
      }
      else {
        $val = $this->getParm($f, $fld['required']);
      }
      
      if( !$val && $fld['required'] ) {
        $errs[] = "{$fld['label']} is required";
      }
      else if( ZenFieldMap::isVariableField($f) ) {
        $custom[$f] = $val;
      }
      else {
        $vals[$f] = $val;
      }
    }
    
    /*
    //todo: make these come from field map
    //todo: can cheat and use global $map!
    $vals["title"] = $this->getParm("title");
    $vals["bin_id"]      = $this->getParm("bin");
    $vals["description"] = $this->getParm("description");
    $vals["creator_id"]  = $this->getParm("creator_id");
    $vals["priority"]  = 1;
    $vals["type_id"]   = 2;
    $vals["system_id"] = 1;
    */
    
    $id = false;
    if( empty($errs) ) {
      $errs = $this->zen->add_new_ticket($id, 
        array('standard'=>$vals, 'varfield'=>$custom, 'contacts'=>$contacts), 
        "Created from IP {$_SERVER['REMOTE_ADDR']}");
    }
    
    if( !empty($errs) ) {
      return $this->_generateTransaction(
        "Create Ticket Failed",
        false,
        $errs,
        $id,
        'error');
    }
    
    return $this->_generateTransaction(
      ($id? "Created ticket #{$id}" : "Failed to create ticket"),
      ($id? true : false),
      ($id? $this->zen->get_ticket($id) : null),
      $id);
  }
  
  /**
   * Return a list of valid users.  Only returns user data for users
   * the logged in account can see; all others should be shown as anonymous
   *
   * <p>A special filter is applied by using the api_view field map's 
   * user_filter setting. That can be one of several things:
   * <ul>
   *   <li>empty - no filter applied
   *   <li>string - anything with 'notes' field exactly matching string
   *   <li>/string/ - a regular expression to match
   * </ul>
   *
   * <p>Additionally, users with the same home bin can be included by checking
   * the special "user_filter_homebin" setting in api_view field map.
   */
  function _api_list_users() {
    $vars = $this->zen->get_users($this->ubins);
    
    $filter = $this->map->getViewProp('api_view', 'user_filter');
    $use_homebin = $this->map->getViewProp('api_view', 'user_filter_homebin');
    
    // if the filter is on, check our user list and strip results that don't match
    if( $filter ) {
      // regexp filters are specified by placing the string inside /.../ marks
      $regexp = preg_match("@^/.*/$@", $filter);
      $users = array();
      foreach($vars as $u) {
        // if use_homebin is specified, and the user's bin matches logged in user,
        // we ignore the filter
        if( $this->user['homebin'] == $u['homebin'] ||
            (!$regexp && $u['notes'] == $filter) || 
            ($regexp && preg_match($filter, $u['notes'])) ) {
          $users[] = $u;
        }
      }
    }
    // if the filter is off, just return the whole list
    else { $users = $vars; }
    
    return $this->_generateTransaction(
      "List Users",
      true,
      $users,
      null,
      'user',
      count($users)
      );
  }
  
  /**
   * Add a log to ticket
   *
   * @return string formatted transaction string
   */
  function _api_log() {
    $id = $this->getNumParm('id', true);
    $text = $this->getParm('text', true);
    $hours = $this->getFloatParm('hours');
    $task = $this->getAlphanumParm('task');
    $parms = array(
      'user_id' => $this->uid,
      'action'  => $task? $task : "LOG",
      'entry'   => $text,
      'hours'   => $hours);
    $lid = $this->zen->add_log($id, $parms);
    return $this->_generateTransaction(
      "New Log Entry", 
      ($lid? true : false),
      array("log_id" => $lid),
      $id);
  }
  
  /**
   * Add a recipient to notify list
   *
   * @return string formatted transaction string
   */
  function _api_notify_add() {
    //todo: implement
    //todo: avoid duplicates!
    return $this->_notReadyTrxn('notify_add');
  }
  
  /**
   * Remove a notify recipient
   *
   * @return string formatted transaction string
   */
  function _api_notify_delete() {
    //todo: implement
    return $this->_notReadyTrxn('notify_delete');
  }
  
  /**
   * Return a list of recent log entries. The default number returned is 25
   * thought it can be overridden by passing limit as an arg.
   *
   * @return string formatted transaction string
   */
  function _api_recent_logs() {
    // restrict logs to bins user can see
    $parms = array( "bin_id" => array("bin_id", "IN", $this->ubins) );
    
    $syslogs = $this->getNumParm('syslogs');
    if( !syslogs ) {
      $parms['user_id'] = array('user_id', '>', 0);
    }

    // determine if we're paging
    $page = $this->getNumParm('page');
    if( !$page ) { $page = 0; }

    // the default limit is 25, unless one is passed as an arg
    $limit = $this->getNumParm('limit');
    if( !$limit ) { $limit = 25; }
    
    // a client can override the default behavior and make it an or
    $or = $this->getNumParm('or');

    // get the logs
    $logs = $this->zen->search_logs($parms, ($or? 'OR' : 'AND'), $page, $limit);
    
    return $this->_generateTransaction(
        'Recent Logs',
        is_array($logs),
        $logs,
        false,
        'log',
        $this->zen->total_records
      );
  }
  
  /**
   * Search for matching tickets
   *
   * @return string formatted transaction string
   */
  function _api_search() {
    $parms = array();
    foreach($this->_getApiFields() as $f=>$fld) {
      $v = $this->getParm($f, $fld['required']);
      if( $v ) {
        $parms[$f] = $this->_searchParm($f, $v);
      }
    }
    
    $sort = $this->getParm('sortby');
    if( $sort ) { $sort = preg_replace('@[^\w_,]@', '', $sort); }
    else { $sort = 'status DESC, ctime DESC'; }
    
    $limit = $this->getNumParm('limit');
    
    $tickets = $this->zen->search_tickets($parms, 'OR', 0, $sort, $limit);

    return $this->_generateTransaction(
        'Search Results',
        true,
        $tickets,
        false,
        'ticket',
        $this->zen->total_records
      );
  }
  
  /**
   * Return a summary about opened tickets and so on
   *
   * @return string formatted transaction string
   */
  function _api_summary() {
    //todo: implement (maybe remove?)
    return $this->_notReadyTrxn('summary');
  }
  
  /**
   * Just return a generic result for testing
   */
  function _api_test() {
    return $this->_generateTransaction(
        "Test successful",
        true,
        array_merge($_GET, $_POST),
        false,
        'arg'
      );
  }
  
  /**
   * Return a list of translation strings
   *
   * @return string formatted transaction string
   */
  function _api_translations() {
    //todo: implement (just return all translations for now)
    return $this->_notReadyTrxn('translations');
  }
  
  /**
   * View a ticket
   *
   * @return string formatted transaction string
   */
  function _api_view() {
    $id = $this->getNumParm('id', true);
    $ticket = $this->zen->get_ticket($id);
    if( $this->getParm('logs') ) {
      $ticket['logs'] = $this->zen->get_logs($id);
    }
    return $this->_generateTransaction(
        ($ticket? "Ticket results" : "Couldn't find ticket"),
        ($ticket? true : false),
        $ticket,
        $id
      );
  }
  
  /**
   * View a log for ticket
   *
   * @return string formatted transaction
   */
  function _api_view_log() {
    $id = $this->getNumParm('id', true);
    $logs = $this->zen->get_logs($id);
    return $this->_generateTransaction(
      ($logs? "Logs for ticket #{$id}" : "No logs found for ticket #{$id}"),
      ($logs? true : false),
      $logs,
      $id,
      'log');
  }
  
  /**
   * View a ticket
   *
   * @return string formatted transaction string
   */
  function _api_view_list() {
    //todo: this should check for contact user and use the 'contact' parm if it exists
    //todo: which requires an entirely different lookup strategy
    
    $parms["user_id"] = $this->uid;
    $bin = $this->getIdParm('bin', 'bins');
    if( $bin ) { $parms['bin_id'] = $bin; }
    $result = $this->zen->get_tickets($parms);
    return $this->_generateTransaction(
        ($tickets? "Ticket results" : "No tickets found"),
        ($tickets? true : false),
        $result,
        false,
        'ticket',
        $this->zen->total_records
      );
  }
  
  /**
   * generate the formatted results suitable for returning to client
   * @param string $message
   * @param boolean $success
   * @param array $results indexed array of values to put in the results node
   * @param int $id the id of ticket if provided
   * @param string $defaultResultsNode a name for the results nodes in xml, see {@link self::_genXmlNodeName()}
   * @return string either json or xml format
   */
  function _generateTransaction($message, $success, $results = false, $id = false, 
                                $defaultResultsNode = false, $rows = false) {
    if( $this->format == 'xml' ) {
      return $this->_generateXmlResult($message, $success, $results, $rows, $id, $defaultResultsNode);
    }
    else {
      return $this->_generateJsonResult($message, $success, $results, $rows, $id);
    }
  }
  
  function _generateXmlResult($message, $success, $results = false, $rows = false, 
                              $id = false, $defaultResultsNode = false) {
    $txt = "<?xml version=\"1.0\"?>\n<zenapi_results>\n";
    $message = $this->_escapeParm($message);
    $txt .= "  <message>$message</message>\n";
    $vals = array("success" => $success, "results" => $results);
    if( $rows !== false ) { $vals['total_rows'] = $rows; }
    $d = $this->getNumParm('debug');
    if( $d ) {
      $messages = $this->zen->debugMessages;
      if( !empty($messages) ) {
        $vals['debug_messages'] = array();
        foreach($messages as $m) {
          if( $m[2] <= $d ) {
            $msg = is_array($m[1])? join(",", $m[1]) : $m[1];
            $vals['debug_messages'][] = array('method'=>$m[0], 'severity'=>$m[2], 'message'=>$msg);
          }
        }
      }
    }
    if( $id ) {  $vals['id'] = $id; }
    $txt .= $this->_genXmlParms( $vals, $defaultResultsNode );
    $txt .= "</zenapi_results>\n";
    return $txt;
  }
  
  /**
   * generate formatted parameters for use in xml transaction
   * @param array $parms indexed array of key/value pairs, the key becomes the xml node
   * @param string $default a name for the results nodes in xml, see {@link self::_genXmlNodeName()}
   * @return string
   */
  function _genXmlParms($parms, $default = false, $parent = false, $indent = 2) {
    $txt = '';
    foreach($parms as $key=>$val) {
      // if a prefix is provided, prefer it to a numeric node name
      list($nodeOpen, $nodeClose) = $this->_genXmlNodeName($key, $default, $parent);
      $txt .= str_pad('', $indent, ' ', STR_PAD_LEFT);
      if( is_array($val) ) {
        if( count($val) ) {
          $txt .= "<{$nodeOpen}>\n";
          $txt .= $this->_genXmlParms($val, $default, $key, $indent+2);
          $txt .= str_pad('', $indent, ' ', STR_PAD_LEFT)."</{$nodeClose}>\n";
        }
        else {
          $txt .= "<{$nodeOpen} />\n";
        }
      }
      else {
        $v = $this->_escapeParm($val);
        if( is_null($v) ) {
          $txt .= "<{$nodeOpen} />\n";
        }
        else {
          $txt .= "<{$nodeOpen}>$v</{$nodeClose}>\n";
        }
      }
    }
    return $txt;
  }
  
  /**
   * Generate an xml node name.
   *
   * <p>For a non-numeric key, returns the key (it's a suitable node name), unless
   * the node name is 'results', in which case it tries to formulate a suitable
   * name.
   *
   * <p>This uses the nodename provided, or it
   * tries to generate a meaningful node name using the parent node's name
   * or it will simply return the numeric key if necessary.
   *
   * <p>For the 'results' node, the children can be given a meaningful name
   * using the $default variable.
   *
   * <p>For data types (priorities, tasks, bins, etc) the ids are automagically
   * preserved as the node names.
   *
   * @param mixed $key (string)name of this node or (int)array index
   * @param string $parentNode name of the parent node (false for root nodes)
   * @param string $default a default node name to use (see description)
   * @return string
   */
  function _genXmlNodeName($key, $default = false, $parentNode = false) {
    if( !is_numeric($key) ) {
      // if the key isn't a number, it's already a good node name
      return array($key, $key);
    }

    if( $parentNode == 'results' && $default ) {
      // the nodes inside 'results' can be speficially set to a meaningful name
      // by passing the value as the parent here
      return array($default, $default);
    }
    
    // for data types, the node name is an id, so don't replace it
    $datatype = $parentNode && in_array($parentNode, array('priorities', 'bins', 'tasks', 'types', 'systems'));

    if( $parentNode == 'priorities' ) {
      // can't strip the 's' to make this singular, so manually specify it
      $n = 'priority';
    }
    else if( !is_numeric($parentNode) && preg_match('@s$@', $parentNode) ) {
      // we try to derive a meaningful node name from the parent tag if it's plural
      $n = substr($parentNode,0,-1);
    }
    else {
      $n = 'value';
    }
    
    return $datatype? array("$n id=\"$key\"", $n) : array($n, $n);
  }
  
  /**
   * Escape a string of text for use in xml, convert to CDATA tags as needed
   * @param string $txt
   * @return string
   */
  function _escapeParm($txt) {
    if( is_bool($txt) ) {
      return $txt? 1 : null;
    }
    else if( !strlen($txt) ) {
      return null;
    }
    else if( preg_match("/^[\w\d_.,\$ -]+$/", $txt) ) {
      return $txt;
    }
    else {
      $txt = str_replace("]]>", "&#93;&#93;>", $txt);
      return "<![CDATA[$txt]]>";
    }
  }
   
  
  function _generateJsonResult($message, $success, $results = false, $rows = false, $id = false) {
    $vals = array(
            "message" => $message,
            "success" => $success,
            "results" => $results,
          );
    if( $rows !== false ) { $vals['total_rows'] = $rows; }
    if( $id ) { $vals['id'] = $id; }
    return json_encode($vals);
  }
  
  /**
   * Return a data type id from a parameter value, which might be an (int)id,
   * or a (string)match to find
   *
   * @param string $type any value from {@link self::_getDataTypes}, 'user', or 'contact'
   * @see getParm()
   */
  function getIdParm($key, $type, $required = false, $get = false) {
    // get the parameter
    $val = $this->getParm($key, $required, $get);
    
    // check the obvious first
    if( !$val ) { return false; }
    else if( is_numeric($val) ) { return $val; }
    
    // we do case insensitive matching
    $val = strtolower($val);
    
    if( $type == 'user' ) {
      //todo: make this search users by name, initials, and email
      return false;
    }
    else if( $type == 'contact' ) {
      //todo: make this search contacts by name and email
      return false;
    }
    else {
      // we get the data type and look for matches
      $types = $this->_getDataTypes();
      $possibles = array();
      foreach($types[$type] as $k=>$v) {
        $v = strtolower($v);
        if( $v == $val ) {
          // if there is an exact match, return it
          return $k;
        }
        else if( strpos($v, $val) !== false ) {
          // if there is a close match, store it
          $possibles[] = $k;
        }
      }
      // if we got exactly one match, it's still good!
      if( count($possibles) == 1 ) { return $possibles[0]; }
    }
    return false;
  }
  
  /**
   * Return an alphanumeric parameter value
   * @see getParm()
   */
  function getNumParm( $key, $required = false, $get = false ) {
    return $this->zen->checkNum($this->getParm($key, $required, $get));
  }

  /**
   * Return an alphanumeric parameter value
   * @see getParm()
   */
  function getAlphanumParm( $key, $required = false, $get = false ) {
    return $this->zen->checkAlphaNum($this->getParm($key, $required, $get));
  }
  
  /**
   * Return a decimal value
   * @see getParm()
   */
  function getFloatParm($key, $required = false, $get = false) {
    return $this->zen->checkNum($this->getParm($key, $required, $get), true);
  }
  
  /**
   * Get parameter from request scope. Returns null if not found
   *
   * @param string $key
   * @param boolean $get if true, searchs _POST and then _GET, otherwise, only searches _POST 
   * @return mixed value from query or null if not found
   */
  function getParm( $key, $required = false, $get = false ) {
    $val = array_key_exists($key, $_POST)? $_POST[$key] : null;
    if( is_null($val) && $get && array_key_exists($key, $_GET) ) {
      $val = $_GET[$key];
    }
    
    // record args in debug info; great for troubleshooting
    // if the value is required and null, it's an error, otherwise
    // if it's null, it's a warning; otherwise, it's just a debug msg
    $msg = is_null($val)? "$key was not passed by caller" : "$key=$val";
    $lvl = is_null($val)? ($required? 1 : 2) : 3;
    $this->zen->addDebug("ZenHttpApi::getParm", $msg, $lvl);
      
    // return the result
    return $val;
  }
  
  /**
   * Return an error message as a transaction
   * @param string $message
   * @return string
   */
  function _errTrxn($message) {
    return $this->_generateTransaction($message, false);
  }
  
  /**
   * Just a transition method to present a 'not ready' message until all
   * api methods are implemented
   */
  function _notReadyTrxn($method) {
    $method = $this->zen->checkAlphaNum($method);
    return $this->_errTrxn("$method is not implemented yet");
  }
  
  /**
   * Check that user is allowed to perform action provided
   * @param string $action
   * @return mixed true if allowed or a (string)transaction if not allowed
   */
  function _checkAccess($action) {
    // for access, viewing a log is the same as viewing the ticket
    if( $action == 'view_log' ) { $action = 'view'; }
    
    // we only check ticket actions here
    if( !array_key_exists($action, $this->zen->getActions()) ) { return true; }
    
    // we only need concern ourselves with checking the bin/id if they are set
    // if they aren't set, the user can't retrieve info for something not allowed
    // so we don't concern ourselves
    $id = $this->getNumParm('id');
    if( $id ) {
      if( !$this->zen->actionApplicable($id, $action, $this->uid) ) {
        return $this->_errTrxn("Action not allowed");
      }
    }
    else if( !empty($_POST['bin']) ) {
      //todo: setting a ticket id bypasses this check -- need a fix
      // we check to see if anything is in the bin parm at all
      // now we'll make sure it's a valid bin value
      $bin_id = $this->getIdParm('bin', 'bins', true);
      if( !$bin_id ) { return $this->_errTrxn("Not a valid Bin name or ID"); }
      else {
        $lvl = in_array($action, $this->actions_viewlevel)? 'level_view' : 'level_user';
        if( !$this->zen->checkAccess($this->uid, $bin_id, $lvl) ) {
          return $this->_errTrxn("User doesn't have sufficient access to bin {$bin_id}");
        }
      }
    }
    
    return true;
  }
  
  /**
   * Retrieves data types and caches them for future use
   * @return array (string)type => array( (int)id=>(string)name, ... )
   */
  function _getDataTypes() {
    if( empty($this->dataTypes) ) {
      if( $this->user ) {
        $bins = array();
        $allbins = $this->zen->getBins();
        $ubins = $this->zen->getUsersBins($this->uid);
        foreach($allbins as $k=>$v) {
          if( in_array($k, $ubins) ) { $bins[$k] = $v; }
        }
      }
      else {
        $bins = $this->zen->getBins();
      }
      $this->dataTypes['bins'] = $bins;
      $this->dataTypes['types'] = $this->zen->getTypes();
      $this->dataTypes['priorities'] = $this->zen->getPriorities();
      $this->dataTypes['tasks'] = $this->zen->getTasks();
      $this->dataTypes['systems'] = $this->zen->getSystems();
    }
    return $this->dataTypes;
  }
  
  
  
  /**
   * Retrieve ticket fields which are valid and visible for use by client
   */
  function _getApiFields($view = 'api_view') {
    if( empty($this->fields) ) {
      $this->fields = array();
      foreach($this->map->listFieldsForView($view) as $f) {
        $fld = $this->map->getFieldFromMap($view, $f);
        if( !$fld['is_visible'] ) { continue; }
        $this->fields[$f] = array( 
          'name'     => $fld['field_name'],
          'label'    => $fld['field_label'],
          'required' => $fld['is_required'],
          'type'     => $fld['field_type'] );
      }
    }
    return $this->fields;
  }
  
  function _searchParm($f, $v) {
    if( strpos($v, "\t") !== false ) {
      $op = 'IN';
      $v = explode("\t", $v);
    } 
    else if( preg_match('@^([!]?[=~]|[<>]=?)(.*)@', $v, $matches) ) {
      list($term,$op,$v) = $matches;
    }
    else { $op = '~'; }
    
    if( $op == '!~' ) {
      $op = 'NOT LIKE';
      $v = "%{$v}%";
    }
    else if( $op == '~' ) {
      $op = 'LIKE';
      $v = "%{$v}%";
    }
    
    return array($f, $op, $v);
  }
  
  var $dataTypes = array();
  var $actions;
  var $actions_noauth = array('authenticate', 'translations', 'test');
  var $actions_gettable = array('test', 'translations');
  var $actions_viewlevel = array('notify_add', 'notify_drop', 'search', 'view', 'view_list', 'view_log');
  var $usercols = array('email', 'fname', 'lname', 'initials', 'homebin');
  var $fields = array();
    
  var $authed; //true if authentication has been done successfully
  var $user; // the user who authenticated
  var $uid;
  var $ubins; //bins authenticated user can view
  var $zen; //zenTrack instance
  var $map; //ZenFieldMap instance
}
  
?>