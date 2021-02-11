<?php

require_once('config\config.php');

$id    = $_REQUEST['uid'];

$result = array();

if($id){

  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

  $options = [];

  $query = new MongoDB\Driver\Query($filter,$options);

  $cursor = $connection->executeQuery('gulf_racing.camels', $query);
  
$response="";
foreach($cursor as $row){

$response .='<div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="'.$row->_id.'"/>
						<div class="col-sm-12">
							<div class="col-sm-4">
							</div>
							<div class="col-sm-4">
								<img src="images/'.((!empty($row->image))?$row->image:"noimage.jfif").'" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin-bottom:15%">
							</div>
							<div class="col-sm-4">
							</div>
						</div>
						<div class="col-sm-6">
							<label for="camelname">Camel Name</label>
							<input type="text" class="form-control" id="camelname" name="camelname" value="'.((!empty($row->camelname))?$row->camelname:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="camelnumber">Camel Number</label>
							<input type="text" class="form-control" id="camelnumber" name="camelnumber" value="'.((!empty($row->camelnumber))?$row->camelnumber:"").'" readonly />
						</div>
						<div class="col-sm-12">
							<label for="cameldescription">Camel Description</label>
							<textarea class="form-control" id="cameldescription" name="cameldescription" value="'.((!empty($row->cameldescription))?$row->cameldescription:"").'" readonly>'.((!empty($row->cameldescription))?$row->cameldescription:"").'</textarea>
						</div>
						<div class="col-sm-6">
							<label for="camelcategory">Camel Category</label>
							<input type="text" class="form-control" id="camelcategory" name="camelcategory" value="'.((!empty($row->camelcategory))?$row->camelcategory:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="age">Age</label>
							<input type="text" class="form-control" id="age" name="age" value="'.((!empty($row->age))?$row->age:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="fathername">Father Name</label>
							<input type="text" class="form-control" id="fathername" name="fathername" value="'.((!empty($row->fathername))?$row->fathername:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="mothername">mothername</label>
							<input type="text" class="form-control" id="mothername" name="mothername" value="'.((!empty($row->mothername))?$row->mothername:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="gender">gender</label>
							<input type="text" class="form-control" id="gender" name="gender" value="'.((!empty($row->gender))?$row->gender:"").'" readonly />
						</div>';
						
						
						$response .='<div class="col-sm-6">
							<label for="status">Camel Status</label>
							
							<input type="text" class="form-control" id="camel_status" name="camel_status" value="'.((!empty($row->camel_status))?($row->camel_status=="1"?"Active":"In Active"):"In Active").'" readonly />
							
						</div>
						<div class="col-sm-6">
							<label for="owner_name">Owner name</label>
							<input type="text" class="form-control" id="owner_name" name="owner_name" value="'.((!empty($row->owner_name))?$row->owner_name:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="mobile">Owner Mobile</label>
							<input type="text" class="form-control" id="mobile" name="mobile" value="'.((!empty($row->mobile))?$row->mobile:"").'" readonly />
						</div>
						
                    </div>';
					
					/*$ownerid=$row->raceid;
					$filter = ['_id' => new MongoDB\BSON\ObjectID($ownerid)];

  $options = [];

  $query = new MongoDB\Driver\Query($filter,$options);

  $cursor = $connection->executeQuery('gulf_racing.races', $query);
  foreach($cursor as $row){
	  
	  if (!empty($row->racedate))
						{
							$newd=$row->racedate;
							$timestamp = $newd->__toString(); //ISO DATE Return form mongo database
							$utcdatetime = new MongoDB\BSON\UTCDateTime($timestamp);
							$datetime = $utcdatetime->toDateTime();
							$time=$datetime->format(DATE_RSS);
							$dateInUTC=$time;
							$time = strtotime($dateInUTC.' UTC');
							$dateInLocal = date("Y-m-d", $time);
						}
						if (!empty($row->racetime))
						{
							$newd1=$row->racetime;
							$timestamp1 = $newd1->__toString(); //ISO DATE Return form mongo database
							$utcdatetime1 = new MongoDB\BSON\UTCDateTime($timestamp1);
							$datetime1 = $utcdatetime1->toDateTime();
							$time1=$datetime1->format(DATE_RSS);
							$dateInUTC1=$time1;
							$time1 = strtotime($dateInUTC1.' UTC');
							$dateInLocal1 = date("H:i:s", $time1);
						}
						
						if (!empty($row->duration))
						{
							$newd2=$row->duration;
							$timestamp2 = $newd2->__toString(); //ISO DATE Return form mongo database
							$utcdatetime2 = new MongoDB\BSON\UTCDateTime($timestamp2);
							$datetime2 = $utcdatetime2->toDateTime();
							$time2=$datetime2->format(DATE_RSS);
							$dateInUTC2=$time2;
							$time2 = strtotime($dateInUTC2.' UTC');
							$dateInLocal2= date("H:i:s", $time2);
						}
						
	  $response .='<div class="form-group">
							
						<div class="col-sm-6">
							<label for="racename">Race name</label>
							<input type="text" class="form-control" id="racename" name="racename" value="'.((!empty($row->racename))?$row->racename:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="racedate">Race Date</label>
							<input type="text" class="form-control" id="racedate" name="racedate" value="'.((!empty($dateInLocal))?$dateInLocal:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="racetime">Race Time</label>
							<input type="text" class="form-control" id="racetime" name="racetime" value="'.((!empty($dateInLocal1))?$dateInLocal1:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="length">Race Length (In Miles)</label>
							<input type="text" class="form-control" id="length" name="length" value="'.((!empty($row->length))?$row->length:"").'" readonly />
						</div>
						';
  }
*/
  }

  
  echo $response;
exit;
}