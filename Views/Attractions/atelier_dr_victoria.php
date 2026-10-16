<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions - Atelier de Dr. Victoria</title>
    <link rel="stylesheet" href="atelier_dr_victoria.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA</p>
        <div id="section_nav">
            <a class="liens_nav" href="../accueil.php">ACCUEIL</a>
            <a class="liens_nav" href="../attractions.php">ATTRACTIONS</a>
            <a class="liens_nav" href="../tarifs.php">TARIFS</a>
            <a class="liens_nav" href="#">COMPTE CLIENT</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div id="intro">
        <div id="text_intro">
            <h1>Atelier de Dr. Victoria</h1>
            <h2 class="titres">Plongez dans les coulisses de l'atelier de Dr. Victoria, une des meres fondatrices de la Cite.</h2>
        </div>
    </div>

    <div id="infos">
        <h1 class="titres">Informations sur l'attraction</h1>
        <?php

        include("../../Models/database.php");

        $attractionsVDD = requeteBdd("SELECT * FROM attraction WHERE nom='Atelier de Dr. Victoria';");
        $univers = requeteBdd("SELECT nom FROM univers WHERE id in (SELECT id_univers FROM attraction WHERE nom='Atelier de Dr. Victoria');");
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