<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            background-color: black;
            height: 100vh;
        }

        button {
            background-color: #7ed957; /* Vert */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 8px;
        }

        button:hover {
            background-color: #45a049;
        }

        h1 {
            color: #333;
        }
.textstat{
            
    color: #b7b7b7;
    margin-left: 20px;
    margin-top: 250px;
    font-family: 'Raleway';
    
}



.logo {
    width: 140px; /* Adjust the width to make it smaller */
    height: auto; /* Keep the aspect ratio intact */
    position: fixed; /* Fixes the image to the top-left corner */
    top: 0.4%; /* Adjusts the vertical position from the top */
    left: 5%; /* Adjusts the horizontal position from the left */
    z-index: 1000; /* Ensures the logo is on top of other elements */
    position: absolute;
}
        
    </style>
</head>
<body>

<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>

<?php include 'navRAPP.php'; ?>

    <h1 class="textstat">Choisir une statistique</h1>

    <!-- Bouton pour Statistique par matière -->
    <button type="button" onclick="window.location.href='genererRAPP.php';">
        Statistique par matière
    </button>

    <!-- Bouton pour Statistique par étudiant -->
    <button type="button" onclick="window.location.href='genererRAPPmat.php';">
        Statistique par étudiant
    </button>

</body>
</html>
