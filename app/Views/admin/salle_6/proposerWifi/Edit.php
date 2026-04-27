<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Modifier Proposition WiFi<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Modifier une proposition WiFi<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class=\"breadcrumb-item\"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class=\"breadcrumb-item\"><?= anchor('/gingembre/salle_6/proposer-wifi', 'Propositions WiFi') ?></li>
    <li class=\"breadcrumb-item active\">Modifier</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class=\"row\">
        <div class=\"col-md-8 offset-md-2\">
        <div class=\"card\">
            <div class=\"card-header\">
                <h3 class=\"card-title\">Modifier la proposition WiFi #<?= esc($proposition['wifi_numero']) ?> - Activité #<?= esc($proposition['activite_numero']) ?></h3>
            </div>

            <?= form_open(base_url('/gingembre/salle_6/proposer-wifi/update/' . $proposition['wifi_numero'] . '/' . $proposition['activite_numero'])) ?>

            <div class=\"card-body\">
                <?php if (session('error') || session('errors')): ?>
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <?= session('error') ?>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
            </div>
        <?php endif; ?>

            <div class=\"alert alert-info\">
            <strong>WiFi :</strong> #<?= esc($proposition['wifi_numero']) ?><br>
            <strong>Activité :</strong> #<?= esc($proposition['activite_numero']) ?>
        </div>

        <div class=\"form-group\">
            <?= form_label('Bonne réponse <span class=\"text-danger\">*</span>', 'bonne_reponse') ?>
            <?= form_dropdown(
                    'bonne_reponse',
                    ['' => '-- Sélectionner --', '1' => 'Oui', '0' => 'Non'],
                    old('bonne_reponse', $proposition['bonne_reponse']),
                    ['class' => 'form-control' . (session('errors.bonne_reponse') ? ' is-invalid' : ''), 'id' => 'bonne_reponse', 'required' => true]
            ) ?>
            <small class=\"form-text text-muted\">Indiquez si ce WiFi est la bonne réponse pour cette activité</small>
        </div>
    </div>

    <div class=\"card-footer\">
        <?= form_button([
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'content' => '<i class=\"fas fa-save\"></i> Mettre à jour'
        ]) ?>
        <?= anchor('/gingembre/salle_6/proposer-wifi', '<i class=\"fas fa-times\"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
    </div>

<?= form_close() ?>
    </div>
    </div>
    </div>
<?= $this->endSection() ?>