<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Provides config settings so that tests can run properly.  All tests should include this file.
   *
   * Requirements: Two variables must be set in this file to run tests properly(they will normally auto-configure)
   *
   * @package PHPUnit
   */
  
  /** @var The installation directory (determined by dropping two levels from here) */
  $install_dir = preg_replace('#/utilities/tests/?#', '', dirname(__FILE__));
  
  /** @var The location of the ini file(install/utilities) */
  $ini_file = $install_dir."/zen.ini";
  
  /** @var The location of the Zen.php class(install/setup) */
  $class = $install_dir."/setup/ZenUtils.php";

  /** Include the ZenUtils.php class */
  include_once($class);
  
  /** Include the ini file and process it */
  $GLOBALS['zen'] = ZenUtils::read_ini($ini_file);
  $GLOBALS['zen']['directories']['dir_install'] = $install_dir;

  /** Get all of the class files */
  include_once($GLOBALS['zen']['directories']['dir_lib']."/inc/classes.php");
  load_classes( $classes_all, $GLOBALS['zen']['directories']['dir_classes'] );

}?>
