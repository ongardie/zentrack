<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>
<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    <p>Variable fields are extra fields included in the ticket which can be
       utilized for special needs of your organization.</p>
    
    <p>Variable fields can be boolean (checkboxes), numbers, strings 
    (text fields), large text areas, or dates.</p>
    
    <p>Variable fields can be enabled/configured by going to:
    <br><b><?=tr('Admin')?> -&gt; <?=tr('Ticket Administration')?> -&gt; <?=tr('Edit Field Map')?></b>.
    
    <p>See the <a href='<?=$helpUrl?>/admin/fieldmap.php'>Field Map Documentation</a> for more
    information about how to configure the field map settings.
    
    <p>The variable field columns are listed as custom_string, custom_number,
    custom_date, etc...
    
    <p>The variable field data is maintained in the ZENTRACK_VARFIELD table.
  </td>
</tr>
<tr>
  <td class='titleCell'>Multi Value Fields</td>
</tr>
<tr>
  <td class='cell'>
    <p>Use custom_multi fields for menus where the user will need to select more than one entry.</p>
    
    <p>They are configured in the field map just like the other variable fields.</p>
    
    <p>The custom_multi field data is stored in the ZENTRACK_VARFIELD_MULTI table</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Adding New Variable Fields</td>
</tr>
<tr>
  <td class='cell'>
    <p>Unfortunately there is no automated process for adding variable fields into
    the database, since the software currently doesn't support meta databases.  However,
    it is possible to add variable fields manually.</p>
    
    <p class='error'>This task requires a good understanding of Relational
    Databases.  Do not attempt this if you are not experienced.  Instead, 
    contact the project team and ask for assistance.</p>
    
    <p>Columns added to the ZENTRACK_VARFIELD table must be named in the
    format custom_ttttXX where tttt represents the type (menu, string,
    number, boolean, date, or text) and XX represents the consecutive number
    (you cannot skip any numbers).</p>
    
    <p>For our examples here, we will assume we want to create the new field
    <b>custom_string3</b>.</p>
    
    <p><b>Step 1: BACKUP DATABASE</b></p>
    <p>Create a backup of anything in your database you desire to keep.</p>
    
    <p><b>Step 2: Open SQL Interface of your choice</b></p>
    
    <p><b>Step 3: Create database column</b></p>
    <p>For any field except custom_mulit, run the equivalent command for your database, insuring you enter the correct column type:
    <br>alter table ZENTRACK_VARFIELD add column custom_string3 varchar(255);
    </p>
    
    <p>To create a custom_multi field, run this command instead:
    <br>alter table ZENTRACK_VARFIELD_MULTI add column custom_multi3 varchar(255);
    </p>
    
    <p><b>Step 4: Insert field into the field map</b></p>
    <p>Make a copy of the file install/utils/add_to_map.sql and make the following
    changes to this file.</p>

    <p>Substitute your field name for custom_string3</p>
    
    <p>If you are not creating a string type field, make the following substitutions according
    to the field type:</p>
    <table width='80%' align='center'>
      <tr><th class='subTitle'>Field Type</th><th class='subTitle'>Replace</th><th class='subTitle'>With</th></tr>
      <tr><td class='bars'>custom_menu</td><td class='bars'>'text'</td><td class='bars'>'menu'</td></tr>
      <tr><td class='bars'>custom_text</td><td class='bars'>'text'</td><td class='bars'>'textarea'</td></tr>
      <tr><td class='bars'>custom_date</td><td class='bars'>'text'</td><td class='bars'>'date'</td></tr>
      <tr><td class='bars'>custom_date</td><td class='bars'>'200'</td><td class='bars'>'20'</td></tr>
      <tr><td class='bars'>custom_number</td><td class='bars'>'200'</td><td class='bars'>'20'</td></tr>
      <tr><td class='bars'>custom_multi</td><td class='bars'>'text'</td><td class='bars'>'menu'</td></tr>
      <tr><td class='bars'>custom_multi</td><td class='bars'>'200','1','0'</td><td class='bars'>'50','8','0'</td></tr>
    </table>
    
    <p>Note that the field_map_id must be unique.  We started you off at 9000, which should
    never conflict with any upgrades.  If you add more than one field, you will want to
    increase this number each time so that all entries have a unique id.</p>
    
    <p>Run the commands against your SQL client.</p>
    
    <p><b>Step 5: Log into zentrack</b></p>
    <p>You must close your browser windows and open a new window.  Login as
    Administrator.</p>
    
    <p><b>Step 6: Edit Varfield Settings</b></p>
    <p>Browse to the Edit Field Map section and update your new field on each view where it will be displayed</p>
    
    <p><b>Step 7: Clear the Browser's Session Data</b></p>
    <p>This is done by closing all instances of the browser window.  If you have
    debugging enabled, you may use the 'click here to clear session cache' link
    instead.</p>
  </td>
</tr>
</table>
<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
