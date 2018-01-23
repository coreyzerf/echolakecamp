<?php
	$title = "Admin Settings - Echolakecamp.ca";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d');
	if ( !acctverify($_SESSION['username'])){
		session_unset();
		$_SESSION['fmsg'] = "You are not logged in.";
		header('Location: admin.php');
	}elseif (isset($_POST['save'])){
		$campid = $_POST['campid'];
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
		//$query = "INSERT INTO `camps` (season,date,enddate,regprice,early,earlyprice,earliest,earliestprice,camplimit,speaker) VALUES ('$season','$date','$enddate','$regprice','$early','$earlyprice','$earliest','$earliestprice','$camplimit','$speaker');";
		$query = "UPDATE `camps` SET season='$season' , date='$date' , enddate='$enddate' , regprice='$regprice' , early='$early' , earlyprice='$earlyprice' , earliest='$earliest' , earliestprice='$earliestprice' , camplimit='$camplimit',speaker='$speaker' WHERE campid='".$campid."';";
		$result = mysqli_query($connection, $query);
		if($result){
			if($result){
				$_SESSION['smsg'] = "Camp Updated Successfully.";
			}else{
				$_SESSION['fmsg'] = "Camp Update Failed " . mysqli_error($connection);
			}
		}else{
			$_SESSION['fmsg'] = "Camp Update Failed " . mysqli_error($connection);
		}
    }elseif ( isset($_POST['delete'])){
		$delete = $_POST['delete'];
		unset($_POST);
		$query = "DELETE FROM camps WHERE campid = '" . $delete . "';";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		if($result){
			$query = "DROP TABLE " . $delete . ";";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['smsg'] = "Camp Deleted Successfully.";
			}else{
				$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
			}
		}else{
			$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
		}
	}
	if (isset($_POST['campid'])){
		$campid = $_POST['campid'];
	}elseif (isset($_SESSION['campid'])){
		$campid = $_SESSION['campid'];
		unset($_SESSION['campid']);
	}else{
		$campid = $_POST['edit'];
	}
	$query = "SELECT * FROM camps WHERE campid='$campid'";
	 
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$row = $result->fetch_assoc();
	if (!isset($row['campid'])){
		$_SESSION['fmsg'] = "Something went wrong";
		header('Location: admin.php');
	}
	$campid = $row['campid'];
	
	$total = 0;
	$query = "SELECT amtpaid FROM  . $campid;";
	$res = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($i = $res->fetch_assoc()){ $total += $i['amtpaid']; }
	
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
								<option value="Summer" <?php if ($row['season']=="Summer"){echo selected;}?> >Summer</option>
								<option value="Fall" <?php if ($row['season']=="Fall"){echo selected;}?> >Fall</option>
								<option value="Winter" <?php if ($row['season']=="Winter"){echo selected;}?> >Winter</option>
								<option value="Spring" <?php if ($row['season']=="Spring"){echo selected;}?> >Spring</option>
							</select></p>
							<p>Start Date:
							<input type="date" name="date" class="form-control" placeholder="Start Date" value="<?php echo $row['date'];?>" required >
							</p>
							<p>Regular Price:
							<input type="text" name="regprice" class="form-control" placeholder="Regular Price" value="<?php echo $row['regprice'];?>" required >
							</p>
							<p>Early Bird Date:
							<input type="date" name="early" class="form-control" value="<?php echo $row['early'];?>" >
							</p>
							<p>Early Bird Price:
							<input type="text" name="earlyprice" class="form-control" placeholder="Early Bird Price" value="<?php echo $row['earlyprice'];?>" >
							</p>
							<p>Earliest Bird Date:
							<input type="date" name="earliest" class="form-control" value="<?php echo $row['earliest'];?>" >
							</p>
							<p>Earliest Bird Price:
							<input type="text" name="earliestprice" class="form-control" placeholder="Earliest Bird Price" value="<?php echo $row['earliestprice'];?>" >
							</p>
							<p>Camper Limit:
							<input type="text" name="camplimit" class="form-control" placeholder="Camper Limit" value="<?php echo $row['camplimit'];?>" required >
							</p>
							<p>Registered:
							<input type="text" name="registered" class="form-control" placeholder="Registered" value="<?php echo $row['registered'];?>" readonly >
							</p>
							<p>Speaker:
							<input type="text" name="speaker" class="form-control" placeholder="Speaker" value="<?php echo $row['speaker'];?>" >
							</p>
							<p>Amount Collected:
							<input type="text" name="total" class="form-control" placeholder="Total" value="<?php echo $total;?>" readonly >
							</p>
							<p hidden>Camp ID:
							<input hidden type="text" name="campid" class="form-control" placeholder="Camp ID" value="<?php echo $row['campid'];?>" readonly >
							</p hidden>
							<button class="button buttonwide button-top" name="save" value="save" type="submit">Save</button>
							<button class="button buttonwide button-top" name="delete" value="<?php echo $campid; ?>" type="submit" <?php if ( strtotime("now") > strtotime($row['date']) ) { echo "disabled"; echo " title=\"Can't delete past camps. Contact Corey for assistance\"";}?> onclick="return confirm('Are you sure you want to delete this item?');" >Delete</button>
						</form>
						<form class="form-signin" method="POST" action="./campinfo.php">
							<?php echo "<button class=\"button buttonwide button-top\" name=\"campid\" value=\"" . $campid ."\" type=\"submit\">Registered Campers</button>"; ?>
						</form>
						<a class="button buttonwide button-top" href="campadmin.php">Back</a>

					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>