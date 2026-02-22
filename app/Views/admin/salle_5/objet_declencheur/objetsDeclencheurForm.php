
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un Objet Déclencheur - Salle 5</title>

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
                        <a href="<?= base_url('/gingembre/salle_5/question') ?>" class="nav-link">
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
                        <a href="<?= base_url('/gingembre/salle_5/avoir_rep') ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Liaison act/rép</p>
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
                        <h1><?= isset($objetDeclencheur) ? 'Modifier' : 'Ajouter' ?> un Objet Déclencheur</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('/gingembre/salle_5/objet_declencheur') ?>" class="btn btn-secondary float-right">
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
                    <form action="<?= isset($objetDeclencheur) ? base_url('/gingembre/salle_5/objet_declencheur/update/' . $objetDeclencheur->id) : base_url('/gingembre/salle_5/objet_declencheur/store') ?>"
                          method="post">
                        <?= csrf_field() ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="nom">Nom <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="nom"
                                       name="nom"
                                       value="<?= old('nom', isset($objetDeclencheur) ? $objetDeclencheur->nom : '') ?>"
                                       placeholder="Téléphone_mobile"
                                       maxlength="50"
                                       required>
                                <small class="form-text text-muted">Nom de l'objet (max 50 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="image">Image <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="image"
                                       name="image"
                                       value="<?= old('image', isset($objetDeclencheur) ? substr($objetDeclencheur->image_path, 15) : '') ?>"
                                       placeholder="carte_pins_01.png"
                                       maxlength="50"
                                       required>
                                <small class="form-text text-muted">Nom du fichier image (max 50 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="x">Position X<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="x"
                                       name="x"
                                       value="<?= old('x', isset($objetDeclencheur) ? $objetDeclencheur->x : '') ?>"
                                       placeholder="192.63"
                                       maxlength="50"
                                >
                                <small class="form-text text-muted">Position X de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="y">Position Y<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="y"
                                       name="y"
                                       value="<?= old('y', isset($objetDeclencheur) ? $objetDeclencheur->y : '') ?>"
                                       placeholder="192.63"
                                       maxlength="50"
                                >
                                <small class="form-text text-muted">Position Y de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="width">Largeur <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="width"
                                       name="width"
                                       value="<?= old('width', isset($objetDeclencheur) ? $objetDeclencheur->width : '') ?>"
                                       placeholder="200"
                                       maxlength="50"
                                >
                                <small class="form-text text-muted">Largeur de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="height">Hauteur <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="height"
                                       name="height"
                                       value="<?= old('height', isset($objetDeclencheur) ? $objetDeclencheur->height : '') ?>"
                                       placeholder="200"
                                       maxlength="50"
                                >
                                <small class="form-text text-muted">Hauteur de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="zone_path">Zone</label>
                                <input type="text"
                                       class="form-control"
                                       id="zone_path"
                                       name="zone_path"
                                       value="<?= old('zone_path', isset($objetDeclencheur) ? $objetDeclencheur->zone_path : '') ?>"
                                       placeholder="m200....."
                                       maxlength="80"
                                >
                                <small class="form-text text-muted">Zone de l'objet</small>
                            </div>

                            <div class="form-group">
                                <label for="numero_activite">Activité Déclenchée</label>
                                <select class="form-control" id="numero_activite" name="numero_activite">
                                    <option value="">Aucune activité</option>
                                    <?php foreach ($activites as $activite): ?>
                                        <option value="<?= $activite['numero'] ?>"
                                                <?= old('numero_activite', isset($objetDeclencheur) ? $objetDeclencheur->numero_activite : '') == $activite['numero'] ? 'selected' : '' ?>>
                                            [<?= $activite['numero'] ?>] <?= esc(substr($activite['libelle'], 0, 50)) ?>...
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <a href="<?= base_url('/gingembre/salle_5/objet_declencheur') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
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