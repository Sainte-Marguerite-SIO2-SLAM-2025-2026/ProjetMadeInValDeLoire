<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Modifier la Salle #<?= esc($salle['numero']) ?><?= $this->endSection() ?>

<?= $this->section('page_title') ?>Modifier la Salle #<?= esc($salle['numero']) ?><?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/salle', 'Salle') ?></li>
    <li class="breadcrumb-item active">Modifier #<?= esc($salle['numero']) ?></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails de la Salle #<?= esc($salle['numero']) ?></h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/salle/update/' . $salle['numero'])) ?>

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
                        <?= form_label('Numéro (Lecture seule)', 'numero_dis') ?>
                        <?= form_input([
                            'class'    => 'form-control',
                            'value'    => esc($salle['numero']),
                            'readonly' => true,
                            'disabled' => true
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Libellé <span class="text-danger">*</span>', 'libelle') ?>
                        <?= form_input([
                            'name'     => 'libelle',
                            'id'       => 'libelle',
                            'class'    => 'form-control' . (session('errors.libelle') ? ' is-invalid' : ''),
                            'value'    => old('libelle', $salle['libelle']),
                            'required' => true
                        ]) ?>
                        <?php if (session('errors.libelle')): ?>
                            <div class="invalid-feedback"><?= session('errors.libelle') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Bouton <span class="text-danger">*</span>', 'bouton') ?>
                        <?= form_input([
                            'name'        => 'bouton',
                            'id'          => 'bouton',
                            'class'       => 'form-control' . (session('errors.bouton') ? ' is-invalid' : ''),
                            'value'       => old('bouton', $salle['bouton']),
                            'required'    => true,
                            'maxlength'   => '50',
                            'placeholder' => 'Texte du bouton d\'accès'
                        ]) ?>
                        <small class="form-text text-muted">Maximum 50 caractères</small>
                        <?php if (session('errors.bouton')): ?>
                            <div class="invalid-feedback"><?= session('errors.bouton') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Introduction de la salle', 'intro_salle') ?>
                        <textarea name="intro_salle" id="intro_salle" rows="5"
                                  class="form-control<?= session('errors.intro_salle') ? ' is-invalid' : '' ?>"
                                  placeholder="Texte d'introduction affiché dans la salle (optionnel)"><?= old('intro_salle', $salle['intro_salle'] ?? '') ?></textarea>
                        <?php if (session('errors.intro_salle')): ?>
                            <div class="invalid-feedback"><?= session('errors.intro_salle') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-primary',
                        'content' => '<i class="fas fa-save"></i> Mettre à jour'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/salle', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
