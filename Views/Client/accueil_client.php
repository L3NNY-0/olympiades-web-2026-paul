<?php

session_start();

if (empty($_SESSION['connection']) || $_SESSION['connection'] !== true) {
    header('Location: connexion.php');
    exit;
}

try {
    $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");
} catch (PDOException $e) {

}

$pseudo = $_SESSION['prenom'] ?? $_SESSION['email'] ?? "user";

include("../../Models/database.php")

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>STEAMLANDIA - Compte client</title>
    <link rel="stylesheet" href="accueil_client.css">
</head>

<body>
    <nav id="mainNav">
        <p class="liens_nav">STEAMLANDIA - Compte client</p>
        <div id="section_nav">
            <a class="liens_nav" href="#">MES RESERVATIONS</a>
            <a class="liens_nav" href="billetterie.php">BILLETTERIE</a>
        </div>
        <!-- <button class="hamburger" id="hamburgerBtn">☰</button> -->
    </nav>

    <div class="univers">
        <h1 class="titres">Bon retour <?php echo $pseudo; ?> !</h1>
        <h2 class="titres">Mes réservations</h2>
        <?php

        $stmt = $db->prepare("SELECT * FROM billet WHERE user_id=:id;");
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
        $stmt->execute();

        $billets = $stmt->fetchAll();

        foreach ($billets as $row) {
            echo "<div class='billet'><h3 class='titres'>" . htmlspecialchars($row['type']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['date_util']) . "</p><br>";
            echo "<p>Prix : " . htmlspecialchars($row['prix']) . "</p></div>";
        }
        ?>
    </div>
</body>

</html>