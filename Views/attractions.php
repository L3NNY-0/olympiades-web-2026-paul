<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEAMLANDIA - Nos attractions</title>
    <link rel="stylesheet" href="attractions.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA</p>
        <div id="section_nav">
            <a class="liens_nav" href="accueil.php">ACCUEIL</a>
            <a class="liens_nav" href="#">ATTRACTIONS</a>
            <a class="liens_nav" href="horaires.php">HORAIRES</a>
            <a class="liens_nav" href="tarifs.php">TARIFS</a>
            <a class="liens_nav" href="#">CONTACT</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div id="intro">
        <div id="text_intro">
            <h1>Toutes nos attractions</h1>
            <h2 class="titres">Parcourez la liste de toutes les attractions du parc.</h2>
            <p>Des sensations fortes au sensations douces, en passant par les spectacles familiaux, il y en aura pour tout le monde !</p>
        </div>
    </div>

    <div class="univers">
        <h1 class="titres">La Vallée des dirigeables</h1>
        <?php

        include("../Models/database.php");

        $attractionsVDD = requeteBdd("SELECT * FROM attraction WHERE id_univers in (SELECT id FROM univers WHERE nom='La Vallee des dirigeables');");
        foreach ($attractionsVDD as $row) {
            echo "<div class='attraction'><div class='text_attraction'><h3 class='titres'>" . htmlspecialchars($row['nom']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p><br>";
            echo "<p>Taille min. : " . htmlspecialchars($row['taille_cm']) . " cm - Statut : " . htmlspecialchars($row['statut']) . "</p></div>";
            echo "<img class='img_attractions' src='../Images/" . htmlspecialchars($row['url_img']) . "' alt='Photographie de " . htmlspecialchars($row['nom']) . "'></div>";
        }
        ?>
    </div>

    <div class="univers">
        <h1 class="titres">Le Quartier de l'Industrie</h1>
        <?php

        $attractionsQDI = requeteBdd("SELECT * FROM attraction WHERE id_univers in (SELECT id FROM univers WHERE nom='Le Quartier de l\'Industrie');");
        foreach ($attractionsQDI as $row) {
            echo "<div class='attraction'><div class='text_attraction'><h3 class='titres'>" . htmlspecialchars($row['nom']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p><br>";
            echo "<p>Taille min. : " . htmlspecialchars($row['taille_cm']) . " cm - Statut : " . htmlspecialchars($row['statut']) . "</p></div>";
            echo "<img class='img_attractions' src='../Images/" . htmlspecialchars($row['url_img']) . "' alt='Photographie de " . htmlspecialchars($row['nom']) . "'></div>";
        }
        ?>
    </div>

</body>

</html>