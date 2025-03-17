<?php
session_start();
$conn = new mysqli("localhost", "root", "", "utilisateur");

// Vérifier si la connexion à la base de données fonctionne
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Vérifier le format de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Format d'email invalide";
        header("Location: inscription.php");
        exit();
    }

    // Vérifier la longueur du mot de passe
    if (strlen($password) < 6) {
        $_SESSION["error"] = "Le mot de passe doit contenir au moins 6 caractères";
        header("Location: inscription.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier si l'email existe déjà
    $check_stmt = $conn->prepare("SELECT id FROM utilisateur WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION["error"] = "L'email existe déjà.";
        header("Location: inscription.php");
        exit();
    }
    $check_stmt->close();

    // Insérer le nouvel utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateur (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION["success"] = "Inscription réussie. Vous pouvez vous connecter.";
        header("Location: inscription.php");
    } else {
        $_SESSION["error"] = "Une erreur s'est produite. Veuillez réessayer.";
        header("Location: inscription.php");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Inscription</h2>

        <?php if (isset($_SESSION["error"])) { ?>
            <p class="error"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION["success"])) { ?>
            <p class="success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></p>
        <?php } ?>

        <form action="inscription.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>

        <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
    </div>
</body>
</html>
