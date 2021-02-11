<?php
	$connection = new MongoDB\Driver\Manager("mongodb+srv://dipeeka_palande:SdoTGUSHCxzL788Q@devcluster.kqj7q.mongodb.net/gulf_racing?retryWrites=true&w=majority");
	
	/* success, error messages to be displayed */

 $messages = array(
  1=>'Record deleted successfully',
  2=>'Error occurred. Please try again', 
  3=>'Record saved successfully',
  4=>'Record updated successfully', 
  5=>'All fields are required' ,
  6=>'You didnt did any changes');
?>