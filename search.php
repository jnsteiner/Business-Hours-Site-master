<?php
include 'includes/config.inc.php';
include 'includes/header.php'; 

secureSession();

$errMsgs = array();

if(isset($_POST['go'])){

		//set the place name
		$placename = filter($_POST['placename']);
		//set the zip
		$zipcode = filter($_POST['zipcode']);
		$radius = $_POST['radius'];

		//check that something was filled in. otherwise, display a message
		if(empty($placename) || empty($zipcode)){

			$errMsgs[] = "Please provide a zip code AND a place you're searching for.";
		}

		//check that both are filled in
		if(isset($placename) && isset($zipcode)){

			//concatenate the place and zip for the api call
			$address = $placename . "," . $zipcode;

			if(empty($radius)){
				$radius = 1609.34; //default it to 1 mile
			}
			else{

				//convert miles from the form into meters for Google API
				$radius = milesTometers($radius);
			} //end empty


			$refArray = getPlaceReferencesviaText($address,$radius);

			$references = array();

			//parse the json and store out the ref ids into an array
			for($i = 0;$i < count($refArray['results']) ; $i++){

				//store out place references to be used to get details
				$references[] = $refArray['results'][$i]["reference"];

			} //end for

			//pass the references to the places API to display the hours
			$listDisplay = getPlaceDetails($references);
		} //end address
				
} //end go
?>
<head>
	<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>




<body>
<div style="background-color:black;color:white;">
<?php
	
	foreach ($errMsgs as $key => $value) {
		echo $value . "<br>";
	}


?>
</div>

	<div class="colmask fullpage">
		<div class="col1">
		
			<h2>Search</h2>
				<p>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table><tr><td>place name</td><td>zip code</td><td></td></tr>
				<tr><td><input type="text" name="placename" maxlength="200" size="50"></td>
				<td><input type="text" name="zipcode" maxlength="200" size="20"></td><td>
				<input type="submit" name="go" value="find nearby"></td></tr>
				<tr><td colspan="3"><input type="text" name="radius" size="5" value="">&nbsp;&nbsp;(in miles)</td></tr>
				</table>
				</form>


				<form action="<?php echo "favorites.php"; ?>" method="post">
				<div id="result" align="left">
				<?php
	
					if(!empty($listDisplay)){
						echo "<input type='submit' name='add' value='add to favorites'><br>";
						echo $listDisplay;
					}
				?>
				</div>
				</form>
				</p>

		</div> <!-- End div col1-->
	</div><!-- End colmask fullpage-->



<?php include 'includes/footer.php'; 
?>

</body>

