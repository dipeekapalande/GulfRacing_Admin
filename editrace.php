<?php
ob_start();
	include_once('config\config.php');
	include_once('inc\header.php');
	include_once('inc\aside.php');
	
	
	if(isset($_POST['submit'])){

	   $id = $_POST['id'];
	   $racename=$_POST['racename'];
	   $racedate=$_POST['racedate'];
	   
	   $d=new MongoDB\BSON\UTCDateTime((new DateTime($racedate))->getTimestamp()*1000);
	   $racetime=$_POST['racetime'];
	   
	    $t=new MongoDB\BSON\UTCDateTime((new DateTime($racetime))->getTimestamp()*1000);
		
		$duration=$_POST['duration'];
		
		$durationtime=new MongoDB\BSON\UTCDateTime((new DateTime($duration))->getTimestamp()*1000);
		
	   $isTrending=$_POST['isTrending'];
	   if($isTrending=="true")
		  {
			  $s=true;
		  }
		  else
		  {
			  $s=false;
		  }
	   
	   $length=$_POST['length'];
	   
	   $lowurl=$_POST['lowurl'];
	   $mediumurl=$_POST['mediumurl'];
	   $highurl=$_POST['highurl'];
	   $ultrahighurl=$_POST['ultrahighurl'];
	   $youtubeurl=$_POST['youtubeurl'];
	   $vimeourl=$_POST['vimeourl'];
	   
       $channelid=new MongoDB\BSON\ObjectId($_POST['channel_name']);
		
		$oldcamellist =$_POST['oldcamellist'];
    	$urlarray = array(
		  'low'  => $lowurl,
		  'med'  => $mediumurl,
		  'high'  => $highurl,
		  'ultra_high'  => $ultrahighurl,
		  'youtube'  => $youtubeurl,
		  'vimeo'  => $vimeourl
   
		);	
		
$camellist=$_POST['camellist'];
$camellist22=array();
if(empty($camellist))
{
	$oldcamellist=explode(',',$oldcamellist);
	foreach($oldcamellist as $key=>$c)
	{
		$camellist22[]=array(
		'_id'=>new MongoDB\BSON\ObjectId(),
		'camelid'=>new MongoDB\BSON\ObjectId($c),
		'nomination'=>array()
		);
		
	}
}
else
{
	if(empty($oldcamellist))
	{
		$newcamellist=explode(',',$camellist);
		

		foreach($newcamellist as $key=>$c)
		{
			$camellist22[]=array(
			'_id'=>new MongoDB\BSON\ObjectId(),
			'camelid'=>new MongoDB\BSON\ObjectId($c),
			'nomination'=>array()
			);
			
		}
	}
	else{
	$oldcamellist=explode(',',$oldcamellist);
	$newcamellist=explode(',',$camellist);
	$result = array_merge($oldcamellist, $newcamellist);

	foreach($result as $key=>$c)
	{
		$camellist22[]=array(
		'_id'=>new MongoDB\BSON\ObjectId(),
		'camelid'=>new MongoDB\BSON\ObjectId($c),
		'nomination'=>array()
		);
		
	}
	}

}	 

//Image Upload
	
	if($_FILES['image']['name']!="")
	{
				$imagename = $_FILES['image']['name'];
			    $imagePath = $_FILES['image']['tmp_name'];
			    $newName   = rand().$imagename;
    			move_uploaded_file($imagePath,"images/".$newName);
	}
	else
	{
		if($_POST['oldimage']=='')
		{
			$newName='';
		}
		else{
		$newName=$_POST['oldimage'];
		}
	}
    	   
	
						  if(!$isTrending){
					  
							$flag = 5;

						  }else{
							 
							 
								$insRec       = new MongoDB\Driver\BulkWrite;


							  
								$insRec->update(['_id'=>new MongoDB\BSON\ObjectID($id)],['$set' =>['racename'=>$racename,'racedate'=>$d,'racetime'=>$t,'duration'=>$durationtime,'isTrending'=>$s,'length'=>(double)$length,'channelid'=>$channelid,'camellist'=>$camellist22,'coverimage'=>$newName]], ['multi' => false, 'upsert' => false]);

										  
								$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

										 
								 $result = $connection->executeBulkWrite('gulf_racing.races', $insRec, $writeConcern);

							  if($result->getModifiedCount()){

								$flag = 3;

							  }else{

								$flag = 6;

							  }
							  
						  }
				
	
	  //echo $flag;
	 // die();
	header("Location: race.php?flag=$flag");

    exit;

	
  

  }
?>
<style>


.nav-tabs-custom>.nav-tabs>li.active {
    border-top-color: #3c8dbc;
    border-left: 3px solid #3c8dbc;
    border-right: 3px solid #3c8dbc;
}
.nav-tabs-custom>.nav-tabs {
   
    border-bottom-color: #3c8dbc;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       تحرير السباق / Edit Race
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">السباق / Race</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>
<!-- END ALERTS AND CALLOUTS -->
     
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <!--<h3 class="box-title">Data Table With Full Features</h3>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
			 <!-- START CUSTOM TABS -->
      <h2 class="page-header">تغيير تفاصيل السباق / Change Race Details</h2>

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active" style="font-size: 20px;font-weight: 600;"><a href="#tab_1" data-toggle="tab">تفاصيل السباق الأساسية / Race Basic Details</a></li>
              <li><a href="#tab_2" data-toggle="tab" style="font-size: 20px;font-weight: 600;">بث مباشر عناوين المواقع وإضافة الجمال / Live Streaming Urls  And Add Camels</a></li>
              
             
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <br>
				<?php
					$id    = $_GET['id'];

					$result = array();

					if($id){

					  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

					  $options = [];

					  $query = new MongoDB\Driver\Query($filter,$options);

					  $cursor = $connection->executeQuery('gulf_racing.races', $query);
					  
					foreach($cursor as $row){
						//print_r($row);
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
				?>
				<form enctype="multipart/form-data" method="POST">
                    <div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="<?php echo $row->_id;?>"/>
							
						
						<input type="hidden" name="oldimage" value="<?=((!empty($row->coverimage))?$row->coverimage:"")?>"/>
						
						<div class="col-sm-6">
							<label for="racename">اسم السباق / (Race Name)</label>
							<input type="text" class="form-control" id="racename" name="racename" value="<?php if (!empty($row->racename)) { echo $row->racename;} else { echo "";}?>"  placeholder="Enter Race Name" required />
						</div>
						<div class="col-sm-6">
							<label for="racedate">تاريخ السباق / (Race Date)</label>
							<input type="date" class="form-control" id="racedate" name="racedate" value="<?php echo $dateInLocal;?>" placeholder="Enter Race Date" required />
						</div>
						
						<div class="col-sm-6">
							<label for="racetime"> سباق الوقت / Race Time</label>
							<input type="time" class="form-control" id="racetime" name="racetime" value="<?php if (!empty($row->racetime)) { echo $dateInLocal1;} else { echo "";}?>"  placeholder="Enter Race Time" required />
							
						</div>
						
						<div class="col-sm-6">
							<label for="duration">المدة (بالدقائق )  / Duration (Hour:Minute:Seconds:Milliseconds)</label>
							<input type="time" class="form-control" id="duration" name="duration" list="limittimeslist" step="0.001" value="<?php if (!empty($row->duration)) { echo $dateInLocal2;} else { echo "";}?>"  placeholder="Enter Duration in Minutes" required />
							
							
							
						</div>
						<div class="col-sm-6">
							<label for="status">اسم القناة / (Channel name)</label>
							
							<select class="form-control" class="channel_name" id="select2" name="channel_name" class="required">
								<option value="" selected="">حدد القناة / Select Channel</option>
									<?php
										$filter = [];
										$options = ['sort' => ['position' => -1]];	
										$query=new MongoDB\Driver\Query($filter,$options);
										$cursor=$connection->executeQuery("gulf_racing.channels",$query);
										
										foreach($cursor as $document)
										{
									?>
											<option value="<?php echo $document->_id;?>" <?php if(!empty($row->isTrending)){if ($row->channelid==$document->_id) { echo "selected=selected";}} else { echo "Select Status";}?>><?php echo $document->channelheader;?></option>
									<?php
										}
									?>
								
							</select>
							
						</div>
							
						
						<div class="col-sm-6">
							<label for="isTrending">حالة الاتجاه / (Trending Status)</label>
							
							<select class="form-control" id="isTrending" name="isTrending" class="required">
								<option value="" selected="">Select Status</option>
								<option value="true" <?php if(!empty($row->isTrending)){if ($row->isTrending==true) { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="false" <?php if(!empty($row->isTrending)){if ($row->isTrending==false) { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
						</div>
					
						<div class="col-sm-6">
							<label for="length">الطول ( بالمايلز ) / Length ( In Miles )</label>
							<input type="text" class="form-control" id="length" name="length" value="<?php if (!empty($row->length)) { echo $row->length;} else { echo "";}?>"  placeholder="Enter Length of race in Miles" required />
						</div>
						
						<div class="col-sm-6">
								 
								 <input type="submit" class="btn btn-success" value="submit" name="submit" style="margin-top:2%">
							</div>
				
              </div>
			  </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               <div class="col-md-12 col-sm-12">
							<br><br><br><br>
						</div>
								<?php
										
										$allurls=$row->live_stream_urls;
										//echo "<pre>";
										//print_r($allurls);
										//echo $allurls->high;
										
									?>
						<div class="col-sm-6">
							<label for="lowurl">منخفضه / Low</label>
							<input type="text" class="form-control" id="lowurl" name="lowurl" value="<?php if (!empty($allurls->low)) { echo $allurls->low;} else { echo "";}?>"  placeholder="Enter URL for Low Resolution" readonly />
						</div>
						<div class="col-sm-6">
							<label for="mediumurl">متوسط / Medium</label>
							<input type="text" class="form-control" id="mediumurl" name="mediumurl" value="<?php if (!empty($allurls->med)) { echo $allurls->med;} else { echo "";}?>"  placeholder="Enter URL for Medium Resolution" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="highurl">عاليه / High</label>
							<input type="text" class="form-control" id="highurl" name="highurl" value="<?php if (!empty($allurls->high)) { echo $allurls->high;} else { echo "";}?>"  placeholder="Enter URL for High Resolution" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="ultrahighurl">عالية جدا / Ultra High</label>
							<input type="text" class="form-control" id="ultrahighurl" name="ultrahighurl" value="<?php if (!empty($allurls->ultra_high)) { echo $allurls->ultra_high;} else { echo "";}?>"  placeholder="Enter URL for Ultra High Resolution" readonly />
						</div>
						
						<div class="col-sm-6">
							<label for="youtubeurl">يوتيوب / Youtube</label>
							<input type="text" class="form-control" id="youtubeurl" name="youtubeurl" value="<?php if (!empty($allurls->youtube)) { echo $allurls->youtube;} else { echo "";}?>"  placeholder="Enter URL for Youtube " readonly />
						</div>
					    <div class="col-sm-6">
							<label for="vimeourl">فيميو  / Vimeo</label>
							<input type="text" class="form-control" id="vimeourl" name="vimeourl" value="<?php if (!empty($allurls->vimeo)) { echo $allurls->vimeo;} else { echo "";}?>"  placeholder="Enter URL for Vimeo " readonly />
						</div>
						
						<div class="col-sm-6">
							<label class="control-label" for="inputPatient">صورة غطاء السباق / (Race Cover Picture)</label>
							<div class="field desc">
								<input class="form-control" id="image" name="image" placeholder="Image" type="file" onchange="return validateimage();">
							</div>
						</div>
						<!-- Image preview -->
						<img src="<?php echo "images/".((!empty($row->coverimage))?$row->coverimage:"noimage.jfif");?>" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin:2% 0%" id="oldimagepreview">
						<div id="imagePreview"></div>
						
						
						<?php
							$camellist=$row->camellist;
							
							$listc=array_column($camellist,'camelid');
							$abc=implode(",",$listc);
							
						?>
						<div class="col-sm-12">
						<input type="hidden" name="oldcamellist" class="oldcamellist form-control" value="<?=$abc?>">
							<label for="addcamels">قوائم الجمل القديمة / Old Camel Lists</label>
							<div id="myItemListold">
								<ul>
									<?php
									foreach($listc as $ca)
									{
										 $filtercamel = ['_id' => new MongoDB\BSON\ObjectID($ca)];

										  $optionscamel = [];

										  $querycamel = new MongoDB\Driver\Query($filtercamel,$optionscamel);

										  $cursorcamel = $connection->executeQuery('gulf_racing.camels', $querycamel);
										  foreach($cursorcamel as $cucam)
											{
										?>
										<li><?=$cucam->camelname?> - <?=$cucam->camelnumber?></li>
										<?php
											}
									}
									?>
								</ul>
							</div>
							
						</div>
						<div class="col-sm-12">
						
							<label for="addcamels">قوائم الجمل المضافة / Added Camel Lists</label>
							<div id="displayaddedcamelslist">
							</div>
							<input type="hidden" name="camellist" class="camellist form-control" >
						</div>
						<div class="col-sm-12">
							<label for="addcamels">إضافة الجمال / Add Camels</label>
							<!-- Search box. -->
						   <input type="text" id="search" placeholder="Search here ..." class="form-control"/>
						   <br>
						    <b>Note / ملاحظه: </b><i>الرجاء إدخال رقم الجمل فقط / Please Enter camel number only</i>
						   <br />
						   <!-- Suggestions will be displayed in below div. -->
						   <div id="display"></div>

						</div>
						
					
							<div class="col-sm-6">
								 
								 <input type="submit" class="btn btn-success" value="submit" name="submit" style="margin-top:2%">
							</div>
						
                    </div>
                 
					
				
                </form>
				<?php
					}
					}
				  ?>
                
              </div>
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

     
      </div>
      <!-- /.row -->
      <!-- END CUSTOM TABS -->
              
				
			  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
		
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
		include('inc/footer.php');
  ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
//Getting value from "ajax.php".
function fill(Value) {
   //Assigning value to "search" div in "search.php" file.
   $('#search').val(Value);
   //Hiding "display" div in "search.php" file.
   $('#display').hide();
}
$(document).ready(function() {
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
   $("#search").keyup(function() {
       //Assigning search box value to javascript variable named as "name".
       var name = $('#search').val();
       //Validating, if "name" is empty.
       if (name == "") {
           //Assigning empty value to "display" div in "search.php" file.
           $("#display").html("");
       }
       //If name is not empty.
       else {
           //AJAX is called.
           $.ajax({
               //AJAX type is "Post".
               type: "POST",
               //Data will be sent to "ajax.php".
               url: "ajax/checkcamel.php",
               //Data, that will be sent to "ajax.php".
               data: {
                   //Assigning value of "name" into "search" variable.
                   search: name
               },
               //If result found, this funtion will be called.
               success: function(html) {
                   //Assigning result to "display" div in "search.php" file.
                   $("#display").html(html).show();
               }
           });
       }
   });
});

var camels=[];

function addcamelRow() {
	$('div.camelitems').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				//$(item).remove();
				
				camels.push($(this).val());
            }
        });
	});
	
	$(".camellist").val(camels);
	
	console.log( camels );
	
	$.ajax({
               //AJAX type is "Post".
               type: "POST",
               //Data will be sent to "ajax.php".
               url: "ajax/showaddedcamel.php",
               //Data, that will be sent to "ajax.php".
               data: {
                   //Assigning value of "name" into "search" variable.
                   listcam: camels
               },
               //If result found, this funtion will be called.
               success: function(html) {
				 //  alert(html);
                   //Assigning result to "display" div in "search.php" file.
                   $("#displayaddedcamelslist").html(html).show();
               }
           });
   /* ul = document.createElement('ul');

	document.getElementById('myItemList').appendChild(ul);

	camels.forEach(function (item) {
		let li = document.createElement('li');
		ul.appendChild(li);

		li.innerHTML += item;
	});*/
}
	</script>
<script>
function submitofferForm(){
   
	var postData = new FormData($("#modal_form_id")[0]);
    
  
        $.ajax({
            type:'POST',
            url:'addcategory.php',
           processData: false,
                                 contentType: false,
                                 data : postData,
                                 success:function(data){
									 
                              		console.log(data);
									window.location.href="category.php";
                                 }
		});
	
	}
	
	 //Validate image formats
  //By Dipeeka Palande
  //on 6th January 2020
  function validateimage()
  {
	  var eventimage=$("#image").val();
	 
	  var ValidFileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF', 'bmp', 'BMP'];
	    if ($.inArray(eventimage.split('.').pop().toLowerCase(), ValidFileExtension) == -1) {
            alert("Sorry !!! Allowed image formats are '.jpeg','.jpg', '.png', '.gif', '.bmp'.Please select image file only");
			$("#image").val('');
			$("#image").focus();
			return false;
        }
		else
		{
			$("#oldimagepreview").hide();
			//Image preview
			var fileInput = document.getElementById('image');
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"  style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin:2% 0%"/>';
				};
				reader.readAsDataURL(fileInput.files[0]);
			}
		}
	  
	  
  }
</script>
</body>
</html>
