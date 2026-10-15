<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions - Le Colosse d'Helios</title>
    <link rel="stylesheet" href="colosse_helios.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA</p>
        <div id="section_nav">
            <a class="liens_nav" href="../accueil.php">ACCUEIL</a>
            <a class="liens_nav" href="../attractions.php">ATTRACTIONS</a>
            <a class="liens_nav" href="../horaires.php">HORAIRES</a>
            <a class="liens_nav" href="../tarifs.php">TARIFS</a>
            <a class="liens_nav" href="#">CONTACT</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div id="intro">
        <div id="text_intro">
            <h1>Le Colosse d'Helios</h1>
            <h2 class="titres">Osez monter dans le celebre train a vapeur du Dr. Victoria et faire face a sa derniere invention : Le Colosse d'Helios.</h2>
        </div>
    </div>

    <div id="infos">
        <h1 class="titres">Informations sur l'attraction</h1>
        <?php

        include("../../Models/database.php");

        $attractionsVDD = requeteBdd("SELECT * FROM attraction WHERE nom='Le Colosse d\'Helios';");
        $univers = requeteBdd("SELECT nom FROM univers WHERE id in (SELECT id_univers FROM attraction WHERE nom='Le Colosse d\'Helios');");
        foreach ($attractionsVDD as $row) {
            echo "<p><span>Nom : </span>" . htmlspecialchars($row['nom']);
            echo "<p><span>Description : </span>" . htmlspecialchars($row['description']);
            echo "<p><span>Statut : </span>" . htmlspecialchars($row['statut']);
            echo "<p><span>Taille minimale : </span>" . htmlspecialchars($row['taille_cm']) . " cm";
            echo "<p><span>Univers lié : </span>" . htmlspecialchars($univers[0]['nom']);
        }
        ?>
    </div>
</body>

</html>