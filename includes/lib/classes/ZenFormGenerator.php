<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

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
   * @param ZenMetaTable $table is the meta info for the table used to create form
   * @param string $template the template file to use for creating form output
   */
  function ZenFormGenerator($table, $template) {
    $this->_table = $table;
    $this->_template = $template;
    $this->_name = 'aForm';
    $this->_action = $_SERVER['SCRIPT_NAME'];
    $this->_method = 'POST';
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
   * Also see {@link setFormProp()} below for more options
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
   *   <li><b>len</b> - the size of the input element
   *   <li><b>checkval</b> - the value to give a checkbox (defaults to 1)
   *   <li><b>vals</b> - if type is select, option, or helper, vals contains
   *       the valid choices (generated from criteria and reference values, 
   *       setting this overrides the existing values)
   *   <li><b>onBlur</b> - onBlur event handler
   *   <li><b>onClick</b> - onClick event handler
   *   <li><b>onChange</b> - onChange event handler
   *   <li><b>onMouseOver</b> - onMouseOver event handler
   *   <li><b>onMouseOut</b> - onMouseOut event handler
   * </ul>
   *
   * @param string $field form field name
   * @param string $prop special property
   * @param mixed $value
   * @return boolean
   */
  function setFormProp($field, $property, $value) {
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
   * Set a value that will be used by template, some common values
   * are Title (the title to show on form), Description (a quick blurb
   * about the form), etc.
   *
   * @param string $name
   * @param mixed $val
   */
  function setVal($name, $val) {
    $this->_vals[$name] = $val;
  }

  /**
   * Render the html form for display
   *
   * @return string containing html output
   */
  function render() {
    // generate values to pass to form
    $vals = $this->_vals;
    $vals["name"] = $this->_name;
    $vals["action"] = $this->_action;
    $vals["method"] = $this->_method;
    $vals["fields"] = array();
    foreach($this->_table->listFields as $f) {
      $mfield = $this->_table->getMetaField($f);
      $field = $field->getFieldArray();
      if( !isset($field['default']) ) { $field['default'] = null; }
      if( isset($this->_props[$f]) ) {
        foreach($this->_props[$f] as $key=>$val) {
          $field[$key] = $val;
        }
      }
      switch( $field['type'] ) {
      case 'skip':
        // do not process these
        continue;
      case 'checkbox':
        if( !isset($field['checkval']) ) { $field['checkval'] = null; }
        break;
      case 'helper':
        //todo: run helper and get results
        break;
      case 'select':
        //todo: read criteria and reference, process
        break;
      case 'checklist':
        //todo: read criteria and reference, process
        break;
      case 'popupselect':
        //todo: read criteria and reference, process
        break;
      case 'yesno':
        $field['type'] = 'select';
        $field['vals'] = array('1'=>'Yes','0'=>'No');
      case 'datebox':
        //todo: convert date, determine format
        break;
      case 'colorbox':
        //todo: read criteria, set default
        break;
      case 'setting':
        //todo: get field type from db criteria
        break;        
      }      
      $vals["fields"][] = $field;
    }
    
    // render the form
    $template = new ZenTemplate($this->_template);
    $template->values($vals);
    return $template->process();
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
}

?>
