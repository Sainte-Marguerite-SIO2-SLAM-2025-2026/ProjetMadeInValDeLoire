<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle_5/admin/modif.css'); ?>
    <title>Modifier</title>
</head>
<body>

<?php if ($section == 'objets'): ?>
    <?= form_open('admin/validerModifObjet', ['class' => 'form-objet']) ?>

    <h3>Modification de l'objet</h3>

    <!-- ID (non modifiable) -->
    <p><strong>ID :</strong> <?= esc($modifier->id) ?></p>
<?= form_hidden('id', $modifier->id) ?>

<hr>

    <!-- Nom -->
<?= form_label('Nom', 'nom') ?>
<?= form_input([
    'name'  => 'nom',
    'id'    => 'nom',
    'value' => $modifier->nom,
]) ?>

    <!-- Position -->
<?= form_label('Position X', 'x') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'x',
    'value' => $modifier->x,
]) ?>

<?= form_label('Position Y', 'y') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'y',
    'value' => $modifier->y,
]) ?>

    <!-- Dimensions -->
<?= form_label('Largeur', 'width') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'width',
    'value' => $modifier->width,
]) ?>

<?= form_label('Hauteur', 'height') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'height',
    'value' => $modifier->height,
]) ?>

    <!-- Image -->
<?= form_label('Image', 'image') ?>
<?= form_input([
    'name'  => 'image',
    'value' => $modifier->image,
]) ?>

    <!-- Zone path -->
<?= form_label('Zone path', 'zone_path') ?>
<?= form_textarea([
    'name'  => 'zone_path',
    'value' => $modifier->zone_path,
]) ?>

<hr>

    <!-- Texte optionnel -->
    <button type="button"
            class="btn-toggle-texte"
            onclick="toggleTexte()">
        Ajouter / modifier le texte sur l'objet
    </button>

    <div id="zoneTexte" style="display:none;">
        <?= form_label('Texte', 'texte') ?>
        <?= form_textarea([
            'name'  => 'texte',
            'value' => $modifier->texte,
        ]) ?>
    </div>

<hr>

    <!-- Options -->
    <div class="form-options">

        <label>
            <?= form_checkbox('drag', '1', (bool)$modifier->drag, ['id' => 'drag']) ?>
            Draggable
        </label>

        <label>
            <?= form_checkbox('hover', '1', (bool)$modifier->hover, [
                'id' => 'hover',
                'onchange' => 'toggleHoverTexte()'
            ]) ?>
            Hover actif
        </label>

        <label>
            <?= form_checkbox('cliquable', '1', (bool)$modifier->cliquable) ?>
            Cliquable
        </label>

        <label>
            <?= form_checkbox('ratio', '1', (bool)$modifier->ratio) ?>
            Ratio conservé
        </label>

    </div>

    <!-- TEXTE (lié au hover) -->
    <div id="zoneTexteHover" style="<?= $modifier->hover ? '' : 'display:none;' ?>">
        <?= form_label('Texte affiché au hover', 'texte') ?>
        <?= form_textarea([
            'name'  => 'texteHover',
            'value' => $modifier->texte,
        ]) ?>
    </div>

<?= form_submit('submit', 'Valider les modifications', ['class' => 'btn-submit']) ?>

<?= form_close() ?>

    <script>
        function toggleTexte() {
            const zone = document.getElementById('zoneTexte');
            zone.style.display = (zone.style.display === 'none') ? 'block' : 'none';
        }
    </script>
    <script>
        function toggleHoverTexte() {
            const hover = document.getElementById('hover');
            const zone  = document.getElementById('zoneTexteHover');

            if (hover.checked) {
                zone.style.display = 'block';
            } else {
                zone.style.display = 'none';
                // optionnel : vider le texte si hover décoché
                zone.querySelector('textarea').value = '';
            }
        }
    </script>




<?php elseif ($section == 'enigmes'): ?>
<?= form_open('admin/validerModifEnigme', ['class' => 'form-objet']) ?>

    <h3>Modification de l’énigme</h3>

    <!-- Numéro non modifiable -->
    <p><strong>Numéro :</strong> <?= esc($modifier->numero) ?></p>
    <?= form_hidden('numero', $modifier->numero) ?>

<hr>

<?= form_label('Libellé', 'libelle') ?>
<?= form_input([
    'name'  => 'libelle',
    'value' => $modifier->libelle,
]) ?>

<?= form_label('Image', 'image') ?>
<?= form_input([
    'name'  => 'image',
    'value' => $modifier->image,
]) ?>

<?= form_label('Type', 'type_numero') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'type_numero',
    'value' => $modifier->type_numero,
]) ?>

<?= form_label('Explication', 'explication_numero') ?>
<?= form_input([
    'type'  => 'number',
    'name'  => 'explication_numero',
    'value' => $modifier->explication_numero,
]) ?>

<?= form_submit('submit', 'Valider les modifications', ['class' => 'btn-submit']) ?>

<?= form_close() ?>



<?php elseif ($section == 'objets_declencheurs'): ?>
<?= form_open('admin/validerModifObjetDeclencheur', ['class' => 'form-objet']) ?>

    <h3>Modification de l'objet déclencheur</h3>

    <!-- ID non modifiable -->
    <p><strong>ID :</strong> <?= $modifier['id']?></p>
    <?= form_hidden('id', $modifier['id']) ?>

<hr>

    <?= form_label('Nom', 'nom') ?>
    <?= form_input([
        'name'  => 'nom',
        'value' => $modifier['nom'],
    ]) ?>

    <?= form_label('Image (path)', 'image_path') ?>
    <?= form_input([
        'name'  => 'image_path',
        'value' => $modifier['image_path'],
    ]) ?>

    <?= form_label('Position X', 'x') ?>
    <?= form_input([
        'type'  => 'number',
        'name'  => 'x',
        'value' => $modifier['x'],
    ]) ?>

    <?= form_label('Position Y', 'y') ?>
    <?= form_input([
        'type'  => 'number',
        'name'  => 'y',
        'value' => $modifier['y'],
    ]) ?>

    <?= form_label('Largeur', 'width') ?>
    <?= form_input([
        'type'  => 'number',
        'name'  => 'width',
        'value' => $modifier['width'],
    ]) ?>

    <?= form_label('Hauteur', 'height') ?>
    <?= form_input([
        'type'  => 'number',
        'name'  => 'height',
        'value' => $modifier['height'],
    ]) ?>

    <?= form_label('Zone path', 'zone_path') ?>
    <?= form_textarea([
        'name'  => 'zone_path',
        'value' => $modifier['zone_path'],
    ]) ?>

    <?= form_label('Numéro activité déclenchée', 'numero_activite') ?>
    <?= form_input([
        'type'  => 'number',
        'name'  => 'numero_activite',
        'value' => $modifier['numero_activite'],
    ]) ?>

    <?= form_submit('submit', 'Valider les modifications', ['class' => 'btn-submit']) ?>

    <?= form_close() ?>
<?php endif; ?>
