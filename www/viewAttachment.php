<?
  /*
  **  VIEW ATTACHMENT
  **  
  **  Safely print an attachment out for user to view
  **
  */
  
  include("header.php");

  $aid = ereg_replace("[^0-9]", "", $aid);  
  $att = $zen->get_attachment($aid);
  if( !$aid || !is_array($att) )
    header("Location: $rootUrl/index.php\n");
  $page_title = $att["name"];

  if( eregi("^application",$att["filetype"]) ) {
     $cd = "attachment;";
  } else {
     unset($cd);
  }
  header("Content-type: $att[filetype]\nContent-Disposition: $cd filename=$att[name]");

  readfile($zen->attachmentsDir."/$att[filename]");

?>
