<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Nouvelle Proposition VPN
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Créer une proposition VPN
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre') ?>">Accueil</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6/proposer-vpn') ?>">Propositions VPN</a></li>
    <li class="breadcrumb-item active">Nouveau</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations de la proposition</h3>
                </div>

                <form method="post" action="<?= base_url('/gingembre/salle_6/proposer-vpn/store') ?>">
                    <?= csrf_field() ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="vpn_numero">VPN <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.vpn_numero') ? 'is-invalid' : '' ?>"
                                    id="vpn_numero"
                                    name="vpn_numero"
                                    required>
                                <option value="">-- Sélectionner un VPN --</option>
                                <?php foreach ($vpns as $vpn): ?>
                                    <option value="<?= esc($vpn['numero']) ?>" <?= old('vpn_numero') == $vpn['numero'] ? 'selected' : '' ?>>
                                        #<?= esc($vpn['numero']) ?> - <?= esc($vpn['libelle']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.vpn_numero')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.vpn_numero') ?>
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
                                Indiquez si ce VPN est la bonne réponse pour cette activité
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="<?= base_url('/admin/proposer-vpn') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>