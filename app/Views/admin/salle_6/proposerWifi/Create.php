<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Nouvelle Proposition WiFi
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Créer une proposition WiFi
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre') ?>">Accueil</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6/proposer-wifi') ?>">Propositions WiFi</a></li>
    <li class="breadcrumb-item active">Nouveau</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de la proposition</h3>
                </div>

                <form method="post" action="<?= base_url('/gingembre/salle_6/proposer-wifi/store') ?>">
                    <?= csrf_field() ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="wifi_numero">WiFi <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.wifi_numero') ? 'is-invalid' : '' ?>"
                                    id="wifi_numero"
                                    name="wifi_numero"
                                    required>
                                <option value="">-- Sélectionner un WiFi --</option>
                                <?php foreach ($wifis as $wifi): ?>
                                    <option value="<?= esc($wifi['numero']) ?>" <?= old('wifi_numero') == $wifi['numero'] ? 'selected' : '' ?>>
                                        #<?= esc($wifi['numero']) ?> - <?= esc($wifi['nom']) ?> (<?= esc($wifi['chiffrement']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.wifi_numero')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.wifi_numero') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="activite_numero">Numéro d'activité <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control <?= session('errors.activite_numero') ? 'is-invalid' : '' ?>"
                                   id="activite_numero"
                                   name="activite_numero"
                                   value="<?= old('activite_numero') ?>"
                                   required
                                   min="1"
                                   placeholder="Entrez le numéro de l'activité">
                            <?php if (session('errors.activite_numero')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.activite_numero') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="zone_clique">Zone cliquée <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?= session('errors.zone_clique') ? 'is-invalid' : '' ?>"
                                   id="zone_clique"
                                   name="zone_clique"
                                   value="<?= old('zone_clique') ?>"
                                   required
                                   maxlength="50"
                                   placeholder="Ex: zone1, zone2, etc.">
                            <?php if (session('errors.zone_clique')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.zone_clique') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Identifiant de la zone interactive où le WiFi apparaît
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="bonne_reponse">Bonne réponse <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.bonne_reponse') ? 'is-invalid' : '' ?>"
                                    id="bonne_reponse"
                                    name="bonne_reponse"
                                    required>
                                <option value="">-- Sélectionner --</option>
                                <option value="1" <?= old('bonne_reponse') == '1' ? 'selected' : '' ?>>Oui</option>
                                <option value="0" <?= old('bonne_reponse') == '0' ? 'selected' : '' ?>>Non</option>
                            </select>
                            <?php if (session('errors.bonne_reponse')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.bonne_reponse') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Indiquez si ce WiFi est la bonne réponse pour cette activité
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="<?= base_url('/admin/proposer-wifi') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>