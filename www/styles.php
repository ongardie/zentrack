<?
  include_once(dirname(__FILE__)."/header.php");  
  header("Content-Type: text/css");
?>
<!--
 
  /*** PAGE PROPERTIES ***/
  
  BODY {
     background:       <?=$zen->getSetting("color_background")?>;
     color:            <?=$zen->getSetting("color_text")?>;
     font-family:      <?=$zen->getSetting("font_face")?>;
     font-size:        <?=$zen->getSetting("font_size")?>px;
     margin-left:      4px;
     margin-top:       4px;
  }

  TD {
     font-family:      <?=$zen->getSetting("font_face")?>;
     font-size:        <?=$zen->getSetting("font_size")?>px;
     align-vertical:   top;
  }
  
  LI {
     margin-top: 5px; 
  }
  
  FORM {
     margin: 0px;
     padding: 0px;
  }
  
  

  /*** PAGE COMPONENTS ***/

  .page_section {
     font-size:       <?=$zen->getSetting("font_size_large")?>px;
     color:           <?=$zen->getSetting("color_alt_text")?>px;
     font-weight:     bold;     
  }

  .mainContent {
      background: <?=$zen->getSetting("color_bars")?>;
      /* padding: 5px; */
  }
  
  .padded {
    padding: 5px;
  }
  
  /*** LINK PROPERTIES ***/


  A {
     text-decoration: none;
     color:           <?=$zen->getSetting("color_links")?>;
  }

  A:hover {
     color:           <?=$zen->getSetting("color_hover")?>;
     text-decoration: underline;
  }

  A.menuLink {
     color:       <?=$zen->getSetting("color_title_txt")?>; 
     font-size:   <?=$zen->getSetting("font_size")?>;
     font-weight: bold;
     font-family: <?=$zen->getSetting("font_face")?>;
  }

  A.menuLink:hover{
     text-decoration: none;
     color: <?=$zen->getSetting("color_title_txt")?>;
  }

  A.subMenuLink {     
     color:      <?=$zen->getSetting("color_title_txt")?>; 
     font-size:  <?=$zen->getSetting("font_size_small")?>;
  }

  A.subMenuLink:hover {
     text-decoration: none;
     color:           <?=$zen->getSetting("color_title_txt")?>;
     font:            <?=$zen->getSetting("font_size_small")?>;
  }

  A.rowLink {
     color:           <?=$zen->getSetting("color_text")?>;
  }

  A.rowLink:Hover {
     color:           <?=$zen->getSetting("color_text")?>;
     text-decoration: none;
  }
  
  A.tabsOn {
     color:           <?=$zen->getSetting("color_text")?>;
     text-decoration: none;     
  }

  A.tabsOn:hover {
     color:  #000099;
  }

  A.tabsOff {
     color:           <?=$zen->getSetting("color_title_text")?>;
     text-decoration: none;     
  }
 
  A.tabsOff:hover {
     color: #FFFF00;
  }

  /*** PRIORITY PROPERTIES ***/
<?
  include("$libDir/priorityColors.php");
?>

  /*** CELL PROPERTIES ***/

  .altCell {
     color:       <?=$zen->getSetting("color_alt_background")?>;
     background:  <?=$zen->getSetting("color_alt_text")?>;
     padding: 2px;
  }

  .altCellInv {
     color:       <?=$zen->getSetting("color_alt_text")?>;
     background:  <?=$zen->getSetting("color_alt_background")?>;
     padding: 2px;
  }

  .cell, .invalidCell, .content, .labelCell {
     color:       <?=$zen->getSetting("color_alt_text")?>;
     background:  <?=$zen->getSetting("color_background")?>;
     padding: 2px;     
  }
  
  .labelCell {
     font-weight: bold; 
  }
  
  .content {
     padding: 10px; 
  }
  
  .invalidCell {
    color:       <?=$zen->getSetting('color_hot')?>;
  }

  .bars, .bar {
     color:       <?=$zen->getSetting("color_bar_text")?>;
     background:  <?=$zen->getSetting("color_bars")?>;
     padding: 2px;
  }
  
  .darker {
    background: <?=$zen->getSetting('color_bar_darker')?>;
  }
  
  .darkest {
    background: <?=$zen->getSetting('color_bar_darkest')?>;
  }

  .disabled, .disabled INPUT, .disabled BUTTON, .disabled SUBMIT, 
  .disabled SELECT, .inputDisabled {
     color:      <?=$zen->getSetting('color_grey')?> !important;
     background: <?=$zen->getSetting('color_bars')?> !important;
  }
  
  .altBars {
     color:       <?=$zen->getSetting("color_bars")?>;
     background:  <?=$zen->getSetting("color_bar_text")?>;
     padding: 2px;
  }

  .titleCell {
     color:          <?=$zen->getSetting("color_title_txt")?>;
     background:     <?=$zen->getSetting("color_title_background")?>;
     <?
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     border:         1px solid <?=$zen->getSetting("color_alt_text")?>;
     font-weight:    Bold;
  }

  .plainCell {
     color:       <?=$zen->getSetting("color_text")?>;
     background:  <?=$zen->getSetting("color_background")?>;
  }

  .subTitle {
     color:          <?=$zen->getSetting("color_bar_text")?>;
     background:     <?=$zen->getSetting("color_bar_darkest")?>;  
     padding-left:   2px;
     font-weight:    Bold;
     border: 1px solid <?=$zen->getSetting('color_bar_text')?>;
  }
  
  .menuCell {
     color:      <?=$zen->getSetting("color_title_txt")?>;
     background: <?=$zen->getSetting("color_title_background")?>;
  }

  .ticketCell {
     color:          <?=$zen->getSetting("color_alt_text")?>;
     background:     <?=$zen->getSetting("color_alt_background")?>;
     <?
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>
     padding-left:   15px;
     border:         1px solid <?=$zen->getSetting("color_title_background")?>;
  }

  .smallTitleCell {
     color:          <?=$zen->getSetting("color_title_txt")?>;
     background:     <?=$zen->getSetting("color_title_background")?>;
     <?
       if( $page_browser != "ns" ) {
     print "padding-top: 2px;";
     print "padding-bottom: 2px;";
       }
     ?>     
     padding-left:   2px;
     font-size:      <?=$zen->getSetting("font_size_small")?>px;
  }

  .outlined {
     border:         1px solid <?=$zen->getSetting("color_title_background")?>;
     background:     <?=$zen->getSetting("color_background")?>;
  }
  
  .tab {
     font-weight:    bold;
     font-size:      <?=$zen->getSetting("font_size")?>px;
     padding:   2px 5px;
     border-top: 2px outset <?=$zen->getSetting('color_bar_darker')?>;
     border-left: 2px outset <?=$zen->getSetting('color_bar_darker')?>;
     border-right: 2px outset <?=$zen->getSetting('color_bar_darker')?>;
  }
  
  .tab A { border: none; background: none; text-decoration: none; }
  .tab A:hover { border: none; background: none; text-decoration: none; }
  
  .on {
     color:          <?=$zen->getSetting("color_text")?>;
     background:     <?=$zen->getSetting("color_bars")?>;
  }

  .off {
     color:          <?=$zen->getSetting("color_bar_text")?>;
     background:     <?=$zen->getSetting("color_bar_darker")?>;
  }
  
  .off A { color: <?=$zen->getSetting('color_bar_text')?> !important; }
  .on A { color: <?=$zen->getSetting('color_text')?> !important; }
  
  A.navOn, A.navOn:Hover {
    text-decoration: none;
    color: <?=$zen->getSetting("color_title_text")?>;
    background: none;
  }
  
  A.navOff, A.navOff:Hover {
    text-decoration: none;
    color: <?=$zen->getSetting("color_title_text")?>;
    background: none;
  }

  A.leftNavLink, A.leftNavLink:Hover {
    text-decoration: none;
    color: <?=$zen->getSetting("color_alt_text")?>;
    background: none;
  }
  

  .navTab {
     font-weight:    bold;
     font-size: <?=$zen->getSetting('font_size')?>;
     padding: 5px;
     border-top: 1px outset <?=$zen->getSetting('color_bar_border')?>;
     border-left: 1px outset <?=$zen->getSetting('color_bar_border')?>;
     border-right: 1px outset <?=$zen->getSetting('color_bar_border')?>;
  }
  
  .hotKeyHelp {
    position: absolute;
    left: 300px;
    top: 120px;
  }
  
  .hotKeyCell {
    background: <?=$zen->getSetting('color_highlight')?>;
    color: <?=$zen->getSetting('color_hot')?>;
    border: 1px solid <?=$zen->getSetting('color_title_background')?>;
  }
  
  .invisible {
    visibility: hidden;
  }
  
  .accesskeys {
   border: 0; width: 0px; height: 0px;    
  }
  
  A.navTab { border: none; }

  .navOn {
     color:          <?=$zen->getSetting("color_title_text")?>;
     background:     <?=$zen->getSetting("color_title_background")?>;
  }

  .navOff {
     color:          <?=$zen->getSetting("color_title_text")?>;
     background:     <?=$zen->getSetting("color_bar_darkest")?>;
  }

  /*** TEXT PROPERTIES ***/

.alttext {
   color:       <?=$zen->getSetting("color_alt_text")?>;
}

.bigBold {
   font-size:    <?=$zen->getSetting("font_size_large")?>px;  
   font-weight:  bold;
}

.big {
   font-size:   <?=$zen->getSetting("font_size_large")?>px;  
}

TD.bigger { font-size: 50px; }

.error {
   color:       <?=$zen->getSetting("color_hot")?>;
   font-weight: Bold;
}

.highlight {
   font-weight: bold;
   background:  <?=$zen->getSetting("color_highlight")?>;
   color:       <?=$zen->getSetting("color_bar_text")?>;
}

.mark {
   background:  <?=$zen->getSetting("color_highlight")?>;  
}

.hot {
   font-weight: bold;
   color:       <?=$zen->getSetting("color_hot")?>;
   background:  <?=$zen->getSetting("color_highlight")?>;
}

.small {
   font-size:   <?=$zen->getSetting("font_size_small")?>px;
}

.tiny {
   font-size:   <?=($zen->getSetting("font_size_small")-1)?>px;
}

.smallGrey {
   color:       <?=$zen->getSetting("color_grey")?>;
}

.smallError {
   color:       <?=$zen->getSetting("color_hot")?>;
   font-weight: bold;
   font-size:   <?=$zen->getSetting("font_size_small")?>px;
}

.bold {
  font-weight: bold;
}

.smallBold {
   font-weight: bold;
}

.note {
   color:  <?=$zen->getSetting("color_grey")?>;
   font-size: <?=$zen->getSetting("font_size_small")?>px;
}

.warning {
   color:  <?=$zen->getSetting("color_text")?>;
   font-size: <?=$zen->getSetting("font_size_small")?>px;
}

.smallHighlight {
   color:       <?=$zen->getSetting("color_highlight")?>;
   font-weight: bold;
}

  
  /*** FORM PROPERTIES ***/


  INPUT, TEXTAREA, SELECT, .input {
     color:      <?=$zen->getSetting("color_bar_text")?>;
     background: <?=$zen->getSetting("color_background")?>;
  }

  BUTTON, .navButtons {
     color:      <?=$zen->getSetting("color_bars")?>;
     background: <?=$zen->getSetting("color_bar_text")?>;
  }

  .submit {
     color:      <?=$zen->getSetting("color_highlight")?>;
     background: <?=$zen->getSetting("color_alt_text")?>;
  }  
  .submitPlain {
     color:      <?=$zen->getSetting("color_background")?>;
     background: <?=$zen->getSetting("color_alt_text")?>;
  }  

  .smallSubmit {
     color:      <?=$zen->getSetting("color_highlight")?>;
     background: <?=$zen->getSetting("color_alt_text")?>;
     font-face:  Courier;
     font-size:  <?=$zen->getSetting("font_size_small")?>px;
  }

  .actionButton {
     font-face:      Courier;
     color:          <?=$zen->getSetting("color_highlight")?>;
     background:     <?=$zen->getSetting("color_bar_text")?>;
     font-size:      <?=$zen->getSetting("font_size_small")?>px;
     padding-left:   8px;
     text-align:     left;
     width:          80px;
  }

  .actionButtonContact {
     font-face:      Courier;
     color:          <?=$zen->getSetting("color_highlight")?>;
     background:     <?=$zen->getSetting("color_bar_text")?>;
     font-size:      <?=$zen->getSetting("font_size_small")?>px;
     padding-left:   8px;
     text-align:     left;
     width:          122px;
  }

  .searchbox {
     background: <?=$zen->getSetting("color_bar_darkest")?>;
  }
  
  .leftNavCell {
    background: <?=$zen->getSetting('color_bar_darkest')?>;
    font-size:  <?=$zen->getSetting('font_size_small')?>px;
  }
  
  .leftNavMenu {
    background: <?=$zen->getSetting('color_bar_darkest')?>;
    font-weight: bold;
    font-size:  <?=$zen->getSetting('font_size')?>px;
  }
  
  .leftNavTitle {
    color: <?=$zen->getSetting('color_title_text')?>;
    text-align: center;
    font-weight: bold;
    font-size:  <?=$zen->getSetting('font_size')?>px;
  }
  
  .inset {
    border: 1px inset <?=$zen->getSetting('color_bar_border')?>;
  }
  
  .outset {
    border: 1px outset <?=$zen->getSetting('color_bar_border')?>;
  }
  
  .navpad {
    padding-top: 3px;
    padding-bottom: 3px;
  }
  
  .indent {
    padding-left: 10px;
  }
  
  .boxpad {
    padding-top: 5px;
    padding-bottom: 5px;
  }
  
  .tabpad {
    padding-top: 5px;
  }
  
  .tbar {
     color:       <?=$zen->getSetting("color_text")?>;
     background:  <?=$zen->getSetting("color_bar_darkest")?>;
     font-weight: bold;
  }
  
  .borderBox {
    border: 1px solid <?=$zen->getSetting('color_bar_border')?>;
    position: relative;
    padding: 5px;
    margin-top: 12px;
    margin-left: 0px;
    margin-right: 10px;
    margin-bottom: 5px;
  }
  
  .borderLabel {
    position: absolute;
    top: -12px;
    left: 25px;
    width: 100%;
  }
  
  .borderLabel span {
    color:      <?=$zen->getSetting('color_bar_border')?>;
    font-weight: bold;
    font-size:  <?=$zen->getSetting('font_size')?>;
    background: <?=$zen->getSetting('color_bars')?>;
    padding: 0px 5px;
  }
  
  .borderContent {
    color:      <?=$zen->getSetting('color_text')?>;
    font-size:  <?=$zen->getSetting('font_size')?>;
    background: <?=$zen->getSetting('color_background')?>;
    border:     1px solid <?=$zen->getSetting('color_bar_darkest')?>;
    padding: 5px;
    max-height: 200px;
    height: expression(this.scrollHeight > 200? "200px" : "auto");
    overflow: auto;
  }
  
  .propContent, .propLabel {
    color:      <?=$zen->getSetting('color_text')?>;
    font-size:  <?=$zen->getSetting('font_size')?>;
  }
  
  .propContent {
    background: <?=$zen->getSetting('color_background')?>;
    border:     1px solid <?=$zen->getSetting('color_bar_darkest')?>;
    padding: 5px;
  }
  
  .propLabel {
    background: <?=$zen->getSetting('color_bar_darkest')?>;
    border:     1px solid <?=$zen->getSetting('color_bar_darkest')?>;
    font-weight: bold;
    padding: 2px 5px;
    white-space: nowrap;
  }
  
  .barborder {
    border: 1px solid <?=$zen->getSetting('color_bar_border')?>;
  }
-->