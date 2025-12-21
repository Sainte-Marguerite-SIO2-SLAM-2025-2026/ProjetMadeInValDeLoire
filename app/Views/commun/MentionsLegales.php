<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mentions légales</title>
    <?= link_tag('styles/commun/mentions.css'); ?>
</head>
<body>
<main class="container">
    <section>
        <h2>1. Éditeur du site</h2>
        <p>
            Le site <strong>EnigManor</strong> est édité par la société
            <strong>BLUT - Brigade Loufoque de l’Univers des Technophiles</strong>, au capital social de <strong>1000 €</strong>,
            dont le siège social est situé au <strong>1 rue Horizon Vert, 37130 Chambray-lès-Tours, France</strong>.
        </p>
        <ul>
            <li>Téléphone : 01 01 01 01 01</li>
            <li>Email : <a href="mailto:bts.sio.slam.stm@gmail.com">bts.sio.slam.stm@gmail.com</a></li>
            <li>Directeur de la publication : Mr PINTO</li>
            <li>Responsable éditorial : Dorian ADAM</li>
        </ul>
    </section>

    <section>
        <h2>2. Hébergement</h2>
        <p>
            Le site est hébergé en local – 1 rue Horizon Vert, 37130 Chambray-lès-Tours, France<br>
            Téléphone : None
        </p>
    </section>

    <section>
        <h2>3. Propriété intellectuelle</h2>

        <p>
            L’ensemble du contenu présent sur ce site — textes, images, graphismes, logos, vidéos, icônes,
            ainsi que l’ensemble des réalisations présentes dans les différentes salles — est la
            propriété exclusive des <strong>DNMADES de Ste Marguerite</strong>, sauf mention contraire.
        </p>

        <p>
            Chaque salle présente des créations spécifiques conçues par nos équipes :
        </p>
        <ul>
            <li>
                <strong>Salle Accueil</strong> : développement réalisé par
                <strong>S. Hovhannessian</strong>, graphismes conçus par
                <strong>Lisa DAVID, Léo REDON</strong>.
            </li>
            <li>
                <strong>Salle ingénierie sociale / Human Factor</strong> : développement réalisé par
                <strong>Mathys DAUVERGNE</strong>, graphismes conçus par
                <strong>Alice CHARY, Eloise GUTTIN</strong>.
            </li>
            <li>
                <strong>Salle Mots de passe / Key Room</strong> : développement réalisé par
                <strong>Kerrian GOUSSET</strong>, graphismes réalisés par
                <strong>Lisa-Maria SOULICE, Clara FREIDA</strong>.
            </li>
            <li>
                <strong>Salle Phising / Fake Inbox</strong> : développement réalisé par
                <strong>Enzo MENINI</strong>, graphismes réalisés par
                <strong>Clara LAGARDE, Morgane DENEUX</strong>.
            </li>
            <li>
                <strong>Salle Ransomware / Lockdown</strong> : développement réalisé par
                <strong>Benjamin PINTO</strong>, graphismes réalisés par
                <strong>Laura COUTURE, Louna BRIANNE</strong>.
            </li>
            <li>
                <strong>Salle sécurité physique et matérielle / Safe Room</strong> : développement réalisé par
                <strong>Dorian ADAM</strong>, graphismes réalisés par
                <strong>Fleur LAHAVE, Paola DESNOYERS</strong>.
            </li>
            <li>
                <strong>Salle Sécurité à l'extérieur / Access Gate</strong> : développement réalisé par
                <strong>Clovis JOUANNEAU</strong>, graphismes réalisés par
                <strong>Gaidig LE FLOCH, Yasmine PANTAIS</strong>.
            </li>
            <li>
                <strong>Espaces Mystère Quiz</strong> : développement réalisé par
                <strong>S. Hovhannessian</strong>, graphismes réalisés par
                <strong>IA</strong>.
            </li>
        </ul>

        <p>
            Les créations graphiques réalisées par nos <strong>designers partenaires</strong> et
            les productions multimédias des étudiants sont protégées par le Code de la propriété
            intellectuelle. Elles ne peuvent être utilisées, copiées, modifiées ou diffusées sans
            autorisation écrite de leurs auteurs et des DNMADES de Ste Marguerite.
        </p>

        <p>
            Toute utilisation non autorisée du contenu du site peut entraîner des poursuites
            judiciaires conformément aux articles L335-2 et suivants du Code de la propriété
            intellectuelle.
        </p>

    </section>

    <section>
        <h2>4. Limitation de responsabilité</h2>
        <p>
            Les SLAM ne sauront être tenue responsable en cas d’erreur, d’indisponibilité du site,
            ou de dommages directs ou indirects résultant de son utilisation.
        </p>
    </section>

    <!-- Bouton retour -->
    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="retour-top">
            <?= anchor('/manoirJour', img([
                    'src'   => 'images/commun/btn_retour/home_icone_4.webp',
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php else: ?>
        <div class="retour-top">
            <?= anchor('/', img([
                    'src'   => 'images/commun/btn_retour/home_icone_4.webp',
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php endif?>
</main>