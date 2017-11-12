<?php
	$title = "Registration";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$today = time();
	
	if ( !acctverify($_SESSION['username'])){
	session_unset();
	$_SESSION['fmsg'] = "You are not logged in.";
	header('Location: index.php');
	}elseif (isset($_POST['method'])){
		$method = $_POST['method'];
		$username = $_SESSION['username'];
		$campid = $_POST['campid'];
		
		if ($method == "cheque") {
			$querycamper = "SELECT * FROM `EchoPeople` WHERE username='$username'";
			$querycamp = "SELECT * FROM `camps` WHERE campid='$campid'";
			$resultcamper = mysqli_query($connection, $querycamper) or die(mysqli_error($connection));
			$resultcamp = mysqli_query($connection, $querycamp) or die(mysqli_error($connection));
			if($resultcamp->num_rows == 0){
				$_SESSION['wmsg'] = "There are no active camps";
			}
			if($resultcamper->num_rows == 0){
				$_SESSION['wmsg'] = "Something went wrong.";
			}
			
			$camper = $resultcamper->fetch_assoc();
			$camp = $resultcamp->fetch_assoc();			
			$id = $camper['id'];
			$price = $_POST['price'];
			
			$query = "INSERT INTO " . $campid . " (camperid,amtpaid) VALUES ('$id','$price');";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['smsg'] = "Successfully Registered.";
				$registered = 1;
			}else{
				$_SESSION['fmsg'] = "Registration Failed, " . mysqli_error($connection);
				$registered = 0;
			}
			
			$attended = $camper['attended'] + 1;
			$query = "UPDATE EchoPeople SET attended='$attended' WHERE username='$username'";
			$result = mysqli_query($connection, $query);
			
			$registered = $camp['registered'] + 1;
			$query = "UPDATE camps SET registered='$registered' WHERE campid='$campid'";
			$result = mysqli_query($connection, $query);			
		}
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="register">
			<div>
				<div>
					<div class="register">
						<?php
							if ($registered){
								echo '<h3>Registered!</h3>';
								if ($method == "cheque"){
									echo "<p>Great! Please make a cheque out to \"Echo Lake Youth Ministries\" and send it to:</p>";
									echo "<p><b>Susan Zerf<br>";
									echo "1616 Edenwood Dr<br>";
									echo "Oshawa, Ont<br>";
									echo "L1G 7Y6</b></p>";
								}else{
									echo "<br><p>Great! You are all registered! You should recieve confirmation from our registrar a couple weeks before camp starts</p>";
								}
							}else{
								echo '<h3>UH-OH!</h3>';
								echo "<br><p>Something has gone wrong. But never fear, everything can be fixed! Please try again, or contact echoregistrar@gmail.com</p>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>