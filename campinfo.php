<?php
	$title = "Registration";
	include('header.php');
	//require('connect.php');
	//require('functions.php');
	if ( !acctverify($_SESSION['username'])){
		session_unset();
		$_SESSION['fmsg'] = "You are not logged in.";
		header('Location: login.php');
	}
	$campid = $_POST['campid'];
	
	if (isset($_POST['save'])){
		$dothis = $_POST['save'];
		echo $dothis;
		if ($dothis == "save"){
			echo saving;
			foreach ($_POST['id'] as $id){
				$paid = $_POST['paid'][$id];
				$query = "UPDATE " . $campid . " SET amtpaid='$paid' WHERE camperid='$id';";
				$result = mysqli_query($connection, $query);
				if($result){
					$_SESSION['smsg'] = "Saved.";
				}else{
					$_SESSION['fmsg'] = "Save failed, " . mysqli_error($connection);
				}
			}
		} elseif ($dothis == "delete") {
			echo deleting;
			foreach ($_POST['id'] as $id){
				if ($_POST['checked'][$id]) {
					$query = "DELETE FROM " . $campid . " WHERE camperid='$id';";
					$result = mysqli_query($connection, $query);
					if($result){
						$_SESSION['smsg'] = "Saved.";
					}else{
						$_SESSION['fmsg'] = "Save failed, " . mysqli_error($connection);
					}
				}
			}
		}
	}
	$query = "SELECT EchoPeople.first, EchoPeople.last, EchoPeople.id, " . $campid . ".amtpaid\n"
    . "FROM EchoPeople, " . $campid . "\n"
    . "WHERE EchoPeople.id = " . $campid . ".camperid";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	if($result->num_rows == 0){
		$_SESSION['wmsg'] = "There are no registered campers";
	}
	
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="register">
			<div>
				<div>
					<div class="register">
						<h3>Camper Details</h3>
						<form class="form-signin" method="POST">
						<table>
						<?php
							while($row = $result->fetch_assoc()){
								$id = $row['id'];
								echo "<input type=\"hidden\" name=\"id[]\" value=\"$id\">";
								echo "<tr>";
								echo "<td class=\"h\">" . $row['first'] . " " . $row['last'] . "</td><td> <input type=\"text\" name=\"paid[". $id ."]\" class=\"form-control formright\" placeholder=\"Parent\" required value=\"" . $row['amtpaid'] . "\"></td><td><input type=\"checkbox\" name=\"checked[$id]\" value=\"1\"></td>\n";
								echo "</tr>";
							}
						?>
						</table>
						
							<input type="hidden" name="campid" value="<?php echo $campid; ?>">
							<button class="button buttonwide button-top" name="save" value="save" type="submit">Save</button>							
							<button class="button buttonwide button-top" name="save" value="delete" type="submit">Unregister</button>							
						</form>
						<form class="form-signin" method="POST" action="./edit.php">
							<button class="button buttonwide button-top" name="campid" value="<?php echo $campid; ?>" type="submit">Back</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>