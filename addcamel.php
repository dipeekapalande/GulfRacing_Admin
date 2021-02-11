<?php
ob_start();
	include_once('config\config.php');
	include_once('inc\header.php');
	include_once('inc\aside.php');
	
	
	if(isset($_POST['submit'])){
	
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
         
           $insRec       = new MongoDB\Driver\BulkWrite;

           $insRec->insert(['camelname'=>$camelname,'camelnumber'=>$camelnumber,'cameldescription'=>$cameldescription,'camelcategory'=>$camelcategory,'age'=>(int)($age),'fathername'=>$fathername,'mothername'=>$mothername,'gender'=>$gender,'camel_status' =>$s,'image'=>$newName,'owner_name'=>$owner_name,'mobile'=>$ccode,'countryCode'=>$countryCode,'contact'=>$contact]);
          
           $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
         
             $result       = $connection->executeBulkWrite('gulf_racing.camels', $insRec, $writeConcern);

          if($result->getInsertedCount()){

            $flag = 3;

          }else{

            $flag = 2;

          }
		   
		  
      }
					
	  //echo $flag;
	 // die();
	header("Location: camels.php?flag=$flag");

    exit;

	
  

  }
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     أضف الجمل /( Add Camel )
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Camel</a></li>
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
							<label for="camelname">اسم الجمل/(Camel Name)</label>
							<input type="text" class="form-control" id="camelname" name="camelname" value="<?php if (!empty($row->camelname)) { echo $row->camelname;} else { echo "";}?>"  placeholder="Enter Camel Name" required />
						</div>
						<div class="col-sm-6">
							<label for="camelnumber">عدد الجمل/(Camel Number)</label>
							<input type="text" class="form-control" id="camelnumber" name="camelnumber" value="<?php if (!empty($row->camelnumber)) { echo $row->camelnumber;} else { echo "";}?>"  placeholder="Enter Camel Number" onblur="checkduplicatecamelnumber(this)" required />
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
							
							<select class="form-control" class="camelcategory"  name="camelcategory" class="required">
								
									
											<option value=""></option>
											<option value=""></option>
											<option value=""></option>
											<option value=""></option>
									
								
							</select>
							
						</div>-->
						
						<div class="col-sm-6">
							<label for="cameldescription">الجمل الوصف/(Camel Description)</label>
							<input type="text" class="form-control" id="cameldescription" name="cameldescription" value="<?php if (!empty($row->cameldescription)) { echo $row->cameldescription;} else { echo "";}?>" placeholder="Enter Camel Description" required />
						</div>
						
						<div class="col-sm-6">
							<label for="camelnumber">العمر/(Age)</label>
							<input type="number" class="form-control" id="age" name="age" value="<?php if (!empty($row->age)) { echo $row->camelnumber;} else { echo "";}?>"  placeholder="Enter Age of Camel"  />
						</div>
						
						<div class="col-sm-6" style="margin:2% 0;">
							<label for="gender">الجنسين/(Gender)</label><br>
							
							<input type="radio" name="gender" value="Male" checked> جعدان /(Male)<br>
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
							<label class="control-label" for="inputPatient"> صورة الجمل / (Camels Picture)</label>
							<div class="field desc">
								<input class="form-control" id="image" name="image" placeholder="Image" type="file" onchange="return validateimage();"  >
							</div>
						</div>
						<!-- Image preview -->
						<div id="imagePreview"></div>
						
						<div class="col-sm-6">
							<label for="owner_name">اسم المالك /(Owner name)</label>
								<input type="text" class="form-control" id="owner_name" name="owner_name" value="<?php if (!empty($row->owner_name)) { echo $row->owner_name;} else { echo "";}?>"  placeholder="Enter Owner Name"  />
						<!--	<select class="form-control" class="owner_name" id="select2" name="owner_name" class="required">
								
									<?php
										$filter = [];
										$options = ['sort' => ['position' => -1]];	
										$query=new MongoDB\Driver\Query($filter,$options);
										$cursor=$connection->executeQuery("gulf_racing.owners",$query);
										foreach($cursor as $document)
										{
									?>
											<option value="<?php echo $document->_id;?>"><?php echo $document->first_name . ' ' . $document->last_name;?></option>
									<?php
										}
									?>
								
							</select>-->
							
						</div>
						<div class="col-sm-6">
						
						<label for="country_code">كود البلد /(Country Code)</label>
						<select name="countryCode" id="" class="form-control">
						<option data-countryCode="OM" value="968">Oman (+968)</option>
	<!--<option data-countryCode="GB" value="44" Selected>UK (+44)</option>
	<option data-countryCode="US" value="1">USA (+1)</option>-->
	<optgroup label="Other countries">
		<option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91">India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<!--<option data-countryCode="OM" value="968">Oman (+968)</option>-->
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		 <option data-countryCode="GB" value="44">UK (+44)</option> 
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		 <option data-countryCode="US" value="1">USA (+1)</option> 
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
	</optgroup>
</select>
</div>

						<div class="col-sm-6">
							<label for="mobile">المحمول / (Mobile)</label>
							<input type="text" class="form-control" id="mobile" name="mobile" value="<?php if (!empty($row->mobile)) { echo $row->mobile;} else { echo "";}?>" maxlength="8" onkeypress="return onlyNumberKey(event)" placeholder="Enter Mobile Number"  />
						</div>
						
						
						
						<div class="col-sm-6">
							<label for="status">حالة الجمال /(Camel Status)</label>
							
							<select class="form-control" id="camel_status" name="camel_status" class="required">
								<!--<option value="" selected="">Select Status</option>-->
								<option value="1" <?php if(!empty($row->camel_status)){if ($row->camel_status=="1") { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="2" <?php if(!empty($row->camel_status)){if ($row->camel_status=="2") { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
						</div>
						
						
						
						
						
						<?php
						/*if (!empty($row->created_date))
						{
							$newd=$row->created_date;
							//$ti=$newd->__toString();
							//echo $d;
							
							//$utcdatetime = new MongoDB\BSON\UTCDateTime($ti);
							//$datetime = $utcdatetime->toDateTime();
							
							$timestamp = $newd->__toString(); //ISO DATE Return form mongo database
							$utcdatetime = new MongoDB\BSON\UTCDateTime($timestamp);
							$datetime = $utcdatetime->toDateTime();
							$time=$datetime->format(DATE_RSS);
							$dateInUTC=$time;
							$time = strtotime($dateInUTC.' UTC');
							$dateInLocal = date("F d Y", $time);
							//echo $dateInLocal;

						}*/
						?>
						<!--<div class="col-sm-6">
							<label for="date_of_joining">Date Of Joining</label>
							<input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="<?php if (!empty($row->date_of_joining)) { echo $dateInLocal;;} else { echo "";}?>"  />
						</div>
						
						<div class="col-sm-6">
							<label for="status">Owner Status</label>
							
							<select class="form-control" id="owner_status" name="owner_status" class="required">
								<option value="" selected="">Select Status</option>
								<option value="1" <?php if(!empty($row->owner_status)){if ($row->owner_status=="1") { echo "selected=selected";}} else { echo "Select Status";}?>>Active</option>
								<option value="2" <?php if(!empty($row->owner_status)){if ($row->owner_status=="2") { echo "selected=selected";}} else { echo "Select Status";}?>>InActive</option>
								
								
							</select>
							
						</div>
						<div class="col-sm-6">
							<label for="address">Address</label>
							<input type="text" class="form-control" id="address" name="address" value="<?php if (!empty($row->address)) { echo $row->address;} else { echo "";}?>"  placeholder="Enter Mobile Number" required />
						</div>-->
						
					
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
		include('footer.php');
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
  //To check duplicate camel number 
//By Dipeeka on 21st January 2020
function checkduplicatecamelnumber(number){
	var numbervalue=number.value;
	
	$.ajax({
		method:'GET',
		url:'ajax/checkduplicatecamelnumber.php?camelnumber='+numbervalue,
		   dataType:'JSON',
		 success:function(data){
				alert(data.message);
				//alert($("#emailid").val());
				//document.getElementById("emailid").reset();
				$("#camelnumber").val('');
			}
	})
   /* $.ajax({
		
			 url:'ajax/checkduplicateemail.php',
			 dataType:'JSON',
			 success:function(data){
			}
		)}*/
}
  
</script>
</body>
</html>
