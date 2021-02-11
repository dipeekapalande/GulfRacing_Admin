<?php
include('../config/config.php');

$camelnumber = $_REQUEST['keyword'];



 

$filter = ["camelnumber"=>$camelnumber];
/* the following condition, and others similar to it, work as well

$filter = ["age"=>["$gt"=>"18"]]; /*/
   
$options = []; /* put desired options here, should you need any */
   
$query = new MongoDB\Driver\Query($filter,$options);
   
$documents = $connection->executeQuery('gulf_racing.camels',$query);


 
foreach($documents as $document){
    $document = json_decode(json_encode($document),true);
  //  echo $document['name'];
	$storedUsername=$document['camelname'];
	
	
}

if($emailvalue == $storedUsername ){ 
					
					$response['message'] = "Email is already exist please use another email";
    
					echo json_encode($response);
					}else{
					echo $storedUsername;
					
				}
				
