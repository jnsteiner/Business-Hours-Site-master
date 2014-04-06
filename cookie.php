<?php
include 'includes/config.inc.php';

if(isset($_POST['rememberme'])){

	$_SESSION['email'] = "mike.morgan@adp.com";

	$value = $_SESSION['email'];

//	initializeSession($value);

	setcookie("md5",$value,time()+3600);

	print_r($_COOKIE);
}
else{


}
	

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
<input type="checkbox" name="rememberme" value="Yes">Yes
Update cookie <input type="submit" name="rememberme" value="set it">
</form>

