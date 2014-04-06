<?php

session_start();

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
	<script src="<?php echo SITE_BASE; ?>/js/jquery-1.10.2.js"></script>
</head>
<body>	
<?php $base = basename($_SERVER['SCRIPT_NAME']); ?>

<div id="header">



<div id='login_links'>
<?php

<<<<<<< HEAD
//check if logged in. if they are then displayn a welcome message. hide the register link if they're logged in. otherwise, show it.
=======
//Display utility navigation bar regardless of login status
echo "<a href='about.php'>About Us</a> | ";
echo "<a href='faq.php'>FAQ</a> | ";


//check if logged in. if they are then displayn a welcome message
>>>>>>> FETCH_HEAD
if(!$_SESSION['loggedin']){
echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a></div>			
";
}
else{
<<<<<<< HEAD
echo "<a href='faq.php'>FAQ</a> | <a href='about.php'>About Us</a> | <a href='profile.php'>Profile</a> | Welcome " . $_SESSION['full_name'] . "      " . "<a href='logout.php'>Logout</a>";
=======
echo "<a href='profile.php'>Profile</a> | 
<a href='logout.php'>Logout</a>			
<div style='text-align: left; margin-left: 0.8em;font-size: 1.2em; margin-top: -1.1em;'><strong>Welcome, " . $_SESSION['full_name'] . "      " . "</strong></div></div>";
>>>>>>> FETCH_HEAD
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
		
		<li><a href="search.php" 
					>Search</a> </li>		
<<<<<<< HEAD
=======

>>>>>>> FETCH_HEAD
<!-- hide register link for logged in users  -->
<?php 
if(!$_SESSION['loggedin']){					
		echo "<li><a href='register.php'>Register</a> </li>";
		}
else{	?>
			
		<li><a href="favorites.php" 
					>My Favorites</a> </li>
		
<?php } ?>		
	</ul>
</div>

