<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Modifier Proposition VPN<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Modifier une proposition VPN<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6', 'Accueil') ?></li>
    <li class="breadcrumb-item"><?= anchor('/gingembre/salle_6/proposer-vpn', 'Propositions VPN') ?></li>
    <li class="breadcrumb-item active">Modifier</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier la proposition VPN #<?= esc($proposition['vpn_numero']) ?> - Activité #<?= esc($proposition['activite_numero']) ?></h3>
                </div>

                <?= form_open(base_url('/gingembre/salle_6/proposer-vpn/update/' . $proposition['vpn_numero'] . '/' . $proposition['activite_numero'])) ?>

                <div class="card-body">
                    <?php /* Bloc d'erreurs standardisé */ ?>
                    <?php if (session('error') || session('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <?php if (session('errors')): ?>
                                <ul class="mb-0"><?php foreach (session('errors') as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
                            <?php endif; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php endif; ?>

                    <div class="alert alert-info">
                        <i class="icon fas fa-info"></i>
                        <strong>VPN:</strong> #<?= esc($proposition['vpn_numero']) ?><br>
                        <strong>Activité:</strong> #<?= esc($proposition['activite_numero']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Bonne réponse <span class="text-danger">*</span>', 'bonne_reponse') ?>
                        <?= form_dropdown(
                                'bonne_reponse',
                                ['' => '-- Sélectionner --', '1' => 'Oui', '0' => 'Non'],
                                old('bonne_reponse', $proposition['bonne_reponse']),
                                ['class' => 'form-control' . (session('errors.bonne_reponse') ? ' is-invalid' : ''), 'id' => 'bonne_reponse', 'required' => true]
                        ) ?>
                        <small class="form-text text-muted">Indiquez si ce VPN est la bonne réponse pour cette activité</small>
                    </div>
                </div>

                <div class="card-footer">
                    <?= form_button([
                            'type' => 'submit',
                            'class' => 'btn btn-primary',
                            'content' => '<i class="fas fa-save"></i> Mettre à jour'
                    ]) ?>
                    <?= anchor('/gingembre/salle_6/proposer-vpn', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>