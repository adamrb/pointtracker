<?php
// Include required MySQL configuration file and functions
require_once('config.inc.php');
require_once('functions.inc.php');
 
// Start session
session_start();

// Check if user is already logged in
if ($_SESSION['logged_in'] == true) {
	// If user is already logged in, redirect to main page
	redirect('../index.php');
} else {
	// Make sure that user submitted a username/password and username only consists of alphanumeric chars
	if ( (!isset($_POST['username'])) || (!isset($_POST['password']))|| 
	     (!ctype_alnum($_POST['username']))) {
		if (!isset($_COOKIE["username"]) or !isset($_COOKIE["password"])) {	redirect('../login.php');}
	}
 
	// Connect to database
	$mysqli = @new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
	// Check connection
	if (mysqli_connect_errno()) {
		printf("Unable to connect to database: %s", mysqli_connect_error());
		exit();
	}
	
	$lusername = strtolower($_POST['username']); 
	// Escape any unsafe characters before querying database
	//$username = $mysqli->real_escape_string($lusername);
	$password = $mysqli->real_escape_string($_POST['password']);
	$cpassword = $_COOKIE["password"];	
	if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
		$username = $_COOKIE["username"];
		$sql = "SELECT First_Name FROM users WHERE username = '" . $username . "' AND password = '" . $cpassword . "'";
	}
	else {
		$username = $mysqli->real_escape_string($lusername);	
		$sql = "SELECT First_Name FROM users WHERE username = '" . $username . "' AND password = '" . md5($password) . "'";
	}	
	$result = $mysqli->query($sql);
 
	// If one row is returned, username and password are valid
	if (is_object($result) && $result->num_rows == 1) {
		// Set session variable for login status to true
		$_SESSION['logged_in'] = true;
		while ($row = $result->fetch_row()) {
			$_SESSION['first'] = $row[0];}	
		$_SESSION['username'] = $username;
		$number_of_days = 30 ;
		if (isset($_POST['remember'])) {
		$cpass = md5($password);
		$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
		setcookie( "username", "$username", $date_of_expiry, "/" ) ;
		setcookie( "password", "$cpass", $date_of_expiry, "/" ) ;
		}
		redirect('../index.php');
	} else {
		// If number of rows returned is not one, redirect back to login screen
		$date_of_expiry = time() - 60 ;
       		setcookie( "username", "$username", $date_of_expiry, "/" ) ;
	        setcookie( "password", "none", $date_of_expiry, "/" ) ;
		redirect('../login.php?&message=1');
	}
}
?>
