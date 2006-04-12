<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<html>
<head>
<?
  // load hot key selections
  $sect = getZtSection();
  $load_section = $sect != 'undefined' && file_exists("$templateDir/nav_$sect.php");
  if( $load_section ) {
    $hotkeys->loadSection($sect);
    $GLOBALS['zt_hotkeys'] = $hotkeys;
  }

  print "<title>$page_prefix$page_title</title>";
  include("$templateDir/nav_header.php");
?>
</head>
<body>
<?
  include("$templateDir/nav_body.php"); 
?>