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
    array( "text"     => "Text",         "textarea" => "Text Area",     "select"   => "Select Menu", 
	   "hidden"   => "Hidden Field", "radio"    => "Radio Button",  "checklist"=> "Checkbox List", 
	   "checkbox" => "Checkbox",     "immutable"=> "Immutable",     "searchbox"=> "Search Box", 
	   "popselect"=> "Popup Select", "datebox"  => "Date Picker",   "colorbox" => "Color Picker", 
	   "yesno"    => "Yes/No Menu",  "setting"  => "Setting Field", "spacer"   => "Spacer Row",  
           "skip"     => "Skip" );

  /**
   * List of options for making comparisons
   */
  $GLOBALS['criteriaLists']['comparison'] =
    array( ZEN_EQ       => "Equals", 
           ZEN_LT       => "Less Than", 
           ZEN_LE       => "Less or Equal",
           ZEN_GT       => "Greater Than",
           ZEN_GE       => "Greater or Equal",
           ZEN_CONTAINS => "Contains",
           ZEN_BEGINS   => "Begins With",
           ZEN_ENDS     => "Ends With",
           ZEN_IN       => "In (list)" );
  
  /**
   * Time periods which can be used as intervals
   */
  $GLOBALS['criteriaLists']['timeset'] =
    array( "seconds"  => "Seconds",
           "minutes"  => "Minutes",
           "hours"    => "Hours",
           "days"     => "Days",
           "weeks"    => "Weeks",
           "months"   => "Months",
           "quarters" => "Quarters",
           "years"    => "Years" );
}?>
