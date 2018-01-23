<?php
	$title = "Application - Echolakecamp.ca";
	require('header.php');
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="applications">
			<div>
				<div>
					<div class="application">
						<h2>STAFF APPLICATION</h2>
						<form action="index.php">
							<div>
								<table>
									<tr>
										<td><label for="name">Name:</label></td>
										<td><input type="text" id="name"></td>
									</tr>
									<tr>
										<td><label for="nickname">Nickname:</label></td>
										<td><input type="text" id="nickname"></td>
									</tr>
									<tr>
										<td><label for="gender1">Gender:</label></td>
										<td><input type="radio" name="gender" id="gender1" value="male">
											Male
											<input type="radio" name="gender" id="gender2" value="female">
											Female </td>
									</tr>
									<tr>
										<td><label for="position">Position:</label></td>
										<td><input type="text" id="position"></td>
									</tr>
									<tr>
										<td><label for="address">Address:</label></td>
										<td><textarea name="address" id="address" cols="30" rows="5"></textarea></td>
									</tr>
								</table>
							</div>
							<div>
								<table>
									<tr>
										<td><label for="birthdate">Birthdate:</label></td>
										<td><input type="text" id="birthdate"></td>
									</tr>
									<tr>
										<td><label for="age">Age:</label></td>
										<td><input type="text" id="age"></td>
									</tr>
									<tr>
										<td><label for="phone-number">Phone Num.:</label></td>
										<td><input type="text" id="phone-number"></td>
									</tr>
									<tr>
										<td><label for="email">Email Add:</label></td>
										<td><input type="text" id="email"></td>
									</tr>
								</table>
							</div>
							<input type="submit" value="submit application" id="application-submit">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>