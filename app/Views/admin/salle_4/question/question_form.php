<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($question) ? 'Modifier' : 'Ajouter' ?> une Question - Salle 4</title>

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
                        <?= anchor('/gingembre/salle_4/carte', '<i class="nav-icon fas fa-id-card"></i><p>Cartes</p>', ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= anchor('/gingembre/salle_4/question', '<i class="nav-icon fas fa-question-circle"></i><p>Questions</p>', ['class' => 'nav-link active']) ?>
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
                        <h1><?= isset($question) ? 'Modifier' : 'Ajouter' ?> une Question</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor('/gingembre/salle_4/question', '<i class="fas fa-arrow-left"></i> Retour', ['class' => 'btn btn-secondary float-right']) ?>
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
                    <?= form_open(isset($question) ? '/gingembre/salle_4/question/update/' . $question['numero'] : '/gingembre/salle_4/question/store') ?>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="libelle">Question <span class="text-danger">*</span></label>
                                <textarea class="form-control"
                                          id="libelle"
                                          name="libelle"
                                          rows="3"
                                          placeholder="Un ransomware peut se propager via une pièce jointe email malveillante"
                                          required><?= old('libelle', isset($question) ? $question['libelle'] : '') ?></textarea>
                                <small class="form-text text-muted">Énoncé de la question pour le quiz</small>
                            </div>

                            <div class="form-group">
                                <label for="reponse">Réponse Correcte <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="reponse"
                                           id="reponse_vrai"
                                           value="1"
                                        <?= old('reponse', isset($question) ? $question['reponse'] : '') == '1' ? 'checked' : '' ?>
                                           required>
                                    <label class="form-check-label" for="reponse_vrai">
                                        <span class="badge badge-success"><i class="fas fa-check"></i> VRAI</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="reponse"
                                           id="reponse_faux"
                                           value="0"
                                        <?= old('reponse', isset($question) ? $question['reponse'] : '') === '0' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="reponse_faux">
                                        <span class="badge badge-danger"><i class="fas fa-times"></i> FAUX</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="activite_numero">Activité Associée <span class="text-danger">*</span></label>
                                <select class="form-control" id="activite_numero" name="activite_numero" required>
                                    <option value="">Sélectionnez une activité</option>
                                    <?php foreach ($activites as $activite): ?>
                                        <option value="<?= $activite['numero'] ?>"
                                            <?= old('activite_numero', isset($question) ? $question['activite_numero'] : '') == $activite['numero'] ? 'selected' : '' ?>>
                                            [<?= $activite['numero'] ?>] <?= esc(substr($activite['libelle'], 0, 60)) ?>...
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-muted">L'activité liée à cette question (généralement 403 pour le quiz)</small>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Astuce :</strong> Pour le quiz ransomware, les questions sont de type VRAI/FAUX.
                                Rédigez des affirmations claires que les utilisateurs peuvent valider ou infirmer.
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <?= anchor('/gingembre/salle_4/question', '<i class="fas fa-times"></i> Annuler', ['class' => 'btn btn-secondary']) ?>
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
</body>
</html>
