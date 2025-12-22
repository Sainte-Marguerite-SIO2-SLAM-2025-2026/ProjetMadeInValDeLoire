<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Salle 1</title>

    <?= link_tag('styles/salle_1/salle1Global.css') ?>
    <?= link_tag('styles/salle_1/salle1Admin.css') ?>
</head>
<body>

<div class="container">
    <a href="<?= base_url('/gingembre/accueil') ?>"> Retour Dashboard Principal </a>
    <div class="header">
        <h1>Administration Salle 1</h1>
        <p>Gestion des activités d'ingénierie sociale</p>
    </div>

    <div class="tabs">
        <button class="tab active" data-target="activites">Activités</button>
        <button class="tab" data-target="erreurs">Erreurs</button>
        <button class="tab" data-target="stats">Statistiques</button>
    </div>

    <div id="alert" class="alert"></div>

    <!-- ACTIVITÉS -->
    <div id="activites" class="tab-content active">

        <div class="card">
            <h3>Ajouter une activité</h3>

            <?= form_open('/admin/salle1/activites/add', ['id' => 'addActivityForm']) ?>

            <div class="form-group">
                <label>Libellé du message</label>
                <textarea name="libelle" required placeholder="Décrivez l'activité..."></textarea>
            </div>

            <div class="form-group">
                <label>Difficulté</label>
                <select name="difficulte_numero" required>
                    <option value="1">Facile</option>
                    <option value="2">Moyen</option>
                    <option value="3">Difficile</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>

            <?= form_close() ?>
        </div>

        <div class="card">
            <h3>Liste des activités</h3>
            <input type="text" id="searchActivites" class="search-box" placeholder="🔍 Rechercher une activité...">

            <div class="table-container">
                <table class="data-table" id="activitiesTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Difficulté</th>
                    </tr>
                    </thead>
                    <tbody id="activitiesTableBody">
                    <tr>
                        <td colspan="7" class="empty-state">Chargement...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ERREURS -->
    <div id="erreurs" class="tab-content">

        <div class="card">
            <h3>Ajouter une erreur</h3>

            <?= form_open('/admin/salle1/erreurs/add', ['id' => 'addErrorForm']) ?>

            <div class="form-group">
                <label>Activité</label>
                <select name="activite_numero" id="errorActivitySelect" required>
                    <option value="">Sélectionnez une activité</option>
                </select>
            </div>

            <div class="form-group">
                <label>Mot incorrect</label>
                <input type="text" name="mot_incorrect" required placeholder="Ex: légitime, cliquer...">
            </div>

            <div class="form-group">
                <label>Explication</label>
                <textarea name="explication" required placeholder="Expliquez pourquoi c'est incorrect..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>

            <?= form_close() ?>
        </div>

        <div class="card">
            <h3>Liste des erreurs</h3>

            <input type="text" id="searchErreurs" class="search-box" placeholder="🔍 Rechercher une erreur...">

            <div class="table-container">
                <table class="data-table" id="errorsTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Activité</th>
                        <th>Mot incorrect</th>
                        <th>Explication</th>
                    </tr>
                    </thead>
                    <tbody id="errorsTableBody">
                    <tr>
                        <td colspan="6" class="empty-state">Chargement...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- STATISTIQUES -->
    <div id="stats" class="tab-content">
        <div class="stats">
            <div class="stat-card">
                <h4 id="totalActivites">0</h4>
                <p>Activités</p>
            </div>
            <div class="stat-card">
                <h4 id="totalErreurs">0</h4>
                <p>Erreurs</p>
            </div>
        </div>

        <div class="card">
            <h3>Détails par activité</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Activité</th>
                        <th>Difficulté</th>
                        <th>Nb Erreurs</th>
                    </tr>
                    </thead>
                    <tbody id="statsDetailsTable">
                    <tr>
                        <td colspan="5" class="empty-state">Chargement...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="<?= base_url('js/salle_1/salle1Admin.js') ?>"></script>
</body>
</html>
