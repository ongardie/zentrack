
The following options are available for ticket <?=id?>, at present:

<?
 foreach($valid_actions as $k=>$v) {
    if( $v["egate"] > 0 ) {
      print ucwords($k)."\n";
    }
 }
?>

For more information on using these options, reply to this message with the word "help" in the subject.
