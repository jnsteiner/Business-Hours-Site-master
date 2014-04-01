<?php
include 'includes/config.inc.php';

secureSession();

$Msgs = array();
$refArray = array();


//check submitted favorites from search page
if(isset($_POST['referenceIDs']) && !empty($_POST['referenceIDs'])){

		$refArray = $_POST['referenceIDs'];

		addToFavorites($refArray);

		$Msgs[] = "Your favorites have been added";

}

//if coming from a GET then you're trying to delete an item
if(isset($_GET['referenceIDs']) && !empty($_GET['referenceIDs']) && isset($_GET['delete'])){

	$refArray = $_GET['referenceIDs'];

	deleteFavorites($refArray);

	$Msgs[] = "Your favorites have been deleted";
}

//set the favorites display
$displayFaves = showMyFavorites();


?>
<head>
<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>
<body>
<?php
include 'includes/nav.inc.php';
?>
<h1><?php echo $_SESSION['full_name'] . "'s" . " Favorites";?></h1>
<div style="background-color:black;color:white;">
<?php
foreach ($Msgs as $key => $value) {
	echo $value . "<br>";
}
?>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> 
<br>
<?php

//only show delete buttons when there are results to delete. otherwise hide them.
if(!empty($displayFaves)){
	echo "<input type='submit' name='delete' value='delete'/>";
	echo $displayFaves;
}
else{
	echo "You currently have no favorites.";
	echo "<a href='search.php'>Search</a> to add favorites";

}
//same here. only show when favorites exist
if(!empty($displayFaves)){
	echo "<input type='submit' name='delete' value='delete'/>";
}

?>
</form>
</body>