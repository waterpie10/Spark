<?php
// Database connection details
// $database_host = "db";
// $database_user = "root";  // Your username
// $database_pass = "";  // Your password
// $database_name = "2023_comp10120_x10";  // Group database name

require_once ("config.inc.php");

// Create connection
$connection = mysqli_connect($database_host, $database_user, $database_pass, "2023_comp10120_x10");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to read data from tblLaptop
$query = "SELECT * FROM tblLaptop";  // Adjust the query to fetch the data you need
$result = mysqli_query($connection, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    if ($row["image"] != null) {
        $row["image"] = base64_encode($row["image"]);
    }
    $data[] = $row;
}

$jsonData = json_encode($data);

// Close the connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style> 
       
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .card {
            position: absolute;
            width: 393.75px;
            height: 700px;
            /* width: 50vw;
            height: auto; */
            background-color: #fff;
            border: 1px solid #000;
            position: absolute;
            cursor: move; /* Change the cursor to a move icon when over the draggable element */
            user-select: none;
            transition: transform 0.5s;
        }


        .card img {
            width: 100%;
            height: auto;

        }

        .card.moved {
            transform: translateX(100%);
        }

        #card1 {
            z-index: 1000;
        }

        #card2 {
            z-index: 999;
        }

        #card3 {
            z-index: 998;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }


        .border-line {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 1px; /* Line width */
            background-color: #f00; /* Line color */
        }

        #left-border {
            left: 25%;
        }

        #right-border {
            left: 75%;
        }       

        @media only screen and (max-width: 600px) {
            .card {
                width: 200px;
                height: 355.56px;
            }
            
            #left-border {
                left: 3%; /* Adjusted position for smaller screens */
            }

            #right-border {
                left: 97%; /* Adjusted position for smaller screens */
            }

        }



        
    </style>
</head>
<body>
    <div class="border-line" id="left-border"></div>
    <div class="border-line" id="right-border"></div>
    

    <script>

        var jsonData = <?php echo $jsonData; ?>;
        var j = 0;
        var k = 0;

        function fanOutCards() {
            var cards = document.getElementsByClassName("card");
            var viewportWidth = window.innerWidth;
            var cardWidth = cards[0].offsetWidth;
            var initialLeft = (viewportWidth - cardWidth) / 2; // Center of the viewport

            for (var i = 0; i < cards.length; i++) {
                cards[i].style.position = "absolute";
                cards[i].style.left = (initialLeft + i * 20) + 'px'; // Adjust the left position based on index
                cards[i].style.transition = 'transform 0.5s'; // Add a transition to the transform property
                if (window.innerWidth <= 600) {
                    cards[i].style.transform = 'rotate(' + i * 2.5 + 'deg)'; // Rotate and scale the card based on index
                } else {
                    cards[i].style.transform = 'rotate(' + i * 5 + 'deg)'; // Rotate and scale the card based on index
                }
            }
        }

        function createCard(record, zIndex){

            var newCard = document.createElement("div");
            newCard.className = "card";
            newCard.style.zIndex = zIndex;

            newCard.style.animation = "fadeIn 0.5s";

            var cards = document.getElementsByClassName("card");
            newCard.style.transform = "rotate(" + cards.length * 5 + "deg)";

            newCard.dataset.id = record[j]["laptopID"];

            var img = document.createElement("img");
            img.src = "data:image/jpeg;base64," + record[j]["image"] ;
            
            newCard.appendChild(img);

            var model = document.createElement("p");
            model.textContent = "Model: " + record[j]["Model"];

            if (window.innerWidth <= 600) {
                model.style.fontSize = "14px";
            } else {
                model.style.fontSize = "35px";
            }
            model.style.fontWeight = "bold";
            model.style.textAlign = "center";
            newCard.appendChild(model);

            var price = document.createElement("p");
            price.textContent = "Price: $" + record[j]["price"];
    
            if (window.innerWidth <= 600) {
                model.style.fontSize = "14px";
            } else {
                model.style.fontSize = "35px";
            }
            price.style.fontWeight = "bold";
            price.style.textAlign = "center";
            newCard.appendChild(price);

            document.body.appendChild(newCard);
            dragElement(newCard);

            j++;
        }

        for (var i = 0; i < 3; i++) {
            createCard(jsonData, 999 - i);
        }

        function dragElement(elmnt) {
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            elmnt.onmousedown = dragMouseDown;
            elmnt.ontouchstart = dragMouseDown;

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX || e.touches[0].clientX;
                pos4 = e.clientY || e.touches[0].clientY;
                document.onmouseup = closeDragElement;
                document.ontouchend = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
                document.ontouchmove = elementDrag;

                // Remove the transition property during the drag operation 
                elmnt.style.transition = "";

            }

            function elementDrag(e) {
                e = e || window.event;
                // calculate the new cursor position:
                pos1 = pos3 - (e.clientX || e.touches[0].clientX);
                pos2 = pos4 - (e.clientY || e.touches[0].clientY);
                pos3 = e.clientX || e.touches[0].clientX;
                pos4 = e.clientY || e.touches[0].clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }



            function closeDragElement() {
                /* stop moving when mouse button is released:*/
                document.onmouseup = null;
                document.onmousemove = null;
                document.ontouchend = null;
                document.ontouchmove = null;   

                // Calculate the center position
                var centerX = (window.innerWidth / 2) - (elmnt.offsetWidth / 2);
                var centerY = (window.innerHeight / 2) - (elmnt.offsetHeight / 2);


                // Calculate the left and right quarter of the screen
                var leftQuarter, rightQuarter;
                if (window.innerWidth <= 600) {  
                    leftQuarter = window.innerWidth * 0.03;  
                    rightQuarter = window.innerWidth * 0.97;  
                } else {
                    leftQuarter = window.innerWidth / 4;  
                    rightQuarter = 3 * window.innerWidth / 4;  
                }

                var favourited = null;
                if (elmnt.offsetLeft < leftQuarter) {
                    favourited = false;
                }
                else if (elmnt.offsetLeft + elmnt.offsetWidth > rightQuarter) {
                    favourited = true;
                }

                if (favourited !== null) {
                    var laptopID = elmnt.dataset.id;
                    var formData = new FormData();
                    formData.append('laptopID', laptopID);
                    formData.append('favourited', favourited);

                    var request = new XMLHttpRequest();
                    request.open('POST', 'updateDB.php');
                    request.send(formData);

                    request.onload = function() {
                        if (request.status === 200) {
                            console.log(request.responseText);
                        }
                    }
                }

                // Check if the card is in the left or right quarter of the screen
                if (elmnt.offsetLeft < leftQuarter || elmnt.offsetLeft + elmnt.offsetWidth > rightQuarter) {
                    // If the card is in the left or right quarter, animate it to move off screen
                    elmnt.style.transition = "left 0.2s";
                    elmnt.style.left = (elmnt.offsetLeft < leftQuarter ? -elmnt.offsetWidth : window.innerWidth) + "px";

                    elmnt.classList.add("moved");

                    // Listen for the transitionend event
                    elmnt.addEventListener('transitionend', function() {
                        // Remove the card from the DOM
                        elmnt.remove();

                        // Create a new card
                        if (j < jsonData.length) {
                            createCard(jsonData, 999 - j);
                            fanOutCards();
                        }
                    });
                } else {
                    // If the card is in the middle quarter, animate it back to the center
                    elmnt.style.transition = "top 0.5s, left 0.5s";
                    elmnt.style.top = centerY + "px";
                    elmnt.style.left = centerX + "px";
                }


            }
        }

    </script>
</body>
</html>