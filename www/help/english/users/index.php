<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<p><b>Where Am I?</b></p>

<p>The user's manual contains instructions on how to use
common features of <?=$zen->settings['system_name']?>.</p>

<p>
First time using <?=$zen->settings['system_name']?>?  
Please try out the 
<a href='<?=$helpUrl?>/users/tutorial.php'>Tutorial</a>!</p>

<p><b>Contents of User's Manual</b></p>
<?
  renderTOC('users', false);
?>

<p><b>What is <?=$zen->settings['system_name']?>?</b></p>

<p><?=$zen->settings['system_name']?> stores information about tasks and projects for your company as 
'tickets'.  It provides an interface for monitoring who is working on 
a ticket and what the status is.

<p><?=$zen->settings['system_name']?> also provides useful information about the ticket for both the
users who will be doing work and for project managers who must plan and monitor
current projects.</p>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
