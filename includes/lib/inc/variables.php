<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  // set the path variables
  $libDir = $zen['directories']['lib'];
  $includesDir = $zen['paths']['path_includes'];
  $cacheDir = $zen['directories']['cache'];
  $templateDir = $zen['directories']['templates']."/".$zen['layout']['template'];

  $webDir = $zen['paths']['path_www'];
  $webUrl = $zen['paths']['url_www'];

  /**
   * @var array $_GLOBALS['zen'] is an array parsed from the php.ini file settings
   */
  $_GLOBALS['zen'] = $zen;
  $_GLOBALS['libDir'] = $libDir;
  $_GLOBALS['includesDir'] = $includesDir;
  $_GLOBALS['cacheDir'] = $cacheDir;
  $_GLOBALS['templateDir'] = $templateDir;
  $_GLOBALS['dbConnection'] = null;

  /**
   * @var array $_GLOBALS['loadstat'] is an array of all the static objects which have been loaded
   *
   * It consists of two parts:
   *   perm - objects stored between pages (serialized)
   *   temp - objects not kept between pages
   */
  $_GLOBALS['loadstat']['perm'] =& $_SESSION['loadstat'];
  $_GLOBALS['loadstat']['temp'] = array("tickets"  => array(),
                                        "users"    => array(),
                                        "triggers" => array(),
                                        "actions"  => array()
                                        );

  // clean up page variables
  $page_title = $zen['layout']['default_title'];
  $page_prefix = $zen['layout']['default
  $id = isset($id)? preg_replace("/[^0-9]/", "", $id) : null;
  $errs = array();
  $msg = array();
  
}?>
