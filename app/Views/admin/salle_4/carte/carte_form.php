<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($carte) ? 'Modifier' : 'Ajouter' ?> une Carte - Salle 4</title>

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
                        <?= anchor('/gingembre/salle_4', '<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-header">DONNÉES RANSOMWARE</li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/carte', '<i class="nav-icon fas fa-id-card"></i><p>Cartes</p>', ['class' => 'nav-link active']) ?>
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?= isset($carte) ? 'Modifier' : 'Ajouter' ?> une Carte</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor('/gingembre/salle_4/carte', '<i class="fas fa-arrow-left"></i> Retour', ['class' => 'btn btn-secondary float-right']) ?>
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
                    <?= form_open(isset($carte) ? '/gingembre/salle_4/carte/update/' . $carte['numero'] : '/gingembre/salle_4/carte/store') ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="image">Image <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="image"
                                       name="image"
                                       value="<?= old('image', isset($carte) ? $carte['image'] : '') ?>"
                                       placeholder="carte_pins_01.png"
                                       maxlength="50"
                                       required>
                                <small class="form-text text-muted">Nom du fichier image (max 50 caractères)</small>
                            </div>

                            <div class="form-group">
                                <label for="explication">Explication <span class="text-danger">*</span></label>
                                <textarea class="form-control"
                                          id="explication"
                                          name="explication"
                                          rows="3"
                                          required><?= old('explication', isset($carte) ? $carte['explication'] : '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="type_carte">Type de Carte <span class="text-danger">*</span></label>
                                <select class="form-control" id="type_carte" name="type_carte" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="bonne_pratique" <?= old('type_carte', isset($carte) ? $carte['type_carte'] : '') == 'bonne_pratique' ? 'selected' : '' ?>>
                                        Bonne pratique
                                    </option>
                                    <option value="piege" <?= old('type_carte', isset($carte) ? $carte['type_carte'] : '') == 'piege' ? 'selected' : '' ?>>
                                        Piège
                                    </option>
                                </select>
                            </div>

                            <div class="form-group" id="explication_piege_group" style="display: none;">
                                <label for="explication_piege">Explication du Piège</label>
                                <textarea class="form-control"
                                          id="explication_piege"
                                          name="explication_piege"
                                          rows="2"><?= old('explication_piege', isset($carte) ? $carte['explication_piege'] : '') ?></textarea>
                                <small class="form-text text-muted">Pourquoi cette carte est un piège</small>
                            </div>

                            <div class="form-group">
                                <label for="activite_numero">Activité Associée</label>
                                <select class="form-control" id="activite_numero" name="activite_numero">
                                    <option value="">Aucune activité</option>
                                    <?php foreach ($activites as $activite): ?>
                                        <option value="<?= $activite['numero'] ?>"
                                            <?= old('activite_numero', isset($carte) ? $carte['activite_numero'] : '') == $activite['numero'] ? 'selected' : '' ?>>
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
                            <?= anchor('/gingembre/salle_4/carte', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
                        </div>

                    <?= form_close() ?>
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
<script>
    $(document).ready(function() {
        function toggleExplicationPiege() {
            if ($('#type_carte').val() === 'piege') {
                $('#explication_piege_group').show();
            } else {
                $('#explication_piege_group').hide();
            }
        }

        toggleExplicationPiege();
        $('#type_carte').on('change', toggleExplicationPiege);
    });
</script>
</body>
</html>
