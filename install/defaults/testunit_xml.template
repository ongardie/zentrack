
<TestUnit>

  <!-- 
     **************************
     test data for PHPUnit tests

     An optional <setup> node can
     appear in the list, if it exists
     then it will be passed as the
     ZenXNode to the (assumed to exist)
     $this->load() method

     The xml file should contain nodes
     named the same as the method the
     data applies to.

     Each method node can contain any
     number of test nodes which will
     each contain a set of <param>
     nodes which will be passed back
     to the test method

     An optional eval='true' attribute
     can be applied to any param tag
     which will cause the data block to
     be run using eval() (executed as code)
     
     This is useful for creating boolean vals,
     for running functions, using variables, etc

     IMPORTANT NOTE: the method names need
     to be in all lower case here, since the
     call uses get_class_methods, which returns
     them entirely in lower case
     **************************
  -->

<!-- Sample setup node:
  <setup>
    <xmlfile>testdb.xml</xmlfile>
    <fields>
      <field_a>value_1</field_a>
      <field_b>value_2</field_b>
    </fields>
  </setup>
-->

<!--  Sample test data:
  <testgetfield>
    <pass_1>
      <param name='rowid'>1</param>
      <param name='field'>column_value</param>
      <param name='value'>test_field_1</param>
      <param name='expected' eval='true'>true</param>
    </pass_1>
    <fail_1>
      <param name='rowid'>10</param>
      <param name='field'>happy</param>
      <param name='expected' eval='true'>false</param>
    </fail_1>
  </testgetfield>
-->

</TestUnit>