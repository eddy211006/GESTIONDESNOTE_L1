<?php
// Connexion à la base de données
include 'db.php';

// Récupération des matières
$query = "SELECT id, name FROM courses";
$stmt = $pdo->prepare($query);
$stmt->execute();
$courses = $stmt->fetchAll();

// Si une matière est sélectionnée
$grades = [];
$total_grade = 20; // Supposons que le total des points est 20 pour l'exemple
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Récupération des notes pour la matière sélectionnée
    $grades_query = "
        SELECT s.name AS student_name, g.grade 
        FROM grades g
        JOIN students s ON g.student_id = s.id
        WHERE g.course_id = ?
    ";
    $grades_stmt = $pdo->prepare($grades_query);
    $grades_stmt->execute([$course_id]);
    $grades = $grades_stmt->fetchAll();
    
    // Calcul des pourcentages pour chaque étudiant par rapport au total possible
    $student_percentages = [];
    foreach ($grades as $grade) {
        $student_percentage = ($grade['grade'] / $total_grade) * 100;
        $student_percentages[] = round($student_percentage, 2);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord des Notes</title>
    
    <script src="./chart.js"></script>
    <style>
        body {
            background-color: black !important;
            margin: 1px;
            font-family: 'Raleway', Arial, sans-serif;
            height: 100vh;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            background-color: black;
            height: 100vh
        } 
        canvas {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }
        h1, label {
            color: #ffffff;
        }
        .tableau {
            margin-top: 200px;
            margin-left: 260px;
        }
        .logo {
            width: 140px;
            height: auto;
            position: fixed;
            top: 0.4%;
            left: 5%;
            z-index: 1000;
            position: absolute;
        }
        .tableau {
            color: #b7b7b7;
            margin-left: 0px;
            margin-top: 100px;
            font-family: 'Raleway';
        }
        .cadre {
            width: 300px;
            height: 41px;
            margin: 20px;
            border-radius: 10px;
            border: none;
        }
        .button {
            width: 166px;
            height: 42px;
            padding: 5px;
            transition: transform 0.2s ease;
            background-color: #7ed957;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin: 20px;
        }
        .button:hover {
            transform: scale(1.1);
            background-color: #45a049;
        }
        .fo {
            margin: 0 auto;
            margin-top: 50px;
            height: auto;
            font-family: 'Raleway';
            margin-left: 0px;
        }
        .cercle{
            margin:140px 210px;
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


<h1 class="tableau">Statistiques pour une matiere</h1>

<!-- Formulaire pour sélectionner la matière -->
<form method="POST" action="" class="fo">
    <label for="course_id">Choisissez une matière :</label>
    <select name="course_id" id="course_id" required class="cadre">
        <?php foreach ($courses as $course): ?>
            <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="button">Afficher les statistique</button>
</form>

<?php if (!empty($grades)): ?>
    <h2 style="color: #ffff;">Notes pour la matière : <?= htmlspecialchars($courses[array_search($course_id, array_column($courses, 'id'))]['name']) ?></h2>
    <canvas id="gradesChart" width="250" height="100"></canvas>
    
    <!-- Graphique en barres pour les notes des élèves -->
    <script>
        const ctx = document.getElementById('gradesChart').getContext('2d');
        const data = {
            labels: <?= json_encode(array_column($grades, 'student_name')) ?>,
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

    <!-- Graphique circulaire pour les pourcentages des notes des élèves par rapport au total -->
    <h3 style="color: #ffff;">Pourcentage des notes des élèves par rapport au total</h3>
    <canvas id="percentageChart" width="250" height="100" class="cercle"></canvas>
    <script>
        const percentageCtx = document.getElementById('percentageChart').getContext('2d');
        const percentageData = {
            labels: <?= json_encode(array_column($grades, 'student_name')) ?>,
            datasets: [{
                data: <?= json_encode($student_percentages) ?>,
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

        const percentageConfig = {
            type: 'pie',
            data: percentageData,
        };

        const percentageChart = new Chart(percentageCtx, percentageConfig);
    </script>

<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p style="color:red;">Aucune note trouvée pour cette matière.</p>
<?php endif; ?>

</body>
</html>
