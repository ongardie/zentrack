<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * Provides standards critiera lists to be used by templates and forms
   *
   * @package Libs
   */

  /**
   * The basic criteria array
   */
  $GLOBALS['criteriaLists'] = array();

  /**
   * List of possible form field types
   */
  $GLOBALS['criteriaLists']['ftypes'] = 
    array( "text",      "textarea",  "select", 
	   "hidden",    "radio",     "checklist", 
	   "checkbox",  "immutable", "searchbox[user]", 
	   "searchbox[ticket]",      "searchbox[log]",
	   "popselect", "datebox",   "colorbox", 
	   "yesno",     "setting",   "heading",
	   "spacer",    "skip" );


}?>
