<?php
include 'includes/config.inc.php';
include 'includes/header.php'; 

$msg = array();

//check for variables set
if(isset($_GET['ac']) && isset($_GET['em'])){

$activationcode = filter($_GET['ac']);
$md5 = filter($_GET['em']);

//get the id based on the activation URL to make sure it exists
$id = mysql_query("SELECT id FROM " . USERS . " WHERE md5_id='" . $md5 . "' AND activation_code='" . $activationcode . "'");

$idRownum = mysql_num_rows($id);

//if it exists then update the activation flag to yes. otherwise, tell users it can't be verified
if($idRownum > 0){

	//update code goes here
	$updActiveflg = mysql_query("UPDATE " . USERS . " SET isactivated='Y' WHERE md5_id='" . $md5 . "'") or die(mysql_error());


	$msg[] = "Congratulations! Your account has been activated!<br>You may <a href='login.php'>login.</a>";
}
else{
	$msg[] = "Your account cannot be verified. Please try and <a href='register.php'>re-register</a>.";
}


} 
else{
	$msg[] =  "Invalid URL";
}//end isset



?>
<div class="colmask fullpage">
	<div class="col1">

		<h2>Account activation</h2>
		<br />
		<p> 
		<?php 
				foreach ($msg as $key => $value) {
					echo $value . "<br>";
				}
		 ?>
	</div>
</div>


<?php include 'includes/footer.php'; 
?>


</body>
</html>
