<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouveau WiFi<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer un WiFi<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/wifi', 'WiFi') ?></li>
    <li class="breadcrumb-item active">Nouveau</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations du WiFi</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/wifi/store')) ?>

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
                        <?= form_label('Nom du réseau (SSID) <span class="text-danger">*</span>', 'nom') ?>
                        <?= form_input([
                                'name'        => 'nom',
                                'id'          => 'nom',
                                'class'       => 'form-control' . (session('errors.nom') ? ' is-invalid' : ''),
                                'value'       => old('nom'),
                                'required'    => true,
                                'placeholder' => 'Ex: Guest_WiFi'
                        ]) ?>
                        <?php if (session('errors.nom')): ?>
                            <div class="invalid-feedback"><?= session('errors.nom') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Type de Chiffrement <span class="text-danger">*</span>', 'chiffrement') ?>
                        <?= form_dropdown(
                                'chiffrement',
                                ['' => '-- Sélectionner --', 'OPEN' => 'OPEN', 'WEP' => 'WEP', 'WPA' => 'WPA', 'WPA2' => 'WPA2', 'WPA3' => 'WPA3'],
                                old('chiffrement'),
                                ['class' => 'form-control' . (session('errors.chiffrement') ? ' is-invalid' : ''), 'id' => 'chiffrement', 'required' => true]
                        ) ?>
                        <?php if (session('errors.chiffrement')): ?>
                            <div class="invalid-feedback"><?= session('errors.chiffrement') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                            'type'    => 'submit',
                            'class'   => 'btn btn-success',
                            'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/wifi', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>