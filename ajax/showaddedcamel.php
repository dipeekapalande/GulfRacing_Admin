<?php

require_once('..\config\config.php');

$id    = $_REQUEST['listcam'];


$response="";

						
					
							$response.="<div id='myItemListold'>
								<ul>
									";
									foreach($id  as $ca)
									{
										 $filtercamel = ['_id' => new MongoDB\BSON\ObjectID($ca)];

										  $optionscamel = [];

										  $querycamel = new MongoDB\Driver\Query($filtercamel,$optionscamel);

										  $cursorcamel = $connection->executeQuery('gulf_racing.camels', $querycamel);
										  foreach($cursorcamel as $cucam)
											{
										
										$response.="<li>".$cucam->camelname." - ".$cucam->camelnumber."</li>";
										
											}
									}
									
								$response.="</ul>
							</div>";
							
							echo $response;
							exit;
							
						


