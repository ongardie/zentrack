  <form name="ticket_customForm" action="<?=$rootUrl?>/actions/editCustomSubmit.php">

  <table width="600" align="center" cellpadding="2" cellspacing="2">
<?
  $cfd=$zen->getCustomFields(0,$page_type,"C");
  foreach($cfd as $f) {
    $k=$f['field_name'];
    $v=$f['field_label'];
    $r=$f['is_required'];
    $varfield_type=ereg_replace("[^a-z_]", "", $k);
    switch($varfield_type) {
      case "custom_number":
        $cfs="10";
        $cfv=($varfields["$k"])?$varfields["$k"] : 0;
        if (!$r) {
          $cfe=" &nbsp;(".tr("optional").")";
        } else {
          $cfe="";
        }
        break;
      case "custom_date":
        $cfs="20";
        $cfv=($varfields["$k"])?$zen->showDateTime($varfields["$k"]) : "n/a";
        $cfe="\n"
          ."        <img name='date_button' src='".$rootUrl."/images/cal.gif'\n"
          ."         onClick=\"popUpCalendar(this, document.ticket_customForm.$k, '".$zen->popupDateFormat()." 00:00')\"\n"
          ."         alt='".tr("Select a Date")."'>\n";
        if (!$r) {
          $cfe.=" &nbsp;(".tr("optional").")";
        }
        break;
      default:
        $cfs="50";
        $cfv=$varfields["$k"];
        if (!$r) {
          $cfe=" &nbsp;(".tr("optional").")";
        } else {
          $cfe="";
        }
        break;
    }
?>
    <tr>
      <td class="bars">
        <?=$v?>
      </td>
      <td class="bars">
        <input type="text" name="<?=$k?>" size="<?=$cfs?>" 
               value="<?=(get_magic_quotes_runtime())?nl2br(stripslashes($cfv)):nl2br($cfv); ?>"><?=$cfe?>
      </td>
    </tr>
<?
  }
?>
    <tr>
         <input type="hidden" name="id" value="<?=strip_tags($id)?>">
         <td align="right">
           <?
//             if( $zen->actionApplicable($id,"edit_custom",$login_id) ) {
                $button = "submit";
                $color = $zen->settings["color_highlight"];
//             } else {
//                $button = "button";
//                $color = $zen->settings["color_alt_background"];
//             }
           ?>
           <input type="<?=$button?>" value=" <?=uptr("Save")?> " class="actionButton" style="width:125;color:<?=$color?>">
         </td>
     </tr>
   </table>
   </form>
