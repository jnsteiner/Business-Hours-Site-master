<?php
include 'includes/config.inc.php';

secureSession(); //secure the session

include 'includes/header.php'; 


$errMsgs = array();

//check to see if data was set from the form
if(isset($_POST['update'])){

//clean up the fields so that they will be DB friendly
	$full_name = filter($_POST['full_name']);
	$email = filter($_POST['email']);
	$pwd = filter($_POST['pwd']);
	$confirm_pwd = filter($_POST['confirm_pwd']);
	$city = filter($_POST['city']);
	$state = $_POST['state'];
	$postal_code = filter($_POST['postal_code']);
	$activationcode = NULL;

	$errMsgs = registerMe($full_name,$email,$pwd,$confirm_pwd,$city,$state,$postal_code,$activationcode);

}


?>

<title>Update Your Profile</title>
<head>
	<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>



<body>
	<div class="colmask fullpage">
		<div class="col1">
		
			<form name="profileform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
<<<<<<< HEAD
				<div>
=======
			<!--<div align="right"><a href="logout.php">Logout</a></div> -->
				<div style="background-color:green;">
>>>>>>> FETCH_HEAD
					
					<h2>Update Your Profile</h2>
					
						<div style="background-color:black; color:white;">
						
							<?php
								if($errMsgs){
									foreach ($errMsgs as $key => $msg) {
										echo $msg . "<br />";
									} //end foreach
								}//end if

							?>	
						</div>
						
						
					<?php
						//query the db for the user's profile info
						$profileInfo = mysql_query("SELECT *, AES_DECRYPT(email, '$salt') AS myemail FROM ".USERS." WHERE id = '" . $_SESSION['uid'] . "'") or die("Unable to get your info!");

						//display their info except for the password
						while($flds = mysql_fetch_array($profileInfo)){

						print_r($flds);

					?>

				First Name:<br />
				<input type="text" name="full_name" size="100" maxlength="200" value="<?php echo $flds['full_name']; ?>">
				<br /><br />
				
				Email:<br />
				<input type="text" name="email" size="100" maxlength="200" value="<?php echo $flds['myemail']; ?>">
				<br /><br />

				New Password:<br />
				<input type="password" name="pwd" size="20" maxlength="200">
				<br /><br />

				Confirm Password:<br />
				<input type="password" name="confirm_pwd" size="20" maxlength="200">
				<br /><br />
				
				City:<br />
				<input type="text" name="city" size="40" maxlength="40" value="<?php echo $flds['city']; ?>">
				<br /><br />

				State:<br />
				<?php
					//identify the state in the db and store it out for selection in the drop-down
					$stateProf = $flds['state'];

				?>
				

				<select name="state">
				<?php
				//iterate through the list of states in the array and render them on the register page
					foreach ($states as $idx => $statecode) {

						if($statecode == $stateProf){
							echo "<option value='" . $statecode . "' selected>" . $statecode . "</option>";
						}
						else{
						echo "<option value='" . $statecode . "'>" . $statecode . "</option>";
						} //end if
					} //End foreach

				?>	
				</select>
				
				
				<br />
				Postal Code:<br />
				<input type="text" name="postal_code" size="40" maxlength="40" value="<?php echo $flds['postal_code']; ?>">
				<br />
					<?php
					}
					?>
			
			<input type="submit" name="update" value="update my profile"><br /><br />
		</div>
		</form>
		
		</div> <!-- End div col1-->
	</div><!-- End colmask fullpage-->



<?php include 'includes/footer.php'; 
?>


</body>
</html>
