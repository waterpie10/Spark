<?php

session_start();

$login = ($_POST);
$email = $login["email"];
$password = $login["password"];
$first = $login["first"];
$last = $login["last"];
require_once('config.inc.php');

$mysqli = new mysqli($database_host, $database_user, $database_pass, $group_dbnames[1]);
if($mysqli -> connect_error) {
    die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
}

$hashedpw = password_hash($password,PASSWORD_DEFAULT);

// $mysqli -> query("SELECT password FROM tblUsers WHERE email='$email'");

if ($result = $mysqli -> query("SELECT * FROM tblUsers WHERE email='$email'")) {
    if ($result -> num_rows == 0) {
        $_SESSION["email"] = $email;
        $sql = "INSERT INTO tblUsers (firstName, lastName, password, email) VALUES ('$first','$last','$hashedpw','$email')";
        if ($mysqli->query($sql) === TRUE) {
            echo "added to database";
        } else {
            echo "error: " . $sql . "<br>" . $mysqli->error;
        }
        echo('login successful');
    } else {
        echo('user already exists with that email');
    }
    

}

header('location: home.php')

?>