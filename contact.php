<?php
	$title = "Contact - Echolakecamp.org";
	require('header.php');
	if (isset($_POST['save'])){
		$contact = $_POST['contact'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$name = $_POST['name'];
		$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
		if ($contact == "regist"){
		$toEmail = "registrar@echolakecamp.org";
		$staff = "Susan Zerf";
		}elseif ($contact == "rental"){
		$toEmail = "rentals@echolakecamp.org";
		$staff = "Rebecca Kennedy";
		}elseif ($contact == "summer"){
		$toEmail = "summermanager@echolakecamp.org";
		$staff = "Steve Hutchison";
		}elseif ($contact == "weeken"){
		$toEmail = "weekendmanager@echolakecamp.org";
		$staff = "Scott Kennedy";
		}elseif ($contact == "websit"){
		$toEmail = "admin@echolakecamp.org";
		$staff = "Corey Zerf";
		}elseif ($contact == "promot"){
		$toEmail = "promotions@echolakecamp.org";
		$staff = "Brittany Zerf";
		}
		$appendedsubject = "[Contact Form @ Echolakecamp.org] " . $subject;
		$content = "
		<html>
		<body>
		<p>Hey " . $staff . "</p>
		<p>". $name . "(" . $email . ") submitted a message to the contact form on the Echo Lake website. <br>
		The message can be found below.<br></p>
		<hr>
		<p>" . nl2br($message) . "</p>
		<br>
		<hr>
		<p>You can click <a href=\"mailto:".$email."?Subject=RE:".$subject."\" target=\"_top\">here</a> to reply. If not, you can contact Corey.
		<p>Thanks,</p>
		<p>Echolakecamp.org Website</p>
		";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
		$headers .= 'From: Echolakecamp.org<admin@echo.zerf.ca>' . "\r\n";
		$headers .= 'Reply-To: ' . $email . "\r\n";
		if(mail($toEmail, $appendedsubject, $content, $headers)) {
			$_SESSION['smsg'] = "Your email has been sent.";			
		}else{
			$_SESSION['fmsg'] = "Your email has not been sent.";
		}
		unset($_POST);
	}
	
	msgbox ($_SESSION['smsg'], $_SESSION['fmsg'], $_SESSION['wmsg']);
	
?>
</div>
	<div class="content">
		<div class="register">
			<div>
				<div>
					<div class="register">
						<h2>CONTACT US</h2>
							<p>
								1055 Bush Rd<br>
								Godfrey, ON K0H 2K0<br>
								<br>
								(613) 374-5727<br>
								*This number is not used except when camp is in session. 
							</p>
						</div>
						<h3>For Any Inquiries, Please Fill out The Form Below.</h3>
						<form class="form-signin" method="POST">
							<label for="name">Name:</label>
							<input type="text" name="name" class="form-control">
							<label for="email">Email Address:</label>
							<input type="text" name="email" class="form-control">
							<label for="subject">Subject:</label>
							<input type="text" name="subject" class="form-control">
							<label for="contact">Contact:</label>
							<select class="form-control" name="contact" class="form-control">
								<option value="regist">Registrar</option>
								<option value="rental">Rental Coordinator</option>
								<option value="summer">Summer Camp Manager</option>
								<option value="weeken">Weekend Camp Manager</option>
								<option value="promot">Promotions</option>
								<option value="websit">Website Administrator</option>
							</select>
							<label for="message">Message:</label>
							<textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
							<button name="save" class="button buttonwide" type="submit">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	require('footer.php');
?>