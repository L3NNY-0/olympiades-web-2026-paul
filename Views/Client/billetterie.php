<?php

session_start();

if (empty($_SESSION['connection']) || $_SESSION['connection'] !== true) {
    header('Location: connexion.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");

        $type = 1;
        $prix = 20;
        $id = $_SESSION['id'];
        $date = $_POST['date'];
        switch ($_POST['type']) {
            case 'Adulte >12ans (20 €)':
                $statut = 1;
                $prix = 20;
                break;

            case 'Enfant >3ans (15 €)':
                $type = 2;
                $prix = 15;
                break;

            case 'Junior <3ans (Gratuit)':
                $type = 3;
                $prix = 0;
                break;
        }

        echo "<p id='result'>INSERT INTO billet (type, prix, user_id, date_util) VALUES (" . $type . ", " . $prix . " , " . $id . ", " . $date . ");</p>";
        // $stmt = $db->prepare("INSERT INTO billet (type, prix, user_id, date_util) VALUES (:type, :prix, :user_id, :date_util);");
        // $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        // $stmt->bindParam(':prix', $prix, PDO::PARAM_INT);
        // $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        // $stmt->bindParam(':date_util', $date, PDO::PARAM_STR);
        // $stmt->execute();

        // header('Location: ajout.php');
        // exit;
    } catch (PDOException $e) {
    }
}

$pseudo = '';
$dateJour = date('Y-m-d');

include("../../Models/database.php")

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>STEAMLANDIA - Compte client</title>
    <link rel="stylesheet" href="billetterie.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Compte client</p>
        <div id="section_nav">
            <a class="liens_nav" href="accueil_client.php">MES RESERVATIONS</a>
            <a class="liens_nav" href="#">BILLETTERIE</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <h1 class="titres">Billetterie</h1>

        <form method="POST" action="billetterie.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" required>
                    <option>Adulte >12ans (20 €)</option>
                    <option>Enfant >3ans (15 €)</option>
                    <option>Junior <3ans (Gratuit)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" value="<?php echo $dateJour ?>" min="<?php echo $dateJour ?>" required>
            </div>

            <button type="submit" class="submit-btn">Réserver</button>
        </form>

    </div>
</body>

</html>