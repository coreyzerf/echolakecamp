<?php 
	session_unset();
	$title = "Forgot Password - Echolakecamp.org";
	include('header.php');
	require('connect.php');
	require('functions.php');

	if (isset($_POST['username'])){
		$username = $_POST['username'];
		$sentmail = 0;
		$query="SELECT * FROM `EchoPeople` WHERE username='$username'";
		$result=mysqli_query($connection, $query);
		$count=mysqli_num_rows($result);
		$rows=mysqli_fetch_array($result);
		$id = $rows['id'];
		// If the count is equal to one, we will send message other wise display an error message.
		if($count==1){		
			$actual_link = "http://$_SERVER[HTTP_HOST]/"."forgottwo.php?id=" . $id;
			$toEmail = $rows["email"];
			$subject = "Password Reset Email";
			$content = "
			<html>
			<body>
			<p>Hey " . $username . "</p>
			<p>Please click this link to reset your password</p>
			<p>" . $actual_link . "</p>
			<p>Thanks,</p>
			<p>Echo Lake Staff</p>
			";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
			$headers .= 'From: Echolakecamp.org<admin@echo.zerf.ca>' . "\r\n";
			if(mail($toEmail, $subject, $content, $headers)) {
				$_SESSION['smsg'] = "We have sent you a link to reset your password.";	
			}else{
				$_SESSION['fmsg'] = "Cannot send password to your e-mail address.Problem with sending mail..." . mysqli_error($connection);
			}
			unset($_POST);
			
		}//If the message is sent successfully, display sucess message otherwise display an error message.
		
	}
	?> 
<div class="container">
	<form class="form-signin" method="POST">
		<h2 class="form-signin-heading">Please enter your username to recover your password</h2>
		<input type="text" name="username" class="form-control" placeholder="Username" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
	</form>
</div>
 
</body>
 
</html>