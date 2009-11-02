<?
// Start session
session_start();

// Include required functions file
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');

?>

<?php require_once('menu.php');?>
<script language="JavaScript" src="java/passverify.js"></script>
<div id="page">
        <div id="page-bg">
      <?php

        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');
        //select database
        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $user = $_SESSION['username'];

	?>
        <h1><p>User Information</p></h1>
        <form name="newuser" method="POST" action="#">
	<h3>First Name: <input type='text' size=15  name='first'></h3><p />
	<h3>Last Name: <input type='text' size=20 name='last'></h3><p />
	<h3>Username: <input type='text' size=15 maxlength=20 name='username'></h3><p />
	<h3>Enter Password: <input type='password' name='pass1'>&nbsp;&nbsp;
	Retype Password: <input type='password' name='pass2'></h3><br />
	<hr />	
	<h1><p>Profile Information</p></h1>
        <h3>Enter Your Sex: <select name='Sex'> <option  <?php if($ssex == 2) {echo "selected";}?> value=2>Female</option><option <?php if($ssex == 8) {echo "selected";}?> value=8>Male</option><option <?php if($ssex == 12) {echo "selected";}?> value=12>Nursing Mother</option></select></h3><p />
        <h3>How Old are You: <select name='Age'> <option <?php if($sage == 4) {echo "selected";}?> value=4>17-26</option><option  <?php if($sage == 3) {echo "selected";}?> value=3>27-37</option><option  <?php if($sage == 2) {echo "selected";}?> value=2>38-47</option><option  <?php if($sage == 1) {echo "selected";}?> value=1>48-58</option><option  <?php if($sage == 0) {echo "selected";}?> value=0>59+</option></select></h3>
        <p><h3>Enter Your Weight: <input type='text'  <?php if ($sweighta == "") {echo "";} else {echo "default value=$sweighta";}?> name='weight'></h3></p>
	<p><h3>Enter Your Weight Goal: <input type='text'  <?php if ($sgoal == "") {echo "";} else {echo "default value=$sgoal";}?> name='goal'></h3></p> 
       <h3>How Tall Are You: <select name='Height'> <option <?php if($sheight == 0) {echo "selected";}?> value=0>Under 5'1</option><option  <?php if($sheight == 1) {echo "selected";}?> value=1>5'1 - 5'10</option><option  <?php if($sheight == 2) {echo "selected";}?> value=2>Over 5'10</option></select></h3><p />
        <h3>How do you spend most of the day: <select name='Activity'> <option <?php if($sact == 0) {echo "selected";}?> value=0>Sitting Down</option><option <?php if($sact == 2) {echo "selected";}?> value=2>Occasionally Sitting</option><option <?php if($sact == 4) {echo "selected";}?> value=4>Walking Most of the Time</option><option <?php if($sact == 6) {echo "selected";}?> value=6>Doing Physically hard work Most of the Time</option></select></h3><p />
        <input type='button' value='Submit' onclick="nverify();" name='B1'></p></h3>
        </form><br /><br />

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

	$firstv = cleanQuery($_POST['first']);
	$lastv = cleanQuery($_POST['last']);
	$usern = strtolower(cleanQuery($_POST['username']));
	$pass = cleanQuery($_POST['pass1']);
        $sexv = cleanQuery($_POST['Sex']);
        $agev =  cleanQuery($_POST['Age']);
        $heightv =  cleanQuery($_POST['Height']);
        $weighta = cleanQuery($_POST['weight']);
        $goal = cleanQuery($_POST['goal']);
	if (strlen(cleanQuery($_POST['weight'])) == 3)
        	$weightv =  substr(cleanQuery($_POST['weight']), 0, 2);
      	else
		$weightv =  substr(cleanQuery($_POST['weight']), 0, 1); 
	$actv =  cleanQuery($_POST['Activity']);
        $modv = cleanQuery($_POST['Modder']);
        $weekly = $sexv + $agev + $heightv + $weightv + $actv + $modv;
	if ($firstv <> NULL)
	{
        $query = "SELECT count(*) from users where username = '$usern';";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
        $row = mysql_fetch_row($result);
        if ($row[0] == 0)
                {$query2 = "INSERT INTO `Profile` (`Sex`,`Age`,`Height`,`Weight`,`TRWeight`,`Activity`,`Weekly`,`Modifier`,`Goal`,`User`,`Startday`)VALUES ('$sexv', '$agev', '$heightv', '$weightv', '$weighta', '$actv', '$weekly', '$modv', '$goal', '$usern', 'Sunday');";
                 $result2 = mysql_query($query2) or die ('Error in query: $query. ' . mysql_error());
		$query3 = "INSERT INTO `users` (`id` ,`First_Name` ,`Last_Name` ,`username` ,`password`)VALUES (NULL ,'$firstv','$lastv', '$usern', MD5('$pass'));";
		$result3 = mysql_query($query3) or die ('Error in query: $query3. ' . mysql_error());	
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=login.php?&message=2\">";
		//redirect('../login.php?&message=1');
		}

        else
		{echo "<h1>This Username already Exists, Please Select Another</h1>";
                }
        }
	mysql_close($connection); 
       	?>
<br><br>
</body>
</html>
