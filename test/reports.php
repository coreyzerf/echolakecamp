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
							<p> COMING SOON </p>
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