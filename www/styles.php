<?
  include_once("./header.php");  
?>
<!--
 
  /*** PAGE PROPERTIES ***/
  
  BODY {
     background:       <?=$zen->settings["color_background"]?>;
     color:            <?=$zen->settings["color_text"]?>;
     font-family:      <?=$zen->settings["font_face"]?>;
     font-size:        <?=$zen->settings["font_size"]?>px;
     margin-left:      4px;
     margin-top:       4px;
  }

  TD {
     font-family:      <?=$zen->settings["font_face"]?>;
     font-size:        <?=$zen->settings["font_size"]?>px;     
  }
  
  FORM {
     margin-top: 0px;
     margin-bottom: 0px;
  }

  /*** PAGE COMPONENTS ***/

  .page_section {
     font-size:       <?=$zen->settings["font_size_large"]?>px;
     color:           <?=$zen->settings["color_alt_text"]?>px;
     font-weight:     bold;     
  }


  /*** LINK PROPERTIES ***/


  A {
     text-decoration: none;
     color:           <?=$zen->settings["color_links"]?>;
  }

  A:hover {
     color:           <?=$zen->settings["color_hover"]?>;
     text-decoration: underline;
  }

  A.menuLink {
     color:       <?=$zen->settings["color_title_txt"]?>; 
     font-size:   <?=$zen->settings["font_size"]?>;
     font-weight: bold;
     font-family: <?=$zen->settings["font_face"]?>;
  }

  A.menuLink:hover{
     text-decoration: none;
     color: <?=$zen->settings["color_title_txt"]?>;
  }

  A.subMenuLink {     
     color:      <?=$zen->settings["color_title_txt"]?>; 
     font-size:  <?=$zen->settings["font_size_small"]?>;
  }

  A.subMenuLink:hover {
     text-decoration: none;
     color:           <?=$zen->settings["color_title_txt"]?>;
     font:            <?=$zen->settings["font_size_small"]?>;
  }

  A.rowLink {
     color:           <?=$zen->settings["color_text"]?>;
  }

  A.rowLink:Hover {
     color:           <?=$zen->settings["color_text"]?>;
     text-decoration: none;
  } 

  A.tabsOn {
     color:           <?=$zen->settings["color_text"]?>;
     text-decoration: none;     
  }

  A.tabsOn:hover {
     color:  #000099;
  }

  A.tabsOff {
     color:           <?=$zen->settings["color_title_text"]?>;
     text-decoration: none;     
  }
 
  A.tabsOff:hover {
     color: #FFFF00;
  }


  /*** PRIORITY PROPERTIES ***/
<?
function priority_color($priority, $num) {
   // This function returns an HTML colour based on the priority
   // supplied on a sliding colour scale.
    
   $p = $priority / $num * 100;
   
   if ($p < 0) {
       $p = 0;
   }
   
   if ($p > 100) {
      $p = 100;
   }
   
   if ($p < 25) {
      $colour = '#FFFF' . substr('0'.dechex((25 - $p) * 10.23), -2);
   } elseif ($p < 100) {
      $colour = '#FF' . substr('0'.dechex((100 - $p) * 3.4), -2) . "00";
   } else {
      $colour = '#FF0000';
   }
   
   return ($colour);
}

$lowp = 99999;
$hip = -1;

foreach ($zen->getPriorities(1) as $v) {
   if ($v["priority"] < $lowp) $lowp = $v["priority"];
   if ($v["priority"] > $hip) $hip = $v["priority"];
}
      
$num = $hip - $lowp;

foreach ($zen->getPriorities(1) as $v) {
?>
  .priority<?=$v["pid"]?> {
     background:      <?=priority_color($v["priority"] - $lowp, $num)?>;
<?
   if ($v["priority"] == $hip) {?>

     font-weight:     Bold;
<?

   }?>
  }
  
<?
}
?>


  /*** CELL PROPERTIES ***/

  .altCell {
     color:       <?=$zen->settings["color_alt_background"]?>;
     background:  <?=$zen->settings["color_alt_text"]?>;
  }

  .altCellInv {
     color:       <?=$zen->settings["color_alt_text"]?>;
     background:  <?=$zen->settings["color_alt_background"]?>;
  }

  .cell {
     color:       <?=$zen->settings["color_alt_text"]?>;
     background:  <?=$zen->settings["color_background"]?>;     
  }

  .bars {
     color:       <?=$zen->settings["color_bar_text"]?>;
     background:  <?=$zen->settings["color_bars"]?>;     
  }

  .altBars {
     color:       <?=$zen->settings["color_bars"]?>;
     background:  <?=$zen->settings["color_bar_text"]?>;
  }

  .titleCell {
     color:          <?=$zen->settings["color_title_txt"]?>;
     background:     <?=$zen->settings["color_title_background"]?>;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     border:         1px solid <?=$zen->settings["color_alt_text"]?>;
     font-weight:    Bold;
  }

  .plainCell {
     color:       <?=$zen->settings["color_text"]?>;
     background:  <?=$zen->settings["color_background"]?>;
  }

  .subTitle {
     color:          <?=$zen->settings["color_alt_text"]?>;
     background:     <?=$zen->settings["color_alt_background"]?>;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     font-weight:    Bold;     
  }

  .menuCell {
     color:      <?=$zen->settings["color_title_txt"]?>;
     background: <?=$zen->settings["color_title_background"]?>;
  }

  .ticketCell {
     color:          <?=$zen->settings["color_alt_text"]?>;
     background:     <?=$zen->settings["color_alt_background"]?>;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     border:         1px solid <?=$zen->settings["color_title_background"]?>;
  }

  .smallTitleCell {
     color:          <?=$zen->settings["color_title_txt"]?>;
     background:     <?=$zen->settings["color_title_background"]?>;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     font-size:      <?=$zen->settings["font_size_small"]?>px;
  }

  .outlined {
     border:         1px solid <?=$zen->settings["color_title_background"]?>;
     background:     <?=$zen->settings["color_background"]?>;
  }

  .tabOn {
     color:          <?=$zen->settings["color_alt_text"]?>;
     background:     <?=$zen->settings["color_alt_background"]?>;
     font-weight:    bold;
     font-size:      <?=$zen->settings["font_size_small"]?>px;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   5px;
     padding-right:  5px;
  }

  .tabOff {
     color:          <?=$zen->settings["color_title_text"]?>;
     background:     <?=$zen->settings["color_title_background"]?>;
     font-weight:    bold;     
     font-size:      <?=$zen->settings["font_size_small"]?>px;
     <?
       if( $page_browser != "ns" ) {
	  print "padding-top: 2px;";
	  print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   5px;
     padding-right:  5px;     
  }

  /*** TEXT PROPERTIES ***/

.alttext {
   color:       <?=$zen->settings["color_alt_text"]?>;
}

.bigBold {
   color:        <?=$zen->settings["color_title_background"]?>;   
   font-size:    <?=$zen->settings["font_size_large"]?>px;  
   font-weight:  bold;
}

.big {
   font-size:   <?=$zen->settings["font_size_large"]?>px;  
}

.error {
   color:       <?=$zen->settings["color_hot"]?>;
   font-weight: Bold;
}

.highlight {
   font-weight: bold;
   background:  <?=$zen->settings["color_highlight"]?>;
   color:       <?=$zen->settings["color_bar_text"]?>;
}

.hot {
   font-weight: bold;
   color:       <?=$zen->settings["color_hot"]?>;
   background:  <?=$zen->settings["color_highlight"]?>;
}

.small {
   font-size:   <?=$zen->settings["font_size_small"]?>px;
}

.tiny {
   font-size:   <?=($zen->settings["font_size_small"]-1)?>px;
}

.smallGrey {
   color:       <?=$zen->settings["color_grey"]?>;
}

.smallError {
   color:       <?=$zen->settings["color_hot"]?>;
   font-weight: bold;
   font-size:   <?=$zen->settings["font_size_small"]?>px;
}

.smallBold {
   font-weight: bold;
}

.note {
   color:  <?=$zen->settings["color_grey"]?>;
   font-size: <?=$zen->settings["font_size_small"]?>px;
}

.smallHighlight {
   color:       <?=$zen->settings["color_highlight"]?>;
   font-weight: bold;
}

  
  /*** FORM PROPERTIES ***/


  INPUT, TEXTAREA, SELECT {
     color:      <?=$zen->settings["color_bar_text"]?>;
     background: <?=$zen->settings["color_bars"]?>;
  }

  BUTTON, .navButtons {
     color:      <?=$zen->settings["color_bars"]?>;
     background: <?=$zen->settings["color_bar_text"]?>;
  }

  .submit {
     color:      <?=$zen->settings["color_highlight"]?>;
     background: <?=$zen->settings["color_alt_text"]?>;
  }  
  .submitPlain {
     color:      <?=$zen->settings["color_background"]?>;
     background: <?=$zen->settings["color_alt_text"]?>;
  }  

  .smallSubmit {
     color:      <?=$zen->settings["color_highlight"]?>;
     background: <?=$zen->settings["color_alt_text"]?>;
     font-face:  Courier;
     font-size:  <?=$zen->settings["font_size_small"]?>px;
  }

  .actionButton {
     /* font-face:      <?=$zen->settings["font_face"]?>; */
     font-face:      Courier;
     color:          <?=$zen->settings["color_highlight"]?>;
     background:     <?=$zen->settings["color_bar_text"]?>;
     font-size:      <?=$zen->settings["font_size_small"]?>px;
     padding-left:   8px;
     text-align:     left;
     width:          80px;
  }

  .searchbox {
     color:      <?=$zen->settings["color_alt_text"]?>;
     background: <?=$zen->settings["color_alt_background"]?>;
  }

-->