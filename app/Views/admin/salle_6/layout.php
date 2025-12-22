<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> - Admin Salle 6</title>

    <?= link_tag('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') ?>

    <?= link_tag('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css') ?>

    <?= link_tag('https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css') ?>

    <?= $this->renderSection('styles') ?>

    <style>
        .table-actions {
            white-space: nowrap;
        }
        .table-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .back-button {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <?= anchor(
                        'gingembre/accueil',
                        '<i class="fas fa-arrow-left"></i> Retour Dashboard Principal',
                        ['class' => 'nav-link', 'escape' => false]
                ) ?>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <i class="fas fa-user"></i> <?= esc(session()->get('admin_user')) ?>
                </span>
            </li>
            <li class="nav-item">
                <?= anchor(
                        'gingembre/logout',
                        '<i class="fas fa-sign-out-alt"></i> Déconnexion',
                        ['class' => 'nav-link', 'escape' => false]
                ) ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <?= anchor(
                'gingembre/salle_6',
                '<i class="fas fa-network-wired brand-image ml-3"></i><span class="brand-text font-weight-light">Admin Salle 6</span>',
                ['class' => 'brand-link', 'escape' => false]
        ) ?>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">DASHBOARD</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6',
                                '<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard Salle 6</p>',
                                [
                                        'class' => 'nav-link' . (uri_string() == 'gingembre/salle_6' ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-header">SALLE 6 - RÉSEAU</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/vpn',
                                '<i class="nav-icon fas fa-shield-alt"></i><p>VPN</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'vpn') !== false && strpos(uri_string(), 'proposer-vpn') === false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/wifi',
                                '<i class="nav-icon fas fa-wifi"></i><p>WiFi</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'wifi') !== false && strpos(uri_string(), 'proposer-wifi') === false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/proposer-vpn',
                                '<i class="nav-icon fas fa-link"></i><p>Propositions VPN</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'proposer-vpn') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/proposer-wifi',
                                '<i class="nav-icon fas fa-project-diagram"></i><p>Propositions WiFi</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'proposer-wifi') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-header">ACTIVITÉS & CONTENU</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/activite',
                                '<i class="nav-icon fas fa-running"></i><p>Activités</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'activite') !== false && strpos(uri_string(), 'activite-message') === false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/type',
                                '<i class="nav-icon fas fa-tags"></i><p>Types</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'type') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/salle',
                                '<i class="nav-icon fas fa-door-open"></i><p>Salles</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'salle') !== false && strpos(uri_string(), 'salle_6') === false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-header">AIDE & INDICES</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/indice',
                                '<i class="nav-icon fas fa-lightbulb"></i><p>Indices</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'indice') !== false && strpos(uri_string(), 'avoir-indice') === false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/explication',
                                '<i class="nav-icon fas fa-info-circle"></i><p>Explications</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'explication') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/avoir-indice',
                                '<i class="nav-icon fas fa-link"></i><p>Avoir Indice</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'avoir-indice') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-header">MESSAGES</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/salle_6/activite-message',
                                '<i class="nav-icon fas fa-envelope"></i><p>Messages Activité</p>',
                                [
                                        'class' => 'nav-link' . (strpos(uri_string(), 'activite-message') !== false ? ' active' : ''),
                                        'escape' => false
                                ]
                        ) ?>
                    </li>

                    <li class="nav-header">RETOUR</li>

                    <li class="nav-item">
                        <?= anchor(
                                'gingembre/accueil',
                                '<i class="nav-icon fas fa-home"></i><p>Accueil Admin</p>',
                                [
                                        'class' => 'nav-link',
                                        'escape' => false
                                ]
                        ) ?>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $this->renderSection('page_title') ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><?= anchor('gingembre/accueil', 'Accueil Admin') ?></li>
                            <li class="breadcrumb-item"><?= anchor('gingembre/salle_6', 'Salle 6') ?></li>
                            <?= $this->renderSection('breadcrumb') ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="icon fas fa-ban"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="icon fas fa-ban"></i>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Administration Salle 6</strong> - Made in Val de Loire
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>

<?= script_tag('https://code.jquery.com/jquery-3.7.0.min.js') ?>

<?= script_tag('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js') ?>

<?= script_tag('https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js') ?>

<?= $this->renderSection('scripts') ?>

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Confirmation de suppression globale
    $(document).on('click', '.btn-delete', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>