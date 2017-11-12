<?php
	$title = "Registration";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$id = $_GET['id'];
	if(!empty($id)) {
		$query = "SELECT * FROM `EchoPeople` WHERE id='$id'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		if(!$result){
			$_SESSION['fmsg'] = "Problem in account activation.";
			header('Location: login.php');
		}elseif ($row['isactive'] == 1){
			$_SESSION['fmsg'] = "Activation link was already used.";
			header('Location: login.php');
		}else{
			$isactive = 1;
			$query = "UPDATE EchoPeople SET isactive='$isactive' WHERE id='".$id."';";
			$result = mysqli_query($connection, $query);
			
			if($result) {
				$_SESSION['smsg'] = "Your account is activated.";
			} else {
				$_SESSION['fmsg'] = "Problem in account activation.";
			}
		
			$_SESSION['username'] = $row['username'];
			$_SESSION['loggedin'] = "1";
			header('Location: index.php');
		}
	}
?>