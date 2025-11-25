<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title) ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_introduction_S3.css') ?>">
</head>
<body>

<div class="fixed-layer">

    <div class="bg-container">
        <img src="<?= base_url('/images/salle_2/introduction_salle3.webp') ?>"
             alt="Fond"
             style="width:1920px; height:1080px; display:block;">
    </div>

    <a class="btn btn--ghost btn--xl btn-retour" href="<?= base_url('/salle/salle_2') ?>">Retour</a>

    <a class="btn btn--ghost btn--xl btn-passe"
       href="<?= base_url('/Etape1') ?>"
       onclick="try{ sessionStorage.removeItem('etape1_suppress_intro'); sessionStorage.setItem('etape1_show_intro_once','1'); }catch(e){}">
        Commencer
    </a>

    <div class="code-intro">
        <article>
            <p>489677</p>
        </article>
    </div>

    <main class="book">
        <article class="book-text">
            <p>
                Ce grimoire poussiéreux vous introduit à la Salle des Mots de Passe, ancien bureau du célèbre détective Fox.
                Chaque recoin de cette pièce raconte une énigme, chaque objet semble murmurer un secret oublié. Ici, cinq épreuves vous attendent, plus ou moins difficiles, conçues pour tester votre logique, votre mémoire et votre sens de l’observation.
                Mais attention : il ne suffit pas de trouver des mots de passe. Vous devrez les générer, les identifier, puis les trier avec soin. Le moindre faux pas peut vous faire perdre du temps précieux.
            </p>

            <p>
                Épreuve de Génération : utilisez votre esprit pour imaginer les combinaisons possibles, à partir d’indices dissimulés, les livres ou les écrits griffonnés de Fox.
                Épreuve d’Identification : parmi une multitude de mots, seuls certains correspondent à la vérité que le détective a laissée derrière lui. Serez-vous capable de les reconnaître ?
                Épreuve de Tri : classez-les dans le bon endroit, car chaque mot de passe mal placé peut bloquer votre progression vers la réussite.
            </p>

            <p>
                Les autres épreuves, plus subtiles, reposent sur l’Observation et la Déduction. Notez le moindre détail : un livre sur le bureau, une montre arrêtée sur une heure étrange, un post-it … Tous ces indices composent le fil invisible de l’histoire de Fox.
                Trouvez la cohérence entre les éléments, et un cliquetis discret vous confirmera que vous avancez sur la bonne voie.
            </p>
        </article>
    </main>
</div>

<?php if (session()->get('mode') === 'jour'): ?>
    <div class="bouton-accueil-cluedo">
        <?= anchor('/manoirJour',
                img([
                        'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                        'alt' => 'Mascotte',
                        'class' => 'bouton-accueil-cluedo'
                ])
        ) ?>
    </div>
<?php else: ?>
    <div class="bouton-accueil-cluedo">
        <?= anchor('/',
                img([
                        'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                        'alt' => 'Mascotte',
                        'class' => 'bouton-accueil-cluedo'

                ])
        ) ?>
    </div>
<?php endif?>

<div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>

</body>
</html>