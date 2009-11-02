<?php
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');

// open connection to MySQL server
$connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
or die ('Unable to connect!');
$user = $_SESSION['username'];
//select database
mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
//create and execute query
$query = "SELECT * FROM Withings;";
$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
while($row = mysql_fetch_row($result))
{
$user = $row[0];
$userid = $row[1];
$pubkey = $row[2];
$session = curl_init("http://wbsapi.withings.net/measure?action=getmeas&userid=$userid&publickey=$pubkey&meastype=1&limit=1");
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($session);
curl_close($session);
$xml = json_decode($response);

$status = $xml->status;

if ($status == 0) {
$update = date("Y-m-d",$xml->body->measuregrps[0]->date);
$wval = $xml->body->measuregrps[0]->measures[0]->value;
$wunit = $xml->body->measuregrps[0]->measures[0]->unit;
$weight = round(($wval*pow(10,$wunit))*2.20462262,2);

$wquery = "SELECT * FROM Weight where User = '$user' and Date = '$update';";
$wresult = mysql_query($wquery) or die ('Error in query: $wquery. ' . mysql_error());
if (mysql_num_rows($wresult) == 0){
        $querya = "SELECT * from Profile where USER = '$user';";
        $tquerya = "SELECT * from Twitter where USER = '$user';";
        $tresulta = mysql_query($querya) or die ('Error in query: $tquerya. ' . mysql_error());
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
$upprofile = "UPDATE Profile set Weight = '$trweight', TRWeight = '$weight', Weekly = '$weekly' where User = '$user';";
$upweight = "INSERT INTO Weight (`User`, `Weight`, `Date`) VALUES ('$user', '$weight', '$update');";
$rupprofile = mysql_query($upprofile) or die ('Error in query: $upprofile. ' . mysql_error());
$rupweight = mysql_query($upweight) or die ('Error in query: $upweight. ' . mysql_error());
echo "$user Updated Sucessfully";
}
else {echo "Nothing to update<br>";}
}
else {echo "An Error $status Occured";}
}
?>
