<? if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Manages keyboard shortcuts for all pages.
 *
 * There are global assignments (those which are available on every page) and
 * local assignments (which are loaded using ZenHotKeys::loadSection().
 *
 * A singleton instance of this class is maintained in $hotkeys by the
 * includes/headerInc.php file.
 *
 * Initialization of this class requires that the (zenTrack)$zen and (ZenFieldMap)$map
 * singletons be declared in the global scope before calling the constructor.
 */
class ZenHotKeys {
  
  function ZenHotKeys( &$zen ) {
    $this->_zen =& $zen;
    $this->_keys = array();
    $this->_fxns = array();
    $this->_idx = array();
    $this->_tabs = array();
    $this->_keysRendered = array();
    $this->_tabkeys = array();
    $this->_lh = '';
    $this->_alternate = $zen->getSetting('hotkeys_alternate_hints');
    $this->_alreadyLoaded = array();
    $this->_urlMatches = array();
	
	// mozilla has changed their accesskey to alt+shift... so let's make sure we use that correctly.
	// HTTP_USER_AGENT=>'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.10) Gecko/20071115 Firefox/2.0.0.10'
    $this->isFirefox = !empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') > 0;
	$this->accessKey = $this->isFirefox? "ALT+SHIFT" : "ALT";

    $this->_initSections();
    $this->loadSection('globals');
	
  }
  
  /**
   * Generates section information (right now it is just hard coded, later we will add this to the db)
   */
  function _initSections() {
    global $zen;
	global $map;
    $this->_sections = array();
    
    ////////////////////////
    // GLOBALS
    ////////////////////////
    $c = 1;
    $this->newFxn('quickFocus', 'window.document.quickIdForm.idText.focus(); quickHighlight("window.document.quickIdForm.idText","searchHelpBox");', '', true);
    $this->_sections['globals'] = array();
    $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Projects', "KeyEvent.loadUrl('{rootUrl}/projects.php')", '', true);
    $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Tickets', "KeyEvent.loadUrl('{rootUrl}/index.php')", '', true);
    if( $this->_zen->settingOn('allow_contacts') ) {
      $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Contacts',    "KeyEvent.loadUrl('{rootUrl}/contacts.php')", '', true);
    }
    $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Options', "KeyEvent.loadUrl('{rootUrl}/options.php')", '', true);  
    $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Help', "KeyEvent.loadUrl('{rootUrl}/help/index.php')", '', true);  
    $this->_sections['globals'][$this->checkMetaKey('ALT', $c++)] = array('Admin', "KeyEvent.loadUrl('{rootUrl}/admin/index.php')", '', true);  
    $this->_sections['globals'][$this->checkMetaKey('ALT', 'P')] = array('New Project', "KeyEvent.loadUrl('{rootUrl}/newProject.php')", '', true);  
    $this->_sections['globals'][$this->checkMetaKey('ALT', 'T')] = array('New Ticket',  "KeyEvent.loadUrl('{rootUrl}/newTicket.php')", '', true);  
    $this->_sections['globals'][$this->checkMetaKey('ALT', 'C')] = array('New Contact', "KeyEvent.loadUrl('{rootUrl}/newContact.php')", '', true);
    $this->_sections['globals'][$this->checkMetaKey('ALT', 'S')] = array('Search', "quickFocus()", 'Enter a ticket id or summary', true);
    $this->_sections['globals'][$this->checkMetaKey('ALT', 'V')] = array('Advanced Search', "KeyEvent.loadUrl('{rootUrl}/search.php')", "Advanced ticket search", true);
    
    ////////////////////////
    // ADMIN
    ////////////////////////
    $this->_sections['admin'] = array();
    $this->_sections['admin'][$this->checkMetaKey('ALT', 'N')] = array('New User', "KeyEvent.loadUrl('{rootUrl}/admin/addUser.php')", '', false);
    $this->_sections['admin'][$this->checkMetaKey('ALT', 'U')] = array('Edit Users', "KeyEvent.loadUrl('{rootUrl}/admin/listUsers.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'E')] = array('Edit Tickets', "KeyEvent.loadUrl('{rootUrl}/admin/editTicket.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'F')] = array('Edit Field Map', "KeyEvent.loadUrl('{rootUrl}/admin/fieldMap.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'B')] = array('Bins', "KeyEvent.loadUrl('{rootUrl}/admin/bins.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'P')] = array('Priorities', "KeyEvent.loadUrl('{rootUrl}/admin/priorities.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'S')] = array('Systems', "KeyEvent.loadUrl('{rootUrl}/admin/systems.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'T')] = array('Tasks', "KeyEvent.loadUrl('{rootUrl}/admin/tasks.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'Y')] = array('Types', "KeyEvent.loadUrl('{rootUrl}/admin/types.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'D')] = array('Data Groups', "KeyEvent.loadUrl('{rootUrl}/admin/groups.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'H')] = array('Behaviors', "KeyEvent.loadUrl('{rootUrl}/admin/behaviors.php')", '', false);
    //$this->_sections['admin'][$this->checkMetaKey('ALT', 'C')] = array('Configuration', "KeyEvent.loadUrl('{rootUrl}/admin/config.php')", '', false);

    ////////////////////////
    // ACTIONS
    ////////////////////////
    $this->_sections['actionbar'] = array();
    $actions = $this->_zen->getActions();
    foreach($actions as $k=>$v) {
      if( $v['button'] && $v['key'] ) {
        if( $k == 'print' ) {
          $this->_sections['actionbar'][$v['key']] = array("Action: {$v['label']}", "printWindow", '', false);
          continue;
        }
        $this->_sections['actionbar'][$v['key']] = array("Action: {$v['label']}", 
          "KeyEvent.loadUrl('{rootUrl}/actions/$k.php?id={id}')", $v['label'], false);
      }
    }

    ////////////////////////
    // action_approve
    ////////////////////////
    $f = "window.document.formless['approveForm']";
    $this->_sections['action_approve'] = array();
    $this->_sections['action_approve'][$this->checkMetaKey('ALT', 'O')] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_approve'][$this->checkMetaKey('ALT', 'A')] = array('Approve', "{$f}.submit()", '', false);

    ////////////////////////
    // action_assign
    ////////////////////////
    $f = "window.document.forms['assignForm']";
    $this->_sections['action_assign'] = array();
    $this->_sections['action_assign'][$this->checkMetaKey('ALT', 'R')] = array('Recipient', "{$f}.elements['user_id'].focus()", '', false);
    $this->_sections['action_assign'][$this->checkMetaKey('ALT', 'O')] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_assign'][$this->checkMetaKey('ALT', 'A')] = array('Assign', "{$f}.submit()", '', false);

    ////////////////////////
    // action_close
    ////////////////////////
    $this->_sections['action_close'] = array();
    $this->_sections['action_close'][$this->checkMetaKey('ALT', 'H')] = array('Field: hours', "window.document.forms['ticketTabForm'].elements['hours'].select()", 'Hours', false);
    $this->_sections['action_close'][$this->checkMetaKey('ALT', 'O')] = array('Field: comments', "window.document.forms['ticketTabForm'].elements['comments'].select()", 'Comments', false);
    $this->_sections['action_close'][$this->checkMetaKey('ALT', 'L')] = array('Close', "window.document.forms['ticketTabForm'].submit()", '', false);
    
    ////////////////////////
    // action_contacts
    ////////////////////////
    $this->_sections['action_contacts'] = array();
    $this->_sections['action_contacts'][$this->checkMetaKey('ALT', 'N')] = array('Create New Contact', "window.document.forms['newContactForm'].submit()", '', false);
    $this->_sections['action_contacts'][$this->checkMetaKey('ALT', 'A')] = array('Add Contact', "window.document.forms['ContactsAddForm'].submit()", '', false);
    $this->_sections['action_contacts'][$this->checkMetaKey('ALT', 'D')] = array('Drop Contacts', "window.document.forms['dropContactsForm'].submit()", '', false);
    $this->_sections['action_contacts'][$this->checkMetaKey('ALT', 'Y')] = array('Field: company_id', "window.document.forms['ContactsAddForm'].elements['company_id'].focus()", 'Company', false);
    $this->_sections['action_contacts'][$this->checkMetaKey('ALT', 'E')] = array('Field: person_id', "window.document.forms['ContactsAddForm'].elements['person_id'].focus()", 'Person', false);
    
    ////////////////////////
    // action_notify
    ////////////////////////
    $this->_sections['action_notify'] = array();
    $f = "window.document.forms['notifyAddForm']";
    $this->_sections['action_notify'][$this->checkMetaKey('ALT', 'R')] = array('Enter Registered Users', "{$f}.elements['user_accts'].select()", '', false);
    $this->_sections['action_notify'][$this->checkMetaKey('ALT', 'U')] = array('Add an Unregistered User', "{$f}.elements['unreg_name'].select()", '', false);
    $this->_sections['action_notify'][$this->checkMetaKey('ALT', 'O')] = array('Add a Contact', "{$f}.elements['company_id'].focus()", '', false);
    $this->_sections['action_notify'][$this->checkMetaKey('ALT', 'A')] = array('Add Recipients', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_email
    ////////////////////////
    $this->_sections['action_email'] = array();
    $f = "window.document.forms['emailForm']";
    $this->newFxn('emailFormToggle', "var obj = {$f}.elements['method']; var newVal = arguments[0]; for(var i=0; i < obj.length; i++) { if( obj[i].value == newVal ) { obj[i].checked = true; break; } }");
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'U')] = array('Select a User', "{$f}.elements['users_to_email[]'].focus();", "Select one or more users, use CTRL or SHIFT key for multiples", false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'M')] = array('Manually Enter Addresses', "{$f}.elements['custom_email_addresses'].select();", "Manually enter an email address, use commas to separate multiple addresses", false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'O')] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'E')] = array('Send Email', "{$f}.submit()", '', false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'L')] = array('send option: link', "emailFormToggle(1)", '', false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'Y')] = array('send option: summary', "emailFormToggle(2)", '', false);
    $this->_sections['action_email'][$this->checkMetaKey('ALT', 'G')] = array('send option: log', "emailFormToggle(3)", '', false);
    
    ////////////////////////
    // action_log
    ////////////////////////
    $this->_sections['action_log'] = array();
    $f = "window.document.forms['logForm']";
    $this->_sections['action_log'][$this->checkMetaKey('ALT', 'Y')] = array('Select an Activity', "{$f}.elements['log_action'].focus()", '', false);
    $this->_sections['action_log'][$this->checkMetaKey('ALT', 'H')] = array('Enter Hours Worked', "{$f}.elements['hours'].select()", '', false);
    $this->_sections['action_log'][$this->checkMetaKey('ALT', 'O')] = array('Log Entry / Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_log'][$this->checkMetaKey('ALT', 'A')] = array('Save Log', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_move
    ////////////////////////
    $this->_sections['action_move'] = array();
    $f = "window.document.forms['moveForm']";
    $this->_sections['action_move'][$this->checkMetaKey('ALT', 'B')] = array('New Bin', "{$f}.elements['newBin'].focus()", '', false);
    $this->_sections['action_move'][$this->checkMetaKey('ALT', 'O')] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_move'][$this->checkMetaKey('ALT', 'M')] = array('Move', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_reject
    ////////////////////////
    $this->_sections['action_reject'] = array();
    $f = "window.document.forms['rejectForm']";
    $this->_sections['action_reject'][$this->checkMetaKey('ALT', 'O')] = array('Reason', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_reject'][$this->checkMetaKey('ALT', 'R')] = array('Reject', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_relate
    ////////////////////////
    $this->_sections['action_relate'] = array();
    $f = "window.document.forms['relateTicketForm']";
    $this->_sections['action_relate'][$this->checkMetaKey('ALT', 'I')] = array('Enter Ticket IDs', "{$f}.elements['relations'].select()", '', false);
    $this->_sections['action_relate'][$this->checkMetaKey('ALT', 'O')] = array('Comments', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_relate'][$this->checkMetaKey('ALT', 'R')] = array('Relate', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_reopen
    ////////////////////////
    $this->_sections['action_reopen'] = array();
    $f = "window.document.forms['reopenForm']";
    $this->_sections['action_reopen'][$this->checkMetaKey('ALT', 'O')] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_reopen'][$this->checkMetaKey('ALT', 'R')] = array('Reopen', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_test
    ////////////////////////
    $this->_sections['action_test'] = array();
    $f = "window.document.forms['testForm']";
    $this->_sections['action_test'][$this->checkMetaKey('ALT', 'H')] = array('Hours Worked', "{$f}.elements['hours'].select()", '', false);
    $this->_sections['action_test'][$this->checkMetaKey('ALT', 'O')] = array('Comments or Instructions', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_test'][$this->checkMetaKey('ALT', 'E')] = array('Testing Complete', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_upload
    ////////////////////////
    $this->_sections['action_upload'] = array();
    $f = "window.document.forms['addAttachmentForm']";
    $this->_sections['action_upload'][$this->checkMetaKey('ALT', 'U')] = array('Select a File to Upload', "{$f}.elements['userfile'].focus()", '', false);
    $this->_sections['action_upload'][$this->checkMetaKey('ALT', 'E')] = array('Description of Attachment', "{$f}.elements['comments'].select()", '', false);
    $this->_sections['action_upload'][$this->checkMetaKey('ALT', 'A')] = array('Add Attachment', "{$f}.submit()", '', false);
    
    ////////////////////////
    // action_yank
    ////////////////////////
    $this->_sections['action_yank'] = array();
    $this->_sections['action_yank'][$this->checkMetaKey('ALT', 'O')] = array('Reason', "window.document.forms['pullForm'].elements['comments'].select()", '', false);
    $this->_sections['action_yank'][$this->checkMetaKey('ALT', 'U')] = array('Pull', "window.document.forms['pullForm'].submit()", '', false);
    
    ////////////////////////
    // agreement_view
    ////////////////////////
    $this->_sections['agreement_view'] = array();
    $this->_sections['agreement_view'][$this->checkMetaKey('ALT', 'E')] = array('Edit', "window.document.forms['editAgreementForm'].submit()", '', false);
    $msg = Zen::fixJsHtml(tr("Are you sure you want to archive this agreement?"),"'");
    $this->_sections['agreement_view'][$this->checkMetaKey('ALT', 'A')] = array('Archive', "confirmSubmit(window.document.forms['archiveAgreementForm'],$msg)", '', false);
    $msg = Zen::fixJsHtml(tr("Are you sure you want to delete this agreement?"),"'");
    $this->_sections['agreement_view'][$this->checkMetaKey('ALT', 'D')] = array('Delete', "confirmSubmit(window.document.forms['deleteAgreementForm'],$msg)", '', false);
    
    ////////////////////////
    // agreement_form
    ////////////////////////
    $this->_sections['agreement_form'] = array();
    $f = "window.document.forms['agreementForm']";
    $this->_sections['agreement_form'][$this->checkMetaKey('ALT', 'A')] = array('Add Item', "rerouteAgreementForm('addItems')", '', false);
    $this->_sections['agreement_form'][$this->checkMetaKey('ALT', 'M')] = array('Name', "fieldFocus('agreementForm','name1')", '', false);
    $this->_sections['agreement_form'][$this->checkMetaKey('ALT', 'O')] = array('Drop Items', "rerouteAgreementForm('removeItems')", '', false);
    $this->_sections['agreement_form'][$this->checkMetaKey('ALT', 'I')] = array('Agreement ID', "{$f}.elements['contractnr'].select()", '', false);
    $this->_sections['agreement_form'][$this->checkMetaKey('ALT', 'E')] = array('Description', "{$f}.elements['description'].select()", '', false);
    
    ////////////////////////
    // auto_login
    ////////////////////////
    $this->_sections['auto_login'] = array();
    $this->_sections['auto_login'][$this->checkMetaKey('ALT', 'O')] = array('Turn On', "window.document.autoForm.submit()", 'Toggle setting on/off', false);

    ////////////////////////
    // contacts
    ////////////////////////
    $this->_sections['contacts'] = array();
    $this->_sections['contacts'][$this->checkMetaKey('ALT', 'N')] = array('Find', "KeyEvent.loadUrl('{rootUrl}/searchContacts.php')", '', false);
    $this->_sections['contacts'][$this->checkMetaKey('ALT', 'B')] = array('Browse', "KeyEvent.loadUrl('{rootUrl}/agreements.php')", '', false);
    $this->_sections['contacts'][$this->checkMetaKey('ALT', 'G')] = array('New Agreement', "KeyEvent.loadUrl('{rootUrl}/newAgreement.php')", '', false);
    
    ////////////////////////
    // contacts_new_menu
    ////////////////////////
    $this->_sections['contacts_new_menu'] = array();
    $this->_sections['contacts_new_menu'][$this->checkMetaKey('ALT', 'Y')] = array('New Company', "KeyEvent.loadUrl('{rootUrl}/newContact.php?mode2=1')", '', false);
    $this->_sections['contacts_new_menu'][$this->checkMetaKey('ALT', 'N')] = array('New Person', "KeyEvent.loadUrl('{rootUrl}/newContact.php?mode2=2')", '', false);
    
    ////////////////////////
    // contacts_view
    ////////////////////////
    $this->_sections['contacts_view'] = array();
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'D')] = array('Edit', "KeyEvent.loadUrl('{rootUrl}/actions/contact_edit.php?cid={id}')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'L')] = array('Delete', "KeyEvent.loadUrl('{rootUrl}/actions/contact_delete.php?cid={id}')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'E')] = array('Add Employee', "KeyEvent.loadUrl('{rootUrl}/actions/contact_employee.php?cid={id}')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'A')] = array('Add Agreement', "KeyEvent.loadUrl('{rootUrl}/actions/contact_agreement.php?cid={id}')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'I')] = array('View Tickets', "KeyEvent.loadUrl('{rootUrl}/contact.php?overview=tickets&cid={id}')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'Y')] = array('View Employees', "KeyEvent.loadUrl('{rootUrl}/contact.php?cid={id}&overview=contact')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'M')] = array('View Agreements', "KeyEvent.loadUrl('{rootUrl}/contact.php?cid={id}&overview=agreement')", '', false);
    $this->_sections['contacts_view'][$this->checkMetaKey('ALT', 'K')] = array('Add Ticket', "KeyEvent.loadUrl('{rootUrl}/newTicket.php?contacts=1-{id}')", '', false);
    
    ////////////////////////
    // contacts_view_employee
    ////////////////////////
    $this->_sections['contacts_view_employee'] = array();
    $this->_sections['contacts_view_employee'][$this->checkMetaKey('ALT', 'E')] = array('Edit', "window.document.forms['edit_form'].submit()", '', false);
    $msg = Zen::fixJsVal(tr("Are you sure you want to delete this contact?"),"'");
    $this->_sections['contacts_view_employee'][$this->checkMetaKey('ALT', 'D')] = array('Delete', "confirmSubmit(window.document.forms['delete_form'],$msg)", '', false);
    $this->_sections['contacts_view_employee'][$this->checkMetaKey('ALT', 'I')] = array('View Tickets', "window.document.forms['view_form'].submit()", '', false);
    $this->_sections['contacts_view_employee'][$this->checkMetaKey('ALT', 'K')] = array('Add Ticket', "KeyEvent.loadUrl('{rootUrl}/newTicket.php?contacts=2-{id}')", '', false);
    
    ////////////////////////
    // contacts_list
    ////////////////////////
    $this->_sections['contacts_list'] = array();
    $tabs = array('all',"abc","def","ghi","jkl","mno","pqrs","tuv","wxyz","other");
    foreach($tabs as $t) {
      $c = $t == 'all'? 1 : 0;
      $k = false;
      $key = false;
      $len = strlen($t);
      while(!$key || array_key_exists($key,$this->_keys)) {
        if( $c == $len ) {
          $key = false;
          break;
        }
        $key = "SHIFT+".strtoupper(substr($t,$c,1));
        if( $key == 'SHIFT+!' ) { $key = false; }
        $c++;
      }
      if( $key && !array_key_exists($key,$this->_sections['contacts_list']) ) {
        $this->_sections['contacts_list'][$key] = array($t, "updateUrl('setmode','$t')", '', false);
      }
    }
    $this->_sections['contacts_list'][$this->checkMetaKey('ALT', 'O')] = array("Company",  "updateUrl('overview', 'company')", '', false);
    $this->_sections['contacts_list'][$this->checkMetaKey('ALT', 'E')] = array("External", "updateUrl('overview', 'external')", '', false);
    $this->_sections['contacts_list'][$this->checkMetaKey('ALT', 'I')] = array("Internal", "updateUrl('overview', 'internal')", '', false);
    
    /////////////////////////
    // field map form
    /////////////////////////
    $this->_sections['field_map_form'] = array();
    $this->_sections['field_map_form'][$this->checkMetaKey('ALT', 'D')] = array("Update", "submitForm('fieldMapForm')", 'Save changes to this view', false);
    
    ////////////////////////
    // log
    ////////////////////////
    $this->_sections['log'] = array();
    $this->_sections['log'][$this->checkMetaKey('ALT', 'L')] = array('Show All Logs', "window.document.getElementById('systemLogFilterCheckbox').click()", '', false);
    
    ////////////////////////
    // login
    ////////////////////////
    $this->_sections['login'] = array();
    $f = "window.document.forms['loginForm']";
    $this->newFxn("loginAutoCheck", "{$f}.elements['save_my_password'].checked = !window.document.forms['loginForm'].elements['save_my_password'].checked;");
    $this->_sections['login'][$this->checkMetaKey('ALT', 'L')] = array('Log On', "{$f}.submit()", '', false);
    $this->_sections['login'][$this->checkMetaKey('ALT', 'A')] = array('In the future, log me in automatically (using a cookie)', "loginAutoCheck()", '', false);
    $this->_sections['login'][$this->checkMetaKey('ALT', 'N')] = array('Login Name', "{$f}.elements['username'].select()", '', false);
    $this->_sections['login'][$this->checkMetaKey('ALT', 'W')] = array('Password', "{$f}.elements['passphrase'].select()", '', false);
    
    ////////////////////////
    // options
    ////////////////////////
    $this->_sections['options'] = array();
    $this->_sections['options'][$this->checkMetaKey('ALT', 'L')] = array('Log Off',
        "KeyEvent.loadUrl('{rootUrl}/index.php?logoff=1')", 
        "Log out of ".$this->_zen->getSetting('system_name'), false);
    $this->_sections['options'][$this->checkMetaKey('ALT', 'W')] = array('Change Password', "KeyEvent.loadUrl('{rootUrl}/misc/pwc.php')", '', false);
    $this->_sections['options'][$this->checkMetaKey('ALT', 'A')] = array('Set Auto-Login', "KeyEvent.loadUrl('{rootUrl}/misc/autologin.php')", '', false);
    $this->_sections['options'][$this->checkMetaKey('ALT', 'H')] = array('Change Home Bin', "KeyEvent.loadUrl('{rootUrl}/misc/homebin.php')", '', false);
    $this->_sections['options'][$this->checkMetaKey('ALT', 'G')] = array('Set Language', "KeyEvent.loadUrl('{rootUrl}/misc/language.php')", '', false);
    
    ////////////////////////
    // paging
    ////////////////////////
    $this->_sections['paging'] = array();
    $this->_sections['paging'][$this->checkMetaKey('ALT', 'E')] = array('Prev', "window.location = window.document.getElementById('pagingPrevLink').href", '', false);
    $this->_sections['paging'][$this->checkMetaKey('ALT', 'X')] = array('Next', "window.location = window.document.getElementById('pagingNextLink').href", '', false);
    
    ////////////////////////
    // project_tasks
    ////////////////////////
    $this->_sections['project_tasks'] = array();
    $this->_sections['project_tasks'][$this->checkMetaKey('ALT', 'A')] = array('Add Ticket to Project', "window.document.forms['newTicketHotkey'].submit()", '', false);
    $this->_sections['project_tasks'][$this->checkMetaKey('ALT', 'R')] = array('Create Sub-Project', "window.document.forms['newProjectHotkey'].submit()", '', false);
    
    ////////////////////////
    // search_form
    ////////////////////////
    $this->_sections['search_form'] = array();
    $f = "window.document.forms['searchForm']";
    $this->_sections['search_form'][$this->checkMetaKey('ALT', 'E')] = array('Search', "{$f}.submit()", '', false);
    $this->_sections['search_form'][$this->checkMetaKey('ALT', 'O')] = array('Containing', "{$f}.elements['search_text'].select()", '', false);
    $this->_sections['search_form'][$this->checkMetaKey('ALT', 'U')] = array('Summary', "{$f}.elements['search_fields[title]'].click()", '', false);
    $this->_sections['search_form'][$this->checkMetaKey('ALT', 'D')] = array('Description', "{$f}.elements['search_fields[description]'].click()", '', false);
    
    ////////////////////////
    // searchbox
    ////////////////////////
    $this->_sections['searchbox'] = array();
    $this->_sections['searchbox']['ESC'] = array('Close Window', "window.close()", 'Close window without changes', false);
    
    ////////////////////////
    // tab_attachments
    ////////////////////////
    $this->_sections['tab_attachments'] = array();
    $this->_sections['tab_attachments'][$this->checkMetaKey('ALT', 'D')] = array('Delete Attachments', "window.document.forms['deleteAttachmentForm'].submit()", '', false);
    $this->_sections['tab_attachments'][$this->checkMetaKey('ALT', 'A')] = array('Add Attachment', "window.document.forms['addAttachmentForm'].submit()", '', false);
    
    ////////////////////////
    // tab_contacts
    ////////////////////////
    $this->_sections['tab_contacts'] = array();
    $this->_sections['tab_contacts'][$this->checkMetaKey('ALT', 'N')] = array('Create New Contact', "window.document.forms['newContactForm'].submit()", '', false);
    $this->_sections['tab_contacts'][$this->checkMetaKey('ALT', 'A')] = array('Add Contact', "window.document.forms['ContactsAddForm'].submit()", '', false);
    $this->_sections['tab_contacts'][$this->checkMetaKey('ALT', 'D')] = array('Drop Contacts', "window.document.forms['dropContactsForm'].submit()", '', false);
    $this->_sections['tab_contacts'][$this->checkMetaKey('ALT', 'Y')] = array('Field: company_id', "window.document.forms['ContactsAddForm'].elements['company_id'].focus()", 'Company', false);
    $this->_sections['tab_contacts'][$this->checkMetaKey('ALT', 'E')] = array('Field: person_id', "window.document.forms['ContactsAddForm'].elements['person_id'].focus()", 'Person', false);
    
    ////////////////////////
    // tab_notify
    ////////////////////////
    $this->_sections['tab_notify'] = array();
    $this->_sections['tab_notify'][$this->checkMetaKey('ALT', 'D')] = array('Drop Recipients', "window.document.forms['dropNotifyForm'].submit()", '', false);
    $this->_sections['tab_notify'][$this->checkMetaKey('ALT', 'A')] = array('Add Recipients', "window.document.forms['notifyAddForm'].submit()", '', false);
    
    ////////////////////////
    // ticket_fields_editable
    ////////////////////////
    $this->_sections['ticket_fields_editable'] = array();
    $this->_sections['ticket_fields_editable'][$this->checkMetaKey('ALT', 'A')] = array('Save', "window.document.forms['ticketTabForm'].submit()", '', false);
    
    ////////////////////////
    // ticket_view
    ////////////////////////
    $this->_sections['ticket_view'] = array();
    $t = 'ticket';
    $j = 1;
    for($i=1; $i<=8; $i++) {
      $key = "SHIFT+$j";
      $view = "{$t}_tab_{$i}";
      if( $map->getViewProp($view, 'visible') ) {
        $this->_tabkeys[$view] = $key;
        $label = $map->getViewProp($view,'label');
        $this->_sections['ticket_view'][$key] = array($label, "KeyEvent.loadUrl('{rootUrl}/ticket.php?id={id}&setmode=$view')", '', false);
        $j++;
      }
    }
    
    ////////////////////////
    // project_view
    ////////////////////////
    $this->_sections['project_view'] = array();
    $t = 'project';
    $j = 1;
    for($i=1; $i<=8; $i++) {
      $key = "SHIFT+$j";
      $view = "{$t}_tab_{$i}";
      if( $map->getViewProp($view, 'visible') ) {
        $this->_tabkeys[$view] = $key;
        $label = $map->getViewProp($view,'label');
        $this->_sections['project_view'][$key] = array($label, "KeyEvent.loadUrl('{rootUrl}/ticket.php?id={id}&setmode=$view')", '', false);
        $j++;
      }
    }
    
    ////////////////////////
    // user search
    ////////////////////////
    $this->_sections['user_search'] = array();
    $this->_sections['user_search'][$this->checkMetaKey('ALT', 'L')] = array("List All Users", "KeyEvent.loadUrl('{rootUrl}/admin/listUsers.php?TODO=ALL');", 'Show all user accounts', false);
    $this->_sections['user_search'][$this->checkMetaKey('ALT', 'D')] = array("Find", "submitForm('searchUsersForm')", '', false);
    $this->_sections['user_search'][$this->checkMetaKey('ALT', 'I')] = array('User ID', "placeFocus(window.document.forms['searchUsersForm'].elements['search_params[user_id]'])", '', false);
    $this->_sections['user_search'][$this->checkMetaKey('ALT', 'M')] = array('Modify Search', "submitForm('searchModifyForm')", '', false);
    
    ////////////////////////
    // user form
    ////////////////////////
    $this->_sections['user_form'] = array();
    $this->_sections['user_form'][$this->checkMetaKey('ALT', 'L')] = array("Last Name", "fieldFocus('userForm','lname')", '', false);
    $this->_sections['user_form'][$this->checkMetaKey('ALT', 'I')] = array("Email", "fieldFocus('userForm','email')", '', false);
    $this->_sections['user_form'][$this->checkMetaKey('ALT', 'M')] = array("Make User", "submitForm('userForm')", '', false);

    /////////////////////////
    // useful for activating list of items (see ZenHotKeys::activateList())
    /////////////////////////
    $this->_sections['activated_list'] = array();
    for($i=0; $i <= 10; $i++) {
      $j = $i==10? 0 : $i;
      $this->_sections['activated_list']["$j"] = array("Select item from list", "", "", false);
    }
    
  }
  var $_sections;
  
  function listSections() {
    return array_keys($this->_sections);
  }
  
  function listEntries( $sect ) {
    return $this->_sections[$sect];
  }
  
  /** Prepares hot keys for a given section of the app */
  function loadSection( $sect ) {
    $sect = strtolower($sect);
    if( $sect != 'activated_list' && in_array($sect, $this->_alreadyLoaded) ) {
      $this->_zen->addDebug('loadSection', "$sect already loaded", 3);
      return;
    }
    $this->_alreadyLoaded[] = $section;
    
    //todo load registered hot keys from database and assign here
    $this->_zen->addDebug('loadSection', "Loading section: $sect", 3);
    
    if( !array_key_exists($sect, $this->_sections) ) {
      $this->_zen->addDebug('loadSection', "$sect is not valid", 1);
      return;
    }
    
    foreach($this->_sections[$sect] as $k=>$v) {
      $this->assign($k, $v[0], $v[1], $v[2], $v[3]);
    }
  }
  
  var $_tabkeys;
  
  function getTabKeys() {
    return $this->_tabkeys;
  }
  
  function newFxn( $name, $code ) {
    if( array_key_exists($name, $this->_fxns) ) {
      $this->_zen->addDebug('ZenHotKeys->newFxn', "The fxn '$name' already exists", 2);
      return;
    }
    $this->_zen->addDebug('ZenHotKeys->assign', "Added fxn '$name'", 4);
    $this->_fxns["$name"] = $code;
  }
  
  function getFxnName($key) {
    return $this->_keys[$key]['fxn'];
  }

  /** 
   * Adds a hot key to the list.  The fxn param accepts the following special
   * placeholders:
   * <ul>
   *  <li>{rootUrl} - replaced with the value of $rootUrl in www/header.php
   *  <li>{id} - replaced with the current ticket/project/contact/agreement id (if any)
   * </ul>
   *
   * The special text "KeyEvent.loadUrl('{root_url}/my_url_here')" can be used to access
   * the global url forwarding mechanism and should be preferred to trying window.forward
   *
   * @param String $key a hot key such as 'CTRL+SHIFT+Y'
   * @param String $label name of the hot key
   * @param String $fxn name of function to call when hot key is pressed
   * @param String $description tooltip text (defaults to label)
   */
  function assign( $key, $label, $fxn, $description = '', $global = false ) {
    global $id; global $rootUrl;

    // if the hot key doesn't exist, we fail and don't add anything
    $key = strtoupper($key);
    if( array_key_exists($key, $this->_keys) ) {
      $this->_zen->addDebug('ZenHotKeys->assign', "The key '$key' already exists and will not have a hot key", 2);
      return;
    }

    // add the label if it is not a duplicate... items which duplicate the label
    // cannot appear together
    if( array_key_exists($label, $this->_idx) ) {
      $this->_zen->addDebug('ZenHotKeys->assign', "The label '$label' already exists for key '".$this->_idx["$label"]."', this hotkey cannot be looked up by label accurately", 2);
    }
    else {
      $this->_idx["$label"] = $key;
    }
    
    // if there is no description, we use the label for this field
    if( !$description ) { $description = $label; }
    
    // replace special variables in the function call with current values
    $fxn = str_replace("{rootUrl}", $rootUrl, $fxn);
    $fxn = str_replace("{id}", $id, $fxn);
    
    // actually create the key assignment now
    $this->_zen->addDebug('ZenHotKeys->assign', "Added key '$key' for label '$label' and fxn '$fxn'", 4);
    $this->_keys["$key"] = array('label'=>$label, 'fxn'=>$fxn, 'description'=>$description, 'global'=>$global);
  }
  
  function disableAction( $key ) {
    $this->_keys["$key"]["fxn"] = 'doNothing';
  }
  
  /**
   * Return the hot key for a given label (the section must be loaded unless
   * this label appears in 'all')
   *
   * @param String $label
   * @return String the key for this label
   */
  function find( $label ) {
    if( !array_key_exists("$label", $this->_idx) ) { return false; }
    return $this->_idx["$label"];
  }
  
  
  /** Returns a tooltip for a given label */
  function tt( $label ) {
    $key = $this->find($label);
    if( !$key ) {
      $this->_zen->addDebug('ZenHotKeys->tt', "Invalid label '$label'", 2);
      return $label;
    }
    return $this->tooltip($key, $override_text = '');
  }
  
  /** Returns a parsed/translated label for a given label */
  function ll( $label, $override_text = '', $supress_key = false ) {
    $key = $this->find($label);
    if( !$key ) {
      $this->_zen->addDebug('ZenHotKeys->ll', "Invalid label '$label'", 2);
      return $override_text? $override_text : $label;
    }
    return $this->label($key, $override_text, $supress_key);
  }
  
  /** 
   * Return a tooltip message for a given key, this will be translated and
   * the hot key will be appended
   */
  function tooltip( $key ) {
    $key = strtoupper($key);
    return Zen::ffv(tr($this->_keys["$key"]["description"])." ($key)");
  }
  
  /**
   * Return description for a given key, translated and escaped
   *
   * If the description is the same as the label, it will be skipped.
   */
  function description( $key ) {
    $key = strtoupper($key);
    $x = $this->_keys["$key"];
    if( $x["description"] == $x["label"] ) { return "&nbsp;"; }
    return Zen::ffv(tr($x["description"]));
  }
  
  /** 
   * Return a label for a given key, this will be translated
   * and the hot key will be underlined if possible
   */
  function label( $key, $override_text = '' ) {
    $key = strtoupper($key);
    $char = $this->_getChar($key);
    $lchar = strtolower($char);
    $label = $override_text? tr($override_text) : tr($this->_keys["$key"]["label"]);
    $label = preg_replace('@^(Action|Field): @', '', $label);
    $label = str_replace('_', ' ', $label);
    $label = Zen::ffv($label);
    $pos = strpos($label, $char);
    if( $pos === false ) { $pos = strpos($label, $lchar); $char = $lchar; }
    $len = strlen($label);
    if( $pos === 0 ) {
      // matched at beginning of string
      $txt = "<u>{$char}</u>".substr($label,1);
    }
    else if( $pos > 0 && $pos == $len-1 ) {
      // matched at end of string
      $txt = substr($label,0,$len-1)."<u>{$char}</u>";
    }
    else if( $pos > 0 ) {
      // matched inside the string
      $txt = substr($label,0,$pos)."<u>{$char}</u>".substr($label,$pos+1);
    }
    else {
      // no match, just return the label
      //return $label."<sub class='note'>$char</sub>";
      $txt = $label;
    }
    //if( !$supress_key ) { $txt .= $this->renderAccessKey($key); }
    $txt .= $this->addZenTab($key);
    return $txt;
  }
  
  /**
   * Renders any custom functions defined here.
   */
  function renderFunctions() {
    if( !count($this->_fxns) ) { return; }
    foreach( $this->_fxns as $k=>$v ) {
      print "function $k() {\n";
      print $v;
      print "}\n\n";
    }
     
  }
  
  /** 
   * Create javascript code needed for
   * hot keys to function.  Depends on the keyevents.js file
   *
   * This is meant to be used inside of the onload fxn for the page.   */
  function renderKeys() {
    if( !count($this->_keys) ) { return; }
    foreach( $this->_keys as $k=>$v ) {
      if( $this->_getAccessKey($k) || array_key_exists($k,$this->_keysRendered) || !$v['fxn'] ) { continue; }
      $this->_keysRendered[$k] = 1;
      print "\tKeyEvent.register(".Zen::fixJsVal($v['fxn']).", '$k');\n";
    }
    foreach( $this->_tabs as $t=>$k ) {
      print "\tZenTabs.singleton.register('keySub_$t');\n";
    }
  }
  
  /**
   * create javascript code needed for
   * accesskey functions
   */
  function renderAccessKeys() {
    $keys = array();
    foreach($this->_keys as $k=>$v) {
      if( !$v['fxn'] ) { continue; }
      print $this->renderAccessKey($k);
    }
  }
  
  /**
   * Render a single access key, done this way so that they will focus near
   * the appropriate field, when possible
   */
  function renderAccessKey( $k ) {
    $v = $this->_keys[$k];
    if( array_key_exists($k,$this->_keysRendered) ) { return; }
    if( $key = $this->_getAccessKey($k) ) {
      $this->_keysRendered[$k] = 1;
      $fxn_parsed = Zen::fixJsHtml($v['fxn']);
      return "<input type='button' name='accessKeyButton{$key}' value='' accesskey='{$key}' class='accesskeys' onclick=$fxn_parsed>";
    }
    return null;
  }
  
  /** Returns letter used to access this key if it is an accesskey */
  function _getAccessKey( $key ) {
    $meta = str_replace("+", "[+]", $this->accessKey)."[+]";
    preg_match("@^{$meta}(\w)$@", $key, $matches);
    return count($matches)>1? $matches[1] : false;
  }
  
  /** Splits a key and returns the letter to be used */
  function _getChar( $key ) {
    return preg_replace('@^.*[+]@', '', $key);
  }
  
  function getChar( $key ) {
    return $this->_getChar($key);
  }
  
  /** Creates html output to display help info */
  function renderHelp() {
    print "<table width='300' border='0' cellspacing='1' cellpadding='2'><tr><td class='titleCell'>Hot Key</td><td class='titleCell'>Function</td></tr>";
    $keys = $this->_keys;
    uasort($keys, 'sortHotKeyTable');
    foreach( $keys as $k=>$v ) {
      print "<tr><td class='hotKeyCell'>$k</td><td class='hotKeyCell'>"
      .$this->label($k)."</td></tr>";
    }
    print "</table>\n";
  }
  
  /** Store a key that will be used to display subtext on tabs */
  function addZenTab( $key ) {
    $count = 1;
    $id = $key.$count++;
    while( array_key_exists($id, $this->_tabs) ) {
      $id = $key.$count++;
    }
    $this->_tabs[$id] = $key;
    return "<div id='keySub_$id' class='keySub".$this->_lh()."'>$key</div>";
  }
  
  function addZenTabByLabel($label) {
    $this->addZenTab($this->find($label));
  }
  
  function _lh() {
    return $this->_alternate? $this->_lh == 'High'? 'Low' : 'High' : "High";
  }
  
  /**
   * Activate a form field by examining the label for the field and assigning
   * it a hot key from the most appropriate letter available.
   *
   * @param string $label the text displayed to user (i.e. label) of the field to activate (translated)
   * @param string $form the form containing the field
   * @param string $field the actual field name inside the html form
   * @param string $meta_key the meta key to use in conjunction with field (defaults to ALT)
   * @return ZenHotKeyElement or (boolean)false if no key could be activated
   */
  function activateField( $label, $form, $field, $meta_key = 'ALT' ) {
    $fxn = "fieldFocus('$form', '$field')";
    return $this->activate($label, $meta_key, $fxn);
  }
  
  /**
   * Activate a searchbox field by examining the label for the field and assigning
   * it a hot key from the most appropriate letter available.
   *
   * @param string $label the text displayed to user (i.e. label) of the field to activate (translated)
   * @param string $form the form containing the field
   * @param string $field the actual field name inside the html form
   * @param string $meta_key the meta key to use in conjunction with field (defaults to ALT)
   * @return ZenHotKeyElement or (boolean)false if no key could be activated
   */
  function activateSearchbox( $label, $form, $field, $meta_key = 'ALT' ) {
    $fxn = "buttonClick('$form', '{$field}_button')";
    return $this->activate($label, $meta_key, $fxn);
  }

  /**
   * Activate a list of fields using the values given in the array.
   *
   * @param array $fields an associative array of (string)field_names -> (string)label
   * @param string $form name of the form object fields will be placed in
   * @param string $meta_key the key to use with letter, such as ALT, SHIFT, OR CTRL
   * @return array of (string)field_name -> (ZenHotKeyElement)hot key info
   */
  function activateFieldList( $fields, $form, $meta_key = 'ALT' ) {
    $vals = array();
    foreach($fields as $f=>$l) {
      $vals[$f] = $this->activateField($l, $form, $f, $meta_key);
    }
    return $vals;
  }
  
  /**
   * Activate a button by examining the label of the button and
   * assigning it a hot key from the most appropriate letter available
   *
   * @param string $label the text displayed to user (i.e. label) of the field to activate (translated)
   * @param string $form the form containing the field
   * @param string $button the actual field name inside the html form
   * @param string $meta_key the meta key to use in conjunction with field (defaults to ALT)
   * @return ZenHotKeyElement or (boolean)false if no key could be activated
   */
  function activateButton( $label, $form, $button = false, $meta_key = 'ALT' ) {
    if( $button ) {
      $fxn = "buttonClick('$form', '$button')";
    }
    else {
      $fxn = "submitForm('$form');";
    }
    return $this->activate($label, $meta_key, $fxn);
  }
  
  /**
   * Make sure the key assignment won't conflict with any reserved hotkeys. Firefox
   * prevents them from working, so we have to really check carefully...
   */
  function checkMetaKey( $meta, $key ) {
    // if there isn't a meta key, or the meta key contains SHIFT, it's not reserved
	if( !$meta || strpos($meta, "SHIFT") !== FALSE ) { return "$meta+$key"; }
  
    $comb = "{$meta}+{$key}";
	if( in_array($comb, $this->commonReservedKeys) || 
	    ($this->isFirefox && in_array($comb, $this->firefoxReservedKeys)) ||
		(!$this->isFirefox && in_array($comb, $this->microsoftReservedKeys)) ) {
	  $meta = "{$meta}+SHIFT";
	}
    return "$meta+$key";
  }
  
  /**
   * Activates hot keys for up to 10 items (0-9) for use with lists of
   * tickets/users/etc
   *
   * The $event entry can take substitutions from the list by using the {data_column}
   * syntax.  For example:
   * <pre><code>
   *   $keyEvent = "KeyEvent.loadUrl('$rootUrl/ticket.php?id={id}')";
   *   $row1 = array( "id" => 1, "title" => "my favorite ticket" );
   *   $row2 = array( "id" => 2, "title" => "my second favorite" );
   *   $list = $hotkeys->activateList( array($row1, $row2), $key_event, "title", "title" );
   *
   * //// or ///////
   *   $keyEvent = "alert(\"You clicked on '{title}'\")";
   *   $row1 = array( "id" => 1, "title" => "my favorite ticket" );
   *   $row2 = array( "id" => 2, "title" => "my second favorite" );
   *   $list = $hotkeys->activateList( array($row1, $row2), $key_event, "title", "title" );
   * </code></pre>
   *
   * @param array $list the data rows to be activated
   * @param string $label_column the column from data rows to use for the label text
   * @param string $desc_column the column from data rows to use for description text
   * @param string $event the event to launch when hot key is pressed (see above for details)
   * @param boolean $do_not_parse if true, no columns will be substituted into the url
   * @param string $type right now just 'ticket' (may add 'users', 'attachments', etc later)
   */
  function activateList( $list, $label_column, $desc_column, $url ) {
    if( !$list || !count($list) ) {
      $this->_zen->addDebug('ZenHotKeys::activateList', "Nothing to do (list was empty)",3);
      return; 
    }
    for($i=0; $i < count($list); $i++) {
      $name = $list[$i][$label_column];
      $desc = $list[$i][$desc_column];
      if( $i >= count($this->_sections['activated_list']) ) {
        // no more hot keys to assign
        $list[$i]['hotkey_key'] = null;
        $list[$i]['hotkey_sup'] = null;
        $list[$i]['hotkey_label'] = Zen::ffv($name);
        $list[$i]['hotkey_tooltip'] = Zen::ffv($desc);
        continue; 
      }
      $j = $i==9? 0 : $i+1;
      $key = "$j";
      $this->_sections['activated_list'][$key][1] = $this->_parseUrl( $list[$i], $url );
      $list[$i]['hotkey_key'] = Zen::ffv($key);
      $list[$i]['hotkey_sup'] = $this->addZenTab($key)."<span class='listHotkey'>[$j]</span> ";
      $list[$i]['hotkey_label'] = $list[$i]['hotkey_sup'].Zen::ffv($name);
      $list[$i]['hotkey_tooltip'] = Zen::ffv($name)." ($key)";
    }
    $this->loadSection('activated_list');
    return $list;
  }
  
  function activate($label, $meta, $fxn) {
    $meta = strtoupper($meta);
    for($i=0; $i < strlen($label); $i++) {
      $letter = strtoupper($label{$i} );
      if( !preg_match('@[0-9A-Z]@', $letter) ) { continue; }
      $key = $this->checkMetaKey($meta, $letter);
      if( array_key_exists($key, $this->_keys) ) { continue; }
      $this->assign($key, $label, $fxn);
      $hk = new ZenHotKeyElement($key, $this->label($key), $this->tooltip($key), $this->description($key));
      return $hk;
    }
    return new ZenHotKeyElement(false, Zen::ffv($label), Zen::ffv($label), Zen::ffv($label));
  }
  
  /**
   * Take an associative list of values and try to substitute them in for
   * any {column_name} entries in $text
   *
   * @param array $vals associative array of possible substitutions
   * @param string $text the text to perform substitutions in
   */
  function _parseUrl( $vals, $text ) {
    if( array_key_exists($text, $this->_urlMatches) ) { $matches = $this->_urlMatches[$text]; }
    else { preg_match_all("@[{]([^}]+)[}]@", $text, $matches, PREG_SET_ORDER); }
    for($i=0; $i<count($matches); $i++) {
      $key = $matches[$i][1];
      if( array_key_exists($key, $vals) ) {
        $text = preg_replace("@[{]{$key}[}]@", $vals[$key], $text);
      }
    }
    return $text;
  }
  
  var $_urlMatches;
  
  var $_alternate;
  var $_lh;
  var $_fxns;
  var $_zen;
  var $_keys;
  var $_idx;
  var $_alreadyLoaded;
  var $_tabs;
  var $_keysRendered;
  var $isFirefox;
  var $accessKey;
  
  var $commonReservedKeys = array('CTRL+L', 'CTRL+O', 'CTRL+P', 'ALT+D');
  var $firefoxReservedKeys = array('CTRL+K', 'ALT+F', 'ALT+E', 'ALT+V', 'ALT+S', 'ALT+B', 'ALT+T', 'ALT+H');
  var $microsoftReservedKeys = array('ALT+N', 'ALT+A');
  
}

/** Must be declared outside of class to work with php */
function sortHotKeyTable( $a, $b ) {
  $a['label'] = preg_replace('@^(Action|Field): @', '', $a['label']);
  $b['label'] = preg_replace('@^(Action|Field): @', '', $b['label']);
  return strnatcmp($a['label'], $b['label']);
}

class ZenHotKeyElement {
  function ZenHotKeyElement($key, $label, $tooltip, $description) {
    $this->_key = $key;
    $this->_label = $label;
    $this->_tt = $tooltip;
    $this->_desc = $description;
  }
  
  function getKey() { return $this->_key; }
  
  function getLabel() { return $this->_label; }
  
  function getTooltip() { return $this->_tt; }
  
  function getDescription() { return $this->_desc; }
  
  var $_key;
  var $_label;
  var $_tt;
  var $_desc;
}

?>
