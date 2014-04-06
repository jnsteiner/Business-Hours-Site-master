<?php
include 'includes/config.inc.php';

//don't output this unless its upon loading of the page without logging in
if(!isset($_POST['submit'])){
	include 'includes/header.php'; 
}


//initialize the form fields
$full_name = NULL;
$email = NULL;
$password = NULL;
$passwordconfirm = NULL;
$city = NULL;
$state = NULL;
$postal_code = NULL;

//instantiate an error array to populate with error messages
$errors = array();

//check to see if data was set from the form
if(isset($_POST['submit'])){

//clean up the fields so that they will be DB friendly
	$full_name = filter($_POST['full_name']);
	$email = filter($_POST['email']);
	$pwd = filter($_POST['pwd']);
	$confirm_pwd = filter($_POST['confirm_pwd']);
	$city = filter($_POST['city']);
	$state = $_POST['state'];
	$postal_code = filter($_POST['postal_code']);
	$activationcode = rand(1111,99999);
	$date = date('Y-m-d');

//call registration function. return errors and success message based on function rules in config file
$errMsgs = registerMe($full_name,$email,$pwd,$confirm_pwd,$city,$state,$postal_code,$activationcode,$date);


}


?>
	<title>Register</title>
	<head></head>
	<body>


	<div class="colmask fullpage">
		<div class="col1">

		<form name="regform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
			<div>
		
			<h2>Register</h2>
			
				<div style="background-color:black;color:white;">
					<?php
						if($errMsgs){
							foreach ($errMsgs as $key => $msg) {
								echo $msg . "<br />";
							} //end foreach
						}//end if
					?>	
				</div>


				<p><br />Love our site?  Register today and save frequented stores to your favorites list so you can access them even quicker in the future!  You can register by filling out the short form below.  When everything looks good, simply click the Register Now button to access your new account!  </p>
				<p>Already have an account?  That’s awesome!  Sign in <a href="login.php">here</a>.</p>
				<br />
			
				<p>	
				Full Name:<br />
				<input type="text" name="full_name" size="100" maxlength="200" value="<?php echo $full_name; ?>">
				<br /><br />
			
				Email Address:<br />
				<input type="text" name="email" size="100" maxlength="200" value="<?php echo $email; ?>">
				<br /><br />
				
				Password:<br />
				<input type="password" name="pwd" size="20" maxlength="200">
				<br /><br />
			
				Confirm Password:<br />
				<input type="password" name="confirm_pwd" size="20" maxlength="200">
				<br /><br />

				City:<br />
				<input type="text" name="city" size="40" maxlength="40" value="<?php echo $city; ?>">
				<br /><br />

				State:<br />
				<select name="state">
				<?php

					//iterate through the list of states in the array and render them on the register page
					foreach ($states as $idx => $statecode) {

						if($statecode == $state){
						echo "<option value='" . $statecode . "' selected>" . $statecode . "</option>";
						}
						else{
						echo "<option value='" . $statecode . "'>" . $statecode . "</option>";
						} //end if
					}//end foreach

				?>	
				</select>
				<br /><br />
			
				Postal Code:<br />
				<input type="text" name="postal_code" size="40" maxlength="40" value="<?php echo $postal_code; ?>">
				<br /><br />
						
				<input type="submit" name="submit" value="Register Now">
				<br /><br />
			
			</p>
		</div>
		</form>
		
		
		</div> <!-- End div col1-->
	</div><!-- End colmask fullpage-->



<?php include 'includes/footer.php'; 
?>


</body>
</html>
