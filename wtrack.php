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

<html>
<head>
        <title><?php echo ucwords($_SESSION['first']);?>'s Point Tracker</title>

        <!-- link calendar files  -->
        <script language="JavaScript" src="java/calendar_db.js"></script>
        <script language="JavaScript" src="java/verify.js"></script>
        <link href="css/calendar.css" rel="stylesheet"/>
        <link href="css/default.css" rel="stylesheet"/>
        <link href="css/layout.css" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
<div id="header">
        <h1><p><?php echo ucwords($_SESSION['first']);?>'s Point Tracker</p></h1>
</div>
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

	$sexv = $_POST['Sex'];
       	$agev =  cleanQuery($_POST['Age']);
	$heightv =  cleanQuery($_POST['Height']);
	$weighta = cleanQuery($_POST['weight']);
	        if (strlen(cleanQuery($_POST['weight'])) == 3)
                $weightv =  substr(cleanQuery($_POST['weight']), 0, 2);
        else
                $weightv =  substr(cleanQuery($_POST['weight']), 0, 1);
	$actv =  cleanQuery($_POST['Activity']);
	$modv = cleanQuery($_POST['Modder']);
	$weekly = $sexv + $agev + $heightv + $weightv + $actv + $modv;

        if ($weekly <> 0)
                {
        echo "<h1>Daily Points Allowed: $weekly</h1>";

        //create and execute query
        $query = "SELECT count(*) from Profile where USER = '$user';";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
        $row = mysql_fetch_row($result);
        if ($row[0] == 0)
                {$query2 = "INSERT INTO `Profile` (`Sex`,`Age`,`Height`,`Weight`,`TRWeight`,`Activity`,`Weekly`,`Modifier`,`User`)VALUES ('$sexv', '$agev', '$heightv', '$weightv', '$weighta', '$actv', '$weekly', '$modv', '$user');";
                 $result2 = mysql_query($query2) or die ('Error in query: $query. ' . mysql_error());}

        else
                {$query2 = "Update `Profile` set `Sex`='$sexv',`Age`='$agev',`Height`='$heightv',`Weight`='$weightv',`TRWeight`='$weighta',`Activity`='$actv',`Weekly`='$weekly',`Modifier`='$modv' where `USER` = '$user';";
                 $result2 = mysql_query($query2) or die ('Error in query: $query. ' . mysql_error());
        
                }
        }

	else
	{


        $user = $_SESSION['username'];
        $querya = "SELECT * from Profile where USER = '$user';";
        $resulta = mysql_query($querya) or die ('Error in query: $querya. ' . mysql_error());
        $rowa = mysql_fetch_row($resulta);
	$ssex = $rowa[0];
	$sage = $rowa[1];
	$sheight = $rowa[2];
	$sweighta = $rowa[4];
	$sact = $rowa[5];
	$smod = $rowa[7];
	?>	
	<h2><p>Please Enter The Following Information</p></h2>
	<form name="profiler" method="POST" action="#"> 
	<h3>Enter Your Sex: <select name='Sex'> <option  <?php if($ssex == 2) {echo "selected";}?> value=2>Female</option><option <?php if($ssex == 8) {echo "selected";}?> value=8>Male</option><option <?php if($ssex == 12) {echo "selected";}?> value=12>Nursing Mother</option></select></h3><p /> 
	<h3>How Old are You: <select name='Age'> <option <?php if($sage == 4) {echo "selected";}?> value=4>17-26</option><option  <?php if($sage == 3) {echo "selected";}?> value=3>27-37</option><option  <?php if($sage == 2) {echo "selected";}?> value=2>38-47</option><option  <?php if($sage == 1) {echo "selected";}?> value=1>48-58</option><option  <?php if($sage == 0) {echo "selected";}?> value=0>59+</option></select></h3> 
	<p><h3>Enter Your Weight: <input type='text'  <?php if ($sweighta == "") {echo "";} else {echo "default value=$sweighta";}?> name='weight'></h3></p>
	<h3>How Tall Are You: <select name='Height'> <option <?php if($sheight == 0) {echo "selected";}?> value=0>Under 5'1</option><option  <?php if($sheight == 1) {echo "selected";}?> value=1>5'1 - 5'10</option><option  <?php if($sheight == 2) {echo "selected";}?> value=2>Over 5'10</option></select></h3><p /> 
	<h3>How do you spend most of the day: <select name='Activity'> <option <?php if($sact == 0) {echo "selected";}?> value=0>Sitting Down</option><option <?php if($sact == 2) {echo "selected";}?> value=2>Occasionally Sitting</option><option <?php if($sact == 4) {echo "selected";}?> value=4>Walking Most of the Time</option><option <?php if($sact == 6) {echo "selected";}?> value=6>Doing Physically hard work Most of the Time</option></select></h3><p /> 
	<h3>Add or Remove Daily Points: <select name='Modder'><option <?php if($smod == -3) {echo "selected";}?> value=-3>-3</option><option <?php if($smod == -2) {echo "selected";}?> value=-2>-2</option><option <?php if($smod == -1) {echo "selected";}?> value=-1>-1</option><option <?php if($smod == 0) {echo "selected";}?> value=0>0</option><option <?php if($smod == 1) {echo "selected";}?> value=1>1</option><option <?php if($smod == 2) {echo "selected";}?> value=2>2</option></select></h3><p />
<h2><a href=changepass.php>Change Password</a></h2>
<br /><h3><p>
<input type='submit' value='Submit' name='B1'></p></h3>
	</form><br /><br />

	<?php

	mysql_close($connection); 
	}
       	?>
<br><br>
</body>
</html>
