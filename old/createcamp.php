<?php
	$title = "Home - Echolakecamp.org";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$date = date('Y-m-d');
	$verify = acctverify($_SESSION['username']);
	
	if (isset($_POST['season'])){
        $campid = uniqid();
		$season = $_POST['season'];			
		$date = $_POST['date'];
		if ($season == "Summer"){
			$newdate = strtotime ( '+7 day' , strtotime ( $date ) ) ;
			$enddate = date ( 'Y-m-j' , $newdate );	
		}else{
			$newdate = strtotime ( '+3 day' , strtotime ( $date ) ) ;
			$enddate = date ( 'Y-m-j' , $newdate );	
		}			
		$regprice = $_POST['regprice'];			
		$early = $_POST['early'];			
		$earlyprice = $_POST['earlyprice'];			
		$earliest = $_POST['earliest'];			
		$earliestprice = $_POST['earliestprice'];			
		$camplimit = $_POST['camplimit'];			
		$query = "INSERT INTO `camps` (campid,season,date,enddate,regprice,early,earlyprice,earliest,earliestprice,camplimit) VALUES ('$campid','$season','$date','$enddate','$regprice','$early','$earlyprice','$earliest','$earliestprice','$camplimit');";
		$result = mysqli_query($connection, $query);
		if($result){
			$query = "CREATE TABLE " . $campid . " (camperid VARCHAR(40), amtpaid INT(6));";
			$result = mysqli_query($connection, $query);
			if($result){
				unset($_SESSION['fmsg']);
				$_SESSION['smsg'] = "Camp Created Successfully.";
				unset($_POST);
			}else{
				unset($_SESSION['smsg']);
				$_SESSION['fmsg'] ="Camp Registration Failed " . mysqli_error($connection);
			}
		}else{
			unset($_SESSION['smsg']);
			$_SESSION['fmsg'] ="Camp Registration Failed " . mysqli_error($connection);
		}
    }
?>

<div class="container">
	<form class="form-signin" method="POST">
		
		<p>Season: <select class="form-control" name="season" required >
			<option value="Summer">Summer</option>
			<option value="Fall">Fall</option>
			<option value="Winter">Winter</option>
			<option value="Spring">Spring</option>
		</select></p>
		<input type="date" name="date" class="form-control" placeholder="Start Date"required >
		<input type="text" name="regprice" class="form-control" placeholder="Regular Price" required >
		<input type="date" name="early" class="form-control" >
		<input type="text" name="earlyprice" class="form-control" placeholder="Early Bird Price" >
		<input type="date" name="earliest" class="form-control" >
		<input type="text" name="earliestprice" class="form-control" placeholder="Earliest Bird Price" >
		<input type="text" name="camplimit" class="form-control" placeholder="Camper Limit" required >
		<button class="btn btn-lg btn-primary btn-block" type="submit">Create Camp</button>
		<a class="btn btn-lg btn-primary btn-block" href="index.php">Cancel</a>
	</form>
</div>