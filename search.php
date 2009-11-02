<?php
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

<?php require_once('menu.php');

?>
<h1>Nutrition Information Search</h1>
<form name="search" method="POST" action="#">
Food Name <input type='text' name="searchterm"><input type='submit' value='Search' name='B1'></form>
<?php

$squery = $_POST['searchterm'];
if ($squery <> NULL) {
require_once('includes/restapi.php');
$search = urlencode($squery);
echo "<h2>Search Results for $squery </h2>";

$request ='http://foodsearch1.webservices.calorieking.com/rest/search/' . $search;
$response= restCall($request, "GET");
$xml = simplexml_load_string($response);

$c = 0;
$category = "category";
while ($category <> NULL) {
$f = 0;
$fid = "foodid";
$category = $xml->category[$c]->name;
if ($category <> NULL)
echo "<h2>Category: $category</h2>";
echo "<ul>";
        while ($fid <> NULL) {
                $fid = $xml->category[$c]->foods->food[$f]->id;
                $foodname = $xml->category[$c]->foods->food[$f]->display;
                if ($fid <> NULL){
                        echo "<li><form name\"$fid\" method=\"POST\" action=#><input type=\"hidden\" name=\"foodquery\" value=\"$fid\"><input type=\"submit\" value=\"$foodname\" style=\"Border: none; background: none; color: blue\"></form></li>";}
                $f++;
        }
echo "</ul>";
$c++;
}}
?>

<?php
$fquery = $_POST['foodquery'];
require_once('includes/restapi.php');
require_once('includes/functions.inc.php');
require_once('includes/config.inc.php');

if ($fquery <> NULL) {

$nlookup ='http://foodsearch1.webservices.calorieking.com/rest/foods/'. $fquery;
$ninfo = restCall($nlookup, "GET");

$servingname = "ServingName";
$ninfoxml = simplexml_load_string($ninfo);
$name = $ninfoxml->name;

echo "<h2>Name: $name</h2>";

        $servingname = $ninfoxml->servings->serving[0]->name;
        $calories = round($ninfoxml->servings->serving[0]->nutrients[0]->calories);
        $fat = round($ninfoxml->servings->serving[0]->nutrients[0]->fat);
        $fiber = round($ninfoxml->servings->serving[0]->nutrients[0]->fiber);
	$namee = explode(":",$name);
	$type = $namee[1];
	$fullname = $namee[0] . $namee[2];
	$servings = 1;
	$points = round((($calories*$servings)/50) + (($fat*$servings)/12) - (min(($fiber*$servings),4)/5));

        if ($servingname <> NULL){
        echo "<h2>Serving Size: $servingname</h2>";
	echo "<h2><b>Point Value: $points</b></h2>";
	echo "<hr>";
	echo "<table>";
        echo "<form name=\"$servingname\" method=\"POST\" action=\"foodsubmit.php\">";
        echo "<tr><td>Food Name</td><td><input type=\"text\" name=\"food\" size=\"50\" default value=\"$fullname\"></td></tr>";
        echo "<tr><td>Calories</td><td><input type=\"text\" READONLY name=\"calories\" size=\"5\" default value='$calories'></td></tr>";
        echo "<tr><td>Fat</td><td><input type=\"text\" READONLY name=\"fat\" size=\"3\" default value='$fat'></td></tr>";
        echo "<tr><td>Fiber</td><td><input type=\"text\" READONLY name=\"fiber\" size=\"2\" default value='$fiber'></td></tr>";
        echo "<tr><td>Servings</td><td><select name=\"servings\"><option value=.25>1/4</option><option value=.5>1/2</option><option selected value=1>1</option><option value = 2>2</option><option value = 3>3</option></select></td></tr>";
        echo "<tr><td>Type</td><td>";

        $connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
        or die ('Unable to connect!');
        $user = $_SESSION['username'];
        //select database
	mysql_select_db(DB_DATABASE) or die ('Unable to select database!');
        $query = "SELECT Name from Snack_Types order by Name;";
        $result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());

        //create selection list
        echo "<select name=type>";
        while($row = mysql_fetch_row($result))
        {
                $name = $row[0];

                echo "<option value='$name'>$name\n</option>";
        }
        echo "<option selected value='$type'>$type</option>";
        echo "</select>&nbsp;&nbsp;</tr>";
	$today = date("Y-m-d");
        echo "<tr><td><p>Date: </td><td><input type=\"text\" name=\"date\" size=11 default value='$today' /></td></tr>";
        echo "<tr><td>Save Item to List?&nbsp;</td><td><input type=\"radio\" name=\"save\" value=\"Yes\" checked>Yes  <input type=\"radio\" name=\"save\" value=\"No\"> No</td></tr>";
        echo "<tr><td><input type=\"submit\" value=\"Submit\"></td></tr>";
	echo "</form>";
	echo "</tr></table>";
}}
?><br/><br/><br/>
<img src='<?php echo CALORIEURL; ?>'></td></tr></table>
