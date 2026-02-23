<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Objets Déclencheurs - Salle 5</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables -->
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
                <?= anchor('/gingembre/accueil',
                        '<i class="fas fa-home"></i> Accueil Admin',
                        ['class' => 'nav-link']
                ) ?>
            </li>
            <li class="nav-item">
                <?= anchor('/gingembre/logout',
                        '<i class="fas fa-sign-out-alt"></i> Déconnexion',
                        ['class' => 'nav-link']
                ) ?>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <?= anchor('/gingembre/salle_5',
                '<span class="brand-text font-weight-light">Admin Salle 5</span>',
                ['class' => 'brand-link']
        ) ?>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5',
                                '<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>',
                                ['class' => 'nav-link active']
                        ) ?>

                    </li>
                    <li class="nav-header">DONNÉES SÉCURITÉ</li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/objet',
                                '<i class="nav-icon fas fa-id-card"></i><p>Objets</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/objet_declencheur',
                                '<i class="nav-icon fas fa-question-circle"></i><p>Objets déclencheurs</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/objet_activite',
                                '<i class="nav-icon fas fa-question-circle"></i><p>Objets Activité</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/question',
                                '<i class="nav-icon fas fa-question-circle"></i><p>Questions</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/reponse',
                                '<i class="nav-icon fas fa-question-circle"></i><p>Réponses</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/avoir_rep',
                                '<i class="nav-icon fas fa-question-circle"></i><p>Liaison act/rép</p>',
                                ['class' => 'nav-link']
                        ) ?>

                    </li>
                    <li class="nav-header">DONNÉES COMMUNES</li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/activite',
                                '<i class="nav-icon fas fa-tasks"></i><p>Activités</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/explication',
                                '<i class="nav-icon fas fa-info-circle"></i><p>Explications</p>',
                                ['class' => 'nav-link']
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_5/indice',
                                '<i class="nav-icon fas fa-lightbulb"></i><p>Indices</p>',
                                ['class' => 'nav-link']
                        ) ?>
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
                        <h1>Gestion des Objets déclencheurs d'activités</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor(
                                '/gingembre/salle_5/objet_declencheur/create',
                                '<i class="fas fa-plus"></i> Nouvel Objet déclencheur',
                                ['class' => 'btn btn-success float-right']
                        ) ?>
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
                        <h3 class="card-title">Liste des Objets Déclencheurs</h3>
                    </div>
                    <div class="card-body">
                        <table id="objetsTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>nom</th>
                                <th>image</th>
                                <th>x</th>
                                <th>y</th>
                                <th>width</th>
                                <th>height</th>
                                <th>zone_path</th>
                                <th>numéro activité</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($objetsDeclencheurs as $objetD): ?>
                                <tr>
                                    <td><?= $objetD->id ?></td>
                                    <td><?= esc($objetD->nom) ?></td>
                                    <td><?= esc(substr($objetD->image_path,15)) ?></td>
                                    <td><?= esc($objetD->x) ?></td>
                                    <td><?= esc($objetD->y) ?></td>
                                    <td><?= esc($objetD->width) ?></td>
                                    <td><?= esc($objetD->height) ?></td>
                                    <td><?= esc($objetD->zone_path) ?></td>
                                    <td><?= esc($objetD->numero_activite) ?></td>
                                    <td>
                                        <div class="btn-group" >
                                        <?= anchor(
                                                '/gingembre/salle_5/objet_declencheur/edit/' . $objetD->id,
                                                '<i class="fas fa-edit"></i>',
                                                [
                                                        'class' => 'btn btn-sm btn-primary mr-1',
                                                        'title' => 'Modifier'
                                                ]
                                        ) ?>
                                        <?= form_open(
                                                '/gingembre/salle_5/objet_declencheur/delete/' . $objetD->id,
                                                ['onsubmit' => "return confirm('Êtes-vous sûr de vouloir supprimer cet objet déclencheur d\\'activité ? Cette action supprimera aussi ses liens avec les activités.')"]
                                        )
                                        ?>
                                        <?= csrf_field() ?>
                                        <?= form_button([
                                                'type'    => 'submit',
                                                'class'   => 'btn btn-sm btn-danger',
                                                'title'   => 'Supprimer',
                                                'content' => '<i class="fas fa-trash"></i>'
                                        ]) ?>
                                        <?= form_close() ?>
                                        </div>
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

    <footer class="main-footer">
        <strong>Administration Salle 5</strong> - Made in Val de Loire
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#objetsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
            },
            "order": [[0, "asc"]]
        });
    });
</script>
</body>
</html>