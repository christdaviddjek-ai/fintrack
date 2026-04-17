<?php 
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$sql1 = "SELECT SUM(montant) FROM depenses WHERE user_id = ? AND MONTH(date_depense)=MONTH(NOW()) AND YEAR(date_depense)=YEAR(NOW())";
$stmt = $cbd->prepare($sql1);
$stmt->execute([$_SESSION['user_id']]);
$total_depenses = $stmt->fetchColumn() ?? 0;

$sql2 = "SELECT MAX(montant) FROM depenses WHERE user_id = ? AND MONTH(date_depense)=MONTH(NOW()) AND YEAR(date_depense)=YEAR(NOW())";
$stmt = $cbd->prepare($sql2);
$stmt->execute([$_SESSION['user_id']]);
$depense_sup = $stmt->fetchColumn() ?? 0;

$stmt = $cbd->prepare("SELECT revenu_mensuel FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$revenu = $stmt->fetchColumn() ?? 0;

$pourcentage_utilise = ($revenu > 0) ? ($total_depenses / $revenu) * 100 : 0;
$alerte_budget       = ($pourcentage_utilise > 80);

$stmt = $cbd->prepare("SELECT categories.nom, SUM(montant) as total FROM depenses JOIN categories ON depenses.categorie_id = categories.id WHERE user_id = ? GROUP BY categorie_id");
$stmt->execute([$_SESSION['user_id']]);
$repart = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord — fintrack</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="logo" href="dashbordd.php">💰 fin<span>track</span></a>
            <div class="hamburger">
                <span></span><span></span><span></span>
            </div>
            <ul class="nav-links">
                <li><a href="dashbordd.php" class="active">Tableau de bord</a></li>
                <li><a href="crud_depense.php">Mes dépenses</a></li>
                <li><a href="ajouter.php">+ Ajouter</a></li>
                <li><a href="profil.php">Mon Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top: 40px; padding-bottom: 60px;">

        <!-- En-tête page -->
        <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <h1 style="font-family:var(--font-display); font-size:28px; font-weight:800; color:var(--ink); letter-spacing:-0.8px;">
                    Bonjour, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> 👋
                </h1>
                <p style="color:var(--text-secondary); font-size:14px; margin-top:4px;">
                    Voici votre résumé du mois
                </p>
            </div>
            <a href="ajouter.php" class="btn btn-primary">+ Ajouter une dépense</a>
        </div>

        <!-- Alertes budget -->
        <?php if ($revenu > 0 && $total_depenses > 0): ?>
            <?php if ($total_depenses > $revenu): ?>
                <div class="alert alert-error" style="margin-bottom:24px;">
                    🚨 <strong>Budget dépassé !</strong> Vous avez dépassé votre budget de
                    <strong><?php echo number_format($total_depenses - $revenu, 2); ?> Fr</strong> ce mois-ci.
                </div>
            <?php elseif ($alerte_budget): ?>
                <div class="alert alert-warning" style="margin-bottom:24px;">
                    ⚠️ <strong>Attention !</strong> Vous avez utilisé
                    <strong><?php echo number_format($pourcentage_utilise, 1); ?>%</strong> de votre budget mensuel.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Stats cards -->
        <div class="dashboard-container">
            <div class="stat-card success">
                <div class="stat-icon">💸</div>
                <div class="stat-label">Total ce mois</div>
                <div class="stat-value"><?php echo number_format($total_depenses, 2); ?> Fr</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-icon">📈</div>
                <div class="stat-label">Dépense la plus haute</div>
                <div class="stat-value"><?php echo number_format($depense_sup, 2); ?> Fr</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon">🏷️</div>
                <div class="stat-label">Catégories actives</div>
                <div class="stat-value"><?php echo count($repart); ?></div>
            </div>

            <div class="stat-card info">
                <div class="stat-icon">💰</div>
                <div class="stat-label">Revenu mensuel</div>
                <div class="stat-value"><?php echo number_format($revenu, 2); ?> Fr</div>
            </div>

            <div class="stat-card <?php echo ($pourcentage_utilise > 80) ? 'warning' : 'success'; ?>">
                <div class="stat-icon">✅</div>
                <div class="stat-label">Budget restant</div>
                <div class="stat-value"><?php echo number_format(max(0, $revenu - $total_depenses), 2); ?> Fr</div>
            </div>
        </div>

        <!-- Graphique répartition -->
        <div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:28px; box-shadow:var(--shadow-sm); margin-bottom:32px;">
            <h2 style="font-family:var(--font-display); font-size:18px; font-weight:700; color:var(--ink); letter-spacing:-0.3px; margin-bottom:24px;">
                Répartition par catégorie
            </h2>

            <?php if (count($repart) > 0): ?>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:36px; align-items:center;">
                    <div style="max-height:280px; display:flex; align-items:center; justify-content:center;">
                        <canvas id="repartitionChart"></canvas>
                    </div>
                    <div>
                        <ul style="list-style:none;">
                            <?php foreach ($repart as $row): ?>
                                <li style="padding:10px 0; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border);">
                                    <span style="font-weight:500; font-size:14px; color:var(--text-primary);">
                                        <?php echo htmlspecialchars($row['nom']); ?>
                                    </span>
                                    <span style="font-weight:700; font-size:14px; color:var(--emerald-dark);">
                                        <?php echo number_format($row['total'] ?? 0, 2); ?> Fr
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <script>
                    const ctx = document.getElementById('repartitionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: [<?php echo "'" . implode("', '", array_map(fn($r) => htmlspecialchars($r['nom']), $repart)) . "'"; ?>],
                            datasets: [{
                                data: [<?php echo implode(', ', array_map(fn($r) => $r['total'] ?? 0, $repart)); ?>],
                                backgroundColor: ['#00c78c','#3b82f6','#ff4d6d','#ffaa00','#a855f7','#06b6d4','#f97316','#84cc16'],
                                borderColor: '#ffffff',
                                borderWidth: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            cutout: '62%',
                            plugins: {
                                legend: { display: true, position: 'bottom', labels: { font: { size: 12 }, padding: 16 } }
                            }
                        }
                    });
                </script>

            <?php else: ?>
                <div style="text-align:center; padding:40px 0; color:var(--text-muted);">
                    <div style="font-size:40px; margin-bottom:12px;">📭</div>
                    <p>Aucune dépense pour le moment.</p>
                    <a href="ajouter.php" class="btn btn-primary" style="margin-top:16px;">Ajouter une dépense</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- CTA voir toutes dépenses -->
        <div style="text-align:center;">
            <a href="crud_depense.php" class="btn btn-outline btn-lg">Voir toutes mes dépenses →</a>
        </div>

    </div>

    <footer class="footer">
        <div class="container">
            <p>© 2026 <strong>fintrack</strong>. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
