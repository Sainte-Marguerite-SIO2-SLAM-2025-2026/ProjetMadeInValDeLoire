<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 4</title>
    <?= link_tag('styles/salle_4/salle4.css'); ?>
</head>

<body>
<div class="image-container">
    <?= anchor(base_url().'pageFrise', ' ', [ 'class' => 'clickable-zone zone1' ] );?>
    <?= anchor(base_url().'quizFin', ' ', [ 'class' => 'clickable-zone zone2' ] );?>

    <?= anchor(base_url(), img([
            'src'   => 'images/commun/retour.png',
            'alt'   => 'retour',
            'class' => 'retour'
    ])); ?>

    <!-- Mascotte interactive -->
    <div class="mascotte-zone" id="mascotte-container">
        <img src="<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>"
             class="mascotte-img mascotte-default"
             alt="Mascotte">

        <img src="<?= base_url('images/commun/mascotte/mascotte_exclamee.svg') ?>"
             class="mascotte-img mascotte-hover"
             alt="Mascotte hover">
    </div>

    <!-- Modal des règles -->
    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>Salle 4</h2>
            <div class="rules-content">
                <h3>Mission</h3>
                <p> Vous venez de rentrer dans la chambre. Prenez le temps de bien observer les éléments qui vous entourent pour parvenir au bout de la salle.</p>

                <h3>Éléments à explorer</h3>
                <ol>
                    <li>
                        <strong>Tableau</strong><br>
                        Les traces de l'incident sont éparpillées. Replacez chaque étape au bon endroit.
                    </li>
                    <li>
                        <strong>Dossier</strong><br>
                        Vérifiez vos connaissances sur la cyber-attaque de la salle en répondant à des questions rapides.
                    </li>
                </ol>

                <h3>Progression</h3>
                <ul>
                    <li>Le <strong>tableau</strong> contient les indices à analyser.</li>
                    <li>Le <strong>dossier</strong> permet d'évaluer votre compréhension après avoir réussi la première énigme.</li>
                </ul>

                <h3>Astuce</h3>
                <p>Observez attentivement les indices avant de donner votre interprétation de l'attaque.</p>
            </div>
        </div>
    </div>


</div>

<script>
    const baseUrl = '<?= base_url() ?>';

    // Gestion de la mascotte et de la modal
    const mascotteContainer = document.getElementById('mascotte-container');
    const rulesModal = document.getElementById('rulesModal');
    const closeRules = document.querySelector('.close-rules');

    if (mascotteContainer) {
        mascotteContainer.addEventListener('click', function() {
            rulesModal.style.display = 'block';
        });
    }

    if (closeRules) {
        closeRules.addEventListener('click', function() {
            rulesModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(event) {
        if (event.target === rulesModal) {
            rulesModal.style.display = 'none';
        }
    });

    // Fermer avec Échap
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && rulesModal.style.display === 'block') {
            rulesModal.style.display = 'none';
        }
    });
</script>

</body>
</html>