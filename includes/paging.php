<!--- BEGIN Paging --->

  </td>
</tr>

<tr>
   <td  align="right"  style="background:<?=$zen->settings["color_bars"]?>;">
     <?
       $links = $zen->get_links("all", "on");
       for ($y = 0; $y < count($links); $y++) {
          echo $links[$y] . "&nbsp;&nbsp;";

       }
     ?>
<!--- END Paging --->

