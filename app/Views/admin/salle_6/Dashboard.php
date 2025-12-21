<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Dashboard Salle 6
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Administration Salle 6 - Réseau
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Bouton retour -->
    <div class="row mb-3">
        <div class="col-12">
            <?= anchor(
                    'gingembre/accueil',
                    '<i class="fas fa-arrow-left"></i> Retour au Dashboard Principal',
                    ['class' => 'btn btn-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">

        <!-- VPN -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $total_vpn ?? 0 ?></h3>
                    <p>VPN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/vpn',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- WiFi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $total_wifi ?? 0 ?></h3>
                    <p>WiFi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/wifi',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Propositions VPN -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $total_proposer_vpn ?? 0 ?></h3>
                    <p>Propositions VPN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/proposer-vpn',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Propositions WiFi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $total_proposer_wifi ?? 0 ?></h3>
                    <p>Propositions WiFi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/proposer-wifi',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Activités -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><?= $total_activite ?? 0 ?></h3>
                    <p>Activités</p>
                </div>
                <div class="icon">
                    <i class="fas fa-running"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/activite',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Types -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3><?= $total_type ?? 0 ?></h3>
                    <p>Types</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/type',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Salles -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-indigo">
                <div class="inner">
                    <h3><?= $total_salle ?? 0 ?></h3>
                    <p>Salles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/salle',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Indices -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?= $total_indice ?? 0 ?></h3>
                    <p>Indices</p>
                </div>
                <div class="icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/indice',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Explications -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3><?= $total_explication ?? 0 ?></h3>
                    <p>Explications</p>
                </div>
                <div class="icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/explication',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Avoir indice -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3><?= $total_avoir_indice ?? 0 ?></h3>
                    <p>Avoir indice</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/avoir-indice',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Messages -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3><?= $total_activite_message ?? 0 ?></h3>
                    <p>Messages activité</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <?= anchor(
                        'gingembre/salle_6/activite-message',
                        'Gérer <i class="fas fa-arrow-circle-right"></i>',
                        ['class' => 'small-box-footer', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>