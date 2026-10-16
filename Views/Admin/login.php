<?php
session_start();

$error = '';
$username = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=olympiade", $_POST['username'], $_POST['password']);

        $stmt = $db->prepare("SELECT username, password FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user[1])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            $_SESSION['password'] = $_POST['password'];

            header('Location: dashboard.php');
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
    <title>STEAMLANDIA - Administrateur</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div id="login">
        <div class="login-container">
            <h1>Espace Administrateur</h1>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Identifiant</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
        </div>
    </div>
</body>

</html>