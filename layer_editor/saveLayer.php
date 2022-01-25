<?php

	header('Content-Type: text/html; charset=utf-8');
	include 'db_active.php';
	$connection->set_charset("utf8");

	$data = json_decode($_POST["data"]);
	$result = "lol:";
	
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	// Perform a query, check for error
	  // foreach ($data as $key => $value) {
		// foreach ($value as $k => $val) {
	  // 	if (!mysqli_query($connection,"INSERT INTO layers(name_id,number_div,width,height,pos_top,pos_left) VALUES('$val[0]','0','$val[1]','$val[2]','$val[3]','$val[4]')"))
	  // {
	  // echo("Error description: " . mysqli_error($con));
	  // }
			// mysqli_query($connection,"INSERT INTO layers(name_id,number_div,width,height,pos_top,pos_left) VALUES('$value[0]','0','$value[1]','$value[2]','$value[3]','$value[4]')");
			// $result .= "" . $value[0] . $value[1] . $value[2] . $value[3] . $value[4];
		// }
		
	// }

	foreach ($variable as $d) {
		$result .= $d;
	}
	
	  $connection->close();

	  echo var_dump($data);

	

?>