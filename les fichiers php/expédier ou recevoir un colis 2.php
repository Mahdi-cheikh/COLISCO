<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=width=device-width, initial-scale=1.0">
    <title>Expédier ou Recevoir un Colis</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index.css">
    <style>
     
        
            body {
          font-family: 'Poppins', sans-serif;
          background-color: #f9f9f9;
          margin: 0;
          padding: 0;
      }
      
      .container {
          background-color: #ffffff;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          max-width: 500px;
          margin: 20px auto;
          border-radius: 30px;
         
      }
      
      h1 {
          font-size: 1.8rem;
          color: #001B4B;
          margin-bottom: 20px;
          text-align: center;
      }
      
      .progress-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 500px;
        margin: 30px auto;
        position: relative;
        margin-top: 100px;
    }
    
    /* Line between steps */
    .progress-bar .line {
        flex: 8;
        background-color: #d3d3d3;
        margin: 0 -23px;
        padding: 5px;
    }
    
    .progress-bar .line.active {
        background-color: #1900ff;
    }
    
    /* Step circles */
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .step .circle {
        width: 40px;
        height: 40px;
        background-color: #d3d3d3;
        border-radius: 50%;
        display: flex;
        margin-top: 25px;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s ease-in-out;
    }
    
    .step.active .circle {
        background-color: #1900ff;
        box-shadow: 0 0 10px rgba(74, 108, 247, 0.5);
        
    }
    
    /* Step labels */
    .step span {
        margin-top: 8px;
        font-size: 14px;
        color: #d3d3d3;
        transition: color 0.3s ease-in-out;
    }
    
    .step.active span {
        color: #4a6cf7;
    }
      
      .info-banner {
          display: flex;
          align-items: center;
          background-color: #ffeef2;
          padding: 10px;
          border-radius: 5px;
          margin-bottom: 20px;
      }
      
      .info-banner img {
          width: 30px;
          margin-right: 10px;
      }
      
      .info-banner p {
          font-size: 0.9rem;
          color: #ff69b4;
      }
      
      .form-group {
          margin-bottom: 15px;
      }
      
      label {
          display: block;
          font-size: 0.9rem;
          color: #333;
          margin-bottom: 5px;
      }
      
      input[type="text"],
      input[type="number"],
      textarea,
      select {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 0.9rem;
      }
      
      textarea {
          resize: none;
          height: 80px;
      }
      
      button {
          display: block;
          width: 60%;
          padding: 10px;
          background-color: #0800ff;
          color: #fff;
          border: none;
          border-radius: 30px;
          font-size: 1rem;
          cursor: pointer;
          margin-top: 10px;
          margin-left: 20px;
      }
      
      button:hover {
          background-color: #0056b3;
      }
      
      .add-object-btn {
          color: #f5f5f5;
          border: 1px solid #0400eb;
          border-radius: 30px;
      }
      
      .add-object-btn:hover {
          background-color: #0011ff;
      }
      
      .info-note {
          font-size: 0.8rem;
          color: #666;
          margin-top: 10px;
          text-align: center;
      }
      * Form Styling */
.form-group {
    margin-bottom: 15px;
}
.inline-group {
    display: flex;
    align-items: center;
    gap: 10px; /* Adjust spacing between checkbox and label */
}

.inline-group label {
    margin: 0; /* Remove default margin from label */
}
/* Navigation Buttons */
.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    gap: 10px;
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
                    <li><a href="devis démenagement.PHP">Devis déménagement</a></li>
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
    <div class="progress-bar">
        <div class="step active">
            <div class="circle"></div>
            <span>Colis</span>
        </div>
        <div class="line active"></div>
        <div class="step active">
            <div class="circle"></div>
            <span>Départ</span>
        </div>
        <div class="line"></div>
        <div class="step">
            <div class="circle"></div>
            <span>Arrivée</span>
        </div>
        <div class="line"></div>
        <div class="step">
            <div class="circle"></div>
            <span>Prix</span>
        </div>
    </div>

    <div class="container">
        <h1>Enlèvement</h1>

        <form method="POST" action="expedier_colis 2.php">
            <div class="form-group">
                <label for="ville_dep">Adresse</label>
                <input type="text" id="ville_dep" name="ville_dep" placeholder="Ex: 13 cité el nour nabeul" required>
            </div>

            <div class="form-group">
                <label for="pickup_type_dep">Type d'enlèvement</label>
                <select id="pickup_type_dep" name="pickup_type_dep" required>
                    <option value="">Choisir un type d'enlèvement</option>
                    <option value="domicile">À domicile</option>
                    <option value="point-relais">Point relais</option>
                </select>
            </div>

            <div class="form-group inline-group">
                <input type="checkbox" id="has_coordinates_dep" name="has_coordinates_dep">
                <label for="has_coordinates_dep">J'ai les coordonnées de l'expéditeur</label>
            </div>

            <div class="form-navigation">
                <button type="button" class="prev-btn" onclick="location.href='Expédier ou recevoir un colis.php'">Précédent</button>
                <button type="submit" class="next-btn">Suivant</button>
            </div>
        </form>
    </div>
</body>
</html>