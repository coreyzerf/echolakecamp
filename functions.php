<?php
	require('connect.php');
	
	function pwverify($password_string){
		$password_string = trim($password_string);
		if($password_string == ''){
			return "0";
		}elseif(strlen($password_string) < 8){
			return "0";
		}elseif(!(preg_match('#[0-9]#', $password_string))){
			return "0";
		}else{
			return "1";
		}
	}
	
	function acctverify($username){
		$connection = mysqli_connect('localhost', 'zerfca_echo', 'echolakecamp1956!');
		if (!$connection){
			die("Database Connection Failed" . mysqli_error($connection));
		}
		$select_db = mysqli_select_db($connection, 'zerfca_echo');
		if (!$select_db){
			die("Database Selection Failed" . mysqli_error($connection));
		}
		$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";		 
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$count = mysqli_num_rows($result);
		$row = $result->fetch_assoc();
		if($count == 1){
			if($row['isactive']){
				return "1";
			}else{
				return "2";
			}
		}
		return "0";
	}
	
	function age($bday, $today=NULL){
		$birthday = new DateTime($bday);
		$today = new DateTime();
		$interval = $today->diff($birthday);
		return $interval->format('%y');
	}
	
	function eligible($username, $alert){
		$connection = mysqli_connect('localhost', 'zerfca_echo', 'echolakecamp1956!');
		if (!$connection){
			die("Database Connection Failed" . mysqli_error($connection));
		}
		$select_db = mysqli_select_db($connection, 'zerfca_echo');
		if (!$select_db){
			die("Database Selection Failed" . mysqli_error($connection));
		}
		
		$query = "SELECT * FROM `EchoPeople` where username='$username'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		
		//Load database into variables
		$id = $row['id'];
		$username = $row['username'];
		$first = $row['first']; 
        $last = $row['last'];
        $gender = $row['gender'];
		$email = $row['email'];
        $incharge = $row['incharge'];
        $parent = $row['parent'];
        $street = $row['street'];
        $city = $row['city'];
        $province = $row['province'];
        $postal = $row['postal'];
        $country = $row['country'];
        $emergency = $row['emergency'];
		$emergnum = $row['emergnum'];
        $healthnum = $row['healthnum'];
        $healthconcerns = $row['healthconcerns'];
        $medication = $row['medication'];
        $phone = $row['phone'];
        $church = $row['church'];
        $isprivate = $row['isprivate'];
        $isstaff = $row['isstaff']; 
        $isactive = $row['isactive'];
		$birthday = $row['birthday'];
		
		//Required variables
		$maxage = 22;
		$minage = 14;
		$eligible = 1;
		
		//Variable processing
		$age = age($birthday);
		
		//Age Check
		if( $age >= $maxage ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "You or your child are too old for camp.<br>";}
			$eligible = 0;
		}
		if( $age < $minage ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "You or your child are too young for camp.<br>";}
			$eligible = 0;
		}
		if ( empty($first)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your first name is required.<br>";}
			$eligible = 0;
		} 
		if( empty($last)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your last name is required.<br>";}
			$eligible = 0;
		} 
		if( empty($gender)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "You need to indicate your sex.<br>";}
			$eligible = 0;
		} 
		if( empty($birthday)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your birthday is required.<br>";}
			$eligible = 0;
		} 
		if( empty($email)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your email is required, or is formatted incorrectly.<br>";}
			$eligible = 0;
		} 
		if( empty($street)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your street address is required.<br>";}
			$eligible = 0;
		} 
		if( empty($city)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your city is required.<br>";}
			$eligible = 0;
		} 
		if( empty($province)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your province is required.<br>";}
			$eligible = 0;
		} 
		if( empty($postal)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your postal code is required.<br>";}
			$eligible = 0;
		} 
		if( empty($country)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your country is required.<br>";}
			$eligible = 0;
		} 
		if( empty($healthnum)  ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your health card number is required.<br>";}
			$eligible = 0;
		} 
		if( empty($emergency) || empty($emergnum) ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your emergency contact information is required.<br>";}
			$eligible = 0;
		} 
		if( empty($phone) ) {
			if($alert){ 
				$_SESSION['fmsg'] .= "Your phone number is required.<br>";}
			$eligible = 0;
		}
		
		return $eligible;
	}
	
	function msgbox ($smsg, $fmsg, $wmsg){
		if(isset($_SESSION['smsg'])){ 
			$smsg = $_SESSION['smsg'];
			echo "<div class=\"alert good\">\n";
			echo "<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>\n";
			echo $_SESSION['smsg'] . "\n";
			echo "</div>\n\n";
			unset($_SESSION['smsg']);
		}
		if(isset($_SESSION['fmsg'])){ 
			$smsg = $_SESSION['fmsg'];
			echo "<div class=\"alert bad\">\n";
			echo "<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>\n";
			echo $_SESSION['fmsg'] . "\n";
			echo "</div>\n\n";
			unset($_SESSION['fmsg']);
		}
		if(isset($_SESSION['wmsg'])){ 
			$smsg = $_SESSION['wmsg'];
			echo "<div class=\"alert warn\">\n";
			echo "<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>\n";
			echo $_SESSION['wmsg'] . "\n";
			echo "</div>\n\n";
			unset($_SESSION['wmsg']);
		}
	}
	
	function sec_session_start() {
		$session_name = 'sec_session_id';   // Set a custom session name
		/*Sets the session name. 
		 *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP. 
		 */
		session_name($session_name);
	 
		$secure = true;
		// This stops JavaScript being able to access the session id.
		$httponly = true;
		// Forces sessions to only use cookies.
		if (ini_set('session.use_only_cookies', 1) === FALSE) {
			header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
			exit();
		}
		// Gets current cookies params.
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"],
			$cookieParams["path"], 
			$cookieParams["domain"], 
			$secure,
			$httponly);
	 
		session_start();            // Start the PHP session 
		session_regenerate_id(true);    // regenerated the session, delete the old one. 
	}

function isregistered($conn, $campid, $id){
		$query = "SELECT camperid\n"
		. "FROM " . $campid . "\n"
		. "WHERE camperid = '" . $id . "'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$row = $result->fetch_assoc();
		
		if ($id == $row['camperid']) { return 1; }
		else { return 0; }
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
?>