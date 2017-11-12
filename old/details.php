<?php
	$title = "Home - Echolakecamp.org";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	$date = date('Y-m-d');
	$verify = acctverify($_SESSION['username']);
?>
<div class="container">
<?php



	
?>
</div>
<?php 
	include('footer.php');
?>