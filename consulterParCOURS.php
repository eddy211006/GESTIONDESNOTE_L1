<?php
// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'academic_tracking';
$username = 'root'; // Modifier si nécessaire
$password = '';     // Modifier si nécessaire

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Impossible de se connecter à la base de données : " . $e->getMessage());
}

// Récupérer toutes les matières pour les afficher dans le formulaire
$sql = "SELECT id, name FROM courses";
$stmt = $pdo->query($sql);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Récupérer le nom du cours sélectionné
    $sql = "SELECT name FROM courses WHERE id = :course_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['course_id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    $course_name = $course['name']; // Nom du cours sélectionné

    // Requête SQL pour récupérer les notes des étudiants, leur ID et leur numéro d'inscription pour le cours sélectionné
    // Tri par ID de l'étudiant en ordre décroissant
    $sql = "
        SELECT students.id AS student_id, students.name, students.student_number, grades.grade
        FROM students
        JOIN grades ON students.id = grades.student_id
        JOIN courses ON grades.course_id = courses.id
        WHERE courses.id = :course_id
        ORDER BY students.id ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['course_id' => $course_id]);

    // Récupérer les résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculer la moyenne des notes
    $totalGrades = 0;
    $numStudents = count($results);

    if ($numStudents > 0) {
        foreach ($results as $row) {
            if (is_numeric($row['grade'])) {
                $totalGrades += $row['grade'];
            }
        }
        // Calcul de la moyenne
        $averageGrade = $totalGrades / $numStudents;
    } else {
        $averageGrade = null; // Aucune note disponible
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un cours</title>
    <link rel="stylesheet" href="consulterParCOURS.css">
    <style>
        .success { color: green; }
        .fail { color: red; }
    </style>
</head>
<body>
<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>

<?php include 'navconsultermat.php'; ?>
    <h1 class="textrech">Rechercher les notes des étudiants par matière</h1>

    <!-- Formulaire pour sélectionner la matière -->
    <form method="post" action="" class="consulter">
        <label for="course" style="color: #f2f2f2;">Cours :</label>
        <select name="course_id" id="course" required class="cadre">
            <option value="" disabled selected>Choisissez un cours</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="rechercher">Rechercher</button>
    </form>

    <!-- Affichage des résultats sous forme de tableau -->
    <?php if (isset($results) && count($results) > 0): ?>
        <h2 class="textnote">Notes des étudiants pour la matière : <?= htmlspecialchars($course_name) ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID de l'étudiant</th>
                    <th>Nom de l'étudiant</th>
                    <th>Numéro d'inscription</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['student_number']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Affichage de la moyenne des notes -->
        <p class="textmoy"><strong>Moyenne des notes :</strong> 
            <?php if ($averageGrade !== null): ?>
                <?= number_format($averageGrade, 2) ?> / 20
            <?php else: ?>
                Aucune note disponible.
            <?php endif; ?>
        </p>

        <!-- Affichage du message conditionnel selon que la classe atteint ou non la moyenne -->
        <?php if ($averageGrade !== null): ?>
            <?php if ($averageGrade >= 10): ?>
                <p class="success">Cette classe a atteint la moyenne pour la matière <?= htmlspecialchars($course_name) ?>.</p>
            <?php else: ?>
                <p class="fail">Cette classe n'a pas atteint la moyenne pour la matière <?= htmlspecialchars($course_name) ?>.</p>
            <?php endif; ?>
        <?php endif; ?>

    <?php elseif (isset($results)): ?>
        <p style="color:red;">Aucune note trouvée pour la matière <?= htmlspecialchars($course_name) ?>.</p>
    <?php endif; ?>
</body>
</html>
