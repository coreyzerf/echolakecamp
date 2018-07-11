<?php
	$title = "Profile";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	if ( !acctverify($_SESSION['username'])){
		session_unset();
		$_SESSION['fmsg'] = "You are not logged in.";
		header('Location: login.php');
	}elseif ( isset($_POST['optin'])){ 

		$query = "INSERT `optin` (email) VALUES ($email) ;";
        $result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['smsg'] = "Saved.";
		}else{
            $_SESSION['fmsg'] = "Save failed, " . mysqli_error($connection);
		}
    }
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
	 
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$row = $result->fetch_assoc();
	if (!isset($row['id'])){
		session_unset();
		$_SESSION['fmsg'] = "Something went wrong";
		header('Location: index.php');
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="profile">
			<div>
				<div>
					<div class="profile">
						<h2>Profile</h2>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>