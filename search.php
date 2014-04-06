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
	<script src="<?php echo SITE_BASE; ?>/js/jquery-1.10.2.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>
<script>
//when users select the fields the background will turn yellow and the ghost text will disappear
$(document).ready(function(){

	$("#placename").focus(function(){
		$(this).val("");
		$(this).css("background-color","#EDEAC5");
		$(this).css("color","black");	//reset the color to black when the user starts typing
	});

$("#placename").blur(function(){
		$(this).css("background-color","white");
		$(this).val("Enter a place e.g. TD Bank");
		$(this).css("color","gray");
	});

	$("#zipcode").focus(function(){
		$(this).val("");
		$(this).css("background-color","#EDEAC5");
		$(this).css("color","black");	//reset the color to black when the user starts typing
	});

$("#zipcode").blur(function(){
		$(this).css("background-color","white");
		$(this).val("Enter a zip code, city or state e.g. New York, NY 12345");
		$(this).css("color","gray");
	});



});
</script>



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
				<table><tr><td>place name</td><td>zip code/city/state</td><td></td></tr>
				<tr><td><input type="text" id="placename" name="placename" maxlength="200" size="50" value="Enter a place e.g. TD Bank"></td>
				<td><input type="text" id="zipcode" name="zipcode" maxlength="200" size="40" value="Enter a zip code, city or state e.g. New York, NY 12345"></td><td>
				<input type="submit" name="go" value="find nearby"></td></tr>
				<tr><td colspan="3">search radius (in miles)<br><input type="text" name="radius" size="5" value=""></td></tr>
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

