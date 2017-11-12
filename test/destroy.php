<?php
	//include('functions.php');
	sec_session_start();
	session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
	//header('Location: index.php');
?>