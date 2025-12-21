<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Salle 2</title>
    <?= link_tag('styles/admin/adminAccueil.css'); ?> <!-- Styles globaux du dashboard Admin -->
    <?= link_tag('styles/salle_2/salle2Admin'); ?> <!-- Styles spécifiques Salle 2 (ancienne feuille) -->
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/Salle2Admin.css') ?>"> <!-- Nouvelle feuille dédiée à l’admin Salle 2 -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 pour confirmations et modales -->
</head>
<body data-delete-base="<?= base_url('gingembre/deleteElement') ?>">

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>🔐 Administration Salle 2</h1>
        <?= anchor('gingembre/accueil', '⬅ Retour', ['class' => 'btn-action btn-create']); ?> <!-- Lien retour vers l’accueil Admin -->
    </div>

    <div class="admin-layout">

        <div class="sidebar">
            <!-- Navigation latérale: bascule d’affichage via showSection() -->
            <div class="nav-card active" id="nav-explication" onclick="showSection('explication')">
                <div class="icon">📖</div><h3>Explications</h3>
            </div>
            <div class="nav-card" id="nav-indice" onclick="showSection('indice')">
                <div class="icon">💡</div><h3>Indices</h3>
            </div>
            <div class="nav-card" id="nav-mdp" onclick="showSection('mdp')">
                <div class="icon">🔑</div><h3>Mots de Passe</h3>
            </div>
        </div>

        <div class="main-content">

            <!-- Section Explications -->
            <div id="section-explication" class="content-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Explications</h2>
                    <button class="btn-add" onclick="openForm('explication', 'add')">➕ Ajouter</button> <!-- Ouverture du formulaire en mode ajout -->
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th style="width: 60px;">N°</th>
                            <th>Description</th>
                            <th style="width: 190px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($explications)): foreach($explications as $row): ?>
                            <tr>
                                <td><?= $row['numero'] ?></td>
                                <td>
                                    <!-- Cellule tronquée avec tooltip pour éviter débordements -->
                                    <div class="tooltip-wrapper">
                                        <div class="cell-truncate"><?= $row['libelle'] ?></div>
                                        <span class="tooltip-content"><?= $row['libelle'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <!-- Encodage JSON pour passer des chaînes sûres à JS (évite conflit de quotes) -->
                                    <button class="btn-edit" onclick='openForm("explication", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["libelle"]) ?>)'>Modif</button>
                                    <button class="btn-delete" onclick="confirmDelete('explication', '<?= $row['id'] ?>', '<?= $row['numero'] ?>', <?= htmlspecialchars(json_encode($row['libelle'])) ?>)">Suppr</button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section Indices -->
            <div id="section-indice" class="content-section hidden">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Indices</h2>
                    <button class="btn-add" onclick="openForm('indice', 'add')">➕ Ajouter</button>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th style="width: 60px;">N°</th>
                            <th>Description</th>
                            <th style="width: 190px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($indices)): foreach($indices as $row): ?>
                            <tr>
                                <td><?= $row['numero'] ?></td>
                                <td>
                                    <div class="tooltip-wrapper">
                                        <div class="cell-truncate"><?= $row['libelle'] ?></div>
                                        <span class="tooltip-content"><?= $row['libelle'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <!-- Données transmises au formulaire d’édition -->
                                    <button class="btn-edit" onclick='openForm("indice", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["libelle"]) ?>)'>Modif</button>
                                    <button class="btn-delete" onclick="confirmDelete('indice', '<?= $row['id'] ?>', '<?= $row['numero'] ?>', <?= htmlspecialchars(json_encode($row['libelle'])) ?>)">Suppr</button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section Mots de Passe -->
            <div id="section-mdp" class="content-section hidden">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Mots de Passe</h2>
                    <button class="btn-add" onclick="openForm('mdp', 'add')">➕ Ajouter</button>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th style="width: 60px;">N°</th>
                            <th>Mot de Passe</th>
                            <th>Etape</th>
                            <th style="width: 190px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($mdps)): foreach($mdps as $row): ?>
                            <tr>
                                <td><?= $row['numero'] ?></td>
                                <td><strong><?= $row['motPasse'] ?></strong></td>
                                <td><?= $row['Valeur'] ?></td>
                                <td>
                                    <!-- Inclut l’étape (Valeur) dans le payload d’édition -->
                                    <button class="btn-edit" onclick='openForm("mdp", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["motPasse"]) ?>, <?= json_encode($row["Valeur"]) ?>)'>Modif</button>
                                    <button class="btn-delete" onclick="confirmDelete('mdp', '<?= $row['id'] ?>', '<?= $row['numero'] ?>', <?= htmlspecialchars(json_encode($row['motPasse'])) ?>)">Suppr</button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulaire générique (piloté par JS) -->
            <div id="generic-form" class="hidden">
                <h2 id="form-title">Edition</h2>

                <?= form_open('gingembre/saveGeneric', ['id' => 'main-form', 'class' => 'form-container']); ?> <!-- Ouverture du formulaire CI -->

                <!-- Champs cachés: contrôle d’état par JS -->
                <input type="hidden" id="inp-id" name="id">
                <input type="hidden" id="inp-type" name="type_element">

                <div class="form-group">
                    <label>Numéro</label>
                    <!-- Empêche les lettres et force uniquement des chiffres -->
                    <input
                            type="text"
                            id="inp-numero"
                            name="numero"
                            required
                            inputmode="numeric"
                            pattern="^\d+$"
                            title="Le numéro doit contenir uniquement des chiffres."
                            autocomplete="off"
                            oninput="this.value = this.value.replace(/\D/g, '')"
                    >
                </div>

                <div class="form-group">
                    <label id="lbl-desc">Description</label>
                    <textarea id="inp-desc" name="description" rows="5" required></textarea>
                </div>

                <!-- Champ "Valeur Associée" (utilisé pour MDP) masqué par défaut -->
                <div class="form-group hidden-field" id="group-valeur">
                    <label id="lbl-valeur">Valeur Associée</label>
                    <!-- Liste déroulante (combo box) -->
                    <select id="inp-valeur" name="valeur">
                        <option value="" disabled selected>Choisir une étape…</option>
                        <option value="Etape1a">Etape1a</option>
                        <option value="Etape2">Etape2</option>
                        <option value="Etape2-Introduction">Etape2-Introduction</option>
                        <option value="Etape3">Etape3</option>
                        <option value="Etape4">Etape4</option>
                        <option value="Etape4-Accept">Etape4-Accept</option>
                    </select>
                </div>

                <!-- Actions du formulaire: sauvegarde (confirmSave) et fermeture (closeForm) -->
                <div style="margin-top:20px; display:flex; gap:10px;">
                    <button type="button" class="btn-add" onclick="confirmSave()">Enregistrer</button>
                    <button type="button" class="btn-delete" onclick="closeForm()" style="border:none">Annuler</button>
                </div>
                </form> <!-- Fermeture du form_open -->
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('/js/salle_2/Salle2Admin.js') ?>" defer></script> <!-- Logique JS (navigation, formulaires, modales) -->
</body>
</html>