<?
 if( !ZT_DEFINED ) { die("Illegal access"); }
?>
  <br><blockquote>
   <b><?=tr("Please enter ticket IDs")?></b>
   <form action='<?=$SCRIPT_NAME?>' name='ticketIdForm' method='post'>
     <div>Separate multiple ids with spaces</div>
     <textarea name="tickets_to_delete" rows="3" cols="25"><?= $zen->ffv(join(" ",$validids)) ?></textarea>
     <p><input type='submit' name='delbutton' value=' Confirm Tickets to be Deleted '>
   </form>
   <script>setFocalPoint('ticketIdForm','id');</script>
   </blockquote>
