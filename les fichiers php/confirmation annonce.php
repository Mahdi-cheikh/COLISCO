<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details</title>
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #e5e5e5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            width: 600px;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .photo {
            position: relative;
            width: 250px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #d9d9d9;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
            height: 100%;
        }

        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .photo button {
            position: absolute;
            top: 89%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 15px 10px;
            cursor: pointer;
            z-index: 10;
        }

        .photo .prev {
            left: 5px;
        }

        .photo .next {
            right: -190px;
        }

        .details {
            flex: 1;
            margin-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .details h3 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #000;
        }

        .details .price {
            font-size: 18px;
            font-weight: bold;
            color: #4a00ff;
            text-align: left; /* Aligns the text to the left */
            position: relative; /* Allows positioning with top and left */
            top: 20px; /* Moves the price lower */
            left: 90px; /* Moves the price more to the left */
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
            font-size: 14px;
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
        }

        .button:hover {
            background-color: #3a00cc;
        }
    </style>
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
                    <li><a href="Proposer un trajet.html">Proposer un trajet</a></li>
                    <li><a href="recherche trajet.html">Voir annonce</a></li>
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
                    <img src="utilisateur.png" alt="Profile Picture" class="profile-pic">
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
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
    <div class="container">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "colisco");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the last ID from the colis table
        $sql_last_id = "SELECT MAX(id) AS last_id FROM colis";
        $result_last_id = $conn->query($sql_last_id);

        if ($result_last_id->num_rows > 0) {
            $row_last_id = $result_last_id->fetch_assoc();
            $id = $row_last_id['last_id'];

            // Fetch data for the package with the last ID
            $sql = "SELECT photos, object, ville_dep, ville_arr, price FROM colis WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Output data for the package
                $row = $result->fetch_assoc();
                ?>
                <div class="photo">
                    <?php 
                    $photos = explode(',', $row["photos"]); // Assuming photos are stored as a comma-separated string
                    if (!empty($photos)): ?>
                        <div class="carousel">
                            <?php foreach ($photos as $photo): ?>
                                <img src="<?php echo htmlspecialchars($photo); ?>" alt="Package Photo">
                            <?php endforeach; ?>
                        </div>
                        <button class="prev">&lt;</button>
                        <button class="next">&gt;</button>
                    <?php else: ?>
                        No Photo Available
                    <?php endif; ?>
                </div>
                <div class="details">
                    <h3><?php echo htmlspecialchars($row["object"]); ?></h3>
                    <div class="routes">
                        <label>
                            <input type="radio" name="route" value="route1" selected >
                            <?php echo htmlspecialchars($row["ville_dep"]); ?>
                        </label>
                        <div class="line"></div>
                        <label>
                            <input type="radio" name="route" value="route2">
                            <?php echo htmlspecialchars($row["ville_arr"]); ?>
                        </label>
                    </div>
                    <div class="price"><?php echo htmlspecialchars($row["price"]); ?> TND</div>
                    <form action="index2.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" class="button">Valider</button>
                    </form>
                </div>
                <?php
            } else {
                echo "<p>No package found with the specified ID.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>No packages found in the database.</p>";
        }

        $conn->close();
        ?>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.querySelector(".carousel");
        const images = document.querySelectorAll(".carousel img");
        const prevButton = document.querySelector(".prev");
        const nextButton = document.querySelector(".next");

        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * 100; // Move by 100% for each image
            carousel.style.transform = `translateX(${offset}%)`;
        }

        prevButton.addEventListener("click", function () {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
            updateCarousel();
        });

        nextButton.addEventListener("click", function () {
            currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        });
    });
</script>
</body>
</html>