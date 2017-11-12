<?php
	$title = "Registration";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$id = $_GET['id'];
	$passone = $_POST['passone'];
	$passtwo = $_POST['passtwo'];
	if(!empty($id)) {
		$query = "SELECT * FROM `EchoPeople` WHERE id='$id'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		if(!$result){
			$_SESSION['fmsg'] = "Problem resetting password.";
			header('Location: login.php');
		}else{
			if (isset($_POST['passone'])){
				if( $passone == $passtwo){
					$encpass = password_hash($passone, PASSWORD_DEFAULT);
					if(pwverify($passone)){
						$query = "UPDATE EchoPeople SET password='$encpass' WHERE id='".$id."';";
						$result = mysqli_query($connection, $query);
					
						if($result) {
							$_SESSION['smsg'] = "Your password has been reset.";
							unset($_SESSION['fmsg']);
							header('Location: index.php');
						} else {
							$_SESSION['fmsg'] = "Problem resetting password.";
						}
					} else {
						$_SESSION['fmsg'] = "You password does not meet requirements";
					}					
				}else{
					$_SESSION['fmsg'] = "Password did not match.";
				}
			}			
		}
	}
?>
<div class="container">
<form class="form-signin" method="POST">
	<h2 class="form-signin-heading">Please enter your new password</h2>
	<input type="password" name="passone" id="inputPassword" class="form-control" placeholder="New Password" required>
	<input type="password" name="passtwo" id="inputPassword" class="form-control" placeholder="Verify Password" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
</form>
</div>