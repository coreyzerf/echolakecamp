<?php
	$title = "Admin Settings - Echolakecamp.org";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d');
	if ( !acctverify($_SESSION['username'])){
		session_unset();
		$_SESSION['fmsg'] = "You are not logged in.";
		header('Location: index.php');
	}elseif (!$isadmin){
		header('Location: index.php');
	}elseif (isset($_POST['season'])){
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
		$speaker = $_POST['speaker'];			
		$query = "INSERT INTO `camps` (campid,season,date,enddate,regprice,early,earlyprice,earliest,earliestprice,camplimit,speaker) VALUES ('$campid','$season','$date','$enddate','$regprice','$early','$earlyprice','$earliest','$earliestprice','$camplimit','$speaker');";
		$result = mysqli_query($connection, $query);
		if($result){
			$query = "CREATE TABLE " . $campid . " (camperid VARCHAR(40), amtpaid INT(6), UNIQUE(camperid));";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['smsg'] = "Camp Created Successfully.";
				unset($_POST);
				$_SESSION['campid'] = $campid;
				header('Location: edit.php');
			}else{
				$_SESSION['fmsg'] = "Camp Registration Failed " . mysqli_error($connection);
			}
		}else{
			$_SESSION['fmsg'] = "Camp Registration Failed " . mysqli_error($connection);
		}
    }elseif (isset($_POST['campid'])){
		$edit = 1;
		$campid = $_POST['campid'];
		$query = "SELECT * FROM camps WHERE campid='$campid'";
		 
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		if (!isset($row['campid'])){
			session_unset();
			$_SESSION['fmsg'] = "Something went wrong";
			header('Location: index.php');
		}
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div>
			<div>
				<div>
					<div class="blog">
						<h2>Admin Settings</h2>
							<form class="form-signin" method="POST">
							<p>Season: <select class="form-control" name="season" required >
								<option value="Summer">Summer</option>
								<option value="Fall">Fall</option>
								<option value="Winter">Winter</option>
								<option value="Spring">Spring</option>
							</select></p>
							<p>Start Date:
							<input type="date" name="date" class="form-control" placeholder="Start Date" required >
							</p>
							<p>Regular Price:
							<input type="text" name="regprice" class="form-control" placeholder="Regular Price" required >
							</p>
							<p>Early Bird Date:
							<input type="date" name="early" class="form-control" >
							</p>
							<p>Early Bird Price:
							<input type="text" name="earlyprice" class="form-control" placeholder="Early Bird Price" >
							</p>
							<p>Earliest Bird Date:
							<input type="date" name="earliest" class="form-control" >
							</p>
							<p>Earliest Bird Price:
							<input type="text" name="earliestprice" class="form-control" placeholder="Earliest Bird Price" >
							</p>
							<p>Camper Limit:
							<input type="text" name="camplimit" class="form-control" placeholder="Camper Limit" value="115" required >
							</p>
							<p>Speaker:
							<input type="text" name="speaker" class="form-control" placeholder="Speaker" >
							</p>
							<button class="button buttonwide button-top" type="submit">Create Camp</button>
							<a class="button buttonwide button-top" href="campadmin.php">Back</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>