<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration Salle 4 - Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?= anchor('/gingembre/accueil', '<i class="fas fa-home"></i> Accueil Admin', ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item">
                <?= anchor('/gingembre/logout', '<i class="fas fa-sign-out-alt"></i> Déconnexion', ['class' => 'nav-link']) ?>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <?= anchor('/gingembre/salle_4', '<span class="brand-text font-weight-light">Admin Salle 4</span>', ['class' => 'brand-link']) ?>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4', '<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>', ['class' => 'nav-link active']) ?>
                    </li>
                    <li class="nav-header">DONNÉES RANSOMWARE</li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/carte', '<i class="nav-icon fas fa-id-card"></i><p>Cartes</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/question', '<i class="nav-icon fas fa-question-circle"></i><p>Questions</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-header">DONNÉES COMMUNES</li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/activite', '<i class="nav-icon fas fa-tasks"></i><p>Activités</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/explication', '<i class="nav-icon fas fa-info-circle"></i><p>Explications</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/indice', '<i class="nav-icon fas fa-lightbulb"></i><p>Indices</p>', ['class' => 'nav-link']) ?>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Dashboard - Salle 4 Ransomware</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-3">Données Spécifiques Ransomware</h3>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $total_cartes ?></h3>
                                <p>Total Cartes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/carte', 'Gérer <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $cartes_bonnes_pratiques ?></h3>
                                <p>Bonnes Pratiques</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/carte', 'Voir <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= $cartes_pieges ?></h3>
                                <p>Pièges</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/carte', 'Voir <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $total_questions ?></h3>
                                <p>Questions Quiz</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/question', 'Gérer <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-3 mt-3">Données Communes (Plage 400-499)</h3>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?= $total_activites ?></h3>
                                <p>Activités</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/activite', 'Gérer <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?= $total_explications ?></h3>
                                <p>Explications</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/explication', 'Gérer <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3><?= $total_indices ?></h3>
                                <p>Indices</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <?= anchor('/gingembre/salle_4/indice', 'Gérer <i class="fas fa-arrow-circle-right"></i>', ['class' => 'small-box-footer']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Répartition des réponses du Quiz</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <div class="text-success">
                                            <i class="fas fa-check-circle fa-3x"></i>
                                            <h4><?= $stats_reponses['vrai'] ?></h4>
                                            <p>Questions VRAI</p>
                                        </div>
                                    </div>
                                    <div class="col-6 text-center">
                                        <div class="text-danger">
                                            <i class="fas fa-times-circle fa-3x"></i>
                                            <h4><?= $stats_reponses['faux'] ?></h4>
                                            <p>Questions FAUX</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Actions rapides</h3>
                            </div>
                            <div class="card-body">
                                <?= anchor('/gingembre/salle_4/carte/create', '<i class="fas fa-plus"></i> Ajouter une Carte', ['class' => 'btn btn-success btn-block mb-2']) ?>
                                <?= anchor('/gingembre/salle_4/question/create', '<i class="fas fa-plus"></i> Ajouter une Question', ['class' => 'btn btn-primary btn-block mb-2']) ?>
                                <?= anchor('/gingembre/salle_4/activite/create', '<i class="fas fa-plus"></i> Ajouter une Activité', ['class' => 'btn btn-secondary btn-block']) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Administration Salle 4</strong> - Made in Val de Loire
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
