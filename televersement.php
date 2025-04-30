<?php
session_start();
include "basededonnees.php";

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

// Traitement de l'upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Vérifier que le champ 'pdf' existe
    if (!isset($_FILES["pdf"])) {
        die("Aucun fichier détecté dans la requête.");
    }

    // Vérifier l'erreur d'upload
    if ($_FILES["pdf"]["error"] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload : Code " . $_FILES["pdf"]["error"]);
    }

    // Récupérer le titre et le fichier
    $titre   = trim($_POST["title"]);
    $fichier = $_FILES["pdf"];

    // Vérifier le type MIME avec finfo pour plus de fiabilité
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $fichier["tmp_name"]);
    finfo_close($fileInfo);

    if ($mimeType !== "application/pdf") {
        die("Seuls les fichiers PDF sont autorisés. Type détecté : " . htmlspecialchars($mimeType));
    }

    // Générer un nom unique pour éviter les collisions
    $nom_fichier = time() . "_" . basename($fichier["name"]);
    $destination = "televersements/" . $nom_fichier;

    // Déplacer le fichier uploadé vers le dossier 'televersements'
    if (move_uploaded_file($fichier["tmp_name"], $destination)) {
        // Insérer la nouvelle en base
        $stmt = $pdo->prepare(
            "INSERT INTO nouvelles (titre, fichier, author_id) VALUES (?, ?, ?)"
        );
        if ($stmt->execute([$titre, $nom_fichier, $_SESSION["id_utilisateur"]])) {
            header("Location: tableau_de_bord.php");
            exit();
        } else {
            echo "Erreur lors de l'enregistrement en base de données.";
        }
    } else {
        echo "Erreur lors du déplacement du fichier.";
    }

} else {
    echo "Aucune requête POST reçue.";
}
?>
