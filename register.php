<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $auth_code = trim($_POST['auth_code']); // Récupérer le code d'authentification

    // Validation des données
    if (empty($name) || empty($email) || empty($password) || empty($auth_code)) {
        echo "Tous les champs sont requis.";
        exit;
    }

    // Vérifier si l'e-mail est déjà utilisé
    $stmt = $conn->prepare("SELECT * FROM professors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Cet e-mail est déjà utilisé.";
    } else {
        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insérer les données dans la table professors
        $stmt = $conn->prepare("INSERT INTO professors (name, email, password, auth_code) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $auth_code);

        if ($stmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur lors de l'inscription : " . $stmt->error;
        }
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Professeur</title>
</head>
<body>
    <h2>Inscription pour les Professeurs</h2>
    <form action="" method="POST">
        <label for="name">Nom :</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="auth_code">Code d'authentification :</label><br>
        <input type="text" id="auth_code" name="auth_code" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
