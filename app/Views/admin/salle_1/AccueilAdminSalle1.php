<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Salle</title>

    <?= link_tag(base_url().'styles/salle_1/salle1Admin.css') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-delete-base="<?= site_url('admin/delete') ?>">

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1>Administration</h1>
        <?= anchor('gingembre/accueil', 'Retour', ['class' => 'btn-action']) ?>
    </div>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="nav-card active" onclick="showSection('auteur')">
                <h3>Auteurs</h3>
            </div>

            <div class="nav-card" onclick="showSection('message')">
                <h3>Messages</h3>
            </div>

            <div class="nav-card" onclick="showSection('reponse')">
                <h3>Bonnes réponses</h3>
            </div>
        </div>

        <!-- CONTENU -->
        <div class="main-content">

            <!-- ================= AUTEURS ================= -->
            <div id="section-auteur" class="content-section">

                <div class="header-line">
                    <h2>Auteurs</h2>
                    <button class="btn-add" onclick="openForm('auteur','add')">
                        Ajouter
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="data-table">

                        <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Fonction</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php if (!empty($auteurs)): ?>
                            <?php foreach ($auteurs as $auteur): ?>

                                <tr>

                                    <td><?= esc($auteur['numero']) ?></td>

                                    <td><?= esc($auteur['nom']) ?></td>

                                    <td><?= esc($auteur['prenom']) ?></td>

                                    <td><?= esc($auteur['fonction_role']) ?></td>

                                    <td>

                                        <button
                                                class="btn-edit"

                                                onclick='openFormAuteur(
                                                        "edit",
                                                <?= json_encode($auteur) ?>
                                                        )'>
                                            Modifier
                                        </button>

                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'auteur',
                                                        '<?= $auteur['numero'] ?>',
                                                        '<?= esc($auteur['nom']) ?>'
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


            <!-- ================= MESSAGES ================= -->
            <div id="section-message" class="content-section hidden">

                <div class="header-line">
                    <h2>Messages</h2>

                    <button class="btn-add" onclick="openForm('message','add')">
                        Ajouter
                    </button>
                </div>

                <div class="table-responsive">

                    <table class="data-table">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Message</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php if (!empty($messages)): ?>
                            <?php foreach ($messages as $msg): ?>

                                <tr>

                                    <td><?= esc($msg['id']) ?></td>

                                    <td>
                                        <div class="cell-truncate">
                                            <?= esc($msg['message']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?= esc($msg['auteur_nom'] ?? 'Aucun') ?>
                                    </td>

                                    <td>

                                        <button
                                                class="btn-edit"

                                                onclick='openFormMessage(
                                                        "edit",
                                                <?= json_encode($msg) ?>
                                                        )'>
                                            Modifier
                                        </button>

                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'message',
                                                        '<?= $msg['id'] ?>',
                                                        '<?= esc($msg['message']) ?>'
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


            <!-- ================= BONNES REPONSES ================= -->
            <div id="section-reponse" class="content-section hidden">

                <div class="header-line">
                    <h2>Bonnes réponses</h2>

                    <button class="btn-add" onclick="openForm('reponse','add')">
                        Ajouter
                    </button>
                </div>

                <div class="table-responsive">

                    <table class="data-table">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mot</th>
                            <th>ID Message</th>
                            <th>Libellé</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php if (!empty($reponses)): ?>
                            <?php foreach ($reponses as $rep): ?>

                                <tr>

                                    <td><?= esc($rep['id']) ?></td>

                                    <td><?= esc($rep['mot']) ?></td>

                                    <td><?= esc($rep['message_id']) ?></td>

                                    <td><?= esc($rep['libelle']) ?></td>

                                    <td>

                                        <button
                                                class="btn-edit"

                                                onclick='openFormReponse(
                                                        "edit",
                                                <?= json_encode($rep) ?>
                                                        )'>
                                            Modifier
                                        </button>

                                        <button
                                                class="btn-delete"

                                                onclick="confirmDelete(
                                                        'reponse',
                                                        '<?= $rep['id'] ?>',
                                                        '<?= esc($rep['mot']) ?>'
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
            <!-- FORMULAIRE AUTEUR -->
            <!-- ===================================================== -->

            <div id="form-auteur" class="admin-form-box">

                <h2>Ajouter / Modifier un auteur</h2>

                <?= form_open('gingembre/admin/save', [
                        'class' => 'form-container'
                ]) ?>

                <input type="hidden" name="type" value="auteur">

                <input type="hidden" name="numero" id="auteur-numero">

                <div class="form-group">
                    <label>Nom</label>

                    <input type="text"
                           name="nom"
                           id="auteur-nom"
                           required>
                </div>

                <div class="form-group">
                    <label>Prénom</label>

                    <input type="text"
                           name="prenom"
                           id="auteur-prenom"
                           required>
                </div>

                <div class="form-group">
                    <label>Fonction</label>

                    <input type="text"
                           name="fonction_role"
                           id="auteur-fonction"
                           required>
                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-add">
                        Enregistrer
                    </button>

                    <button type="button"
                            class="btn-delete"
                            onclick="resetAuteurForm()">
                        Vider
                    </button>

                </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- FORMULAIRE MESSAGE -->
            <!-- ===================================================== -->

            <div id="form-message" class="admin-form-box hidden">

                <h2>Ajouter / Modifier un message</h2>

                <?= form_open('gingembre/admin/save', [
                        'class' => 'form-container'
                ]) ?>

                <input type="hidden" name="type" value="message">

                <input type="hidden" name="numero" id="message-id">

                <div class="form-group">
                    <label>Contenu</label>

                    <textarea
                            name="message"
                            id="message-content"
                            required></textarea>
                </div>

                <div class="form-group">

                    <label>Auteur</label>

                    <select
                            name="auteur_numero"
                            id="message-auteur"
                            required>

                        <?php foreach ($auteurs as $auteur): ?>

                            <option value="<?= $auteur['numero'] ?>">

                                <?= esc($auteur['nom'].' '.$auteur['prenom']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-add">
                        Enregistrer
                    </button>

                    <button type="button"
                            class="btn-delete"
                            onclick="resetMessageForm()">
                        Vider
                    </button>

                </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- FORMULAIRE REPONSE -->
            <!-- ===================================================== -->

            <div id="form-reponse" class="admin-form-box hidden">

                <h2>Ajouter / Modifier une bonne réponse</h2>

                <?= form_open('gingembre/admin/save', [
                        'class' => 'form-container'
                ]) ?>

                <input type="hidden" name="type" value="reponse">

                <input type="hidden" name="numero" id="reponse-id">

                <div class="form-group">

                    <label>Mot</label>

                    <input type="text"
                           name="mot"
                           id="reponse-mot"
                           required>
                </div>

                <div class="form-group">

                    <label>Message associé</label>

                    <select
                            name="message_id"
                            id="reponse-message-id"
                            required>

                        <?php foreach ($messages as $msg): ?>

                            <option value="<?= $msg['id'] ?>">

                                #<?= $msg['id'] ?> -
                                <?= esc(substr($msg['message'], 0, 50)) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>Libellé</label>

                    <input type="text"
                           name="libelle"
                           id="reponse-libelle"
                           required>
                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-add">
                        Enregistrer
                    </button>

                    <button type="button"
                            class="btn-delete"
                            onclick="resetReponseForm()">
                        Vider
                    </button>

                </div>

                </form>

            </div>

        </div>
    </div>
</div>

<?= script_tag(base_url().'js/salle_1/salle1Admin.js') ?>

</body>
</html>