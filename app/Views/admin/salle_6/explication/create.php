<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouvelle Explication<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer une Explication<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/explication', 'Explications') ?></li>
    <li class="breadcrumb-item active">Nouvelle</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de l'Explication</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/explication/store')) ?>

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
                        <?= form_label('Numéro <span class="text-danger">*</span>', 'numero') ?>
                        <?= form_input([
                            'name'        => 'numero',
                            'id'          => 'numero',
                            'type'        => 'number',
                            'class'       => 'form-control' . (session('errors.numero') ? ' is-invalid' : ''),
                            'value'       => old('numero'),
                            'required'    => true,
                            'min'         => '600',
                            'max'         => '699',
                            'placeholder' => 'Entre 600 et 699'
                        ]) ?>
                        <small class="form-text text-muted">Le numéro doit être compris entre 600 et 699 (Salle 6)</small>
                        <?php if (session('errors.numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.numero') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Libellé <span class="text-danger">*</span>', 'libelle') ?>
                        <?= form_input([
                            'name'        => 'libelle',
                            'id'          => 'libelle',
                            'class'       => 'form-control' . (session('errors.libelle') ? ' is-invalid' : ''),
                            'value'       => old('libelle'),
                            'required'    => true,
                            'placeholder' => 'Entrez le libellé de l\'explication'
                        ]) ?>
                        <small class="form-text text-muted">Le libellé doit contenir au minimum 3 caractères</small>
                        <?php if (session('errors.libelle')): ?>
                            <div class="invalid-feedback"><?= session('errors.libelle') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-success',
                        'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/explication', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
