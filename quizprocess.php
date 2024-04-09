<?php
/*
1. Validation
2. Processing answers
3. Put into database


*/

session_start();
// $email = $_SESSION["email"];


$answers = ($_POST);
require_once('config.inc.php');
$mysqli = new mysqli($database_host, $database_user, $database_pass, "2023_comp10120_x10");
if($mysqli -> connect_error) {
    die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
}

if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $query = $mysqli -> query("SELECT userID FROM tblUsers WHERE email='$email'");
    
    
    $id = mysqli_fetch_column($query);

} else {
    die("no account");
}


foreach ($answers as $q => $a) {
    echo "$q: $a <br>";
}


$userID = 1;

if (is_numeric($answers["budget"])) {
    $budget = (int)floor($answers["budget"]);
} else {
    die('non numeric budget');
}


switch ($answers["use"]) {
    case "general":
        $processor = 2.0;
        break;
    case "business":
        $processor = 3.0;
        break;
    case "gaming":
        $processor = 5.0;
        break;
    case "creative":
        $processor = 4.0;
        break;
    case "programming":
        $processor = 3.0;
        break;
    case "educational":
        $processor = 2.0;
        break;
    default:
        $processor = 3.0;
        break;
}

switch ($answers["portability"]) {
    case "important3":
        $weight = 3.0;
        break;
    case "important2":
        $weight = 2.0;
        break;
    case "important1":
        $weight = 1.0;
        break;
    default:
        $weight = 2.0;
        break;
}


$batteryLife = 5.0;

$os = $answers["os"];

$screenSize = 1920.0;

$storage = 512.0;

$memory = 8.0;

$touchscreen = 1.0;



$sql = "DELETE FROM tblPreferences WHERE userID='$id'";

if ($mysqli->query($sql) === TRUE) {
    echo "deleted record";
} else {
    echo "error: " . $sql . "<br>" . $mysqli->error;
}

$sql = "INSERT INTO tblPreferences (userID, budget, processor, weight, batteryLife, operatingSystem, screenSize, storage, memory, touchscreen) VALUES ($id,{$budget},{$processor},{$weight},{$batteryLife},'$os',{$screenSize},{$storage},{$memory},{$touchscreen})";


if ($mysqli->query($sql) === TRUE) {
    echo "added to database";
} else {
    echo "error: " . $sql . "<br>" . $mysqli->error;
}

header('location: results.php')



?>