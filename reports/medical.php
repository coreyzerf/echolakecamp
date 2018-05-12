<?php
	require('../connect.php');
	require('../functions.php');
	
	session_start();
	
	$page = $_SERVER['PHP_SELF'];
	$now = time(); // or your date as well
	$your_date = strtotime("2017-08-20");
	$datediff = $your_date - $now;
	$until = floor($datediff / (60 * 60 * 24));

	$username = $_SESSION['username'];
	$verify = acctverify($username);
	if ($verify){
		$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		$isadmin = $row["isstaff"];
		unset($row);
	}
	
	$date = date('Y-m-d');
	if ( !acctverify($_SESSION['username'])){
	session_unset();
	$_SESSION['fmsg'] = "You are not logged in.";
	header('Location: ../index.php');
	}elseif (!$isadmin){
		header('Location: index.php');
	}
	
	$header = "";
	$data = "";
	$search = array();
	$i = 0;
	
	$query = "SELECT * FROM `EchoPeople` ORDER BY gender, last";	 
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	
	$fields = mysqli_fetch_fields($result);
	foreach ( $fields as $field )
	{
		$header .= $field->name . ",";
	}


	while ($row = $result->fetch_assoc())
	{
		$line = '';
		foreach( $row as $value )
		{                                            
			if ( ( !isset( $value ) ) || ( $value == "" ) )
			{
				$value = ",";
			}
			else
			{
				$value = str_replace( '"' , '""' , $value );
				$value = '"' . $value . '"' . ",";
			}
			$line .= $value;
		}
		$data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );

	if ( $data == "" )
	{
		$data = "\n(0) Records Found!\n";                        
	}
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=campers.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
	
?>