<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Utils */
class ZenEmail extends Zen {

  /**
   * CONSTRUCTOR
   * 
   * Set the email params, and call Zen() constructor
   *
   * @param string $from from address
   * @param string $subject the subject of the message
   * @param string $message the message body
   */
  function ZenEmail( $from, $subject, $message ) { }

  /**
   * Loads recipients, can either be a ZenUserList, array of email addresses, or a ZenNotifyList
   *
   * @param mixed $recipients a ZenUserList, array of email addresses or ZenNotifyList
   * @return boolean validated
   */
  function setRecipients( $recipients ) { }

  /**
   * Loads templates (in order)
   *
   * @param string $template name of template to load
   * @param array $vals are the values to pass to the template
   * @return boolean template found and loaded successfully
   */
  function addTemplate( $template, $vals = null ) { }

  /**
   * Adds additional headers in the (unlikely) event that a special header is desired
   *
   * @param string $header the complete header minus \n
   * @return boolean valid and added
   */
  function addHeader( $header ) { }

  /**
   * Sends the message
   * 
   * @return boolean message sent successfully
   */
  function send() { }

  /**
   * converts entries to valid email addresses, checks for duplicates
   *
   * @param mixed $entries the array, ZenUserList or ZenNotifyList to be added
   * @return integer the number added (duplicates will not appear here)
   */
  function _addRecipients( $entries ) { }

  /**
   * formats text for use in email with proper escape characters
   * 
   * (checks magic_quotes_runtime and magic_quotes_gpc)
   *
   * @param string $text to format
   * @return string $text formatted
   */
  function formatForEmail( $text ) { }


  /** @var array $_recipients the unique list of recipients */
  var $_recipients;

  /** @var string $_sender the email sender */
  var $_sender;
  
  /** @var string $_subject the message subject */
  var $_subject;

  /** @var string $_message the message to send */
  var $_message;

}

?>
