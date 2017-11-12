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
	
	function age($bday){
		$birthday = new DateTime($bday);
		$today = new DateTime();
		$interval = $today->diff($birthday);
		return $interval->format('%y');
	}
	
	function eligible($username){
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
		$email = $row['email'];
        $incharge = $row['incharge'];
        $parent = $row['parent'];
        $street = $row['street'];
        $city = $row['city'];
        $province = $row['province'];
        $postal = $row['postal'];
        $country = $row['country'];
        $emergency = $row['emergency'];
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
		if( $age > $maxage ) {
			$_SESSION['fmsg'] .= "You or your child are too old for camp.<br>";
			$eligible = 0;
		}
		if( $age < $minage ) {
			$_SESSION['fmsg'] .= "You or your child are too young for camp.<br>";
			$eligible = 0;
		}
		if ( empty($first)  ) {
			$_SESSION['fmsg'] .= "Your first name is required.<br>";
			$eligible = 0;
		} 
		if( empty($last)  ) {
			$_SESSION['fmsg'] .= "Your last name is required.<br>";
			$eligible = 0;
		} 
		if( empty($birthday)  ) {
			$_SESSION['fmsg'] .= "Your birthday is required.<br>";
			$eligible = 0;
		} 
		if( empty($email)  ) {
			$_SESSION['fmsg'] .= "Your email is required, or is formatted incorrectly.<br>";
			$eligible = 0;
		} 
		if( empty($street)  ) {
			$_SESSION['fmsg'] .= "Your street address is required.<br>";
			$eligible = 0;
		} 
		if( empty($city)  ) {
			$_SESSION['fmsg'] .= "Your city is required.<br>";
			$eligible = 0;
		} 
		if( empty($province)  ) {
			$_SESSION['fmsg'] .= "Your province is required.<br>";
			$eligible = 0;
		} 
		if( empty($postal)  ) {
			$_SESSION['fmsg'] .= "Your postal code is required.<br>";
			$eligible = 0;
		} 
		if( empty($country)  ) {
			$_SESSION['fmsg'] .= "Your country is required.<br>";
			$eligible = 0;
		} 
		if( empty($healthnum)  ) {
			$_SESSION['fmsg'] .= "Your health card number is required.<br>";
			$eligible = 0;
		} 
		if( empty($emergency)  ) {
			$_SESSION['fmsg'] .= "Your emergency contact information is required.<br>";
			$eligible = 0;
		} 
		if( empty($phone) ) {
			$_SESSION['fmsg'] .= "Your phone number is required.<br>";
			$eligible = 0;
		}
		
		return $eligible;
	}
?>