<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        body {
            background-color: #000; /* Fond noir */
            color: #fff; /* Texte blanc */
            font-family: 'Raleway', sans-serif; /* Utilisation de la police Barlow Condensed */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            width:100%;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            margin-top:850px;
        }
        .info-box {
            border: 1px solid #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
        }
        p {
            font-size: 1.2rem;
            line-height: 1.5;
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
    font-family: 'Raleway';
    font-style: normal;
    font-weight: 400;
    font-display: swap;
    src: url('fonts/Raleway-Thin.ttf') format('truetype'); /* Assurez-vous que le nom du fichier est correct */
    /* Vous pouvez également ajouter d'autres formats si nécessaire */
}

.footer {
            margin-top: 2900px;
            text-align: center;
            font-size: 0.9em;
            color: #ffff; /* Texte en vert (#7ed957) */
            margin-left:-939px;
        }

     
        
    </style>
</head>
<body>
<?php include 'navcontact.php'; ?>

<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>
    <div class="container">
        <h1 style="margin-top:367px;">Contact</h1>

        <div class="info-box">
            <p><strong>Nom :</strong> ANDRIAFANOMEZANTSOA</p>
            <p><strong>Prénom :</strong> Ravaka</p>
            <p><strong>Classe :</strong> ENI L1 PRO GROUPE 1 2023-2024</p>
            <p><strong>numero :</strong> 3098</p>
            <p><strong>Facebook :</strong> Ravaka Andriafanomezantsoa</p>
            <p><strong>Email :</strong> ravakaandriafanomezantsoa@gmail.com</p>
        </div>

        <div class="info-box">
            <p><strong>Nom :</strong> LANTOFANAMBINANA</p>
            <p><strong>Prénom :</strong> Tsiaro</p>
            <p><strong>Classe :</strong> ENI L1 PRO GROUPE 1 2023-2024</p>
            <p><strong>Numero :</strong> 3099</p>
            <p><strong>Facebook :</strong>  Tsiaro LANTOFANAMBINANA</p>
            <p><strong>Email :</strong>lantofanambinanatsiaro@gmail.com</p>
        </div>

        <div class="info-box">
            <p><strong>Nom :</strong> SITRAKINIAINA</p>
            <p><strong>Prénom :</strong> Eddy Francisco</p>
            <p><strong>Classe :</strong> ENI L1 PRO GROUPE 1 2023-2024</p>
            <p><strong>Numero :</strong> 3136</p>
            <p><strong>Facebook :</strong>  Sitrakiniaina eddy francisco</p>
            <p><strong>Email :</strong> Sitrakiniainaeddyfrancisco@gmail.com</p>
           
        </div>

        <div class="info-box">
            <p><strong>Nom :</strong>SOLOFONJAZATIANA </p>
            <p><strong>Prénom :</strong>Fagnitsy Gilbert </p>
            <p><strong>Classe :</strong> ENI L1 PRO GROUPE 1 2023-2024</p>
            <p><strong>Numero :</strong></p>
            <p><strong>Facebook :</strong>  Gilbert Njaka</p>
            <p><strong>Email :</strong> solofogilbert13@gmail.com</p>
        </div>
    </div>

    <?php
    echo '<div class="footer">';
        echo '<p>&copy; 2024 Groupe 24 - Système de suivi des performances académiques | L1 Informatique  2023-2024</p>';
        echo '</div>';
        ?>

</body>
</html>
