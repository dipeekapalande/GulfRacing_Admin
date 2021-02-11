<?php
ob_start();
	include_once('config\config.php');
	include_once('inc\header.php');
	include_once('inc\aside.php');
	
	
	if(isset($_POST['submit'])){
	
	
	
	
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
	   
	   
		$urlarray = array(
		  'low'  => $lowurl,
		  'med'  => $mediumurl,
		  'high'  => $highurl,
		  'ultra_high'  => $ultrahighurl,
		  'youtube'  => $youtubeurl,
		  'vimeo'  => $vimeourl,
   
		);

$camellist=$_POST['camellist'];
$camellist22=array();
if(empty($camellist))
{
}
else
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

/*foreach($newcamellist as $key2=>$c) {
   
         $camellist22[$key2]=$d;
    
}
print_r($camellist22);
die();
	   */
	   $camel_status=1;
	   /*$camellist=$_POST['camellist'];
	  
	  $newcamellist=array();
	 foreach($camellist as $c)
	 {
		 $newcamellist[]=new MongoDB\BSON\ObjectId($c);
	 }*/
		
		$channelid=new MongoDB\BSON\ObjectId($_POST['channel_name']);
	  /*$gender=$_POST['gender'];
      $fathername=$_POST['fathername'];
	  $mothername=$_POST['mothername'];
      
	  $owner_id=$_POST['owner_name'];
	  
	  $own=new MongoDB\BSON\ObjectId($owner_id);
	   
	   
	  $camel_status  = $_POST['camel_status'];
      if($camel_status==1)
	  {
		  $s=true;
	  }
	  else
	  {
		  $s=false;
	  }*/
	
		 //Image Upload
				$imagename = $_FILES['image']['name'];
				if($imagename=='')
				{
					$newName='';
				}
				else{
					$imagePath = $_FILES['image']['tmp_name'];
					$newName   = rand().$imagename;
    			    move_uploaded_file($imagePath,"images/".$newName);
    			    
				}		
	  

      if(!$camel_status){
  
        $flag = 5;

      }else{
		  
		 
         
           $insRec = new MongoDB\Driver\BulkWrite;
		   
		   //$answers->update(array('userId' => 1, 'questions.questionId' => '1'), array('$push' => array('questions.$.ans' => 'try2')));

           $insRec->insert(['racename'=>$racename,'racedate'=>$d,'racetime'=>$t,'duration'=>$durationtime,'isTrending'=>$s,'length'=>(double)$length,'channelid'=>$channelid,'live_stream_urls'=>$urlarray,'camellist'=>$camellist22,'coverimage'=>$newName]);
          
           $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
         
             $result       = $connection->executeBulkWrite('gulf_racing.races', $insRec, $writeConcern);

          if($result->getInsertedCount()){

            $flag = 3;

          }else{

            $flag = 2;

          }
		  
      }
					
	  //echo $flag;
	 // die();
	header("Location: race.php?flag=$flag");

    exit;

	
  

  }
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     إضافة سباق /   Add Race
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">سباق / Race </a></li>
        <li class="active">Add</li>
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
              
				
				<form enctype="multipart/form-data" method="POST">
                    <div class="form-group">
						<input type="hidden" class="form-control" id="uid" name="id" value="<?php echo $row->_id;?>"/>
						<div class="col-sm-6">
							<label for="racename">اسم السباق / (Race Name)</label>
							<input type="text" class="form-control" id="racename" name="racename" value="<?php if (!empty($row->racename)) { echo $row->racename;} else { echo "";}?>"  placeholder="Enter Race Name" required />
						</div>
						<div class="col-sm-6">
							<label for="racedate">تاريخ السباق / (Race Date)</label>
							<input type="date" class="form-control" id="racedate" name="racedate" value="<?php if (!empty($row->racedate)) { echo $row->racedate;} else { echo "";}?>" placeholder="Enter Race Date" required />
						</div>
						
						<div class="col-sm-6">
							<label for="racetime">سباق الوقت / Race Time</label>
							<input type="time" class="form-control" id="racetime" name="racetime" value="<?php if (!empty($row->racetime)) { echo $row->racetime;} else { echo "";}?>"  placeholder="Enter Race Time" required />
						</div>
						
						<div class="col-sm-6">
							<!--<label for="duration">Duration (In Minutes )</label>
							<input type="text" class="form-control" id="duration" name="duration" value="<?php if (!empty($row->duration)) { echo $row->duration;} else { echo "";}?>"  placeholder="Enter Duration in Minutes" required />-->
							
							<label for="duration">المدة (بالدقائق )  / Duration (Hour:Minute:Seconds:Milliseconds)</label>
							<input type="time" class="form-control" id="duration" name="duration" list="limittimeslist" step="0.001" value="<?php if (!empty($row->duration)) { echo $row->duration;} else { echo "";}?>"  placeholder="Enter Duration in Minutes" required />
							
							
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
											<option value="<?php echo $document->_id;?>"><?php echo $document->channelheader;?></option>
									<?php
										}
									?>
								
							</select>
							
						</div>
						<!--<div class="container col-md-12">	
								<label for="status">Select Camels </label>
								<p>Please Check the Camels Which will take participate in the race</p>
						<div class="card-group"> 
				  
							//bootstrap card with 3 horizontal images
							<div class="row"> 
							
													<?php
														
														$filter1 = [];
														$options1 = ['sort' => ['position' => -1]];	
														$query1=new MongoDB\Driver\Query($filter1,$options1);
														$cursor1=$connection->executeQuery("gulf_racing.races",$query1);
														$newcamelarray=array();
														foreach($cursor1 as $d)
														{
															$newcamelarray[]=$d->camellist;
														}
														
														$arraySingle = call_user_func_array('array_merge', $newcamelarray);
														/*echo "<pre>";
														print_r($newcamelarray);
														print_r($arraySingle);
														die();*/
														$filter = [];
														$options = ['sort' => ['position' => -1]];	
														$query=new MongoDB\Driver\Query($filter,$options);
														$cursor=$connection->executeQuery("gulf_racing.camels",$query);
														foreach($cursor as $document)
														{
															//echo $document->_id;
															
															if(in_array($document->_id,$arraySingle))
															{
																//echo "here";
															}
														else{
													?>
															
													
													
															<div class="col-md-1">
																 <div class="checkbox">
																	<label><input type="checkbox" value="<?=$document->_id?>" name="camellist[]">  </label>
																</div>
																</div>
															<div class="card col-md-2"> 

																	<img src="<?php echo "images/".((!empty($document->image))?$document->image:"noimage.jfif");?>" class="card-img-top" style="width:150px;height:150px;border:1px solid gray;margin:8% 0%;" id="oldimagepreview">
																<div class="card-body"> 
																	<h3 class="card-title"><?=((!empty($document->camelnumber))?$document->camelnumber:"")?></h3> 
																	<p class="card-text"><?=((!empty($document->cameldescription))?$document->cameldescription:"")?></p> 
																</div> 
															</div> 
								<?php
														}
														}
													?>
													
													
								 
								
							
							</div>
						</div>
										
						</div>	-->			
						
						<div class="col-sm-6">
							<label for="isTrending">حالة الاتجاه / (Trending Status)</label>
							
							<select class="form-control" id="isTrending" name="isTrending" class="required">
								<option value="" selected="">Select Status</option>
								<option value="true" <?php if(!empty($row->isTrending)){if ($row->isTrending==true) { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="false" <?php if(!empty($row->isTrending)){if ($row->isTrending==false) { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
						</div>
					
						<div class="col-sm-6">
							<label for="length"> الطول ( بالمايلز ) / Length ( In Miles )</label>
							<input type="text" class="form-control" id="length" name="length" value="<?php if (!empty($row->length)) { echo $row->length;} else { echo "";}?>"  placeholder="Enter Length of race in Miles" required />
						</div>
						
						<div class="col-md-12 col-sm-12">
							<label for="racename">URL البث المباشر / Live Streaming Urls</label>
						</div>
						<div class="col-sm-6">
							<label for="lowurl">منخفضه / Low</label>
							<input type="text" class="form-control" id="lowurl" name="lowurl" value="<?php if (!empty($row->lowurl)) { echo $row->lowurl;} else { echo "";}?>"  placeholder="Enter URL for Low Resolution"  required />
						</div>
						<div class="col-sm-6">
							<label for="mediumurl">متوسط / Medium</label>
							<input type="text" class="form-control" id="mediumurl" name="mediumurl" value="<?php if (!empty($row->mediumurl)) { echo $row->mediumurl;} else { echo "";}?>"  placeholder="Enter URL for Medium Resolution" required />
						</div>
						
						<div class="col-sm-6">
							<label for="highurl">عاليه / High</label>
							<input type="text" class="form-control" id="highurl" name="highurl" value="<?php if (!empty($row->highurl)) { echo $row->highurl;} else { echo "";}?>"  placeholder="Enter URL for High Resolution" required />
						</div>
						
						<div class="col-sm-6">
							<label for="ultrahighurl">عالية جدا / Ultra High</label>
							<input type="text" class="form-control" id="ultrahighurl" name="ultrahighurl" value="<?php if (!empty($row->ultrahighurl)) { echo $row->ultrahighurl;} else { echo "";}?>"  placeholder="Enter URL for Ultra High Resolution" required />
						</div>
						
						<div class="col-sm-6">
							<label for="youtubeurl">يوتيوب / Youtube</label>
							<input type="text" class="form-control" id="youtubeurl" name="youtubeurl" value="<?php if (!empty($row->youtubeurl)) { echo $row->youtubeurl;} else { echo "";}?>"  placeholder="Enter URL for Youtube " required />
						</div>
					    <div class="col-sm-6">
							<label for="vimeourl">فيميو  / Vimeo</label>
							<input type="text" class="form-control" id="vimeourl" name="vimeourl" value="<?php if (!empty($row->vimeourl)) { echo $row->vimeourl;} else { echo "";}?>"  placeholder="Enter URL for Vimeo " required />
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="inputPatient"> صورة غطاء السباق / (Race Cover Picture)</label>
							<div class="field desc">
								<input class="form-control" id="image" name="image" placeholder="Image" type="file" onchange="return validateimage();"  >
							</div>
						</div>
						
						<div id="imagePreview"></div>
						
						<div class="col-sm-12">
						<br>
							<label for="addcamels">قوائم الجمل المضافة / Added Camel Lists</label>
							<div id="displayaddedcamelslist">
							<br>
							</div>
							<input type="hidden" name="camellist" class="camellist form-control">
						</div>
						<div class="col-sm-12">
						<br><br>
						<label for="addcamels">إضافة الجمال / Add Camels</label>
						<br>
						<!-- Search box. -->
						   <input type="text" id="search" placeholder="Search here ..." class="form-control"/>
						   <br>
						   <b>Note / ملاحظه: </b><i>الرجاء إدخال رقم الجمل فقط / Please Enter camel number only</i>
						   <br />
						   <!-- Suggestions will be displayed in below div. -->
						   <div id="display"></div>

						</div>

						<div class="col-sm-6">
								 
							<input type="submit" class="btn btn-success" value="submit" name="submit" style="margin-top:2%" onclick="return validate();">
						</div>
						
                    </div>
                 
					
				
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
     <script type="text/javascript" src="script.js"></script>
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
<script type="text/javascript">
    $("#select2").select2({
        templateResult: formatState
    });
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "flags";
        var $state = $(
            '<span> ' + state.text + '</span>'
        );
        return $state;
    }
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
	function onlyNumberKey(evt) { 
          
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
	function validate()
	{
		//alert("here");
		
		var camelnumber=$("#camelnumber").val();
		var cameldescription=$("#cameldescription").val();
		var age=$("#age").val();
		var fathername=$("#fathername").val();
		var mothername=$("#mothername").val();
		var image=$("#image").val();
		
		
		if(camelnumber.trim()=="")
		  {
			    alert("Please Enter the camel number");
				$("#camelnumber").val('');
				$("#camelnumber").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		if(cameldescription.trim()=="")
		  {
			    alert("Please Enter the camel description");
				$("#cameldescription").val('');
				$("#cameldescription").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		  
		  if(age.trim()=="")
		  {
			    alert("Please Enter the age of the camel");
				$("#age").val('');
				$("#age").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		  
		  if(fathername.trim()=="")
		  {
			    alert("Please Enter the Father name of the camel");
				$("#fathername").val('');
				$("#fathername").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		  
		   if(mothername.trim()=="")
		  {
			    alert("Please Enter the Mother name of the camel");
				$("#mothername").val('');
				$("#mothername").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		  
		    if(image.trim()=="")
		  {
			    alert("Please Enter the image of the camel");
				$("#image").val('');
				$("#image").focus();
				return false;
		  }
		  else 
		  {
			  return true;
		  }
		  
	}
	
	//To check duplicate email of the student 
//By Dipeeka on 21st January 2020
function checkduplicateemailoftheuser(email){
	var emailvalue=email.value;
	
	$.ajax({
		method:'GET',
		url:'ajax/checkduplicateemail.php?email='+emailvalue,
		   dataType:'JSON',
		 success:function(data){
				alert(data.message);
				//alert($("#emailid").val());
				//document.getElementById("emailid").reset();
				$("#email").val('');
			}
	})
   /* $.ajax({
		
			 url:'ajax/checkduplicateemail.php',
			 dataType:'JSON',
			 success:function(data){
			}
		)}*/
}

//search the camel
/*
var camels=[];
function checkcamel()
{
	var keyword=$("#keyword").val();
	
	$.ajax({
		method:'GET',
		url:'ajax/checkcamel.php?keyword='+keyword,
		  
		 success:function(data){
			 
				alert(data);
				
				//alert(data.message);
				
				//alert(data.message[0]["oid"]);
				camels.push(data.message);
				
				//alert($("#emailid").val());
				//document.getElementById("emailid").reset();
				//$(".camellist").val(camels);
			}
	})
	$(".camellist").val(camels);
	//console.log( camels );

}
*/



			  
			  
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
			//Image preview
			var fileInput = document.getElementById('image');
			if (fileInput.files && fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" height="100px" width="100px"/>';
				};
				reader.readAsDataURL(fileInput.files[0]);
			}
		}
	  
	  
  }
  
  
</script>
</body>
</html>
