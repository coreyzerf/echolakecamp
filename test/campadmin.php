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
	}elseif ( isset($_POST['delete'])){
		$delete = $_POST['delete'];
		unset($_POST);
		$query = "DELETE FROM camps WHERE campid = '" . $delete . "';";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		if($result){
			$query = "DROP TABLE " . $delete . ";";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['smsg'] = "Camp Deleted Successfully.";
			}else{
				$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
			}
		}else{
			$_SESSION['fmsg'] ="Deletion Failed " . mysqli_error($connection);
		}
	}
	$username = $_SESSION['username'];
	$query = "SELECT * FROM `camps` WHERE UNIX_TIMESTAMP(date) >= UNIX_TIMESTAMP(DATE(NOW()))";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	if($result == 0){
		$_SESSION['wmsg'] = "There are no active camps";
	}
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div>
			<div>
				<div>
					<div class="blog">
						<h2>Camp Admninistration</h2>
							<table class="diff">
							<?php
								while($row = $result->fetch_assoc()){
									$campid = $row['campid'];
									$season = $row['season'];
									echo '<tr>';
									echo '<form class="form-signin" method="POST" action="./edit.php">';
									echo "<td class='h'>Season: " . $row['season'] . " Date: " . $row['date'] . " Registered: " . $row['registered'] . "</td>";
									echo "<td class='s'><button class=\"button\" name=\"edit\" value=\"" . $campid ."\" type=\"submit\">Edit Camp </button></td>\n";
									echo "</form>";
									echo '</tr>';
								}
							?>
							</table>
							<form class="form-signin" method="POST">
							<a class="button buttonwide button-top" href="create.php">Create New Camp</a>
							<a class="button buttonwide button-top" href="camppast.php">Past Camps</a>
							<a class="button buttonwide button-top" href="admin.php">Back</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>