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


        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');
        //select database
        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
	$today = date("Y-m-d");
        $user = $_SESSION['username'];

	$weighta = cleanQuery($_POST['weight']);
        $user = $_SESSION['username'];
  
if ($weighta <> NULL) {
$wquery = "SELECT * FROM Weight where User = '$user' and Date = '$today';";
$wresult = mysql_query($wquery) or die ('Error in query: $wquery. ' . mysql_error());
if (mysql_num_rows($wresult) == 0){
        $querya = "SELECT * from Profile where USER = '$user';";
        $tresulta = mysql_query($querya) or die ('Error in query: $querya. ' . mysql_error());
        $rowa = mysql_fetch_row($tresulta);
        $ssex = $rowa[0];
        $sage = $rowa[1];
        $sheight = $rowa[2];
        $sact = $rowa[5];
        $smod = $rowa[7];
        if (strlen($weighta) == 3)
                $trweight =  substr($weighta, 0, 2);
        else
                $trweight =  substr($weighta, 0, 1);

$weekly = $ssex + $sage + $sheight + $trweight + $sact + $smod;
$upprofile = "UPDATE Profile set Weight = '$trweight', TRWeight = '$weighta', Weekly = '$weekly' where User = '$user';";
$upweight = "INSERT INTO Weight (`User`, `Weight`, `Date`) VALUES ('$user', '$weighta', '$today');";
$rupprofile = mysql_query($upprofile) or die ('Error in query: $upprofile. ' . mysql_error());
$rupweight = mysql_query($upweight) or die ('Error in query: $upweight. ' . mysql_error());
echo "Weight Updated to $weighta Sucessfully";
}
else {echo "Your Weight for today has already been posted<br>";}
}
	
	?>	
	<h2><p>Please Enter The Following Information</p></h2>
	<form name="weighin" method="POST" action="#"> 
	<p><h3>Enter Your Weight: <input type='text' name='weight'></h3></p>
	<h3><input type='submit' value='Submit' name='B1'></p></h3>
	</form><br /><br />

	<?php

	mysql_close($connection); 
       	?>
<br><br>
</body>
</html>
