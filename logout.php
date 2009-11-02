<?php
// Start session
session_start();
 
// Include required functions file
require_once('includes/functions.inc.php');
 
// If not logged in, redirect to login screen
// If logged in, unset session variable and display logged-out message
if (check_login_status() == false) {
	// Redirect to 
	redirect('login.php');
} else {
	// Kill session variables
	unset($_SESSION['logged_in']);
	unset($_SESSION['username']);
	unset($_SESSION['first']); 
	// Destroy session
	$date_of_expiry = time() - 60 ;
	setcookie( "username", "$username", $date_of_expiry, "/" ) ;	
	setcookie( "password", "none", $date_of_expiry, "/" ) ;
	session_destroy();
}
?>
<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">
<body>
<h1>Logged Out</h1>
<p>You have successfully logged out. Back to <a href="../login.php">login</a> screen.</p>
</body></div></div>
</html>
