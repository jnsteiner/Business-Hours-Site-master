<?php

$value = "17273748";


if(isset($_POST['rememberme'])){
	cookieSet($value);
}
else{
	cookieExpire($value);
}
	
	echo "<br>RM is " . $_POST['rememberme'] . "  Cookie is " . $_COOKIE["uid"];



function cookieSet($val){
	setcookie("uid",$val,time()+(10*365*24*60*60));
	echo "<br>cookie set";
}

function cookieExpire($val){
	setcookie("uid",$val,time()-3600);
	echo "<br>cookie expire";
}


?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
<input type="checkbox" name="rememberme" value="Yes">Yes
Update cookie <input type="submit" name="rememberme" value="set it">
</form>

