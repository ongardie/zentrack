<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Test the ZenMetaField.php class file and its methods
   *
   * @package PHPUnit
   */

  /** Try to include the config file for testing */
  include_once( realpath(dirname(__FILE__)."/../")."/phpunit_config.php");

  /**
   * Test the ZenMetaField.php class methods
   *
   * This test unit requires that the ZenDbSchema.php, ZenUtils.php, Zen.php,
   * ZenDbSchema, ZenMetaTable, and ZenMetaField class files be included
   * This test also relies on the ZenMetaFieldTest.xml and ZenDbSchema_config.xml files to provide test data
   *
   * @package PHPUnit
   */
  class ZenMetaFieldTest extends Test {

    /** The db schema object */
    var $_schema;

    /** Array of ZenMetaField objects to use for testing mapped by the name */
    var $_fields;

    /** Array of values used to create the ZenMetaField objects */
    var $_vals;

    /** Constructor */
    function ZenMetaFieldTest() { }

    /** Load config file (gets params from <setup> node) */
    function load( $node ) {
      // delete cache file and data from test table
      $this->unload();

      // load the schema
      $GLOBALS['testingSchemaOverride'] = dirname(dirname(__FILE__)).'/DB/'.$node->childData('xmlfile');
      $this->_schema = new ZenMetaDb( false, $GLOBALS['testingSchemaOverride'] );

      // load our sample fields
      $this->_fields = array();
      foreach( $node->child('field') as $f ) {
        $d = $f->childSet(true);
        $this->_vals[ $d['name'] ] = $d;
        $field = new ZenMetaField( $d );
        $this->_fields[ $d['name'] ] = $field;
      }
    }

    function testDataType( $vals ) {
      $field = $this->_get($vals);
      $type = $field->dataType();
      $dat = $this->_dat($vals);
      Assert::equals($type, $dat['type'], "{$vals['name']} did not match:"
                     ." '$type' != '{$dat['type']}'");
    }

    function testCopy( $vals ) {
      $orig = $this->_get($vals);
      $copy = new ZenMetaField();
      $copy->copy($orig);
      Assert::equalsTrue( ZenUtils::arrayEquals($orig->getFieldArray(), $copy->getFieldArray()),
                          "{$vals['name']}: data did not copy correctly" );
    }

    function testForceChanged( $vals ) {
      $field = $this->_get($vals);
      $field->forceChanged();
      Assert::equalsTrue($field->updated(), "{$vals['name']}: not marked");
    }

    function testFormType( $vals ) {
      $field = $this->_get($vals);
      $dat = $this->_dat($vals);
      Assert::equals($field->formType(), $dat['ftype']);
    }

    function testGetFieldArray( $vals ) {
      $field = $this->_get($vals);
      $vals = $field->getFieldArray();
      $dat = $this->_dat($vals);
      Assert::equalsTrue( ZenUtils::arrayEquals($vals,$dat), "{$vals['name']}: failed" );
    }

    function testGetProp( $vals ) {
      $p = $vals['prop'];
      $field = $this->_get($vals);
      $dat = $this->_dat($vals);
      $val = $field->getProp($p);
      $exp = $dat[ $p ];
      Assert::equals($val, $exp, "{$vals['name']}->{$p}: '$val' != '{$exp}'");
    }

    function testImmutable( $vals ) {
      $field = $this->_get($vals);
      $p = $vals['prop'];
      Assert::equals($field->immutable($p), $vals['expected'], 
                     "{$vals['name']}->{$p}: expected {$vals['expected']}");
    }

    function testIsCustom( $vals ) {
      $field = $this->_get($vals);
      $dat = $this->_dat($vals);
      Assert::equals($field->isCustom(), $dat['custom']);
    }

    function testIsProperty( $vals ) {
      $field = $this->_get($vals);
      $p = $vals['prop'];
      Assert::equals($field->isProperty($p), $vals['expected'], 
                     "{$vals['name']}->{$p}: expected {$vals['expected']}");
    }

    function testIsRequired( $vals ) {
      $field = $this->_get($vals);
      $p = $vals['prop'];
      Assert::equalsTrue($field->isRequired($p), $vals['expected'], 
                         "{$vals['name']}: expected {$vals['expected']}");
    }

    function testName( $vals ) {
      $field = $this->_get($vals);
      $dat = $this->_dat($vals);     
      Assert::equals($field->name(), $dat['name'], 
                     "{$vals['name']}: '".$field->name()."' != '{$dat['name']}'");
    }

    function testSave( $vals ) {
      $field = $this->_schema->getMetaField($vals['table'], $vals['field']);      
      if( $vals['set'] ) {
        $orig = $field->getProp($vals['set']);
        $field->setProp($vals['set'], $vals['value']);
      }
      $res = $field->save();
      Assert::equals($res, $vals['expected'], 
                     "{$vals['name']}: return val $res != {$vals['expected']}");
      if( $res ) {
        // validate the entry in the database
        $query = Zen::getNewQuery();
        $query->table('FIELD_DEFS');
        $query->match('table_name', $vals['table']);
        $query->match('col_name', $vals['field']);
        $vals = $query->selectRow(null, true);
        foreach($vals as $key=>$val) {
          Assert::equals($val, $field->prop($key), 
                         "{$vals['name']}->{$key}: {$val} != ".$field->prop($key));
        }
        if( $vals['set'] ) {
          // attempt to reset the database value to the original
          $field->setProp($vals['set'], $orig);
          $res = $field->save();
          Assert::equalsTrue($res, "Unable to reset {$vals['table']}->{$vals['field']} to ".
                             "$orig!!, this is a problem!!");
        }
      }
    }

    function testSetProp( $vals ) {
      $field = $this->_get($vals);
      $res = $field->setProp( $vals['field'], $vals['newval'] );
      Assert::equals($res, $vals['expected'], 
                     "{$vals['name']}->return_val: $res != {$vals['expected']}");
      if( $res ) {
        Assert::equals($vals['newval'], $field->prop($vals['field']),
                       "{$vals['name']}->prop: ".$field->prop($vals['field'])
                       ." != {$vals['expected']}");
      }
    }

    function testTable( $vals ) {
      $field = $this->_get($vals);      
      $dat = $this->_dat($vals);
      Assert::equals($field->table(), $dat['table_name'], "{$vals['name']}: expected "
                     .$dat['table_name'].", found ".$field->table());
    }

    function testUpdated( $vals ) {
      $field = $this->_get($vals);
      if( $vals['set'] ) {
        $field->setProp($vals['field'], $vals['set']);
      }
      Assert::equals($field->updated(), $vals['expected'], "{$vals['name']}: expected "
                     .($vals['expected']? 'true' : 'false'));
    }

    function testValidate( $vals ) {
      $field = $this->_get($vals);
      $res = $field->validate($vals['value']);
      Assert::equals($res, $vals['expected'], "{$vals['name']}: expected "
                     .($vals['expected']? 'true' : 'false') );
    }

    /** Clear out cached data and reset system */
    function unload() {
      // clear out any cached data
      ZenMetaDb::clearCacheInfo();
    }

    /** Get a field from the loaded selection */
    function _get( $vals ) {
      $name = $vals['name'];
      return $this->_fields[$name];
    }

    /** Get a field from the original data */
    function _dat( $vals ) {
      $name = $vals['name'];
      return $this->_vals[$name];
    }

  }

}?>
