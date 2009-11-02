<html>
<head>
        <title><?php if (isset($_SESSION['logged_in'])) {echo $_SESSION['first']."'s ";}?>Point Tracker</title>

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
        <h1><p><?php if (isset($_SESSION['logged_in'])) {echo $_SESSION['first']."'s ";}?>Point Tracker</p></h1>
</div>
<div id="main-menu">
        <ul>
                <li><a href="index.php">Enter Food</a></li>
                <li class="first"><a href="calculator.php">Calculator</a></li>
                <li class="first"><a href="report.php">My Point Log</a></li>
                <li class="first"><a href="profile.php">My Profile</a></li>
		<li class="first"><a href="search.php">Nutrition Information Lookup</a></li>
                <li class="right"><a href="todo.php">Upcoming Features</a></li>
                <?php if (isset($_SESSION['logged_in'])) {echo "<li class=\"right\"><a href=\"logout.php\">Logout</a></li>";}?>
                <?php if (!isset($_SESSION['logged_in'])) {echo "<li class=\"right\"><a href=\"login.php\">Log In</a></li>";}?>
        </ul>
</div>
<?php require_once('sidebar.php');?>
