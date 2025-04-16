<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transporter des colis </title>
    <link rel="stylesheet" href="index.css">
    <script defer src="script.js"></script>
    <style>
        

        .body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(94, 20, 20);
        }

        /* Navbar */

        

       

        /* Main Section */
        .main-section {
            display: flex;
            justify-content: space-between;
            padding: 80px;
            background-color:rgb(250, 255, 234);
            margin-top: 40px;
            margin-bottom: 0px;
        }

        .main-section .form-container {
            flex: 2;
            margin-right: 20px;
        }

        .main-section .form-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #007bff;
            
        }

        .main-section .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .main-section .form-container form input,
        .main-section .form-container form select {
            padding: 10px;
            border: 20px  #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .main-section .form-container form button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .main-section .form-container form button:hover {
            background-color: #0056b3;
        }

        .main-section .map-container {
            flex: 4;
            z-index: 0;
            border-radius: 40px;    
            overflow:hidden;
            height: 800px;
            margin-left: 50px;
          

        
        }

        .main-section .map-container iframe {
            width: 100%;
            height: 100%;
    
            
        }

        /* List Section */
        .list-section {
            padding: 40px;
            background-color: #f8f9fa;
        }

        .list-section .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .list-section .list-item img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }

        .list-section .list-item .details {
            flex: 1;
            margin-left: 20px;
        }

        .list-section .list-item .details h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .list-section .list-item .details p {
            margin: 5px 0;
            color: #666;
        }

        .list-section .list-item .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        /* Add a loading spinner */
    .loading-spinner {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 20px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .map-container {
        position: relative;
        width: 100%;
        height: 500px;
    }

    .map-container.loading .loading-spinner {
        display: block;
    }

    .map-container.loading iframe {
        opacity: 0.5;
    }

    .form-container img{
    max-width: 1000px;
    z-index: 1;
    height: 170px;
    width: 170px;
    margin-right: 0px;
    margin-left: 310px;
    margin-top: -50px;
}

.additional-section {
    padding: 40px;
    background-color: #f8f9fa;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 0px 9px 19px rgba(0, 0, 0, 0.1);
    height: 700px; /* Set a fixed height */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: hidden; /* Disable horizontal scrolling */
    margin-top: -30px;
}

.additional-section .package-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.package-container {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.package-container .photo {
    width: 100%;
    height: 150px;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #d9d9d9;
    margin-bottom: 15px;
}

.package-container .photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.package-container .details h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
    color: #000;
}

.package-container .details .routes {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 10px 0;
}

.package-container .details .routes .circle {
    width: 16px;
    height: 16px;
    border: 2px solid #4a00ff;
    border-radius: 50%;
    background-color: transparent;
}

.package-container .details .routes .line {
    flex-grow: 1;
    height: 2px;
    background-color: #ccc;
}

.package-container .details .price {
    font-size: 18px;
    font-weight: bold;
    color: #4a00ff;
    margin: 10px 0;
}

.package-container .button {
    background-color: #4a00ff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
}

.package-container .button:hover {
    background-color: #3a00cc;
}
        .container {
            background-color: white;
            width: 600px;
            padding: 20px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            
           
        }

        .photo {
            width: 240px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #d9d9d9;
            
        }

        .photo img {
            width: 120%;
            height: 120%;
            object-fit: cover;
            margin-right:310px;
            margin-top:1px;
        }

        .details {
            flex: 1;
            margin-left: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .details h3 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #000;
            margin-right:300px;
        }

        .details .price {
            font-size: 18px;
            font-weight: bold;
            color: #4a00ff;
            text-align: left; /* Aligns the text to the left */
            position: relative; /* Allows positioning with top and left */
            top: -9px; /* Moves the price lower */
            left: 50px; /* Moves the price more to the left */
        }

        .details .routes {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .details .routes label {
            display: flex;
            align-items: center;
            font-size: 19px;
            color: #666;
            margin-bottom: 0;
        }

        .details .routes input[type="radio"] {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid #4a00ff;
            border-radius: 50%;
            outline: none;
            margin-right: 8px;
            cursor: pointer;
            position: relative;
        }

        .details .routes input[type="radio"]:checked {
            background-color: #4a00ff;
        }

        .details .routes .line {
            flex-grow: 1;
            height: 2px;
            background-color: #ccc;
            margin: 0 10px;
        }

        .button {
            background-color: #4a00ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            align-self: flex-end;
            margin-right:50px;
        }

        .button:hover {
            background-color: #3a00cc;
        }
    </style>
    <!-- Include Leaflet.js CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    </head>
<body>

    <nav class="navbar">
        <div class="logo">
            <a href="index2.php">
              <img src="logo2.png" width="200px" height="50px" alt="Logo">
            </a>
        </div>
        
        <ul class="nav-links">
            <li class="dropdown">
                <a href="#">Solution Business ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="#">E-commerce</a></li>
                    <li><a href="#">Marketplace</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Transporteur ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="Proposer un trajet.php">Proposer un trajet</a></li>
                    <li><a href="recherche trajet.php">Voir annonce</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Particulier ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="Expédier ou recevoir un colis.php">Expédier ou recevoir un colis</a></li>
                    <li><a href="devis démenagement.html">Devis déménagement</a></li>
                </ul>
            </li>
            <li><a href="#">Nos Engagements</a></li>
        </ul>

              <div class="nav-buttons">
            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Display profile picture and user name -->
                <div class="profile">
                    <a href="profil.php">
                        <img src="profile.png" alt="Profile Picture" class="profile-pic">
                    </a>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <!-- Message Icon -->
                <a href="messages.php" class="btn message-icon">
                    <img src="test.png" alt="Messages" style="width: 24px; height: 24px;">
                </a>
                <a href="logout.php" class="btn login">Se Déconnecter</a>
            <?php else: ?>
                <a href="recherche trajet.php" class="btn">Voir les annonces</a>
                <a href="login.html" class="btn login">Se Connecter</a>
            <?php endif; ?>
        </div>
    </nav>


<script>document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");
    const navbar = document.querySelector(".navbar");

    // Menu Burger Animation
    menuToggle.addEventListener("click", function () {
        navLinks.classList.toggle("active");
        menuToggle.classList.toggle("active");
    });

    // Changement de couleur en scroll
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
});</script>

<script>
    function searchRoute() {
        const departureCity = document.getElementById('departure-city').value.trim();
        const arrivalCity = document.getElementById('arrival-city').value.trim();

        if (!departureCity || !arrivalCity) {
            alert('Please enter both departure and arrival cities.');
            return;
        }

        // Geocode the departure and arrival cities
        Promise.all([
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(departureCity)}`)
                .then(response => response.json()),
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(arrivalCity)}`)
                .then(response => response.json())
        ])
        .then(([departureData, arrivalData]) => {
            if (departureData.length === 0 || arrivalData.length === 0) {
                alert('Could not find one or both locations.');
                return;
            }

            const departureCoords = [departureData[0].lat, departureData[0].lon];
            const arrivalCoords = [arrivalData[0].lat, arrivalData[0].lon];

            // Fetch the route from OpenRouteService
            fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248574132d2e0874d0c96af7d6a6fe8c38b&start=${departureCoords[1]},${departureCoords[0]}&end=${arrivalCoords[1]},${arrivalCoords[0]}`)
                .then(response => response.json())
                .then(routeData => {
                    // Remove the previous route layer if it exists
                    if (routeLayer) {
                        map.removeLayer(routeLayer);
                    }

                    // Extract the route geometry
                    const routeCoords = routeData.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);

                    // Add the route to the map
                    routeLayer = L.polyline(routeCoords, { color: 'blue', weight: 4 }).addTo(map);

                    // Zoom to the route
                    map.fitBounds(routeLayer.getBounds());
                })
                .catch(error => console.error('Error fetching route data:', error));
        })
        .catch(error => console.error('Error fetching geocoding data:', error));
    }
</script>

<section class="main-section">
    <div class="form-container">
        <h2>Transportez des colis sur votre trajet</h2>
        <form>
            <input id="departure-city" type="text" placeholder="Ville de départ">
            <input id="arrival-city" type="text" placeholder="Ville d'arrivée">
            <button type="button" onclick="searchRoute()">Chercher</button>
        </form>
        <img src="new 9.png" alt="Smiling Box" height="400px" width="400px">

        <!-- Converted Section to Div -->
        <div class="additional-section">
            <div class="package-grid">
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "colisco");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch all packages from the colis table
                $sql = "SELECT id, photos, object, ville_dep, ville_arr, price FROM colis";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop through all rows and display each package
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="package-container">
                            <div class="photo">
                                <?php if (!empty($row["photos"])): ?>
                                    <img src="<?php echo htmlspecialchars($row["photos"]); ?>" alt="Package Photo">
                                <?php else: ?>
                                    No Photo Available
                                <?php endif; ?>
                            </div>
                            <div class="details">
                                <h3><?php echo htmlspecialchars($row["object"]); ?></h3>
                                <div class="routes">
                                    <label>
                                        <div class="circle"></div>
                                        <?php echo htmlspecialchars($row["ville_dep"]); ?>
                                    </label>
                                    <div class="line"></div>
                                    <label>
                                        <div class="circle"></div>
                                        <?php echo htmlspecialchars($row["ville_arr"]); ?>
                                    </label>
                                </div>
                                <div class="price"><?php echo htmlspecialchars($row["price"]); ?> TND</div>
                                <form action="description_annonce.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <button type="submit" class="button">Voir l'annonce</button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No packages found in the database.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div class="map-container" id="map-container">
        <div class="loading-spinner"></div>
        <div id="map" style="width: 100%; height: 800px;"></div>
    </div>
</section>

<div id="package-details" style="
    display: none;
    position: absolute;
    top: 430px;
    left: 640px;
    z-index: 1000;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 200px;
">
    <img id="package-photo" src="" alt="Package Photo" style="width: 100%; height: auto; border-radius: 10px; margin-bottom: 10px;">
    <h3 id="package-title"></h3>
    <p><strong>Départ:</strong> <span id="package-departure"></span></p>
    <p><strong>Arrivée:</strong> <span id="package-arrival"></span></p>
    <p><strong>Prix:</strong> <span id="package-price"></span> TND</p>
    <form action="description_annonce.php" method="GET">
        <input type="hidden" name="id" value="">
        <button type="submit" class="button">Voir l'annonce</button>
      </form>
</div>

<?php
// Fetch all departure cities (ville_dep), arrival cities (ville_arr), prices, objects, and photos from the colis table
$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$departureData = [];
$sql = "SELECT id, ville_dep, ville_arr, price, object, photos FROM colis";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departureData[] = $row;
    }
}

$conn->close();
?>
<script>
    // Pass PHP array to JavaScript
    const departureData = <?php echo json_encode($departureData); ?>;
</script>

<?php
// Fetch all required data from trajets and userregistration tables
$conn = new mysqli("localhost", "root", "", "colisco");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$trajetsData = [];
$sql = "
    SELECT 
        trajets.departure_city, 
        trajets.arrival_city, 
        trajets.user_name, 
        userregistration.phone_number 
    FROM trajets
    INNER JOIN userregistration 
    ON trajets.user_name = CONCAT(userregistration.first_name, ' ', userregistration.last_name)
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trajetsData[] = $row;
    }
}

$conn->close();
?>
<script>
    // Pass PHP array to JavaScript
    const trajetsData = <?php echo json_encode($trajetsData); ?>;
</script>

<script>
    // Initialize the map
    const map = L.map('map').setView([33.8869, 9.5375], 6); // Centered on Tunisia

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let routeLayer; // To store the route layer

    // Add markers for each departure city with price
    departureData.forEach(data => {
        const city = data.ville_dep;
        const price = data.price;

        // Geocode the city to get its coordinates
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}`)
            .then(response => response.json())
            .then(geoData => {
                if (geoData.length > 0) {
                    const { lat, lon } = geoData[0];

                    // Add a marker with a tooltip containing the price
                    const marker = L.marker([lat, lon])
                        .addTo(map)
                        .bindTooltip(`<b><b>${city}</b><br> ${price} TND`, {
                            permanent: false, // Tooltip only appears on hover
                            direction: 'top', // Tooltip appears above the marker
                            offset: [0, -10] // Adjust the position slightly above the marker
                        });

                    // Add a click event to the marker
                    marker.on('click', () => {
                        // Fetch the route and display package details
                        showRouteAndDetails(data, lat, lon);
                    });
                } else {
                    console.error(`Could not find location for ${city}`);
                }
            })
            .catch(error => console.error('Error fetching geocoding data:', error));
    });

    // Custom walking icon
    const walkingIcon = L.icon({
        iconUrl: 'humanisme.png', // Replace with the path to your walking icon image
        iconSize: [32, 32], // Size of the icon
        iconAnchor: [16, 32], // Anchor point of the icon
        popupAnchor: [0, -32] // Position of the popup relative to the icon
    });

    // Add markers for each departure city from trajets
    trajetsData.forEach(data => {
        const departureCity = data.departure_city;
        const arrivalCity = data.arrival_city;
        const userName = data.user_name;
        const phoneNumber = data.phone_number;

        // Geocode the departure city to get its coordinates
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(departureCity)}`)
            .then(response => response.json())
            .then(geoData => {
                if (geoData.length > 0) {
                    const { lat, lon } = geoData[0];

                                    // Add a marker with the walking icon
                    const marker = L.marker([lat, lon], { icon: walkingIcon })
                        .addTo(map)
                        .bindPopup(`
                            <b>Départ:</b> ${departureCity}<br>
                            <b>Arrivée:</b> ${arrivalCity}<br>
                            <b>Utilisateur:</b> ${userName}<br>
                            <b>Téléphone:</b> ${phoneNumber}<br>
                            <a href="discussion.php?user_name=${encodeURIComponent(userName)}" class="button" style="display: block; margin: 10px auto; text-align: center; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; width: fit-content;">Discuter</a>
                            <a href="user_profile.php?user_name=${encodeURIComponent(userName)}" class="button" style="display: block; margin: 10px auto; text-align: center; background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; width: fit-content;">Voir le profil</a>
                        `);

                    // Add a click event to the marker
                    marker.on('click', () => {
                        // Geocode the arrival city
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(arrivalCity)}`)
                            .then(response => response.json())
                            .then(arrivalGeoData => {
                                if (arrivalGeoData.length > 0) {
                                    const arrivalCoords = [arrivalGeoData[0].lat, arrivalGeoData[0].lon];

                                    // Fetch the route from OpenRouteService
                                    fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=YOUR_API_KEY&start=${lon},${lat}&end=${arrivalCoords[1]},${arrivalCoords[0]}`)
                                        .then(response => response.json())
                                        .then(routeData => {
                                            // Remove the previous route layer if it exists
                                            if (routeLayer) {
                                                map.removeLayer(routeLayer);
                                            }

                                            // Extract the route geometry
                                            const routeCoords = routeData.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);

                                            // Add the route to the map
                                            routeLayer = L.polyline(routeCoords, { color: 'blue', weight: 4 }).addTo(map);

                                            // Zoom to the route
                                            map.fitBounds(routeLayer.getBounds());
                                        })
                                        .catch(error => console.error('Error fetching route data:', error));
                                } else {
                                    console.error(`Could not find location for ${arrivalCity}`);
                                }
                            })
                            .catch(error => console.error('Error fetching geocoding data for arrival city:', error));
                    });
                } else {
                    console.error(`Could not find location for ${departureCity}`);
                }
            })
            .catch(error => console.error('Error fetching geocoding data for departure city:', error));
    });

    // Function to fetch the route and display package details
    function showRouteAndDetails(data, lat, lon) {
        const departureCity = data.ville_dep;
        const arrivalCity = data.ville_arr;
        const photo = data.photos; // Assuming 'photos' contains the photo URL
        const packageId = data.id; // Assuming 'id' contains the package ID

        // Geocode the arrival city
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(arrivalCity)}`)
            .then(response => response.json())
            .then(geoData => {
                if (geoData.length > 0) {
                    const arrivalCoords = [geoData[0].lat, geoData[0].lon];

                    // Fetch the route from OpenRouteService
                    fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248574132d2e0874d0c96af7d6a6fe8c38b&start=${lon},${lat}&end=${arrivalCoords[1]},${arrivalCoords[0]}`)
                        .then(response => response.json())
                        .then(routeData => {
                            // Remove the previous route layer if it exists
                            if (routeLayer) {
                                map.removeLayer(routeLayer);
                            }

                            // Extract the route geometry
                            const routeCoords = routeData.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);

                            // Add the route to the map
                            routeLayer = L.polyline(routeCoords, { color: 'blue', weight: 4 }).addTo(map);

                            // Zoom to the route
                            map.fitBounds(routeLayer.getBounds());

                            // Display package details
                            document.getElementById('package-photo').src = photo || 'default-photo.jpg'; // Use a default photo if none is provided
                            document.getElementById('package-title').textContent = data.object;
                            document.getElementById('package-departure').textContent = departureCity;
                            document.getElementById('package-arrival').textContent = arrivalCity;
                            document.getElementById('package-price').textContent = data.price;

                            // Update the hidden input field in the #package-details form
                            document.querySelector('#package-details input[name="id"]').value = packageId;

                            // Show the package details section
                            document.getElementById('package-details').style.display = 'block';
                        })
                        .catch(error => console.error('Error fetching route data:', error));
                } else {
                    console.error(`Could not find location for ${arrivalCity}`);
                }
            })
            .catch(error => console.error('Error fetching geocoding data:', error));
    }
</script>
       
</body>
</html>