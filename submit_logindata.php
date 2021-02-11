

<?php

session_start();
include('config/config.php');

$email=$_POST['email'];
$pass=$_POST['password'];   

$filter = ["email_id"=>$email,"password"=>$pass];
/* the following condition, and others similar to it, work as well

$filter = ["age"=>["$gt"=>"18"]]; /*/
   
$options = []; /* put desired options here, should you need any */
   
$query = new MongoDB\Driver\Query($filter,$options);
   
$documents = $connection->executeQuery('gulf_racing.admin_auth',$query);

$storedUsername='';
 $storedPassword='';
foreach($documents as $document){
    $document = json_decode(json_encode($document),true);
  //  echo $document['name'];
	$storedUsername=$document['email_id'];
	$storedPassword=$document['password'];
	
}

if($email == $storedUsername && $pass == $storedPassword){ 
					
					$_SESSION["email"] = $email;
					
					//echo $_SESSION["email"];
					//die();
					header("location:indexmain.php");
					}
				else{
					
					$filter = ["email"=>$email,"mobile"=>$pass];
					/* the following condition, and others similar to it, work as well

					$filter = ["age"=>["$gt"=>"18"]]; /*/
					   
					$options = []; /* put desired options here, should you need any */
					   
					$query = new MongoDB\Driver\Query($filter,$options);
					   
					$documents = $connection->executeQuery('gulf_racing.owners',$query);
					foreach($documents as $document){
						
						$document = json_decode(json_encode($document),true);
					  //  echo $document['name'];
						$storedUsername=$document['email'];
						$storedPassword=$document['mobile'];
						
					}
					if($email == $storedUsername && $pass == $storedPassword){ 
					
					$_SESSION["email"] = $email;
					$_SESSION["userrole"] = '2';
					
					header("location:indexmain.php");
					}
					else{
					
					header("location:index.php?activity=error");
				}
				}
				
