<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> - Admin Salle 6</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

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

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('/gingembre/accueil') ?>" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Retour Dashboard Principal
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <i class="fas fa-user"></i> <?= session()->get('admin_user') ?>
                </span>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('/gingembre/logout') ?>" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= base_url('/gingembre/salle_6') ?>" class="brand-link">
            <i class="fas fa-network-wired brand-image ml-3"></i>
            <span class="brand-text font-weight-light">Admin Salle 6</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">SALLE 6 - RÉSEAU</li>

                    <!-- Dashboard Salle 6 -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_6') ?>" class="nav-link <?= uri_string() == 'gingembre/salle_6' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Salle 6</p>
                        </a>
                    </li>

                    <!-- VPN -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_6/vpn') ?>" class="nav-link <?= strpos(uri_string(), 'vpn') !== false && strpos(uri_string(), 'proposer-vpn') === false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <p>VPN</p>
                        </a>
                    </li>

                    <!-- WiFi -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_6/wifi') ?>" class="nav-link <?= strpos(uri_string(), 'wifi') !== false && strpos(uri_string(), 'proposer-wifi') === false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-wifi"></i>
                            <p>WiFi</p>
                        </a>
                    </li>

                    <!-- Propositions VPN -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_6/proposer-vpn') ?>" class="nav-link <?= strpos(uri_string(), 'proposer-vpn') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-link"></i>
                            <p>Propositions VPN</p>
                        </a>
                    </li>

                    <!-- Propositions WiFi -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/salle_6/proposer-wifi') ?>" class="nav-link <?= strpos(uri_string(), 'proposer-wifi') !== false ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Propositions WiFi</p>
                        </a>
                    </li>

                    <li class="nav-header">RETOUR</li>

                    <!-- Retour accueil admin -->
                    <li class="nav-item">
                        <a href="<?= base_url('/gingembre/accueil') ?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Accueil Admin</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= $this->renderSection('page_title') ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/accueil') ?>">Accueil Admin</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6') ?>">Salle 6</a></li>
                            <?= $this->renderSection('breadcrumb') ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Messages Flash -->
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

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Administration Salle 6</strong> - Made in Val de Loire
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<?= $this->renderSection('scripts') ?>

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Confirmation de suppression
    $('.btn-delete').on('click', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>