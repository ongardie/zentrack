<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * This creates a list of tickets and keeps special information about
 * their relationships
 *	
 * @package Zen 
 */
class ZenRelatedList extends ZenTicketList {
  
  /**
   * CONSTRUCTOR: get related tickets, and load the ZenTicketList
   *
   * This will load the relationships for the ticket requested, and will
   * cache them for use here.
   *
   * @param integer $ticket_id is the ticket to obtain relationships for
   */
  function ZenRelatedList( $ticket_id ) { }

  /**
   * returns the entire relationship array
   *
   * @return array of relationships
   * @see $_relations
   */
  function getAllRelations() { }

  /**
   * returns a list of tickets mathing the desired relationship
   *
   * @param string $type the relation type to get ("child", "parent", etc)
   * @return array children of this ticket in a ZenTicketList format
   */
  function getRelations( $type ) { }

  /** 
   * @var array $_relations an array of relationships formatted as:
   *    relations["parents"] = array( $id1, $id2, $id3... ); 
   *    relations["children"] = array( $id1, $id2, $id3... );
   *    relations["similar"] = array( $id1, $id2, $id3... );
   *    relations["seealso"] = array( $id1, $id2, $id3... );
   */
  var $_relations;
}

?>
