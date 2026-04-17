<?php 
session_start();
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

if(isset($_POST['save'])) {
    $stmt = $cbd->prepare("UPDATE depenses SET montant = ?, description = ?, categorie_id = ?, date_depense = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$_POST['montant'], $_POST['description'], $_POST['categorie'], $_POST['date'], $_POST['id'], $_SESSION['user_id']]);
    header('Location: crud_depense.php');
    exit();
}

if(isset($_GET['id'])) {
    $stmt = $cbd->prepare("SELECT * FROM depenses WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $depense = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$depense) {
        echo "Depense introuvable";
        exit();
    }
} else {
    echo "ID de depense manquant";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Dépense - fintrack</title>
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
                <li><a href="crud_depense.php">Mes Dépenses</a></li>
                <li><a href="ajouter.php">Ajouter Dépense</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h1 class="form-title">Modifier la Dépense</h1>
        
        <?php if(isset($_POST['save'])): ?>
            <div class="alert alert-success">Dépense mise à jour avec succès!</div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $depense['id']; ?>">

            <div class="form-group">
                <label for="montant">Montant (Fr CFA)</label>
                <input type="number" id="montant" name="montant" value="<?php echo $depense['montant']; ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($depense['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <?php 
                    $stmt = $cbd->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $categories = $stmt->fetchAll();
                    foreach($categories as $lignes): 
                    ?>
                        <option value="<?php echo $lignes['id']; ?>" <?php if($lignes['id'] == $depense['categorie_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($lignes['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo $depense['date_depense']; ?>" required>
            </div>

            <button type="submit" name="save" class="btn btn-primary" style="width: 100%;">Enregistrer les modifications</button>
            <a href="crud_depense.php" class="btn" style="width: 100%; text-align: center; margin-top: 10px; background-color: #718096; color: white; text-decoration: none;">Annuler</a>
        </form>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>