<!--- BEGIN Paging --->

<table width='100%'>
<tr>
   <td  align="right" valign='bottom' style="background:<?=$zen->settings["color_bars"]?>;">
     <?
       $links = $zen->get_links("all", "off");
       for ($y = 0; $y < count($links); $y++) {
          echo $links[$y] . "&nbsp;&nbsp;";

       }
     ?>
   </td>
</tr>
</table>

<!--- END Paging --->

