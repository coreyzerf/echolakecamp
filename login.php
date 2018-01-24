<?php
	$title = "Registration";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d h:i:s');
	
	if (isset($_POST['username']) and isset($_POST['password'])){
		//session_unset();
		//3.1.1 Assigning posted values to variables.
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$username = strtolower($username);
		$password = $_POST['password'];
		$encpass = password_hash($password, PASSWORD_DEFAULT);
		//3.1.2 Checking the values are existing in the database or not
		$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
		 
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$count = mysqli_num_rows($result);
		$row = $result->fetch_assoc();
		$encpass = $row["password"];
		$lastlogin = $row['lastlogin'];
		$first = $row['first'];
		//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
		if ($count == 1) {
			$activated = $row["isactive"];
			$correct = password_verify($password, $encpass);
			echo $activated;
			if (!$activated){
				$_SESSION['fmsg'] = "Sorry, your account is not activated. Please check your email for your activation link";
			}elseif($correct == true) {				
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $row["id"];
				$id = $_SESSION['id'];
				$_SESSION['loggedin'] = 1;
				$query = "UPDATE EchoPeople SET lastlogin=now() WHERE id='".$id."';";
				$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
				
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
		$_SESSION['smsg'] = "Welcome back!<br>";
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
					<form class="form-signin" method="POST">    
						<h2 class="form-signin-heading">Please Login</h2>
						<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $_POST['username']; ?>"  required autofocus>
						<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
						<!--<div class="checkbox">
							<label>
								<input type="checkbox" value="remember-me"> Remember me
							</label>
						</div>-->
						<button class="button buttonwide" type="submit">Login</button>
						<a class="button buttonwide button-top-tiny" href="register.php">Create an Account</a>
						<a href="forgot.php">Forgot Password?</a>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	}
	include('footer.php');
?>