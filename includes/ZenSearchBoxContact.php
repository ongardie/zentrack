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
        $this->_company[$v['company_id']]=$v['title'];
      }
    }
    $this->_possible = 1000;
    Zen::addDebug("ZenSearchBoxContact::init _company",$this->_company, 3, false);
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
    $search_text=$_REQUEST['search_text'];
    $cid=array_key_exists('cid',$_REQUEST) ? $_REQUEST['cid'] : '';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid='$cid'", 3);
    $txt .= "<table><tr><td colspan='2' class='subTitle' width='600'>";
    $txt .= tr("Search Employee");
    $txt .= "</td><tr><td class='bars'>".tr("Company").":</td><td class='bars'>";
    $txt .= "<select name='cid' size='1'>";
    $sel=strlen($cid)?'':'selected';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['-any-'] selected='$sel'", 3);
    $txt .= "<option value='' $sel>".tr('-any-')."</option>";
    $sel=(strcmp($cid,"0")==0)?'selected':'';
    Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['-none-'] selected='$sel'", 3);
    $txt .= "<option value='0' $sel>".tr('-none-')."</option>";
    if( is_array($this->_company) ) {
      foreach($this->_company as $id=>$cname) {
        $sel=(strcmp($cid,$id)==0)?'selected':'';
        Zen::addDebug("ZenSearchBoxContact::renderFormFields","cid['$cname'] selected='$sel'", 3);
        $txt .= "<option value='$id' $sel>$cname</option>";
      }
    }
    $txt .= "</select></td></tr>";
    $txt .= "<tr><td>Filter:</td>";
    $txt .= '<td class="bars">
                <input type="text" name="search_text" title="'.tr("Filter text").'"
                 value="'.$this->_zen->ffv($search_text).'" size="25" maxlength="50">
             </td>
             </tr>
             </table>';
    return $txt;
  }

  function obsoleto() {
    $txt .= '</form>';
    if( is_array($tickets) && count($tickets) ) {
      $link = $zen->getSetting("url_view_ticket");
      $c = count($tickets);
//Begin table heading render
      $txt .= '<table width="100%" cellspacing="1" cellpadding="2" bgcolor="'.$this->_zen->getSetting("color_alt_background").'">
               <tr>
               <td class="titleCell" colspan="9" align="center">'.(($c>1)? tr("? Matches",array($c)) : tr("1 Match")).'</td></tr>
               <tr bgcolor="'.$this->_zen->getSetting("color_title_background").'" >

               <td width="32" height="25" valign="middle" title="'.tr("ID of the contact").'">
               <div align="center"><span style="color:'.$this->_zen->getSetting("color_title_txt").'"><b><span class="small">'.tr("ID");
      if (!empty($image)) {
        $txt .= '&nbsp;<IMG SRC="'.$imageUrl.$image.'" border="0">';
      }
      $txt .= '</span></b></span></div>
               </td>

               <td height="25" valign="middle" title="'.tr("The name of the contact").'">
               <div align="center"><span style="color:'.$this->_zen->getSetting("color_title_txt").'"><b><span class="small"><'.tr("Name");
      if (!empty($image)) {
        $txt .= '&nbsp;<IMG SRC="'.$imageUrl.$image.'" border="0">';
      }
      $txt .= '</span></b></span></div>
               </td>

               <td height="25" valign="middle" title="'.tr("The company where the contact works").'">
               <div align="center"><span style="color:'.$this->_zen->getSetting("color_title_txt").'"><b><span class="small">'.tr("Company");
      if (!empty($image)) {
        $txt .= '&nbsp;<IMG SRC="'.$imageUrl.$image.'" border="0">';
      }
      $txt .= '</span></b></span></div>
               </td>

               <td height="25" valign="middle" title="'.tr("The E-mail address of the contact").'">
               <div align="center"><span style="color:'.$this->_zen->getSetting("color_title_txt").'"><b><span class="small">'.tr("E-mail");
      if (!empty($image)) {
        $txt .= '&nbsp;<IMG SRC="'.$imageUrl.$image.'" border="0">';
      }
      $txt .= '</span></b></span></div>
               </td>

               <td height="25" valign="middle" title="'.tr("The telephone number of the contact").'">
               <div align="center"><span style="color:'.$this->_zen->getSetting("color_title_txt").'"><b><span class="small">'.tr("Telephone");
      if (!empty($image)) {
        $txt .= '&nbsp;<IMG SRC="'.$imageUrl.$image.'" border="0">';
      }
      $txt .= '</span></b></span></div>
               </td>

               </tr>';

//End table header render
//Begin table detail render
      $link  = "$rootUrl/contact.php";
      $td_ttl = "title='".tr("Click here to view the Contact")."'";
      foreach($tickets as $t) {
        $txt .= '<tr  class="priority1" onclick="ticketClk("'.$link.'?pid='.$t["person_id"].'")"
                 onMouseOver="if(window.document.body && mClassX){mClassX(this, "priority1Over", true);}"
                 onMouseOut="if(window.document.body && mClassX){mClassX(this, "priority1", false);}">
                 <td height="25" width="5%" valign="middle" '.$td_ttl.'>    '.$t["person_id"].'
                 </td>
                 <td height="25" width="25%" valign="middle" '.$td_ttl.'>'.ucfirst($t["lname"]).'
                 &nbsp;'.($t["fname"])?",".ucfirst($t["fname"]):",".ucfirst($t["initials"]).'
                 </td>   <td height="25" width="25%" valign="middle" '.$td_ttl.'>';
        if ( isset($t["company_id"])) {
          $contact = $this->_zen->get_contact($t["company_id"],"ZENTRACK_COMPANY","company_id");
          if( is_array($contact) ) {
            $txt .= strtoupper($contact["title"]);
            if ($contact["title"]){
              $txt .= " " .strtolower($contact["office"]);
            }
          }
        }
 
        $txt .= '</td>
                 <td height="25" width="25%" valign="middle" '.$td_ttl.'>'.$t["email"].'
                 </td>   <td width="20%" valign="middle" '.$td_ttl.'>'.strtolower($t["telephone"]).'
                 </td>
                 </tr>';
    
        unset($contact);
      }
    }


//End table detail render

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
    $search_text=$_REQUEST['search_text'];
    $cid=$_REQUEST['cid'];
    $search_fields = array(
                        "fname"       => "fname",
                        "lname"    => "lname",
                        "initials" => "initials",
                        "jobtitle"       => "jobtitle",
                        "department"      => "department",
                        "email"      => "email",
                        "telephone"    => "telephone",
                        "mobiel"      => "mobiel",
                        "description"   => "description",
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
                         'company'=>$this->_company[$c['company_id']],
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
