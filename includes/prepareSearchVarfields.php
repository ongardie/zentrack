<?
 $varfieldsAll = $zen->getCustomFields(0,"","Search Screen");
 $varfieldsText = array();
 $varfieldsDates = array();
 $varfieldsParms = array();
 
 foreach( $varfieldsAll as $v ) {
   $key = $v['field_name'];
   $label = $v['field_label'];
   switch( getVarfieldDataType($key) ) {
   case "date":
     $varfieldsDates["$key"] = $label;
     break;
   case "boolean":
   case "menu":
     $varfieldsParms["$key"] = $v;
     break;
   default:
     $varfieldsText["$key"] = $label;
     break;
   }
 }
?>