<?php
ob_start();
	include_once('config\config.php');
	include_once('inc\header.php');
	include_once('inc\aside.php');
	
	
	if(isset($_POST['submit'])){
	  
	  $eventname=$_POST['eventname'];
	 
	  $event_status  = $_POST['event_status'];
	  
	  $alldate=$_POST['alldate'];
	  
	  
	  
	  
	
	  if (empty($_POST['alldate'])) {
     
	
	 echo "here";
		
		$newdatelist = $_POST['olddatelist'];
	 }
	 else
	 {
			$newdatelist= $_POST['olddatelist'];
			 foreach($alldate as $c)
			 {
				 $newdatelist[]=new MongoDB\BSON\UTCDateTime((new DateTime($c))->getTimestamp()*1000);
				 
			 }
	 }
	  print_r($newdatelist);
	  die();
	  $today=date('Y-m-d');
	  $d=new MongoDB\BSON\UTCDateTime((new DateTime($today))->getTimestamp()*1000);
	  
      if($event_status==1)
	  {
		  $s=true;
	  }
	  else
	  {
		  $s=false;
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
		$newName=$_POST['oldimage'];
	}
    			    
	
						  if(!$event_status){
					  
							$flag = 5;

						  }else{
							 
							 
								$insRec       = new MongoDB\Driver\BulkWrite;

							  
								$insRec->update(['_id'=>new MongoDB\BSON\ObjectID($id)],['$set' =>['eventname'=>$eventname,'event_status' =>$s,'image'=>$newName,'created_date'=>$d,'alldates'=>$newdatelist]], ['multi' => false, 'upsert' => false]);

										  
								$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

										 
								 $result = $connection->executeBulkWrite('gulf_racing.camels', $insRec, $writeConcern);

							  if($result->getModifiedCount()){

								$flag = 3;

							  }else{

								$flag = 2;

							  }
							  
						  }
				
	
	  //echo $flag;
	 // die();
	header("Location: events.php?flag=$flag");

    exit;

	
  

  }
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Event
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Event</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>

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
              
				<?php
					$id    = $_GET['id'];

					$result = array();

					if($id){

					  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

					  $options = [];

					  $query = new MongoDB\Driver\Query($filter,$options);

					  $cursor = $connection->executeQuery('gulf_racing.events', $query);
					  
					foreach($cursor as $row){
						$alldatesarray=$row->alldates;
				?>
				<form enctype="multipart/form-data" method="POST">
                    <div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="<?php echo $row->_id;?>"/>
							
						
						<input type="hidden" name="oldimage" value="<?=((!empty($row->image))?$row->image:"")?>"/>
						<?php
							foreach($alldatesarray as $value)
							{
								echo '<input type="hidden" name="olddatelist[]" value="'. $value. '">';
							}
						?>
						<div class="col-sm-6">
							<label for="eventname">Event Name</label>
							<input type="text" class="form-control" id="eventname" name="eventname" value="<?php if (!empty($row->eventname)) { echo $row->eventname;} else { echo "";}?>"  placeholder="Enter Event Name" required />
						</div>
						
						<div class="col-sm-6">
							<label for="status">Event Status</label>
							
							<select class="form-control" id="event_status" name="event_status" class="required">
								<!--<option value="" selected="">Select Status</option>-->
								<option value="1" <?php if(!empty($row->event_status)){if ($row->event_status==true) { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="2" <?php if(!empty($row->event_status)){if ($row->event_status==false) { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
						</div>
						
						
						<div class="col-sm-6">
							<label class="control-label" for="inputPatient">Event Logo</label>
							<div class="field desc">
								<input class="form-control" id="image" name="image" placeholder="Image" type="file" onchange="return validateimage();"  required>
							</div>
						</div>
						<div class="col-sm-6">
							<!-- Image preview -->
							<div id="imagePreview"></div>
						</div>
						<div class="col-sm-6">
							<label for="status">Old Dates</label><br>
							<ul>
							<?php
							foreach($row->alldates as $ad)
							{
								$timestamp = $ad->__toString();							
								$utcdatetime = new MongoDB\BSON\UTCDateTime($timestamp);
								$datetime = $utcdatetime->toDateTime();
								$time=$datetime->format(DATE_RSS);
								/********************Convert time local timezone*******************/

								$dateInUTC=$time;
								$time = strtotime($dateInUTC.' UTC');
								$dateInLocal = date("d-m-Y", $time);
								
							?>
							
							  
							  <li><span class="label label-warning" style="font-size:12px;"><?=$dateInLocal?></span> <button type="button" class='delete btn btn-danger' id='del_<?= $ad ?>' data-id='<?= $ad ?>' >x</button></li>

							  
								<br><br>
							<?php
								
							}
							?>
							</ul>
						</div>
							<div class="col-sm-6">	
									<DIV id="product">
										<?php /*require_once("dateevent.php");*/ ?>
									</DIV>
									<DIV class="btn-action float-clear col-sm-4">
										<input type="button" name="add_item" value="Add More" onClick="addMore();" class="btn btn-success" />
										<input type="button" name="del_item" value="Delete" onClick="deleteRow();"  class="btn btn-danger"/>
										<span class="success"><?php if(isset($message)) { echo $message; }?></span>
									</DIV>
							</div>
						
					
							<div class="col-sm-12">
								 
								 <input type="submit" class="btn btn-success" value="submit" name="submit" style="margin-top:2%">
							</div>
						
                    </div>
                 
					
				
                </form>
				<?php
					}
					}
				  ?>
                
			  
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
$(document).ready(function(){
	
	// Delete 
		  $('.delete').click(function(){
			var el = this;
		  
			// Delete id
			var deleteid = $(this).data('id');
			var eventid=$("#uid").val();
			
			alert(deleteid);
			alert(eventid);
			var con=confirm("Are You Sure to Delete");
					if(con==true)
					{
						window.location.href="deleteeventdate.php?id="+deleteid+"&eventid="+eventid;
					}
					else
					{
						return false;
					}
			});
});
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
