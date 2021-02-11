<?php
	include('config/config.php');
	include('inc/header.php');
	include('inc/aside.php');
	
	$filter = [];
	$options = ['sort' => ['position' => -1]];	
	$query=new MongoDB\Driver\Query($filter,$options);
	$cursor=$connection->executeQuery("gulf_racing.channels",$query);
	
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
                <h4 class="modal-title" id="myModalLabel">Channels Details</h4>
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
        Channels 
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Channels</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
				<a href="addchannel.php"><button class="btn btn-success">
   Add Channel
</button></a>
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
              <table id="example1" class="table table-bordered table-striped" style="margin-top:3%">
                <thead style="background: #00BCD4;;">
                <tr>
					  <th>Sr.No</th>
					  <th>Logo</th>
					  <th>Channel Header</th>
					  <th>Channel Sub Header</th>
					  <th>Location</th>
					  <th>Event name</th>
					  <th>Channel Status</th>
				      <th>Action</th>
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
				
				
					
				  ?>
                <tr>
					<td><?php echo ++$id; ?></td>
					<td>
								<img src="images/<?=((!empty($document->image))?$document->image:"noimage.jfif")?>" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin-bottom:15%">
					</td>		
                  <td>
						<?php if (!empty($document->channelheader)) {
								 // do something
								 echo $document->channelheader;
								}
						?>
				  
				  
				 </td>
                  <td>
						<?php if (!empty($document->channelsubheader)) {
								 // do something
								 echo $document->channelsubheader;
								}
						?>
				  </td>
				  
				  <td>
						<?php if (!empty($document->location)) {
								 // do something
								 echo $document->location;
								}
						?>
				  </td>
				
					<td>
						<?php if (!empty($document->eventname)) {
								 // do something
								 echo $document->eventname;
								}
						?>
				  </td>
				
				  
				   <td>
				   
						<?php if (!empty($document->channel_status)) {
								 // do something
								
									 if ($document->channel_status==true)
									 {
											 echo 'Active';
									 }
									 else
									 {
										 echo "In Active";
									 }
									 
								}
								else
								{
										echo "In Active";
								}
						?>
						
				  </td>
					 
				  <td>
				  
				 <!-- <a class='editlink' data-id=<?php echo $document->_id; ?> 
             href='javascript:void(0)'>View</a> -->
			  <!--<button class="btn btn-success userdetails" data-id=<?php echo $document->_id; ?>>
 <i class="fa fa-eye"></i> View
</button> -->

			 <a href="editchannel.php?id=<?php echo $document->_id;  ?>" title="Edit" style="margin-right:3%;margin-left:2%;" class="btn btn-info"><i class="fa fa-pencil-square"></i>  Edit</a>
			 
			 
			 <button class='delete btn btn-danger' id='del_<?= $document->_id ?>' data-id='<?= $document->_id ?>' >Delete</button>
			 
			 
       <!-- <button type="button" onclick ="return confirmdelete(<?=$document->_id?>)" 
         class="btn btn-danger"><i class="fa fa-trash"></i>  Delete </button>-->
		 
		 
		 </td>

				  <!--<a href="editbutton.php?uid=<?php echo $res['user_id']; ?>" title="Edit" style="margin-right:3%;margin-left:2%;"><i class="fa fa-pencil-square" aria-hidden="true"style="font-size:20px;color:green;"></i></a>
											<a href="deletebutton.php?uid=<?php echo $res['user_id']; ?>" onclick="return confirm('Are you sure?')" title="Delete" style="margin-right:3%;margin-left:2%;"><i class="fa fa-trash-o" aria-hidden="true"style="font-size:20px;color:red;"></i></a>-->
                 
					
                </tr>
               
                 <?php
					}
					?>
              </table>
			 
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
				url: 'fetchdatachannel.php',
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
						window.location.href="deletechannel.php?id="+deleteid;
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
