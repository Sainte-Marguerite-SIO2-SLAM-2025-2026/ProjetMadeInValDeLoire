<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Gestion des Propositions WiFi
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Propositions WiFi
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><?= anchor('/gingembre/accueil', 'Accueil') ?></li>
    <li class="breadcrumb-item active">Propositions WiFi</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Liste des propositions WiFi (<?= $total ?>)</h3>
                </div>
                <div class="col-md-6 text-right">
                    <?= anchor('/gingembre/salle_6/proposer-wifi/create', '<i class="fas fa-plus"></i> Nouvelle proposition', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Barre de recherche -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <?= form_open('/gingembre/salle_6/proposer-wifi', ['method' => 'get', 'class' => 'form-inline']) ?>
                    <div class="input-group">
                        <?= form_input([
                                'name' => 'search',
                                'class' => 'form-control',
                                'placeholder' => 'Rechercher...',
                                'value' => esc($search)
                        ]) ?>

                        <?php if ($sort !== 'wifi_numero'): ?>
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
                                <?= anchor('/gingembre/salle_6/proposer-wifi', '<i class="fas fa-times"></i>', ['class' => 'btn btn-secondary']) ?>
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
                        <th style="width: 120px">
                            <?php
                            $sortParams = [
                                    'sort' => 'wifi_numero',
                                    'order' => ($sort == 'wifi_numero' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/proposer-wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'N° WiFi ' . ($sort == 'wifi_numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th>
                            <?php
                            $sortParams = [
                                    'sort' => 'wifi_nom',
                                    'order' => ($sort == 'wifi_nom' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/proposer-wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Nom WiFi ' . ($sort == 'wifi_nom' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 150px">
                            <?php
                            $sortParams = [
                                    'sort' => 'activite_numero',
                                    'order' => ($sort == 'activite_numero' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/proposer-wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'N° Activité ' . ($sort == 'activite_numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 140px">
                            <?php
                            $sortParams = [
                                    'sort' => 'zone_clique',
                                    'order' => ($sort == 'zone_clique' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/proposer-wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Zone cliquée ' . ($sort == 'zone_clique' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 140px" class="text-center">
                            <?php
                            $sortParams = [
                                    'sort' => 'bonne_reponse',
                                    'order' => ($sort == 'bonne_reponse' && $order == 'ASC') ? 'DESC' : 'ASC'
                            ];
                            if ($search) $sortParams['search'] = $search;
                            $sortUrl = '/gingembre/salle_6/proposer-wifi?' . http_build_query($sortParams);
                            ?>
                            <?= anchor($sortUrl,
                                    'Bonne réponse ' . ($sort == 'bonne_reponse' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'),
                                    ['class' => 'text-dark']
                            ) ?>
                        </th>
                        <th style="width: 150px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($propositions)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune proposition trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($propositions as $prop): ?>
                            <tr>
                                <td><?= esc($prop['wifi_numero']) ?></td>
                                <td><?= esc($prop['wifi_nom'] ?? 'N/A') ?></td>
                                <td><?= esc($prop['activite_numero']) ?></td>
                                <td><span class="badge badge-secondary"><?= esc($prop['zone_clique']) ?></span></td>
                                <td class="text-center">
                                    <?php if ($prop['bonne_reponse'] == 1): ?>
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Oui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="fas fa-times"></i> Non</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= anchor(
                                            '/gingembre/salle_6/proposer-wifi/edit/' . $prop['wifi_numero'] . '/' . $prop['activite_numero'],
                                            '<i class="fas fa-edit"></i>',
                                            ['class' => 'btn btn-sm btn-info', 'title' => 'Modifier']
                                    ) ?>
                                    <?= anchor(
                                            '/gingembre/salle_6/proposer-wifi/delete/' . $prop['wifi_numero'] . '/' . $prop['activite_numero'],
                                            '<i class="fas fa-trash"></i>',
                                            [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'title' => 'Supprimer',
                                                    'onclick' => 'return confirm("Êtes-vous sûr de vouloir supprimer cette proposition ?")'
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
                    if ($sort !== 'wifi_numero') $queryParams['sort'] = $sort;
                    if ($order !== 'ASC') $queryParams['order'] = $order;

                    $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                    ?>
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'default_full', 0, $queryString) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>