<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * Holds the ZenEmail class.  Requires Zen.php
 * @package Utils
 */

/** 
 * Provides methods for easy creation and formatting of emails 
 * to one or more recipients.
 * 
 * @package Utils 
 */
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
  function ZenEmail( $from, $subject, $message ) { 
    $this->_sender = $from;
    $this->_subject = $subject;
    $this->_message = $message;
  }

  /**
   * Loads recipients, can either be a ZenUserList, array of email addresses, or a ZenNotifyList
   *
   * @param mixed $recipients a ZenUserList, array of email addresses or ZenNotifyList
   * @param integer $priority (required if ZenNotifyList
   * @return boolean validated
   */
  function setRecipients( $recipients ) { 
    if( is_object($recipients) && is_a("ZenUserList") ) {
      //reset the list and begin to loop through it
      $recipients->reset();
      while ($recipients->hasNext()) {
      	$zenUser = $recipients->next();
      	//TODO: add the email of the user to the recipients array
      	//$this->_recipients[] = $zenUser->_email;
      }
    }
    if( is_object($recipients) && is_a("ZenNotifyList") ) {
      //reset the list and begin to loop through it
      $recipients->reset();
      while ($recipients->hasNext()) {
      	$zenNotify = $recipients->next();
      	//TODO: I have no idea what type of object is going to be loaded into zenNotify. 
      	//Need to find out and implement accordingly
      }
    }
    else if( is_array($recipients) ) {
      //direct array copy is all that's needed
      $this->_recipients = $recipients;
      return true;
    }
    else { return false; }
  }

  /**
   * Loads templates (in order)
   *
   * @param string $template name of template to load
   * @param array $vals are the values to pass to the template
   * @return boolean template found and loaded successfully
   */
  function addTemplate( $template, $vals = null ) {
  	$this->_templateVars = $vals;
  	$this->_template = new ZenTemplate(); //TODO: figure out how to initialize a template
  	return true;
  }

  /**
   * Adds additional headers in the (unlikely) event that a special header is desired
   *
   * @param string $header the complete header minus \n
   * @return boolean valid and added
   */
  function addHeader( $header ) { 
    $this->_headers[] = $header;
  }

  /**
   * Sends the message
   * 
   * @return boolean message sent successfully
   */
  function send() {
  	$recipients = implode(', ', $this->_recipients);
  	$message = $this->_template->fetch(); //TODO: This function needs to be fixed
  	$headers = implode("\n", array_merge($this->_headers, array("From: {$this->_sender}")));
  	mail($recipients, $this->_subject, $message, $headers);
  }

  /**
   * formats text for use in email with proper escape characters
   * 
   * (checks magic_quotes_runtime and magic_quotes_gpc)
   *
   * @param string $text to format
   * @return string $text formatted
   */
  function formatForEmail( $text ) {
  	if (get_magic_quotes_gpc()) {
  		return stripslashes($text);
  	} else {
  		return $text;
  	}
  }


  /** @var array $_recipients the unique list of recipients */
  var $_recipients = array();

  /** @var string $_sender the email sender */
  var $_sender;
  
  /** @var string $_subject the message subject */
  var $_subject;

  /** @var string $_message the message to send */
  var $_message;
  
  /** @var string $_template the template to use for the message */
  var $_template;
  
  /** @var array $_templateVars The variables (besides 'msg') to use with the template */
  var $_templateVars;

  /** @var array $_headers headers to send with message */
  var $_headers = array();

}

?>
