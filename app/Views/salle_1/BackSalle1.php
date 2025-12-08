<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Salle 1</title>

    <?= link_tag('styles/salle_1/salle1Global.css') ?>
    <?= link_tag('styles/salle_1/salle1Back.css') ?>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Administration Salle 1</h1>
        <p>Gestion des activités d’ingénierie sociale</p>
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

            <?= form_open('/salle1/activites/add', ['id' => 'addActivityForm']) ?>

            <div class="form-group">
                <label>Libellé du message</label>
                <textarea name="libelle" required></textarea>
            </div>

            <div class="form-group">
                <label>Difficulté</label>
                <select name="difficulte_numero">
                    <option value="1">Facile</option>
                </select>
            </div>

            <button class="btn btn-primary">Ajouter</button>

            <?= form_close() ?>
        </div>

        <div class="card">
            <h3>Liste des activités</h3>
            <div id="activitiesList" class="loading">Chargement…</div>
        </div>

    </div>

    <!-- ERREURS -->
    <div id="erreurs" class="tab-content">

        <div class="card">
            <h3>Ajouter une erreur</h3>

            <?= form_open('/salle1/erreurs/add', ['id' => 'addErrorForm']) ?>

            <div class="form-group">
                <label>Activité</label>
                <select name="activite_numero" id="errorActivitySelect" required>
                    <option value="">Sélectionnez</option>
                </select>
            </div>

            <div class="form-group">
                <label>Mot incorrect</label>
                <input type="text" name="mot_incorrect" required>
            </div>

            <div class="form-group">
                <label>Explication</label>
                <textarea name="explication" required></textarea>
            </div>

            <button class="btn btn-primary">Ajouter</button>

            <?= form_close() ?>
        </div>

        <div class="card">
            <h3>Erreurs par activité</h3>
            <select id="viewErrorsSelect"></select>
            <div id="errorsList"></div>
        </div>

    </div>

    <!-- STATISTIQUES -->
    <div id="stats" class="tab-content">
        <div class="stats">
            <div class="stat-card">
                <h4 id="totalActivites">0</h4><p>Activités</p>
            </div>
            <div class="stat-card">
                <h4 id="totalErreurs">0</h4><p>Erreurs</p>
            </div>
            <div class="stat-card">
                <h4 id="totalIndices">0</h4><p>Indices</p>
            </div>
        </div>

        <div class="card">
            <h3>Détails</h3>
            <div id="statsDetails" class="loading">Chargement…</div>
        </div>
    </div>

</div>

<script src="<?= base_url('js/salle_1/salle1Back.js') ?>"></script>
</body>
</html>
