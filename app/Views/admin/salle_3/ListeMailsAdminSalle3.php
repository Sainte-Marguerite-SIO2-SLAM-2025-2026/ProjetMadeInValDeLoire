<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des mails</title>
    <?= link_tag('styles/salle_3/salle3_listeAdmin.css'); ?>
</head>
<body>
<div class="container">
    <h1>Liste des mails</h1>

    <?php if (session()->has('success')): ?>
        <div class="success"><?= session('success') ?></div>
    <?php endif ?>

    <a href="<?= base_url('Salle3/mails/create') ?>" class="btn btn-add">➕ Ajouter un mail</a>

    <table>
        <thead>
        <tr>
            <th>N°</th>
            <th>Expéditeur</th>
            <th>Objet</th>
            <th>Contenu</th>
            <th>Difficulté</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($mails)): ?>
            <tr>
                <td colspan="7" class="empty-state">
                    <p>📭 Aucun mail enregistré</p>
                    <a href="<?= base_url('salle_3/mails/create') ?>" class="btn btn-primary">Créer le premier mail</a>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($mails as $mail): ?>
                <tr>
                    <td><?= esc($mail['numero']) ?></td>
                    <td><?= esc($mail['expediteur']) ?></td>
                    <td><?= esc($mail['objet']) ?></td>
                    <td class="contenu-preview" title="<?= esc($mail['contenu']) ?>">
                        <?= esc(substr($mail['contenu'], 0, 50)) ?><?= strlen($mail['contenu']) > 50 ? '...' : '' ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $mail['difficulte'] ? esc($mail['difficulte']) : '-' ?>
                    </td>
                    <td>
                        <?php if ($mail['phishing'] == 1): ?>
                            <span class="badge badge-danger">Frauduleux</span>
                        <?php else: ?>
                            <span class="badge badge-success">Légitime</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="<?= base_url('Salle3/mails/edit/' . $mail['numero']) ?>" class="btn btn-warning"> ✏️ </a>
                        <a href="<?= base_url('Salle3/mails/delete/' . $mail['numero']) ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mail ?')"> 🗑️ </a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
        </tbody>
    </table>
</div>
</body>
</html>