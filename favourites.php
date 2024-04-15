<?php
// Database connection details
// $database_host = "localhost";
//$database_user = "root";  // Your username
//$database_pass = "";  // Your password
// $database_name = "2023_comp10120_x10";  // Group database name
session_start();
require_once ("config.inc.php");

// Create connection
$connection = mysqli_connect($database_host, $database_user, $database_pass, "2023_comp10120_x10");

// Check connection
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $query = $connection -> query("SELECT userID FROM tblUsers WHERE email='$email'");
    
    
    $desiredUserID = mysqli_fetch_column($query);
    $_SESSION["id"] = $desiredUserID;

} else {
    header('location: login.php');
}


// SQL query to read data from tblLaptop
$query = "SELECT laptopID FROM tblSwipe WHERE userID = '$desiredUserID' AND favourited = 1";  // Adjust the query to fetch the data you need
$result = mysqli_query($connection, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
	$laptopID = $row["laptopID"];
	$query2 = "SELECT * FROM tblLaptop WHERE laptopID = '$laptopID'";  // Adjust the query to fetch the data you need
	$result2 = mysqli_query($connection, $query2);
	$laptopData = mysqli_fetch_assoc($result2);
	
	if ($laptopData["image"] != null) {
		$laptopData["image"] = base64_encode($laptopData["image"]);
	}
	
	$data[] = $laptopData;
}

// Close the connection
mysqli_close($connection);

$jsonData = json_encode($data);
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Spark</title>
</head>
<header>
	<p style="font-weight: bold; font-size: 2em; display: inline;"><a style="text-decoration:none; color: black;" href="home.php">Spark </a></p>
	<p class="tagline">The shortest circuit to your dream laptop</p> 
	<img src="profile.png" alt="Profile image" width="30" height="30" style="display: inline; float: right; margin-right:1%; margin-top:0.8%;">
	<img src="checkout.png" alt="Checkout image" width="30" height="30" style="display: inline; float: right;margin-right:1%;margin-top:0.8%">
</header>
<body>

<?php
$jsonData = json_encode($data);
?>

<script>
	var data = <?php echo $jsonData; ?>;
	console.log(data);

	function createCard(record, index){
		var card = document.createElement("div");
		card.className = "card";
		card.style.width = "18rem";
		card.style.display = "inline-block";
		card.style.margin = "1%";
		card.style.marginTop = "2%";
		card.style.marginBottom = "2%";
		card.style.border = "1px solid black";
		card.style.borderRadius = "10px";
		card.style.padding = "1%";
		card.style.backgroundColor = "white";
		card.style.boxShadow = "5px 5px 5px grey";

		var image = document.createElement("img");
		image.className = "card-img-top";
		image.src = "data:image/jpeg;base64," + record[index]["image"];
		image.alt = "Laptop image";
		image.style.width = "100%";
		image.style.height = "200px";
		image.style.borderRadius = "10px";

		var cardBody = document.createElement("div");
		cardBody.className = "card-body";

		var title = document.createElement("h5");
		title.className = "card-title";
		title.innerHTML = record[index]["Model"];

		var price = document.createElement("p");
		price.className = "card-text";
		price.innerHTML = "Price: £" + record[index]["price"];

		var processor = document.createElement("p");
		processor.className = "card-text";
		processor.innerHTML = "Processor: " + record[index]["processor"];

		var ram = document.createElement("p");
		ram.className = "card-text";
		ram.innerHTML = "RAM: " + record[index]["RAM"] + "GB";

		var storage = document.createElement("p");
		storage.className = "card-text";
		storage.innerHTML = "Storage: " + record[index]["storage"] + "GB";
		

		var touchscreen = "";
		if (record[index]["touchScreen"] == 1 ){
			touchscreen = "touchscreen";
		}

		var display = document.createElement("p");
		display.className = "card-text";
		display.innerHTML = "Display: " + record[index]["screenSize"] + " inches " + touchscreen+ "  with " + record[index]["resolution"] + " resolution";

		var graphics = document.createElement("p");
		graphics.className = "card-text";
		graphics.innerHTML = "Graphics: " + record[index]["graphicsCard"];

		var os = document.createElement("p");
		os.className = "card-text";
		os.innerHTML = "OS: " + record[index]["OS"];

		var cardFooter = document.createElement("div");
		cardFooter.className = "card-footer";

		var button = document.createElement("button");
		button.className = "btn btn-primary";
		button.innerHTML = "Remove from Favourites";

		// Append elements to the card
		cardBody.appendChild(title);
		cardBody.appendChild(price);
		cardBody.appendChild(processor);
		cardBody.appendChild(ram);
		cardBody.appendChild(storage);
		cardBody.appendChild(display);
		cardBody.appendChild(graphics);
		cardBody.appendChild(os);
		cardFooter.appendChild(button);
		card.appendChild(image);
		card.appendChild(cardBody);
		card.appendChild(cardFooter);

		// Append card to the DOM
		document.body.appendChild(card);
	

	button.addEventListener("click", function(){
		// Send a POST request to updateRecord.php
		var laptopID = record[index]["laptopID"];
		var favourited = false;
		var formData = new FormData();
		formData.append("laptopID", laptopID);
		formData.append("favourited", favourited);

		var request = new XMLHttpRequest();
		request.open("POST", "updateRecord.php", true);
		request.send(formData);

		request.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
			}
		};

		// Remove the card from the DOM
		card.remove();
	})

	};

	var i = 0;
	data.forEach(function(record){
		createCard(data, i);
		i++;
	});
</script>
</body>
</html>
