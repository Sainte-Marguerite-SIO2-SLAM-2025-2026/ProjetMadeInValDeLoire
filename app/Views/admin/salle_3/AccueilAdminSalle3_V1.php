<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend - Gestion des Mails</title>
    <?= link_tag('styles/salle_3/salle3_accueilAdmin.css') ?>
</head>
<body>
<div class="container">
    <h1>🎯 Backend - Gestion des Mails</h1>
    <p class="subtitle">Salle 3 - Administration de la base de données</p>

    <div class="actions-grid">
        <a href="<?= base_url('Salle3/mails/create') ?>" class="action-card add">
            <span class="icon">➕</span>
            <div class="action-title">Ajouter</div>
            <div class="action-description">Créer un nouveau mail dans la base de données</div>
        </a>

        <a href="<?= base_url('Salle3/mails') ?>" class="action-card view">
            <span class="icon">📋</span>
            <div class="action-title">Afficher</div>
            <div class="action-description">Voir tous les mails enregistrés</div>
        </a>

        <a href="<?= base_url('salle_3/mails/list-edit') ?>" class="action-card edit">
            <span class="icon">✏️</span>
            <div class="action-title">Modifier</div>
            <div class="action-description">Éditer les mails existants</div>
        </a>

        <a href="<?= base_url('salle_3/mails/list-delete') ?>" class="action-card delete">
            <span class="icon">🗑️</span>
            <div class="action-title">Supprimer</div>
            <div class="action-description">Effacer des mails de la base</div>
        </a>
    </div>
</div>
</body>
</html>