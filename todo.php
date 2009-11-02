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
<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">

<h1>Functionality Improvements</h1>
<h2>[x] Complete Profile Page with points goal</h2>
<h2>[x] Daily Points Goal on Report Page</h2>
<h2>[x] Add/Remove Points (+ or - 3) from Goal</h2>
<h2>[x] Weekly Point allowance</h2>
<h2>[x] Weekly report bar graph</h2>
<h2>[x] Remove Daily Entered Items</h2>
<h2>[x] Delete Saved Items</h2>
<h2>[x] Calulate Points without entering item</h2>
<h2>[x] Filter Automatically when selected</h2>
<h2>[x] Logout Options</h2>
<h2>[x] Change Password Option</h2>
<h2>[x] New User Registration</h2>
<h2>[x] Serving Sizes</h2>
<h2>[ ] Validate Input as Numbers</h2>
<h2>[x] Weekly Weigh in With Graph</h2>
<h2>[ ] Activity Points</h2>
<h2>[ ] Email Reminders</h2>
<h2>[x] Weight Goals</h2>
<h2>[ ] Water, Fruit, and Veggie Tracker</h2>
<h2>[x] Enable Cookies (Remember Me Checkbox)</h2>
<h1>Future Improvements</h1>
<h2>[ ] iPhone/iTouch Compatible Version</h2>
<h2>[x] Integration with <a href=http://www.calorieking.com>CalorieKing</a> to allow for food searching from within application.
<h2>[x] Integration with <a href=http://www.withings.com/>Withing Wifi Body Scale</a>.
</div></div>
