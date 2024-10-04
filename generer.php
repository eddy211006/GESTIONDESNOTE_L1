<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generer votre note</title>
    <link rel="stylesheet" href="consulter.css">
    <style>
        .message {
            font-size: 1.2em;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .failure {
            color: red;
        }

        h3, h4 {
            color: white; /* "Notes de l'Étudiant" et "Moyenne" en blanc */
        }
        .button-gen .down{
            margin-top:-24px;
            margin-left:37px;
        }
        .icon{
            margin-top:3px;
            margin-left:-97px;
            height:23px;
        }
    </style>
</head>
<body>

<a href="home.php" alt="Logo" class="logo"><img src="logo.png" alt="Logo" class="logo"></a>
    <!-- Fichier: navbar.php -->
    <?php include 'navgenerer.php'; ?>

    <h1 class="textcons">Generer &nbsp;en PDF &nbsp; votre &nbsp; rapport&nbsp; ici !</h1>

    <!-- Formulaire de recherche d'étudiant -->
    <form method="POST" action="genererPDF.php" class="generer">
        <input type="text" name="search_name" placeholder="Nom de l'étudiant" required class="genNomEtudiant">
        <input type="text" name="search_number" placeholder="Numéro de l'étudiant" required class="genNumEtudiant">
        <button type="submit" class="button-gen"><img src="down.png" alt="icone" class="icon">&nbsp;<p class="down">Générer PDF</p></button>
    </form>

    <?php
    require_once('TCPDF-main/tcpdf.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search_name = $_POST['search_name'];
        $search_number = $_POST['search_number'];

        // Vérification stricte pour s'assurer que l'étudiant existe avec ce nom et numéro
        $stmt = $pdo->prepare("
            SELECT s.name AS student_name, s.student_number 
            FROM Students s 
            WHERE s.name = ? AND s.student_number = ?
        ");
        $stmt->execute([$search_name, $search_number]);
        $student = $stmt->fetch();

        if ($student) {
            // Si l'étudiant existe, on continue à récupérer ses notes
            $grade_stmt = $pdo->prepare("
                SELECT c.name AS course_name, g.grade 
                FROM Grades g 
                JOIN Courses c ON g.course_id = c.id 
                WHERE g.student_id = (SELECT id FROM Students WHERE name = ? AND student_number = ?)
            ");
            $grade_stmt->execute([$search_name, $search_number]);
            $grades = $grade_stmt->fetchAll();

            if ($grades) {
                // Générer le PDF uniquement si l'étudiant a des notes
                $pdf = new TCPDF();
                $pdf->AddPage();
                $pdf->SetFont('helvetica', '', 12);

                // Contenu du PDF
                $html = "<h1>Notes de l'Étudiant : {$student['student_name']} ({$student['student_number']})</h1>";
                $html .= "<table border='1'>
                            <tr>
                                <th>Cours</th>
                                <th>Note</th>
                            </tr>";
                foreach ($grades as $grade) {
                    $html .= "<tr>
                                <td>{$grade['course_name']}</td>
                                <td>{$grade['grade']}</td>
                              </tr>";
                }
                $html .= "</table>";

                // Calcul de la moyenne
                $average_stmt = $pdo->prepare("
                    SELECT AVG(g.grade) AS average 
                    FROM Grades g 
                    JOIN Students s ON g.student_id = s.id 
                    WHERE s.name = ? AND s.student_number = ?
                ");
                $average_stmt->execute([$search_name, $search_number]);
                $average = $average_stmt->fetch();
                $average_value = round($average['average'], 2);

                $html .= "<h4>Moyenne : $average_value</h4>";

                // Ajouter le contenu HTML au PDF
                $pdf->writeHTML($html, true, false, true, false, '');

                // Sortie du PDF
                $pdf->Output('rapport_etudiant.pdf', 'I');
            } else {
                // Aucun grade trouvé pour cet étudiant
                echo "<p class='message failure'>Cet étudiant n'a aucune note enregistrée.</p>";
            }
        } else {
            // Si aucun étudiant n'est trouvé
            echo "<p class='message failure'>Aucun étudiant trouvé avec ce nom et ce numéro.</p>";
        }
    }
    ?>
</body>
</html>
