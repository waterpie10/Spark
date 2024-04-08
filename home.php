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
if (isset($_SESSION["email"])) {
	$email = $_SESSION['email'];
	echo("Hi $email! Not you? Log out.");
} else {
	echo("Not logged in!");
}
?>
</a>
<img src="computers.png" alt="Image of computers" class="center-image" style= "width: 50vw; height:auto;">
<img src="browse.png" style="position: absolute; top:70%;left:22%;">
<img src="quiz.png" style="position:absolute; top:70%; left:62%;" >
<a href="quiz.html"  style="position:absolute;top:73%;left:27%;">Browse our <br>selection</a>
<a href="quiz.html"  style="position:absolute;top:73%;left:67%;">Take our <br>matchmaking quiz!</a>
</body>
</html>
