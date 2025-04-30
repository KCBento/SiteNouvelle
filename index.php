<?php
session_start();
include "basededonnees.php";

$recherche = isset($_GET["recherche"]) ? trim($_GET["recherche"]) : "";

$sql = "SELECT nouvelles.*, utilisateurs.nom_utilisateur AS auteur 
        FROM nouvelles 
        JOIN utilisateurs ON nouvelles.author_id = utilisateurs.id 
        WHERE date_publication >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
if (!empty($recherche)) {
    $sql .= " AND (nouvelles.titre LIKE :recherche OR utilisateurs.nom_utilisateur LIKE :recherche)";
}
$sql .= " ORDER BY date_publication DESC";

$stmt = $pdo->prepare($sql);
if (!empty($recherche)) {
    $stmt->execute(["recherche" => "%{$recherche}%"]);
} else {
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil – Site de Nouvelles</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Site de Nouvelles</h1>
    <nav>
      <a href="index.php">Accueil</a>
      <?php if (isset($_SESSION["id_utilisateur"])): ?>
        <a href="tableau_de_bord.php">Tableau de bord</a>
        <a href="deconnexion.php">Déconnexion</a>
      <?php else: ?>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
      <?php endif; ?>
    </nav>
  </header>

  <main class="accueil-container">
    <h2>Dernières nouvelles de la semaine</h2>
    <form method="GET" class="search-form">
      <input
        type="text"
        name="recherche"
        placeholder="Rechercher par titre ou auteur"
        value="<?= htmlspecialchars($recherche) ?>"
      >
      <button type="submit" class="btn">Rechercher</button>
    </form>

    <div class="stories-list">
      <?php while ($ligne = $stmt->fetch()): ?>
        <div class="story-card">
          <h3>
            <?= htmlspecialchars($ligne['titre']); ?>
            <small>par <?= htmlspecialchars($ligne['auteur']); ?></small>
          </h3>
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
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

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
