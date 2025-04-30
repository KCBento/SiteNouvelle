<?php
session_start();
include "basededonnees.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_utilisateur = trim($_POST["nom_utilisateur"]);
    $mot_de_passe = $_POST["mot_de_passe"];
    
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->execute([$nom_utilisateur]);
    $utilisateur = $stmt->fetch();
    
    if ($utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
        $_SESSION["id_utilisateur"] = $utilisateur["id"];
        $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];
        header("Location: tableau_de_bord.php");
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Site de Nouvelles</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Connexion</h1>
    <nav>
      <a href="index.php">Accueil</a>
      <a href="inscription.php">Inscription</a>
    </nav>
  </header>
  <main>
    <form method="POST" action="connexion.php">
      <label>Nom d'utilisateur :</label>
      <input type="text" name="nom_utilisateur" required><br>
      
      <label>Mot de passe :</label>
      <input type="password" name="mot_de_passe" required><br>
      
      <button type="submit">Se connecter</button>
    </form>
  </main>
  <footer>
    <p>&copy; 2024 - Site de Nouvelles</p>
  </footer>
</body>
</html>
