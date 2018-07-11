<?php
	if ( isset($_POST['optin'])){ 
		$email = $_POST['email'];
		echo $email;
		$query = "INSERT `optin` (email) VALUES ('$email') ;";
        $result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['smsg'] = "Saved.";
		}else{
            $_SESSION['fmsg'] = "Save failed, " . mysqli_error($connection);
		}
		echo $_SESSION['smsg'];
		echo $_SESSION['fmsg'];
		//header('Location: index.php');
    }else{
		header('Location: index.php');
	}
	
	
?>
