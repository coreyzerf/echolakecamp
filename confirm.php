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
	}elseif (isset($_POST['register'])){
		$registered = 0;
		$register = $_POST['register'];
		$username = $_SESSION['username'];
		$querycamp = "SELECT * FROM `camps` WHERE campid = '$register';";
		$resultcamp = mysqli_query($connection, $querycamp) or die(mysqli_error($connection));	
		if($resultcamp->num_rows == 0){
			$_SESSION['wmsg'] = "Something Broke (Camp)";
			header('Location: index.php');
		}
		$camp = $resultcamp->fetch_assoc();
		$camp = $resultcamp->fetch_assoc();
		$_SESSION['campid'] = $camp['campid'];

		$query = "SELECT * FROM `EchoPeople` ORDER BY `last`, `first`";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			if($result->num_rows == 0){
				$_SESSION['wmsg'] = "Something Broke.";
			}		
		
		$querycamper = "SELECT * FROM `EchoPeople` WHERE username = '$username';";
		$resultcamper = mysqli_query($connection, $querycamper) or die(mysqli_error($connection));	
		if($resultcamp->num_rows == 0){
			$_SESSION['wmsg'] = "Something Broke (Camper)";
			header('Location: index.php');
		}
		$camper = $resultcamper->fetch_assoc();
		$camperid = $camper['id'];
		if (isregistered($connection, $register, $camperid)) {
			$_SESSION['wmsg'] = 'It would appear that you are already registered for this camp. Please contact our registrar (<a href="mailto:echoregistrar@gmail.com">echoregistrar@gmail.com</a>) for assistance';
			$registered = 1;
		}
		$datediff = strtotime($camp['early']) - $today;
		if ($datediff > 0){
			$datediff = strtotime($camp['earliest']) - $today;
			if ($datediff < 0){
				$price = $camp['earlyprice'];
			}else{
				$price = $camp['earliestprice'];
			}
		}else{
			$price = $camp['regprice'];
		}
		
	}else{
		header('Location: index.php');
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="register">
			<div>
				<div>
					<div class="register">
						<h3>Register for <?php echo $camp['season'];?> Camp <?php echo date('Y', strtotime($camp['date']));?></h3>
						<br>
						<p>It appears that all your registration information is properly filled out under your profile. Please ensure that you have entered accurate details, have included your allergies, and that your health information, emergency contact information, etc. is all correct.</p>

						<p>The registration fee is non-refundable. You may pay online using your credit card, PayPal, or you may pay by cheque.</p>
						<hr noshade>
						<br>
						<p>Please confirm that the information below is correct:</p>
						<table>
							<tr>
								<td class="h">Camper:</td><td><b><?php echo $camper['first'] . " " . $camper['last']; ?></b></td>
							</tr><tr>
								<td class="h">Birthday:</td><td><b><?php echo date('d M Y', strtotime($camper['birthday'])) . " (" . age($camper['birthday']) . " years)"; ?></b></td>
							</tr><tr>
								<td class="h">Emergency Contact:</td><td><b><?php echo $camper['emergency']; ?></b></td>
							</tr><tr>
								<td class="h">Emergency Number:</td><td><b><?php echo $camper['emergnum']; ?></b></td>
							</tr><tr>
								<td class="h">Allergies:</td><td><b><?php if (empty($camper['allergy'])){ echo "None"; } else { echo $camper['allergy']; } ?></b></td>
							</tr><tr>
								<td class="h">Health Concerns:</td><td><b><?php if (empty($camper['healthconcerns'])){ echo "None"; } else { echo $camper['healthconcerns']; } ?></b></td>
							</tr><tr>
								<td class="h">Camp:</td><td><b><?php echo $camp['season'] . " (" . date('d M Y', strtotime($camp['date'])) . " - " . date('d M Y', strtotime($camp['date']. ' + 7 days')) . ")" ; ?></b></td>
							</tr><tr>
								<td>Friend Request:</td><td>
								<select class="form-control" name="friend" id="friends">
								<?php								
									while($row = $result->fetch_assoc()){
										$cuserid = $row['id'];
										$cfirst = $row['first'];
										$clast = $row['last'];
										echo "<option value=\"" .$cuserid . "\" >" . $cfirst . " " . $clast . "</option>\n";
									}
								?>
								</select></td>
							</tr>
						</table><br>
						<hr noshade>
						<br>
						<p>Please choose the payment option below:</p>
						<?php
							if ($registered) {
								echo '<p> It would appear that you are already registered for this camp. Please contact our registrar (<a href="mailto:echoregistrar@gmail.com">echoregistrar@gmail.com</a>) for assistance</p>';
							}else{ ?>
								<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

								<!-- Identify your business so that you can collect the payments. -->
								<input type="hidden" name="business" value="corey@zerf.ca">
								
								<!-- Specify a Buy Now button. -->
								<input type="hidden" name="cmd" value="_xclick">

								<!-- Specify details about the item that buyers will purchase. -->
								<input type="hidden" name="item_name" value="<?php echo $camp['season'];?> Camp Registration">
								<input type="hidden" name="amount" value="<?php echo $price; ?>">
								<input type="hidden" name="currency_code" value="CAD">
								  
								<input type="hidden" name="email" value="<?php echo $camper['email']; ?>">
								<input type="hidden" name="custom" value="<?php echo $camper['username']; ?>">
								
								<input type="hidden" name="return" value="http://www.echolakecamp.ca/registered.php">
								  
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cancel_return" value="http://www.echolakecamp.ca/register.php">
								<input type="hidden" name="no_shipping" value="1">
								 
								<!-- Display the payment button. -->
								<button class="button buttonmedium" name="method" value="online" type="submit">Pay $<?php echo $price; ?> by PayPal</button><br>

								</form>
								<form class="form-signin" method="POST" action="./registered.php">
								<input type="hidden" name="campid" value="<?php echo $camp['campid']; ?>">
								<input type="hidden" name="price" value="<?php echo $price; ?>">
						<?php
								echo "<button class=\"button buttonmedium\" name=\"method\" value=\"cheque\" type=\"submit\">Pay $" . $price . " by Cheque</button><br>";
								//echo "<button class=\"button buttonmedium\" name=\"method\" value=\"online\" type=\"submit\">Pay $" .$price . " by PayPal</button>";
							}
						?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>