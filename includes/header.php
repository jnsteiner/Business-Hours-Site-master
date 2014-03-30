
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



//store out base to check URL in order to highlight selected link
<?php $base = basename($_SERVER['SCRIPT_NAME']); ?>


<div id="header">

	<!--MAIN PAGE NAVIGATION ------------------>
	<div id="login_links">
		<a href="login.php">Login</a> or <a href="register.php">Register</a>
	</div>
	
	
	
	<!--DISPLAY PAGE LOGO------------------>
	<p id="logo"> 
				 <a href="index.php"> <img src="images/bh_logo_os.gif" width="100%" style="margin-top: -5.0em; margin-left: -0.5em; margin-bottom: -3.0em;"></a>
	</p>
	
	
	
	<!--MAIN PAGE NAVIGATION ------------------>
	<ul id="nav">
		<li><a href="index.php" 
		<?php if($base == "index.php") echo "class=active"; ?>
		    >Home</a> </li>
		    				 	 	
		<li><a href="about.php" 
		<?php if($base == "about.php") echo "class=active"; ?>
			>About Us</a> </li>	
		
		<li><a href="search.php" 
		<?php if($base == "search.php") echo "class=active"; ?>
			>Search</a> </li>		
				
		<li><a href="#"><span>Categories</span></a></li>
		
		<li><a href="faq.php" 
		<?php if($base == "faq.php") echo "class=active"; ?>
			>FAQ</a> </li>
					
		<li><a href="register.php" 
		<?php if($base == "register.php") echo "class=active"; ?>
			>Register</a> </li>
		
		<li><a href="login.php" 
		<?php if($base == "login.php") echo "class=active"; ?>
			>Login</a> </li>
		
		<li><a href="profile.php" 
		<?php if($base == "profile.php") echo "class=active"; ?>
			>Profile</a> </li>
			
		<li><a href="faves.php" 
		<?php if($base == "faves.php") echo "class=selected"; ?>
			>My Favorites</a> </li>
		
		
	</ul>
</div>


<?php


/*
<div id="nav">
<ul><li><a href="register.php" <?php if($base == "register.php") echo " class=selected"; ?>>Register</a> | 

<li><a href="index.php" <?php if($base == "index.php") echo " class=selected"; ?>>Home</a>

 | <li><a href="login.php" <?php if($base == "login.php") echo "class=selected"; ?> >Login</a> | 
 
 <li><a href="profile.php" <?php if($base == "profile.php") echo "class=selected"; ?>>Profile</a> |
 
  <li><a href="faves.php" <?php if($base == "faves.php") echo "class=selected"; ?>>My Favorites</a>| 
  
  <li><a href="search.php" <?php if($base == "search.php") echo "class=selected"; ?>>Search</a></ul>
</li>
</div>

*/