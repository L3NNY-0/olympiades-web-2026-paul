<?php

session_start();

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../login.php');
    exit;
}

include("../../../Models/database.php");

$error = '';

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


        $nom = $_POST['nom'];
        $stmtAnciennesValeurs = $db->prepare("SELECT * FROM attraction WHERE nom = ?");
        $stmtAnciennesValeurs->execute([$nom]);
        $anciennes_valeurs = $stmtAnciennesValeurs->fetch(PDO::FETCH_ASSOC);

        $past_desc = $anciennes_valeurs['description'];
        $past_statut = $anciennes_valeurs['statut'];
        $past_taille = $anciennes_valeurs['taille_cm'];
        $past_img = $anciennes_valeurs['url_img'];

        $img_attraction = $anciennes_valeurs['url_img'];
        if (isset($_FILES['url_img']['name']) && !empty($_FILES['url_img']['name'])) {
            $img_attraction = substr($_FILES['url_img']['name'], 0, -4);
        }

        $past_univers = $anciennes_valeurs['id_univers'];

        $description = $_POST['description'] ?? $past_desc;
        if (empty($_POST['description'])) {
            $description = $past_desc;
        }

        $statut = $statut ?? $past_statut;

        $taille_cm = $_POST['taille_min'] ?? $past_taille;
        if (empty($_POST['taille_min'])) {
            $taille_cm = $past_taille;
        }

        $id_univers = requeteBdd("SELECT id FROM univers WHERE nom='" . str_replace("'", "\'", $_POST['univers']) . "';");

        $stmt = $db->prepare("UPDATE attraction SET description=:description, statut=:statut, taille_cm=:taille_cm, url_img=:url_img, id_univers=:id_univers WHERE nom=:nom;");
        $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_INT);
        $stmt->bindParam(':taille_cm', $_POST['taille_min'], PDO::PARAM_INT);
        $stmt->bindParam(':url_img', $img_attraction, PDO::PARAM_STR);
        $stmt->bindParam(':id_univers', $id_univers[0]['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->execute();

        $filename = $img_attraction . '.png';

        $destination = "../../../Images/" . $filename;

        if (file_exists($destination)) {
            $error = "Une image portant ce nom existe déjà.";
            header('Location: modif.php');
            exit;
        }

        if (!move_uploaded_file($_FILES['url_img']['tmp_name'], $destination)) {
            $error = "Impossible d'enregistrer l'image.";
            header('Location: modif.php');
            exit;
        }

        header('Location: modif.php');
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
    <link rel="stylesheet" href="modif.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Administrateur</p>
        <div id="section_nav">
            <a class="liens_nav" href="../dashboard.php">SUPERVISION</a>
            <a class="liens_nav" href="../Ajout/ajout.php">AJOUT</a>
            <a class="liens_nav" href="#">MODIFICATION</a>
            <a class="liens_nav" href="../Suppression/suppr.php">SUPPRESSION</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <div id="contenu">
            <div id="bandeau_modif">
                <h1 class="titres">Modifier une attraction</h1>
                <p><?php if ($error) {
                        echo $error;
                    } ?></p>
            </div>

            <form method="POST" action="modif.php" enctype="multipart/form-data">
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

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description">
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
                    <input type="number" name="taille_min">
                </div>

                <div class="form-group">
                    <label for="url_img">Image de présentation</label>
                    <input type="file" name="url_img">
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

                <button type="submit" class="submit-btn">Modifier</button>
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