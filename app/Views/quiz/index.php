<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Salle de Quiz</title>
    <style>
        body {
            margin: 0;
            background: #222;
            color: #fff;
            font-family: sans-serif;
            overflow: hidden;
        }

        svg {
            width: 100%;
            height: 100vh;
            display: block;
            background: #222;
        }

        .zone-interactive:hover {
            cursor: pointer;
            opacity: 0.8;
        }

        /* Style interne du formulaire */
        .formulaire {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            height: 100%;
            box-sizing: border-box;
            padding: 1rem;
            /*background: #095c24;*/
        / background: radial-gradient(circle at center, #0d7a31, #095c24);
            */ *
            color: #fff;
            /*border-radius: 12px;*/
            font-size: 20px;
            background: radial-gradient(
                    circle at center,
                    #26c35a 0%, /* Plus clair au centre */ #197838 50%, /* Transition */ #095c24 100% /* Couleur foncée aux bords */
            );
        }

        .quiz-form {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }

        .formulaire h2 {
            margin-top: 0;
            font-size: 1.9rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
        }

        select {
            width: 100%;
            padding: 0.4rem;
            border-radius: 5px;
            border: none;
            background: #333;
            color: #fff;
            font-size: 1.2rem;
        }

        .btn {
            background-color: #0a510c;
            color: white;
            border: none;
            padding: 0.6rem;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
            width: 100%;
            font-size: 20px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        @font-face {
            font-family: 'Audiowide-Regular';
            src: url('<?= base_url("fonts/Audiowide-Regular.ttf") ?>');
            font-weight: normal;
            font-style: normal;
        }

        .policeTexte {
            font-family: 'Audiowide-Regular', 'Audiowide-Regular';
            filter: brightness(0.85) contrast(0.9);

        }

        .quiz-container {
            text-align: center;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .svg-wrapper {
            position: relative;
            z-index: 1;
        }

        .svg-wrapper svg {
            width: 100%;
            height: auto;
            display: block;
        }

        svg {
            max-width: 100%;
            height: auto;
            border: 2px solid var(--color-border);
            border-radius: var(--radius-md);
            background: transparent;
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <div class="svg-wrapper">
        <!-- === Le SVG === -->
        <svg width="1920" height="1080" viewBox="0 0 1920 1080"
             xmlns="http://www.w3.org/2000/svg">

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/quiz/entree_quiz.webp') ?>"
                    x="0"
                    y="0"
                    width="1920" height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Zone retour -->
            <g id="retour" class="zone-retour" data-piece="Retour">
                <image class="retour-image default" width="200" height="180"
                       x="<?= 160-100 ?>" y="<?= 130 - 90 ?>"
                       preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/quiz/home_icone_2.webp') ?>"/>
                <ellipse class="retour-zone" cx="160" cy="130" rx="100" ry="100"
                         fill="transparent" />
            </g>

            <!-- Zone lumi -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <image class="lumi-image"
                       x="1580" y="700" width="184" height="261"
                       xlink:href="<?= base_url('images/lumi/masc_base.webp') ?>"/>
            </g>

            <!-- Zone de la porte -->
            <path id="clavier"
                  d="M1320.7,850.1c-19.6,9.8-56,0-56,0,0,0,2.9-397.4,22.6-506.4,20.6-109,33.4-81.3,33.4-81.3,0,0,32.4,44.7,48.1,71.5,15.7,26.8,33.4,60.7,43.2,90.2,9.8,29.5,13.8,56.3,16.7,86.6s0,62.5-2,92c-2.9,29.5-2.9,55.4-12.8,86.6-9.8,31.3-27.5,73.2-44.2,100-15.7,26.8-29.5,50-49.1,59.8v.9Z"
            fill="transparent" class="zone-interactive" stroke-width="2" stroke="yellow"/>

            <!-- === FORMULAIRE intégré -->
            <foreignObject id="formulaire-quiz"
                           x="637.53888" y="298.81595"
                           width="561.61823" height="353.32309"
                           style="display:none;">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     class="formulaire policeTexte">
                    <h2 style="text-align:center;">Alors ?</h2>

                    <?php if (session()->has('error')): ?>
                        <div class="alert">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('quiz/demarrer') ?>" method="post" class="quiz-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="piece" value="Quizz"/>
                        <div class="form-group erase">
                            <label for="nb_questions">Nombre de questions</label>
                            <select name="nb_questions" id="nb_questions" class="policeTexte">
                                <option value="5">5 questions</option>
                                <option value="10" selected>10 questions</option>
                                <option value="15">15 questions</option>
                                <option value="20">20 questions</option>
                                <option value="30">30 questions</option>
                            </select>
                        </div>

                        <!--                        <div class="form-group erase">-->
                        <!--                            <label for="categorie_id">Catégorie (optionnel)</label>-->
                        <!--                            <select name="categorie_id" id="categorie_id">-->
                        <!--                                <option value="">Toutes les catégories</option>-->
                        <!--                                --><?php //foreach ($categories as $cat): ?>
                        <!--                                    <option value="--><?php //= $cat['id'] ?><!--">-->
                        <!--                                        --><?php //= esc($cat['nom']) ?><!-- (-->
                        <?php //= $cat['nb_questions'] ?><!--)-->
                        <!--                                    </option>-->
                        <!--                                --><?php //endforeach; ?>
                        <!--                            </select>-->
                        <!--                        </div>-->

                        <div class="form-group erase">
                            <label for="niveau_difficulte">Niveau de difficulté (optionnel)</label>
                            <select name="niveau_difficulte" id="niveau_difficulte"
                                    class="policeTexte">
                                <option value="">Tous les niveaux</option>
                                <option value="F">Facile</option>
                                <option value="M">Moyen</option>
                                <option value="D">Difficile</option>
                                <option value="E">Expert</option>
                            </select>
                        </div>

                        <!--                        <button type="submit" class="btn policeTexte">Lancer le Quiz</button>-->
                    </form>
                </div>
            </foreignObject>
        </svg>
    </div>
</div>
<script>
    const clavier = document.getElementById('clavier');
    const formSVG = document.getElementById('formulaire-quiz');
    const form = document.querySelector('#formulaire-quiz form');

    let formulaireOuvert = false;

    clavier.addEventListener('click', (e) => {
        e.stopPropagation(); // évite le clic "fermeture"

        if (!formulaireOuvert) {
            // 👉 Premier clic : afficher le formulaire
            formSVG.style.display = 'block';
            formulaireOuvert = true;
        } else {
            // 👉 Second clic : valider le formulaire
            form.submit();
        }
    });

    // 👉 clic ailleurs pour fermer le formulaire
    document.getElementById('salle-svg').addEventListener('click', (e) => {
        if (formulaireOuvert &&
            e.target.id !== 'clavier' &&
            !formSVG.contains(e.target)
        ) {
            formSVG.style.display = 'none';
            formulaireOuvert = false;
        }
    });
</script>


</body>
</html>

