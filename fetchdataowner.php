<?php

require_once('config\config.php');

$id    = $_REQUEST['uid'];

$result = array();

if($id){

  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

  $options = [];

  $query = new MongoDB\Driver\Query($filter,$options);

  $cursor = $connection->executeQuery('gulf_racing.owners', $query);

  


/*
$response = "<table border='0' width='100%'>";
 foreach($cursor as $row){
// $id = $row['id'];
 $first_name = $row->first_name;
 $last_name = $row->last_name;
 $email_id = $row->email_id;

 
 $response .= "<tr>";
 $response .= "<td>First Name : </td><td>".$first_name."</td>";
 $response .= "</tr>";

 $response .= "<tr>";
 $response .= "<td>Last Name : </td><td>".$last_name."</td>";
 $response .= "</tr>";

 $response .= "<tr>";
 $response .= "<td>Email : </td><td>".$email_id."</td>";
 $response .= "</tr>";



}

$response .= "</table>";*/
foreach($cursor as $row){

$response ='<div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="'.$row->_id.'"/>
						<div class="col-sm-6">
							<label for="first_name">First Name</label>
							<input type="text" class="form-control" id="first_name" name="first_name" value="'.((!empty($row->first_name))?$row->first_name:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="last_name">Last Name</label>
							<input type="text" class="form-control" id="last_name" name="last_name" value="'.((!empty($row->last_name))?$row->last_name:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" value="'.((!empty($row->email))?$row->email:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="mobile">Mobile</label>
							<input type="text" class="form-control" id="mobile" name="mobile" value="'.((!empty($row->mobile))?$row->mobile:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="language">Language</label>
							<input type="text" class="form-control" id="language" name="language" value="'.((!empty($row->language))?$row->language:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="gender">gender</label>
							<input type="text" class="form-control" id="gender" name="gender" value="'.((!empty($row->gender))?$row->gender:"").'" readonly />
						</div>';
						
						if (!empty($row->date_of_joining))
						{
							$newd=$row->date_of_joining;
							//$ti=$newd->__toString();
							//echo $d;
							
							//$utcdatetime = new MongoDB\BSON\UTCDateTime($ti);
							//$datetime = $utcdatetime->toDateTime();
							
							//$timestamp = $newd->__toString(); //ISO DATE Return form mongo database
							//$utcdatetime = new MongoDB\BSON\UTCDateTime($timestamp);
							//$datetime = $utcdatetime->toDateTime();
							//$time=$datetime->format(DATE_RSS);
							//$dateInUTC=$time;
							//$time = strtotime($dateInUTC.' UTC');
							$dateInLocal = date("F d, Y", strtotime($newd));
							//echo $dateInLocal;

						}
						
						
						$response .='<div class="col-sm-6">
							<label for="date_of_joining">Date of Joining</label>
							<input type="text" class="form-control" id="date_of_joining" name="date_of_joining" value="'.((!empty($row->date_of_joining))? $dateInLocal: "").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="status"> Status</label>
							
							<input type="text" class="form-control" id="owner_status" name="owner_status" value="'.((!empty($row->owner_status))?($row->owner_status=="1"?"Active":"In Active"):"In Active").'" readonly />
							
						</div>
						
                    </div>';


echo $response;
exit;
}
}