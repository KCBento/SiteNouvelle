<?php
session_start();
include "basededonnees.php";

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: connexion.php");
    exit();
}

$id_utilisateur = $_SESSION["id_utilisateur"];
$stmt = $pdo->prepare("SELECT * FROM nouvelles WHERE author_id = ? ORDER BY date_publication DESC");
$stmt->execute([$id_utilisateur]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord – Site de Nouvelles</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Tableau de bord</h1>
    <nav>
      <a href="index.php">Accueil</a>
      <a href="deconnexion.php">Déconnexion</a>
    </nav>
  </header>

  <main class="dashboard-container">
    <h2>Ajouter une nouvelle</h2>
    <form method="POST"
          enctype="multipart/form-data"
          action="televersement.php"
          class="upload-form"
          autocomplete="off"
    >
      <label for="title">Titre :</label><br>
      <input type="text" name="title" id="title" required placeholder="Titre de la nouvelle"><br>

      <label for="pdf">Fichier PDF :</label><br>
      <input type="file" name="pdf" id="pdf" accept="application/pdf" required><br>

      <iframe id="pdfPreview"
              title="Aperçu du PDF avant téléversement"
              style="display:none; width:100%; height:200px; margin:10px 0;">
      </iframe>

      <button type="submit" class="btn">Uploader</button>
    </form>

    <h2>Mes nouvelles</h2>
    <div class="stories-list">
      <?php while ($ligne = $stmt->fetch()): ?>
        <div class="story-card">
          <h3><?= htmlspecialchars($ligne['titre']); ?></h3>
          <iframe
            src="televersements/<?= htmlspecialchars($ligne['fichier']); ?>"
            title="<?= htmlspecialchars($ligne['titre']); ?>"
            width="100%" height="200px"
          ></iframe>
          <div class="story-actions">
            <button
              class="btn enlarge-btn"
              data-pdf="televersements/<?= htmlspecialchars($ligne['fichier'], ENT_QUOTES) ?>"
            >Agrandir</button>
            <a href="televersements/<?= htmlspecialchars($ligne['fichier']); ?>"
               download class="btn">Télécharger</a>
            <a href="supprimer_nouvelle.php?id=<?= $ligne['id']; ?>"
               class="btn delete">Supprimer</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <!-- Modal plein écran -->
  <div id="previewModal" class="modal">
    <div class="modal-inner">
      <span id="modalClose" class="close">&times;</span>
      <iframe id="modalContent"
              class="modal-content"
              title="Prévisualisation de la nouvelle">
      </iframe>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 – Site de Nouvelles</p>
  </footer>




  <script src="/scprits.js"></script>

  <div id="previewModal" class="modal">
  <div class="modal-inner">
    <span id="modalClose" class="close">&times;</span>
    <iframe id="modalContent" class="modal-content" title="Prévisualisation en plein écran"></iframe>
  </div>
</div>

</body>
</html>
