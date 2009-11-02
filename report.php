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
		$delquery = "DELETE FROM Daily_Food where ID = '$deleter' and USER = '$user';";
        	$delresult = mysql_query($delquery);	
	}		

	$weekquery = "SELECT Weekly, TRWeight, Startday from Profile where USER = '$user';";
	$goalquery = "SELECT Goal from Profile where USER = '$user';";
	$weekresult = mysql_query($weekquery) or die ('Error in query: $weekquery. ' . mysql_error());
	$goalresult = mysql_query($goalquery) or die ('Error in query: $goalquery. ' . mysql_error());
	$tquerya = "SELECT * from Twitter where USER = '$user';";
	$tresulta = mysql_query($tquerya) or die ('Error in query: $tquerya. ' . mysql_error());
	$trowa = mysql_fetch_row($tresulta);
	$pointarr = mysql_fetch_row($weekresult);
	$goal = mysql_fetch_row($goalresult);
	$dailypoint = $pointarr[0];	
	$weight = $pointarr[1];
	$sday = $pointarr[2];
	$wgoal = $goal[0];
	$gdiff = $weight - $wgoal;
	//Set the Date
        $today = date("Y-m-d");
                if(isset($_POST['fdate']))
                {$date = stripslashes($_POST['fdate']);}
        else
                {$date = $today;}

	if ($dailypoint == 0)
		{echo "<h1>You have not <a href=profile.php>setup a profile</a>. You must do so to calculate daily points.</h1>";}
	else
		{echo "<h2>Points Allowed Per Day: $dailypoint</h2>";}
      
        if ($wgoal == 0)
                {echo "<h2>You have not <a href=profile.php>Set a Weight Goal</a>. You should do that now!</h2>";}
        else
                {echo "<h2>You are " . $gdiff . "lbs away from your weight goal of $wgoal.  <font size=1><a href=weighin.php>Weigh In Now</a></font></h2>";} 
	
	$wday = date("l", strtotime($date));

	//Calculate Weekly Points
	if ($wday == $sday)
		$startday = date("Y-m-d",strtotime("$sday",strtotime($date)));	
	else
		$startday = date("Y-m-d",strtotime("Last $sday",strtotime($date)));
	
	$endday = date("Y-m-d",strtotime("+7 Days $startday",strtotime($date)));
	$wquery = "SELECT DATE_ENTERED, sum(POINTS) FROM Daily_Food where DATE_ENTERED >= '$startday' and DATE_ENTERED < '$endday' and USER = '$user' group by DATE_ENTERED order by DATE_ENTERED;";
	//echo $wquery;	
	$wresult = mysql_query($wquery) or die ('Error in query: $query. ' . mysql_error());
        while($row = mysql_fetch_row($wresult))
        {
                $wday = $row[0];
		$week = $weekday = date('l', strtotime($wday));
                $wval = $row[1];
		if (!isset($chd))
		   {$chd = $wval;}
		else
		   {$chd = $chd . "," . $wval;}	

	        if (!isset($chl))
                   {$chl = $week;}
                else
                   {$chl = $chl . "|" . $week;}

		if ($wval > $dailypoint) {$wtotal = $wtotal + ($wval - $dailypoint);}
        }
?>
	        <div class="hr1">
                <hr />
        </div>
      <?php
	$fdate = date("l, F jS Y",strtotime($date));
        echo "<h2><p>Point Report for $fdate</p></h2>";
        //select database
	//create and execute query
        $query = "SELECT ID, Name, Points FROM Daily_Food where DATE_ENTERED = '$date' and USER = '$user' order by ID ;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
	echo "<table border=0><tr><td>";
	echo "<table border=\"1\">";
	echo "<tr>";
	echo "<td><b>Food Name</b></td>";
	echo "<td><b>Point Value</b></td>";
        //create selection list
        while($row = mysql_fetch_row($result))
        {
                $id = $row[0];
		$name = substr(stripslashes($row[1]),0,50);
		$points = $row[2];
		$totalpoints = $totalpoints + $points;
		echo "<tr>";
		echo "<td>$name</td>";
		echo "<td align=\"right\">$points</td>";
		echo "<td><form style=\"margin-bottom:0;\" name=\"deleter$id\" method=\"POST\" action=\"$_SERVER[PHP_SELF]\"><input type=\"hidden\" name=\"date\" value='$date'/><input type=\"hidden\" value=$id name=\"delid\"><input type=\"image\" src=\"images/delete.png\" value=\"Submit\" name=\"B1\"></form></td>";
		echo "</tr>";
        }
	echo "<tr>";
	echo "<td><b>Total Points Today</b></td>";
	echo "<td align=\"right\"><b>$totalpoints</b></td>";
	echo "<tr><td><b>Today's Points Remaining</b></td>";
	$remaining = $dailypoint - $totalpoints;
	echo "<td align=\"right\"><b>$remaining</b></td>";
	echo "<tr><td><b>Weekly Bonus Points Remaining</b></td>";
	$wremaining = 35 - $wtotal;
	echo "<td align=\"right\"><b>$wremaining</b></td>";	
	echo "</table></td>";
	if ($trowa[1] <> NULL) {
	echo "<td style=\"vertical-align: bottom; position: relative;\"><form name=\"twitter\" method=\"POST\" action=\"twitter.php\"><input type=hidden name=\"ptotal\" value=$dailypoint><input type=hidden name=\"pweight\" value=$gdiff><input type=hidden name=\"ptoday\" value=$totalpoints><input type=\"image\" src=\"images/twitter.png\" value=\"Submit\" name=\"Twiterer\"></form></td>";}
	$self = $_SERVER['PHP_SELF'];
	echo "</tr></table>";
	echo "<form name=\"reporter\" method=\"POST\" action=\"$self\">";
  	echo "<h2><p>Select a Different Date to Report On</p></h2>";
        echo "<h2>Date: <input type=\"text\" name=\"fdate\" default value='$date' onchange=\"this.form.submit()\" />";
        ?>
        <script language="JavaScript">
        new tcal ({
                // form name
                'formname': 'reporter',
                // input name
                'controlname': 'fdate'
        });
        </script></h2>
        <p><input type='submit' value='Submit' name='B1'></p>
        </form>
<?
	echo "<div class=\"hr1\"><hr /></div><br /><h1>Daily Point Breakdown</h1><img src=http://chart.apis.google.com/chart?cht=bvs&chs=600x250&chd=t:$chd&chl=$chl&chco=4d89f9&chbh=60&chxt=x,y&chm=N*f*,000000,0,-1,11&chds=0,65&chxr=1,0,65,5 />";

        $weightquery = "SELECT * FROM `Weight` WHERE user = '$user' order by Date asc limit 15";
        //echo $wquery;
        $weightresult = mysql_query($weightquery) or die ('Error in query: $weightquery. ' . mysql_error());
	$whigh = 0;
	$wlow = 999;
	$counter=0;
        while($weightrow = mysql_fetch_row($weightresult))
        {
                $weightday = date("M-j",strtotime($weightrow[2]));
               
		 $weightval = $weightrow[1];
		
                if (!isset($wchd))
                   {$wchd = $weightval;}
                else
                   {$wchd = $wchd . "," . $weightval;}

      		if ($weightval > $whigh) {$whigh = $weightval;} 
		if ($weightval < $wlow) {$wlow = $weightval;}
 
	        if (!isset($wchl))
                   {$wchl = $weightday;}
                else
                   {$wchl = $wchl . "|" . $weightday;}

       		if (!isset($wchm))
                   {$wchm = "t$weightval,000000,0,$counter,10,0";}
                else
                   {$wchm = $wchm . "|" . "t$weightval,000000,0,$counter,10,0" ;}
 		
		$counter++;
	}
	$lownum = roundnum(round($wlow),5) - 15;
	$highnum = roundnum(round($whigh),5) + 15;
	echo "<div class=\"hr1\"><hr /></div><br /><h1>Weight Tracking Graph</h1><img src=http://chart.apis.google.com/chart?cht=lc&chs=700x300&chd=t:$wchd&chl=$wchl&chxt=x,y&chds=$lownum,$highnum&chxr=1,$lownum,$highnum,10&chm=$wchm />";	
	mysql_close($connection);
       	?> 
<br><br>
<a href=../index.php>Go To Main Page</a>
</body>
</html>
