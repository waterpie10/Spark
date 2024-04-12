<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Spark</title>
</head>
<header>
    <p style="font-weight: bold; font-size: 2em; display: inline;">Spark </p>
	<p class="tagline">The shortest circuit to your dream laptop</p> 
    <img src="profile.png" alt="Profile image" width="30" height="30" style="display: inline; float: right; margin-right:1%; margin-top:0.8%;">
    <img src="checkout.png" alt="Checkout image" width="30" height="30" style="display: inline; float: right;margin-right:1%;margin-top:0.8%">
</header>
<body>
<a href="login.php" style="text-align:center; font-size: 2em;">
<?php
session_start();
require_once ("config.inc.php");
$connection = mysqli_connect($database_host, $database_user, $database_pass, "2023_comp10120_x10");

if (isset($_SESSION["email"])) {
	$email = $_SESSION['email'];
	echo("Hi $email! Not you? Log out.");

    $query = $connection -> query("SELECT userID FROM tblUsers WHERE email='$email'");

    $id = mysqli_fetch_column($query);
    // $_SESSION["id"] = $id;

	$query = "SELECT * FROM tblPreferences WHERE userID=$id";
	$result = mysqli_query($connection, $query);
	$prefpresence = mysqli_fetch_assoc($result);
	$pref = $prefpresence == null ? 0 : 1;

} else {
	echo("Not logged in!");
	$pref = 0;
}
?>
</a>
<img src="computers.png" alt="Image of computers" class="center-image" style= "width: 50vw; height:auto;">

<!--
<img src="browse.png" style="position: absolute; top:70%;left:22%;">
<img src="quiz.png" style="position:absolute; top:70%; left:62%;" >
-->

<a class="box4" href="login.php" <?php if (isset($_SESSION["email"])) { echo "style=\"display:none;\"";}?>>Log in now!</a>
<a class="box4" href="createaccount.html" <?php if (isset($_SESSION["email"])) { echo "style=\"display:none;\"";}?>>Create an account!</a>
<a class="box4" href="quiz.html" <?php if (!isset($_SESSION["email"])) { echo "style=\"display:none;\"";}?>>Take our matchmaking quiz!</a>
<a class="box4" href="results.php" <?php if (!$pref) { echo "style=\"display:none;\"";}?>>Swipe laptops!</a>
</body>
</html>
