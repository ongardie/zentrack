
To create a new ticket, simply reply to this email, and fill in the following information:

Parent: 
{*optional: provide another ticket id here to make this a sub-task of that ticket*}

Title:
{*your title may include anything except a colon (:) and brackets*}

Type:
{*place an x in the appropriate box*}
<?
  foreach($zen->getTypes() as $k=>$v) {
    print "[ ] $v\n";
  }
?>

System:
{*place an x in the appropriate box*}
<?
  foreach($zen->getTypes() as $k=>$v) {
    print "[ ] $v\n";
  }
?>

Owner:
{*optional: you may place a user's full name here, or you may put myself*}

Bin:
{*place an x in the appropriate box*}
<?
  foreach($zen->getTypes() as $k=>$v) {
    print "[ ] $k-$v\n";
  }
?>

Priority:
{*place an x in the appropriate box*}
<?
  foreach($zen->getTypes() as $k=>$v) {
    print "[ ] $k-$v\n";
  }
?>

Start Date:
{*optional: the date can be any standard format, you may also use +1 week, +2 months, etc*}

Deadline:
{*optional: the date can be any standard format, you may also use +1 week, +2 months, etc*}

Testing Required: [<?=($zen->settings["default_test_checked"]=="on")?"x":" "?>]
{*place an x in the box if testing will be needed before closing*}

Approval Required: [<?=($zen->settings["default_aprv_checked"]=="on")?"x":" "?>]
{*place an x in the box if approval will be required before closing*}

Details:
{*enter details about the ticket here, any text formatting will be accepted*}

