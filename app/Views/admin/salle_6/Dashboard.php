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
            <a href="<?= base_url('/gingembre/accueil') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard Principal
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <!-- VPN -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $total_vpn ?></h3>
                    <p>VPN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <a href="<?= base_url('/gingembre/salle_6/vpn') ?>" class="small-box-footer">
                    Gérer <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- WiFi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $total_wifi ?></h3>
                    <p>WiFi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <a href="<?= base_url('/gingembre/salle_6/wifi') ?>" class="small-box-footer">
                    Gérer <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Propositions VPN -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $total_proposer_vpn ?></h3>
                    <p>Propositions VPN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <a href="<?= base_url('/gingembre/salle_6/proposer-vpn') ?>" class="small-box-footer">
                    Gérer <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Propositions WiFi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $total_proposer_wifi ?></h3>
                    <p>Propositions WiFi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="<?= base_url('/gingembre/salle_6/proposer-wifi') ?>" class="small-box-footer">
                    Gérer <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Informations sur la salle 6 -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-network-wired mr-1"></i>
                        Salle 6 - Gestion des Réseaux
                    </h3>
                </div>
                <div class="card-body">
                    <p>Bienvenue dans l'interface d'administration de la <strong>Salle 6</strong>.</p>
                    <p>Cette salle est dédiée à l'apprentissage de la sécurité réseau à travers des exercices sur les VPN et les réseaux WiFi.</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-shield-alt text-info"></i> VPN (Virtual Private Network)</h5>
                            <ul>
                                <li>Créer et gérer les VPN proposés aux étudiants</li>
                                <li>Définir les caractéristiques de chaque VPN</li>
                                <li>Associer les VPN aux activités pédagogiques</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-wifi text-success"></i> WiFi</h5>
                            <ul>
                                <li>Gérer les réseaux WiFi disponibles</li>
                                <li>Configurer le type de chiffrement</li>
                                <li>Définir si le réseau est public ou privé</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5><i class="fas fa-link text-warning"></i> Propositions VPN</h5>
                            <ul>
                                <li>Lier des VPN à des activités spécifiques</li>
                                <li>Définir les bonnes et mauvaises réponses</li>
                                <li>Créer des scénarios pédagogiques</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-project-diagram text-danger"></i> Propositions WiFi</h5>
                            <ul>
                                <li>Associer des réseaux WiFi aux activités</li>
                                <li>Définir les zones cliquables</li>
                                <li>Configurer les réponses correctes</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h5><i class="icon fas fa-info"></i> Fonctionnalités disponibles</h5>
                        <ul class="mb-0">
                            <li><strong>Recherche</strong> : Trouvez rapidement vos données</li>
                            <li><strong>Tri</strong> : Cliquez sur les en-têtes de colonnes pour trier</li>
                            <li><strong>Pagination</strong> : Affichage de 10 éléments par page</li>
                            <li><strong>CRUD complet</strong> : Créer, Lire, Modifier, Supprimer</li>
                            <li><strong>Validation</strong> : Vérification automatique des données</li>
                            <li><strong>Sécurité</strong> : Protection contre les suppressions non autorisées</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès rapide -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fas fa-bolt"></i> Accès Rapide</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?= base_url('/gingembre/salle_6/vpn/create') ?>" class="btn btn-block btn-info">
                                <i class="fas fa-plus"></i> Nouveau VPN
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/gingembre/salle_6/wifi/create') ?>" class="btn btn-block btn-success">
                                <i class="fas fa-plus"></i> Nouveau WiFi
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/gingembre/salle_6/proposer-vpn/create') ?>" class="btn btn-block btn-warning">
                                <i class="fas fa-plus"></i> Nouvelle Prop. VPN
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/gingembre/salle_6/proposer-wifi/create') ?>" class="btn btn-block btn-danger">
                                <i class="fas fa-plus"></i> Nouvelle Prop. WiFi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>