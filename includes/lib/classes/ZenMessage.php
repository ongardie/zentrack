<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Zen */
class ZenMessage extends Zen {

  /**
   * CONSTRUCTOR
   *
   * loads the message and prepares for use
   * @param string $class the class or page responsible
   * @param string $method the method or section responsible
   * @param string $message the message to store
   * @param integer $errnum error number (http://zendocs.phpzen.net/bin/view/Zentrack/ErrorMessages)
   * @param integer $level the level of the message
   */
  function ZenMessage( $class, $method, $message, $errnum = 0, $level = 3 ) { 
    $this->Zen();
    $this->_class = $class;
    $this->_method = $method;
    $this->_message = $message;
    $this->_errnum = $errnum;
    $this->_level = $level;
  }

  /**
   * returns the message string, without formatting
   *
   * @return string unformatted message
   */
  function get() { 
    return $this->_message;
  }

  /**
   * Returns the error number
   *
   * @return int zenError number
   */
  function getNumber() { 
    return $this->_errnum;
  }

  /**
   * Returns the error level
   *
   * @return int level of error
   */
  function getLevel() { 
    return $this->_level;
  }

  /**
   * Returns the class name or script name which produced error
   *
   * @return String class name which produced error
   */
  function getClass() { 
    return $this->_class;
  }

  /**
   * Returns the method or section which produced error
   *
   * @return String method name which produced error
   */
  function getMethod() { 
    return $this->_method;
  }

  /**
   * Returns true or false based on whether this error is relative to provided params
   *
   * @param int $level is a level to validate against
   * @param String $class is a class to validate against
   * @param String $method is a method to validate against
   * @param int $number is an error number to validate against
   * @return boolean true-is relative, or false-not relative
   */
  function meets( $level = null, $class = null, $method = null, $number = null ) { 
    if( $level && $this->getLevel() > $level )
      return false;
    if( $class && $this->getClass() != $class )
      return false;
    if( $method && $this->getMethod() != $method )
      return false;
    if( $number && $this->getNumber() != $number )
      return false;
    return true;
  }
  

  /* VARIABLES */

  /** @var integer $_errnum the error number associated with message */
  var $_errnum;

  /** @var integer $_level The level of the message */
  var $_level;

  /** @var string $_class the class responsible */
  var $_class;

  /** @var string $_method the method responsible */
  var $_method;

  /** @var string $_message */
  var $_message;

}

?>
