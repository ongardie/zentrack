<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenFormGenerator class.  Requires Zen.php
 * @package Zen
 */

/**
 * ZenFormGenerator is used to create html forms from database
 * schema information.
 *
 * The template rendering form can expect to recieve the following input values:
 * <ul>
 *   <li><b>name</b> (string)the form name
 *   <li><b>action</b> (string)the form action
 *   <li><b>method</b> (string)the post method
 *   <li><b>odd</b> (boolean)whether there is an odd number or even number of fields
 *   <li><b>fields</b> (array) contains field info as outlined in {@link ZenDbSchema::getTableArray()}
 *     <br>Note that a field might contain the special type "break", which means this is a break in the fields,
 *     <br>to be anticipated and dealt with by the template.  The value of the special "break" field will be
 *     <br>"" or a title to display in the break line.
 * </ul>
 * 
 * @package Utils 
 */
class ZenFormGenerator extends Zen {

  /**
   * CONSTRUCTOR: Create a ZenFormGenerator
   *
   * @param ZenMetaTable $table is the meta info for the table used to create form (note that you probably want
   *         to get this from ZenMetaDb and not from ZenDbSchema!)
   * @param string $template the template file to use for creating form output
   */
  function ZenFormGenerator($table, $template) {
    ZenUtils::prep("ZenMetaField");
    ZenUtils::prep("ZenTemplate");
    $this->_table = $table;
    $this->_template = $template;
    $this->_name = 'aForm';
    $this->_action = $_SERVER['SCRIPT_NAME'];
    $this->_method = 'POST';
    $this->_id = null;
  }

  /**
   * Load a row of data into this form element
   *
   * @param integer $rowid is the primary key for this table corresponding to data row we want loaded
   * @return boolean if row loaded successfully
   */
  function loadData( $rowid ) {
    $conn =& Zen::getDbConnection();
    $key = $conn->getPrimaryKey($this->_table);
    $this->_id = $rowid;
    $fields = Zen::getDataRow($this->_table, $this->_id);
    if( is_array($fields) && count($fields) ) {
      foreach($fields as $key=>$val) {
        $this->setValue($key, $val);
      }
      return true;
    }
    return false;
  }

  /**
   * Set the name of the form
   *
   * @param string $name
   */
  function setFormName($name) { $this->_name = $name; }
 
  /**
   * Set the form action, defaults to $_SERVER['SCRIPT_NAME']
   *
   * @param string $action
   */
  function setFormAction($action) { $this->_action = $action; }
  
  /**
   * Set the form post method (GET or POST), defaults to POST
   *
   * @param string $method
   */
  function setPostMethod($method) { $this->_method = $method; }
  
  /**
   * Merge another template into this one.  Any conflicting fields
   * will be ignored (i.e. this form object will be preferred)
   *
   * @param ZenFormGenerator $secondForm
   */
  function merge( $secondForm ) {
    foreach($secondForm->listFields() as $f) {
      $this->_table->addMetaField( $secondForm->getMetaField($f) );
    }
  }

  /**
   * Add a new field to the form
   *
   * @param array $parms must match the parameters for ZenMetaField
   * @return boolean
   */
  function addNewField( $params ) {
    $field = new ZenMetaField($params);
    return $this->_table->addMetaField($field);
  }
  
  /**
   * Edit one or more properties of a field to appear on the form.
   *
   * The field properties correspond to the values as described in
   * {@link ZenDbSchema::getTableArray()}.
   *
   * Notes:
   * <br>The size element refers to the maximum input length for the field
   * <br>For ftype='checkbox', if defualt value != null, checkbox defaults to checked
   *
   * Also see {@link setFieldProp()} below for more options
   *
   * @param string $fname the form field name
   * @param array $props mapped (String)property -> (mixed)value
   */
  function modifyField( $fname, $props ) {
    $field = $this->_table->getMetaField($fname);
    if( $field == null ) { return null; }
    foreach( $props as $field=>$val ) {
      $field->setProp($field, $val);
    }
    return $this->_table->updateMetaField($field);
  }

  /**
   * Set the value to appear (selected or printed) for field
   *
   * @param string $field name of field
   * @param mixed $value active value of field (could be an array for multiple selects)
   */
  function setValue($field, $value) {
    $this->modifyField($field, array('default'=>$value));
  }

  /**
   * Set a special form property for the field
   *
   * The following special properties exist for form fields:
   * <ul>
   *  <li><b>len</b> - the size of the input element
   *  <li><b>checkval</b> - the value to give a checkbox (defaults to 1)
   *  <li><b>vals</b> - if type is select, option, or helper, vals contains
   *       the valid choices (generated from criteria and reference values, 
   *       setting this overrides the existing values)
   *  <li><b>onBlur</b> - onBlur event handler
   *  <li><b>onClick</b> - onClick event handler
   *  <li><b>onChange</b> - onChange event handler
   *  <li><b>onMouseOver</b> - onMouseOver event handler
   *  <li><b>onMouseOut</b> - onMouseOut event handler
   *  <li><b>other</b> - things like class='..' and disabled attributes can be entered here
   *        (this should hardly ever be necessary to use)
   *  <li><b>multiple</b> - if this is a select field, and multiple is set to an integer, 
   *      then this select will allow multiple entries up to the maximum.
   * </ul>
   *
   * @param string $field form field name
   * @param string $prop special property
   * @param mixed $value
   * @return boolean
   */
  function setFieldProp($field, $property, $value) {
    if( in_array($field, $this->_specialProps) && $this->getMetaField($field) != null ) {
      if( !isset($this->_props[$field]) ) {
        $this->_props[$field] = array();
      }
      $this->_props[$field][$property] = $value;
      return true;
    }
    return false;
  }

  /**
   * Set many field values at once
   *
   * @param array $fields mapped (String)name -> (mixed)value
   */
  function setVals($fields) {
    foreach($fields as $key=>$val) {
      $this->setValue($key, $val);
    }
  }

  /**
   * Return an array containing the names of fields for this form
   */
  function listFields() {
    return $this->_table->listFields();
  }

  /**
   * Return a ZenMetaField object representing field
   *
   * @param string $field name of field
   * @return ZenMetaField
   */
  function getMetaField($field) {
    return $this->_table->getMetaField($field);
  }

  /**
   * Set a property for this form which can be used by template
   *
   * Any property can be added here, and will be availble to the template
   * when it is parsed.
   *
   * There are several standard properties:
   * <ul>
   *  <li><b>title</b> - the title of the form
   *  <li><b>description</b> - a description containing information or instructions
   *         for users which will appear on form.
   * </ul>
   *
   * There are also several reserved properties which cannot be set or accessed externally,
   * since they are dynamically generated during form creation:
   * <ul>
   *   <li>name - name property of the &lt;form&gt; element
   *   <li>action - action property of the &lt;form&gt; element
   *   <li>method - method property of the &lt;form&gt; element
   *   <li>fields - the form field info
   *   <li>hiddenfields - the form fields which are hidden from view
   *   <li>settext - dynamically generated text from helpers or scripts
   *   <li>choices - choices available to a select option (see {@link _generateChoices()})
   *   <li>table - name of database table
   *   <li>template - name of template in use
   * </ul>
   *
   * @param string $name
   * @param mixed $val
   */
  function setFormProp($name, $val) {
    $this->_vals[$name] = $val;
  }

  /**
   * Render the html form for display
   *
   * @return string containing html output
   */
  function render() {
    $markName = "ZenFormGenerator->Render(".$this->_table->name().")";
    // store performance times if possible
    ZenUtils::mark($markName);

    // generate values to pass to form
    $vals = $this->_vals;
    $vals["name"] = $this->_name;
    $vals["action"] = $this->_action;
    $vals["method"] = $this->_method;
    $vals["fields"] = array();
    $vals["hiddenfields"] = array();
    $vals["settext"] = array();
    $vals["choices"] = array();    
    foreach($this->_table->listFields() as $f) {
      $metafield = $this->_table->getMetaField($f);
      $field = $metafield->getFieldArray();
      if( !isset($field['default']) ) { $field['default'] = null; }
      //$field['default'] = ZenUtils::ffv($field['default']); //probably not needed (using smarty escape)
      if( isset($this->_props[$f]) ) {
        foreach($this->_props[$f] as $key=>$val) {
          $field[$key] = $val;
        }
      }
      switch( $field['ftype'] ) {
      case 'skip':
        continue; // do not process these
      case 'checkbox':
        if( !isset($field['checkval']) ) { $field['checkval'] = null; }
        break;
      case 'helper':
        $vals['settext'] = $this->_getHelperResult($field);
        break;
      case 'radio':
      case 'select':
      case 'checklist':
        $vals['choices'][$f] = $this->_generateChoices($field);
        break;
      case 'popselect':
        //todo
        //todo set source table and field
        //todo set dest table and field
        //todo pass criteria and reference
        //todo set label or title... have
        //todo popselect util take care of
        //todo permissions, form generation
        //todo and returning selected value
        //todo
        //todo use a standard format for our popup
        //todo field types:
        //todo    open new window,
        //todo    pass source/dest table/field by session
        //todo    pass calling form field via url
        //todo    have popup return value to form by reading
        //todo      field type and taking appropriate action
        //todo
        //todo probably include to handle javascript for returning
        //todo value and reading the incoming parms.
        //todo
        break;
      case 'yesno':
        $field['ftype'] = 'select';
        $vals['choices'][$f] = array('1'=>'Yes','0'=>'No');
        break;
      case 'datebox':
        //todo
        //todo
        //todo: convert date, determine format
        //todo
        //todo
        break;
      case 'colorbox':
        //todo
        //todo
        //todo: read criteria, set default
        //todo
        //todo
        break;
      case 'searchbox':
        //todo
        //todo pass source table and field
        //todo pass criteria and reference
        //todo pass dest table and field
        //todo set label or title
        //todo have searchbox take care of
        //todo permissions and returning value
        //todo
        break;
      case 'setting':
        //todo
        //todo
        //todo: get field type from db criteria
        //todo: get values and validation criteria
        //todo
        //todo
        break;        
      }
      if( $field['ftype'] == 'hidden' ) {
        $vals['hiddenfields'][] = $field;
      }
      else {
        $vals["fields"][] = $field;
      }
      //todo
      //todo set up js validation array
      //todo have special php for creating this
      //todo
    }
    
    //ZenUtils::printArray($vals);//debug
    
    // render the form
    $template = new ZenTemplate();
    $template->assign($vals);
    $res = $template->fetch($this->_template);
    ZenUtils::unmark($markName);
    return $res;
  }

  /**
   * Generate arguments from field criteria and reference info to be
   * used for choices and settext params.
   *
   * @access private
   * @param array $field properties of the field
   * @return array (might be text for helpers)
   */
  function _generateArgs($field) {
    // if there is no criteria to process, there are no arguments
    // to be passed
    if( !isset($field['criteria']) && !isset($field['reference']) ) { 
      ZenUtils::safeDebug($this, "_generateArgs", "Field {$field['name']}: criteria "
                          ."or reference required for field type {$field['type']}", 
                          101, LVL_ERROR);
      return null; 
    }
    if( !isset($field['criteria']) ) {
      return $this->_getArgsFromRef($field);
    }
    // if there is criteria, then we will
    // generate the list from this
    switch($field['criteria'][0]) { 
    case "filter":
      {
        return $this->_genFilterArgs($field);
      }
    case "list":
      {
        return $this->_genListArgs($field);
      }
    case "standard":
      {
        // a standard list is defined in lib/inc/standard_criteria.php
        // we will just look in $GLOBALS (where they are stored) and
        // extract the correct list
        if( !isset($GLOBALS['criteriaLists']) ) {
          ZenUtils::safeDebug($this, "_generateArgs", "Criteria lists not found!", 122, LVL_ERROR);
          return null;
        }
        $k = $field['criteria'][1];
        $list = $GLOBALS['criteriaLists'][$k];
        // we will overflow to the zenlist, since they
        // do pretty much the same thing
      }
    case "zenlist":
      {
        $def = $field['default'];
        if( $field['type'] == 'zenlist' ) {
          // for a zenlist, we are simply going
          // to load the data type list from the Zen
          $list = Zen::loadDataTypeArray($field['criteria'][1]);
        }
        if( is_array($list) ) {
          // convert our list into a usable format
          // with selected and style attributes
          $args = array();
          foreach($list as $id=>$name) {
            $args[] = $this->_genArg($id, $name, $def);
          }
          return $args;
        }
        return false;
      }
    case "helper":
      {
        return $this->_genHelperArgs($field);
      }
    default:
      return false;
    }
  }

  /**
   * Generate arguments for filter type criteria
   */
  function _genFilterArgs($field) {
    $def = $field['default'];
    // the reference tag tells us which table and field we
    // are going to use for data
    list($table,$fk_id) = explode('.',$field['reference']);       
    if( is_numeric($field['criteria'][1]) ) {
      ZenUtils::prep("ZenFilter");
      // if we get a filter with just an id, it refers
      // to a filter_id in the filter table, so we will
      // simply retrieve it and use it for our filter parms
      $filter = new ZenFilter($field['criteria'][1]);
      $parms = $filter->createSearchParms();          
    }
    else {
      ZenUtils::prep("ZenSearchParms");
      // if we get a filter with params, we will
      // generate a ZenSearchParms object
      // ourselves from the params provided
      $parms = new ZenSearchParms('AND');
      $parts = explode(',',$field['criteria'][1]);
      foreach($parts as $p) {
        // the parts of $p represent
        // $fk-foriegn table field, $m-match or exclude, 
        // $o-operator(ZEN_EQ), $f-local field
        list($fk,$m,$o,$f) = explode(":",$p);
        // get the field value, it will be used as our
        // match parameter
        $f2 = $this->getMetaField($f);
        $v = $f2->getProp('default');
        // set the match/exclude condition, constant($o)
        // converts the operator string to the correct
        // constant value
        $parms->$m($fk, constant($o), $v, $table);
      }
    }
    return $this->_genArgsFromRef($field, $parms);
  }

  /**
   * Generate arguments from reference tag(in the case that there is no criteria)
   *
   * @param array $field
   * @param ZenSearchParms $parms search parameters, if coming from filter method
   * @return array
   */
  function _genArgsFromRef($field, $parms = null) {
    // if there is no criteria
    // then we will use the reference
    // id and create a list accordingly
    list($table,$fk_id) = explode('.', $field['reference']);
    $nf = $this->_genNameField($field,$table);
    $query = Zen::getNewQuery();
    $query->table($table);
    $query->field($fk_id);
    if( $nf ) { $query->field($nf); }
    if( $parms ) { $query->search($parms); }
    $vals = $query->select(Zen::getCacheTime(),true);
    if( is_array($vals) && count($vals) ) {
      // convert the values from the query
      // into proper args we can use
      $args = array();
      foreach($vals as $v) {
        $args[] = $this->_genArg($v[$fk_id], 
                                 ($nf? $v[$nf]:$v[$fk_id]), $def);
      }
      return $args;      
    }
    else { return array(); }
  }

  /**
   * Determines field to use for label
   *
   * @param array $field is the current field
   * @param string $table is the reference table
   * @return string or null(in case of null, just use the fkey)
   */
  function _genNameField($field, $table) {
    // the namefield is a field in the table to display
    // if there isn't a name field, the table is assumed
    // to have a field_name field.  If it does not, then
    // we will simply go with the pk field
    if( $field['namefield'] ) {
      $nf = $field['namefield'];
    }
    else {
      $metaTable = Zen::getMetaData(ZenUtils::classNameFromTable($table));
      if( in_array("field_name",$metaTable->listFields()) ) {
        $nf = 'field_name';
      }
      else { $nf = null; }
    }
    return $nf;
  }
  
  /**
   * Generate arguments for list type criteria
   */
  function _genListArgs($field) {
    $def = $field['default'];
    $args = array();
    $parts = explode(",",$field['criteria'][1]);
    // for lists, we will split the criteria on
    // commas, then look for entries with keys
    // ("[key]value") and plain entries "value"
    foreach($parts as $p) {
      if( preg_match('/^\[([^[]+)\](.*)$/', $p, $matches) ) {
        $k = $matches[1];
        $args[] = $this->_genArg($matches[1],$matches[2],$def);
      }
      else {
        $args[] = $this->_genArg($p,$p,$def);
      }
    }
    return $args;
  }

  /**
   * Generate string from helper type criteria
   */
  function _getHelperResult($field) {
    $def = $field['default'];
    $parms = array();
    $parts = explode(",", $field['criteria'][1]);
    foreach($parts as $p) {
      $pts = explode(":",$p);
      $key = $pts[0];
      switch( $pts[1] ) {
      case null:
        $val = null;
        break;
      case preg_match('/^"(.*)"$/', $pts[1], $matches):
        // this is a string
        $val = $matches[1];
        break;
      case 'ini':
        // ini property
        $val = ZenUtils::getIni($pts[2],$pts[3]);
        break;
      case 'setting':
        // database setting
        $val = Zen::getSetting($pts[2],$pts[3]);
        break;
      default:
        ZenUtils::safeDebug($this, '_genHelperArgs', "The text $p was not a valid arg entry", 103, LVL_ERROR);
        $val = null;
        break;
      }
      $parms[$key] = $val;
    }
    $parms['field'] = $field;
    $parms['template'] = $this->_template;
    $helper = "{$this->_table}_{$f}_helper";
    return ZenUtils::runHelper($helper, $parms);
  }

  /**
   * Generate argument from key/val pairs
   *
   * @param string $val
   * @param string $label
   * @param string $default
   * @param string $style
   * @return array
   */
  function _genArg($val, $label, $default, $style = null) {
    return array("label" => $label,
                 "value" => $val,
                 "selected" => ($default && $default == $val),
                 "style" => $style);
  }

  /** @var ZenMetaTable $_table */
  var $_table;

  /** @var string $_template the template design used to render form */
  var $_template;

  /** @var string $_name the name of the form */
  var $_name;

  /** @var string $_action the form action */
  var $_action;
  
  /** @var string $_method the form post method */
  var $_method = 'POST';

  /** @var array $_vals values to pass to template, mapped (string)name->(mixed)value */
  var $_vals = array();

  /** @var array $_props special form field properties, mapped (string)field->array( (string)prop->(mixed)value ) */
  var $_props = array();

  /** @var integer $_id the row id in database loaded into this form (or null) */
  var $_id;
}

?>
