<?
  /*
  ** QUICK FIX TO GET USER 
  ** TO THE RIGHT PLACE
  ** FOR EDITING TICKETS
  */
  include("./action_header.php");
  header("Location:$rootUrl/admin/editTicket.php?id=$id");
?>