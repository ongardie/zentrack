<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<div class='menuBoxContainer'>

<div class='menuBox'>
  <div>Description</div>
  <p class='note'>The field map screen is used to configure the look and feel and
  behavior of various screens throughout the application.</p>
  
  <p>The 'screen' represents a certain view in the application, 
  which could be a tab in the ticket view, or a window such as the search form
  or form for creating new tickets.</p>
  
  <p>A 'field' might represent a column, a form field, or a field displayed in
  the view.</p>
</div>

<div class='menuBox'>
  <div>Terminology</div>
  <p class='note'>The screens listed are described briefly below:</p>
  <table width='80%'>
    <tr><th class='headerCell'>Screen</th><th class='headerCell'>Description</th></tr>
    <tr>
      <td class='cell'>project_close<br>ticket_close</td>
      <td class='cell'>
        The screen which is displayed when the 'close' button is pressed while
        viewing a ticket.  Any ticket field may be added to this view and displayed
        on the close screen for entry.  The special fields 'hours' and 'comments' 
        always appear in the close ticket screen and are entered into the log.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_create<br>ticket_create</td>
      <td class='cell'>
        The screen displayed when the 'New Ticket' or 'New Project' button is pressed.
        Used to create new tickets.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_edit<br>ticket_edit</td>
      <td class='cell'>
        The screen displayed when the 'edit' button is pressed while viewing a ticket.
        A special comments field can be added to this view by the Configuration Setting
        edit_reason_required.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_list<br>ticket_list</td>
      <td class='cell'>
        The screen displayed when the 'Projects' or 'Tickets' tab at the top of the
        browser is selected.  This map controls the actual columns that appear in the list.
        This view is read only.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_list_filters<br>ticket_list_filters</td>
      <td class='cell'>
        This view configures the fields which are displayed above the ticket_list.
        They are used to filter the contents of the list window below.  Note that adding
        searchbox or label fields in this view is not very practical or useful.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_tab_*<br>ticket_tab_*</td>
      <td class='cell'>
        This controls the contents of the various tabs which appear while
        viewing a ticket.  Note that each tab can load special helper scripts
        (preload and postload) and can also have access permissions set.  It is
        also possible to make the fields in any tab editable using the "view_only"
        property for the view. (more on these below)
      </td>
    </tr>
    <tr>
      <td class='cell'>project_view_top<br>ticket_view_top</td>
      <td class='cell'>
        This configures the top area that is displayed above the tabs when viewing
        a ticket.  Fields here are configured the same as the project_tab_* views.
      </td>
    </tr>
    <tr>
      <td class='cell'>project_tasks</td>
      <td class='cell'>
        Controls the columns displayed in the project view when the special
        preload/postload window "tasks" is enabled. (more on these below)
      </td>
    </tr>
    <tr>
      <td class='cell'>search_form</td>
      <td class='cell'>
        Controls the fields which are displayed on the search form.  Note that
        the fields in the search form are divided into special sections based on the field
        type.  For instance, date fields have a start/end range rather than
        just a single field.
      </td>
    </tr>
    <tr>
      <td class='cell'>search_list</td>
      <td class='cell'>
        Controls the columns which are displayed in the search results window.
      </td>
    </tr>
    <tr>
      <td class='cell'>search_export</td>
      <td class='cell'>
        Controls the columns which are exported when the "export results" feature
        is used from the search results.
      </td>
    </tr>
    <tr>
      <td class='cell'>searchbox_project<br>searchbox_ticket</td>
      <td class='cell'>
        Controls which fields are used in the special searchbox windows that
        appear for ticket and project fields.
      </td>
    </tr>
  </table>
  
  <p class='note'>The use of Sections:</p>
  
  <p>Sections are special dividers which can appear in certain views (such
  as ticket_create and ticket_edit).  You may add or remove sections as you see
  fit.</p>
  
  <p>Note that some special sections (like 'elapsed') may not be removed, but you may
  uncheck the 'Show' box to hide them.  This is done because they provide special
  functionality that you cannot recreate by any other method.</p>
  
  <p class='note'>Special view properties appear for some screens, they are
  described here:</p>
  <table width='80%'>
    <tr><th class='headerCell'>View Property</th><th class='headerCell'>Description</th></tr>
    <tr>
      <td class='cell'>access_level</td>
      <td class='cell'>
        This specifies the access level that is required to use this screen.
        Note that this feature is only editable in some views, such as ticket tabs.
      </td>
    </tr>
    <tr>
      <td class='cell'>any_option</td>
      <td class='cell'>
        Some views allow "any" to be selected as a choice for certain fields.  This
        option controls whether the "any" option is shown.  Note that only some
        views are capable of allowing the administrator to configure this property.
      </td>
    </tr>
    <tr>
      <td class='cell'>columns</td>
      <td class='cell'>
        The columns property specifies how many fields will be shown on each
        line.  If the number of fields exceeds this number, then multiple lines
        will be shown.
      </td>
    </tr>
    <tr>
      <td class='cell'>has_behaviors</td>
      <td class='cell'>
        This property simply tells the administrator whether behaviors are
        implemented in the corresponding view.
      </td>
    </tr>
    <tr>
      <td class='cell'>label</td>
      <td class='cell'>
        Provides a title for the view or a label to appear in tabs.
      </td>
    </tr>
    <tr>
      <td class='cell'>preload<br>postload</td>
      <td class='cell'>
        These enable special features for a ticket tab and are described in
        detail below.
      </td>
    </tr>
    <tr>
      <td class='cell'>show_totals</td>
      <td class='cell'>
        In some lists of tickets, columns can be totaled (even over multiple pages).
        This feature displays/hides the total information.
      </td>
    </tr>
    <tr>
      <td class='cell'>view_only</td>
      <td class='cell'>
        Certain views allow fields to be edited or to simply appear as text.  This
        feature controls whether the fields are editable.  Note that only some
        views, such as ticket tabs, can be used for either.
      </td>
    </tr>
    <tr>
      <td class='cell'>visible</td>
      <td class='cell'>
        Unchecking this will disable certain views by removing them from
        the interface.
      </td>
    </tr>
    <tr>
      <td class='cell'>width</td>
      <td class='cell'>
        This is used with ticket tabs to specify how wide each field will be
        in the display.  Use this together with 'columns' to get a good display
        set based on your fields' optimal width.
      </td>
    </tr>
    
  </table>
  
  <p class='note'>The columns listed for each field are described here:</p>
  <table width='80%'>
    <tr><th class='headerCell'>Column Name</th><th class='headerCell'>Description</th></tr>
    <tr>
      <td class='cell'>Options</td>
      <td class='cell'>
        Provides options to reorder fields and to delete/add sections.  Note that
        it is not advisable to reorder and edit fields at the same time!
      </td>
    </tr>
    <tr>
      <td class='cell'>Name</td>
      <td class='cell'>
        The field name as it appears in the database
      </td>
    </tr>
    <tr>
      <td class='cell'>Label</td>
      <td class='cell'>
        The field name as it should appear in the screen
      </td>
    </tr>
    <tr>
      <td class='cell'>Show</td>
      <td class='cell'>
        Unchecking this box removes the field from the view.  Note that for
        forms the field becomes hidden, so that it can still be used by
        behaviors, but cannot be edited.
      </td>
    </tr>
    <tr>
      <td class='cell'>Required</td>
      <td class='cell'>
        Checking this box means that the field must contain a value in order
        to submit a form in this screen.
      </td>
    </tr>
    <tr>
      <td class='cell'>Default</td>
      <td class='cell'>
        Supply a default value for the field.  This has no affect in view only
        screens.  For custom_menu fields, this field is used to select a "Data Group"
        which contains the values to appear in the dropdown.  The default
        value is always the first one in the list.
      </td>
    </tr>
    <tr>
      <td class='cell'>Type</td>
      <td class='cell'>
        The types of fields are described below
      </td>
    </tr>
    <tr>
      <td class='cell'>Columns</td>
      <td class='cell'>
        The columns specifies the maximum width of input fields, and the length
        of columns in view only screens.  Note that the input fields will only expand
        up to a certain width, but the number of characters which can be entered
        in total always matches this value.
      </td>
    </tr>
    <tr>
      <td class='cell'>Rows</td>
      <td class='cell'>
        For menus and textareas, this determines the height of the field.  It
        has no affect on any other fields.
      </td>
    </tr>
  </table>
  
  <p class='note'>The field types are:</p>
  <table width='80%'>
    <tr><th class='headerCell'>Field Type</th><th class='headerCell'>Description</th></tr>
    <tr>
      <td class='cell'>Checkbox</td>
      <td class='cell'>
        Shows a checkbox for the field, the value entered is always 1 if checked
        and 0 if not.  If more than one entry is allowed, then this will show a
        list of possible values.  Note that this feature will only work with certain fields.
      </td>
    </tr>
    <tr>
      <td class='cell'>Date</td>
      <td class='cell'>
        Displays the field with a date picker icon.
      </td>
    </tr>
    <tr>
      <td class='cell'>Hidden</td>
      <td class='cell'>
        The field is not displayed to the user.  For forms, this is the same as
        unchecking the "Show" box.  For view only screens, this completely removes the field.
      </td>
    </tr>
    <tr>
      <td class='cell'>Label</td>
      <td class='cell'>
        Display the field as text only.  For forms, the value is still provided
        in a hidden field for use in behaviors.
      </td>
    </tr>
    <tr>
      <td class='cell'>Menu</td>
      <td class='cell'>
        A list of choices is provided in a dropdown menu.
      </td>
    </tr>
    <tr>
      <td class='cell'>Options</td>
      <td class='cell'>
        Provides options to reorder fields and to delete/add sections.  Note that
        it is not advisable to reorder and edit fields at the same time!
      </td>
    </tr>
    <tr>
      <td class='cell'>Radio</td>
      <td class='cell'>
        Shows a list of radio buttons for all of the possible choices.
      </td>
    </tr>
    <tr>
      <td class='cell'>Searchbox</td>
      <td class='cell'>
        Provides a search window and displays the chosen records in
        a special table.
      </td>
    </tr>
    <tr>
      <td class='cell'>Section</td>
      <td class='cell'>
        Displays a special divider between areas of a form.  Note that some special
        fields are also provided as type "section".
      </td>
    </tr>
  </table>
  
  <p class='note'>The special options preload/postload are used to display
  special data in the ticket view.  Here are some of the choices and what
  they do:</p>
  <table width='80%'>
    <tr><th class='headerCell'>Loader</th><th class='headerCell'>Description</th></tr>
    <tr>
      <td class='cell'>Attachments</td>
      <td class='cell'>
        Display a table of attachments which are linked to the ticket.  Attachments
        can be added/removed from this table.
      </td>
    </tr>
    <tr>
      <td class='cell'>Contacts</td>
      <td class='cell'>
        Display a list of contacts which have been linked to the ticket.  Contacts
        can be added or removed using this table.
      </td>
    </tr>
    <tr>
      <td class='cell'>Details</td>
      <td class='cell'>
        Display the "details" field of the ticket with special formatting.  URLs
        are converted to links, white space is preserved, and a scrollbar is included
        for maximum screen usage.  The size of the box is set using the
        Configuration Setting max_textbox_height
      </td>
    </tr>
    <tr>
      <td class='cell'>Log</td>
      <td class='cell'>
        Displays log entries in sortable, filterable, scrolling box.  The size
        of the box is configured using the Configuration Setting max_textbox_height.
      </td>
    </tr>
    <tr>
      <td class='cell'>Notify</td>
      <td class='cell'>
        Displays the notify list for the ticket.  Contacts and users can be added/removed
        from this table.
      </td>
    </tr>
    <tr>
      <td class='cell'>Project</td>
      <td class='cell'>
        Displays the title of the parent project (if any) and provides a link
        to that project.
      </td>
    </tr>
    <tr>
      <td class='cell'>Related</td>
      <td class='cell'>
        Displays related tickets in a table with links.
      </td>
    </tr>
    <tr>
      <td class='cell'>Tasks</td>
      <td class='cell'>
        Displays the list of tickets which are attached to a project
        in a sortable, paging table.  The format of the columns in this list
        is configured using the project_tasks field map.
      </td>
    </tr>
  </table>
</div>

</div>
<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
