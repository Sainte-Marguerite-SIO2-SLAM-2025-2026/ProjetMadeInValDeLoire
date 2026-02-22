<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration Salle 5 - Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
                <h1>Dashboard - Salle 5 Sécurité physique et matérielle</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Statistiques Ransomware -->
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-3">Données Spécifiques</h3>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $totalObjets ?></h3>
                                <p>Total Objets</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/objet',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $totalObjetsDeclencheurs ?></h3>
                                <p>Objets déclencheurs d'activité</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/objet_declencheur',
                                    'Voir <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $totalObjetsActivites ?></h3>
                                <p>Objets utilisés dans activités</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/objet_activite',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3><?= $totalModeEmploi ?></h3>
                                <p>Questions</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/question',
                                    'Voir <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $message ?></h3>
                                <p>Explication réponse</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/reponse',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $avoirRep ?></h3>
                                <p>Liaison activités/réponses</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/avoir_rep',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>
                </div>

                <!-- Statistiques Données Communes -->
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-3 mt-3">Données Communes (Plage 500-599)</h3>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?= $totalActivites ?></h3>
                                <p>Activités</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/activite',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?= $totalExplications ?></h3>
                                <p>Explications</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/explication',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3><?= $totalIndices ?></h3>
                                <p>Indices</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <?= anchor(
                                    '/gingembre/salle_5/indice',
                                    'Gérer <i class="fas fa-arrow-circle-right"></i>',
                                    ['class' => 'small-box-footer']
                            ) ?>
                        </div>
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
</body>
</html>