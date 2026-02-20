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
                        <a href="<?= base_url('/gingembre/salle_5/objets_declencheurs') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Objets déclencheurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objets_declencheurs') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Objets Activité</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objets_declencheurs') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Questions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objets_declencheurs') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Réponses</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_5/objets_declencheurs') ?>" class="nav-link">
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
                            <a href="<?= base_url('/gingembre/salle_5/objet') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_4/objets_declencheurs') ?>" class="small-box-footer">
                                Voir <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_4/question') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_4/mode_emploi') ?>" class="small-box-footer">
                                Voir <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $messageVrai ?></h3>
                                <p>Explication bonne réponse</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <a href="<?= base_url('/gingembre/salle_4/question') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $messageFaux ?></h3>
                                <p>Explication mauvaise réponse</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <a href="<?= base_url('/gingembre/salle_4/question') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>



                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $avoirRep ?></h3>
                                <p>Liaison questions/réponses</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <a href="<?= base_url('/gingembre/salle_4/question') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_5/activite') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_4/explication') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
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
                            <a href="<?= base_url('/gingembre/salle_4/indice') ?>" class="small-box-footer">
                                Gérer <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
        </section>
    </div>
<!---->
<!--                <!-- Détails et Actions -->-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="card">-->
<!--                            <div class="card-header bg-primary">-->
<!--                                <h3 class="card-title">Répartition des réponses du Quiz</h3>-->
<!--                            </div>-->
<!--                            <div class="card-body">-->
<!--                                <div class="row">-->
<!--                                    <div class="col-6 text-center">-->
<!--                                        <div class="text-success">-->
<!--                                            <i class="fas fa-check-circle fa-3x"></i>-->
<!--                                            <h4>--><?php //= $stats_reponses['vrai'] ?><!--</h4>-->
<!--                                            <p>Questions VRAI</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-6 text-center">-->
<!--                                        <div class="text-danger">-->
<!--                                            <i class="fas fa-times-circle fa-3x"></i>-->
<!--                                            <h4>--><?php //= $stats_reponses['faux'] ?><!--</h4>-->
<!--                                            <p>Questions FAUX</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-6">-->
<!--                        <div class="card">-->
<!--                            <div class="card-header bg-info">-->
<!--                                <h3 class="card-title">Actions rapides</h3>-->
<!--                            </div>-->
<!--                            <div class="card-body">-->
<!--                                <a href="--><?php //= base_url('/gingembre/salle_4/carte/create') ?><!--" class="btn btn-success btn-block mb-2">-->
<!--                                    <i class="fas fa-plus"></i> Ajouter une Carte-->
<!--                                </a>-->
<!--                                <a href="--><?php //= base_url('/gingembre/salle_4/question/create') ?><!--" class="btn btn-primary btn-block mb-2">-->
<!--                                    <i class="fas fa-plus"></i> Ajouter une Question-->
<!--                                </a>-->
<!--                                <a href="--><?php //= base_url('/gingembre/salle_4/activite/create') ?><!--" class="btn btn-secondary btn-block">-->
<!--                                    <i class="fas fa-plus"></i> Ajouter une Activité-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->



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