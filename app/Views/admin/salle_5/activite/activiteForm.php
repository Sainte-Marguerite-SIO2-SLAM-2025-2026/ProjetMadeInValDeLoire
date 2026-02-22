<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($activite) ? 'Modifier' : 'Ajouter' ?> une Activité - Admin Salle 5</title>

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
                        <h1><?= isset($activite) ? 'Modifier' : 'Ajouter' ?> une Activité</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor('/gingembre/salle_5/activite',
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
                    <form action="<?= isset($activite) ? base_url('/gingembre/salle_5/activite/update/' . $activite['numero']) : base_url('/gingembre/salle_5/activite/store') ?>"
                          method="post">
                        <?= csrf_field() ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="numero">Numéro <span class="text-danger">*</span></label>
                                <?php if (isset($activite)): ?>
                                    <input type="number" class="form-control" value="<?= $activite['numero'] ?>" readonly>
                                    <small class="form-text text-muted">Le numéro ne peut pas être modifié</small>
                                <?php else: ?>
                                    <input type="number"
                                           class="form-control"
                                           id="numero"
                                           name="numero"
                                           value="<?= old('numero', $next_numero ?? '') ?>"
                                           min="500"
                                           max="599"
                                           required>
                                    <small class="form-text text-muted">Numéro suggéré: <?= $next_numero ?? '' ?> (plage 500-599)</small>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="libelle">Libellé <span class="text-danger">*</span></label>
                                <textarea class="form-control"
                                          id="libelle"
                                          name="libelle"
                                          rows="4"
                                          required><?= old('libelle', isset($activite) ? $activite['libelle'] : '') ?></textarea>
                                <small class="form-text text-muted">Description de l'activité</small>
                            </div>

                            <div class="form-group">
                                <label for="image">Image de fond<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="image"
                                       name="image"
                                       value="<?= old('image', isset($activite) ? substr($activite['image'], 18) : '') ?>"
                                       placeholder="frise_reaction_ransomware.png">
                                <small class="form-text text-muted">Nom du fichier image</small>
                            </div>

                            <div class="form-group">
                                <label for="explication_numero">Explication Associée</label>
                                <select class="form-control" id="explication_numero" name="explication_numero">
                                    <option value="">Aucune explication</option>
                                    <?php foreach ($explications as $explication): ?>
                                        <option value="<?= $explication['numero'] ?>"
                                            <?= old('explication_numero', isset($activite) ? $activite['explication_numero'] : '') == $explication['numero'] ? 'selected' : '' ?>>
                                            [<?= $explication['numero'] ?>] <?= esc(substr(strip_tags($explication['libelle']), 0, 60)) ?>...
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="width_img">Largeur de l'image de fond<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="width_img"
                                       name="width_img"
                                       value="<?= old('width_img', isset($activite) ? $activite['width_img'] : '') ?>"
                                       placeholder="1920">
                                <small class="form-text text-muted">Largeur de l'image de fond</small>
                            </div>

                            <div class="form-group">
                                <label for="height_img">Taille de l'image de fond<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="height_img"
                                       name="height_img"
                                       value="<?= old('height_img', isset($activite) ? $activite['height_img'] : '') ?>"
                                       placeholder="1080">
                                <small class="form-text text-muted">Hauteur de l'image de fond</small>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                               <span>Il est recommandé de mettre une largeur de
                                   1920 pour une hauteur de 1080 pour l'image de fond : salle_bureau_compil.svg
                                   et 1375 et 917 pour : bureau.svg</span>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <?= anchor('/gingembre/salle_5/activite',
                                    '<i class="fas fa-times"></i> Annuler',
                                    ['class' => 'btn btn-secondary']
                            ) ?>
                        </div>
                    </form>
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