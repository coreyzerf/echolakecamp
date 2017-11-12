<?php
	$title = "Registration";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	if (isset($_POST['username']) and isset($_POST['password'])){
		session_unset();
		//3.1.1 Assigning posted values to variables.
		$username = strtolower($_POST['username']);
		$password = $_POST['password'];
		$encpass = password_hash($password, PASSWORD_DEFAULT);
		//3.1.2 Checking the values are existing in the database or not
		$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
		 
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$count = mysqli_num_rows($result);
		$row = $result->fetch_assoc();
		$encpass = $row["password"];
		//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
		if ($count == 1) {
			$correct = password_verify($password, $encpass);
			if($correct == true) {				
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $row["id"];
				$_SESSION['loggedin'] = 1;
			} else {
				$_SESSION['fmsg'] = "Invalid Login Credentials.";
				
			}
		}else{
			$_SESSION['fmsg'] = "Invalid Login Credentials.";
		}
	}
	//3.1.4 if the user is logged in Greets the user with message
	if (isset($_SESSION['username'])){
		/*$username = $_SESSION['username'];
		echo "<p>" . $username . "</p>";
		echo "<p>This is the Members Area</p>";
		echo "<p>Your UUID is " . $_SESSION['id'] . "</p>";
		echo "<p><a href='logout.php'>Logout</a></p>";*/
		$_SESSION['smsg'] = "You have successfully logged in";
		header('Location: index.php');
		 
	}else{
?>
<div class="container">
    <form class="form-signin" method="POST">
		<h2 class="form-signin-heading">Please Login</h2>
		<input type="text" name="username" class="form-control" placeholder="Username" required>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<div class="checkbox">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		<a class="btn btn-lg btn-primary btn-block" href="register.php">Create an Account</a>
	</form>
</div>
<?php 
	}
	include('footer.php');
?>