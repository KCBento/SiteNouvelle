<?php
session_start();
include "basededonnees.php";

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    
    // Supprimer uniquement si la nouvelle appartient à l'utilisateur connecté
    $stmt = $pdo->prepare("DELETE FROM nouvelles WHERE id = ? AND author_id = ?");
    if ($stmt->execute([$id, $_SESSION["id_utilisateur"]])) {
        // Optionnel : vous pouvez également supprimer le fichier PDF du serveur si nécessaire.
        header("Location: tableau_de_bord.php");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "Aucun identifiant spécifié.";
}
?>
