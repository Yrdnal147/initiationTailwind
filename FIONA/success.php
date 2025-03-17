<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <style>
        /* Style général de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Conteneur du formulaire */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        /* Style du titre */
        h2 {
            text-align: center;
            color: #333;
        }

        /* Style des labels */
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        /* Style des champs de saisie */
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Style du bouton */
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        /* Effet au survol du bouton */
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION["email"]); ?> !</h2>
    <a href="logout.php">Déconnexion</a>
    </div>
</body>
</html>
