<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Zen/Smarty tr (translate) modifier
 *
 * Type:     modifier<br>
 * Name:     tr<br>
 * Purpose:  translate strings for internationalization
 *
 * @param string $string string to be translated
 * @param array $vals values to be substituted for ? placeholders
 * @return string
 */
function smarty_modifier_tr($string, $vals = null)
{
  return ZenUtils::translate($string, $vals);
}

?>
