<?

  include("help_header.php");
  $title = "Administrating zenTrack Configuration";
  $is_help_menu = 1;
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  <span class=highlight>WARNING: Editing the zenTrack config settings can severely harm the tracking system operation.  Edit functions and settings only with proper understanding, and follow the three rules of systems administration: Backup, backup, backup.</span>
  <ul>
    <li><a href="#overview">Overview of Settings</a>
    <li><a href="#editing">Editing Settings</a>
    <li><a href="#adding">Adding Settings</a>
    <li><a href="#deleting">Deleting Settings</a> (don't do it)
  </ul>
  <b><a name="overview"></a>OVERVIEW</b>
  <ul>
  The configuration is divided into three sections: Settings with multiple values, settings which are either on or off, and settings with a single value.
  <P>
    <img src="images/config_view.jpg" width="225" height="400" usemap="#config_view" border="1">
  <P>
  <b>Settings with multiple values</b> are set into groups and arranged by order (starting from zero).  These settings depict things such as what bins are available, what the priority levels should be labelled, etc.  New multiple value settings may be added by checking the appropriate box when adding new settings.  New values for existing multiple valued settings may be added by clicking the button under each section.
  <P>
  <b>Settings which are either On or Off</b> control aspects of zenTrack that may be disabled or enabled as needed.  New settings with On or Off properties may be added by simply adding a setting and assigning it a value of On or a value of Off.  (watch the capitalization)
  <P>
  <b>Settings with a single value</b> control such aspects as font faces, color settings, and various configuration data needed by the system.  They may be added or deleted by following the instructions for the appropriate action.
  </ul>
  <b><a name="editing"></a>EDITING SETTINGS</b>
  <ul>
  The settings values may be edited by changing the text in the appropriate boxes, and then choosing "Save Settings" from the button near the base of the page.
  </ul>
  <b><a name="adding"></a>ADDING NEW SETTINGS</b>
  <ul>
    <img src="images/newsetting_view.jpg" width="590" height="277" usemap="#add_setting" border="1">
  <P>
  The new setting should be named in lower case with underscores(_) in the place of spaces (for consistency), and the value should appear in the box as it will appear in code and practice.
  <P>
  The multiple values checkbox (if checked) will make this a multi-value setting, allowing for more values to be entered once it is saved.
  <P>
  To create an On/Off flag, simply enter On or Off for the value of the setting.
  <P>
  To create more than one setting at a time, enter a value next the the "More" button and click it.  A number of fields will be added equal to the number entered.
  </ul>
  <b><a name="deleting"></a>DELETING SETTINGS</b>
  <ul>
    <img src="images/delsetting_view.jpg" width="400" height="403" usemap="#delete_setting" border="1">
  <P>
  <span class=highlight>YET ANOTHER WARNING: Deleting settings from zenTrack config that the system requires will have severely detrimental affects on operation.  Always back up the database and research the affects before deleting a setting.</span>
  <P>
  If you simply wish to disable a setting, set the value to blank and do not delete it from the database.
  <P>
  By choosing the Delete Settings button at the base of the page, you will recieve a menu of all available settings.  Choose delete to remove that setting.
  <P>
  Choosing the delete link next to a multi-value setting will delete all settings (and the setting itself!) for that setting.
  </ul>
  </blockquote>

<map name="config_view">
<area shape="rect" coords="79,13,184,65" href="#" alt="a value for a multi-valued setting" title="a value for a multi-valued setting">
<area shape="rect" coords="192,12,215,65" href="#" alt="the ranking order of this value " title="the ranking order of this value ">
<area shape="rect" coords="79,82,170,100" href="#" alt="add more values to this setting" title="add more values to this setting">
<area shape="rect" coords="79,108,183,191" href="#" alt="a value for a multi-valued setting" title="a value for a multi-valued setting">
<area shape="rect" coords="192,107,211,196" href="#" alt="the ranking order of this value " title="the ranking order of this value ">
<area shape="rect" coords="0,8,37,31" href="#" alt="a multi value setting" title="a multi value setting">
<area shape="rect" coords="3,103,60,127" href="#">
<area shape="rect" coords="5,232,58,262" href="#">
<area shape="rect" coords="78,204,164,228" href="#" alt="add more values to this setting" title="add more values to this setting">
<area shape="rect" coords="79,238,185,361" href="#" alt="a value for a multi-valued setting" title="a value for a multi-valued setting">
<area shape="rect" coords="192,236,214,360" href="#" alt="the ranking order of this value " title="the ranking order of this value ">
<area shape="rect" coords="81,379,197,394" href="#" alt="add more values to this setting" title="add more values to this setting">
</map>


<map name="add_setting">
<area shape="rect" coords="11,67,226,89" href="#" alt="the name of the setting ( should be in lower case, with _ instead of spaces for names" title="the name of the setting ( should be in lower case, with _ instead of spaces for names">
<area shape="rect" coords="9,91,230,116" href="#" alt="the value of the setting as it will appear in use" title="the value of the setting as it will appear in use">
<area shape="rect" coords="10,116,333,143" href="#" alt="will make this a multi-valued setting (you may then add additional values to it)" title="will make this a multi-valued setting (you may then add additional values to it)">
<area shape="rect" coords="9,155,49,174" href="#" alt="commit to database" title="commit to database">
<area shape="rect" coords="6,193,118,218" href="#" alt="show (number) sets of fields instead of just one" title="show (number) sets of fields instead of just one">
</map>


<map name="delete_setting">
<area shape="rect" coords="-8,-6,399,35" href="#" alt="Believe It!" title="Believe It!">
<area shape="rect" coords="82,39,137,48" href="#" alt="delete the entire setting and all values" title="delete the entire setting and all values">
<area shape="rect" coords="82,86,137,93" href="#" alt="delete the entire setting and all values" title="delete the entire setting and all values">
<area shape="rect" coords="83,154,137,162" href="#" alt="delete the entire setting and all values" title="delete the entire setting and all values">
<area shape="rect" coords="77,244,138,253" href="#" alt="delete the entire setting and all values" title="delete the entire setting and all values">
<area shape="rect" coords="101,51,136,79" href="#" alt="delete a single value from this setting" title="delete a single value from this setting">
<area shape="rect" coords="103,98,135,148" href="#" alt="delete a single value from this setting" title="delete a single value from this setting">
<area shape="rect" coords="104,164,134,241" href="#" alt="delete a single value from this setting" title="delete a single value from this setting">
<area shape="rect" coords="103,259,135,323" href="#" alt="delete a single value from this setting" title="delete a single value from this setting">
<area shape="rect" coords="102,338,135,403" href="#" alt="remove this single-value setting from the database" title="remove this single-value setting from the database">
</map>

<?
  include("$libDir/footer.php");
?>
