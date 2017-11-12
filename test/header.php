<?php
	require('connect.php');
	require('functions.php');
	
	session_start();

	$page = $_SERVER['PHP_SELF'];
	$now = time(); // or your date as well
	$your_date = strtotime("2017-05-19");
	$datediff = $your_date - $now;
	$until = floor($datediff / (60 * 60 * 24));
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
		// last request was more than 30 minutes ago
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
		session_start();
		$_SESSION['wmsg'] = "You have been logged out";
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	if (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$verify = acctverify($username);
		if ($verify){
			$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$row = $result->fetch_assoc();
			$isadmin = $row["isstaff"];
		}
	} else {
		$verify = 0;
	}
	ini_set('SMTP','zerf.ca');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title?></title>	
	<link rel="stylesheet" href="css/style.css" type="text/css">
		
		
	<script>
		function goBack() {
			window.history.back();
		}		
</script>
	
</head>
<body>
	<div class="header">
		<div>
			<a href="index.php" id="logo"><img src="images/els.png" alt="logo"></a>
			<div class="days">
				<p>
					Next Camp In: <?php echo $until; ?> Days
				</p>
			</div>
			<ul>
				<li class="<?php if (strpos($page, 'index') !== false) { echo 'selected'; } else { echo 'notselected'; } ?>">
					<a href="index.php">Home</a>
				</li>
				<li class=<?php if (strpos($page, 'register') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?> <?php if ( $isadmin ){echo "style=\"display:none;\"";}?>>
					<a href="register.php">Register</a>
				</li>
				<li class=<?php if (strpos($page, 'admin') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?> <?php if ( !$isadmin ){echo "style=\"display:none;\"";}?>>
					<a href="admin.php">Admin</a>
				</li>
				<li class=<?php if (strpos($page, 'programs') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?>>
					<a href="programs.php">About</a>
				</li>
				<!--li class=<?php if (strpos($page, 'blog') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?>>
					<a href="blog.php">Blog</a>
				</li>
				<li class=<?php if (strpos($page, 'staff') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?>>
					<a href="staff.php">Staff</a>
				</li>-->
				<li class=<?php if (strpos($page, 'contact') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?>>
					<a href="contact.php">Contact</a>
				</li>
				<li class=<?php if (strpos($page, 'profile') !== false) { echo '"selected"'; } else { echo '"notselected"'; } ?> <?php if ( !$verify ){echo "style=\"display:none;\"";}?>>
					<a href="profile.php">Profile</a>
				</li>
				<li class="notselected" <?php if ( !$verify ){echo "style=\"display:none;\"";}?>>
					<a href="logout.php">Logout</a>
				</li>
			</ul>
			
		</div>
		
	
	
	
	<!--PHP HEADER END-->