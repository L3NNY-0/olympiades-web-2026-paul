<?php

session_start();

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

include("../../Models/database.php")

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>STEAMLANDIA - Administrateur</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Administrateur</p>
        <div id="section_nav">
            <a class="liens_nav" href="#">SUPERVISION</a>
            <a class="liens_nav" href="Ajout/ajout.php">AJOUT</a>
            <a class="liens_nav" href="Ajout/ajout.php">MODIFICATION</a>
            <a class="liens_nav" href="Ajout/ajout.php">SUPPRESSION</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <h1 class="titres">Toutes les attractions</h1>
        <?php

        $attractionsQDI = requeteBdd("SELECT * FROM attraction;");
        foreach ($attractionsQDI as $row) {
            echo "<div class='attraction'><div class='text_attraction'><h3 class='titres'>" . htmlspecialchars($row['nom']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p><br>";
            echo "<p>Taille min. : " . htmlspecialchars($row['taille_cm']) . " cm - Statut : " . htmlspecialchars($row['statut']) . "</p></div>";
            echo "<img class='img_attractions' src='../../Images/" . htmlspecialchars($row['url_img']) . ".png' alt='Photographie de " . htmlspecialchars($row['nom']) . "'></div>";
        }
        ?>
    </div>
</body>

</html>