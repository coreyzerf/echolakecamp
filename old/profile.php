<?php
	$title = "Registration";
	include('header.php');
	require('connect.php');
	require('functions.php');
	
	if ( !acctverify($_SESSION['username'])){
		session_unset();
		$_SESSION['fmsg'] = "You are not logged in.";
		header('Location: login.php');
	}elseif ( isset($_POST['save'])){ 
		$id = $_SESSION['id'];
		$username = $_SESSION['username'];
		$first = $_POST['first']; 
        $last = $_POST['last'];
        $birthday = $_POST['birthday'];
		$email = $_POST['email'];
        $incharge = $_POST['incharge'];
        $parent = $_POST['parent'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal = $_POST['postal'];
        $country = $_POST['country'];
        $emergency = $_POST['emergency'];
        $healthnum = $_POST['healthnum'];
        $healthconcerns = $_POST['healthconcerns'];
        $medication = $_POST['medication'];
        $phone = $_POST['phone'];
        $church = $_POST['church'];
        $isprivate = $_POST['isprivate'];
        $isstaff = $_POST['isstaff']; 
        $isactive = $_POST['isactive']; 
		
        //$query = "UPDATE EchoPeople SET username=$username , first=$first , last=$last , birthday=$birthday , email=$email , incharge='$incharge' , parent=$parent , street=$street , city=$city , province=$province , postal=$postal , country=$country , emergency=$emergency , healthnum=$healthnum , healthconcerns=$healthconcerns , medication=$medication , phone=$phone , church=$church , isprivate='$isprivate' , isstaff='$isstaff' , isactive='$isactive' WHERE username='".$username."';";
		$query = "UPDATE EchoPeople SET username='$username', first='$first' , last='$last' , birthday='$birthday' , email='$email' , incharge='$incharge' , parent='$parent' , street='$street' , city='$city' , province='$province' , postal='$postal' , country='$country' , emergency='$emergency' , healthnum='$healthnum' , healthconcerns='$healthconcerns' , medication='$medication' , phone='$phone' , church='$church' , isprivate='$isprivate' , isstaff='$isstaff' , isactive='$isactive' WHERE id='".$id."';";
        $result = mysqli_query($connection, $query);
        if($result){
            $_SESSION['smsg'] = "Updated Successfully.";
			unset($_SESSION['fmsg']);
		}else{
			unset($_SESSION['smsg']);
            $_SESSION['fmsg'] = "Update Failed, " . $result;
		}
    }//else{
		$username = $_SESSION['username'];
		$query = "SELECT * FROM `EchoPeople` WHERE username='$username'";
		 
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$row = $result->fetch_assoc();
		if (!isset($row['id'])){
			session_unset();
			$_SESSION['fmsg'] = "Something went wrong";
			header('Location: login.php');
		}
?>
<div class="container">
	<form class="form-signin" method="POST">
		ID:<input type="text" name="id" class="form-control" readonly value="<?php echo $row['id'];?>"/>
		Created:<input type="text" name="created" class="form-control"  readonly value="<?php echo $row['created'];?>"/>
		Username:<input type="text" name="username" class="form-control" placeholder="Username" required value="<?php echo $row['username'];?>"/>
		First Name:<input type="text" name="first" class="form-control" placeholder="First Name" required value="<?php echo $row['first'];?>"/>
		Last Name:<input type="text" name="last" class="form-control" placeholder="Last Name" required value="<?php echo $row['last'];?>"/>
		Birthday:<input type="text" name="birthday" class="form-control" placeholder="Birthday (YYYY-MM-DD)" required value="<?php echo $row['birthday'];?>"/>
		Email: <input type="text" name="email" class="form-control" placeholder="Email" required value="<?php echo $row['email'];?>"/>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="incharge" value="1" <?php if ( $row['incharge'] == 1){echo "checked=\"checked\"";}?>> Parent of Camper
			</label>
		</div>
		Parent: <input type="text" name="parent" class="form-control" placeholder="Parent" required value="<?php echo $row['parent'];?>"/>
		Street: <input type="text" name="street" class="form-control" placeholder="Street" required value="<?php echo $row['street'];?>"/>
		City: <input type="text" name="city" class="form-control" placeholder="City" required value="<?php echo $row['city'];?>"/>
		Province: <input type="text" name="province" class="form-control" placeholder="Province" required value="<?php echo $row['province'];?>"/>
		Postal Code: <input type="text" name="postal" class="form-control" placeholder="Postal Code" required value="<?php echo $row['postal'];?>"/>
		Country: <input type="text" name="country" class="form-control" placeholder="Country" required value="<?php echo $row['country'];?>"/>
		Emergency Contact: <input type="text" name="emergency" class="form-control" placeholder="Emergency Contact" value="<?php echo $row['emergency'];?>"/>
		Health Card Number: <input type="text" name="healthnum" class="form-control" placeholder="Health Card Number" value="<?php echo $row['healthnum'];?>"/>
		Health Concerns: <input type="text" name="healthconcerns" rows="5" class="form-control" placeholder="Health Concerns" value="<?php echo $row['healthconcerns'];?>"/>
		Medication: <input type="text" name="medication" class="form-control" placeholder="Medication" value="<?php echo $row['medication'];?>"/>
		Phone: <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="<?php echo $row['phone'];?>"/>
		Church: <input type="text" name="church" class="form-control" placeholder="Church" value="<?php echo $row['church'];?>"/>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="isprivate" value="1" <?php if ( $row['isprivate'] == 1){echo "checked=\"checked\"";}?>> Private
			</label>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="isstaff" value="1"  <?php if ( $row['isstaff'] == 1){echo "checked=\"checked\"";}?>> Staff
			</label>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="isactive" value="1" readonly <?php if ( $row['isactive'] == 1){echo "checked=\"checked\"";}?>> Active
			</label>
		</div>
		<button name="save" class="btn btn-lg btn-danger btn-block" type="submit" value="Save">Save</button>
		<a class="btn btn-lg btn-primary btn-block" href="index.php">Home</a>
	</form>
</div>
<?php //}
	include('footer.php')
?>