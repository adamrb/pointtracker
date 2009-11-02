<?
// Start session
//session_start();

// Include required functions file
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');
?>
<table width="98%">
<tr><td width=175px id="sidebar" style="border-right: 1px solid; padding: 10px; vertical-align: top; position: relative;" >

      <?php
        // open connection to MySQL server
        $sconnection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');

        mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $suser = $_SESSION['username'];
	if ($suser <> NULL) {	
        $weekquery = "SELECT Weekly, TRWeight from Profile where USER = '$suser';";
        $goalquery = "SELECT Goal from Profile where USER = '$suser';";
        $weekresult = mysql_query($weekquery) or die ('Error in query: $weekquery. ' . mysql_error());
        $goalresult = mysql_query($goalquery) or die ('Error in query: $goalquery. ' . mysql_error());
        $pointarr = mysql_fetch_row($weekresult);
        $goal = mysql_fetch_row($goalresult);
        $sdailypoint = $pointarr[0];    
        $weight = $pointarr[1];
        $wgoal = $goal[0];
        $gdiff = $weight - $wgoal;

	$sdate = date("Y-m-d");

	//Calculate Weekly Points
	$ssunday = date("Y-m-d",strtotime("last Sunday",strtotime($sdate)));
	$ssaturday = date("Y-m-d",strtotime("next Saturday",strtotime($sdate)));
	$swquery = "SELECT DATE_ENTERED, sum(POINTS) FROM Daily_Food where DATE_ENTERED >= '$ssunday' and DATE_ENTERED <= '$ssaturday' and USER = '$suser' group by DATE_ENTERED order by DATE_ENTERED;";
	//echo $swquery;	
	$swresult = mysql_query($swquery) or die ('Error in query: $squery. ' . mysql_error());
        while($srow = mysql_fetch_row($swresult))
        {
                $swday = $srow[0];
		$sweek = $sweekday = date('l', strtotime($swday));
                $swval = $srow[1];
		if (!isset($schd))
		   {$schd = $swval;}
		else
		   {$schd = $schd . "," . $swval;}	

	        if (!isset($schl))
                   {$schl = $sweek;}
                else
                   {$schl = $schl . "|" . $sweek;}

		if ($swval > $sdailypoint) {$swtotal = $swtotal + ($swval - $sdailypoint);}
        }

	$stoday = date("Y-m-d");

        //select database
	//create and execute query
        $squery = "SELECT ID, Name, Points FROM Daily_Food where DATE_ENTERED = '$sdate' and USER = '$suser' order by ID ;";
        $sresult = mysql_query($squery) or die ('Error in query: $squery. ' . mysql_error());

	echo "<table border=\"0\" cellspacing=\"3\">";
        while($srow = mysql_fetch_row($sresult))
        {
                $sid = $srow[0];
		$sname = stripslashes($srow[1]);
		$spoints = $srow[2];
		$stotalpoints = $stotalpoints + $spoints;
        }
	echo "<tr>";
	echo "<td>Points Today:</td>";
	echo "<td align=\"right\"><b>$stotalpoints</b></td>";
	echo "<tr><td>Points Remaining:</td>";
	$sremaining = $sdailypoint - $stotalpoints;
	echo "<td align=\"right\"><b>$sremaining</b></td>";
	echo "<tr><td>Weekly Points:</td>";
	$swremaining = 35 - $swtotal;
	echo "<td align=\"right\"><b>$swremaining</b></td>";	
	if ($wgoal == 0)
                {echo "<tr/><tr><td><a href=profile.php>Set a Weight Goal</a></td></tr>";}
        else
                {
	echo "<tr><td>Lbs from Goal:</td>";
	echo "<td align=\"right\"><b>".$gdiff."lbs</b></td></tr>";}
	echo "</table><br />";
	mysql_close($sconnection);
	echo "<hr>";
	echo "<br />";
	echo "<form name=\"search\" method=\"POST\" action=\"search.php\">";
	echo "<input type='text' name=\"searchterm\"><input type='submit' value='Nutrition Info Search' name='B1'></form>";
	//echo "</td><td style=\"padding-left: 15px;\">";
	}
	echo "</td><td style=\"padding-left: 15px;\">";
       	?> 
