<?php
session_start();
include "basededonnees.php";

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_GET["id"])) {
    $stmt = $pdo->prepare("DELETE FROM commentaires WHERE id = ? AND auteur_id = ?");
    $stmt->execute([$_GET["id"], $_SESSION["id_utilisateur"]]);
}

header("Location: index.php");
exit();
?>
