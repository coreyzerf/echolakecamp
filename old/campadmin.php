<?php
	$title = "Home - Echolakecamp.org";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$date = date('Y-m-d');
	if ( !acctverify($_SESSION['username'])){
	session_unset();
	$_SESSION['fmsg'] = "You are not logged in.";
	header('Location: index.php');
	}	
?>
<div class="container">
<?php
	$username = $_SESSION['username'];
	if ( isset($_SESSION['username']) && !$verify){
		session_unset();
		session_destroy();
		session_start();
		$_SESSION['fmsg'] = "You are not logged in.";
	}elseif ( isset($_POST['delete'])){
		$delete = $_POST['delete'];
		unset($_POST);
		$query = "DELETE FROM camps WHERE campid = '" . $delete . "';";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		if($result){
			$query = "DROP TABLE " . $delete . ";";
			$result = mysqli_query($connection, $query);
			if($result){
				unset($_SESSION['fmsg']);
				$_SESSION['smsg'] = "Camp Deleted Successfully.";
			}else{
				unset($_SESSION['smsg']);
				$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
			}
		}else{
			unset($_SESSION['smsg']);
			$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
		}
	}
	
	echo '<form class="form-signin" method="POST">';
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `camps`";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	if($result == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\">There are no active camps.</div>";
	}
	while($row = $result->fetch_assoc()){
		$campid = $row['campid'];
		echo "<p>Season: " . $row['season'] . " Date: " . $row['date'] . " Registered: " . $row['registered'] . " ID: " . $row['campid'] . "\n";
		echo "<button class=\"btn btn-lg btn-danger btn-block\" name=\"delete\" value=\"" . $campid ."\"  type=\"submit\">Delete camp " . $campid ."</button>\n";
		echo "</p>\n";
	}
	?>
	<a class="btn btn-lg btn-primary btn-block" href="index.php">Home</a>
	</form>
	<?php
	//$row = $result->fetch_assoc();
	//echo "<p>Season: " . $camp[$i]['season'] . " Date: " . $camp[$i]['date'] . " Registered: " . $camp[$i]['registered'] . "</p>";
	
?>