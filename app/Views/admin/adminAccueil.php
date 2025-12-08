<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Tableau de bord</title>
    <?= link_tag('styles/admin/adminAccueil.css'); ?>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>🎯 Tableau de bord Admin</h1>
        <p>Bienvenue dans l'interface d'administration</p>
    </div>

    <div class="action-buttons">
        <?= anchor('gingembre/createUser', '➕ Créer un utilisateur', ['class' => 'btn-action btn-create']); ?>
        <?= anchor('gingembre/logout', '🚪 Se déconnecter', ['class' => 'btn-action btn-logout']); ?>
    </div>

    <div class="section-title">📚 Gestion des Salles</div>

    <div class="salles-grid">
        <?= anchor('gingembre/salle_1', '<div class="icon">🚪</div><h3>Salle 1</h3><p>Administration Salle 1</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/salle_2', '<div class="icon">🔐</div><h3>Salle 2</h3><p>Administration Salle 2</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/salle_3', '<div class="icon">🧩</div><h3>Salle 3</h3><p>Administration Salle 3</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/salle_4', '<div class="icon">📅</div><h3>Salle 4</h3><p>Administration Salle 4</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/salle_5', '<div class="icon">🎲</div><h3>Salle 5</h3><p>Administration Salle 5</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/salle_6', '<div class="icon">🌐</div><h3>Salle 6</h3><p>Administration Salle 6</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/quiz', '<div class="icon">❓</div><h3>Quiz</h3><p>Administration Quiz</p>', ['class' => 'salle-card']); ?>

        <?= anchor('gingembre/mascotte', '<div class="icon">🦊</div><h3>Mascotte</h3><p>Administration Mascotte</p>', ['class' => 'salle-card']); ?>
    </div>
</div>
</body>
</html>