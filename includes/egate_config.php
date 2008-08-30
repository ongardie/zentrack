<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  EGATE CONFIGURATION
  */
  
  // use the absolute path (not the url)
  // to the www/header.php file
  $header_file_location = "/web/...zentrack/www/header.php";

  // the notify level determines what we will
  // send an email to the sender for
  //    0 - never
  //    1 - on high level errors only
  //    2 - on any warning
  //    3 - on any information
  $egate_notify_level = 2;

  // the log level determines what we will
  // place within the log
  //    0 - never
  //    1 - on high level errors only
  //    2 - on any warning
  //    3 - on any information logged
  $egate_log_level = 3;

  // this is primarily for debugging.  Any email address
  // entered here will recieve a BCC of all emails sent
  // by the egate system
  $egate_bcc_address = "";

  // the user account that will be used to control
  // permissions while using the egate interface
  // this should match the login name entered in the zentrack users
  // (provide the login name here, the password is not needed)
  $egate_account = "egate";
  
  /**
   * STRIP ORIGINAL MESSAGE FROM REPLIES.
   *
   * Removes text from emails based on a regexp. You can literally use
   * this to remove anything from the email. The intention, of course,
   * being to delete the quoted reply text when a reply email is sent.
   *
   * The default setting is to replace any text after the tag
   * ---Original Message--- (surrounded by 3 or more dashes)
   *
   * This is a PHP regular expression. Note the .* at the end, this causes it to delete everything
   * from the regexp to the end of the message. Also note the "s" modifier
   * after the the closing bar. This causes the .* to match \n (returns)
   * which would otherwise be excluded and allows it to reach the end of the
   * message instead of just the end of the line.
   *
   * To add multiple bits of text, use the (...|...) notation, like this:
   * "@\n\s*(-{3,}Original Message-{3,}|[*]{2,}Reply from [^*]+[*]{2,}).*$@s"
   *
   * The above example would match ---Original Message--- or ** Reply from name here **
   *
   * To disable this feature, simply set this variable to false.
   */
  $egate_originalemail_prefix = "@\n\s*-{3,}Original Message-{3,}.*$@s";
  
  /*
  ** DEFAULT NEW TICKET PROPERTIES
  **
  ** These are used by the egate_create.php and egate_check_create.php scripts.
  **
  ** If you are using these scripts, set the values below, otherwise, you may skip these.
  */
  $egate_default_options = array(
				 "Type"              => "Support Request",
				 "Bin"               => "Tech Support",
				 "Priority"          => "None",
				 "System"            => "Website",
				 "Testing Required"  => 0,      //0=no, 1=yes
				 "Approval Required" => 0       //0=no, 1=yes
				 );
  
  /*
  **  IF USING A PIPE FROM THE MAIL SERVER, you are done
  **
  **  IF CHECKING A POP MAIL BOX, configure the settings below
  */
  
  // use an ip address, 
  // a fully qualified domain name, or locahost
  $smtp_host = "mail.yourstmpsite.com";
  
  // this probably doesn't need to change
  $smtp_port = "110";
  
  // the username to log in with
  $smtp_user = "username";
  
  // the password to log in with
  $smtp_pass = "password";    

  // this is a basic pop3 config
  // you probably don't need to change this at all
  // there are others for imap, ssl, etc
  // see http://www.php.net/manual/en/function.imap-open.php for more options

  $smtp_string = "{".$smtp_host.":".$smtp_port."/pop3}INBOX";  // note that the { and $ separation is critical!

  // RED HAT USERS!!
  // you may need to use one of the following strings to get this working on redhat
  // due to yet another redhat bug
  // $smtp_string = "{".$smtp_host.":".$smtp_port."/pop3/notls}INBOX";
  // $smtp_string = "{".$smtp_host.":".$smtp_port."/notls}INBOX";


  /**
   * You probably don't need to change this, unless you specifically want to disallow some fields
   * from being settable.
   */
  
  // allows users to customize the ticket properties by putting 'field:value' at the beginning of the email
  // this is only used by the egate_create script (not the admin script)
  $egate_create_overrides = 1;

  // if $egate_create_overrides is on, this will determine which fields can be set
  // this list also includes valid aliases.
  //
  // YOU CANNOT ADD ITEMS TO THIS ARRAY, and you should probably never edit it, 
  // other than to comment out fields which you do not want the user to override
  $egate_create_fields = array(
			      "parent",
			      "project",                //project name or id
			      "bin",                    //bin name or id
			      "priority",               //priority name or id
			      "type",                   //type name or id
                              "system",                 //system name or id
			      "owner",                  //owner name, email, or id
			      "start",
			      "start date",
			      "start_date",             //start date (any date format)
			      "deadline",               //deadline for completion (any date format)
			      "worked", 
			      "wd_hours", 
			      "hours worked",           //the number of hours worked so far (integer)
			      "est_hours", 
			      "estimated hours",
			      "estimated",              //estimated hours (integer)
			      "testing",
			      "testing required",
			      "testing_required",       //is testing required (1=yes)
			      "approval",
			      "approval required",
			      "approval_required"       //is approval required (1=yes)
  );

?>