<?php 
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$query = "SELECT depenses.*, categories.nom FROM depenses JOIN categories ON depenses.categorie_id = categories.id WHERE depenses.user_id = ?";
$params = [$_SESSION['user_id']];

if(isset($_GET['categorie']) && $_GET['categorie'] !== '') {
    $query .= " AND depenses.categorie_id = ?";
    $params[] = (int)$_GET['categorie'];
}

if(isset($_GET['mois']) && $_GET['mois'] !== '') {
    $mois_parts = explode('-', $_GET['mois']);
    if(count($mois_parts) == 2) {
        $annee = (int)$mois_parts[0];
        $mois = (int)$mois_parts[1];
        $query .= " AND EXTRACT(YEAR FROM depenses.date_depense) = ? AND EXTRACT(MONTH FROM depenses.date_depense) = ?";
        $params[] = $annee;
        $params[] = $mois;
    }
}

$query .= " ORDER BY depenses.date_depense DESC";

$stmt = $cbd->prepare($query);
$stmt->execute($params);
$depenses = $stmt->fetchAll();

$stmt = $cbd->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Dépenses - fintrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">💰 fintrack</div>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="dashbordd.php">Tableau de Bord</a></li>
                <li><a href="crud_depense.php" class="active">Mes Dépenses</a></li>
                <li><a href="ajouter.php">Ajouter Dépense</a></li>
                <li><a href="profil.php">Mon Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 40px;">
        <div class="table-container">
            <div class="table-header">
                <h2>Mes Dépenses</h2>
                <a href="ajouter.php" class="btn btn-primary">+ Ajouter Dépense</a>
            </div>

            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="filter-group-item">
                        <label for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie">
                            <option value="">Toutes les catégories</option>
                            <?php foreach($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id']; ?>" <?php if(isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($categorie['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group-item">
                        <label for="mois">Mois</label>
                        <input type="month" name="mois" id="mois" value="<?php echo isset($_GET['mois']) ? htmlspecialchars($_GET['mois']) : ''; ?>">
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
                        <a href="crud_depense.php" class="btn btn-secondary btn-sm">Réinitialiser</a>
                    </div>
                </form>
            </div>

            <?php if(count($depenses) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Montant</th>
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($depenses as $row): ?>
                            <tr>
                                <td style="font-weight: bold; color: #667eea;"><?php echo number_format($row['montant'], 2); ?> Fr</td>
                                <td>
                                    <span style="background-color: #ebf8ff; color: #2c5282; padding: 4px 8px; border-radius: 4px; font-size: 14px;">
                                        <?php echo htmlspecialchars($row['nom']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)); ?><?php echo strlen($row['description']) > 50 ? '...' : ''; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['date_depense'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="modifier.php?id=<?php echo $row['id']; ?>" class="btn-edit">✎ Modifier</a>
                                        <a href="supprimer.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense?');">🗑 Supprimer</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 40px; text-align: center; color: #718096;">
                    <p style="font-size: 18px; margin-bottom: 20px;">Aucune dépense trouvée</p>
                    <a href="ajouter.php" class="btn btn-primary">Ajouter votre première dépense</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
    <script>
        // Auto-submit du formulaire au changement de filtre
        document.getElementById('categorie').addEventListener('change', function() {
            document.querySelector('.filter-form').submit();
        });
        
        document.getElementById('mois').addEventListener('change', function() {
            document.querySelector('.filter-form').submit();
        });
    </script>
</body>
</html>