<?php
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}elseif (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
		// last request was more than 30 minutes ago
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	/*if (!isset($_SESSION['CREATED'])) {
		$_SESSION['CREATED'] = time();
	}elseif (time() - $_SESSION['CREATED'] > 1800) {
		// session started more than 30 minutes ago
		session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
		$_SESSION['CREATED'] = time();  // update creation time
	}*/
		
	echo "<!DOCTYPE html>\n";
	echo "<html lang=\"en\">\n";
	echo "<head>\n";
	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
	echo "	<title>" . $title . "</title>\n";
	echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" >\n";
	echo "<script src=\"http://code.jquery.com/jquery-1.9.1.js\"></script>";
	echo "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<div class=\"container\">";
	if(isset($_SESSION['smsg'])){ 
		$smsg = $_SESSION['smsg'];
		echo "<div class=\"alert alert-success\" role=\"alert\">" . $smsg . "</div>";
		unset($_SESSION['smsg']);
	}
	if(isset($_SESSION['fmsg'])){ 
		$fmsg = $_SESSION['fmsg'];
		echo "<div class=\"alert alert-danger\" role=\"alert\">" . $fmsg . "</div>";
		unset($_SESSION['fmsg']);
	}
	