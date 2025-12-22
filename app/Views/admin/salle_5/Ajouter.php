<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <?= link_tag('styles/salle_5/admin/modif.css'); ?>
    <title>Ajouter</title>
</head>
<body>

<?php if ($section == 'objets'): ?>
    <?= form_open('admin/validerAjoutObjet', ['class' => 'form-objet']) ?>

    <h3>Ajouter un nouvel objet</h3>

<?= form_label('Nom', 'nom') ?>
<?= form_input('nom') ?>

<?= form_label('Position X', 'x') ?>
<?= form_input(['type' => 'number', 'name' => 'x']) ?>

<?= form_label('Position Y', 'y') ?>
<?= form_input(['type' => 'number', 'name' => 'y']) ?>

<?= form_label('Largeur', 'width') ?>
<?= form_input(['type' => 'number', 'name' => 'width']) ?>

<?= form_label('Hauteur', 'height') ?>
<?= form_input(['type' => 'number', 'name' => 'height']) ?>

<?= form_label('Image', 'image') ?>
<?= form_input('image') ?>

<?= form_label('Zone path', 'zone_path') ?>
<?= form_textarea('zone_path') ?>

    <button type="button" class="btn-toggle-texte" onclick="toggleTexte()">Ajouter texte optionnel</button>
    <div id="zoneTexte" style="display:none;">
        <?= form_label('Texte', 'texte') ?>
        <?= form_textarea('texte') ?>
    </div>

    <div class="form-options">
        <label><?= form_checkbox('drag', '1') ?> Draggable</label>
        <label><?= form_checkbox('hover', '1', false, ['id' => 'hover', 'onchange' => 'toggleHoverTexte()']) ?> Hover actif</label>
        <label><?= form_checkbox('cliquable', '1') ?> Cliquable</label>
        <label><?= form_checkbox('ratio', '1') ?> Ratio conservé</label>
    </div>

    <div id="zoneTexteHover" style="display:none;">
        <?= form_label('Texte affiché au hover', 'texteHover') ?>
        <?= form_textarea('texteHover') ?>
    </div>

<?= form_submit('submit', 'Ajouter l\'objet', ['class' => 'btn-submit']) ?>
<?= form_close() ?>

    <script>
        function toggleTexte() {
            const zone = document.getElementById('zoneTexte');
            zone.style.display = (zone.style.display === 'none') ? 'block' : 'none';
        }
        function toggleHoverTexte() {
            const zone = document.getElementById('zoneTexteHover');
            zone.style.display = document.getElementById('hover').checked ? 'block' : 'none';
        }
    </script>

<?php elseif ($section == 'enigmes'): ?>
<?= form_open('admin/validerAjoutEnigme', ['class' => 'form-objet']) ?>

    <h3>Ajouter une nouvelle énigme</h3>

<?= form_label('Libellé', 'libelle') ?>
<?= form_input('libelle') ?>

<?= form_label('Image', 'image') ?>
<?= form_input('image') ?>

<?= form_label('Type', 'type_numero') ?>
<?= form_input(['type' => 'number', 'name' => 'type_numero']) ?>

<?= form_label('Explication', 'explication_numero') ?>
<?= form_input(['type' => 'number', 'name' => 'explication_numero']) ?>

<?= form_submit('submit', 'Ajouter l\'énigme', ['class' => 'btn-submit']) ?>
<?= form_close() ?>

<?php elseif ($section == 'objets_declencheurs'): ?>
<?= form_open('admin/validerAjoutObjetDeclencheur', ['class' => 'form-objet']) ?>

    <h3>Ajouter un nouvel objet déclencheur</h3>

    <?= form_label('Nom', 'nom') ?>
    <?= form_input('nom') ?>

    <?= form_label('Image (path)', 'image_path') ?>
    <?= form_input('image_path') ?>

    <?= form_label('Position X', 'x') ?>
    <?= form_input(['type' => 'number', 'name' => 'x']) ?>

    <?= form_label('Position Y', 'y') ?>
    <?= form_input(['type' => 'number', 'name' => 'y']) ?>

    <?= form_label('Largeur', 'width') ?>
    <?= form_input(['type' => 'number', 'name' => 'width']) ?>

    <?= form_label('Hauteur', 'height') ?>
    <?= form_input(['type' => 'number', 'name' => 'height']) ?>

    <?= form_label('Zone path', 'zone_path') ?>
    <?= form_textarea('zone_path') ?>

    <?= form_label('Numéro activité déclenchée', 'numero_activite') ?>
    <?= form_input(['type' => 'number', 'name' => 'numero_activite']) ?>

    <?= form_submit('submit', 'Ajouter l\'objet déclencheur', ['class' => 'btn-submit']) ?>
    <?= form_close() ?>
<?php endif; ?>

</body>
</html>
