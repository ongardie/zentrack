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

      // load some sample data to datatype_test table
      foreach( $node->child('load') as $r ) {
        Zen::simpleInsert('DATATYPE_TEST', $r->childSet());
      }

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
      $exp = isset($dat[$p])? $dat[ $p ] : null;
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
      $exp = isset($dat['custom'])? $dat['custom'] : null;
      Assert::equals($field->isCustom(), $exp);
    }

    function testIsProperty( $vals ) {
      $field = $this->_get($vals);
      $p = $vals['prop'];
      Assert::equals($field->isProperty($p), $vals['expected'], 
                     "{$vals['name']}->{$p}: expected {$vals['expected']}");
    }

    function testIsRequired( $vals ) {
      $field = $this->_get($vals);
      Assert::equalsTrue($field->isRequired(), $vals['expected'], 
                         "{$vals['name']}: expected {$vals['expected']}");
    }

    function testName( $vals ) {
      $field = $this->_get($vals);
      $dat = $this->_dat($vals);     
      $exp = isset($dat['name'])? $dat['name'] : null;
      Assert::assert($field->name() == $exp, 
                     "{$vals['name']}: '".$field->name()."' != '{$exp}'");
    }

    function testSetProp( $vals ) {
      $field = $this->_get($vals);
      $res = $field->setProp( $vals['prop'], $vals['newval'] );
      Assert::assert($res == $vals['expected'], 
                     "{$vals['name']}->return_val: $res != {$vals['expected']}");
      if( $res ) {
        Assert::assert($vals['newval'] == $field->getProp($vals['prop']),
                       "{$vals['name']}->{$vals['prop']}: ".$field->getProp($vals['prop'])
                       ." != {$vals['expected']}");
      }
    }

    function testTable( $vals ) {
      $field = $this->_get($vals);      
      $dat = $this->_dat($vals);
      Assert::assert($field->table() == $dat['table'], "{$vals['name']}: expected '"
                     .$dat['table']."', found '".$field->table()."'");
    }

    function testUpdated( $vals ) {
      $field = $this->_get($vals);
      if( $vals['set'] ) {
        $field->setProp($vals['set'], $vals['newval']);
      }
      Assert::assert($field->updated() == $vals['expected'], "{$vals['name']}: expected "
                     .($vals['expected']? 'true' : 'false'));
    }

    function testValidate( $vals ) {
      $field = $this->_get($vals);
      $res = $field->validate($vals['newval']);
      Assert::assert( ($vals['expected'] && $res === true) || !$vals['expected'] && is_string($res), 
                     "{$vals['name']}: expected ".($vals['expected']? 'true' : 'false')
                     ." for value '{$vals['newval']}'" );
      //todo: add a test for unique values
    }

    function testSave( $vals ) {
      $field = $this->_schema->getMetaField($vals['table'], $vals['field']);      
      if( isset($vals['set']) ) {
        $orig = $field->getProp($vals['set']);
        $field->setProp($vals['set'], $vals['value']);
      }
      $res = $field->save();
      Assert::equals($res, $vals['expected'], 
                     "{$vals['table']}->{$vals['field']}: return val $res != {$vals['expected']}");
      if( $res ) {
        // validate the entry in the database
        $query = Zen::getNewQuery();
        $query->table('FIELD_DEFS');
        $query->match('table_name', ZEN_EQ, $vals['table']);
        $query->match('col_name', ZEN_EQ, $vals['field']);
        $vals = $query->selectRow(null, true);
        foreach($vals as $key=>$val) {
          Assert::assert($val == $field->getProp($key), 
                         "{$vals['name']}->{$key}: {$val} != ".$field->getProp($key));
        }
        if( isset($vals['set']) ) {
          // attempt to reset the database value to the original
          $field->setProp($vals['set'], $orig);
          $res = $field->save();
          Assert::assert($res, "Unable to reset {$vals['table']}->{$vals['field']} to ".
                             "$orig!!, this is a problem!!");
        }
      }
    }

    /** Clear out cached data and reset system */
    function unload() {
      // clear out any cached data
      ZenMetaDb::clearCacheInfo();
      // clear data from test table
      Zen::simpleDelete('DATATYPE_TEST');
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
