<?php
	if ( isset($_POST['optin'])){ 
		$email = $_POST['email'];
		$query = "INSERT `optin` (email) VALUES ($email) ;";
        $result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['smsg'] = "Saved.";
		}else{
            $_SESSION['fmsg'] = "Save failed, " . mysqli_error($connection);
		}
    }else{
		header('Location: index.php');
	}
	
	
?>
