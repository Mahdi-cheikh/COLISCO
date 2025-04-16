<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"="width=device-width, initial-scale=1.0">
    <title>expédier ou recevoir un colis 1</title>
    <link rel="stylesheet" href="index.css">
    <script defer src="script.js"></script>
    <style>
      
        
            .body {
          font-family: 'Poppins', sans-serif;
          background-color: #f9f9f9;
          margin: 0;
          padding: 0;
      }
      
      .container {
          background-color: #ffffff;
          padding: 30px;
          border-radius: 30px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          max-width: 500px;
          margin: 20px auto;
          margin-top: -30px;
      }
      
      h1 {
          font-size: 1.8rem;
          color: #001B4B;
          margin-bottom: 20px;
          text-align: center;
      }
      
          /* Progress Bar Styling */
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
        background-color: #d3d3d3;
       
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
          .img-modif img {
             position: relative; /* Ensures z-index works */
             z-index: 10; /* Brings the image to the front */
             margin-left: 955px;
             margin-bottom: -250px;
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
          margin-left: 110px;
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
          .photo-upload {
        text-align: center;
        margin-right: 40px;
    }
    
    .photo-label {
        display: inline-block;
        width: 100%;
        padding: 20px;
        border: 2px dashed #d3c4f3;
        border-radius: 10px;
        background-color: #f9f7ff;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }
    
    .photo-label:hover {
        background-color: #f0eaff;
        border-color: #bba4e6;
    }
    
    .photo-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .photo-icon {
        width: 40px;
        height: 40px;
        opacity: 0.7;
    }
    
    .photo-info {
        margin-top: 10px;
        font-size: 0.9rem;
        color: #666;
    }
        .inline-group {
        display: flex;
        align-items: center;
        gap: 10px; /* Adjust spacing between checkbox and label */
    }
    
    .inline-group label {
        margin: 0; /* Remove default margin from label */
    }
    .photo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
        position: relative;
    }

    .photo-preview img {
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 150px; /* Set a fixed width */
        height: 100px; /* Set a fixed height */
        object-fit: cover; /* Ensure the image fits within the dimensions without distortion */
    }

    .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #ccc;
        border-top: 4px solid #000;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        display: none; /* Hidden by default */
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    @keyframes highlight {
        0% {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        50% {
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.8);
        }
        100% {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    }

    .highlight-animation {
        animation: highlight 1s ease-in-out;
    }

    /* Add animation for the input field */
    #object {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 0.9rem;
        transition: all 5s ease-in-out;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    /* Add hover effect */
    #object:hover {
        border-color: #4a6cf7;
        box-shadow: 0 0 10px rgba(74, 108, 247, 0.5);
    }

    /* Add focus effect */
    #object:focus {
        border-color: #1900ff;
        box-shadow: 0 0 15px rgba(25, 0, 255, 0.7);
        outline: none;
    }

    /* Add typing animation */
    #object.typing {
        animation: typingEffect 5s ease-in-out;
    }

    @keyframes typingEffect {
        0% {
            background-color: #f0f8ff;
        }
        100% {
            background-color: #ffffff;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>
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
        <div class="step">
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
    <div class="img-modif">
        <img src="new 7.png" width="150px" height="150px" alt="Logo">
    </div>

    <div class="container">


        
       

        <h1>Quels objets envoyez-vous ?</h1>

        <form method="POST" action="expedier_colis.php" enctype="multipart/form-data">
            <div class="form-group photo-upload">
                <label for="photos" class="photo-label">
                    <div class="photo-box">
                        <img src="telechargement-dimages.png" alt="Camera Icon" class="photo-icon">
                        <span>Ajouter des photos</span>
                    </div>
                </label>
                <input type="file" id="photos" name="photos[]" multiple style="display: none;" accept="image/*">
                <p class="photo-info">Jusqu'à 7 photos, format JPG, PNG et GIF jusqu'à 7MB.</p>
                <div id="photoPreview" class="photo-preview"></div> <!-- Container for photo previews -->
            </div>
            <div class="form-group">
                <label for="object">Objet</label>
                <input type="text" name="object" id="object" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantité</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>

           

            <div class="form-group inline-group">
                <input type="checkbox" name="exact-dimensions" value="1">
                <label for="exact-dimensions">Je connais les dimensions exactes</label>
            </div>

            <div class="form-group">
                <label for="format">Format</label>
                <select name="format">
                    <option value="">Choisir une taille</option>
                    <option value="petit">Petit</option>
                    <option value="moyen">Moyen</option>
                    <option value="grand">Grand</option>
                </select>
            </div>

            <div class="form-group">
                <label for="weight">Poids</label>
                <select name="weight">
                    <option value="">Choisir un intervalle de poids</option>
                    <option value="0-5">0-5 kg</option>
                    <option value="5-10">5-10 kg</option>
                    <option value="10-20">10-20 kg</option>
                </select>
            </div>

            <div class="form-group">
                <label for="additional-info">Informations complémentaires</label>
                <textarea name="additional-info" placeholder="Ex: Le carton le plus long fait 2m15, le plus lourd est un canapé"></textarea>
            </div>

            <p class="info-note">Ces informations sont publiques. Pour préserver votre vie privée, n'indiquez pas vos coordonnées (adresse e-mail, téléphone ou adresse).</p>

            <button type="submit" class="next-btn">Suivant</button>
        </form>
    </div>

    <script>
        document.getElementById('photos').addEventListener('change', async function (event) {
            const photoPreview = document.getElementById('photoPreview');
            const objectInput = document.getElementById('object');
            photoPreview.innerHTML = ''; // Clear previous previews

            const files = event.target.files;
            if (files.length > 0) {
                const model = await cocoSsd.load(); // Load the Coco-SSD model

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = async function (e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.style.position = 'relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.filter = 'grayscale(100%)';
                        img.style.opacity = '0.5';

                        const spinner = document.createElement('div');
                        spinner.className = 'spinner';
                        spinner.style.display = 'block'; // Show spinner

                        imgContainer.appendChild(img);
                        imgContainer.appendChild(spinner);
                        photoPreview.appendChild(imgContainer);

                        // Wait for the image to load before making predictions
                        img.onload = async function () {
                            const predictions = await model.detect(img);
                            const objectName = predictions[0]?.class || 'Unknown';
                            objectInput.value = objectName;

                            // Add the animation class
                            objectInput.classList.add('highlight-animation');

                            // Remove the animation class after the animation ends
                            setTimeout(() => {
                                objectInput.classList.remove('highlight-animation');
                            }, 1000);

                            // Revert the image and hide the spinner
                            img.style.filter = 'none';
                            img.style.opacity = '1';
                            spinner.style.display = 'none'; // Hide spinner
                        };
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        // Add typing animation when the user types in the input field
        const objectInput = document.getElementById('object');
        objectInput.addEventListener('input', () => {
            objectInput.classList.add('typing');
            setTimeout(() => {
                objectInput.classList.remove('typing');
            }, 500);
        });
    </script>
</body>
</html>