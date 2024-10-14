<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos de ce site</title>
    <link rel="stylesheet" href="">
    <style>
         body {
            font-family: 'Raleway', sans-serif;
            background-color: #000000; /* Fond noir */
            color: #ffffff; /* Texte en blanc */
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #b7b7b7;
    margin-left: 440px;
    margin-top: 230px;
    font-family: 'Raleway'
        }

        h2 {
            color: #7ed957; /* Texte en vert (#7ed957) */
        }

        h3 {
            color: #7ed957; /* Texte en vert (#7ed957) */
        }

        p, ul, li {
           
            margin-bottom: 15px;
            color: #ffffff; /* Texte en blanc */
        } 

        ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #7ed957; /* Texte en vert (#7ed957) */
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



    </style>
</head>

<body>
<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>
    <!-- Inclusion de la barre de navigation -->
    <?php include 'navapropos.php'; ?>

    <?php
        echo '<h1>À propos de ce site</h1>';
        echo '<h2>Groupe 24 : Système de suivi des performances académiques</h2>';
        
        echo "<p><strong>Contexte :</strong> Ce projet est réalisé dans le cadre du cursus de Licence 1 en Informatique. Les
        membres du groupe possèdent des connaissances en <em>Qt Creator, php, MySQL, JavaScript, HTML,</em> et <em>CSS</em>. L'objectif du projet est de concevoir un système permettant de suivre les performances académiques des étudiants d'une classe.</p>";

        echo '<h2>Description</h2>';
        echo '<p>Ce site web, ainsi que l\'application de bureau développée en <strong>Qt</strong>, permettent aux enseignants de gérer les notes des étudiants et de générer des rapports de performances. Les fonctionnalités clés incluent :</p>';

        echo '<ul>
            <li>Saisie et modification des notes par étudiant et par matière.</li>
            <li>Calcul automatique des moyennes.</li>
            <li>Génération de rapports académiques pour chaque étudiant ou par cours.</li>
        </ul>';

        echo '<h2>Conception du Système</h2>';
        echo '<h3>Base de données MySQL :</h3>';
        echo '<p>Le système utilise une base de données MySQL avec les tables suivantes :</p>';

        echo '<ul>
            <li><strong>Students :</strong> (id, name, student_number) - contient les informations des étudiants.</li>
            <li><strong>Courses :</strong> (id, name, code) - contient la liste des cours.</li>
            <li><strong>Grades :</strong> (id, student_id, course_id, grade) - enregistre les notes obtenues par chaque étudiant pour chaque cours.</li>
        </ul>';

        echo '<p>La relation entre les tables <em>Students</em> et <em>Courses</em> est gérée via la table <em>Grades</em>, où chaque note est liée à un étudiant et à un cours.</p>';

        echo '<h3>Interface Utilisateur :</h3>';
        echo '<ul>
            <li><strong>Qt (C++) :</strong> Une interface de bureau permettant la gestion des étudiants, des cours et la saisie des notes. Elle offre une vue centralisée pour les enseignants afin de générer des rapports académiques.</li>
            <li><strong>Web (HTML/CSS/JavaScript/PHP) :</strong> Une interface en ligne pour consulter les notes et les moyennes de chaque étudiant ou cours, accessible aux enseignants et aux étudiants.</li>
        </ul>';

        echo '<h2>Fonctionnalités Principales</h2>';
        echo '<ul>
            <li><strong>Saisie et modification des notes :</strong> Les enseignants peuvent ajouter ou modifier les notes des étudiants dans l\'interface.</li>
            <li><strong>Calcul des moyennes :</strong> Le système calcule automatiquement la moyenne des notes de chaque étudiant.</li>
            <li><strong>Génération de rapports :</strong> Les enseignants peuvent générer des rapports académiques en PDF, montrant les performances des étudiants dans les différents cours.</li>
            <li><strong>Consultation :</strong> Les étudiants peuvent consulter leurs performances académiques par cours, ou voir un résumé général de leurs notes et moyennes.</li>
        </ul>';

        echo '<div class="footer">';
        echo '<p>&copy; 2024 Groupe 24 - Système de suivi des performances académiques | L1 Informatique  2023-2024</p>';
        echo '</div>';
    ?>
</body>

</html>
