<?
// Start session
session_start();

// Include required functions file
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');

// Include the class sources

// Check login status... if not logged in, redirect to login screen
if (check_login_status() == false) {
        redirect('login.php');
}

?>
<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">
	
      <?php
        // open connection to MySQL server
        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');

        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $user = $_SESSION['username'];
	$deleter = $_POST['delid'];
	if ($deleter <> 0) 
	{
		$delquery = "DELETE FROM Saved_Food where ID = '$deleter' and USER = '$user';";
        	$delresult = mysql_query($delquery);	
	}		

        echo "<h1>Delete Saved Food Items</h1>";
        //select database
	//create and execute query
        $query = "SELECT ID, Name, Points FROM Saved_Food where USER = '$user' order by Name;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
	echo "<table border=\"1\">";
	echo "<td><b>Food Name</b></td>";
	echo "<td><b>Point Value</b></td>";
        //create selection list
        while($row = mysql_fetch_row($result))
        {
                $id = $row[0];
		$name = substr(stripslashes($row[1]),0,50);
		$points = $row[2];
		echo "<tr>";
		echo "<td>$name</td>";
		echo "<td align=\"right\">$points</td>";
		echo "<td><form style=\"margin-bottom:0;\" name=\"deleter$id\" method=\"POST\" action=\"$_SERVER[PHP_SELF]\"><input type=\"hidden\" name=\"date\" value='$date'/><input type=\"hidden\" value=$id name=\"delid\"><input type=\"image\" src=\"images/delete.png\" value=\"Submit\" name=\"B1\"></form></td>";
		echo "</tr>";
        }
	echo "<tr>";
	echo "</table></td>";

	mysql_close($connection);
       	?> 
<br><br>
</body>
</html>
