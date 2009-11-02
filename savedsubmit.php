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


$food_id = cleanQuery($_REQUEST['Saved_Food']) ;
$servings = cleanQuery($_REQUEST['servings']) ;
if($food_id <> 'Default')
{
$date = cleanQuery($_REQUEST['date']) ;
mysql_select_db(DB_DATABASE, $con);
        $query = "SELECT Name, Calories, Fat, Fiber, Points, Type FROM Saved_Food where ID = $food_id;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());

        while($row = mysql_fetch_row($result))
        {
                $name = $row[0];
                $calories = $row[1];
                $fat = $row[2];
		$fiber = $row[3];
		$points = $row[4];
		$type = $row[5];
        }

$sname = stripslashes($name);
$user = $_SESSION['username'];
echo "<h1><b>Form Confirmation</b></h1>";
echo "<h2>Food ID: $food_id </br>";
echo "Date: $date </br>";
echo "Name: $sname </br>";
echo "Calories: $calories </br>";
echo "Fat: $fat </br>";
echo "Fiber: $fiber </br>";
echo "Servings: $servings </br>";
$spoints = round((($calories*$servings)/50) + (($fat*$servings)/12) - (min(($fiber*$servings),4)/5));
echo "Points: $spoints </br>";
echo "Type: $type </br>";
$uname = ucwords($user);
echo "Username: $uname</h2>";

$result = mysql_query("INSERT INTO `Daily_Food` (`NAME`,`Calories`,`Fat`,`Fiber`,`Servings`,`Points`,`Date_Entered`,`User`,`Type`) VALUES ('$name', '$calories', '$fat', '$fiber', '$servings', '$spoints', '$date', '$user', '$type');")
or die(mysql_error());  


mysql_close($con);
}
else
{
echo "You didn't select a food from the list!";
}
echo "<br>";
echo "<br>";
echo "<a href=../index.php>Enter Another Item</a>";
?>
</div></div>
