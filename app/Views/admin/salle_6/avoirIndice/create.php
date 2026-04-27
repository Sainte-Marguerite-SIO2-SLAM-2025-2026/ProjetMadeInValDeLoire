<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouvelle Association Activité-Indice<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer une Association Activité-Indice<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/avoir-indice', 'Associations Activité-Indice') ?></li>
    <li class="breadcrumb-item active">Nouvelle</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de l'Association</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/avoir-indice/store')) ?>

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
                        <?= form_label('Activité <span class="text-danger">*</span>', 'activite_numero') ?>
                        <select name="activite_numero" id="activite_numero"
                                class="form-control<?= session('errors.activite_numero') ? ' is-invalid' : '' ?>" required>
                            <option value="">-- Sélectionner une activité --</option>
                            <?php foreach ($activites as $activite): ?>
                                <option value="<?= esc($activite['numero']) ?>"
                                    <?= old('activite_numero') == $activite['numero'] ? 'selected' : '' ?>>
                                    <?= esc($activite['numero']) ?> - <?= esc($activite['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.activite_numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.activite_numero') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Indice <span class="text-danger">*</span>', 'indice_numero') ?>
                        <select name="indice_numero" id="indice_numero"
                                class="form-control<?= session('errors.indice_numero') ? ' is-invalid' : '' ?>" required>
                            <option value="">-- Sélectionner un indice --</option>
                            <?php foreach ($indices as $indice): ?>
                                <option value="<?= esc($indice['numero']) ?>"
                                    <?= old('indice_numero') == $indice['numero'] ? 'selected' : '' ?>>
                                    <?= esc($indice['numero']) ?> - <?= esc($indice['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.indice_numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.indice_numero') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-success',
                        'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/avoir-indice', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
