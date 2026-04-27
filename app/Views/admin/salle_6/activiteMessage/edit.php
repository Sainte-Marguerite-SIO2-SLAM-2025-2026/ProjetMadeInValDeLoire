<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Modifier le Message #<?= esc($message['id']) ?><?= $this->endSection() ?>

<?= $this->section('page_title') ?>Modifier le Message #<?= esc($message['id']) ?><?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/activite-message', 'Messages d\'Activités') ?></li>
    <li class="breadcrumb-item active">Modifier #<?= esc($message['id']) ?></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails du Message #<?= esc($message['id']) ?></h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/activite-message/update/' . $message['id'])) ?>

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
                        <?= form_label('ID (Lecture seule)', 'id_dis') ?>
                        <?= form_input([
                            'class'    => 'form-control',
                            'value'    => esc($message['id']),
                            'readonly' => true,
                            'disabled' => true
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Activité <span class="text-danger">*</span>', 'activite_numero') ?>
                        <select name="activite_numero" id="activite_numero"
                                class="form-control<?= session('errors.activite_numero') ? ' is-invalid' : '' ?>" required>
                            <option value="">-- Sélectionner une activité --</option>
                            <?php foreach ($activites as $activite): ?>
                                <option value="<?= esc($activite['numero']) ?>"
                                    <?= old('activite_numero', $message['activite_numero']) == $activite['numero'] ? 'selected' : '' ?>>
                                    <?= esc($activite['numero']) ?> - <?= esc($activite['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.activite_numero')): ?>
                            <div class="invalid-feedback"><?= session('errors.activite_numero') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Type de message <span class="text-danger">*</span>', 'type_message') ?>
                        <select name="type_message" id="type_message"
                                class="form-control<?= session('errors.type_message') ? ' is-invalid' : '' ?>" required>
                            <option value="">-- Sélectionner un type --</option>
                            <?php foreach ($type_messages as $value => $label): ?>
                                <option value="<?= esc($value) ?>"
                                    <?= old('type_message', $message['type_message']) == $value ? 'selected' : '' ?>>
                                    <?= esc($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.type_message')): ?>
                            <div class="invalid-feedback"><?= session('errors.type_message') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Message <span class="text-danger">*</span>', 'message') ?>
                        <textarea name="message" id="message" rows="4"
                                  class="form-control<?= session('errors.message') ? ' is-invalid' : '' ?>"
                                  required><?= old('message', $message['message']) ?></textarea>
                        <?php if (session('errors.message')): ?>
                            <div class="invalid-feedback"><?= session('errors.message') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-primary',
                        'content' => '<i class="fas fa-save"></i> Mettre à jour'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/activite-message', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
