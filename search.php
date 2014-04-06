<html>
<?php
include 'includes/config.inc.php';
include 'includes/header.php'; 

secureSession();

$errMsgs = array();


if(isset($_POST['go'])){

		$address = filter($_POST['address']);
		$radius = $_POST['radius'];

		//check that something was filled in. otherwise, display a message
		if(empty($address)){

			$errMsgs[] = "Please provide a zip code and/or a place you're searching for.";
		}

		if(isset($address)){

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

<<<<<<< HEAD
$("#zipcode").blur(function(){
		$(this).css("background-color","white");
		$(this).val("Enter a zip code, city or state e.g. New York, NY 12345");
		$(this).css("color","gray");
	});



});
</script>
=======
>>>>>>> FETCH_HEAD



<body>

 	<div class="colmask fullpage">
		<div class="col1">
			
				
			<div style="background-color:#9D1309;color:white;margin:0em; border-radius: 0px 0px 0px 0px;">
			<?php
	
				foreach ($errMsgs as $key => $value) {
					echo $value . "<br>";
				}

			?>
			</div>
			
		
			<h2>Search </h2>
				<p>
<<<<<<< HEAD
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table><tr><td>place name</td><td>zip code/city/state</td><td></td></tr>
				<tr><td><input type="text" id="placename" name="placename" maxlength="200" size="50" value="Enter a place e.g. TD Bank"></td>
				<td><input type="text" id="zipcode" name="zipcode" maxlength="200" size="40" value="Enter a zip code, city or state e.g. New York, NY 12345"></td><td>
				<input type="submit" name="go" value="find nearby"></td></tr>
				<tr><td colspan="3">search radius (in miles)<br><input type="text" name="radius" size="5" value=""></td></tr>
				</table>
=======
				<form action="search.php" method="post">
					<input type="text" name="address" maxlength="200" size="100"><input type="submit" name="go" value="find nearby">
					<input type="text" name="radius" value="">&nbsp;&nbsp;in miles
>>>>>>> FETCH_HEAD
				</form>


				<form action="<?php echo "favorites.php"; ?>" method="post">
				<div id="result" align="left">
							
				<?php
					if(!empty($listDisplay)){
					
						echo "<input type='submit' name='add' value='add to favorites'><br />";
						echo $listDisplay;
					}
				?>
				</div>
				</form>
				</p>
				
				
				<img src="images/poweredbygoogle.png" style="float: right;">


		</div> <!-- End div col1-->
	</div><!-- End colmask fullpage-->



<?php include 'includes/footer.php'; 
?>

</body>
</html>
