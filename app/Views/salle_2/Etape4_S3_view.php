<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Téléphone | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape4_Salle3.webp') ?>">
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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape4_Salle3.webp') ?>');"></div>

    <form method="post" action="<?= site_url('Etape4') ?>">
        <?= csrf_field() ?>

        <div class="genere-telephone" id="genere-telephone" style="cursor:pointer;" aria-label="Générer un nouveau mot de passe"></div>

        <div class="ecran-telephone" aria-live="polite">
            <span id="password-display" class="password-display"></span>
        </div>

        <input type="hidden" name="code" id="code-hidden" value="">

        <div class="validate-container">
            <button type="submit" id="btn-validate" class="btn btn--ghost btn--xl btn-passe">
                Valider
            </button>
        </div>
    </form>

    <aside id="message-intro"
           class="tip-panel tip-panel--top tip-panel--autohide"
           role="status"
           aria-live="polite"
           style="<?= (!empty($error) || !empty($success)) ? 'display:none !important;' : '' ?>">
        <p class="tip-desc">
            Étape 4 : Trouve le mot de passe du téléphone pour permettre de trouver des informations cruciales !
        </p>
    </aside>

    <script>
        // Ce script gère uniquement le cas du F5 (Actualisation simple sans soumission)
        (function() {
            if (performance.getEntriesByType("navigation")[0]?.type === 'reload') {
                const msg = document.getElementById('message-intro');
                if(msg) msg.style.display = 'none';
            }
        })();
    </script>
    <article class="aide-telephone">
        <p>
            Information importante à retenir !
        </p>
        <p>
            Pour trouver le code, vous devez appuyer sur le bouton en orange. Cette action permet de générer automatiquement un mot de passe sécurisé et unique.
        </p>
        <p>
            Attention, le mot de passe peut être plus ou moins complexe. Ne négligez surtout pas la difficulté de cette étape, car elle garantit l'ouverture du Téléphone !
        </p>
    </article>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneDiv     = document.getElementById('genere-telephone');
            const displaySpan  = document.getElementById('password-display');
            const hiddenCode   = document.getElementById('code-hidden');
            const errorBox     = document.getElementById('code-error');
            const validateBtn  = document.getElementById('btn-validate');

            if (!phoneDiv || !displaySpan || !hiddenCode) return;

            let generating = false; // empêche les doubles requêtes

            phoneDiv.addEventListener('click', function () {
                if (generating) return;

                // RESET DU MESSAGE D'ERREUR
                if (errorBox) {
                    errorBox.textContent = '';
                    errorBox.style.display = 'none';
                }

                // (Optionnel) reset visuel du mot de passe précédent
                // displaySpan.textContent = '';

                generating = true;
                phoneDiv.classList.add('loading');
                phoneDiv.setAttribute('aria-busy', 'true');

                fetch("<?= base_url('/Etape4/password-random') ?>", {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Réponse HTTP invalide');
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'ok') {
                            const password = (data.password || '').trim();
                            displaySpan.textContent = password;
                            hiddenCode.value = password;

                        } else {
                            displaySpan.textContent = '';
                            hiddenCode.value = '';
                            alert(data.message || 'Erreur lors de la génération du code');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        displaySpan.textContent = '';
                        hiddenCode.value = '';
                        alert('Erreur réseau lors de la génération du code');
                    })
                    .finally(() => {
                        generating = false;
                        phoneDiv.classList.remove('loading');
                        phoneDiv.removeAttribute('aria-busy');
                    });
            });

            // Optionnel : effacer l'erreur au clic sur "Valider"
            if (validateBtn) {
                validateBtn.addEventListener('click', () => {
                    //
                });
            }
        });
    </script>

    <?php if (!empty($success)): ?>
        <div class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre">
            <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
                <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                    <?= esc($success_message ?? 'Bravo ! Le code est correct. Le Téléphone est maintenant déverrouillée.') ?>
                </p>
                <a href="<?= esc($next_url ?? site_url('Etape5')) ?>"
                   class="tip-btn btn--xl"
                   id="go-next"
                   aria-label="Passer à la salle suivante">
                    Passer à la salle suivante
                </a>
            </aside>
        </div>
        <script>
            (function(){ try { document.getElementById('go-next')?.focus(); } catch(e){} })();
        </script>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div
                id="code-error"
                role="alert"
                aria-live="assertive"
                style="
                position: absolute;
                top: calc(43% + 0px);
                left: 0;
                width: 133%;
                padding: 0.25em 0;
                margin: 0;
                text-align: center;
                font: inherit;
                font-size: 1.2em;
                font-weight: 700;
                color: #ff3b30;
                background: transparent;
                pointer-events: none;
                z-index: 2;
            "
        >
            <?= esc($error) ?>
        </div>
    <?php else: ?>
        <div id="code-error" style="display:none;" aria-live="polite"></div>
    <?php endif; ?>



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
    document.addEventListener("DOMContentLoaded", () => {
        const mascotte = document.getElementById("mascotte");
        const bulle = document.getElementById("mascotte-bulle");
        const txt = document.getElementById("bulle-texte");
        const actions = document.getElementById("bulle-actions");

        const indices = [
            "Indice : générez un mot de passe plutôt long en suivant les recommandations de la CNIL !"
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