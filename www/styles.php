<?
  include("header.php");  
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
     border:         1px solid #000066;
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


.bigBold {
   color:        <?=$zen->settings["color_title_background"]?>;   
   font-size:    <?=$zen->settings["font_size_large"]?>px;  
   font-weight:  bold;
}

.alttext {
   color:       <?=$zen->settings["color_alt_text"]?>;
}

.big {
   font-size:   <?=$zen->settings["font_size_large"]?>px;  
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

.smallGrey {
   color:       <?=$zen->settings["color_grey"]?>;
}

.smallError {
   color:       <?=$zen->settings["color_hot"]?>;
   font-weight: bold;
}

.smallBold {
   font-weight: bold;
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
