<?php 
session_start();
include 'config.php';


if(!isset($_SESSION['user_id'])) {
    header('Location : connexion.php');
    exit();
}

$sql1 = "SELECT SUM(montant) FROM depenses WHERE user_id = ? AND EXTRACT(MONTH FROM date_depense)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(YEAR FROM date_depense) = EXTRACT(YEAR FROM NOW())";
$stmt=$cbd->prepare(convertSQL($sql1, $db_type));
$stmt->execute([$_SESSION['user_id']]);
$total_depenses = $stmt->fetchColumn();

$sql2 = "SELECT MAX(montant) FROM depenses WHERE  user_id = ? AND EXTRACT(MONTH FROM date_depense)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(YEAR FROM date_depense) = EXTRACT(YEAR FROM NOW())";
$stmt=$cbd->prepare(convertSQL($sql2, $db_type));
$stmt->execute([$_SESSION['user_id']]);
$depense_sup = $stmt->fetchColumn();

$stmt=$cbd->prepare("SELECT revenu_mensuel FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$revenu = $stmt->fetchColumn() ?? 0;

$pourcentage_utilise = ($revenu > 0) ? ($total_depenses / $revenu) * 100 : 0;
$alerte_budget = ($pourcentage_utilise > 80);

$stmt=$cbd->prepare("SELECT categories.nom, SUM(montant) FROM depenses  JOIN categories ON depenses.categorie_id = categories.id  WHERE user_id = ? GROUP BY categorie_id   ");
$stmt->execute([$_SESSION['user_id']]);
$repart=$stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - fintrack</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <li><a href="dashbordd.php" class="active">Tableau de Bord</a></li>
                <li><a href="crud_depense.php">Mes Dépenses</a></li>
                <li><a href="ajouter.php">Ajouter Dépense</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> 👋</h1>
        </div>

        <?php if($revenu > 0 && $total_depenses > 0): ?>
            <?php if($total_depenses > $revenu): ?>
                <div class="alert alert-danger" style="margin-bottom: 30px;">
                    <strong>🚨 Dépassement Budget!</strong> Vous avez dépassé votre budget de <strong><?php echo number_format($total_depenses - $revenu, 2); ?> €</strong>
                </div>
            <?php elseif($alerte_budget): ?>
                <div class="alert alert-warning" style="margin-bottom: 30px;">
                    <strong>⚠️ Attention Budget!</strong> Vous avez utilisé <strong><?php echo number_format($pourcentage_utilise, 1); ?>%</strong> de votre budget mensuel.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="dashboard-container">
            <div class="stat-card success">
                <div class="stat-label">Total Mensuel</div>
                <div class="stat-value"><?php echo number_format($total_depenses ?? 0, 2); ?> €</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-label">Dépense la Plus Haute</div>
                <div class="stat-value"><?php echo number_format($depense_sup ?? 0, 2); ?> €</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-label">Nombre de Catégories</div>
                <div class="stat-value"><?php echo count($repart); ?></div>
            </div>

            <div class="stat-card success">
                <div class="stat-label">Revenu Mensuel</div>
                <div class="stat-value"><?php echo number_format($revenu, 2); ?> €</div>
            </div>

            <div class="stat-card <?php echo ($pourcentage_utilise > 80) ? 'warning' : 'success'; ?>">
                <div class="stat-label">Budget Restant</div>
                <div class="stat-value"><?php echo number_format(max(0, $revenu - $total_depenses), 2); ?> €</div>
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 40px;">
            <h2 style="margin-bottom: 30px;">Répartition par Catégorie</h2>
            
            <?php if(count($repart) > 0): ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
                    <div>
                        <canvas id="repartitionChart"></canvas>
                    </div>
                    <div>
                        <ul style="list-style: none;">
                            <?php foreach($repart as $row): ?>
                                <li style="padding: 10px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0;">
                                    <span style="font-weight: 600;"><?php echo htmlspecialchars($row['nom']); ?></span>
                                    <span style="color: #667eea; font-weight: bold;"><?php echo number_format($row['SUM(montant)'] ?? 0, 2); ?> €</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <script>
                    const ctx = document.getElementById('repartitionChart').getContext('2d');
                    const repartitionData = {
                        labels: [<?php echo "'" . implode("', '", array_map(function($r) { return htmlspecialchars($r['nom']); }, $repart)) . "'"; ?>],
                        datasets: [{
                            label: 'Montant (€)',
                            data: [<?php echo implode(', ', array_map(function($r) { return $r['SUM(montant)'] ?? 0; }, $repart)); ?>],
                            backgroundColor: [
                                '#667eea',
                                '#764ba2',
                                '#f093fb',
                                '#4facfe',
                                '#43e97b',
                                '#fa709a',
                                '#fee140',
                                '#30cfd0'
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    };

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: repartitionData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                </script>
            <?php else: ?>
                <p style="text-align: center; color: #718096;">Aucune dépense pour le moment. <a href="ajouter.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Ajouter une dépense</a></p>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-bottom: 40px;">
            <a href="crud_depense.php" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">Voir toutes les dépenses</a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 fintrack. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>