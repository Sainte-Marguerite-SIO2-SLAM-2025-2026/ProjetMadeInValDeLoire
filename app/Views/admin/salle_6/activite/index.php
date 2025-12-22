<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Gestion des Activités
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"><h3 class="card-title">Liste des Activités (<?= $total ?>)</h3></div>
                <div class="col-md-6 text-right">
                    <?= anchor('/gingembre/salle_6/activite/create', '<i class="fas fa-plus"></i> Nouvelle Activité', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <?= form_open('/gingembre/salle_6/activite', ['method' => 'get', 'class' => 'form-inline']) ?>
                    <div class="input-group">
                        <?= form_input(['name' => 'search', 'class' => 'form-control', 'placeholder' => 'Rechercher...', 'value' => esc($search)]) ?>
                        <div class="input-group-append">
                            <?= form_button(['type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-search"></i>']) ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width: 80px">
                            <?php $sortParams = ['sort' => 'numero', 'order' => ($sort == 'numero' && $order == 'ASC') ? 'DESC' : 'ASC']; if ($search) $sortParams['search'] = $search; ?>
                            <?= anchor('/gingembre/salle_6/activite?' . http_build_query($sortParams), 'Numéro ' . ($sort == 'numero' ? '<i class="fas fa-sort-' . strtolower($order) . '"></i>' : '<i class="fas fa-sort text-muted"></i>'), ['class' => 'text-dark']) ?>
                        </th>
                        <th>Libellé</th>
                        <th>Type</th>
                        <th>Difficulté</th>
                        <th>Salle</th>
                        <th class="text-center">Verrou</th>
                        <th style="width: 150px" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($activites)): ?>
                        <tr><td colspan="7" class="text-center">Aucune activité trouvée</td></tr>
                    <?php else: ?>
                        <?php foreach ($activites as $activite): ?>
                            <tr>
                                <td><?= esc($activite['numero']) ?></td>
                                <td><?= esc($activite['libelle']) ?></td>
                                <td><?= esc($activite['type_libelle'] ?? '-') ?></td>
                                <td><?= esc($activite['difficulte_libelle'] ?? '-') ?></td>
                                <td><?= esc($activite['salle_libelle'] ?? '-') ?></td>
                                <td class="text-center">
                                    <span class="badge badge-<?= ($activite['verrouillage'] == 1) ? 'warning' : 'success' ?>">
                                        <?= ($activite['verrouillage'] == 1) ? 'Oui' : 'Non' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?= anchor('/gingembre/salle_6/activite/edit/' . $activite['numero'], '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-info']) ?>
                                    <?= anchor('/gingembre/salle_6/activite/delete/' . $activite['numero'], '<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("Supprimer cette activité ?")']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($total > $perPage): ?>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'default_full', 0, '?' . http_build_query(array_filter(['search' => $search, 'sort' => $sort, 'order' => $order]))) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>