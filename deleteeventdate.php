<?php

  require_once('config\config.php'); 


  $dateid   = $_GET['id'];
  $eventid=$_GET['eventid'];
  $filter = ['_id'=>new MongoDB\BSON\ObjectID($eventid)];
	$options = ['sort' => ['position' => -1]];	
	$query=new MongoDB\Driver\Query($filter,$options);
	$cursor=$connection->executeQuery("gulf_racing.events",$query);
	foreach($cursor as $document)
			{
					$datesarray=$document->alldates;
				
						
							$key = array_search ($dateid, $datesarray);
							//echo $key;
							//unset($datesarray[$key]); 
				//	print_r($datesarray);
					
					events.update(
  { _id: $eventid },
  { $pull: { 'alldates': { $key: $dateid } } }
);
					


							/*foreach($datesarray as $key=>$value)
							{
								if (array_key_exists("Volvo",$a))
								  {
								  echo "Key exists!";
								  }
								else
								  {
								  echo "Key does not exist!";
								  }
							}*/
				
				
														
				
			}
  
  