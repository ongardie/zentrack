<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 
if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
 * Contains the ZenSearchBoxContact class
 */
 
/**
 * The ZenSearch class specific to data type entries
 */
class ZenSearchBoxContact extends ZenSearchBox {
  function ZenSearchBoxContact() { }
  
  function init() {
    global $zen;
    $this->_zen=$zen;
    $this->_company=array();
    $query='SELECT company_id, title FROM ZENTRACK_COMPANY ORDER BY lower(title)';
    $vars = $this->_zen->db_queryIndexed($query);
    if( is_array($vars) ) {
      foreach($vars as $v) {
        $this->_company[$v['company_id']]=array('title'     => $v['title'],
                                                'office'    => $v['office'],
                                                'website'   => $v['website'],
                                                'telephone' => $v['telephone']);
      }
    }
    $this->_possible = 1000;
  }
  
  /**
   * Generate a suitable title based on the type of search being conducted
   *
   * @return string
   */
   function getPageTitle() { return tr("Find Contacts"); }
  
  /** 
   * Generate text for form fields to diplay on form
   *
   * @param string $form name of the form
   * @param array $vals key/value pairs representing current values (if the form is being reloaded)
   * @param boolean $hidden if true, then all fields should be rendered hidden (for reposting data)
   * @return string
   */
  function renderFormFields( $form, $vals, $hidden = false ) {
    $searchbox_vals = array();
    $search_text=$_POST['search_text'];
    $cid=array_key_exists('cid',$_POST) ? $_POST['cid'] : '';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid='$cid'", 3);
    $txt .= "<table><tr><td colspan='3' class='subTitle' width='600'>";
    $txt .= tr("Search Employee");
    $txt .= "</td><tr><td class='bars'>".tr("Company").":</td><td class='bars'>";
    $txt .= "<select name='cid' size='1'>";
    $sel=strlen($cid)?'':'selected';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['-any-'] selected='$sel'", 3);
    $txt .= "<option value='' $sel>".tr('-any-')."</option>";
    $sel=(strcmp($cid,"0")==0)?'selected':'';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['-none-'] selected='$sel'", 3);
    $txt .= "<option value='0' $sel>".tr('-none-')."</option>";
    $jsvar = "var company = new Array();";
    if( is_array($this->_company) ) {
      foreach($this->_company as $id=>$c) {
        $cname=$c['title'];
        $cinfo=$c['title'].','.$c['office'].','.$c['website'].','.$c['telephone'];
        $sel=(strcmp($cid,$id)==0)?'selected':'';
        Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['$cname'] selected='$sel'", 3);
        $txt .= "<option value='$id' $sel>$cname</option>";
        $jsvar .= "company[$id]='$cinfo';";
      }
    }
    $txt .= "</select></td>";
    $txt .= '<td class="bars" colspan="2"><input type="button" onclick="pickCompany()" value="Contact is company">';
    $txt .= "</td>";
    $txt .= "</tr><tr><td>Filter:</td>";
    $txt .= '<td class="bars" colspan="2">
                <input type="text" name="search_text" title="'.tr("Filter text").'"
                 value="'.$this->_zen->ffv($search_text).'" size="25" maxlength="50">
             </td>
             </tr>
             </table>';
    $txt .= "<script type='text/javascript'>
               function pickCompany() {
                 $jsvar
                 var f = window.document.searchboxForm;
                 var id = f.cid.options[f.cid.selectedIndex].value;
                 if (id>0) {
                   var key = '1-' + id;
                   var value = company[id];
                   if( pickedVals[key] ) { 
                     pickedVals[key] = false;
                     newStyle = 'bars';
                     window.opener.delSearchboxVal(form, field, key);
                   } else {
                     pickedVals[key] = value;
                     newStyle = 'invalidBars';
                     window.opener.addSearchboxVal(form, field, key, value, multi, required);
                   }
                 }
               }
             </script>";
    return $txt;
  }

  
  /**
   * Given a list of parameters, this method performs the search operation and
   * returns a ZenSearchBoxResults object.  The parameters are taken from the
   * _POST data resulting from the renderFormFields() method
   *
   * @return ZenSearchBoxResults
   */
  function getSearchResults() {
    $search_text=$_POST['search_text'];
    $cid=$_POST['cid'];
    $search_fields = array(
                        "fname"           => "fname",
                        "lname"           => "lname",
                        "initials"        => "initials",
                        "jobtitle"        => "jobtitle",
                        "department"      => "department",
                        "email"           => "email",
                        "telephone"       => "telephone",
                        "mobiel"          => "mobiel",
                        "description"     => "description",
                  );
    $tables = "ZENTRACK_EMPLOYEE";
    //$orderby="person_id DESC";
    $orderby="lname, fname";
    unset($sp);
    if( $search_text ) {
      foreach($search_fields as $k=>$f) {
        $sp[] = array($f,"contains",$search_text);
      }
      $params[] = array("OR",$sp);
    } else {
      $params[] = array('1',"=",1);
    }
    if (strlen($cid)) {
      $params[] = array("company_id", "=", $cid);
    }
    unset($contacts);
    if (!$errs) {
      $contact_list = $this->_zen->search_contacts($params, "AND",$orderby,$tables);//"status DESC, priority DESC"
    }
    $contacts=array();
    if (is_array($contact_list)) {
      foreach ($contact_list as $c) {
        if (strlen($c['lname']) && strlen($c['fname'])) {
          $fullname=$c['lname'].', '.$c['fname'];
        } else {
          $fullname=$c['lname'].$c['fname'];
        }
        $contacts[]=array(
                         'pid'=>'2-'.$c['person_id'],
                         'fullname'=>$fullname,
                         'company'=>$this->_company[$c['company_id']['title']],
                         'telephone'=>$c['telephone']
                         );
      }
    }

    $total=count($contacts);

    $sbr = new ZenSearchBoxResults( array('pid'=>tr("ID"), 'fullname'=>tr("Full Name"), 'company'=>tr('Company'), 'telephone'=>tr('Telephone') ), $contacts, 
                                    'pid', array('fullname','company','telephone'), $total );
    Zen::addDebug("ZenSearchBoxContact::_getSearchResults [".$sbr->rows()."]",$params, 3, false);
    $this->_possible=$sbr->rows();
    return $sbr;
  }
  
  /**
   * Get the focal point for the form
   */
  function getFocalPoint() { return 'search_text'; }
  
  function showSearchForm() {
    return $this->_possible > $this->_queryLimit;
  }
  
  function totalRecords() { return $this->_possible; }

  var $_fields;
  var $_possible;
  var $_company;
}

?>
