
<?php 
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])) {
    header('Location : connexion.php');
    exit();
}

if(isset($_POST['save'])) {
    $montant = $_POST['montant'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];

    
    $stmt = $cbd->prepare("INSERT INTO depenses (user_id, montant, description, categorie_id, date_depense) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $montant, $description, $categorie, $_POST['date']]);



}


$stmt = $cbd->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Dépense - fintrack</title>
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
                <li><a href="ajouter.php" class="active">Ajouter Dépense</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h1 class="form-title">Ajouter une Dépense</h1>
        
        <?php if(isset($_POST['save'])): ?>
            <div class="alert alert-success">Dépense enregistrée avec succès!</div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="montant">Montant (Fr CFA)</label>
                <input type="number" id="montant" name="montant" placeholder="Ex: 25000 Fr" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Décrivez votre dépense..." required></textarea>
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="">-- Sélectionner une catégorie --</option>
                    <?php foreach($categories as $lignes): ?>
                        <option value="<?php echo $lignes['id']; ?>">
                            <?php echo htmlspecialchars($lignes['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Date de la dépense</label>
                <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" name="save" class="btn btn-primary" style="width: 100%;">Enregistrer la Dépense</button>
            <a href="crud_depense.php" class="btn" style="width: 100%; text-align: center; margin-top: 10px; background-color: #718096; color: white; text-decoration: none;">Annuler</a>
        </form>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>