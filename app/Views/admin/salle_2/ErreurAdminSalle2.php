<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Responsive pour mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style dédiée à l'erreur Admin Salle 2 -->
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/Salle2Erreur.css') ?>">

    <title>Erreur - Administration</title>
</head>
<body>

<!-- Carte d'erreur principale -->
<div class="error-card">
    <!-- Icône d'avertissement -->
    <div class="error-icon">⚠️</div>

    <!-- Titre de la page -->
    <h1>Erreur d'enregistrement</h1>

    <!-- Message d'erreur injecté depuis le backend -->
    <p class="message"><?= esc($message) ?></p>

    <!-- Bloc détails techniques (affiché uniquement si disponible) -->
    <?php if(isset($details)): ?>
        <div class="details-container">
            <strong>Détails techniques :</strong><br>
            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 10px 0;">
            <?= esc($details) ?>
        </div>
    <?php endif; ?>

    <!-- Lien de retour vers l'administration de la Salle 2 -->
    <a href="<?= base_url('gingembre/salle/2') ?>" class="btn-back">
        ⬅ Retour
    </a>
</div>

</body>
</html>