<?php
	$title = "Home - Echolakecamp.org";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$date = date('Y-m-d');
	$verify = acctverify($_SESSION['username']);
	
	
?>
<div class="container">
<?php
	if ( isset($_SESSION['username']) && !$verify){
		session_unset();
		session_destroy();
		session_start();
		$_SESSION['fmsg'] = "You are not logged in.";
	}elseif( isset($_SESSION['username']) && $verify == "2"){
		session_unset();
		$_SESSION['fmsg'] = "Your account has not been activated. Please check your email for an activation link";
	}elseif (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$loggedin = $_SESSION['loggedin'];
		
		$query = "SELECT * FROM `EchoPeople` where username='$username'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		
		$bday = $row['birthday'];
		$age = age($bday);
		$maxage = 22;
		$minage = 14;
		if( !eligible($username) ){
			$eligible = "NOT ELIGIBLE";
		}else{
			$eligible = "ELIGIBLE";
		}
			
		echo "<p class=\"text-left\">" . $date . "</p>";
		echo "<p class=\"text-left\">" . $username . "</p>";
		echo "<p class=\"text-left\">This is the Members Area</p>";
		echo "<p class=\"text-left\">Your UUID is " . $_SESSION['id'] . "</p>";
		echo "<p class=\"text-left\">" . $age . " years </p>";
		echo "<p class=\"text-left\">" . $eligible . "</p>";
		echo "<p class=\"text-left\"><a href=\"./profile.php\">Profile</a></p>";
		echo "<p class=\"text-left\"><a href=\"./createcamp.php\">Create Camp</a></p>";
		echo "<p class=\"text-left\"><a href=\"./campadmin.php\">Camp Admin</a></p>";
		echo "<p class=\"text-left\"><a href='logout.php'>Logout</a></p>";
		 
	}
?>

	<?php 
		if($loggedin){
			echo "";
		}else{
			echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"login.php\">Login</a>";
			echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"register.php\">Create an Account</a>";
			echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\".\\test\index.php\">Tour</a>";
		}
	?>
	<!-- Other Junk to go Here -->
</div>
<?php 
	include('footer.php');
?>