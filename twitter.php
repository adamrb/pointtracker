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


require_once('menu.php');?>

<div id="page">
        <div id="page-bg">

<?php
// Make a MySQL Connection
$con = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
         mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $user = $_SESSION['username'];

        $tquerya = "SELECT * from Twitter where USER = '$user';";
        $tresulta = mysql_query($tquerya) or die ('Error in query: $tquerya. ' . mysql_error());
        $trowa = mysql_fetch_row($tresulta);

$username = $trowa[1];
$password = $trowa[2];

$today = $_POST['ptoday'];
$total = $_POST['ptotal'];
$goal = $_POST['pweight'];

$message = "I have used " . $today . " out of " . $total . " points today, and is " . $goal . "lbs from my weight goal.";

    $host = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($message)));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Go for it!!!
    $result = curl_exec($ch);
    // Look at the returned header
    $resultArray = curl_getinfo($ch);

    // close curl
    curl_close($ch);

    //echo "http code: ".$resultArray['http_code']."<br />";

    if($resultArray['http_code'] == "0"){
        echo "<br />OK! posted to <a href=http://twitter.com/".$username."/>Twitter</a><br />";
    } else {
        echo "eek! yegads! error posting to Twitter";
    }

mysql_close($con);
echo "<br>";
?>
</div></div>
