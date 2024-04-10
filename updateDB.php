<?php
//Database connection details
//remember to change this to db instead of localhost when accessing from uni servers
// $database_host = "localhost";
// $database_user = "root";  // Your username
// $database_pass = "";  // Your password
// $database_name = "2023_comp10120_x10";  // Group database name
//$database_name/ $group_dbnames[0]
session_start();

$id = $_SESSION["id"];
require_once ("config.inc.php");

// Create connection
$connection = mysqli_connect($database_host, $database_user, $database_pass, "2023_comp10120_x10");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the laptop's ID and favorited status from the form data
$laptopID = $_POST["laptopID"];
$favourited = $_POST["favourited"] == "true" ? 1 : 0;  // Convert the favorited status to a boolean


// SQL query to read data from tblLaptop
$query = "INSERT INTO tblSwipe (userID, laptopID, favourited) VALUES (?, ?, ?)"; 
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "iii", $id, $laptopID, $favourited);
mysqli_stmt_execute($stmt);

mysqli_close($connection);
?>