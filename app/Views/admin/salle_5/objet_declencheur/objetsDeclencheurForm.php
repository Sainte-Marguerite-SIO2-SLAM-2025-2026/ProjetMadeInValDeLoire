
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
                        <h1><?= isset($objetDeclencheur) ? 'Modifier' : 'Ajouter' ?> un Objet Déclencheur</h1>
                    </div>
                    <div class="col-sm-6">
                        <?= anchor(
                                '/gingembre/salle_5/objet_declencheur',
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
                    <?= form_open(
                            isset($objetDeclencheur)
                                    ? '/gingembre/salle_5/objet_declencheur/update/' . $objetDeclencheur->id
                                    : '/gingembre/salle_5/objet_declencheur/store'
                    ) ?>

                    <?= csrf_field() ?>

                    <div class="card-body">

                        <!-- NOM -->
                        <div class="form-group">
                            <label for="nom">Nom <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'        => 'nom',
                                    'id'          => 'nom',
                                    'class'       => 'form-control',
                                    'value'       => old('nom', $objetDeclencheur->nom ?? ''),
                                    'placeholder' => 'Téléphone_mobile',
                                    'maxlength'   => 50,
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Nom de l'objet (max 50 caractères)</small>
                        </div>

                        <!-- IMAGE -->
                        <div class="form-group">
                            <label for="image">Image <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'        => 'image',
                                    'id'          => 'image',
                                    'class'       => 'form-control',
                                    'value'       => old('image', isset($objetDeclencheur) ? substr($objetDeclencheur->image_path, 15) : ''),
                                    'placeholder' => 'carte_pins_01.png',
                                    'maxlength'   => 50,
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Nom du fichier image (max 50 caractères)</small>
                        </div>

                        <!-- POSITION X -->
                        <div class="form-group">
                            <label for="x">Position X <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'  => 'x',
                                    'id'    => 'x',
                                    'class' => 'form-control',
                                    'value' => old('x', $objetDeclencheur->x ?? ''),
                                    'placeholder' => '192.63',
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Position X de l'objet</small>
                        </div>

                        <!-- POSITION Y -->
                        <div class="form-group">
                            <label for="y">Position Y <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'  => 'y',
                                    'id'    => 'y',
                                    'class' => 'form-control',
                                    'value' => old('y', $objetDeclencheur->y ?? ''),
                                    'placeholder' => '192.63',
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Position Y de l'objet</small>
                        </div>

                        <!-- LARGEUR -->
                        <div class="form-group">
                            <label for="width">Largeur <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'  => 'width',
                                    'id'    => 'width',
                                    'class' => 'form-control',
                                    'value' => old('width', $objetDeclencheur->width ?? ''),
                                    'placeholder' => '200',
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Largeur de l'objet</small>
                        </div>

                        <!-- HAUTEUR -->
                        <div class="form-group">
                            <label for="height">Hauteur <span class="text-danger">*</span></label>
                            <?= form_input([
                                    'name'  => 'height',
                                    'id'    => 'height',
                                    'class' => 'form-control',
                                    'value' => old('height', $objetDeclencheur->height ?? ''),
                                    'placeholder' => '200',
                                    'required'    => true
                            ]) ?>
                            <small class="form-text text-muted">Hauteur de l'objet</small>
                        </div>

                        <!-- ZONE -->
                        <div class="form-group">
                            <label for="zone_path">Zone</label>
                            <?= form_input([
                                    'name'  => 'zone_path',
                                    'id'    => 'zone_path',
                                    'class' => 'form-control',
                                    'value' => old('zone_path', $objetDeclencheur->zone_path ?? ''),
                                    'placeholder' => 'm200.....',
                                    'maxlength' => 80
                            ]) ?>
                            <small class="form-text text-muted">Zone de l'objet</small>
                        </div>

                        <!-- ACTIVITE DECLENCHEE -->
                        <div class="form-group">
                            <label for="numero_activite">Activité Déclenchée</label>
                            <?php
                            $options = ['' => 'Aucune activité'];
                            foreach ($activites as $activite) {
                                $options[$activite['numero']] = "[{$activite['numero']}] " . esc(substr($activite['libelle'], 0, 50)) . "...";
                            }
                            ?>
                            <?= form_dropdown(
                                    'numero_activite',
                                    $options,
                                    old('numero_activite', $objetDeclencheur->numero_activite ?? ''),
                                    ['class' => 'form-control', 'id' => 'numero_activite']
                            ) ?>
                        </div>

                    </div>

                    <div class="card-footer">

                        <?= form_button([
                                'type'    => 'submit',
                                'class'   => 'btn btn-primary',
                                'content' => '<i class="fas fa-save"></i> Enregistrer',
                                'escape'  => false
                        ]) ?>

                        <?= anchor(
                                '/gingembre/salle_5/objet_declencheur',
                                '<i class="fas fa-times"></i> Annuler',
                                ['class' => 'btn btn-secondary']
                        ) ?>

                    </div>

                    <?= form_close() ?>
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