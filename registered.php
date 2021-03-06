<?php
	$title = "Registration";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$today = time();
	
	if ( !acctverify($_SESSION['username'])){
	//session_unset();
	$_SESSION['fmsg'] = "You are not logged in.";
	//header('Location: index.php');
	}elseif($_POST['friend']){
		$id = $_SESSION['id'];
		$campid = $_SESSION['campid'];
		$friend = $_POST['friend'];
		$query = "UPDATE " . $campid . " SET friend='$friend' WHERE camperid='$id'";
		$result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['smsg'] = "Roommate request saved.";
			header('Location: index.php');
		}else{
            $_SESSION['fmsg'] = "Roommate request failed, " . mysqli_error($connection);
		}
		$registered = 1;
	}elseif (isset($_POST['method']) or isset($_GET['st'])){
		if (isset($_POST['method'])){
			$method = $_POST['method'];
		} else {
			$method = "Paypal";
		}
		$username = $_SESSION['username'];
		$campid = $_SESSION['campid'];

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
		$friend = $_POST['friend'];
		$camper = $resultcamper->fetch_assoc();
		$camp = $resultcamp->fetch_assoc();			
		$id = $camper['id'];
		$first = $camper['first'];
		$last = $camper['last'];
		$email = $camper['email'];
		$season = $camper['season'];
		if (isset($_GET['amt'])){
			$price =  (int)$_GET['amt'];
			
		}else{
			$price = $_POST['price'];
		}
		$friend = '';
		$query = "INSERT INTO " . $campid . " (camperid,amtpaid,friend) VALUES ('$id','$price','$friend');";
		$result = mysqli_query($connection, $query);
		if($result){
			$_SESSION['smsg'] = "Successfully Registered.";
			$aregistered = 1;
		}else{
			$_SESSION['fmsg'] = "Registration Failed, " . mysqli_error($connection);
			$aregistered = 0;
		}
		
		$attended = $camper['attended'] + 1;
		$query = "UPDATE EchoPeople SET attended='$attended' WHERE username='$username'";
		$result = mysqli_query($connection, $query);
		
		$registered = $camp['registered'] + 1;
		$query = "UPDATE camps SET registered='$registered' WHERE campid='$campid'";
		$result = mysqli_query($connection, $query);
		
		$collected = $camp['collected'] + $price;
		$query = "UPDATE camps SET collected='$collected' WHERE campid='$campid'";
		$result = mysqli_query($connection, $query);	
		
		$toEmail = $email;
		$subject = "Registered! | Echolakecamp.ca";
		$content = "
		<html>
		<body>
		<p>Hey " . $first . " " . $last . "!</p>
		<p>You've recieved this email because you have successfully registered for " . $season . " Camp!</p>
		<p>You can expect a acceptance letter soon with more details!</p>
		<br/>
		<p>In the meantime, please your cheque to:</p>
		<p><b>Susan Zerf<br />1616 Edenwood Dr<br />Oshawa, Ont<br />L1G 7Y6</b></p>
		<br />
		<p>Thanks,</p>
		<p>Echo Lake Staff</p>
		";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
		$headers .= 'From: Echo Lake Staff <echo@zerf.ca>' . "\r\n";
		if(mail($toEmail, $subject, $content, $headers, "-f echo@zerf.ca")) {
			$_SESSION['smsg'] .= "<br />We have sent a confirmation email";
		}
		
		$query = "SELECT * FROM `EchoPeople` ORDER BY `last`, `first`";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			if($result->num_rows == 0){
				$_SESSION['wmsg'] = "Something Broke.";
			}
		$_GET['st'] = "";
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
							echo $aregistered;
							if ($aregistered){
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
								echo "";
								?>
								<form class="form-signin" method="POST">
								<table>
									<tr><td class="h">Roommate Request:</td>
									<td>
										<?php
										echo "<input list=\"friends\" class=\"form-control\" name=\"friend\" autocomplete=\"off\">";
										echo "<datalist id=\"friends\">";
											while($row = $result->fetch_assoc()){
												$cuserid = $row['id'];
												$cfirst = $row['first'];
												$clast = $row['last'];
												echo "<option data-value=\"" .$cuserid . "\" >" . $cfirst . " " . $clast . "</option>\n";
											}
										echo "</datalist>";
										?>
									</td></tr></table>
									<button name="sfriends" class="button buttonwide" type="submit">Save</button>
									</form>
							<?php
							}else{
								echo '<h3>UH-OH!</h3>';
								echo "<br><p>Something has gone wrong. But never fear, everything can be fixed! Please try again, or contact echoregistrar@gmail.com</p>";

								 foreach ($_POST as $key => $value) {
								  echo '<p>'.$key.'</p>';
								  foreach($value as $k => $v)
								  {
								  echo '<p>'.$k.'</p>';
								  echo '<p>'.$v.'</p>';
								  echo '<hr />';
								  }

								} 
							}
						?>
						
						<a class="button buttonwide button-top-tiny" href="index.php">Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>