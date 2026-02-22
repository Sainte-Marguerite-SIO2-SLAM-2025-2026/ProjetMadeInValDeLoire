<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Indices - Admin Salle 5</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="<?= base_url('/gingembre/accueil') ?>" class="nav-link">
                    <i class="fas fa-home"></i> Accueil Admin
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('/gingembre/logout') ?>" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url('/gingembre/salle_5') ?>" class="brand-link">
            <span class="brand-text font-weight-light">Admin Salle 5</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5') ?>" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">DONNÉES SÉCURITÉ</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objet') ?>" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Objets</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objet_declencheur') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Objets déclencheurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objet_activite') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Objets Activité</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/questions') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Questions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/reponse') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Réponses</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/liaisons') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Liaison quest/rép</p>
                        </a>
                    </li>
                    <li class="nav-header">DONNÉES COMMUNES</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/activite') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Activités</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/explication') ?>" class="nav-link">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <p>Explications</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/indice') ?>" class="nav-link">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>Indices</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestion des Indices (500-599)</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('/gingembre/salle_5/indice/create') ?>" class="btn btn-success float-right">
                            <i class="fas fa-plus"></i> Nouvel Indice
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des Indices de la Salle 5</h3>
                    </div>
                    <div class="card-body">
                        <table id="indicesTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 80px;">N°</th>
                                <th>Libellé</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($indices as $indice): ?>
                                <tr>
                                    <td><strong><?= $indice['numero'] ?></strong></td>
                                    <td><?= substr(strip_tags($indice['libelle']), 0, 150) ?><?= strlen($indice['libelle']) > 150 ? '...' : '' ?></td>
                                    <td>
                                        <a href="<?= base_url('/gingembre/salle_5/indice/edit/' . $indice['numero']) ?>"
                                           class="btn btn-sm btn-primary"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('/gingembre/salle_5/indice/delete/' . $indice['numero']) ?>"
                                           class="btn btn-sm btn-danger"
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet indice ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Administration Salle 5</strong> - Made in Val de Loire
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#indicesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
            },
            "order": [[0, "asc"]]
        });
    });
</script>
</body>
</html>