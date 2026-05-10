<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Administration Salle 1</title>

    <?= link_tag(base_url() . 'styles/salle_1/salle1Admin.css') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<div class="dashboard-container">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="dashboard-header">

        <h1>Administration Salle 1</h1>

        <?= anchor(
                'gingembre/accueil',
                '⬅ Retour',
                ['class' => 'btn-action']
        ) ?>

    </div>

    <div class="admin-layout">

        <!-- ===================================================== -->
        <!-- SIDEBAR -->
        <!-- ===================================================== -->

        <div class="sidebar">

            <div
                    class="nav-card active"
                    onclick="showSection('activite', this)">

                <h3>Activités</h3>

            </div>

            <div
                    class="nav-card"
                    onclick="showSection('erreur', this)">

                <h3>Erreurs</h3>

            </div>

            <div
                    class="nav-card"
                    onclick="showSection('auteur', this)">

                <h3>Auteur</h3>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- CONTENU -->
        <!-- ===================================================== -->

        <div class="main-content">

            <!-- ===================================================== -->
            <!-- FORM ACTIVITE -->
            <!-- ===================================================== -->

            <div
                    id="form-activite"
                    class="admin-form-box">

                <h2>Ajouter / Modifier une activité</h2>

                <?= form_open(
                        'gingembre/admin/save',
                        ['class' => 'form-container']
                ) ?>

                <input
                        type="hidden"
                        name="type"
                        value="activite">

                <input
                        type="hidden"
                        name="numero"
                        id="activite-numero">

                <div class="form-group">

                    <label>Libellé</label>

                    <textarea
                            name="libelle"
                            id="activite-libelle"
                            required></textarea>

                </div>

                <div class="form-actions">

                    <button
                            type="submit"
                            class="btn-add">

                        Enregistrer

                    </button>

                    <button
                            type="button"
                            class="btn-delete"
                            onclick="resetActiviteForm()">

                        Vider

                    </button>

                </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- FORM ERREUR -->
            <!-- ===================================================== -->

            <div
                    id="form-erreur"
                    class="admin-form-box hidden">

                <h2>Ajouter / Modifier une erreur</h2>

                <?= form_open(
                        'gingembre/admin/save',
                        ['class' => 'form-container']
                ) ?>

                <input
                        type="hidden"
                        name="type"
                        value="erreur">

                <input
                        type="hidden"
                        name="numero"
                        id="erreur-numero">

                <div class="form-group">

                    <label>Mot incorrect</label>

                    <input
                            type="text"
                            name="mot_incorrect"
                            id="erreur-mot"
                            required>

                </div>

                <div class="form-group">

                    <label>Explication</label>

                    <textarea
                            name="explication"
                            id="erreur-explication"
                            required></textarea>

                </div>

                <div class="form-actions">

                    <button
                            type="submit"
                            class="btn-add">

                        Enregistrer

                    </button>

                    <button
                            type="button"
                            class="btn-delete"
                            onclick="resetErreurForm()">

                        Vider

                    </button>

                </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- FORM AUTEUR -->
            <!-- ===================================================== -->

            <div
                    id="form-auteur"
                    class="admin-form-box hidden">

                <h2>Ajouter / Modifier un auteur</h2>

                <?= form_open(
                        'gingembre/admin/save',
                        ['class' => 'form-container']
                ) ?>

                <input
                        type="hidden"
                        name="type"
                        value="auteur">

                <input
                        type="hidden"
                        name="numero"
                        id="auteur-numero">

                <div class="form-group">

                    <label>Nom</label>

                    <textarea
                            name="nom"
                            id="auteur-nom"
                            required></textarea>

                            <label>Prénom</label>

                    <textarea
                            name="prenom"
                            id="auteur-prenom"
                            required></textarea>

                            <label>Fonction</label>

                    <textarea
                            name="fonction"
                            id="auteur-fonction"
                            required></textarea>

                </div>

                <div class="form-actions">

                    <button
                            type="submit"
                            class="btn-add">

                        Enregistrer

                    </button>

                    <button
                            type="button"
                            class="btn-delete"
                            onclick="resetAuteurForm()">

                        Vider

                    </button>

                </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- ACTIVITES -->
            <!-- ===================================================== -->

            <div
                    id="section-activite"
                    class="content-section">

                <h2>Activités</h2>

                <div class="table-responsive">

                    <table class="data-table">

                        <thead>

                        <tr>

                            <th>Numéro</th>
                            <th>Libellé</th>
                            <th>Actions</th>

                        </tr>

                        </thead>

                        <tbody>
                        <?php if (!empty($activites)): ?>

                            <?php foreach ($activites as $activite): ?>

                                <tr>

                                    <td>
                                        <?= esc($activite['numero']) ?>
                                    </td>

                                    <td>
                                        <?= esc($activite['libelle']) ?>
                                    </td>

                                    <td>

                                        <button
                                            class="btn-edit"
                                            data-numero="<?= esc($activite['numero']) ?>"
                                            data-libelle="<?= esc($activite['libelle']) ?>"
                                            onclick="openFormActivite(this)">
                                            Modifier
                                        </button>

                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'activite',
                                                <?= $activite['numero'] ?>,
                                                        'Activité'
                                                        )">

                                            Supprimer

                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- ERREURS -->
            <!-- ===================================================== -->

            <div
                    id="section-erreur"
                    class="content-section hidden">

                <h2>Erreurs</h2>

                <div class="table-responsive">

                    <table class="data-table">

                        <thead>

                        <tr>

                            <th>Numéro</th>
                            <th>Mot incorrect</th>
                            <th>Explication</th>
                            <th>Actions</th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php if (!empty($erreurs)): ?>

                            <?php foreach ($erreurs as $erreur): ?>

                                <tr>

                                    <td>
                                        <?= esc($erreur['numero']) ?>
                                    </td>

                                    <td>
                                        <?= esc($erreur['mot_incorrect']) ?>
                                    </td>

                                    <td>
                                        <?= esc($erreur['explication']) ?>
                                    </td>

                                    <td>

                                        <button
                                                class="btn-edit"
                                                data-numero="<?= esc($erreur['numero']) ?>"
                                                data-mot="<?= esc($erreur['mot_incorrect']) ?>"
                                                data-explication="<?= esc($erreur['explication']) ?>"
                                                onclick='openFormErreur(this)'>
                                               

                                            Modifier

                                        </button>
                                       

                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'erreur',
                                                <?= $erreur['numero'] ?>,
                                                        'Erreur'
                                                        )">

                                            Supprimer

                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- AUTEUR -->
            <!-- ===================================================== -->

            <div
                    id="section-auteur"
                    class="content-section hidden">

                <h2>Auteur</h2>

                <div class="table-responsive">

                    <table class="data-table">

                        <thead>

                        <tr>

                            <th>Numéro</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Fonction</th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php if (!empty($auteurs)): ?>

                            <?php foreach ($auteurs as $auteur): ?>

                                <tr>

                                    <td>
                                        <?= esc($auteur['numero']) ?>
                                    </td>

                                    <td>
                                        <?= esc($auteur['nom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($auteur['prenom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($auteur['fonction_role']) ?>
                                    </td>

                                    <td>

                                        

                                        <button
                                                class="btn-edit"
                                                data-numero="<?= esc($auteur['numero']) ?>"
                                                data-nom="<?= esc($auteur['nom']) ?>"
                                                data-prenom="<?= esc($auteur['prenom']) ?>"
                                                data-fonction="<?= esc($auteur['fonction_role']) ?>"
                                                onclick='openFormAuteur(this)'>
                                               

                                            Modifier

                                        </button>

                                      
                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'auteur',
                                                <?= $auteur['numero'] ?>,
                                                        'Auteur'
                                                        )">

                                            Supprimer

                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?= script_tag(
        base_url() . 'js/salle_1/salle1Admin.js'
) ?>

</body>
</html>