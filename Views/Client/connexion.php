<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=olympiade", "visiteur", "visiteur");

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1;");
        $stmt->bindParam(':username', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user[2])) {
            session_regenerate_id(true);
            $_SESSION['connection'] = true;
            $_SESSION['password'] = $_POST['password'];

            if (!is_null($user[3]) && !is_null($user[4])) {
                $_SESSION['nom'] = $user[3];
                $_SESSION['prenom'] = $user[4];
            }

            header('Location: accueil.php');
            exit;
        } else {
            $error = 'Identifiants incorrects.';
        }
    } catch (PDOException $e) {
        $error = 'Connexion impossible. Veuillez réessayer plus tard.';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEAMLANDIA - Compte client</title>
    <link rel="stylesheet" href="connexion.css">
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
            <h2>Bon retour !</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="connexion.php">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
            <p><a id="lien_inscr" href="inscription.php">Pas de compte ? Inscrivez-vous !</a></p>
        </div>
    </div>
</body>

</html>