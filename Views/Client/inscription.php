<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");

        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mdp = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $db->prepare("INSERT INTO users (username, password, nom, prenom) VALUES (:mail, :mdp, :nom, :prenom);");
        $stmt->bindParam(':mail', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->execute();

        $error = "INSERT INTO users (username, password) VALUES ($email, $mdp);";

        header('Location: connexion.php');
        exit;

    } catch (PDOException $e) {
        $error = 'Un compte existe déjà à cette adresse mail. Veuillez en essayer une autre.';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEAMLANDIA - Compte client</title>
    <link rel="stylesheet" href="inscription.css">
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

    <div class="gear gear-left">
        <img class="icones" src="../../Images/gear.png">
    </div>

    <div class="gear gear-right">
        <img class="icones" src="../../Images/gear.png">
    </div>

    <div id="login">
        <div class="login-container">
            <h1>Espace Client</h1>
            <h2>Bienvenue !</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="inscription.php">
                <div class="form-group">
                    <label for="nom">Nom (optionnel)</label>
                    <input type="text" name="nom">
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom (optionnel)</label>
                    <input type="text" name="prenom">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" minlength="12" required>
                </div>

                <button type="submit" class="submit-btn">S'inscrire</button>
            </form>
            <p><a id="lien_conn" href="connexion.php">Déjà un compte ? Connectez-vous !</a></p>
        </div>
    </div>
</body>

</html>