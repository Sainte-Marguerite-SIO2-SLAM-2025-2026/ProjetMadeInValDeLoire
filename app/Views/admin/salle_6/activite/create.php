<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Nouvelle Activité<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Créer une Activité<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/activite', 'Activités') ?></li>
    <li class="breadcrumb-item active">Nouvelle</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de l'Activité</h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/activite/store')) ?>

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

                    <div class="row">
                        <!-- Libellé -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= form_label('Libellé <span class="text-danger">*</span>', 'libelle') ?>
                                <?= form_input([
                                    'name'        => 'libelle',
                                    'id'          => 'libelle',
                                    'class'       => 'form-control' . (session('errors.libelle') ? ' is-invalid' : ''),
                                    'value'       => old('libelle'),
                                    'required'    => true,
                                    'placeholder' => 'Entrez le libellé de l\'activité'
                                ]) ?>
                                <small class="form-text text-muted">Le libellé doit contenir au minimum 3 caractères</small>
                                <?php if (session('errors.libelle')): ?>
                                    <div class="invalid-feedback"><?= session('errors.libelle') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Salle (forcée à 6, affichage informatif) -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= form_label('Salle', 'salle_dis') ?>
                                <?= form_input([
                                    'class'    => 'form-control',
                                    'value'    => 'Salle ' . $current_salle,
                                    'readonly' => true,
                                    'disabled' => true
                                ]) ?>
                                <small class="form-text text-muted">Automatiquement assignée à la salle 6</small>
                            </div>
                        </div>

                        <!-- Difficulté -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= form_label('Difficulté', 'difficulte_numero') ?>
                                <select name="difficulte_numero" id="difficulte_numero"
                                        class="form-control<?= session('errors.difficulte_numero') ? ' is-invalid' : '' ?>">
                                    <option value="">-- Aucune --</option>
                                    <?php foreach ($difficultes as $difficulte): ?>
                                        <option value="<?= esc($difficulte['numero']) ?>"
                                            <?= old('difficulte_numero') == $difficulte['numero'] ? 'selected' : '' ?>>
                                            <?= esc($difficulte['libelle']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors.difficulte_numero')): ?>
                                    <div class="invalid-feedback"><?= session('errors.difficulte_numero') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Type -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= form_label('Type', 'type_numero') ?>
                                <select name="type_numero" id="type_numero"
                                        class="form-control<?= session('errors.type_numero') ? ' is-invalid' : '' ?>">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= esc($type['numero']) ?>"
                                            <?= old('type_numero') == $type['numero'] ? 'selected' : '' ?>>
                                            <?= esc($type['libelle']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors.type_numero')): ?>
                                    <div class="invalid-feedback"><?= session('errors.type_numero') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Explication -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= form_label('Explication', 'explication_numero') ?>
                                <select name="explication_numero" id="explication_numero"
                                        class="form-control<?= session('errors.explication_numero') ? ' is-invalid' : '' ?>">
                                    <option value="">-- Aucune --</option>
                                    <?php foreach ($explications as $explication): ?>
                                        <option value="<?= esc($explication['numero']) ?>"
                                            <?= old('explication_numero') == $explication['numero'] ? 'selected' : '' ?>>
                                            <?= esc($explication['numero']) ?> - <?= esc($explication['libelle']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors.explication_numero')): ?>
                                    <div class="invalid-feedback"><?= session('errors.explication_numero') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Image -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Image', 'image') ?>
                                <?= form_input([
                                    'name'        => 'image',
                                    'id'          => 'image',
                                    'class'       => 'form-control' . (session('errors.image') ? ' is-invalid' : ''),
                                    'value'       => old('image'),
                                    'placeholder' => 'Nom du fichier image',
                                    'maxlength'   => '50'
                                ]) ?>
                                <small class="form-text text-muted">Maximum 50 caractères</small>
                                <?php if (session('errors.image')): ?>
                                    <div class="invalid-feedback"><?= session('errors.image') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Dimensions image -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label('Largeur image (px)', 'width_img') ?>
                                <?= form_input([
                                    'name'        => 'width_img',
                                    'id'          => 'width_img',
                                    'type'        => 'number',
                                    'class'       => 'form-control',
                                    'value'       => old('width_img'),
                                    'placeholder' => 'Ex : 800',
                                    'min'         => '1'
                                ]) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label('Hauteur image (px)', 'height_img') ?>
                                <?= form_input([
                                    'name'        => 'height_img',
                                    'id'          => 'height_img',
                                    'type'        => 'number',
                                    'class'       => 'form-control',
                                    'value'       => old('height_img'),
                                    'placeholder' => 'Ex : 600',
                                    'min'         => '1'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Verrouillage -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Verrouillage', 'verrouillage') ?>
                                <select name="verrouillage" id="verrouillage"
                                        class="form-control<?= session('errors.verrouillage') ? ' is-invalid' : '' ?>">
                                    <option value="">-- Aucun --</option>
                                    <option value="0" <?= old('verrouillage') === '0' ? 'selected' : '' ?>>Non verrouillé</option>
                                    <option value="1" <?= old('verrouillage') === '1' ? 'selected' : '' ?>>Verrouillé</option>
                                </select>
                                <?php if (session('errors.verrouillage')): ?>
                                    <div class="invalid-feedback"><?= session('errors.verrouillage') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Malveillant -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Malveillant', 'malveillant') ?>
                                <select name="malveillant" id="malveillant"
                                        class="form-control<?= session('errors.malveillant') ? ' is-invalid' : '' ?>">
                                    <option value="">-- Aucun --</option>
                                    <option value="0" <?= old('malveillant') === '0' ? 'selected' : '' ?>>Non</option>
                                    <option value="1" <?= old('malveillant') === '1' ? 'selected' : '' ?>>Oui</option>
                                </select>
                                <?php if (session('errors.malveillant')): ?>
                                    <div class="invalid-feedback"><?= session('errors.malveillant') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-success',
                        'content' => '<i class="fas fa-save"></i> Enregistrer'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/activite', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
