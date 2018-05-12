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
						<h2>Reports</h2>
							<table class="diff">
								<?php
									while($row = $result->fetch_assoc()){
										$campid = $row['campid'];
										$season = $row['season'];
										echo '<tr>';
										echo "<td class='h'>Season: " . $row['season'] . " Date: " . $row['date'] . " Registered: " . $row['registered'] . " Paid: " . $row['collected'] . "</td>";
										echo '</tr>';
										echo '<tr>';
										echo '<form class="form-signin" method="POST" action="./reports/registrar.php">';
										echo "<td><button class=\"button buttonwide button-top\" value=\"" . $campid ."\" type=\"submit\">Registrar</button></td></form>";
										echo '<form class="form-signin" method="POST" action="./reports/registrar.php">';
										echo "<td><button class=\"button buttonwide button-top\" value=\"" . $campid ."\" type=\"submit\">Medical</button></td></form>";
										echo '<form class="form-signin" method="POST" action="./reports/registrar.php">';
										echo "<td><button class=\"button buttonwide button-top\" value=\"" . $campid ."\" type=\"submit\">Kitchen</button></td></form>";
										echo '</tr>';										
									}
								?>
								</table>
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