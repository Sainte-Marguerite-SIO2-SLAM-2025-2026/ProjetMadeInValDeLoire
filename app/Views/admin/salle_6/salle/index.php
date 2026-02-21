<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Gestion de la Salle<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Salle<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/accueil', 'Accueil') ?></li>
    <li class="breadcrumb-item active">Salle</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Informations de la Salle 6</h3>
                </div>
                <div class="col-md-6 text-right">
                    <?php foreach ($salles as $salle): ?>
                        <?= anchor('/gingembre/salle_6/salle/edit/' . $salle['numero'], '<i class="fas fa-edit"></i> Modifier la Salle', ['class' => 'btn btn-info']) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?php if (session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Tableau des données -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 100px">Numéro</th>
                        <th>Libellé</th>
                        <th>Bouton</th>
                        <th>Introduction</th>
                        <th style="width: 100px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($salles)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucune salle trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($salles as $salle): ?>
                            <tr>
                                <td><?= esc($salle['numero']) ?></td>
                                <td><?= esc($salle['libelle']) ?></td>
                                <td><?= esc($salle['bouton']) ?></td>
                                <td><?= esc($salle['intro_salle'] ?? '') ?></td>
                                <td class="text-center">
                                    <?= anchor(
                                        '/gingembre/salle_6/salle/edit/' . $salle['numero'],
                                        '<i class="fas fa-edit"></i>',
                                        ['class' => 'btn btn-sm btn-info', 'title' => 'Modifier']
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
