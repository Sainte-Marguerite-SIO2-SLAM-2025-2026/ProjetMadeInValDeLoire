<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Nouveau WiFi
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Créer un WiFi
<?= $this->endSection() ?>

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
                    <div class="form-group">
                        <?= form_label('Nom du réseau <span class="text-danger">*</span>', 'nom') ?>
                        <?= form_input([
                                'name' => 'nom',
                                'id' => 'nom',
                                'class' => 'form-control' . (session('errors.nom') ? ' is-invalid' : ''),
                                'value' => old('nom'),
                                'required' => true,
                                'placeholder' => 'Entrez le nom du réseau WiFi'
                        ]) ?>
                        <?php if (session('errors.nom')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.nom') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Réseau public <span class="text-danger">*</span>', 'public') ?>
                        <?= form_dropdown(
                                'public',
                                [
                                        '' => '-- Sélectionner --',
                                        '1' => 'Oui',
                                        '0' => 'Non'
                                ],
                                old('public'),
                                [
                                        'id' => 'public',
                                        'class' => 'form-control' . (session('errors.public') ? ' is-invalid' : ''),
                                        'required' => true
                                ]
                        ) ?>
                        <?php if (session('errors.public')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.public') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Type de chiffrement <span class="text-danger">*</span>', 'chiffrement') ?>
                        <?php
                        $chiffrementOptions = ['' => '-- Sélectionner --'];
                        foreach ($chiffrements as $chiff) {
                            $chiffrementOptions[$chiff] = $chiff;
                        }
                        ?>
                        <?= form_dropdown(
                                'chiffrement',
                                $chiffrementOptions,
                                old('chiffrement'),
                                [
                                        'id' => 'chiffrement',
                                        'class' => 'form-control' . (session('errors.chiffrement') ? ' is-invalid' : ''),
                                        'required' => true
                                ]
                        ) ?>
                        <?php if (session('errors.chiffrement')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.chiffrement') ?>
                            </div>
                        <?php endif; ?>
                        <small class="form-text text-muted">
                            Types disponibles: OPEN, WEP, WPA, WPA2, WPA3
                        </small>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                            'type' => 'submit',
                            'class' => 'btn btn-success',
                            'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/admin/wifi', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>