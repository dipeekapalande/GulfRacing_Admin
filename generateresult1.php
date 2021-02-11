<?php
ob_start();
	include('config/config.php');
	include('inc/header.php');
	include('inc/aside.php');
	$id=$_REQUEST['id'];
	$filter = ["_id"=>new MongoDB\BSON\ObjectID($id)];
	$options = ['sort' => ['_id' => -1]];	
	$query=new MongoDB\Driver\Query($filter,$options);
	$cursor=$connection->executeQuery("gulf_racing.races",$query);
	if($_POST['submit'])
	{
		$duration=$_POST['duration'];
		
		$raceid=$_POST['raceid'];
		$raceid=new MongoDB\BSON\ObjectId($raceid);
		/*echo "<pre>";
		print_r($duration);
		echo "</pre>";
		echo "<pre>";
		print_r($_POST['camelid']);
		echo "</pre>";
		die();*/
		//Get Camel Id
		 $camellist=$_POST['camelid'];
	  
		  $newcamellist=array();
		 foreach($camellist as $c)
		 {
			 $newcamellist[]=new MongoDB\BSON\ObjectId($c);
		 }
		 
		 //Get Duration in timestamp
		 $newduration=array();
		 foreach($duration as $dr)
		 {
			$newduration[]=new MongoDB\BSON\UTCDateTime((new DateTime($dr))->getTimestamp()*1000);
		
		 }
		 //Get Camel name array
		 
		 $camelname=$_POST['camelname'];
		  
		  //Get Camel number array
		 
		 $camelnumber=$_POST['camelnumber'];
		 
		 $resultarray=array();
		 $i=0;
		 foreach($newcamellist as $newcamel)
		 {
			 $resultarray[]=array(
				'_id'=>new MongoDB\BSON\ObjectId(),
				'camelid'=>$newcamel,
				'duration'=>$newduration[$i],
				'camelname'=>$camelname[$i],
				'camelnumber'=>$camelnumber[$i]
			 );
			  $i++;
		 }
		 
		 //Insert the result into the table
			 $insRec       = new MongoDB\Driver\BulkWrite;

           $insRec->insert(['raceid'=>$raceid,'result'=>$resultarray]);
          
           $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
         
             $result       = $connection->executeBulkWrite('gulf_racing.raceresults', $insRec, $writeConcern);

			 
			  
		//Update Race Status
		 
								$updateRec       = new MongoDB\Driver\BulkWrite;

								$updateRec->update(['_id'=>new MongoDB\BSON\ObjectID($raceid)],['$set' =>['resultstatus'=>true]], ['multi' => false, 'upsert' => false]);
							  
							  		  
								$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

										 
								 $result = $connection->executeBulkWrite('gulf_racing.races', $updateRec, $writeConcern);
		 
		header("Location: raceresult.php");

    exit; 
	}
	
?>
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Camels Details</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body" >
			   
            </div>
            
            <!-- Modal Footer -->
			 <div class="modal-footer">
				
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-top: 4%;">Close</button>
                <!--<button type="button" class="btn btn-primary submitBtn" onclick="submitForm()" style="margin-top: 2%;">SUBMIT</button>-->
					 
            </div>
        </div>
    </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Camel 
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Camels</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
				
			<?php
			
			
				$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;

				$message ='';

				if($flag){

				  $message = $messages[$flag];
			?>
					
					
					<div class="alert alert-warning alert-dismissible show" role="alert">
					  <strong><?php echo $message;?></strong> 
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
			<?php
					

				}
			?>
              <!--<h3 class="box-title">Data Table With Full Features</h3>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<form enctype="multipart/form-data" method="POST">
				<input type="hidden" name="raceid" value="<?=$_REQUEST['id']?>">
             <!-- <table id="example1" class="table table-bordered table-striped" style="margin-top:3%">-->
			    <table id="" class="table table-bordered table-striped" style="margin-top:3%">
				<div class="col-sm-6">
										 
					<input type="submit" class="btn btn-success" value="submit" name="submit" style="margin-top:2%">
				</div>
                <thead style="background: #00BCD4;;">
                <tr>
					  <th class="sorting_desc">Sr.No</th>
					  <th>Camel Number</th>
					  <th>Camel Name</th>
					  
					  
					  <th>Add Duration (Hour : Minute : Seconds : Miliseconds)</th>
				      
                </tr>
                </thead>
                <tbody>
				<?php
					$dir="uploads";
					$id=0;
					/*$query="Select * from user order by user_id desc";
					$result=mysqli_query($con,$query)or die(mysqli_error($con));*/
					
				foreach($cursor as $document)
				{
				$innerArray=$document->camellist;
				//print_r($innerArray);
				$id_array = array_column($innerArray, 'camelid');

				//print_r($id_array);

				foreach($id_array as $c1)
				{ 
								$filter1 = ["_id"=>new MongoDB\BSON\ObjectID($c1)];
								$options1 = ['sort' => ['_id' => -1]];	
								$query1=new MongoDB\Driver\Query($filter1,$options1);
								$cursor1=$connection->executeQuery("gulf_racing.camels",$query1);
						foreach($cursor1 as $c11)
						{		
								
				/* if (is_array($innerArray)){
						//  Scan through inner loop
						foreach ($innerArray as $value) {
							
							foreach($value as $v)
							{
								print_r($v);
								
								
							}
						}
					}else{
						// one, two, three
						//echo $innerArray;
					}*/
					
				  ?>
                <tr>
					<td><?php echo ++$id; ?></td>
                  <td>
						<?php if (!empty($c11->camelnumber)) {
								 // do something
								 echo $c11->camelnumber;
								}
						?>
				  
				  
				 </td>
                  <td>
						<?php if (!empty($c11->camelname)) {
								 // do something
								 echo $c11->camelname;
								}
						?>
				  </td>
				  <td>
						
						<input type="hidden" name="camelid[]" value="<?=((!empty($c11->_id))?$c11->_id:'')?>">
						<input type="hidden" name="camelnumber[]" value="<?=((!empty($c11->camelnumber))?$c11->camelnumber:'')?>">
						<input type="hidden" name="camelname[]" value="<?=((!empty($c11->camelname))?$c11->camelname:'')?>">
							<input type="time" class="form-control" id="duration" name="duration[]" list="limittimeslist" step="0.001" value="<?php if (!empty($row->duration)) { echo $row->duration;} else { echo "";}?>"  placeholder="Enter Duration in Minutes" required />
							
						
				 </td>
				
				
					
                </tr>
               
                 <?php
				}
				}
				}
					?>
              </table>
			 </form>
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
	$(document).ready(function(){
		$(".userdetails").click(function(){
			var uid=$(this).attr('data-id');
			
			 // AJAX request
			   $.ajax({
				url: 'fetchdatacamel.php',
				type: 'post',
				data: {uid: uid},
				success: function(response){ 
				//alert(response);
				  // Add response in Modal body
				  $('.modal-body').html(response);

				  // Display Modal
				  $('#modalForm').modal('show'); 
				}
			  });
			
		});
		
		$(".deletebutton").click(function(){
			var uid=this.id;
			var con=confirm("Are You Sure to Delete");
			if(con==true)
			{
				window.location.href="deletebutton.php?uid="+uid;
			}
			else
			{
				return false;
			}
				
		});
		
		 // Delete 
		  $('.delete').click(function(){
			var el = this;
		  
			// Delete id
			var deleteid = $(this).data('id');
			
			//alert(deleteid);
			
			var con=confirm("Are You Sure to Delete");
					if(con==true)
					{
						window.location.href="deletecamel.php?id="+deleteid;
					}
					else
					{
						return false;
					}
			});
		
	
	});
</script>
<script>
  $(function () {
    $('#example1').DataTable
	({ 
       "order": [[ 0, "asc" ]] 
    }); 
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
function submitForm(){
   
	var postData = new FormData($("#modal_form_id")[0]);
    
  
        $.ajax({
            type:'POST',
            url:'adduser.php',
           processData: false,
                                 contentType: false,
                                 data : postData,
                                 success:function(data){
									 
                              		console.log(data);
									window.location.href="user.php";
                                 }
		});
	
	}
</script>


</body>
</html>
