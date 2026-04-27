<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Gestion des Associations Activité-Indice<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Associations Activité-Indice<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/accueil', 'Accueil') ?></li>
    <li class="breadcrumb-item active">Associations Activité-Indice</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Liste des Associations (<?= $total ?>)</h3>
                </div>
                <div class="col-md-6 text-right">
                    <?= anchor('/gingembre/salle_6/avoir-indice/create', '<i class="fas fa-plus"></i> Nouvelle Association', ['class' => 'btn btn-success']) ?>
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

            <!-- Barre de recherche -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <?= form_open('/gingembre/salle_6/avoir-indice', ['method' => 'get', 'class' => 'form-inline']) ?>
                    <div class="input-group">
                        <?= form_input([
                            'name'        => 'search',
                            'class'       => 'form-control',
                            'placeholder' => 'Rechercher...',
                            'value'       => esc($search)
                        ]) ?>

                        <?php if ($sort !== 'activite_numero'): ?>
                            <?= form_hidden('sort', $sort) ?>
                        <?php endif; ?>

                        <?php if ($order !== 'ASC'): ?>
                            <?= form_hidden('order', $order) ?>
                        <?php endif; ?>

                        <div class="input-group-append">
                            <?= form_button([
                                'type'    => 'submit',
                                'class'   => 'btn btn-primary',
                                'content' => '<i class="fas fa-search"></i>'
                            ]) ?>
                            <?php if ($search): ?>
                                <?= anchor('/gingembre/salle_6/avoir-indice', '<i class="fas fa-times"></i>', ['class' => 'btn btn-secondary']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Tableau des données -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>
                            <?php
                            $sortParams = ['sort' => 'activite_numero', 'order' => ($sort == 'activite_numero' && $order == 'ASC') ? 'DESC' : 'ASC'];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/avoir-indice?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                'Activité ' . ($sort == 'activite_numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>
                            <?php
                            $sortParams = ['sort' => 'indice_numero', 'order' => ($sort == 'indice_numero' && $order == 'ASC') ? 'DESC' : 'ASC'];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/avoir-indice?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                'Indice ' . ($sort == 'indice_numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 100px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($associations)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Aucune association trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($associations as $association): ?>
                            <tr>
                                <td><?= esc($association['activite_numero']) ?>
                                    <?php if (!empty($association['activite_libelle'])): ?>
                                        - <?= esc($association['activite_libelle']) ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($association['indice_numero']) ?>
                                    <?php if (!empty($association['indice_libelle'])): ?>
                                        - <?= esc($association['indice_libelle']) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= anchor(
                                        '/gingembre/salle_6/avoir-indice/delete/' . $association['activite_numero'] . '/' . $association['indice_numero'],
                                        '<i class="fas fa-trash"></i>',
                                        [
                                            'class'   => 'btn btn-sm btn-danger',
                                            'title'   => 'Supprimer',
                                            'onclick' => 'return confirm("Êtes-vous sûr de vouloir supprimer cette association ?")'
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total > $perPage): ?>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <?php
                    $queryParams = [];
                    if ($search) $queryParams['search'] = $search;
                    if ($sort !== 'activite_numero') $queryParams['sort'] = $sort;
                    if ($order !== 'ASC') $queryParams['order'] = $order;
                    $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                    ?>
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'default_full', 0, $queryString) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
