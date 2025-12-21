<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Modifier Proposition WiFi
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Modifier une proposition WiFi
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/admin') ?>">Accueil</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6/proposer-wifi') ?>">Propositions WiFi</a></li>
    <li class="breadcrumb-item active">Modifier</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier la proposition WiFi #<?= esc($proposition['wifi_numero']) ?> - Activité #<?= esc($proposition['activite_numero']) ?></h3>
                </div>

                <form method="post" action="<?= base_url('/gingembre/salle_6/proposer-wifi/update/' . $proposition['wifi_numero'] . '/' . $proposition['activite_numero']) ?>">
                    <?= csrf_field() ?>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="icon fas fa-info"></i>
                            <strong>WiFi:</strong> #<?= esc($proposition['wifi_numero']) ?><br>
                            <strong>Activité:</strong> #<?= esc($proposition['activite_numero']) ?>
                        </div>

                        <div class="form-group">
                            <label for="zone_clique">Zone cliquée <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?= session('errors.zone_clique') ? 'is-invalid' : '' ?>"
                                   id="zone_clique"
                                   name="zone_clique"
                                   value="<?= old('zone_clique', $proposition['zone_clique']) ?>"
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
                                <option value="1" <?= old('bonne_reponse', $proposition['bonne_reponse']) == '1' ? 'selected' : '' ?>>Oui</option>
                                <option value="0" <?= old('bonne_reponse', $proposition['bonne_reponse']) == '0' ? 'selected' : '' ?>>Non</option>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
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