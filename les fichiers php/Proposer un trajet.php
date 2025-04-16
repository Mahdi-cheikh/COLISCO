<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Itinerary Form</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 350px;
        }

        h1 {
            font-size: 1.5rem;
            color: #001B4B;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
        }

        .radio-group label {
            font-size: 0.9rem;
            color: #333;
        }

        .slider-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .slider-group input[type="range"] {
            width: 80%;
        }

        .slider-value {
            font-size: 0.9rem;
            color: #333;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #0800ff;
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group label {
            font-size: 0.9rem;
            color: #333;
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
                    <li><a href="Proposer un trajet.php">Proposer un trajet</a></li>
                    <li><a href="recherche trajet.php">Voir annonce</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Particulier ▾</a>
                <ul class="dropdown-menu">
                    <li><a href="Expédier ou recevoir un colis.php">Expédier ou recevoir un colis</a></li>
                    <li><a href="devis démenagement.php">Devis déménagement</a></li>
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
    <div class="container">
        <h1>Votre itinéraire</h1>
        <form action="propose_un_trajet.php" method="POST">
            <div class="form-group">
                <label>Je recherche des livraisons</label>
                <div class="radio-group">
                    <label><input type="radio" name="search" value="sur-mon-trajet" required> Sur mon trajet</label>
                    <label><input type="radio" name="search" value="autour-de-moi" required> Autour de moi</label>
                </div>
            </div>

            <div class="form-group">
                <label for="departure-city">Ville de départ</label>
                <input type="text" id="departure-city" name="departure-city" placeholder="Ex: Korbous" required>
            </div>

            <div class="form-group">
                <label for="arrival-city">Ville d'arrivée</label>
                <input type="text" id="arrival-city" name="arrival-city" placeholder="Ex: Nabeul" required>
            </div>

          

            <div class="form-group slider-group">
                <label for="detour">Détour maximum</label>
                <input type="range" id="detour" name="detour" min="0" max="50" value="20" oninput="updateSliderValue(this.value)" required>
                <span class="slider-value" id="slider-value">20 km</span>
            </div>

            <div class="form-group">
                <label for="max-amount">D'un montant maximum</label>
                <input type="text" id="max-amount" name="max-amount" placeholder="Ex: 60 TND" required>
            </div>

            <div class="form-group">
                <label>Fréquence</label>
                <div class="radio-group">
                    <label><input type="radio" name="frequency" value="one-time" required> Je fais ce trajet une fois</label>
                    <label><input type="radio" name="frequency" value="regular" required> Je fais le trajet régulièrement</label>
                </div>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="round-trip" name="round-trip">
                <label for="round-trip">Aller-retour</label>
            </div>

            <button type="submit">Valider</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateSliderValue(value) {
                document.getElementById('slider-value').textContent = value + ' km';
            }

            const slider = document.getElementById('detour');
            slider.addEventListener('input', function () {
                updateSliderValue(this.value);
            });
        });
    </script>
</body>
</html>