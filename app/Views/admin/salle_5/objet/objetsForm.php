
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un Objet - Salle 5</title>

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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un Objet</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor(
                                '/gingembre/salle_5/objet',
                                '<i class="fas fa-arrow-left"></i> Retour',
                                ['class' => 'btn btn-secondary float-right']
                        ) ?>
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
                    <form action="<?= isset($objet) ? base_url('/gingembre/salle_5/objet/update/' . $objet->id) : base_url('/gingembre/salle_5/objet/store') ?>"
                          method="post">
                        <?= csrf_field() ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="nom">Nom <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="nom"
                                       name="nom"
                                       value="<?= old('nom', isset($objet) ? $objet->nom : '') ?>"
                                       placeholder="Téléphone_mobile"
                                       maxlength="50"
                                       required>
                                <small class="form-text text-muted">Nom de l'objet (max 50 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="x">Position X<span class="text-danger"> sauf objet drag n drop</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="x"
                                       name="x"
                                       value="<?= old('x', isset($objet) ? $objet->x : '') ?>"
                                       placeholder="192.63"
                                       maxlength="50"
                                       >
                                <small class="form-text text-muted">Position X de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="y">Position Y<span class="text-danger"> sauf objet drag n drop</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="y"
                                       name="y"
                                       value="<?= old('y', isset($objet) ? $objet->y : '') ?>"
                                       placeholder="192.63"
                                       maxlength="50"
                                       >
                                <small class="form-text text-muted">Position Y de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="width">Largeur <span class="text-danger"> sauf objet drag n drop</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="width"
                                       name="width"
                                       value="<?= old('width', isset($objet) ? $objet->width : '') ?>"
                                       placeholder="200"
                                       maxlength="50"
                                       >
                                <small class="form-text text-muted">Largeur de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="height">Hauteur <span class="text-danger"> sauf objet drag n drop</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="height"
                                       name="height"
                                       value="<?= old('height', isset($objet) ? $objet->height : '') ?>"
                                       placeholder="200"
                                       maxlength="50"
                                       >
                                <small class="form-text text-muted">Hauteur de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="image">Image <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="image"
                                       name="image"
                                       value="<?= old('image', isset($objet) ? substr($objet->image, 15) : '') ?>"
                                       placeholder="carte_pins_01.png"
                                       maxlength="50"
                                       required>
                                <small class="form-text text-muted">Nom du fichier image (max 50 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="texte_image">Texte sur l'objet</label>
                                <input type="text"
                                       class="form-control"
                                       id="texte_image"
                                       name="texte_image"
                                       value="<?= old('texte_image', isset($objet) ? $objet->texte : '') ?>"
                                       placeholder="une clé est utile..."
                                       maxlength="80"
                                       >
                                <small class="form-text text-muted">max 80 caractères</small>
                            </div>

                            <div class="form-group">
                                <label for="hover">Texte au survol</label>
                                <input type="text"
                                       class="form-control"
                                       id="hover"
                                       name="hover"
                                       value="<?= old('hover', isset($objet) ? $objet->hover : '') ?>"
                                       placeholder="une clé est utile..."
                                       maxlength="80"
                                       >
                                <small class="form-text text-muted">Texte au survol de l'objet (max 80 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="cliquable">Objet cliquable <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="cliquable"
                                           id="cliquable_vrai"
                                           value=null
                                            <?= old('cliquable', isset($objet) ? $objet->cliquable : '') == null ? 'checked' : '' ?>
                                           required>
                                    <label class="form-check-label" for="reponse_vrai">
                                        Oui
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="cliquable"
                                           id="cliquable_faux"
                                           value="non"
                                            <?= old('cliquable', isset($objet) ? $objet->cliquable : '') === 'non' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="reponse_faux">
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <?= anchor(
                                    '/gingembre/salle_5/objet',
                                    '<i class="fas fa-times"></i> Annuler',
                                    ['class' => 'btn btn-secondary']
                            ) ?>
                        </div>
                    </form>
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
</body>
</html>