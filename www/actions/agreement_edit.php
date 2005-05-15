<?
  /*
  **  Action: edit agreement
  */
  include_once("../header.php");
  $page_title = tr("Agreement #?", array($id));
  $expand_agreement = 1;


  include("$libDir/nav.php");

  //add item button action
  if ($TODO == "addItems") {

    $agree_id = "0";
    $create_time = time();

    $fields = array(
        "agree_id"    => "int",
        "description1" => "text",
        "name1"       => "text",
        "create_time" => "int",
        );

    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
         $params["$f"] = $$f;
      }
    }

    $params["creator_id"] = $login_id;
    if (!$id){
      $idi = $zen->add_contact($params,"ZENTRACK_AGREEMENT_ITEM");
    } else {
      $params["agree_id"] = $id;
      $idi = $zen->add_contact($params,"ZENTRACK_AGREEMENT_ITEM");
    }
    if( !$idi ) {
      $errs[] = tr("Could not create item.") . " " .$zen->db_error;
    }
    $create_time = null;
    $idi = null;
    $description1 = null;
    $name1 = null;
	}
	//drop button action
	else if ($TODO == "removeItems" ) {
    if( is_array($drops) ) {
      // drop items in list
      for($i=0; $i<count($drops); $i++) {
      // clean up numbers just in case
      $n = $zen->checkNum($drops[$i]);

      $res = $zen->delete_contact( $n,"ZENTRACK_AGREEMENT_ITEM","item_id");
      }
    }
	}

  include("$templateDir/editAgreementForm.php");

  include("$libDir/footer.php");
?>
