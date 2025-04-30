<?php
session_start();
include "basededonnees.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_utilisateur = trim($_POST["nom_utilisateur"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe) VALUES (?, ?, ?)");
    if ($stmt->execute([$nom_utilisateur, $email, $mot_de_passe])) {
        header("Location: connexion.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Site de Nouvelles</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Inscription</h1>
    <nav>
      <a href="index.php">Accueil</a>
      <a href="connexion.php">Connexion</a>
    </nav>
  </header>

  <main class="form-container">
    <form method="POST" action="inscription.php" class="inscription-form">
      <h2>Créer un compte</h2>

      <label for="nom_utilisateur">Nom d'utilisateur :</label>
      <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>

      <label for="email">Email :</label>
      <input type="email" name="email" id="email" required>

      <label for="mot_de_passe">Mot de passe :</label>
      <input type="password" name="mot_de_passe" id="mot_de_passe" required>

      <div class="checkbox-container">
        <input type="checkbox" id="cgu" required>
        <label for="cgu">J'accepte les <a href="cgu.php">conditions générales d'utilisation</a></label>
      </div>

      <button type="submit" class="btn">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
  </main>

  <footer>
    <p>&copy; 2024 - Site de Nouvelles</p>
  </footer>
</body>
</html>
