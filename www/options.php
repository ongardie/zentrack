<?
  /*
  **  USER OPTIONS
  **  
  **  Provide user specific options such as password changing
  **  and preferences
  **
  */
  
  include("header.php");


  $page_tile = "User Options";
  $expand_tickets = 1;
  include("$libDir/nav.php");

?>
  <p><b>User Configuration Screen</b></p>
  <ul>
    <li>Change Password
    <li>Update Personal Preferences
    <li>Configure Some Default Settings
    <li>Set a password cookie
  </ul>
<?
  include("$libDir/footer.php");
?>
