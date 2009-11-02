<?
// Start session
session_start();

// Include required functions file
require_once('includes/functions.inc.php');
// Check login status... if not logged in, redirect to login screen
if (check_login_status() == false) {
        redirect('login.php');
}

?>
<script>
<!--

function calculate() {

	var doc = document.pointCalc;
	var points = 0;
	var fiber = doc.fiber.value;
	var fat = doc.fat.value;
	var calories = doc.calories.value;

	points = (calories / 50) + (fat / 12) - (fiber / 5);
	
	doc.result.value = Math.round(points);


}

// -->

</script>
<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">
	<h2>Calculate Points of Food Without Adding to Tracker</h2>
<form name="pointCalc">
<table><tr>
<tr><td>Calories:</td><td><input type="text" name="calories"></td></tr>
<tr><td>Fat:</td><td><input type="text" name="fat"></td></tr>

<tr>
<td>Fiber:</td>
<td>
	<select name="fiber">
	<option value="0">0</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>

	<option value="4">4 or more</option>
	</select>
</td>
</tr>

<tr><td align = 'right' colspan="2"><input type="button" value="Calculate" onClick="calculate();"></td></tr>

<tr><td><b>Points:&nbsp;&nbsp;</td><td><input type="text" name="result"></td></b></tr>
</table>
</form>

</div>
</td></tr></table>
</div>

</body>
</html>


