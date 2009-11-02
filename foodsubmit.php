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
// Make a MySQL Connection
$con = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


function cleanQuery($string)
{
  if(get_magic_quotes_gpc())  // prevents duplicate backslashes
  {
    $string = stripslashes($string);
  }
  if (phpversion() >= '4.3.0')
  {
    $string = addslashes(mysql_real_escape_string($string));
  }
  else
  {
    $string = addslashes(mysql_escape_string($string));
  }
  return $string;
}


$date = cleanQuery($_REQUEST['date']) ;
$name = cleanQuery($_REQUEST['food']) ;
$calories = cleanQuery($_REQUEST['calories']) ;
$fat = cleanQuery($_REQUEST['fat']) ;
$fiber = cleanQuery($_REQUEST['fiber']) ;
$save = cleanQuery($_REQUEST['save']) ;
$type = cleanQuery($_REQUEST['type']) ;
$servings = cleanQuery($_REQUEST['servings']) ;
$points = round((($calories*$servings)/50) + (($fat*$servings)/12) - (min(($fiber*$servings),4)/5)); 
$rpoints = round(($calories/50) + ($fat/12) - (min($fiber,4)/5));
$user = $_SESSION['username'];
$sname = stripslashes($name);
echo "<h1><b>Form Confirmation</b></h1>";
echo "Date: $date </br>";
echo "Name: $sname </br>";
echo "Calories: $calories </br>";
echo "Fat: $fat </br>";
echo "Fiber: $fiber </br>";
echo "Servings: $servings </br>";
echo "Points: $points </br>";
echo "Type: $type </br>";
$uname = ucwords($user);
echo "Username: $uname";

mysql_select_db(DB_DATABASE) or die ('Unable to select database!');

$result = mysql_query("INSERT INTO `Daily_Food` (`NAME`,`Calories`,`Fat`,`Fiber`,`Servings`,`Points`,`Date_Entered`,`User`,`Type`) VALUES ('$name', '$calories', '$fat', '$fiber', '$servings', '$points', '$date', '$user', '$type');")
or die(mysql_error());  

if($save <> 'No')
{
$result2 = mysql_query("INSERT INTO `Saved_Food` (`NAME`,`Calories`,`Fat`,`Fiber`,`Points`,`User`,`Type`) VALUES ('$name', '$calories', '$fat', '$fiber', '$rpoints', '$user', '$type');")
or die(mysql_error());
}
mysql_close($con);
echo "<br>";
echo "<br>";
echo "<a href=../index.php>Enter Another Item</a>";
?>
</div></div>
