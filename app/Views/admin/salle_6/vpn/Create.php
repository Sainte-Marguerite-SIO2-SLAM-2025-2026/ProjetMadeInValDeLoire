<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouveau VPN<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer un VPN<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/vpn', 'VPN') ?></li>
    <li class="breadcrumb-item active">Nouveau</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations du VPN</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/vpn/store')) ?>

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
                        <?= form_label('Libellé <span class="text-danger">*</span>', 'libelle') ?>
                        <?= form_input([
                                'name'        => 'libelle',
                                'id'          => 'libelle',
                                'class'       => 'form-control' . (session('errors.libelle') ? ' is-invalid' : ''),
                                'value'       => old('libelle'),
                                'required'    => true,
                                'placeholder' => 'Entrez le libellé du VPN'
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
                    <?= anchor('/gingembre/salle_6/vpn', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>