<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>Gestion des Messages d'Activités<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Messages d'Activités<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/accueil', 'Accueil') ?></li>
    <li class="breadcrumb-item active">Messages d'Activités</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Liste des Messages (<?= $total ?>)</h3>
                </div>
                <div class="col-md-6 text-right">
                    <?= anchor('/gingembre/salle_6/activite-message/create', '<i class="fas fa-plus"></i> Nouveau Message', ['class' => 'btn btn-success']) ?>
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
                    <?= form_open('/gingembre/salle_6/activite-message', ['method' => 'get', 'class' => 'form-inline']) ?>
                    <div class="input-group">
                        <?= form_input([
                            'name'        => 'search',
                            'class'       => 'form-control',
                            'placeholder' => 'Rechercher...',
                            'value'       => esc($search)
                        ]) ?>

                        <?php if ($sort !== 'id'): ?>
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
                                <?= anchor('/gingembre/salle_6/activite-message', '<i class="fas fa-times"></i>', ['class' => 'btn btn-secondary']) ?>
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
                        <th style="width: 80px">
                            <?php
                            $sortParams = ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'ASC') ? 'DESC' : 'ASC'];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/activite-message?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                'ID ' . ($sort == 'id' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>
                            <?php
                            $sortParams = ['sort' => 'activite_numero', 'order' => ($sort == 'activite_numero' && $order == 'ASC') ? 'DESC' : 'ASC'];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/activite-message?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                'Activité ' . ($sort == 'activite_numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>
                            <?php
                            $sortParams = ['sort' => 'type_message', 'order' => ($sort == 'type_message' && $order == 'ASC') ? 'DESC' : 'ASC'];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/activite-message?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                'Type ' . ($sort == 'type_message' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>Message</th>
                        <th style="width: 150px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($messages)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun message trouvé</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?= esc($message['id']) ?></td>
                                <td><?= esc($message['activite_numero']) ?></td>
                                <td>
                                    <?php if ($message['type_message'] === 'succes'): ?>
                                        <span class="badge badge-success">Succès</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Échec</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($message['message']) ?></td>
                                <td class="text-center">
                                    <?= anchor(
                                        '/gingembre/salle_6/activite-message/edit/' . $message['id'],
                                        '<i class="fas fa-edit"></i>',
                                        ['class' => 'btn btn-sm btn-info', 'title' => 'Modifier']
                                    ) ?>
                                    <?= anchor(
                                        '/gingembre/salle_6/activite-message/delete/' . $message['id'],
                                        '<i class="fas fa-trash"></i>',
                                        [
                                            'class'   => 'btn btn-sm btn-danger',
                                            'title'   => 'Supprimer',
                                            'onclick' => 'return confirm("Êtes-vous sûr de vouloir supprimer ce message ?")'
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
                    if ($sort !== 'id') $queryParams['sort'] = $sort;
                    if ($order !== 'ASC') $queryParams['order'] = $order;
                    $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                    ?>
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'default_full', 0, $queryString) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
