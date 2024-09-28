<?php
// Inclure la connexion à la base de données
include 'db.php';

// Gérer l'ajout d'un étudiant si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_number = $_POST['student_number'];

    // Insérer l'étudiant dans la table Students
    $stmt = $pdo->prepare("INSERT INTO Students (name, student_number) VALUES (?, ?)");
    $stmt->execute([$name, $student_number]);

    echo "<p>Étudiant ajouté avec succès !</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   
    <?php include 'navbar.php'; ?>

    <h1>Ajouter un Étudiant</h1>

    <form method="POST" action="">
        <label for="name">Nom de l'étudiant :</label>
        <input type="text" name="name" id="name" placeholder="Nom complet" required>

        <br><br>

        <label for="student_number">Numéro d'étudiant :</label>
        <input type="text" name="student_number" id="student_number" placeholder="Numéro d'étudiant" required>

        <br><br>

        <button type="submit">Ajouter l'Étudiant</button>
    </form>
</body>
</html>
