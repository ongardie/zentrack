<?
   // zenTrack verion 1.0
   // zenTrack is a (c)phpZEN product, protected under the GPL Liscence for free distribution.
   // refer to http://www.phpzen.net for more information.

  include("help_header.php");
  $page_title = "Administrating Users";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  <ul>
    <li><a href='<?=$rootUrl?>/help/help_access.php'>Modifying a Users Access Priviledges</a></li>
  </ul>
  <b><a name="add"></a>Adding a User</b>
    <ul>
    <li><i>Login Name:</i>  Specifies the name new user will log into the system with.
    <li><i>Default Access Level:</i>  This is the access level that will be assigned to any bins not specifically declared for the user.  It is recommended to leave this empty with the exception of admin users, or those who have access to most bins.  Bins may be denied to a user, even if their default access level is higher than the level desired, by specifically assigning a level to that user / bin.
    <li><i>Last Name:</i>  Users Last Name.
    <li><i>First Name:</i>  Users First Name.
    <li><i>Initials:</i>  Users Initials.
    <li><i>Email Address:</i>  Users Email Address.
    <li><i>Admin Comments:</i>  Any comments for admin users concerning this account.
    </ul>
  <b><a name="edit"></a>Editing a User</b>
    <ul>
    <li><i>Login Name:</i>  Specifies the name new user will log into the system with.
    <li><i>Default Access Level:</i>  This is the access level that will be assigned to any bins not specifically declared for the user.  It is recommended to leave this empty with the exception of admin users, or those who have access to most bins.  Bins may be denied to a user, even if their default access level is higher than the level desired, by specifically assigning a level to that user / bin.
    <li><i>Last Name:</i>  Users Last Name.
    <li><i>First Name:</i>  Users First Name.
    <li><i>Initials:</i>  Users Initials.
    <li><i>Email Address:</i>  Users Email Address.
    <li><i>Admin Comments:</i>  Any comments for admin users concerning this account.
    </ul>
  <b><a name="delete"></a>Deleting a User</b>
    <ul>
    Users deleted are permanently dropped from the database, and cannot be recovered.
    </ul>
  </blockquote>
  &nbsp;
<?
  include("$libDir/footer.php");
?>
