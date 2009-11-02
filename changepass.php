<?
// Start session
session_start();

// Include required functions file
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');
// Check login status... if not logged in, redirect to login screen
if (check_login_status() == false) {
        redirect('login.php');
}

?>

<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">
      <?php

        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');
        //select database
        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $user = $_SESSION['username'];

	?>
        <h2><p>Please Enter The Following Information</p></h2>
        <form name="changepass" method="POST" action="#">
	<h2>Enter Password: <input type='password' name='pass1'></h2>
	<h2>Retype Password: <input type='password' name='pass2'></h2>
        <input type='button' value='Submit' onclick="verify();" name='B1'></p></h3>
        </form><br /><br />

	<?php
	$pass = $_POST['pass1'];
	if (isset($pass)) 
		{
        		$querya = "Update users SET password = md5('$pass') where username = '$user';";
        		$resulta = mysql_query($querya) or die ('Error in query: $querya. ' . mysql_error());
			echo "<h2>Password Sucessfully Changed<h2>";
		}

	mysql_close($connection); 
       	?>
<br><br>
</body>
</html>
