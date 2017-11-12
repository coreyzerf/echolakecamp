<?php
	$title = "Registration";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	if (isset($_SESSION['username'])){
		unset($_SESSION['smsg']);
		$_SESSION['fmsg'] = "You already have an account";
		header('Location: index.php');
	}elseif (isset($_POST['username']) && isset($_POST['password'])){
        $id = uniqid();
        $_SESSION["id"] = $id;
		$username = strtolower($_POST['username']);
		$email = $_POST['email'];
		//$parent = $_POST['isparent'];
        $password = $_POST['password']; 
		$encpass = password_hash($password, PASSWORD_DEFAULT);
		$created = date('Y-m-d H:i:s');
		
		if (pwverify($password)){
			$query = "INSERT INTO `EchoPeople` (id,username,password,email,created,activesent) VALUES ('$id','$username','$encpass','$email',now(),now());";
			$result = mysqli_query($connection, $query);
			if($result){
				unset($_SESSION['fmsg']);
				//$_SESSION['smsg'] = "User Created Successfully.";
				
				$actual_link = "http://$_SERVER[HTTP_HOST]/"."activate.php?id=" . $id;
				$toEmail = $_POST["email"];
				$subject = "User Registration Activation Email";
				$content = "
				<html>
				<body>
				<p>Hey " . $username . "</p>
				<p>Please click this link to activate your account</p>
				<p>" . $actual_link . "</p>
				<p>Thanks,</p>
				<p>Echo Lake Staff</p>
				";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
				$headers .= 'From: Echolakecamp.org<admin@echo.zerf.ca>' . "\r\n";
				if(mail($toEmail, $subject, $content, $headers)) {
					$_SESSION['smsg'] = "We have sent you an activation email. Please click the activation link to activate your account.";	
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
    ?>

<div class="container">
	<form class="form-signin" method="POST">
		<h2 class="form-signin-heading">Please Register</h2>
		<input type="text" name="username" class="form-control" placeholder="Username" required>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<!--<div class="checkbox">
			<label>
				<input type="checkbox" name="isparent" value="1"> I am a parent
			</label>
		</div> <div class="checkbox">
		  <label>
			<input type="checkbox" value="remember-me"> Remember me
		  </label>
		</div> -->
		<button class="btn btn-lg btn-primary btn-block" type="submit">Create Account</button>
		<a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
	</form>
</div>
 
<?php 
	include('footer.php')
?>