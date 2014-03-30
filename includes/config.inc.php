<?php
require 'php-sdk/src/temboo.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//define db constants
define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "hci573"); // set database user
define ("DB_PASS","hci573"); // set database password
define ("DB_NAME","hci573"); // set database name
define("USERS","bhours_users_mmorgan");//users table as a constant
define("FAVES","bhours_users_favorites_mmorgan");//users table as a constant
define("PSTORE","bhours_pstore_mmorgan"); //password store
define("REFERENCES","bhours_refs_mmorgan"); //reference details store

//define email address for sending activation emails
define("ACTIVATION_SWITCH",true);

//site base
define ("SITE_BASE", "http://".$_SERVER['HTTP_HOST']."/bhours");
define ("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']."/bhours");
define("REGISTER", "<a href='register.php'>register</a>");

//API credentials
define("TEMBOO_NAME","coffeespil");
define("TEMBOO_PROJ","myFirstApp");
define("TEMBOO_KEY","eeed6c5954ae483c92bde95136ad8a97");
define("PLACES_KEY","AIzaSyDvDhrZ4ev2aSiEucD5VdVjaBsCYwISDpw");

// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
global $session; 
$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY); 

//set the sensor globally for choreos
global $sensor;
$sensor = false;

//set connection to be used across site
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

//states for the registration page
$states = array("AL","AK","AS","AZ","AR","CA","CO","CT","DE","DC","FM","FL","GA","GU","HI","ID","IL","IN","IA","KS","KY","LA","ME","MH","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","MP","OH","OK","OR","PW","PA","PR","RI","SC","SD","TN","TX","UT","VT","VI","VA","WA","WV","WI","WY");

//define places array for searching place types
$places = array("accounting","airport","amusement_park","aquarium","art_gallery","atm","bakery","bank","bar","beauty_salon","bicycle_store","book_store","bowling_alley","bus_station","cafe","campground","car_dealer","car_rental","car_repair","car_wash","casino","cemetery","church","city_hall","clothing_store","convenience_store","courthouse","dentist","department_store","doctor","electrician","electronics_store","embassy","establishment","finance","fire_station","florist","food","funeral_home","furniture_store","gas_station","general_contractor","grocery_or_supermarket","gym","hair_care","hardware_store","health","hindu_temple","home_goods_store","hospital","insurance_agency","jewelry_store","laundry","lawyer","library","liquor_store","local_government_office","locksmith","lodging","meal_delivery","meal_takeaway","mosque","movie_rental","movie_theater","moving_company","museum","night_club","painter","park","parking","pet_store","pharmacy","physiotherapist","place_of_worship","plumber","police","post_office","real_estate_agency","restaurant","roofing_contractor","rv_park","school","shoe_store","shopping_mall","spa","stadium","storage","store","subway_station","synagogue","taxi_stand","train_station","travel_agency","university","veterinary_care","zoo");

//array of days of the week used for displaying store hours
$days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
global $days;

//store out day of the week in numeric format for display in store hours
$today = date('w');
global $today;	

//salt for storing email
$salt = "sdhdjhsd8djd9dkdksdksnds";
global $salt;

//salt for storing admin email
$saltAdminemail = "whwhw72heksksk";
global $saltAdminemail;


//function to register users

function registerMe($full_name,$email,$pwd,$confirm_pwd,$city,$state,$postal_code,$activationcode){

	//set the salt for the email address to global so its accessible to the function
	global $salt;
	global $link;
	global $pass;
	global $saltAdminemail;

//set the page name so that the function can be reused for profile or register pages
	$page = basename($_SERVER['PHP_SELF']);


//set the id only for logged in users
if($page == "profile.php"){
	//set the id session for use in the function	
	$id = $_SESSION['uid'];	
							}
//set the errors array and store the message in there when there are errors
	$errors = array();

//check for blank and valid fields
	if(empty($full_name)){
		$errors[] = "Please enter your full name.";
	}
//check for valid email address using hw function
	if(empty($email) || !check_email($email)){
		$errors[] = "Please enter a valid email address.";
	}


//check for at least 1 number and letter present in the password
	$hasNumber = preg_match('/\d/',$pwd);
	$hasLetter = preg_match('/[a-zA-Z]/',$pwd); 	

//check for a password with at least 6 characters, at least one number and one letter
	if(empty($pwd) || !$hasNumber || !$hasLetter || strlen($pwd) < 6){
		$errors[] = "Please enter a valid password.<ul>It must contain at least: <li>one number<li>one letter<li>be at least 6 characters long</ul>";
	}

//check for that the two password fields equal eachother
	if($pwd != $confirm_pwd){
		$errors[] = "Both passwords must match. Please re-enter them.";
	}


//check for city
	if(empty($city)){
		$errors[] = "Please enter your city.";
	}

//check for postal code
	if(empty($postal_code)){
		$errors[] = "Please enter your zip code.";
	}


	if($page == "profile.php"){
	//check to see if email address has been updated from profile page
	//if it has been updated a check to see if it is already taken will need to be done	


	$emailChanged = mysql_query("SELECT *, AES_DECRYPT(email, '$salt') AS myemail FROM " . USERS . " WHERE id = '$id'") or die("Unable to get your info!");
	//will be updated with session variable
  	
  	$storedEmail = mysql_fetch_array($emailChanged);

  	$emailUpdated = false; //initialize to false

  	if($storedEmail['myemail'] != $email){
  						$emailUpdated = true;  //if this is true then we need to check if it exists
  									} //end if
  								}//end if profile


  	if($page == "register.php" || $emailUpdated){

	//check if the user already exists. if he does then prevent the registration 
	$userExists = mysql_query("SELECT email FROM " . USERS . " WHERE email = AES_ENCRYPT('$email', '$salt')");

	$userEmail = mysql_fetch_array($userExists);

	if(mysql_num_rows($userEmail) > 0){
		$errors[] = "A user with email " . $email . " already exists. Please try another email address.";
	}	
												} //end if register


//if the array is empty then start the process for adding it to the database
	if(empty($errors)){

//hash the password before inserting it into the table
	$passwrd = hashpass($pwd);

	if($page == "register.php"){

	$create_date = date("Y-m-d H:i:s");
		
	$registerMe = mysql_query("INSERT INTO ".USERS." (full_name, email, pwd, city, state, postal_code, activation_code, create_date) VALUES ('$full_name', AES_ENCRYPT('$email', '$salt'), '$passwrd', '$city', '$state' , '$postal_code' , '$activationcode','$create_date')", $link) or die("Unable to insert data");

//get the latest user id from the previous statement and then add a hashed id to the database
		$id = mysql_insert_id($link); //get the id of the last inserted item
		$md5 = md5($id);
		mysql_query("UPDATE ".USERS." SET md5_id='$md5' WHERE id='$id'") or die(mysql_error());

	if($registerMe){


		if(ACTIVATION_SWITCH){

	$errors[] = "You're almost done!  We've sent you an email to verify your email address. Please check it to verify your email address.";	
			//generate the message
			$body = "Thanks for registering with Business-Hours.net!\nPlease activate your account:\n"
			. SITE_BASE . "/activate.php?ac=" . $activationcode . "&em=" . $md5;

			$subject = "Business-Hours Account Activation Email";

			$emailInfo = getCredentials("gmail");
			$mailFrom = $emailInfo['email'];
			$mailPwd = $emailInfo['pwd'];

			// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
			$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY);
			$sendEmail = new Google_Gmail_SendEmail($session);

			// Get an input object for the Choreo
			$sendEmailInputs = $sendEmail->newInputs();

			// Set inputs
			$sendEmailInputs->setMessageBody($body)->setSubject($subject)->setUsername($mailFrom)->setPassword($mailPwd)->setToAddress($email);

			// Execute Choreo and get results
			$sendEmailResults = $sendEmail->execute($sendEmailInputs)->getResults();

	
		} //end activation switch
		else{
	$errors[] = "You're now successfully registered. Start saving out your favorite places!";	
		}

						} //end if register me
							} //end if register.php

	if($page == "profile.php"){

	$updProfile = mysql_query("UPDATE ". USERS . " SET full_name = '" . $full_name . "', email = AES_ENCRYPT('" . $email . "', '$salt'), city='" . $city . "', state = '" . $state . "', postal_code = '" . $postal_code . "', pwd = '" . $pwd . "' where id='$id'"); 
	//id will be updated to session when sessions are hooked up

	if($updProfile){
		$errors[] = "You've updated your profile successfully!";	
	}//end if
							}//end if profile.php							

						}//end if for errs

	return $errors;

}//end fn

//convert miles to meters for Google places radius input
function milesTometers($num){

	$radiusInmeters = $num * 1609.34;

	return $radiusInmeters;

} //end miles to meters

/*Function to validate email addresses same from Homework assignment*/
function check_email($email)
{
	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
} //end check email

/*Function to super sanitize anything going near our DBs same one from HW assignment*/
function filter($data)
{
	$data = trim(htmlentities(strip_tags($data)));

	if (get_magic_quotes_gpc())
	{
		$data = stripslashes($data);
	}

	$data = mysql_real_escape_string($data);
	return $data;
} //end filter

//run this hash on user-entered passwords prior to adding to the database
function hashpass($pass){

		$pwd = sha1($pass);
		$passwordmd5 = md5($pwd); 

		return $passwordmd5;
} //end hashpass

function isvalidPwd($pwd){

	//check for at least 1 number and letter present in the password
	$hasNumber = preg_match('/\d/',$pwd);
	$hasLetter = preg_match('/[a-zA-Z]/',$pwd); 	

//check for a password with at least 6 characters, at least one number and one letter
	if(empty($pwd) || !$hasNumber || !$hasLetter || strlen($pwd) < 6){
		return false;
	}
		return true;
} //end fn

//this logout function is called from the logout page and redirects to login page with a confirmation message
function logout($logoutmsg){

	//check if there is a session so it can be destroyed properly
	if(!isset($_SESSION)){
		session_start();
						}

		unset($_SESSION['uid']);
		unset($_SESSION['full_name']);
		unset($_SESSION['skey']);
		unset($_SESSION['stime']);

		session_unset();
		session_destroy();

	header("Location: ".SITE_BASE."/login.php?msg=" . $logoutmsg);


} //end logout

//used to retrieve password store credentials for email and other items
function getCredentials($acct){

	global $link;
	global $saltAdminemail; 

	$credentials = mysql_query("SELECT *, AES_DECRYPT(acct_val, '$saltAdminemail') AS email, AES_DECRYPT(acct_pwd, '$saltAdminemail') AS pwd FROM " . PSTORE . " WHERE acct_nam = '$acct'") or die("Unable to get the info!");

	$credls = mysql_fetch_array($credentials);

	return $credls;

}//end fn

//this function returns a list of placedetails including business hours
function getPlaceDetails($refArray){

	global $session;
	global $days;
	global $today;

	//Get the details for the specific places which includes business hours
	$placeDetails = new Google_Places_PlaceDetails($session);

	// Get an input object for the Choreo
	$placeDetailsInputs = $placeDetails->newInputs();

	// Set inputs
	$sensor = false;
	$placeDetailsInputs->setKey(PLACES_KEY)->setSensor($sensor)->setResponseFormat("json");


	//iterate through each reference to out place details including store hours
	for($i = 0 ; $i < count($refArray) ; $i++){

		$placeDetailsInputs->setReference($refArray[$i]);

			// Execute Choreo and get results
		$placeDetailsResults = $placeDetails->execute($placeDetailsInputs)->getResults();

		$listOfdetails = json_decode($placeDetailsResults->getResponse(),true);

		$listDisplay .= "<input type=checkbox name='referenceIDs[]' value='" . $refArray[$i]  . "'/>";
		$listDisplay .= $listOfdetails['result']["name"] . "<br>";
		$listDisplay .= $listOfdetails['result']["adr_address"] . "<br>";
		$listDisplay .= $listOfdetails['result']["formatted_phone_number"] . "<br>";
		$listDisplay .= formatOpenClosed($listOfdetails['result']["opening_hours"]["open_now"]) . "<br><br>";

					for($j = 0 ; $j < count($listOfdetails['result']["opening_hours"]["periods"]) ; $j++){

						//check if it's todaty's date and highlight the respective row
						if($days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] == $days[$today]){

							$listDisplay .= "<b>" . $days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "</b><br>";

						}

						else{

							$listDisplay .= $days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "<br>";
						} //end if
					}//end for
					echo "<br><br>";
	} //end for 

						return $listDisplay;
}
//end fn

function getplaceReferences($radius,$btype,$lat,$lng){

	global $session;
	$resultsArray = array();

	$placeSearch = new Google_Places_PlaceSearch($session);

	// Get an input object for the Choreo
	$placeSearchInputs = $placeSearch->newInputs();

	// Set inputs
	$placeSearchInputs->setKey(PLACES_KEY)->setRadius($radius)->setTypes($btype)->setResponseFormat("json")->setLatitude($lat)->setLongitude($lng);

	// Execute Choreo and get results
	$placeSearchResults = $placeSearch->execute($placeSearchInputs)->getResults();

	$resultsArray = json_decode($placeSearchResults->getResponse(),true);

	return $resultsArray;

}
//end fn

function getCoordinates($address){

	global $session; 
	$coordinates = array();

	global $sensor;

	$geocodeByAddress = new Google_Geocoding_GeocodeByAddress($session);

	// Get an input object for the Choreo
	$geocodeByAddressInputs = $geocodeByAddress->newInputs();
			
	// Set inputs
	$geocodeByAddressInputs->setSensor($sensor)->setAddress($address)->setResponseFormat("json");

	// Execute Choreo and get results
	$geocodeByAddressResults = $geocodeByAddress->execute($geocodeByAddressInputs)->getResults();

	//store the coordinates in an array
	$coordinates['lat'] = $geocodeByAddressResults->getLatitude();
	$coordinates['lng'] = $geocodeByAddressResults->getLongitude();

	return $coordinates;

} //end fn

//this fn uses google text search api to retrieve place references
function getPlaceReferencesviaText($qry,$radius){

	global $session;

	// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
	$get = new Utilities_HTTP_Get($session);

	// Get an input object for the Choreo
	$getInputs = $get->newInputs();

	// Set inputs for Google Key and Query here. 
	$getInputs->setRequestParameters("{\"key\": \"" . PLACES_KEY . "\", \"sensor\": 'false', \"query\": \"" . $qry . "\", \"radius\": '$radius' }")->setURL("https://maps.googleapis.com/maps/api/place/textsearch/json");

	// Execute Choreo and get results
	$getResults = $get->execute($getInputs)->getResults();

	$resultsArray = json_decode($getResults->getResponse(),true);

	return $resultsArray;
} //end fn

function formatOpenClosed($trueFalse){

	if($trueFalse){
		$state = "Opened";
	}
	else{
		$state = "Closed";
	}

	return $state;
}//end fn


//create a session key to be stored and then used to validate user sessions throughout the site for secure pages
function generateSessionkey(){

	$hash = "shshdf9dmddmeiwwss9sksks";
	
	$sessionKey3 = rand(13273,98176274490);
	$sessionKey2 = md5(sha1($hash));
	$sessionKey4 = time();

	$session = $sessionKey3 . $sessionKey2 . $sessionKey4;

	return $session;

}//end fn


//retrieves all of the place references from bhours database
function getBHoursrefs(){

	$refs = array();

	//get all of the availble ref ids in the db
	$bhoursRefids = mysql_query("SELECT ref_id from " . REFERENCES . ";");

	while($result = mysql_fetch_array($bhoursRefids)){
			$refs[] = $result['ref_id']; 
	} //end while

	return $refs;
}//end fn


function addToFavorites($refs){

	for($i=0 ; $i<count($refs) ; $i++){

		$sqlString = mysql_query("INSERT INTO " . FAVES . " (user_id, reference_id) VALUES('" . $_SESSION['uid'] . "','" . $refs[$i]  . "')") or die("unable to insert data");
								}

}//end fn

function deleteFavorites($refArray){

	for($i=0 ; $i<count($refArray) ; $i++){

		$sqlString = mysql_query("DELETE FROM " . FAVES . " WHERE user_id='" . $_SESSION['uid'] . "' AND  reference_id='" . $refArray[$i]  . "'") or die(mysql_error());

									}

}//end fn



function showMyFavorites(){

	$favIDs = array();
	$myFavorites = array();
	$placeDetails = array();
	global $days;
	global $today;

	//get the references from the db
	$queryFaves = mysql_query("SELECT reference_id FROM " . FAVES . " WHERE user_id ='" . $_SESSION['uid'] . "'" . ";") or die("unable to locate favorites");

	//store out the references in an array
	while($favIDs = mysql_fetch_array($queryFaves)){
		$myFavorites[] = $favIDs['reference_id'];
	}//end while

	//get the place details for each reference and store it in an array
	foreach ($myFavorites as $key => $faves) {
	$placeDetails[] = getDetailsByRef($faves);		
	}

	//iterate through each reference to out place details including store hours
	for($i = 0 ; $i < count($placeDetails) ; $i++){
	

		$listDisplay .= "<input type=checkbox name='referenceIDs[]' value='" . $myFavorites[$i]  . "'/>";
		$listDisplay .= $placeDetails[$i]['result']["name"] . "<br>";
		$listDisplay .= $placeDetails[$i]['result']["adr_address"] . "<br>";
		$listDisplay .= $placeDetails[$i]['result']["formatted_phone_number"] . "<br>";
		$listDisplay .= formatOpenClosed($placeDetails[$i]['result']["opening_hours"]["open_now"]) . "<br><br>";

					for($j = 0 ; $j < count($placeDetails[$i]['result']["opening_hours"]["periods"]) ; $j++){


						//check if it's todaty's date and highlight the respective row
						if($days[$placeDetails[$i]['result']["opening_hours"]["periods"][$j]["open"]["day"]] == $days[$today]){

							$listDisplay .= "<b>" . $days[$placeDetails[$i]['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($placeDetails[$i]['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($placeDetails[$i]['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "</b><br>";

						}

						else{

							$listDisplay .= $days[$placeDetails[$i]['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($placeDetails[$i]['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($placeDetails[$i]['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "<br>";
						} //end if
					}//end for
					echo "<br><br>";
	} //end for 

						echo $listDisplay;


}//end fn


function getDetailsByRef($reference_id){

	global $session;

	// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
	$get = new Utilities_HTTP_Get($session);

	// Get an input object for the Choreo
	$getInputs = $get->newInputs();

	// Set inputs for Google Key and Query here. 
	$getInputs->setRequestParameters("{\"key\": \"" . PLACES_KEY . "\", \"reference\": \"" . $reference_id . "\", \"sensor\": 'false'}")->setURL("https://maps.googleapis.com/maps/api/place/details/json");

	// Execute Choreo and get results
	$getResults = $get->execute($getInputs)->getResults();

	$resultsArray = json_decode($getResults->getResponse(),true);

	return $resultsArray;

}




function secureSession(){

	session_start();

	print_r($_SESSION);

	$sessionMsg = "Invalid session! Clear your cookies and try logging in again.";

/*
	//check to ensure no hackers and that its a legit browser
	if(isset($_SESSION['HTTP_USER_AGENT'])){

			//check session id
			if(isset($_SESSION['uid']))
			{

					$sessionDetail = mysql_query("SELECT session_key, session_start FROM " . USERS . " WHERE id ='".$_SESSION['uid']."'") or die(mysql_error());

					list($sessKey, $start_time) = mysql_fetch_row($sessionDetail);

					if(!isset($_SESSION['stime']) && $_SESSION['stime'] != $start_time || !isset($_SESSION['skey']) && $_SESSION['skey'] != $sessKey)
					{
						$sessionMsg = "something wrong with the key and time";
						logout($sessionMsg);
						exit;
					}//end if
					else{

		//				echo "nothing wrong here";
					}	
			} //end if
			else{
		 			$sessionMsg = "no session id detected";
				logout($sessionMsg);
				exit;
			}
	}
	else{

	//check if the current page being accessed is the profile page. if it is, then don't log them out.
		if(!basename($_SERVER['SCRIPT_NAME']) == 'profile.php'){
			logout();
			exit;
		}
	}//end if
*/
}//end fn

?>