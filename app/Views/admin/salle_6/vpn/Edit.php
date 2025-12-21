<?= $this->extend('admin/salle_6/layout') ?>

<?= $this->section('title') ?>
    Modifier VPN
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
    Modifier un VPN
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6') ?>">Accueil</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('/gingembre/salle_6/vpn') ?>">VPN</a></li>
    <li class="breadcrumb-item active">Modifier #<?= esc($vpn['numero']) ?></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier le VPN #<?= esc($vpn['numero']) ?></h3>
                </div>

                <form method="post" action="<?= base_url('/gingembre/salle_6/vpn/update/' . $vpn['numero']) ?>">
                    <?= csrf_field() ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="libelle">Libellé <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?= session('errors.libelle') ? 'is-invalid' : '' ?>"
                                   id="libelle"
                                   name="libelle"
                                   value="<?= old('libelle', $vpn['libelle']) ?>"
                                   required
                                   placeholder="Entrez le libellé du VPN">
                            <?php if (session('errors.libelle')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.libelle') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Le libellé doit contenir au minimum 3 caractères
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                        <a href="<?= base_url('/admin/vpn') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>