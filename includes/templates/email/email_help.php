
<?=$zen->settings["system_name"]?> Email Gateway Help

-----------------
Overview
-----------------

The <?=$zen->settings["system_name"]?> email gateway
provides an interface for users to
perform actions on request tickets
via email.

Actions are performed by
replying to any email post with
the following text format in
the subject:

#nnnn action

where nnnn is the ticket to 
modify, and action is the task
to peform. (see below for more 
info on actions)

Any comments about the action
may be entered in the body of the
document.

Occasionally special options and 
instructions may be included in the
body of the email.

When replying, you do not need to
worry about removing any text that
is quoted in your reply.  You also
do not need to be concerned if special
options in the email are quoted.

-----------------
Unsubscribe
-----------------

To remove yourself from a notify list
for a specific ticket, you need only to 
reply with the text:

#nnnn remove

In the subject, where nnnn is the 
ticket number.

-----------------
Actions
-----------------

NOTE: not all actions listed here
will be available for every ticket
at any given time.

To get a list of optons for a
specific ticket, use the following
subject:

#nnnn options

Where nnnn is the ticket number.

Accept: This will place a ticket
under your ownership, assuming you
have priviledges to complete this
action.

Add: This will add the email address
that the ticket was recieved from
to the notify list.

Approve: This will provide a final
ok, indicating that all actions for
this ticket have been completed, and
it is done.

Assign: This will assign the ticket
to a new user.  The user must be
registered in the ticket system, and
you must have supervisor rights to
assign tickets to a user.

Close: This will mark the ticket
as completed, and send appropriate
notifications.  This will also 
prepare the ticket for special
conditions as approval and testing.

Email xxxx: This will send a summary
of the ticket to address xxxx.  
Estimate nnnn: This will enter an 
estimate for the length of time 
required to complete this ticket.  
nnnn is the number of hours.

Log: This will enter a message in 
the log file.  The following 
optional parameters can be provided 
in the body of the message:
  hours: nnnn
     where nnn is the number of hours 
     worked to be associated with 
     this log entry.
  activity: xxxx
     where xxxx can be any valid 
     activity type: question, note,
     labor, action, resolution, etc.

Remove: This will remove the address
that the ticket was recieved from 
from the notify list.

Test: Using this option will set the
ticket as having been successfully
tested.
