<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Zen/Smarty ffv (fix form value) modifier
 *
 * Type:     modifier<br>
 * Name:     ffv<br>
 * Purpose:  makes values safe for use in form fields
 *
 * @param string $string string to be translated
 * @param array $vals values to be substituted for ? placeholders
 * @return string
 */
function smarty_modifier_tr($string, $vals = null)
{
  return ZenUtils::ffv($string, $vals);
}

?>
