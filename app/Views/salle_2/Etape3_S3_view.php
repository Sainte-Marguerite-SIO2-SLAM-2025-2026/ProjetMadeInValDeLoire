<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Mallette | Salle Mot de Passe') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape3_Salle3.webp') ?>" type="image/jpeg">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=4">
</head>
<body>
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

<div class="game-fixed-wrapper">

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape3_Salle3.webp') ?>');"></div>

    <form id="complex-form" method="post" action="<?= esc(current_url()) ?>" autocomplete="off">
        <?= csrf_field() ?>

        <div class="ecran-malette">
            <label for="code" class="sr-only">Entrez le mot de passe de la mallette</label>

            <textarea
                    id="code"
                    name="code"
                    autocomplete="off"
                    autocapitalize="off"
                    spellcheck="false"
                    placeholder="Saisissez le mot de passe"
                    data-default-placeholder="Saisissez le mot de passe"
                    aria-label="Mot de passe de la mallette"
                    aria-invalid="<?= !empty($error) ? 'true' : 'false' ?>"
                    maxlength="64"
                    rows="3"
                <?= !empty($success) ? 'disabled' : '' ?>
            ></textarea>

            <div id="label-message"
                 class="label-message <?= empty($error) ? 'is-hidden' : '' ?>">
                <?= esc($error) ?>
            </div>
        </div>

        <div class="reset-malette" style="border:none;">
            <button type="reset" aria-label="Effacer" title="Effacer"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"></button>
        </div>

        <div class="valide-malette" style="border:none;">
            <button type="submit" aria-label="Valider" title="Valider"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>
    </form>

    <?php if (!empty($success)): ?>
        <div class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre" style="z-index: 10000;">
            <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
                <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                    <?= esc($success_message ?? 'Bravo ! Le mot de passe est conforme. La mallette est maintenant ouverte.') ?>
                </p>
                <a href="<?= esc($next_url ?? site_url('etape4')) ?>" class="tip-btn btn--xl" id="go-next" aria-label="Passer à la salle suivante">
                    Passer à la salle suivante
                </a>
            </aside>
        </div>
        <script>
            (function(){ try { document.getElementById('go-next')?.focus(); } catch(e){} })();
        </script>
    <?php endif; ?>

    <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            Étape 3 : Crée un code Sécurisé pour la malette. Elle te donnera des informations précieuses !
        </p>
    </aside>
    <script>
        (function() {
            // 1. Détection du rechargement (F5)
            const isReload = performance.getEntriesByType("navigation")[0]?.type === 'reload';

            // 2. Détection de la validation (Si 'label-message' n'a pas la classe 'is-hidden', c'est qu'il y a une erreur)
            const errorDiv = document.getElementById('label-message');
            const isValidation = errorDiv && !errorDiv.classList.contains('is-hidden') && errorDiv.innerText.trim().length > 0;

            // Si c'est un F5 OU une tentative de validation échouée, on cache le message
            if (isReload || isValidation) {
                const msg = document.getElementById('message-intro');
                if(msg) msg.style.display = 'none';
            }
        })();
    </script>
    <div class="mascotte-container">
        <img id="mascotte" src="<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>" alt="Mascotte">
    </div>

    <div id="mascotte-bulle">
        <div id="bulle-texte"></div>
        <div id="bulle-actions"></div>
        <div class="bulle-fleche"></div>
    </div>

</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>
    <footer>
        <?= $this->include('commun\footer') ?>
    </footer>
</div>


<script>
    // Au chargement: champ vide et focus (si pas en succès)
    (function () {
        try {
            if (!<?= json_encode(!empty($success)) ?>) {
                const input = document.getElementById('code');
                input.value = '';
                input.defaultValue = '';
                input.focus();
            }
        } catch (e) {}
    })();

    // Reset: vide le champ, cache le message centré et remet le placeholder par défaut
    document.getElementById('complex-form')?.addEventListener('reset', function () {
        const input = document.getElementById('code');
        const labelMsg = document.getElementById('label-message');
        setTimeout(() => {
            if (input) {
                input.value = '';
                input.defaultValue = '';
                input.setAttribute('placeholder', input.dataset.defaultPlaceholder || 'Saisissez le mot de passe');
                input.setAttribute('aria-invalid', 'false');
                input.focus();
            }
            if (labelMsg) {
                labelMsg.textContent = '';
                labelMsg.classList.add('is-hidden');
            }
        }, 0);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const mascotte = document.getElementById("mascotte");
        const bulle = document.getElementById("mascotte-bulle");
        const txt = document.getElementById("bulle-texte");
        const actions = document.getElementById("bulle-actions");

        const indices = [
            "Indice : Il faut un mot de passe qui respect les consignes de la CNIL !"
        ];

        let index = 0;
        let timer = null;

        /* Positionne la bulle dynamiquement */
        function positionnerBulle() {
            const r = mascotte.getBoundingClientRect();
            bulle.style.left = Math.max(10, r.left + r.width/2 - bulle.offsetWidth/2) + "px";
            bulle.style.top = Math.max(10, r.top - bulle.offsetHeight - 20) + "px";
        }

        function bouton(label, action) {
            const b = document.createElement("button");
            b.textContent = label;
            b.onclick = action;
            return b;
        }

        function afficherQuestion() {
            clearTimeout(timer);
            mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_exclamee.svg') ?>";

            txt.textContent = "Souhaites-tu un indice ?";
            actions.innerHTML = "";
            actions.appendChild(bouton("Oui", afficherIndice));
            actions.appendChild(bouton("Non", () => {
                bulle.style.display = "none";
                mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>";
            }));

            bulle.style.display = "block";
            setTimeout(positionnerBulle, 10);
        }

        function afficherIndice() {
            clearTimeout(timer);
            txt.textContent = indices[index];
            index = (index + 1) % indices.length;

            actions.innerHTML = "";
            actions.appendChild(bouton("OK", () => {
                bulle.style.display = "none";
                mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>";
            }));

            bulle.style.display = "block";
            setTimeout(positionnerBulle, 10);

            timer = setTimeout(() => {
                bulle.style.display = "none";
                mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>";
            }, 6000);
        }

        // Survol mascotte
        mascotte.addEventListener("mouseenter", () => {
            mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_exclamee.svg') ?>";
        });
        mascotte.addEventListener("mouseleave", () => {
            if(bulle.style.display !== "block"){
                mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>";
            }
        });

        // Clic mascotte
        mascotte.addEventListener("click", () => {
            if (bulle.style.display === "block") {
                bulle.style.display = "none";
                mascotte.src = "<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>";
            } else {
                afficherQuestion();
            }
        });

        // Repositionnement dynamique
        window.addEventListener("resize", () => { if(bulle.style.display==="block") positionnerBulle(); });
        window.addEventListener("scroll", () => { if(bulle.style.display==="block") positionnerBulle(); });
    });
</script>
</body>
</html>