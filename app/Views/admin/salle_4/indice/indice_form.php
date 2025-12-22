<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($indice) ? 'Modifier' : 'Ajouter' ?> un Indice - Admin Salle 4</title>

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
        <a href="<?= base_url('/gingembre/salle_4') ?>" class="brand-link">
            <span class="brand-text font-weight-light">Admin Salle 4</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">DONNÉES RANSOMWARE</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4/carte') ?>" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Cartes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4/question') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Questions</p>
                        </a>
                    </li>
                    <li class="nav-header">DONNÉES COMMUNES</li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4/activite') ?>" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Activités</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4/explication') ?>" class="nav-link">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <p>Explications</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_4/indice') ?>" class="nav-link active">
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
                        <h1><?= isset($indice) ? 'Modifier' : 'Ajouter' ?> un Indice</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('/gingembre/salle_4/indice') ?>" class="btn btn-secondary float-right">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <form action="<?= isset($indice) ? base_url('/gingembre/salle_4/indice/update/' . $indice['numero']) : base_url('/gingembre/salle_4/indice/store') ?>"
                          method="post">
                        <?= csrf_field() ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="numero">Numéro <span class="text-danger">*</span></label>
                                <?php if (isset($indice)): ?>
                                    <input type="number" class="form-control" value="<?= $indice['numero'] ?>" readonly>
                                    <small class="form-text text-muted">Le numéro ne peut pas être modifié</small>
                                <?php else: ?>
                                    <input type="number"
                                           class="form-control"
                                           id="numero"
                                           name="numero"
                                           value="<?= old('numero', $next_numero ?? '') ?>"
                                           min="400"
                                           max="499"
                                           required>
                                    <small class="form-text text-muted">Numéro suggéré: <?= $next_numero ?? '' ?> (plage 400-499)</small>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="libelle">Contenu de l'Indice <span class="text-danger">*</span></label>
                                <textarea class="form-control"
                                          id="libelle"
                                          name="libelle"
                                          rows="6"
                                          required><?= old('libelle', isset($indice) ? $indice['libelle'] : '') ?></textarea>
                                <small class="form-text text-muted">
                                    Texte d'aide qui sera affiché aux joueurs
                                </small>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb"></i>
                                <strong>Conseil :</strong> Un bon indice guide le joueur sans donner directement la réponse.
                                Soyez suffisamment clair pour aider, mais gardez une part de challenge.
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <a href="<?= base_url('/gingembre/salle_4/indice') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Administration Salle 4</strong> - Made in Val de Loire
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>