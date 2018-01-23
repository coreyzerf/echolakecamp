<?php
	$title = "Registration";
	include('header.php');
	include('destroy.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d h:i:s');
	$ready = 0;
	
	if (isset($_POST['reset'])){
		$ready = 0;
		$newpass = $_POST['reset'];
		$encpass = password_hash($newpass, PASSWORD_DEFAULT);
		$id = $_POST['userid'];
		$uniq = $_POST['uniq'];
		$query = "UPDATE EchoPeople SET password='$encpass' WHERE id='$id'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$num = $result->num_rows;
		if($result){
			$_SESSION['smsg'] = "Password update successfully";
			$query = "DELETE FROM `passReset` WHERE uniq='$uniq'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		} else {
			$_SESSION['fmsg'] = "Something has gone wrong";
		}
	} elseif (isset($_GET['id'])){
		$uniq = $_GET['id'];
		$query = "SELECT * FROM `passReset` WHERE uniq='$uniq'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$num = $result->num_rows;
		if( $num > 0){
			$row = $result->fetch_assoc();
			$ready = 1;
			$id = $row['id'];
		} else {
			$_SESSION['fmsg'] = "Something has gone wrong";
		}
	} elseif (isset($_POST['input'])){
		$input = $_POST['input'];
		if(filter_var($input, FILTER_VALIDATE_EMAIL)) {
			$input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_EMAIL);
			$querycamper = "SELECT * FROM `EchoPeople` WHERE email='$input'";
			$resultcamper = mysqli_query($connection, $querycamper) or die(mysqli_error($connection));
			$rowcamper = $resultcamper->fetch_assoc();
			$uniq = generateRandomString();
			$id = $rowcamper['id'];
			$first = $rowcamper['first'];
			$last = $rowcamper['last'];
			$email = $rowcamper['email'];	

			$query = "INSERT INTO `passReset` (id,uniq) VALUES ('$id','$uniq');";
			$result = mysqli_query($connection, $query);			
			
			$actual_link = "https://$_SERVER[HTTP_HOST]/test/"."forgot.php?id=" . $uniq;
			$toEmail = $email;
			$subject = "Password Reset | Echolakecamp.ca";
			$content = "
			<html>
			<body>
			<p>Hey " . $first . " " . $last . "!</p>
			<p>Please click this link to reset your password!.</p>
			<p>" . $actual_link . "</p>
			<p>If you didn't request this, you can safely ignore.</p>
			<p>Thanks,</p>
			<p>Echo Lake Staff</p>
			";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
			$headers .= 'From: Echo Lake Staff <admin@zerf.ca>' . "\r\n";
			if(mail($toEmail, $subject, $content, $headers, "-f admin@zerf.ca")) {
				$_SESSION['smsg'] = "We have sent you an email. Please click the link to reset your password.";	
			}
		} else {
			$input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);
			$querycamper = "SELECT * FROM `EchoPeople` WHERE username='$input'";
			$resultcamper = mysqli_query($connection, $querycamper) or die(mysqli_error($connection));
			$rowcamper = $resultcamper->fetch_assoc();
			$uniq = generateRandomString();
			$id = $rowcamper['id'];
			$first = $rowcamper['first'];
			$last = $rowcamper['last'];
			$email = $rowcamper['email'];
			
			$query = "INSERT INTO `passReset` (id,uniq) VALUES ('$id','$uniq');";
			$result = mysqli_query($connection, $query);
			
			$actual_link = "https://$_SERVER[HTTP_HOST]/test/"."forgot.php?id=" . $uniq;
			$toEmail = $email;
			$subject = "Password Reset | Echolakecamp.ca";
			$content = "
			<html>
			<body>
			<p>Hey " . $first . " " . $last . "!</p>
			<p>Please click this link to reset your password!.</p>
			<p>" . $actual_link . "</p>
			<p>If you didn't request this, you can safely ignore.</p>
			<p>Thanks,</p>
			<p>Echo Lake Staff</p>
			";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
			$headers .= 'From: Echo Lake Staff <admin@zerf.ca>' . "\r\n";
			if(mail($toEmail, $subject, $content, $headers, "-f admin@zerf.ca")) {
				$_SESSION['smsg'] = "We have sent you an email. Please click the link to reset your password.";	
			}
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
					<form class="form-signin" method="POST">    
						<h2 class="form-signin-heading">Forgot Password</h2>
						<?php
							if (!$ready){
								echo '<p>Please provide your username or email for the account you may have forgotten the password for</p>';
								echo '<input type="text" name="input" class="form-control" placeholder="Username or Email"  required autofocus>';
								echo '<button class="button buttonwide" type="submit">Submit</button>';
							} elseif ($ready){
								echo '<p>Please enter a new password</p>';
								echo '<input type="password" name="reset" class="form-control" placeholder="New Password"  required autofocus>';
								echo '<input type="hidden" name="userid" value="' . $id . '">';
								echo '<input type="hidden" name="uniq" value="' . $uniq . '">';
								echo '<button class="button buttonwide" type="submit">Submit</button>';
							}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	include('footer.php');
?>