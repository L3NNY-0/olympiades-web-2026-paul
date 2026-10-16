<?php

session_start();

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../login.php');
    exit;
}

include("../../../Models/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=olympiade", "admin", "admin");

        $stmt = $db->prepare("DELETE FROM attraction WHERE nom=:nom;");
        $stmt->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
        $stmt->execute();

        header('Location: suppr.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Connexion impossible. Veuillez réessayer plus tard.';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>STEAMLANDIA - Administrateur</title>
    <link rel="stylesheet" href="suppr.css">
    <script src="../../../Controllers/app.js"></script>
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Administrateur</p>
        <div id="section_nav">
            <a class="liens_nav" href="../dashboard.php">SUPERVISION</a>
            <a class="liens_nav" href="../Ajout/ajout.php">AJOUT</a>
            <a class="liens_nav" href="../Modification/modif.php">MODIFICATION</a>
            <a class="liens_nav" href="#">SUPPRESSION</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <div id="contenu">
            <h1 class="titres">Supprimer une attraction</h1>

            <form method="POST" action="suppr.php" id="formulaire" onsubmit="return confirmSuppr()">
                <div class="form-group">
                    <label for="nom">Attraction</label>
                    <select name="nom" required>
                        <?php
                        try {
                            $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");

                            $stmt = $db->query("SELECT nom FROM attraction;");

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option>' . htmlspecialchars($row['nom']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            $error = 'Connexion impossible. Veuillez réessayer plus tard.';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Supprimer</button>
            </form>
            <h1 class="titres">Vue d'ensemble</h1>
            <?php

            $attractionsQDI = requeteBdd("SELECT * FROM attraction;");
            foreach ($attractionsQDI as $row) {
                echo "<div class='attraction'><div class='text_attraction'><h3 class='titres'>" . htmlspecialchars($row['nom']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p><br>";
                echo "<p>Taille min. : " . htmlspecialchars($row['taille_cm']) . " cm - Statut : " . htmlspecialchars($row['statut']) . "</p></div>";
                echo "<img class='img_attractions' src='../../../Images/" . htmlspecialchars($row['url_img']) . ".png' alt='Photographie de " . htmlspecialchars($row['nom']) . "'></div>";
            }
            ?>
        </div>
    </div>
</body>

</html>