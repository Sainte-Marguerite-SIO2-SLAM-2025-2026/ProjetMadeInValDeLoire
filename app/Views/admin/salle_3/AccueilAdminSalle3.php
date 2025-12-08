<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un mail</title>
    <?= link_tag('styles/salle_3/salle3_admin.css'); ?>
</head>

<body>
<div class="container">
    <h1>Ajouter un nouveau mail</h1>

    <?php if (session()->has('errors')): ?>
        <div class="errors">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url('gingembre/salle_3/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="expediteur">Expéditeur <span class="required">*</span></label>
            <input type="text" id="expediteur" name="expediteur" value="<?= old('expediteur') ?>" maxlength="50" required placeholder="exemple@domaine.com">
        </div>

        <div class="form-group">
            <label for="objet">Objet <span class="required">*</span></label>
            <input type="text" id="objet" name="objet" value="<?= old('objet') ?>" maxlength="100" required placeholder="Objet du mail">
        </div>

        <div class="form-group">
            <label for="contenu">Contenu <span class="required">*</span></label>
            <textarea id="contenu" name="contenu" required placeholder="Contenu du mail..."><?= old('contenu') ?></textarea>
        </div>

        <div class="form-group">
            <label for="difficulte">Difficulté (optionnel)</label>
            <input type="number" id="difficulte" name="difficulte" value="<?= old('difficulte') ?>" min="1" max="10" placeholder="De 1 à 10">
        </div>

        <div class="form-group">
            <label for="phishing">Type <span class="required">*</span></label>
            <select id="phishing" name="phishing" required>
                <option value="">-- Sélectionner le type --</option>
                <option value="0" <?= old('phishing') === '0' ? 'selected' : '' ?>>Légitime</option>
                <option value="1" <?= old('phishing') === '1' ? 'selected' : '' ?>>Frauduleux (Phishing)</option>
            </select>
        </div>

        <div>
            <button type="submit">Enregistrer</button>
            <a href="<?= base_url('gingembre') ?>"><button type="button" class="btn-secondary">Retour</button></a>
        </div>
    </form>
</div>
</body>
</html>