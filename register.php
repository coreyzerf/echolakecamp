<?php
	$title = "Registration";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	if ($isadmin){
		$_SESSION['fmsg'] = "Staff currently cannot register for camp.";
	}elseif (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$eligible = eligible($username, 1);
		$querycamper = "SELECT * FROM `EchoPeople` WHERE username='$username'";
		$querycamp = "SELECT * FROM `camps` WHERE UNIX_TIMESTAMP(date) >= UNIX_TIMESTAMP(DATE(NOW()))";
		$resultcamper = mysqli_query($connection, $querycamper) or die(mysqli_error($connection));
		$resultcamp = mysqli_query($connection, $querycamp) or die(mysqli_error($connection));
		if($resultcamp->num_rows == 0){
			$_SESSION['wmsg'] = "There are no active camps";
		}
		if($resultcamper->num_rows == 0){
			$_SESSION['wmsg'] = "Something went wrong.";
		}		
	}elseif (isset($_POST['username']) && isset($_POST['password'])){
        $id = uniqid();
        $_SESSION["id"] = $id;
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$first = filter_input(INPUT_POST, 'first', FILTER_SANITIZE_STRING);
		$last = filter_input(INPUT_POST, 'last', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);	
		$username = strtolower($username);
		//$parent = $_POST['isparent']; 
		$encpass = password_hash($password, PASSWORD_DEFAULT);
		$created = date('Y-m-d H:i:s');
		
		if (pwverify($password)){
			$query = "INSERT INTO `EchoPeople` (id,username,first,last,password,email,created,activesent) VALUES ('$id','$username','$first','$last','$encpass','$email',now(),now());";
			$result = mysqli_query($connection, $query);
			if($result){
				unset($_SESSION['fmsg']);
				//$_SESSION['smsg'] = "User Created Successfully.";
				
				$actual_link = "http://$_SERVER[HTTP_HOST]/"."activate.php?id=" . $id;
				$actual_link = "http://$_SERVER[HTTP_HOST]/"."activate.php?id=" . $id;
				$toEmail = $_POST["email"];
				$subject = "User Registration Activation Email";
				$content = "
				<html>
				<body>
				<p>Hey " . $first . " " . $last . "!</p>
				<p>Please click this link to activate your account.</p>
				<p>" . $actual_link . "</p>
				<p>NOTE: You have not registered for any camps yet.</p>
				<p>Thanks,</p>
				<p>Echo Lake Staff</p>
				";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
				$headers .= 'From: Echo Lake Staff <echo@zerf.ca>' . "\r\n";
				if(mail($toEmail, $subject, $content, $headers, "-f echo@zerf.ca")) {
					$_SESSION['smsg'] = "We have sent you an activation email. Please click the activation link to activate your account.";
					header('Location: login.php');
				}
				unset($_POST);
				
				}
			else
				{
				unset($_SESSION['smsg']);
				$_SESSION['fmsg'] ="User Registration Failed " . mysqli_error($connection);
			}
		}else{
			unset($_SESSION['smsg']);
			$_SESSION['fmsg'] = "Password must be at least 8 characters and contain 1 number";
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
							if (isset($_SESSION['username'])){
								if ($isadmin){
									echo '<a class="button buttonwide button-top" href="index.php">Back</a>';
								}else{
									
									echo '<h2>REGISTER FOR A CAMP</h2>';
										if (!$eligible){
											echo '<p>You are not eligible to register for camp. Please check the errors and your profile and try again.</p>';
											echo '<a class="button buttonwide button-top" href="profile.php">Profile</a>';
										}else{
											echo '<p>Great! You are eligible to register for the following camps:';
											echo '<table>';
											echo '<form class="form-signin" method="POST" action="./confirm.php">';
											while($rowcamp = $resultcamp->fetch_assoc()){
												$campid = $rowcamp['campid'];
												$season = $rowcamp['season'];
												$date = $rowcamp['date'];
												echo '<tr>';
												echo "<td class='h'>" . $season . " Camp " . date("Y", strtotime($date)) . "</td>";
												echo "<td><button class=\"button\" name=\"register\" value=\"" . $campid ."\" type=\"submit\">Register </button></td>";
												echo '</tr>';
											}
											echo "</table>";
											echo "</form>";
										echo '<a class="button buttonwide button-top" href="index.php">Back</a>';
										}
								}
							}else{
								echo '<h2>BE A CAMPER TODAY!</h2>';
								echo '<form class="form-signin" method="POST">';
									echo "<input type=\"text\" name=\"username\" class=\"form-control\" placeholder=\" Username\" value=\"" . $_POST['username'] . "\" required>";
									echo "<input type=\"text\" name=\"first\" class=\"form-control formleft\" placeholder=\" First Name\" value=\"" . $_POST['first'] . "\" required>";
									echo "<input type=\"text\" name=\"last\" class=\"form-control formright\" placeholder=\" Last Name\" value=\"" . $_POST['last'] . "\" required>";
									echo "<input type=\"email\" name=\"email\" id=\"inputEmail\" class=\"form-control\" placeholder=\" Email address\" value=\"" . $_POST['email'] . "\" required>";
									echo "<input type=\"password\" name=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\" Password\" required>";
									echo '<!--<div class="checkbox">';
										echo '<label>';
											echo '<input type="checkbox" name="isparent" value="1"> I am a parent';
										echo '</label>';
									echo '</div> <div class="checkbox">';
									  echo '<label>';
										echo '<input type="checkbox" value="remember-me"> Remember me';
									  echo '</label>';
									echo '</div> -->';
									echo '<button class="button buttonwide" type="submit">Create Account</button>';
									echo '<a class="button buttonwide button-top-tiny" href="login.php">Login</a>';
								echo '</form>';
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