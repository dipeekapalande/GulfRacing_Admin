<?php

require_once('config\config.php');

$id    = $_REQUEST['uid'];

$result = array();

if($id){

  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

  $options = [];

  $query = new MongoDB\Driver\Query($filter,$options);

  $cursor = $connection->executeQuery('gulf_racing.races', $query);
  
$response="";
foreach($cursor as $row){
	
	$allurls=$row->live_stream_urls;
	
	//Get Channel details from channel id
	$filter1 = ['_id' => new MongoDB\BSON\ObjectID($row->channelid)];

  $options1 = [];

  $query1 = new MongoDB\Driver\Query($filter1,$options1);

  $cursor1 = $connection->executeQuery('gulf_racing.channels', $query1);
  //Date Time and duration
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
						
						 foreach($cursor1 as $row1){
	  $response .='<div class="form-group">
						<div class="col-sm-12">
							<div class="col-sm-4">
								<h3>Channel Cover Image</h3>
								<img src="images/'.((!empty($row1->coverimage))?$row1->coverimage:"noimage.jfif").'" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin-bottom:15%" title="Cover Image">
							</div>
							<div class="col-sm-4">
							<h3>Channel Logo Image</h3>
								<img src="images/'.((!empty($row1->image))?$row1->image:"noimage.jfif").'" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin-bottom:15%" title="Logo Image">
							</div>
							<div class="col-sm-4">
							<h3>Race Cover Image </h3>
								<img src="images/'.((!empty($row->coverimage))?$row->coverimage:"noimage.jfif").'" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin-bottom:15%" title="Logo Image">
							</div>
							
						</div>
						<div class="col-sm-6">
							<label for="channelname">Channel name</label>
							<input type="text" class="form-control" id="channelname" name="channelname" value="'.((!empty($row1->channelheader))?$row1->channelheader:"").'" readonly />
						</div>
						<div class="col-sm-6">
							<label for="channeldescription">Channel Description</label>
							<input type="text" class="form-control" id="channeldescription" name="channeldescription" value="'.((!empty($row1->channelsubheader))?$row1->channelsubheader:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="location">Location</label>
							<input type="text" class="form-control" id="location" name="location" value="'.((!empty($row1->location))?$row1->location:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="eventname">Event Name</label>
							<input type="text" class="form-control" id="eventname" name="eventname" value="'.((!empty($row1->eventname))?$row1->eventname:"").'" readonly />
						</div>
						';
  }

$response .='<div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="'.$row->_id.'"/>
						
						<div class="col-sm-6">
							<label for="racename">Race Name</label>
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
							<label for="duration">Duration (In Minutes)</label>
							<input type="text" class="form-control" id="duration" name="duration" value="'.((!empty($dateInLocal2))?$dateInLocal2:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="length">Length (In Miles)</label>
							<input type="text" class="form-control" id="length" name="length" value="'.((!empty($row->length))?$row->length:"").'" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="isTrending">Trending Status</label>
							
							<input type="text" class="form-control" id="isTrending" name="isTrending" value="'.((!empty($row->isTrending))?($row->isTrending==true?"Active":"In Active"):"In Active").'" readonly />
							
						</div>
						
						
						<div class="col-md-12 col-sm-12">
							<label for="racename">Live Streaming Urls</label>
						</div>
						<div class="col-sm-12">
							<label for="lowurl">Low</label>
							<input type="text" class="form-control" id="lowurl" name="lowurl" value="'.((!empty($allurls->low))?$allurls->low:"").'"  placeholder="Enter URL for Low Resolution" readonly />
						</div>
						<div class="col-sm-12">
							<label for="mediumurl">Medium</label>
							<input type="text" class="form-control" id="mediumurl" name="mediumurl" value="'.((!empty($allurls->med))?$allurls->med:"").'"  placeholder="Enter URL for Medium Resolution" readonly />
						</div>
						
						<div class="col-sm-12">
							<label for="highurl">High</label>
							<input type="text" class="form-control" id="highurl" name="highurl" value="'.((!empty($allurls->high))?$allurls->high:"").'"  placeholder="Enter URL for High Resolution" readonly />
						</div>
						
						<div class="col-sm-12">
							<label for="ultrahighurl">Ultra High</label>
							<input type="text" class="form-control" id="ultrahighurl" name="ultrahighurl" value="'.((!empty($allurls->ultra_high))?$allurls->ultra_high:"").'"  placeholder="Enter URL for Ultra High Resolution" readonly />
						</div>
						
						<div class="col-sm-12">
							<label for="youtubeurl">Youtube</label>
							<input type="text" class="form-control" id="youtubeurl" name="youtubeurl" value="'.((!empty($allurls->youtube))?$allurls->youtube:"").'"  placeholder="Enter URL for Youtube " readonly />
						</div>
					    <div class="col-sm-12">
							<label for="vimeourl">Vimeo</label>
							<input type="text" class="form-control" id="vimeourl" name="vimeourl" value="'.((!empty($allurls->vimeo))?$allurls->vimeo:"").'"  placeholder="Enter URL for Vimeo " readonly />
						</div>
						
						';
						
						
						$response .='
						
                    </div>';
					
					
 

  }

  
  echo $response;
exit;
}