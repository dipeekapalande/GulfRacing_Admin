<?php
include('../config/config.php');

$camelnumber = $_REQUEST['camelnumber'];



 

$filter = ["camelnumber"=>$camelnumber];
/* the following condition, and others similar to it, work as well

$filter = ["age"=>["$gt"=>"18"]]; /*/
   
$options = []; /* put desired options here, should you need any */
   
$query = new MongoDB\Driver\Query($filter,$options);
   
$documents = $connection->executeQuery('gulf_racing.camels',$query);


 
foreach($documents as $document){
    $document = json_decode(json_encode($document),true);
  //  echo $document['name'];
	$storedUsername=$document['camelnumber'];
	
	
}

if($camelnumber == $storedUsername ){ 
					
					$response['message'] = "camel number is already exist please use another camel number";
    
					echo json_encode($response);
					}else{
					
					
				}
				
