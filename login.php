<?php
?>
<?php require_once('menu.php');?>
<div id="page">
        <div id="page-bg">
<body>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
  <title>Point Tracker Login</title>
  <link rel="stylesheet" type="text/css" href="css/login.css" />
</head>
<?php if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {redirect('includes/login.inc.php');}?>
<?php if ($_REQUEST[message] == 1) {echo "<h1>There Was is Problem With your Password</h1>";}?>
<?php if ($_REQUEST[message] == 2) {echo "<h1>User Created Successfully, Login now.</h1>";}?>
  <form id="login-form" method="post" action="includes/login.inc.php">
    <fieldset>
      <legend>Login to Web Site</legend>
      <p>Please enter your username and password</p>
        <h2>Username: <input type="text" name="username" id="username" /></h2>
        <h2>Password: <input type="password" name="password" id="password" /></h2>
	<h2>Remember Me <input type="checkbox" name="remember" id="remember" checked/></h2>
	      <label for="submit">
        <input type="submit" name="submit" id="submit" value="Login" />
      </label>
    </fieldset>
  </form>
<h2><a href=newuser.php>Register Here</a> if you do not have an account</h2>
</body></div></div>
</html>
