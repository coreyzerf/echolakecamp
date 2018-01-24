<?php
	$title = "Admin Settings - Echolakecamp.ca";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	
	$date = date('Y-m-d');
	if ( !acctverify($_SESSION['username'])){
	session_unset();
	$_SESSION['fmsg'] = "You are not logged in.";
	header('Location: index.php');
	}elseif (!$isadmin){
		header('Location: index.php');
	}
	
	$query = "SELECT * FROM `EchoPeople` ORDER BY `last`, `first`";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	if($result->num_rows == 0){
		$_SESSION['wmsg'] = "Something Broke.";
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div>
			<div>
				<div>
					<div class="blog">
						<h2>Edit Profile</h2>
						<form class="form-signin" method="POST" action="./camperprofile.php">
							<p>Enter the name of the user you are searching for:<br>
							<b>IMPORTANT: Select the username before clicking "Edit"<b></p>
							<input list="campers" class="form-control" name="camper" autocomplete="off">
								<datalist id="campers">
								<?php								
									while($row = $result->fetch_assoc()){
										$username = $row['username'];
										$first = $row['first'];
										$last = $row['last'];
										echo "<option value=\"" .$username . "\">" . $first . " " . $last . "</option>\n";
									}
								?>
								</datalist>
							<button class="button buttonwide button-top" name="edit" type="submit">Edit</button>
							<a class="button buttonwide button-top" href="newprofile.php">New</a>
							<a class="button buttonwide button-top" href="camperadmin.php">Back</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>