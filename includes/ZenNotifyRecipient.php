<? if( !ZT_DEFINED ) { die('Illegal Access'); }

/**
 * ZenNotifyRecipient is a generic person, such as a contact, user, notify recipient,
 * etc. in the ZT system.
 *
 * Note that there is no way to load data into this class... you must use
 * a class which extends ZenNotifyRecipient to load data into it.
 *
 * @abstract
 */
class ZenNotifyRecipient extends ZenRecordBase {
  
  /**
   * Default constructor, included here so that implementing classes can
   * call the super method (in case we decide to put something here later)
   */
  function ZenNotifyRecipient( $id = null, $data = null ) {
    $this->dataType = "ZenNotifyRecipient";
    $this->ZenRecordBase($id, $data);
  }
  
  /**
   * Fetch the email address for this user
   *
   * @return string email or null
   */
  function email() { return $this->getField('email'); }
  
  function getSourceTable() {
    global $zen;
    return $zen->table_notify_list;
  }
  
  function getIdCol() { return "notify_id"; }
  
  function validFields() {
    return array("notify_id", "ticket_id", "user_id", "name", "email", "priority", "notes");
  }
  
  function fieldProps($columnName) {
    switch($columnName) {
      case "notify_id":
      case "ticket_id":
        return array("id", 50, true);
      case "user_id":
        return array("id", 50, false);
      case "name":
        return array("string", 200, false);
      case "email":
        return array("email", 0, false);
      case "priority":
        return array("int", 2, false);
      default:
        return false;
    }
  }

   /**
    * Fetch a formatted name for this user
    *
    * @return string
    */
   function name() {
     $fields = $this->getLabelField();
     $txt = '';
     foreach($fields as $f) {
       $txt .= $txt? ', '.$f : $f;
     }
     return $txt;
   }
   
}

/**
 * A list of ZenNotifyRecipient objects, which uses a raw data set and loads/stores
 * the objects upon demand.  It can contain any type of person (user, contact,
 * etc) and can load/save them as well.
 */
class ZenNotifyRecipientList extends ZenListBase {
  
  function ZenNotifyRecipientList() {
    $this->_dataType = "ZenNotifyRecipient";
    $this->ZenListBase();
  }
  
  function getSourceTable() { return ZenNotifyRecipient::getSourceTable(); }
  function getIdCol() { return ZenNotifyRecipient::getIdCol(); }
  function columnType($columnName) { return ZenNotifyRecipient::columnType($columnName); }
  function validFields() { return ZenNotifyRecipient::validFields(); }

}

?>