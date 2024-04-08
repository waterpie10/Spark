<?php

session_start();

$login = ($_POST);
$email = $login["email"];
require_once('config.inc.php');

$mysqli = new mysqli($database_host, $database_user, $database_pass, $group_dbnames[1]);
if($mysqli -> connect_error) {
    die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
}

$hashedpw = $mysqli -> query("SELECT password FROM tblUsers WHERE email='$email'");

if (password_verify($login["password"],$hashedpw -> fetch_row()[0])) {
    $_SESSION["email"] = $email;
    echo('login successful');
} else {
    echo('incorrectpw');
}

?>