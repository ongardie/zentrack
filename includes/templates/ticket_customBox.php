  <form action="<?=$rootUrl?>/actions/editCustomSubmit.php">

  <table width="600" align="center" cellpadding="2" cellspacing="2">
<?
  $cfd=$zen->getCustomFields(1,$page_type,"C");
  foreach($cfd as $k => $v) {
    $varfield_type=ereg_replace("[^a-z_]", "", $k);
    switch($varfield_type) {
      case "custom_number":
        $cfv=($varfields["$k"])?$varfields["$k"] : 0;
        break;
      case "custom_date":
        $cfv=($varfields["$k"])?$zen->showDateTime($varfields["$k"]) : "n/a";
        break;
      default:
        $cfv=$varfields["$k"];
        break;
    }
?>
   <tr>
    <td colspan="5" class="smallTitleCell" height="<?=$height_num?>"><?=$v?></td>
   </tr>
   <tr>
    <td colspan="5" class="outlined">
      <input type="text" name="<?=$k?>" size="60"
        value='<?=(get_magic_quotes_runtime())?nl2br(stripslashes($cfv)):nl2br($cfv); ?>'>
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
