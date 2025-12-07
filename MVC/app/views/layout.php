<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Parc Activités' ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>/css/style.css">
</head>
<body>

<header>
    <h1>RÉSERVATION ACTIVITÉS</h1>
    <nav class="nav">
        <a href="<?= $base_url ?>/">Activités</a>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="<?= $base_url ?>/reservation">Mes réservations</a>
            
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="<?= $base_url ?>/reservation/list">Toutes les réservations</a>
                <a href="<?= $base_url ?>/user">Utilisateurs</a>
            <?php endif; ?>
            
            <span style="margin-left: 20px; color: #666;">
                Bonjour, <?= htmlspecialchars($_SESSION['user']['prenom']) ?>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <span style="color: #e74c3c; font-weight: bold;">(Admin)</span>
                <?php endif; ?>
            </span>
            <a href="<?= $base_url ?>/user/logout">Déconnexion</a>
        <?php else: ?>
            <a href="<?= $base_url ?>/user/login">Connexion</a>
            <a href="<?= $base_url ?>/user/register">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?= $content ?> 
</main>

</body>
</html>