<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

/**
 * Contains the template processing engine
 * @package Utils
 */

  /**
   *  TEMPLATE PROCESSING ENGINE
   *
   * The template processing engine employs Smarty templates (http://smarty.php.net) to
   * generate a templating/skinning system for zentrack.  
   *
   * This class is simply a wrapper which depends on the smarty/Smarty.class.php file and
   * prepares appropriate system parameters for use.  Note that the smarty class is
   * included in the common classes (see lib/inc/classes.php) and is not prepped here. Thus,
   * it must be included manually before calling this class if not invoked normally.
   *
   * @package Utils
   */
class ZenTemplate extends Smarty {

  /**
   * Invoke the Smarty class and prepare configuration params
   *
   * @see http://smarty.php.net/manual/en/installing.smarty.extended.php
   * @param array $ini_vars if the normal ini config is not available (say during setup, etc)
   *              then the ini properties can be passed manually here.  The name of an ini
   *              file may also be passed here.
   */
  function ZenTemplate( $ini_vars = null ) {
    $this->randomNumber = mt_rand(1,10000)."-".mt_rand(1,10000);
    ZenUtils::mark("ZenTemplate->init({$this->randomNumber})");

    // find out which ini settings to use
    if( !is_array($ini_vars) ) {
      $ini_vars = ZenUtils::findIni( $ini_vars );
    }
    
    // initialize smarty template
    $this->Smarty();
    if( isset($ini_vars['directories']) ) {
      $sep = DIRECTORY_SEPARATOR;
      $this->template_dir = $ini_vars['directories']['dir_templates']
        .$sep.$ini_vars['layout']['template_set'];
      $this->compile_dir = $ini_vars['directories']['dir_cache'].$sep.'tpl_compiled';
      $this->config_dir = $ini_vars['directories']['dir_config'];
      $this->cache_dir = $ini_vars['directories']['dir_cache'].$sep.'tpl_cached';
    }
    $this->caching = false;

    // load ini directives for easy access
    $this->assign('ini', $ini_vars);

    ZenUtils::unmark("ZenTemplate->init({$this->randomNumber})");
  }

  /**
   * Render the template (to stdout)
   *
   * @link http://smarty.php.net/manual/en/api.display.php
   * @param string $template name of template to render
   * @param string $cache_id
   * @param string $compile_id
   */
  function display( $template, $cache_id = null, $compile_id = null ) {
    $u = microtime();
    ZenUtils::mark("ZenTemplate->display($template:{$this->randomNumber}:$u)");
    parent::display($template, $cache_id, $compile_id);
    ZenUtils::unmark("ZenTemplate->display($template:{$this->randomNumber}:$u)");
  }

  /**
   * Return parsed template contents
   *
   * @link http://smarty.php.net/manual/en/api.fetch.php
   * @param string $template name of template to render
   * @param string $cache_id
   * @param string $compile_id
   * @param boolean $display if true, output to stdout
   * @return string containing parsed results
   */
  function fetch( $template, $cache_id = null, $compile_id = null, $display = false) {
    $u = microtime();
    ZenUtils::mark("ZenTemplate->fetch($template:{$this->randomNumber}:$u)");
    $text = parent::fetch($template, $cache_id, $compile_id, $display);
    ZenUtils::unmark("ZenTemplate->fetch($template:{$this->randomNumber}:$u)");
    return $text;
  }

  /**
   * Used to track specific instances of the ZenTemplate class
   * @access private
   * @var string
   */
  var $randomNumber;

}

?>
