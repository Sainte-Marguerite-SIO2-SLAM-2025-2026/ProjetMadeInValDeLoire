<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouvelle Proposition VPN<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer une proposition VPN<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/proposer-vpn', 'Propositions VPN') ?></li>
    <li class="breadcrumb-item active">Nouveau</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de la proposition</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/proposer-vpn/store')) ?>

                <div class="card-body">
                    <?php if (session('error') || session('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <?php if (session('errors')): ?>
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?= form_label('VPN <span class="text-danger">*</span>', 'vpn_numero') ?>
                        <?= form_dropdown(
                                'vpn_numero',
                                ['' => '-- Sélectionner un VPN --'] + array_column($vpns, 'libelle', 'numero'),
                                old('vpn_numero'),
                                ['class' => 'form-control' . (session('errors.vpn_numero') ? ' is-invalid' : ''), 'id' => 'vpn_numero', 'required' => true]
                        ) ?>
                        <?php if (session('errors.vpn_numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.vpn_numero') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Numéro d\'activité <span class="text-danger">*</span>', 'activite_numero') ?>
                        <?= form_input([
                                'name' => 'activite_numero',
                                'id' => 'activite_numero',
                                'type' => 'number',
                                'class' => 'form-control' . (session('errors.activite_numero') ? ' is-invalid' : ''),
                                'value' => old('activite_numero'),
                                'required' => true,
                                'min' => 1,
                                'placeholder' => 'Entrez le numéro de l\'activité'
                        ]) ?>
                        <?php if (session('errors.activite_numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.activite_numero') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Bonne réponse <span class="text-danger">*</span>', 'bonne_reponse') ?>
                        <?= form_dropdown(
                                'bonne_reponse',
                                ['' => '-- Sélectionner --', '1' => 'Oui', '0' => 'Non'],
                                old('bonne_reponse'),
                                ['class' => 'form-control' . (session('errors.bonne_reponse') ? ' is-invalid' : ''), 'id' => 'bonne_reponse', 'required' => true]
                        ) ?>
                        <small class="form-text text-muted">Indiquez si ce VPN est la bonne réponse pour cette activité</small>
                        <?php if (session('errors.bonne_reponse')): ?>
                            <div class="invalid-feedback"><?= session('errors.bonne_reponse') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                            'type' => 'submit',
                            'class' => 'btn btn-success',
                            'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/proposer-vpn', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>