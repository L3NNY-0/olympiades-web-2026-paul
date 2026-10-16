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

        $statut = 1;
        switch ($_POST['statut']) {
            case 'Ouvert':
                $statut = 1;
                break;

            case 'Fermé':
                $statut = 2;
                break;

            case 'En panne':
                $statut = 3;
                break;
        }

        $img_attraction = substr($_FILES['url_img']['name'], 0, strlen($_FILES['url_img']['name']) - 4);
        $filename = $img_attraction . '.png';
        // $filename = $_FILES['url_img']['name'];
        $id_univers = requeteBdd("SELECT id FROM univers WHERE nom='" . str_replace("'", "\'", $_POST['univers']) . "';");

        $stmt = $db->prepare("INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES (:nom, :description, :statut, :taille_cm, :url_img, :id_univers);");
        $stmt->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_INT);
        $stmt->bindParam(':taille_cm', $_POST['taille_min'], PDO::PARAM_INT);
        $stmt->bindParam(':url_img', $img_attraction, PDO::PARAM_STR);
        $stmt->bindParam(':id_univers', $id_univers[0]['id'], PDO::PARAM_INT);
        $stmt->execute();

        $destination = "../../../Images/" . $filename;

        header('Location: ajout.php');
        exit;

        // echo "<p id='result'>INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES (" . $_POST['nom'] . ", " . $_POST['description'] . ", " . $statut . ", " . $_POST['taille_min'] . ", " . substr($_POST['url_img'], 0, strlen($_POST['url_img'])-4) . ", " . $id_univers[0]['id'] . ");</p>";
    } catch (PDOException $e) {
        echo "<p id='result'>" . $e . "</p>";
        $error = 'Connexion impossible. Veuillez réessayer plus tard.' . $e;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>STEAMLANDIA - Administrateur</title>
    <link rel="stylesheet" href="ajout.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Administrateur</p>
        <div id="section_nav">
            <a class="liens_nav" href="../dashboard.php">SUPERVISION</a>
            <a class="liens_nav" href="#">AJOUT</a>
            <a class="liens_nav" href="../Modification/modif.php">MODIFICATION</a>
            <a class="liens_nav" href="../Suppression/suppr.php">SUPPRESSION</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <div id="contenu">
            <h1 class="titres">Ajouter une nouvelle attraction</h1>

            <form method="POST" action="ajout.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" required>
                </div>

                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select name="statut" required>
                        <option>Ouvert</option>
                        <option>Fermé</option>
                        <option>En panne</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taille_min">Taille minimale (en cm)</label>
                    <input type="number" name="taille_min" required>
                </div>

                <div class="form-group">
                    <label for="url_img">Image de présentation</label>
                    <input type="file" name="url_img" required>
                </div>

                <div class="form-group">
                    <label for="univers">Univers lié</label>
                    <select name="univers" required>
                        <?php
                        try {
                            $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");

                            $stmt = $db->query("SELECT nom FROM univers;");

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option>' . htmlspecialchars($row['nom']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            $error = 'Connexion impossible. Veuillez réessayer plus tard.';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Ajouter</button>
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