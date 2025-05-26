<?php
session_start();
include "basededonnees.php";

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["contenu"])) {
    $stmt = $pdo->prepare("INSERT INTO commentaires (nouvelle_id, auteur_id, contenu) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST["nouvelle_id"],
        $_SESSION["id_utilisateur"],
        trim($_POST["contenu"])
    ]);
}

header("Location: index.php");
exit();
?>
