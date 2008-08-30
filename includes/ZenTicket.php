<?
  /**
   * This file contains the ZenTicket class and ZenTicketList, which are used 
   * to access and manipulate tickets.
   */

/**
 * Represents one record in the ZENTRACK_TICKETS table. This class allows the
 * record to be read, modified, and saved back to the database.
 */
class ZenTicket extends ZenRecordBase {

  function __construct($id=null, $data=null) {
    parent::__construct(self::getDataType(), self::$cols, $id, $data);
  }
  
  static function getDataType() { return 'ZenTicket'; }
  
  static function getSourceTable() {
    global $zen; //cheating
    return $zen->table_tickets;
  }
  
  static function getIdCol() { return "id"; }
  static function getLabelCol() { return "title"; }
  
  static private $cols = array(
      "id"          => array('id',           12, false),
      "title"       => array('string',      250, true ),
      "priority"    => array('int',           2, true ),
      "status"      => array('alphanumeric', 25, true ),
      "description" => array('string',        0, false),
      "otime"       => array('date',         12, false),
      "ctime"       => array('date',         12, true ),
      "bin_id"      => array('id',           12, true ),
      "type_id"     => array('id',           12, false),
      "user_id"     => array('id',           12, false),
      "system_id"   => array('id',           12, false),
      "creator_id"  => array('id',           12, false),
      "tested"      => array('boolean',       0, false),
      "approved"    => array('boolean',       0, false),
      "relations"   => array('string',      255, false),
      "project_id"  => array('id',           12, false),
      "est_hours"   => array('float',        13, false),
      "deadline"    => array('date',         12, false),
      "start_date"  => array('date',         12, false),
      "wkd_hours"   => array('float',        13, false)
    );

}

/**
 * Represents a list of ZenTicket records, which can be read, sorted, filtered,
 * and modified en masse.
 */
class ZenTicketList extends ZenListBase {

  function __construct() { parent::__construct("ZenTicket"); }
  
  /** @return string type of objects contained in this list, such as ZenUser, ZenTicket, etc */
  static function getDataType() { return ZenTicket::getDataType(); }

}

?>
