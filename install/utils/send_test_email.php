<?

  $to_address = "your@email.com";
  
  print "Preparing to deliver email.<br>\n";
  if( 
  mail($to_address, "test email settings", "If you receive this email, your php.ini settings are working")
  ) {
    print "Email appears to have been delivered correctly, check your inbox.<br>\n";
  }
  else {
    print "Email may not have been delivered correctly.<br>\n";
  }

?>