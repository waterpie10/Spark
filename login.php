<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spark</title>
    <style>
        .container {
          display: flex; /* Use flexbox */
        }
        
        .left-div {
          width: 65vw; /* Set width to 65% */
          background-color:#ffe7e9;
          text-align: center;
          /* Add other styling properties as needed */
        }
        
        .right-div {
          width: 35vw; /* Set width to 35% */
          height:100vw;
          background-color: #666666ff;
          text-align: center;
          /* Add other styling properties as needed */
        }

        @media screen and (max-width: 700px) {
          .right-div {
            width:100%;
            padding: 0;
            margin: 0;
          }
          .left-div {width: 100vw;}
          .container {display: block;}
        }
      </style>
</head>
<header>
<p style="font-weight: bold; font-size: 2em; display: inline;"><a style="text-decoration:none; color: black;" href="home.php">Spark </a></p>
	<p class="tagline">The shortest circuit to your dream laptop</p> 
    <img src="profile.png" alt="Profile image" width="30" height="30" style="display: inline; float: right; margin-right:1%; margin-top:0.8%;">
    <img src="checkout.png" alt="Checkout image" width="30" height="30" style="display: inline; float: right;margin-right:1%;margin-top:0.8%">
</header>
<body>
    <div class="container">
        <div class="left-div">
            <form action="loginprocess.php" onsubmit="validateLogin()" method="post" id="login-form">
            <p class="text" style="font-weight:bold;color:black;font-size:2em;">Login to your account</p><p></p>
            <input type="text" id="email-entry" name="email" placeholder="Email address" style="width:50vw;" ><p></p><br>
            <input type="password" id="password-entry" name="password" placeholder="Password"style="width:50vw; "><p></p>
            <div class = "error-box" style="display:none;">
                <p class = "error-text">Invalid email or password</p>
            </div>
            <br>
            <button class = "box4" type="submit" >Sign in</button>
            </form>
        </div>
        <div class="right-div">
            <p></p><p class="text" style="font-weight:bold; color:white; position:block;font-size: 2em">New here?</p><p></p><br>    
            <p class="text" style="color:white; position: block;">Sign up to find <br> your match today </p>  <br>
            <button class="box4" type="button" onclick="document.location='createaccount.html'" style="background-color:white;color:black;position:block;">Sign up</button><p></p> <br><br><br><br><br><br><br>   
        </div>
    </div>

<script>
    var email = document.getElementById("email-entry");
    var password = document.getElementById("password-entry");

    function validateLogin(event) {
      if (email.value == "" || password.value == "") {
        document.getElementsByClassName("error-box")[0].style.display = "block";
        return false;
      } else {
        document.getElementsByClassName("error-box")[0].style.display = "none";
        return true;
      }
    }

    document.querySelector("form").addEventListener("submit", function(event) {
      event.preventDefault();
      if (validateLogin()) {
        document.getElementById("login-form").submit();
      }
    });

    window.addEventListener("load", function() {
      document.getElementById("login-form").reset();
    });
</script>
</body>
</html>
