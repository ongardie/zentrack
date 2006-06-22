<? if( !ZT_DEFINED ) { die('Illegal Access'); }

/**
 * ZenPerson is a generic person, such as a contact, user, notify recipient,
 * etc. in the ZT system.
 *
 * Note that there is no way to load data into this class... you must use
 * a class which extends ZenPerson to load data into it.
 *
 * @abstract
 */
class ZenPerson extends ZenDataType {
  
  /**
   * Default constructor, included here so that implementing classes can
   * call the super method (in case we decide to put something here later)
   */
  function ZenPerson( $id = null ) { $this->ZenDataType($id); }
  
  /**
   * Fetch the email address for this user
   *
   * @return string email or null
   */
  function email() { return $this->getField('email'); }
  
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
   
   /**
    * Returns a list of roles that this person has access to.
    *
    * @return ZenRoleList
    */
   function getRoleList() { } //todo
   
}

/**
 * A list of ZenPerson objects, which uses a raw data set and loads/stores
 * the objects upon demand.  It can contain any type of person (user, contact,
 * etc) and can load/save them as well.
 */
class ZenPersonList {
  
  function ZenPersonList() { 
    $this->ZenList(); 
  }

  /**
   * @return string class name of elements in this list
   */
  function getDataType() { return 'ZenPerson'; }
}

?>