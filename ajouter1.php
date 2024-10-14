<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
   
    <head>
    
</head>

<body>
 
    <?php include 'navajouter.php'; ?>
   
<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>






<style>

body{
    font-family: 'Raleway', Arial, sans-serif;
    margin: 20px;
    background-color:#000000;/*radial-gradient(circle at 0% 0%, #000000, #555555);*/
    background-repeat: no-repeat; 
    background-position: center;
    height: 100vh;
    background-size: cover;
    display: flex; /* Active le flexbox pour le corps */
    justify-content: flex-start; /* Aligne horizontalement à gauche */
    align-items: center; /* Centre verticalement */
    padding-left: 20px; /* Ajoute une petite marge à gauche si nécessaire */
}

.logo {
    width: 140px; /* Adjust the width to make it smaller */
    height: auto; /* Keep the aspect ratio intact */
    position: absolute; /* Fixes the image to the top-left corner */
    top: 0.4%; /* Adjusts the vertical position from the top */
    left: 5%; /* Adjusts the horizontal position from the left */
    z-index: 1000; /* Ensures the logo is on top of other elements */
 
    
}




@font-face {
    font-family: 'Barlow Condensed';
    font-style: normal;
    font-weight: 400;
    font-display: swap;
    src: url('fonts/BarlowCondensed-Italic.ttf') format('truetype'); /* Assurez-vous que le nom du fichier est correct */
    /* Vous pouvez également ajouter d'autres formats si nécessaire */
}

@font-face {
    font-family: 'Barlow Condensed';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts/BarlowCondensed-Bold.ttf') format('truetype');
}



@font-face {
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    font-display: swap;
    src: url('fonts/Raleway-Thin.ttf') format('truetype'); /* Assurez-vous que le nom du fichier est correct */
    /* Vous pouvez également ajouter d'autres formats si nécessaire */
}

@font-face {
    font-family: 'Barlow Condensed';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts/Raleway-Black.ttf') format('truetype');
}
    



</body>
</html>
