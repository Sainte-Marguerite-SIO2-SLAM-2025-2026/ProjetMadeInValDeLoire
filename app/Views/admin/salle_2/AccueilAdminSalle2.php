<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Salle 2</title>
    <?= link_tag('styles/admin/adminAccueil.css'); ?>
    <?= link_tag('styles/salle_2/salle2Admin'); ?>



</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>🔐 Administration Salle 2</h1>
        <?= anchor('gingembre/accueil', '⬅ Retour', ['class' => 'btn-action btn-create']); ?>
    </div>

    <div class="admin-layout">

        <div class="sidebar">
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

            <div id="section-explication" class="content-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Explications</h2>
                    <button class="btn-add" onclick="openForm('explication', 'add')">➕ Ajouter</button>
                </div>
                <table class="data-table">
                    <thead><tr><th>N°</th><th>Libellé</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if(!empty($explications)): foreach($explications as $row): ?>
                        <tr>
                            <td><?= $row['numero'] ?></td>
                            <td><?= $row['libelle'] ?></td>
                            <td>
                                <button class="btn-edit" onclick='openForm("explication", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["libelle"]) ?>)'>Modif</button>
                                <?= anchor('gingembre/deleteElement/explication/'.$row['id'], 'Suppr', ['class'=>'btn-delete', 'onclick'=>"return confirm('Sûr ?')"]) ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="section-indice" class="content-section hidden">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Indices</h2>
                    <button class="btn-add" onclick="openForm('indice', 'add')">➕ Ajouter</button>
                </div>
                <table class="data-table">
                    <thead><tr><th>N°</th><th>Libellé</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if(!empty($indices)): foreach($indices as $row): ?>
                        <tr>
                            <td><?= $row['numero'] ?></td>
                            <td><?= $row['libelle'] ?></td>
                            <td>
                                <button class="btn-edit" onclick='openForm("indice", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["libelle"]) ?>)'>Modif</button>
                                <?= anchor('gingembre/deleteElement/indice/'.$row['id'], 'Suppr', ['class'=>'btn-delete', 'onclick'=>"return confirm('Sûr ?')"]) ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="section-mdp" class="content-section hidden">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2>Gestion des Mots de Passe</h2>
                    <button class="btn-add" onclick="openForm('mdp', 'add')">➕ Ajouter</button>
                </div>
                <table class="data-table">
                    <thead><tr><th>N°</th><th>Mot de Passe</th><th>Valeur</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if(!empty($mdps)): foreach($mdps as $row): ?>
                        <tr>
                            <td><?= $row['numero'] ?></td>
                            <td><strong><?= $row['motPasse'] ?></strong></td>
                            <td><?= $row['Valeur'] ?></td>
                            <td>
                                <button class="btn-edit" onclick='openForm("mdp", "edit", <?= $row["id"] ?>, <?= $row["numero"] ?>, <?= json_encode($row["motPasse"]) ?>, <?= json_encode($row["Valeur"]) ?>)'>Modif</button>
                                <?= anchor('gingembre/deleteElement/mdp/'.$row['id'], 'Suppr', ['class'=>'btn-delete', 'onclick'=>"return confirm('Sûr ?')"]) ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="generic-form" class="hidden">
                <h2 id="form-title">Edition</h2>

                <?= form_open('gingembre/saveGeneric', ['class' => 'form-container']); ?>

                <input type="hidden" id="inp-id" name="id">
                <input type="hidden" id="inp-type" name="type_element">

                <div class="form-group">
                    <label>Numéro</label>
                    <input type="number" id="inp-numero" name="numero" required>
                </div>

                <div class="form-group">
                    <label id="lbl-desc">Description</label>
                    <textarea id="inp-desc" name="description" rows="5" required></textarea>
                </div>

                <div class="form-group hidden-field" id="group-valeur">
                    <label>Valeur Associée</label>
                    <input type="text" id="inp-valeur" name="valeur">
                </div>

                <div style="margin-top:20px; display:flex; gap:10px;">
                    <button type="submit" class="btn-add">Enregistrer</button>
                    <button type="button" class="btn-delete" onclick="closeForm()" style="border:none">Annuler</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // 1. GESTION DES ONGLETS
    function showSection(name) {
        // Cache tout
        document.querySelectorAll('.content-section, #generic-form').forEach(e => e.classList.add('hidden'));
        document.querySelectorAll('.nav-card').forEach(e => e.classList.remove('active'));

        // Affiche la section demandée
        document.getElementById('section-' + name).classList.remove('hidden');

        // Active le menu
        const nav = document.getElementById('nav-' + name);
        if(nav) nav.classList.add('active');
    }

    // 2. OUVERTURE DU FORMULAIRE
    function openForm(type, mode, id='', num='', desc='', val='') {
        // Cache les listes
        document.querySelectorAll('.content-section').forEach(e => e.classList.add('hidden'));
        // Affiche le form
        document.getElementById('generic-form').classList.remove('hidden');

        // Remplit les champs cachés et visibles
        document.getElementById('inp-type').value = type;
        document.getElementById('inp-id').value = id;
        document.getElementById('inp-numero').value = num;
        document.getElementById('inp-desc').value = desc;
        document.getElementById('inp-valeur').value = val;

        // Adapte l'interface (titre, champs spécifiques)
        const lbl = document.getElementById('lbl-desc');
        const grpVal = document.getElementById('group-valeur');

        if(type === 'mdp') {
            lbl.innerText = "Mot de Passe";
            grpVal.classList.remove('hidden-field');
        } else {
            lbl.innerText = "Libellé / Description";
            grpVal.classList.add('hidden-field');
        }

        document.getElementById('form-title').innerText = (mode==='add'?'Ajouter ':'Modifier ') + type.toUpperCase();
    }

    // 3. FERMETURE DU FORMULAIRE
    function closeForm() {
        const currentType = document.getElementById('inp-type').value || 'explication';
        showSection(currentType);
    }

    // 4. RESTAURER L'ONGLET APRES RELOAD (via URL #)
    window.onload = function() {
        if(window.location.hash) {
            const section = window.location.hash.replace('#section-', '');
            // Petit fix : si l'URL pointe vers stats (qui n'existe plus), on reste sur defaut
            if(document.getElementById('section-'+section)) {
                showSection(section);
            }
        }
    }
</script>

</body>
</html>