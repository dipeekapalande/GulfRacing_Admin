<?php
include('../config/config.php');

$camelnumber = $_REQUEST['search'];


$regex = new MongoDB\BSON\Regex ( '^'.$camelnumber.'');


$filter = ["camelnumber"=>$regex];
/* the following condition, and others similar to it, work as well

$filter = ["age"=>["$gt"=>"18"]]; /*/
   
$options = []; /* put desired options here, should you need any */
   
$query = new MongoDB\Driver\Query($filter,$options);
   
$documents = $connection->executeQuery('gulf_racing.camels',$query);


$response="<h2>Camel List</h2>
<input type='button' name='del_item' value='Add' onClick='addcamelRow();'  class='btn btn-info' style='float:right'/>
";

foreach($documents as $document){
	//print_r($document);
   // $document = json_decode(json_encode($document),true);
  //  echo $document['name'];
 
	$storedUsername=$document->camelname;
	$storedcamelnumber=$document->camelnumber;
	$storecamelid=$document->_id;
	//$response['message'] =(string)($storecamelid);
	//$response['message'] =(string)($storedUsername);				
   // <button onclick="return getfunction('.(string)($storecamelid).');">
	//echo json_encode($response);
	
	$response.='<div>
	
	<hr style="border-top:2px dotted #ccc;"/>
	
	<div class="camelitems" style="word-wrap:break-word;">
		<input type="checkbox"  value="'.(string)($storecamelid).'" name="item_index[]" /><h4>'.$storedUsername.'---'.$storedcamelnumber.'</h4>
		
	</div>
	<hr style="border-bottom:1px solid #ccc;"/>
	
</div>';
	
}
?>

<?php
echo $response;
exit;