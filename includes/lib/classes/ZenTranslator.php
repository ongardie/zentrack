<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/**
 * The translation functions
 *
 * @package Utils
 */

/**
 * The translation function wrapper
 *
 * SPECIAL NOTE:
 *   This function will be available in the global scope and should facilitate any necessary access to
 *   a translator object. If more access is necessary this is the function that needs to be modified.
 *
 * This function manages all aspects of the translation engine. It performs three different functions.
 *
 * Initialization -
 *   To initialize the engine you need to call this function with an associative array as the first
 *   parameter. The keys for this array are
 *     zen - A reference to a zenTrack object.
 *     domain - A domain to translate from
 *     path - The path to the domain containing the translation files
 *     locale - The locale to translate too 
 *
 * String translation -
 *   To translate a simple string just calling tr() with the string to translate will do the job
 *
 * String translation with variables -
 *   To translate a string with variables that could change just call tr() with the string to translate
 *   as the first parameter. In this string use the token '?' to represent where to place variables.
 *   Then as the second argument pass an ordered array containing the values to substitute in.
 * 
 * @param $string string/array Either an initialization array or the string to translate.
 * @param $vals array A list of values to substitute back into the translated string.
 */
function tr($string, $vals = '') {
  static $translator;
  if( is_array($string)) {
    $translator = new ZenTranslator;
    $translator->bindDomain($string['domain'], $string['path']);
    $translator->textDomain($string['domain']);
    $translator->setLocale($string['locale']);
    return true;
  }
  else if( !$translator ) {
    $locale = ZenUtils::findGlobal('currentLocale');
    if( !$locale ) { $locale = ZenUtils::getIni('layout','default_language'); }
    $translator = new ZenTranslator;
    $translator->bindDomain('messages', 
                            ZenUtils::getIni('directories','dir_translations'));
    $translator->textDomain('messages');    
    $translator->setLocale( $locale );
  }
  if( is_array($vals) ) {
    return $translator->ptrans($string,$vals);
  }
  else {
    return $translator->trans($string);
  }
}   
 
/**
 * This class manages the translation of static strings. It uses translation
 * files that are located in directories specified in the bindDomain() function.
 * The format of these files is forthcoming.
 *
 * Usage:
 * $trans = new ZenTranslator;
 * $trans->bindDomain('messages', './locales/messages/');
 * $trans->textDomain('messages');
 * $trans->setLocale('spanish') // corresponds to the spanish.trans file
 * $trans->trans('Hello World'); //outputs 'Hola Mundo'
 *
 * @package Utils
 */
class ZenTranslator {
/**
 * Creates an instance of the translator class.
 */
   function ZenTranslator() {
      $this->_domainList = array();
      $this->_curDomain = '';
      $this->_locale = '';
      $this->_translationCache = array();
   }

/**
 * Creates a new domain and binds it to a directory containing that domain's
 * translation files.
 *
 * @param $domain string The new domain to create.
 * @param $path The path containing that domain's translation files.
 * @param $path The path containing that domain's translation files.
 * @return boolean True if $path exists. False if it doesn't.
 */
   function bindDomain($domain, $path) {
      //check path
      if (is_dir($path)) {
         $this->_domainList[$domain] = $path;
         return true;
      }
      else {
         ZenUtils::safeDebug($this,"bindDomain", "Domain Path Doesn't Exist: '$path'\n", 21, LVL_ERROR);
         return false;
      }
   }

/**
 * Sets the current locale (language).
 *
 * @param $locale string the two letter ISO abbreviation for the language.
 */
   function setLocale($locale)  {
     ZenUtils::safeDebug($this, "setLocale", "Locale set to $locale", 0, LVL_DEBUG);
      $this->_locale = $locale;
   }

/**
 * Sets the current domain.
 *
 * @param $domain string The domain to use.
 * @return boolean True if the domain exists. False if it does not.
 */
   function textDomain($domain) {
      //Check for domain existance
      if (array_key_exists($domain, $this->_domainList)) {
         $this->_curDomain = $domain;
         return true;
      }
      else {
         ZenUtils::safeDebug($this, "textDomain", "Domain Does Not Exist: '$domain'\n", 105, LVL_ERROR);
         return false;
      }
   }
   
/**
 * Translates a string with parameters in it
 *
 * @param string $string the string to translate
 * @param array $vals the values to insert into the string
 *
 */
 function ptrans($string, $vals) {
   // get the translated string
   $string = $this->trans($string);
   // replace the ?'s one at a time
   foreach($vals as $v) {
     $v = str_replace('?', '&#63;', $v);
     $string = preg_replace("/\?/", $v, $string, 1);   
   } 
   return str_replace('&#63;', '?', $string);
 }

/**
 * Translates a string to the current locale using the current domain
 *
 * @param $string string The text to translate.
 */
   function trans($string) {
      $error = false;
      $translationFile = $this->_domainList[$this->_curDomain] . '/' . $this->_locale . '.trans';

      $cachedir = ZenUtils::getIni('directories','dir_cache') . '/translations/' . $this->_curDomain;
      if( !is_dir( $cachedir ) ) {
        mkdir($cachedir, 0777);
      }

      $compiledFile =  $cachedir . '/' . $this->_locale . '.ctrans';

      //Check for a cached copy
      if (!array_key_exists($translationFile, $this->_translationCache)) {
         //check for file
         if (!file_exists($translationFile)) {
            ZenUtils::safeDebug($this, "trans", 
                                "Translation File Does Not Exist: '$translationFile'\n", 
                                21, LVL_ERROR);
            $error = true;
         }
         else {
            //check for compiled file
            if ((file_exists($compiledFile)) && (filemtime($compiledFile) >= filemtime($translationFile))) {
               $fh = fopen($compiledFile, 'r');
               $serializedArray = fread($fh, filesize($compiledFile));
               $transArray = unserialize($serializedArray);
            }
            else {
               $transArray = $this->_parseTranslationFile($translationFile);
               if ($transArray === false) {
                  ZenUtils::safeDebug($this, "trans", 
                                      "Improper Translation File: '$translationFile'\n", 26, LVL_ERROR);
                  $error = true;
               }
               $serializedArray = serialize($transArray);
               $fh = fopen($compiledFile, 'w');
               fwrite($fh, $serializedArray);
               fclose($fh);
            }
            //Add results to the cache
            $this->_translationCache[$translationFile] = $transArray;
         }
      }

      //Only check the translation if there are currently no errors
      if ($error == false) {
	if( !isset($this->_translationCache[$translationFile][$string]) ) {
	  // translation string doesn't exist, send an error
	  ZenUtils::safeDebug($this, "trans", "Translation does Not Exist: '$string'\n", 21, LVL_ERROR);
	  $error = true;	  
	}
	$translatedString = $this->_translationCache[$translationFile][$string];
	if ($translatedString == '') {
	  //Translated string exists, but isn't filled out, so send a notice
	  if( $this->_locale != "en" )
	    ZenUtils::safeDebug($this, "trans", "Empty string: '$string'\n", 104, LVL_NOTE);
	  $error = true;	  
	}
      }
      
      //Do a final error check
      //If there are errors return the same string. Otherwise return the translated string
      return ($error)?($string):($translatedString);
   }
   
/**
 * Parses a translation file into an array containing the translations.
 *
 * @param $translationFile string The file to parse.
 */
   function _parseTranslationFile($translationFile) {
      //Check for an error.
      if (file_exists($translationFile)) {
         $status = 'none'; //Previous command
         $currentMsgID = '';
         $currentMsgStr = '';
         $matchFilter = '/^(\w+)?\s*"(.*)"/';
         $translationArray = array();
         
         $fileLines = file($translationFile);
         foreach ($fileLines as $line) {
            $filterMatches = array();
            preg_match($matchFilter, $line, $matches);
            
            //If no command is given revert back to the last command ($status)
            if ($matches[1] == '') $matches[1] = $status;
            //determine command
            switch ($matches[1]) {
            case 'msgid':
               //Add the last msg to the array (if there was one);
               if (($status != 'msgid') && ($currentMsgID != '')) {
                  $translationArray[$currentMsgID] = $currentMsgStr;
                  $currentMsgID = '';
               }
               //If there is currently text then we need to append.
               $currentMsgID = ($currentMsgID == '')?($matches[2]):(rtrim($currentMsgID) . ' ' . $matches[2]);
               $currentMsgStr = '';
               $status = 'msgid';
               break;
            case 'msgstr':
               //Only add a message if there is a message to add
               if ($matches[2] != '') {
                  //If the last command was a msgstr then a trailing space needs to be
                  //added before appending text
                  $currentMsgStr = ($currentMsgStr == '')?($matches[2]):(rtrim($currentMsgStr) . ' ' . $matches[2]);
               }
               $status = 'msgstr';
               break;
            }
         }
         if (($currentMsgID != '')) {
            $translationArray[$currentMsgID] = $currentMsgStr;
            $currentMsgID = '';
         }
         return $translationArray;
      }
      else {
         ZenUtils::safeDebug($this, "parseTranslationFile", 
                             "Translation file missing: '$translationFile'\n", 21, LVL_WARN);
      }
   }

/**
 * Maintains file associations for domain lists.
 *
 * @var array $_domainList
 */
   var $_domainList;
   
/**
 * The current translation domain in use.
 *
 * @var string $_curDomain
 */
   var $_curDomain;
   
/**
 * The current translation locale (language) in use.
 *
 * @var string $_locale
 */
   var $_locale;
   
/**
 * The translation cache. Any translation files that have been parsed are
 * stored here.
 *
 * @var array $_translationCache
 */
   var $_translationCache;
}


?>
