<?php
ob_start();
	include_once('config\config.php');
	include_once('inc\header.php');
	include_once('inc\aside.php');
	
	
	if(isset($_POST['submit'])){

		 $id = $_POST['id'];
		 $camelname=$_POST['camelname'];
	    $camelnumber=$_POST['camelnumber'];
	    $cameldescription=$_POST['cameldescription'];
	    $camelcategory=$_POST['camelcategory'];
	    $age=$_POST['age'];
		 
	   $gender=$_POST['gender'];
       $fathername=$_POST['fathername'];
	   $mothername=$_POST['mothername'];
      
	   $owner_name=$_POST['owner_name'];
	   $countryCode=$_POST['countryCode'];
	   $contact=$_POST['mobile'];
	   $ccode="+".$_POST['countryCode'].$_POST['mobile'];
	 
	  //$race_id=$_POST['racename'];
	  
	  //$raceid=new MongoDB\BSON\ObjectId($race_id);
	   
	   
	  $camel_status  = $_POST['camel_status'];
      if($camel_status==1)
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
		if($_POST['oldimage']=='')
		{
			$newName='';
		}
		else{
		$newName=$_POST['oldimage'];
		}
	}
    	
		
	
						  if(!$camel_status){
					  
							$flag = 5;

						  }else{
							 
							 
								$insRec       = new MongoDB\Driver\BulkWrite;

								$insRec->update(['_id'=>new MongoDB\BSON\ObjectID($id)],['$set' =>['camelname'=>$camelname,'camelnumber'=>$camelnumber,'cameldescription'=>$cameldescription,'camelcategory'=>$camelcategory,'age'=>(int)($age),'fathername'=>$fathername,'mothername'=>$mothername,'gender'=>$gender,'camel_status' =>$s,'image'=>$newName,'owner_name'=>$owner_name,'mobile'=>$ccode,'countryCode'=>$countryCode,'contact'=>$contact]], ['multi' => false, 'upsert' => false]);
							  
							  		  
								$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

										 
								 $result = $connection->executeBulkWrite('gulf_racing.camels', $insRec, $writeConcern);

							  if($result->getModifiedCount()){

								$flag = 3;

							  }else{

								$flag = 6;

							  }
							  
						  }
				

	header("Location: camels.php?flag=$flag");

    exit;

	
  

  }
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      تحرير الجمل /  Edit Camel
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Camel</a></li>
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

					  $cursor = $connection->executeQuery('gulf_racing.camels', $query);
					  
					foreach($cursor as $row){
						//print_r($row);
				?>
				<form enctype="multipart/form-data" method="POST">
                    <div class="form-group">
							<input type="hidden" class="form-control" id="uid" name="id" value="<?php echo $row->_id;?>"/>
							
						
						<input type="hidden" name="oldimage" value="<?=((!empty($row->image))?$row->image:"")?>"/>
						
						<div class="col-sm-6">
							<label for="camelname">اسم الجمل/(Camel Name)</label>
							<input type="text" class="form-control" id="camelname" name="camelname" value="<?php if (!empty($row->camelname)) { echo $row->camelname;} else { echo "";}?>"  placeholder="Enter Camel Name" required />
						</div>
						
						<div class="col-sm-6">
							<label for="camelnumber">عدد الجمل/(Camel Number)</label>
							<input type="text" class="form-control" id="camelnumber" name="camelnumber" value="<?php if (!empty($row->camelnumber)) { echo $row->camelnumber;} else { echo "";}?>"  placeholder="Enter Camel Number" required />
						</div>
						<div class="col-sm-6">
							<label for="camelcategory">فئة الجمل/(Camel Category)</label>
							
							<select class="form-control" class="camelcategory"  name="camelcategory" class="required">
								
									
											<option value="فطامين" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='فطامين') { echo "selected=selected";}} else { echo "Select Category";}?>>فطامين </option>
											<option value="حقائق" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='حقائق') { echo "selected=selected";}} else { echo "Select Category";}?>>حقائق</option>
											<option value="لقايا" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='لقايا') { echo "selected=selected";}} else { echo "Select Category";}?>>لقايا</option>
											<option value="يذاع" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='يذاع') { echo "selected=selected";}} else { echo "Select Category";}?>>يذاع</option>
											<option value="ثنايا" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='ثنايا') { echo "selected=selected";}} else { echo "Select Category";}?>>ثنايا</option>
											<option value="حول" <?php if(!empty($row->camelcategory)){if ($row->camelcategory=='حول') { echo "selected=selected";}} else { echo "Select Category";}?>>حول</option>
									
								
							</select>
							<!--<input type="text" class="form-control" id="camelcategory" name="camelcategory" value="<?php if (!empty($row->camelcategory)) { echo $row->camelcategory;} else { echo "";}?>"  placeholder="Enter Camel Category" required />-->
						</div>
						<!--<div class="col-sm-6">
							<label for="camelcategory">Camel Category</label>
							<input type="text" class="form-control" id="camelcategory" name="camelcategory" value="<?php if (!empty($row->camelcategory)) { echo $row->camelcategory;} else { echo "";}?>"  placeholder="Enter Camel Category" required />
						</div>-->
						
						<div class="col-sm-6">
							<label for="cameldescription">الجمل الوصف/(Camel Description)</label>
							<input type="text" class="form-control" id="cameldescription" name="cameldescription" value="<?php if (!empty($row->cameldescription)) { echo $row->cameldescription;} else { echo "";}?>" placeholder="Enter Camel Description" required />
						</div>
						
						<div class="col-sm-6">
							<label for="camelnumber">العمر/(Age)</label>
							<input type="number" class="form-control" id="age" name="age" value="<?php if (!empty($row->age)) { echo $row->age;} else { echo "";}?>"  placeholder="Enter Age of Camel"  />
						</div>
						
						<div class="col-sm-6" style="margin:2% 0;">
							<label for="gender">الجنسين/(Gender)</label><br>
							
							<input type="radio" name="gender" value="Male" checked>  جعدان /(Male)<br>
							<input type="radio" name="gender" value="Female" > بكار /(Female)
							
							<!--<input type="text" class="form-control" id="gender" name="gender" value="<?php if (!empty($row->gender)) { echo $row->gender;} else { echo "";}?>"  />-->
						</div>
						
						<div class="col-sm-6">
							<label for="fathername">اسم الأب /(Father's Name)</label>
							<input type="text" class="form-control" id="fathername" name="fathername" value="<?php if (!empty($row->fathername)) { echo $row->fathername;} else { echo "";}?>"  placeholder="Enter Father Name"  />
						</div>
						
						<div class="col-sm-6">
							<label for="mothername">اسم الأم / (Mother's Name)</label>
							<input type="text" class="form-control" id="mothername" name="mothername" value="<?php if (!empty($row->mothername)) { echo $row->mothername;} else { echo "";}?>"  placeholder="Enter Mother Name"  />
						</div>
						
						<div class="col-sm-6">
							<label class="control-label" for="inputPatient">صورة الجمل / (Camels Picture)</label>
							<div class="field desc">
								<input class="form-control" id="image" name="image" placeholder="Image" type="file" onchange="return validateimage();">
							</div>
						</div>
						<!-- Image preview -->
						<img src="<?php echo "images/".((!empty($row->image))?$row->image:"noimage.jfif");?>" style="width:150px;height:150px;border-radius:50%;border:1px solid grey;margin:2% 0%" id="oldimagepreview">
						<div id="imagePreview"></div>
						
						<div class="col-sm-6">
							<label for="owner_name">اسم المالك /(Owner name)</label>
								<input type="text" class="form-control" id="owner_name" name="owner_name" value="<?php if (!empty($row->owner_name)) { echo $row->owner_name;} else { echo "";}?>"  placeholder="Enter Owner Name"  />
						
							
						</div>
						
						<div class="col-sm-6">
						
						<label for="country_code">كود البلد /(Country Code)</label>
						<select name="countryCode" id="" class="form-control">
						<option data-countryCode="OM" value="968" <?php if(!empty($row->countryCode)){if ($row->countryCode=="968") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Oman (+968)</option>
	<!--<option data-countryCode="GB" value="44" Selected>United Kingdom (+44)</option>
	<option data-countryCode="US" value="1">USA (+1)</option>-->
	<optgroup label="Other countries">
		<option data-countryCode="DZ" value="213" <?php if(!empty($row->countryCode)){if ($row->countryCode=="213") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Algeria (+213)</option>
		<option data-countryCode="AD" value="376" <?php if(!empty($row->countryCode)){if ($row->countryCode=="376") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Andorra (+376)</option>
		<option data-countryCode="AO" value="244" <?php if(!empty($row->countryCode)){if ($row->countryCode=="244") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Angola (+244)</option>
		<option data-countryCode="AI" value="1264" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1264") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1268") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54" <?php if(!empty($row->countryCode)){if ($row->countryCode=="54") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Argentina (+54)</option>
		<option data-countryCode="AM" value="374" <?php if(!empty($row->countryCode)){if ($row->countryCode=="374") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Armenia (+374)</option>
		<option data-countryCode="AW" value="297" <?php if(!empty($row->countryCode)){if ($row->countryCode=="297") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Aruba (+297)</option>
		<option data-countryCode="AU" value="61" <?php if(!empty($row->countryCode)){if ($row->countryCode=="61") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Australia (+61)</option>
		<option data-countryCode="AT" value="43" >Aust<?php if(!empty($row->countryCode)){if ($row->countryCode=="43") { echo "selected=selected";}} else { echo "Select Country Code";}?>ria (+43)</option>
		<option data-countryCode="AZ" value="994" <?php if(!empty($row->countryCode)){if ($row->countryCode=="994") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1242") { echo "selected=selected";}} else { echo "Select Country Code";}?> >Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973" <?php if(!empty($row->countryCode)){if ($row->countryCode=="973") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bahrain (+973)</option>
		<option data-countryCode="BD" value="880" <?php if(!empty($row->countryCode)){if ($row->countryCode=="880") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1246") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Barbados (+1246)</option>
		<option data-countryCode="BY" value="375" <?php if(!empty($row->countryCode)){if ($row->countryCode=="375") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Belarus (+375)</option>
		<option data-countryCode="BE" value="32" <?php if(!empty($row->countryCode)){if ($row->countryCode=="32") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Belgium (+32)</option>
		<option data-countryCode="BZ" value="501" <?php if(!empty($row->countryCode)){if ($row->countryCode=="501") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Belize (+501)</option>
		<option data-countryCode="BJ" value="229" <?php if(!empty($row->countryCode)){if ($row->countryCode=="229") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Benin (+229)</option>
		<option data-countryCode="BM" value="1441" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1441") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975" <?php if(!empty($row->countryCode)){if ($row->countryCode=="975") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bhutan (+975)</option>
		<option data-countryCode="BO" value="591" <?php if(!empty($row->countryCode)){if ($row->countryCode=="591") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bolivia (+591)</option>
		<option data-countryCode="BA" value="387" <?php if(!empty($row->countryCode)){if ($row->countryCode=="387") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267" <?php if(!empty($row->countryCode)){if ($row->countryCode=="267") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Botswana (+267)</option>
		<option data-countryCode="BR" value="55" <?php if(!empty($row->countryCode)){if ($row->countryCode=="55") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Brazil (+55)</option>
		<option data-countryCode="BN" value="673" <?php if(!empty($row->countryCode)){if ($row->countryCode=="673") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Brunei (+673)</option>
		<option data-countryCode="BG" value="359" <?php if(!empty($row->countryCode)){if ($row->countryCode=="359") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226" <?php if(!empty($row->countryCode)){if ($row->countryCode=="226") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257" <?php if(!empty($row->countryCode)){if ($row->countryCode=="257") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Burundi (+257)</option>
		<option data-countryCode="KH" value="855" <?php if(!empty($row->countryCode)){if ($row->countryCode=="855") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cambodia (+855)</option>
		<option data-countryCode="CM" value="237" <?php if(!empty($row->countryCode)){if ($row->countryCode=="237") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cameroon (+237)</option>
		<option data-countryCode="CA" value="1" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Canada (+1)</option>
		<option data-countryCode="CV" value="238" <?php if(!empty($row->countryCode)){if ($row->countryCode=="238") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1345") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236" <?php if(!empty($row->countryCode)){if ($row->countryCode=="236") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56" <?php if(!empty($row->countryCode)){if ($row->countryCode=="56") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Chile (+56)</option>
		<option data-countryCode="CN" value="86" <?php if(!empty($row->countryCode)){if ($row->countryCode=="86") { echo "selected=selected";}} else { echo "Select Country Code";}?>>China (+86)</option>
		<option data-countryCode="CO" value="57" <?php if(!empty($row->countryCode)){if ($row->countryCode=="57") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Colombia (+57)</option>
		<option data-countryCode="KM" value="269" <?php if(!empty($row->countryCode)){if ($row->countryCode=="269") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Comoros (+269)</option>
		<option data-countryCode="CG" value="242" <?php if(!empty($row->countryCode)){if ($row->countryCode=="242") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Congo (+242)</option>
		<option data-countryCode="CK" value="682" <?php if(!empty($row->countryCode)){if ($row->countryCode=="682") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506" <?php if(!empty($row->countryCode)){if ($row->countryCode=="506") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385" <?php if(!empty($row->countryCode)){if ($row->countryCode=="385") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Croatia (+385)</option>
		<option data-countryCode="CU" value="53" <?php if(!empty($row->countryCode)){if ($row->countryCode=="53") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cuba (+53)</option>
		<option data-countryCode="CY" value="90392" <?php if(!empty($row->countryCode)){if ($row->countryCode=="90392") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357" <?php if(!empty($row->countryCode)){if ($row->countryCode=="357") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42" <?php if(!empty($row->countryCode)){if ($row->countryCode=="42") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45" <?php if(!empty($row->countryCode)){if ($row->countryCode=="45") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Denmark (+45)</option>
		<option data-countryCode="DJ" value="253" <?php if(!empty($row->countryCode)){if ($row->countryCode=="253") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1809") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809" <?php if(!empty($row->countryCode)){if ($row->countryCode=="53") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593" <?php if(!empty($row->countryCode)){if ($row->countryCode=="593") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Ecuador (+593)</option>
		<option data-countryCode="EG" value="20" <?php if(!empty($row->countryCode)){if ($row->countryCode=="20") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Egypt (+20)</option>
		<option data-countryCode="SV" value="503" <?php if(!empty($row->countryCode)){if ($row->countryCode=="503") { echo "selected=selected";}} else { echo "Select Country Code";}?>>El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240" <?php if(!empty($row->countryCode)){if ($row->countryCode=="240") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291" <?php if(!empty($row->countryCode)){if ($row->countryCode=="291") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Eritrea (+291)</option>
		<option data-countryCode="EE" value="372" <?php if(!empty($row->countryCode)){if ($row->countryCode=="372") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Estonia (+372)</option>
		<option data-countryCode="ET" value="251" <?php if(!empty($row->countryCode)){if ($row->countryCode=="251") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500" <?php if(!empty($row->countryCode)){if ($row->countryCode=="500") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298" <?php if(!empty($row->countryCode)){if ($row->countryCode=="298") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679" <?php if(!empty($row->countryCode)){if ($row->countryCode=="679") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Fiji (+679)</option>
		<option data-countryCode="FI" value="358" <?php if(!empty($row->countryCode)){if ($row->countryCode=="358") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Finland (+358)</option>
		<option data-countryCode="FR" value="33" <?php if(!empty($row->countryCode)){if ($row->countryCode=="33") { echo "selected=selected";}} else { echo "Select Country Code";}?>>France (+33)</option>
		<option data-countryCode="GF" value="594" <?php if(!empty($row->countryCode)){if ($row->countryCode=="594") { echo "selected=selected";}} else { echo "Select Country Code";}?>>French Guiana (+594)</option>
		<option data-countryCode="PF" value="689" <?php if(!empty($row->countryCode)){if ($row->countryCode=="689") { echo "selected=selected";}} else { echo "Select Country Code";}?>>French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241" <?php if(!empty($row->countryCode)){if ($row->countryCode=="241") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Gabon (+241)</option>
		<option data-countryCode="GM" value="220" <?php if(!empty($row->countryCode)){if ($row->countryCode=="220") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Gambia (+220)</option>
		<option data-countryCode="GE" value="7880" <?php if(!empty($row->countryCode)){if ($row->countryCode=="7880") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Georgia (+7880)</option>
		<option data-countryCode="DE" value="49" <?php if(!empty($row->countryCode)){if ($row->countryCode=="49") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Germany (+49)</option>
		<option data-countryCode="GH" value="233" <?php if(!empty($row->countryCode)){if ($row->countryCode=="233") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Ghana (+233)</option>
		<option data-countryCode="GI" value="350" <?php if(!empty($row->countryCode)){if ($row->countryCode=="350") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30" <?php if(!empty($row->countryCode)){if ($row->countryCode=="30") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Greece (+30)</option>
		<option data-countryCode="GL" value="299" <?php if(!empty($row->countryCode)){if ($row->countryCode=="299") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Greenland (+299)</option>
		<option data-countryCode="GD" value="1473" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1473") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Grenada (+1473)</option>
		<option data-countryCode="GP" value="590" <?php if(!empty($row->countryCode)){if ($row->countryCode=="590") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671" <?php if(!empty($row->countryCode)){if ($row->countryCode=="671") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guam (+671)</option>
		<option data-countryCode="GT" value="502" <?php if(!empty($row->countryCode)){if ($row->countryCode=="502") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guatemala (+502)</option>
		<option data-countryCode="GN" value="224" <?php if(!empty($row->countryCode)){if ($row->countryCode=="224") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guinea (+224)</option>
		<option data-countryCode="GW" value="245" <?php if(!empty($row->countryCode)){if ($row->countryCode=="245") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592" <?php if(!empty($row->countryCode)){if ($row->countryCode=="592") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Guyana (+592)</option>
		<option data-countryCode="HT" value="509" <?php if(!empty($row->countryCode)){if ($row->countryCode=="509") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Haiti (+509)</option>
		<option data-countryCode="HN" value="504" <?php if(!empty($row->countryCode)){if ($row->countryCode=="504") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Honduras (+504)</option>
		<option data-countryCode="HK" value="852" <?php if(!empty($row->countryCode)){if ($row->countryCode=="852") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36" <?php if(!empty($row->countryCode)){if ($row->countryCode=="36") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Hungary (+36)</option>
		<option data-countryCode="IS" value="354" <?php if(!empty($row->countryCode)){if ($row->countryCode=="354") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Iceland (+354)</option>
		<option data-countryCode="IN" value="91" <?php if(!empty($row->countryCode)){if ($row->countryCode=="91") { echo "selected=selected";}} else { echo "Select Country Code";}?>>India (+91)</option>
		<option data-countryCode="ID" value="62" <?php if(!empty($row->countryCode)){if ($row->countryCode=="62") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Indonesia (+62)</option>
		<option data-countryCode="IR" value="98" <?php if(!empty($row->countryCode)){if ($row->countryCode=="98") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Iran (+98)</option>
		<option data-countryCode="IQ" value="964" <?php if(!empty($row->countryCode)){if ($row->countryCode=="964") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Iraq (+964)</option>
		<option data-countryCode="IE" value="353" <?php if(!empty($row->countryCode)){if ($row->countryCode=="353") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Ireland (+353)</option>
		<option data-countryCode="IL" value="972" <?php if(!empty($row->countryCode)){if ($row->countryCode=="972") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Israel (+972)</option>
		<option data-countryCode="IT" value="39" <?php if(!empty($row->countryCode)){if ($row->countryCode=="39") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Italy (+39)</option>
		<option data-countryCode="JM" value="1876" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1876") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81" <?php if(!empty($row->countryCode)){if ($row->countryCode=="81") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Japan (+81)</option>
		<option data-countryCode="JO" value="962" <?php if(!empty($row->countryCode)){if ($row->countryCode=="962") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Jordan (+962)</option>
		<option data-countryCode="KZ" value="7" <?php if(!empty($row->countryCode)){if ($row->countryCode=="7") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254" <?php if(!empty($row->countryCode)){if ($row->countryCode=="254") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Kenya (+254)</option>
		<option data-countryCode="KI" value="686" <?php if(!empty($row->countryCode)){if ($row->countryCode=="686") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Kiribati (+686)</option>
		<option data-countryCode="KP" value="850" <?php if(!empty($row->countryCode)){if ($row->countryCode=="850") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Korea North (+850)</option>
		<option data-countryCode="KR" value="82" <?php if(!empty($row->countryCode)){if ($row->countryCode=="82") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Korea South (+82)</option>
		<option data-countryCode="KW" value="965" <?php if(!empty($row->countryCode)){if ($row->countryCode=="965") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Kuwait (+965)</option>
		<option data-countryCode="KG" value="996" <?php if(!empty($row->countryCode)){if ($row->countryCode=="996") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856" <?php if(!empty($row->countryCode)){if ($row->countryCode=="856") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Laos (+856)</option>
		<option data-countryCode="LV" value="371" <?php if(!empty($row->countryCode)){if ($row->countryCode=="371") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Latvia (+371)</option>
		<option data-countryCode="LB" value="961" <?php if(!empty($row->countryCode)){if ($row->countryCode=="961") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Lebanon (+961)</option>
		<option data-countryCode="LS" value="266" <?php if(!empty($row->countryCode)){if ($row->countryCode=="266") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Lesotho (+266)</option>
		<option data-countryCode="LR" value="231" <?php if(!empty($row->countryCode)){if ($row->countryCode=="231") { echo "selected=selected";}} else { echo "Select Country Code";}?> >Liberia (+231)</option>
		<option data-countryCode="LY" value="218" <?php if(!empty($row->countryCode)){if ($row->countryCode=="218") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Libya (+218)</option>
		<option data-countryCode="LI" value="417" <?php if(!empty($row->countryCode)){if ($row->countryCode=="417") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370" <?php if(!empty($row->countryCode)){if ($row->countryCode=="370") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Lithuania (+370)</option>
		<option data-countryCode="LU" value="352" <?php if(!empty($row->countryCode)){if ($row->countryCode=="352") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853" <?php if(!empty($row->countryCode)){if ($row->countryCode=="853") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Macao (+853)</option>
		<option data-countryCode="MK" value="389" <?php if(!empty($row->countryCode)){if ($row->countryCode=="389") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Macedonia (+389)</option>
		<option data-countryCode="MG" value="261" <?php if(!empty($row->countryCode)){if ($row->countryCode=="261") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Madagascar (+261)</option>
		<option data-countryCode="MW" value="265" <?php if(!empty($row->countryCode)){if ($row->countryCode=="265") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Malawi (+265)</option>
		<option data-countryCode="MY" value="60" <?php if(!empty($row->countryCode)){if ($row->countryCode=="60") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Malaysia (+60)</option>
		<option data-countryCode="MV" value="960" <?php if(!empty($row->countryCode)){if ($row->countryCode=="960") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Maldives (+960)</option>
		<option data-countryCode="ML" value="223" <?php if(!empty($row->countryCode)){if ($row->countryCode=="223") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mali (+223)</option>
		<option data-countryCode="MT" value="356" <?php if(!empty($row->countryCode)){if ($row->countryCode=="356") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Malta (+356)</option>
		<option data-countryCode="MH" value="692" <?php if(!empty($row->countryCode)){if ($row->countryCode=="692") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596" <?php if(!empty($row->countryCode)){if ($row->countryCode=="596") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Martinique (+596)</option>
		<option data-countryCode="MR" value="222" <?php if(!empty($row->countryCode)){if ($row->countryCode=="222") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mauritania (+222)</option>
		<option data-countryCode="YT" value="269" <?php if(!empty($row->countryCode)){if ($row->countryCode=="269") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mayotte (+269)</option>
		<option data-countryCode="MX" value="52" <?php if(!empty($row->countryCode)){if ($row->countryCode=="52") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mexico (+52)</option>
		<option data-countryCode="FM" value="691" <?php if(!empty($row->countryCode)){if ($row->countryCode=="691") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Micronesia (+691)</option>
		<option data-countryCode="MD" value="373" <?php if(!empty($row->countryCode)){if ($row->countryCode=="373") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Moldova (+373)</option>
		<option data-countryCode="MC" value="377" <?php if(!empty($row->countryCode)){if ($row->countryCode=="377") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Monaco (+377)</option>
		<option data-countryCode="MN" value="976" <?php if(!empty($row->countryCode)){if ($row->countryCode=="976") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1664") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212" <?php if(!empty($row->countryCode)){if ($row->countryCode=="212") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Morocco (+212)</option>
		<option data-countryCode="MZ" value="258" <?php if(!empty($row->countryCode)){if ($row->countryCode=="258") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Mozambique (+258)</option>
		<option data-countryCode="MN" value="95" <?php if(!empty($row->countryCode)){if ($row->countryCode=="95") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Myanmar (+95)</option>
		<option data-countryCode="NA" value="264" <?php if(!empty($row->countryCode)){if ($row->countryCode=="264") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Namibia (+264)</option>
		<option data-countryCode="NR" value="674" <?php if(!empty($row->countryCode)){if ($row->countryCode=="674") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Nauru (+674)</option>
		<option data-countryCode="NP" value="977" <?php if(!empty($row->countryCode)){if ($row->countryCode=="977") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Nepal (+977)</option>
		<option data-countryCode="NL" value="31" <?php if(!empty($row->countryCode)){if ($row->countryCode=="31") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Netherlands (+31)</option>
		<option data-countryCode="NC" value="687" <?php if(!empty($row->countryCode)){if ($row->countryCode=="687") { echo "selected=selected";}} else { echo "Select Country Code";}?>>New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64" <?php if(!empty($row->countryCode)){if ($row->countryCode=="64") { echo "selected=selected";}} else { echo "Select Country Code";}?>>New Zealand (+64)</option>
		<option data-countryCode="NI" value="505" <?php if(!empty($row->countryCode)){if ($row->countryCode=="505") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227" <?php if(!empty($row->countryCode)){if ($row->countryCode=="227") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Niger (+227)</option>
		<option data-countryCode="NG" value="234" <?php if(!empty($row->countryCode)){if ($row->countryCode=="234") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Nigeria (+234)</option>
		<option data-countryCode="NU" value="683" <?php if(!empty($row->countryCode)){if ($row->countryCode=="683") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Niue (+683)</option>
		<option data-countryCode="NF" value="672" <?php if(!empty($row->countryCode)){if ($row->countryCode=="672") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670" <?php if(!empty($row->countryCode)){if ($row->countryCode=="670") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47" <?php if(!empty($row->countryCode)){if ($row->countryCode=="47") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Norway (+47)</option>
		<!--<option data-countryCode="OM" value="968">Oman (+968)</option>-->
		<option data-countryCode="PW" value="680" <?php if(!empty($row->countryCode)){if ($row->countryCode=="680") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Palau (+680)</option>
		<option data-countryCode="PA" value="507" <?php if(!empty($row->countryCode)){if ($row->countryCode=="507") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Panama (+507)</option>
		<option data-countryCode="PG" value="675" <?php if(!empty($row->countryCode)){if ($row->countryCode=="675") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595" <?php if(!empty($row->countryCode)){if ($row->countryCode=="595") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Paraguay (+595)</option>
		<option data-countryCode="PE" value="51" <?php if(!empty($row->countryCode)){if ($row->countryCode=="51") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Peru (+51)</option>
		<option data-countryCode="PH" value="63" <?php if(!empty($row->countryCode)){if ($row->countryCode=="63") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Philippines (+63)</option>
		<option data-countryCode="PL" value="48" <?php if(!empty($row->countryCode)){if ($row->countryCode=="48") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Poland (+48)</option>
		<option data-countryCode="PT" value="351" <?php if(!empty($row->countryCode)){if ($row->countryCode=="351") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Portugal (+351)</option>
		<option data-countryCode="PR" value="1787" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1787") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974" <?php if(!empty($row->countryCode)){if ($row->countryCode=="974") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Qatar (+974)</option>
		<option data-countryCode="RE" value="262" <?php if(!empty($row->countryCode)){if ($row->countryCode=="262") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Reunion (+262)</option>
		<option data-countryCode="RO" value="40" <?php if(!empty($row->countryCode)){if ($row->countryCode=="40") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Romania (+40)</option>
		<option data-countryCode="RU" value="7" <?php if(!empty($row->countryCode)){if ($row->countryCode=="7") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Russia (+7)</option>
		<option data-countryCode="RW" value="250" <?php if(!empty($row->countryCode)){if ($row->countryCode=="250") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Rwanda (+250)</option>
		<option data-countryCode="SM" value="378" <?php if(!empty($row->countryCode)){if ($row->countryCode=="378") { echo "selected=selected";}} else { echo "Select Country Code";}?>>San Marino (+378)</option>
		<option data-countryCode="ST" value="239" <?php if(!empty($row->countryCode)){if ($row->countryCode=="239") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966" <?php if(!empty($row->countryCode)){if ($row->countryCode=="966") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221" <?php if(!empty($row->countryCode)){if ($row->countryCode=="221") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Senegal (+221)</option>
		<option data-countryCode="CS" value="381" <?php if(!empty($row->countryCode)){if ($row->countryCode=="381") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Serbia (+381)</option>
		<option data-countryCode="SC" value="248" <?php if(!empty($row->countryCode)){if ($row->countryCode=="248") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Seychelles (+248)</option>
		<option data-countryCode="SL" value="232" <?php if(!empty($row->countryCode)){if ($row->countryCode=="232") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65" <?php if(!empty($row->countryCode)){if ($row->countryCode=="65") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Singapore (+65)</option>
		<option data-countryCode="SK" value="421" <?php if(!empty($row->countryCode)){if ($row->countryCode=="421") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386" <?php if(!empty($row->countryCode)){if ($row->countryCode=="386") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Slovenia (+386)</option>
		<option data-countryCode="SB" value="677" <?php if(!empty($row->countryCode)){if ($row->countryCode=="677") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252" <?php if(!empty($row->countryCode)){if ($row->countryCode=="252") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Somalia (+252)</option>
		<option data-countryCode="ZA" value="27" <?php if(!empty($row->countryCode)){if ($row->countryCode=="27") { echo "selected=selected";}} else { echo "Select Country Code";}?>>South Africa (+27)</option>
		<option data-countryCode="ES" value="34" <?php if(!empty($row->countryCode)){if ($row->countryCode=="34") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Spain (+34)</option>
		<option data-countryCode="LK" value="94" <?php if(!empty($row->countryCode)){if ($row->countryCode=="94") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290" <?php if(!empty($row->countryCode)){if ($row->countryCode=="290") { echo "selected=selected";}} else { echo "Select Country Code";}?>>St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1869") { echo "selected=selected";}} else { echo "Select Country Code";}?>>St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1758") { echo "selected=selected";}} else { echo "Select Country Code";}?>>St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249" <?php if(!empty($row->countryCode)){if ($row->countryCode=="249") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Sudan (+249)</option>
		<option data-countryCode="SR" value="597" <?php if(!empty($row->countryCode)){if ($row->countryCode=="597") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Suriname (+597)</option>
		<option data-countryCode="SZ" value="268" <?php if(!empty($row->countryCode)){if ($row->countryCode=="268") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Swaziland (+268)</option>
		<option data-countryCode="SE" value="46" <?php if(!empty($row->countryCode)){if ($row->countryCode=="46") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Sweden (+46)</option>
		<option data-countryCode="CH" value="41" <?php if(!empty($row->countryCode)){if ($row->countryCode=="41") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Switzerland (+41)</option>
		<option data-countryCode="SI" value="963" <?php if(!empty($row->countryCode)){if ($row->countryCode=="963") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Syria (+963)</option>
		<option data-countryCode="TW" value="886" <?php if(!empty($row->countryCode)){if ($row->countryCode=="886") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7" <?php if(!empty($row->countryCode)){if ($row->countryCode=="7") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66" <?php if(!empty($row->countryCode)){if ($row->countryCode=="66") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Thailand (+66)</option>
		<option data-countryCode="TG" value="228" <?php if(!empty($row->countryCode)){if ($row->countryCode=="228") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Togo (+228)</option>
		<option data-countryCode="TO" value="676" <?php if(!empty($row->countryCode)){if ($row->countryCode=="676") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Tonga (+676)</option>
		<option data-countryCode="TT" value="1868" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1868") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216" <?php if(!empty($row->countryCode)){if ($row->countryCode=="216") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Tunisia (+216)</option>
		<option data-countryCode="TR" value="90" <?php if(!empty($row->countryCode)){if ($row->countryCode=="90") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Turkey (+90)</option>
		<!--<option data-countryCode="TM" value="7" >Turkmenistan (+7)</option>-->
		<option data-countryCode="TM" value="993" <?php if(!empty($row->countryCode)){if ($row->countryCode=="993") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1649") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688" <?php if(!empty($row->countryCode)){if ($row->countryCode=="688") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256" <?php if(!empty($row->countryCode)){if ($row->countryCode=="256") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Uganda (+256)</option>
		 <option data-countryCode="GB" value="44" <?php if(!empty($row->countryCode)){if ($row->countryCode=="44") { echo "selected=selected";}} else { echo "Select Country Code";}?>>UK (+44)</option> 
		<option data-countryCode="UA" value="380" <?php if(!empty($row->countryCode)){if ($row->countryCode=="380") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Ukraine (+380)</option>
		<option data-countryCode="AE" value="971" <?php if(!empty($row->countryCode)){if ($row->countryCode=="971") { echo "selected=selected";}} else { echo "Select Country Code";}?>>United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598" <?php if(!empty($row->countryCode)){if ($row->countryCode=="598") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Uruguay (+598)</option>
		 <option data-countryCode="US" value="1" <?php if(!empty($row->countryCode)){if ($row->countryCode=="1") { echo "selected=selected";}} else { echo "Select Country Code";}?>>USA (+1)</option> 
		<!--<option data-countryCode="UZ" value="7" >Uzbekistan (+7)</option>-->
		<option data-countryCode="VU" value="678" <?php if(!empty($row->countryCode)){if ($row->countryCode=="678") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379" <?php if(!empty($row->countryCode)){if ($row->countryCode=="379") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Vatican City (+379)</option>
		<option data-countryCode="VE" value="58" <?php if(!empty($row->countryCode)){if ($row->countryCode=="58") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Venezuela (+58)</option>
		<option data-countryCode="VN" value="84" <?php if(!empty($row->countryCode)){if ($row->countryCode=="84") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Vietnam (+84)</option>
		<!--<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>-->
		<option data-countryCode="WF" value="681" <?php if(!empty($row->countryCode)){if ($row->countryCode=="681") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969" <?php if(!empty($row->countryCode)){if ($row->countryCode=="969") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967" <?php if(!empty($row->countryCode)){if ($row->countryCode=="967") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260" <?php if(!empty($row->countryCode)){if ($row->countryCode=="260") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Zambia (+260)</option>
		<option data-countryCode="ZW" value="263" <?php if(!empty($row->countryCode)){if ($row->countryCode=="263") { echo "selected=selected";}} else { echo "Select Country Code";}?>>Zimbabwe (+263)</option>
	</optgroup>
</select>
</div>

						<div class="col-sm-6">
							<label for="mobile">المحمول / (Mobile)</label>
							<input type="text" class="form-control" id="mobile" name="mobile" value="<?php if (!empty($row->contact)) { echo $row->contact;} else { echo "";}?>" maxlength="8" onkeypress="return onlyNumberKey(event)" placeholder="Enter Mobile Number"  />
						</div>
						
						
						
						<div class="col-sm-6">
							<label for="status">حالة الجمال /(Camel Status)</label>
							
							<select class="form-control" id="camel_status" name="camel_status" class="required">
								<option value="" selected="">Select Status</option>
								<option value="1" <?php if(!empty($row->camel_status)){if ($row->camel_status==true) { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="2" <?php if(!empty($row->camel_status)){if ($row->camel_status==false) { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
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
