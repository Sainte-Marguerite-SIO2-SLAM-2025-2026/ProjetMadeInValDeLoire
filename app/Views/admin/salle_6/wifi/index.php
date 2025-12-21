<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Gestion des WiFi
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    WiFi
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/accueil', 'Accueil') ?></li>
    <li class="breadcrumb-item active">WiFi</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Liste des WiFi (<?= $total ?>)</h3>
                </div>
                <div class="col-md-6 text-right">
                    <?= anchor('/gingembre/salle_6/wifi/create', '<i class="fas fa-plus"></i> Nouveau WiFi', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Barre de recherche -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <?= form_open('/gingembre/salle_6/wifi', ['method' => 'get', 'class' => 'form-inline']) ?>
                    <div class="input-group">
                        <?= form_input([
                                'name' => 'search',
                                'class' => 'form-control',
                                'placeholder' => 'Rechercher...',
                                'value' => esc($search)
                        ]) ?>

                        <?php if ($sort !== 'numero'): ?>
                            <?= form_hidden('sort', $sort) ?>
                        <?php endif; ?>

                        <?php if ($order !== 'ASC'): ?>
                            <?= form_hidden('order', $order) ?>
                        <?php endif; ?>

                        <div class="input-group-append">
                            <?= form_button([
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary',
                                    'content' => '<i class="fas fa-search"></i>'
                            ]) ?>
                            <?php if ($search): ?>
                                <?= anchor('/gingembre/salle_6/wifi', '<i class="fas fa-times"></i>', ['class' => 'btn btn-secondary']) ?>
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
                        <th style="width: 100px">
                            <?php
                            $sortParams = [
                                    'sort' => 'numero',
                                    'order' => ($sort == 'numero' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Numéro ' . ($sort == 'numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>
                            <?php
                            $sortParams = [
                                    'sort' => 'nom',
                                    'order' => ($sort == 'nom' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Nom ' . ($sort == 'nom' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 120px" class="text-center">
                            <?php
                            $sortParams = [
                                    'sort' => 'public',
                                    'order' => ($sort == 'public' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Public ' . ($sort == 'public' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 150px">
                            <?php
                            $sortParams = [
                                    'sort' => 'chiffrement',
                                    'order' => ($sort == 'chiffrement' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Chiffrement ' . ($sort == 'chiffrement' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 150px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($wifis)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun WiFi trouvé</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($wifis as $wifi): ?>
                            <tr>
                                <td><?= esc($wifi['numero']) ?></td>
                                <td><?= esc($wifi['nom']) ?></td>
                                <td class="text-center">
                                    <?php if ($wifi['public'] == 1): ?>
                                        <span class="badge badge-success">Oui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Non</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-info"><?= esc($wifi['chiffrement']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?= anchor(
                                            '/gingembre/salle_6/wifi/edit/' . $wifi['numero'],
                                            '<i class="fas fa-edit"></i>',
                                            ['class' => 'btn btn-sm btn-info', 'title' => 'Modifier']
                                    ) ?>
                                    <?= anchor(
                                            '/gingembre/salle_6/wifi/delete/' . $wifi['numero'],
                                            '<i class="fas fa-trash"></i>',
                                            [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'title' => 'Supprimer',
                                                    'onclick' => 'return confirm("Êtes-vous sûr de vouloir supprimer ce WiFi ?")'
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
                    // Construire l'URL avec les paramètres
                    $queryParams = [];
                    if ($search) $queryParams['search'] = $search;
                    if ($sort !== 'numero') $queryParams['sort'] = $sort;
                    if ($order !== 'ASC') $queryParams['order'] = $order;

                    $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                    ?>
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'default_full', 0, $queryString) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>