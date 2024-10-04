<?php
// Connexion à la base de données
include 'db.php';

// Si le formulaire est soumis
$grades = [];
$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_name']) && isset($_POST['student_number'])) {
    $student_name = $_POST['student_name'];
    $student_number = $_POST['student_number'];

    // Vérifier si l'étudiant existe dans la base de données
    $student_query = "
        SELECT id 
        FROM students 
        WHERE name = ? AND student_number = ?
    ";
    $student_stmt = $pdo->prepare($student_query);
    $student_stmt->execute([$student_name, $student_number]);
    $student = $student_stmt->fetch();

    if ($student) {
        $student_id = $student['id'];

        // Récupérer les notes de l'étudiant
        $grades_query = "
            SELECT c.name AS course_name, g.grade 
            FROM grades g
            JOIN courses c ON g.course_id = c.id
            WHERE g.student_id = ?
        ";
        $grades_stmt = $pdo->prepare($grades_query);
        $grades_stmt->execute([$student_id]);
        $grades = $grades_stmt->fetchAll();

        // Calculer le total des notes pour obtenir les pourcentages
        $total_grades = array_sum(array_column($grades, 'grade'));
        $grades_percentages = array_map(function ($grade) use ($total_grades) {
            return round(($grade['grade'] / $total_grades) * 100, 2);
        }, $grades);
    } else {
        $error_message = "Aucun étudiant trouvé avec ce nom et numéro d'étudiant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de l'Étudiant</title>
    
    <script src="./chart.js"></script>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            font-family: 'Raleway', Arial, sans-serif;
            margin-top: 100px;
            background-color: black !important;
            margin: 1px;
            font-family: 'Raleway', Arial, sans-serif;
            height: 100vh;
            text-align: center;
        }
        canvas {
            max-width: 100%;
            margin: 20px 0;
        }
        .form-container {
            margin: 20px auto;
        }
        .button {
            background-color: #7ed957;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 20px;
        }
        .logo {
            width: 140px;
            height: auto;
            position: absolute !important;
            top: 0.4%;
            left: 5%;
            z-index: 1000;
        }
        .textstat {
            color: #b7b7b7;
            margin-left: 20px;
            margin-top: 250px;
            font-family: 'Raleway';
        }
        button {
            background-color: #7ed957;
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
            height: 45px;
        }
        button:hover {
            background-color: #45a049;
        }
        .textst {
            color: #b7b7b7;
            margin-left: 0px;
            margin-top: 100px;
            font-family: 'Raleway';
        }
        .nom, .num {
            width: 300px;
            height: 45px;
            margin: 20px;
            border-radius: 10px;
            border: none;
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

<h1 class="textst">Statistiques pour un Étudiant</h1>

<form method="POST" action="" class="form-container">
        <input type="text" name="student_name" placeholder="Nom de l'étudiant"  id="student_name" required class="nom">
        <input type="text" name="student_number" placeholder="Numéro de l'étudiant" required class="num">
        <button type="submit" class="button">Générer PDF</button>
</form>

<?php if ($error_message): ?>
    <p class="error"><?= $error_message ?></p>
<?php endif; ?>

<?php if (!empty($grades)): ?>
    <h2>Notes pour l'étudiant : <?= htmlspecialchars($student_name) ?></h2>

    <canvas id="gradesChart" width="400" height="150"></canvas>
    
    <!-- Graphique en barres pour les notes par matière -->
    <script>
        const ctx = document.getElementById('gradesChart').getContext('2d');
        const data = {
            labels: <?= json_encode(array_column($grades, 'course_name')) ?>,
            datasets: [{
                label: 'Notes',
                data: <?= json_encode(array_column($grades, 'grade')) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff',
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff',
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        }
                    }
                }
            }
        };
        const gradesChart = new Chart(ctx, config);
    </script>

    <!-- Graphique circulaire pour la répartition des pourcentages de notes par matière -->
    <h3>Répartition des notes par matière en pourcentage</h3>
    <canvas id="averageChart" width="200" height="200"></canvas>
    <script>
        const avgCtx = document.getElementById('averageChart').getContext('2d');
        const avgData = {
            labels: <?= json_encode(array_column($grades, 'course_name')) ?>,
            datasets: [{
                data: <?= json_encode($grades_percentages) ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', 
                    'rgba(255, 99, 132, 0.2)', 
                    'rgba(255, 206, 86, 0.2)', 
                    'rgba(75, 192, 192, 0.2)', 
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', 
                    'rgba(255, 99, 132, 1)', 
                    'rgba(255, 206, 86, 1)', 
                    'rgba(75, 192, 192, 1)', 
                    'rgba(153, 102, 255, 1)', 
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };
        const avgConfig = {
            type: 'pie',
            data: avgData,
        };
        const averageChart = new Chart(avgCtx, avgConfig);
    </script>

<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p style="color:red;">Aucune note trouvée pour cet étudiant.</p>
<?php endif; ?>

</body>
</html>
