<?
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
	<table width = 100%>
	<tr >
	<td class="borders">
	<p><h2>Select from a previously entered food</h2></p>
	<form name="savedfood" method="POST" action="savedsubmit.php">
      <?php
	$today = date("Y-m-d");
        // open connection to MySQL server
        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');
	$user = $_SESSION['username'];
        //select database
        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
	if(isset($_POST['myfood']))
		{$myfood = $_POST['myfood'];}
	else
		{$myfood = "yes";}
	$type = $_POST['type'];
        //create and execute query
	if($myfood == "yes") {$byuser = "and User = '$user' ";}
	if($type <> '' && $type <> 'All' ) {$bytype = "and Type = '$type' ";}	
	$query = "SELECT Name, Points, ID FROM Saved_Food where ID is NOT NULL " . $byuser . $bytype . " order by Name;";
	$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());

        //create selection list
        echo "<b>Saved Food:</b><br /><select name=\"Saved_Food\" size=6>";
        //echo "<option selected value='Default'></option>";
        while($row = mysql_fetch_row($result))
        {
                $heading = substr(stripslashes($row[0]),0,35);
		$point = $row[1];
		$fid = $row[2];
                echo "<option value='$fid'>$heading &nbsp;($point points)\n";
        }
        echo "</select><font size=1><a href=delsaved.php>Edit Saved Item List</a></font>";
	echo "<h2>Servings: <select name=\"servings\"><option value=.25>1/4</option><option value=.5>1/2</option><option selected value=1>1</option><option value = 2>2</option><option value = 3>3</option></select><br /></h2>";
	echo "<p>Date: <input type=\"text\" name=\"date\" size=11 default value='$today' />";
       	?> 
	<script language="JavaScript">
        new tcal ({
                // form name
                'formname': 'savedfood',
                // input name
                'controlname': 'date'
        });
        </script></p>
	<p><input type='submit' value='Submit' name='B1'></p>
	</form></td>
	<td align=right><h2>Filter Selection</h2> <form name="showmyfood" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p>Food Type &nbsp;
	<?php
        $query = "SELECT DISTINCT Type from Saved_Food order by Name;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
	
        //create selection list
	$type = $_POST['type'];
       	echo "<select name=type onchange='this.form.submit()'>"; 
	echo "<option value='All'>Show All</option>";
        while($row = mysql_fetch_row($result))
        {
       		$selected = ""; 
	        $name = $row[0];
              	if(!strcmp($type,$name))
			{$selected = "selected";} 
		$sname = substr($name,0,20);
		echo "<option $selected value='$name'>$sname</option>\n";
        }
        echo "</select>&nbsp;&nbsp;</p>";
	?>
	<p>Show All Entries<input type='radio' value='no' onchange='this.form.submit()' name='myfood' <?php if($myfood == "no") {echo "checked";}?>>&nbsp;Show My Entries<input type='radio' onchange='this.form.submit()' value='yes' name='myfood' <?php if($myfood == "yes") {echo "checked";}?>></p>	
	<!--	<p><input type='submit' value='Filter' name='B1'></p>-->
        </form></td></tr></table>
	<div class="hr1">
		<hr />
	</div>
	
	<form name="newfood" method="POST" action="foodsubmit.php">
	<p><h2>Submit and Enter a new Food Item: </h2></p>
	<!-- calendar attaches to existing form element -->
	<table>
	<tr><td>Food Name</td><td><input type="text" name="food" maxlength=30 size=30></td></tr>
	<tr><td>Calories</td><td><input type="text" name="calories" size="5"></td></tr>
	<tr><td>Fat</td><td><input type="text" name="fat" size="3"></td></tr>
	<tr><td>Fiber</td><td><input type="text" name="fiber" size="2"></td></tr>
	<tr><td>Servings</td><td><select name="servings"><option value=.25>1/4</option><option value=.5>1/2</option><option selected value=1>1</option><option value = 2>2</option><option value = 3>3</option></select></td></tr>
	<tr><td>Type</td><td>
        <?php
        $query = "SELECT Name from Snack_Types order by Name;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());

        //create selection list
        echo "<select name=type>";
        while($row = mysql_fetch_row($result))
        {
                $name = $row[0];
		
                echo "<option value='$name'>$name\n</option>";
        }
       	echo "<option selected value='Other'>Other</option>"; 
	echo "</select>&nbsp;&nbsp;</p>";
        ?>

	</table>
	<?php
        $today = date("Y-m-d");
        echo "<p>Date: <input type=\"text\" name=\"date\" size=11 default value='$today' />";
        ?>	
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'newfood',
		// input name
		'controlname': 'date'
	});
	</script></p>
	<p>Save Item to List?&nbsp;<input type="radio" name="save" value="Yes" checked>Yes  <input type="radio" name="save" value="No"> No</p>
	<p><input type=button value="Submit" onclick="verify();"></p>
</form>
</div></td></tr></table></div></div>
</body>
</html>
