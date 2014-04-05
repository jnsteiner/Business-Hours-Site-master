<?php

session_start();

/*
//check RM is set
if(isset($_COOKIE['md5'])){
	echo $_COOKIE['md5'];
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Business Hours</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="The Perfect full page Liquid Layout (double page): No CSS hacks. SEO friendly. iPhone compatible." />
	<meta name="keywords" content="The Perfect full page Liquid Layout (double page): No CSS hacks. SEO friendly. iPhone compatible." />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="styles/layout_styles.css">

</head>
<body>	
<?php $base = basename($_SERVER['SCRIPT_NAME']); ?>

<div id="header">



<div id='login_links'>
<?php

//Display utility navigation bar regardless of login status
echo "<a href='about.php'>About Us</a> | ";
echo "<a href='faq.php'>FAQ</a> | ";


//check if logged in. if they are then displayn a welcome message
if(!$_SESSION['loggedin']){
<<<<<<< HEAD
echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a></div>			
";
=======
echo "<a href='faq.php'>FAQ</a> | <a href='about.php'>About Us</a> | <a href='profile.php'>Profile</a> | <a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
>>>>>>> FETCH_HEAD
}
else{
echo "<a href='profile.php'>Profile</a> | 
<a href='logout.php'>Logout</a>			
<div style='text-align: left; margin-left: 0.8em;font-size: 1.2em; margin-top: -1.1em;'><strong>Welcome, " . $_SESSION['full_name'] . "      " . "</strong></div></div>";
}//end if

?>




	<!--DISPLAY PAGE LOGO-->
	<p id="logo"> 
				 <a href="index.php"> <img src="images/bh_logo_os2.gif" width="100%" style="margin-top: -5.0em; margin-left: 0em; margin-bottom: -3.0em;"></a>
	</p>
	<!--MAIN PAGE NAVIGATION -->
	<ul id="nav">
		<li><a href="index.php" 
				    >Home</a> </li>
<<<<<<< HEAD
		
		<li><a href="search.php" 
					>Search</a> </li>		

<!-- hide register link for logged in users  -->
<?php 
if(!$_SESSION['loggedin']){					
		echo "<li><a href='register.php'>Register</a> </li>";
		}
else{	?>
			
		<li><a href="favorites.php" 
					>My Favorites</a> </li>
		
<?php } ?>		
=======
		    				 	 	
		<li><a href="search.php" 
					>Search</a> </li>		
				
		<li><a href="#"><span>Categories</span></a></li>
<!-- hide register link for logged in users  -->
<?php 
if($_SESSION['loggedin']){					
	echo "<li><a href='favorites.php'>My Favorites</a> </li>";
}		
?>		
>>>>>>> FETCH_HEAD
	</ul>
</div>

