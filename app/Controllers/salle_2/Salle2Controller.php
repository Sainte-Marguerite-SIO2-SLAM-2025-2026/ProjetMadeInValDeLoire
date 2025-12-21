<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\salle_2\Salle2Model;

/**
 * Contrôleur des étapes de la Salle 2 (mode jour/nuit).
 * - Gestion de l’introduction et de l’aide
 * - Parcours des étapes 1 à 5, validation et navigation
 * - Génération du mot de passe aléatoire (AJAX)
 * - Comptage des échecs et redirection vers les fins (limité à la nuit)
 */
class Salle2Controller extends BaseController
{
    /** Cache des données de mascotte pour éviter des réinstanciations répétées */
    protected $mascotte;

    /**
     * Prépare le modèle Salle2 et les données de mascotte pour les vues.
     * Retourne un tableau commun avec:
     * - model: Salle2Model
     * - mascotte: sources d’images des différentes mascottes
     */
    private function commonData()
    {
        $model = new Salle2Model();
        $this->mascotte = new MascotteModel();

        return [
            'model'    => $model,
            'mascotte' => $this->mascotte->getMascottes(),
        ];
    }

    /**
     * Page d’introduction:
     * - Réinitialise les compteurs d’échecs et le chemin nuit
     * - Charge le libellé d’introduction et la mascotte
     */
    public function Introduction()
    {
        $common = $this->commonData();

        session()->remove('nuit_chemin');
        session()->remove('echecs_Etape1a');
        session()->remove('echecs_Etape2');
        session()->remove('echecs_Etape3');
        session()->remove('echecs_Etape4');
        session()->remove('echecs_Etape5');

        $data = [
            'introduction' => $common['model']->getIntroduction(),
            'mascotte'     => $common['mascotte'],
        ];

        return view('salle_2/IntroductionSalle2', $data);
    }

    /**
     * Page d’aide (réutilise le libellé d’introduction et la mascotte pour cohérence).
     */
    public function Aide()
    {
        $common = $this->commonData();

        $data = [
            'introduction' => $common['model']->getIntroduction(),
            'mascotte'     => $common['mascotte'],
        ];

        return view('salle_2/AideSalle2', $data);
    }

    /**
     * Étape 1 (entrée du parcours):
     * - Nettoie le chemin nuit
     * - Charge l’indice, les indices mascotte et la mascotte
     * - Ajoute le footer partagé
     */
    public function Etape1()
    {
        $common = $this->commonData();

        session()->remove('nuit_chemin');

        $data = [
            'libelles'    => $common['model']->getIndice(2),
            'mascotte_i'  => $common['model']->getIndiceMascotte(10),
            'mascotte'    => $common['mascotte'],
        ];

        return view('salle_2/etape1Salle2', $data) . view('commun/footer.php');
    }

    /**
     * Étape 1a (digicode):
     * - Prépare les libellés, indices mascotte et la liste des mots de passe valides
     * - Initialise les flags d’état et l’URL de suite
     */
    public function Etape1a()
    {
        $common = $this->commonData();

        $data = [
            'libelles'            => $common['model']->getIndice(2),
            'mascotte_i'          => $common['model']->getIndiceMascotte(11),
            'mascotte'            => $common['mascotte'],
            'mdp'                 => $common['model']->getMotDePasse1a(),
            'title'               => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe'        => '',
            'placeholder_message' => null,
            'error'               => null,
            'success'             => false,
            'success_message'     => null,
            'next_url'            => '#',
        ];

        return view('salle_2/etape1aSalle2', $data) . view('commun/footer.php');
    }

    /**
     * Validation Étape 1a:
     * - Normalise la saisie (garde 6 chiffres)
     * - En mode nuit: construit un chemin de 3 étapes (Etape1a + 2), avec contrainte “Etape5 pas en dernier”
     * - Au succès: prépare la prochaine URL selon le chemin; à l’échec: incrémente et redirige vers fin “Etapef” si max atteint (nuit uniquement)
     */
    public function validerEtape1a()
    {
        $common = $this->commonData();
        $model  = $common['model'];

        $motDePasseSaisi = preg_replace('/\D+/', '', (string) $this->request->getPost('mot_de_passe'));
        $motDePasseSaisi = mb_substr($motDePasseSaisi, 0, 6);

        $motsDePasseValides = $model->getMotDePasse1a();

        $data = [
            'libelles'     => $model->getIndice(2),
            'mascotte_i'   => $model->getIndiceMascotte(11),
            'mascotte'     => $common['mascotte'],
            'mdp'          => $motsDePasseValides,
            'title'        => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => $motDePasseSaisi,
        ];

        if (in_array($motDePasseSaisi, $motsDePasseValides, true)) {
            session()->remove('echecs_Etape1a');

            if (session()->get('mode') === 'nuit') {
                $candidats = ['Etape2', 'Etape3', 'Etape4', 'Etape5'];
                $sequences = [];
                foreach ($candidats as $a) {
                    foreach ($candidats as $b) {
                        if ($a !== $b && $b !== 'Etape5') {
                            $sequences[] = [$a, $b];
                        }
                    }
                }
                $selection = $sequences[random_int(0, count($sequences) - 1)];
                $chemin    = array_merge(['Etape1a'], $selection);
                session()->set('nuit_chemin', $chemin);
            } else {
                session()->remove('nuit_chemin');
            }

            $data['placeholder_message'] = null;
            $data['error']               = null;
            $data['success']             = true;
            $data['success_message']     = "Bravo ! Le code est correct.";
            $data['next_url']            = $this->getNextUrl('Etape1a');
        } else {
            if ($this->checkMaxFailures('Etape1a')) {
                return redirect()->to(base_url('/Salle2/Etapef'));
            }

            $data['placeholder_message'] = 'Code incorrect. Réessayez.';
            $data['error']               = 'Code incorrect. Réessayez.';
            $data['success']             = false;
            $data['success_message']     = null;
            // On reste sur place en cas d’erreur
            $data['next_url']            = '#';
        }

        return view('salle_2/etape1aSalle2', $data) . view('commun/footer.php');
    }

    /**
     * Étape 2 (coffre fort):
     * - Normalise le code en 6 chiffres
     * - Vérifie le code via le modèle, marque l’état et détermine la prochaine URL
     * - Échec: incrémente et bascule vers fin “Etapef” si max atteint (nuit uniquement)
     */
    public function Etape2()
    {
        $common = $this->commonData();
        $model  = $common['model'];

        $data = [
            'libelles'        => $model->getDistinctLibelles(4),
            'indices'         => $model->getIndice(4),
            'mascotte_i'      => $model->getIndiceMascotte(12),
            'mascotte'        => $common['mascotte'],
            'success'         => false,
            'success_message' => null,
            'error'           => null,
            'code'            => '',
            'title'           => 'Coffre Fort | Salle Mot de Passe',
            'next_url'        => '#',
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $code         = preg_replace('/\D+/', '', (string) $this->request->getPost('code'));
            $code         = mb_substr($code, 0, 6);
            $data['code'] = $code;

            if (mb_strlen($code) < 6) {
                $data['error'] = "Le code doit contenir 6 chiffres.";
            } else {
                if ($model->checkCode($code)) {
                    session()->remove('echecs_Etape2');
                    $data['success']         = true;
                    $data['success_message'] = "Bravo ! Le code est correct.";
                    $data['next_url']        = $this->getNextUrl('Etape2');
                } else {
                    if ($this->checkMaxFailures('Etape2')) {
                        return redirect()->to(base_url('/Salle2/Etapef'));
                    }
                    $data['error'] = "Mot de passe incorrect";
                }
            }
        }

        return view('salle_2/etape2Salle2', $data);
    }

    /**
     * Étape 2a (jour uniquement):
     * - Redirige vers Étape 5 si appelée en mode nuit
     * - Charge l’indice et la mascotte
     * - Ajoute le footer partagé
     */
    public function etape2a()
    {
        if (session()->get('mode') !== 'jour') {
            return redirect()->to(base_url('/Salle2/Etape5'));
        }

        $common = $this->commonData();

        $data = [
            'libelles' => $common['model']->getIndice(5),
            'mascotte' => $common['mascotte'],
        ];

        return view('salle_2/etape2aSalle2', $data) . view('commun/footer.php');
    }

    /**
     * Étape 3 (mallette):
     * - Vérifie la robustesse du mot de passe (12+ chars, maj/min/chiffre/spécial)
     * - Au succès: prépare la prochaine URL, nettoie la saisie
     */
    public function Etape3()
    {
        $common = $this->commonData();
        $model  = $common['model'];

        $data = [
            'libelles'        => $model->getIndice(6),
            'mascotte_i'      => $model->getIndiceMascotte(13),
            'mascotte'        => $common['mascotte'],
            'title'           => 'Mallette | Salle Mot de Passe',
            'success'         => false,
            'success_message' => null,
            'error'           => '',
            'code'            => '',
            'next_url'        => '#',
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $pwd = trim((string) $this->request->getPost('code'));

            if (!$this->isStrongPwd($pwd)) {
                // Échec: message d’erreur
                $data['error'] = 'Mot de passe non conforme (12+ char, Maj, min, chiffre, spécial).';
                $data['code']  = $pwd;

                // Compter les échecs et basculer vers Etapef au 3e (nuit uniquement)
                if ($this->checkMaxFailures('Etape3')) {
                    return redirect()->to(base_url('/Salle2/Etapef'));
                }
            } else {
                // Succès: nettoyer le compteur et préparer la suite
                session()->remove('echecs_Etape3');
                $data['success']         = true;
                $data['success_message'] = 'Bravo ! La mallette est ouverte.';
                $data['code']            = '';
                $data['next_url']        = $this->getNextUrl('Etape3');
            }
        }

        return view('salle_2/Etape3Salle2', $data);
    }

    /**
     * Valide la robustesse d’un mot de passe:
     * - Longueur minimale 12
     * - Présence de majuscule, minuscule, chiffre et caractère spécial
     */
    private function isStrongPwd(string $pwd): bool
    {
        if ($pwd === '') return false;
        if (mb_strlen($pwd) < 12) return false;
        if (!preg_match('/[A-Z]/', $pwd)) return false;
        if (!preg_match('/[a-z]/', $pwd)) return false;
        if (!preg_match('/\d/', $pwd)) return false;
        if (!preg_match('/[^A-Za-z0-9]/', $pwd)) return false;

        return true;
    }

    /**
     * Étape 4 (téléphone):
     * - Prépare l’état de la page et le titre
     * - L’affiche; la validation se fait via validerEtape4()
     */
    public function Etape4()
    {
        $common = $this->commonData();

        $data = [
            'libelles'        => $common['model']->getIndice(7),
            'mascotte_i'      => $common['model']->getIndiceMascotte(14),
            'mascotte'        => $common['mascotte'],
            'title'           => 'Téléphone | Salle Mot de Passe',
            'code'            => '',
            'error'           => '',
            'success'         => false,
            'success_message' => null,
            'next_url'        => '#',
        ];

        return view('salle_2/Etape4Salle2', $data);
    }

    /**
     * Validation Étape 4:
     * - Vérifie le mot de passe saisi via le modèle
     * - Au succès: fixe la prochaine URL; à l’échec: incrémente le compteur et bascule vers “Etapef” si max atteint (nuit uniquement)
     */
    public function validerEtape4()
    {
        $common = $this->commonData();
        $model  = $common['model'];

        $code = trim((string) $this->request->getPost('code'));

        $data = [
            'libelles'   => $model->getIndice(7),
            'mascotte_i' => $model->getIndiceMascotte(14),
            'mascotte'   => $common['mascotte'],
            'title'      => 'Téléphone | Salle Mot de Passe',
            'code'       => $code,
        ];

        if ($model->checkPhoneCode($code)) {
            session()->remove('echecs_Etape4');
            $data['error']           = null;
            $data['success']         = true;
            $data['success_message'] = "Bravo ! Le téléphone est déverrouillé.";
            $data['next_url']        = $this->getNextUrl('Etape4');
        } else {
            if ($this->checkMaxFailures('Etape4')) {
                return redirect()->to(base_url('/Salle2/Etapef'));
            }
            $data['error']           = "Mot de passe incorrect.";
            $data['success']         = false;
            $data['success_message'] = null;
            $data['next_url']        = '#';
        }

        return view('salle_2/Etape4Salle2', $data);
    }

    /**
     * Endpoint AJAX pour un mot de passe aléatoire (Étape 4):
     * - Requiert une requête AJAX
     * - Retourne JSON avec {status, password}
     */
    public function passwordRandom()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error']);
        }

        $model    = new Salle2Model();
        $password = $model->getRandomPassword();

        return $this->response->setJSON(['status' => 'ok', 'password' => $password]);
    }

    /**
     * Étape 5 (classement des Post-it):
     * - Au succès: en mode nuit, suit le chemin; en mode jour, redirige vers la bonne fin
     * - À l’échec: incrémente, bascule vers “Etapef” si max atteint (nuit uniquement)
     * - Ajoute le footer partagé
     */
    public function Etape5()
    {
        $common = $this->commonData();
        $model  = $common['model'];

        $data = [
            'libelles'   => $model->getIndice(8),
            'mascotte_i' => $model->getIndiceMascotte(15),
            'mascotte'   => $common['mascotte'],
            'error'      => null,
            'success'    => false,
            'next_url'   => '#',
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $estValide = $this->request->getPost('resultat_jeu') === '1';

            if ($estValide) {
                session()->remove('echecs_Etape5');

                if (session()->get('mode') === 'nuit') {
                    $next = $this->getNextUrl('Etape5');
                    return redirect()->to($next);
                }

                session()->remove('nuit_chemin');
                return redirect()->to(base_url('/Salle2/Etapeb'));
            }

            if ($this->checkMaxFailures('Etape5')) {
                return redirect()->to(base_url('/Salle2/Etapef'));
            }

            $data['error'] = "Classement incorrect.";
        }

        return view('salle_2/etape5Salle2', $data) . view('commun/footer.php');
    }

    /**
     * Fin “bonne” (jour/nuit):
     * - Nettoie le chemin et affiche la vue de réussite
     */
    public function Etapeb()
    {
        $common = $this->commonData();

        session()->remove('nuit_chemin');

        return view('salle_2/EtapeBonneSalle2', ['mascotte' => $common['mascotte']]);
    }

    /**
     * Fin “fausse” (jour/nuit):
     * - Nettoie le chemin et affiche la vue d’échec
     */
    public function Etapef()
    {
        $common = $this->commonData();

        session()->remove('nuit_chemin');

        return view('salle_2/EtapeFausseSalle2', ['mascotte' => $common['mascotte']]);
    }

    /**
     * Incrémente et teste le nombre d’échecs d’une étape.
     * - Nuit: limite à 3 échecs max, puis redirection vers la fin fausse
     * - Jour: échecs illimités (pas de redirection ni de reset)
     * Retourne true si le maximum (3) est atteint en mode nuit et que le compteur est remis à zéro.
     */
    private function checkMaxFailures(string $step): bool
    {
        $mode = session()->get('mode');

        // En mode jour: échecs illimités, on ne compte pas et on ne bloque pas
        if ($mode !== 'nuit') {
            return false;
        }

        $key   = 'echecs_' . $step;
        $count = (int) (session()->get($key) ?? 0);
        $count++;
        session()->set($key, $count);

        if ($count >= 3) {
            // On réinitialise le compteur et on nettoie le chemin nuit pour éviter les incohérences
            session()->remove($key);
            session()->remove('nuit_chemin');
            return true;
        }

        return false;
    }

    /**
     * Détermine l’URL de la prochaine étape selon le mode.
     * - Jour: progression linéaire prédéfinie (+ nettoyage du chemin nuit)
     * - Nuit: chemin de 3 étapes mémorisé en session (Etape1a + 2),
     */
    private function getNextUrl(string $currentStep): string
    {
        $mode = session()->get('mode');

        if ($mode === 'jour') {
            session()->remove('nuit_chemin');

            switch ($currentStep) {
                case 'Etape1a': return base_url('/Salle2/Etape2');
                case 'Etape2':  return base_url('/Salle2/Etape2a');
                case 'Etape2a': return base_url('/Salle2/Etape3');
                case 'Etape3':  return base_url('/Salle2/Etape4');
                case 'Etape4':  return base_url('/Salle2/Etape5');
                case 'Etape5':  return base_url('/Salle2/Etapeb');
                default:        return base_url('/Salle2/Introduction');
            }
        }

        $chemin = session()->get('nuit_chemin');

        // Construit le chemin si absent (au milieu du parcours ou juste après Etape1a)
        if (empty($chemin)) {
            $candidats = ['Etape2', 'Etape3', 'Etape4', 'Etape5'];

            if (in_array($currentStep, $candidats, true)) {
                $restants        = array_values(array_diff($candidats, [$currentStep]));
                $finalCandidates = array_values(array_diff($restants, ['Etape5']));
                $final           = $finalCandidates[random_int(0, count($finalCandidates) - 1)];
                $chemin          = ['Etape1a', $currentStep, $final];
            } else {
                $sequences = [];
                foreach ($candidats as $a) {
                    foreach ($candidats as $b) {
                        if ($a !== $b && $b !== 'Etape5') {
                            $sequences[] = [$a, $b];
                        }
                    }
                }
                $selection = $sequences[random_int(0, count($sequences) - 1)];
                $chemin    = array_merge(['Etape1a'], $selection);
            }

            session()->set('nuit_chemin', $chemin);
        }

        $positionActuelle = array_search($currentStep, $chemin, true);

        if ($positionActuelle !== false && isset($chemin[$positionActuelle + 1])) {
            $prochaineEtape = $chemin[$positionActuelle + 1];
            return base_url('/Salle2/' . $prochaineEtape);
        }

        // Fin du parcours nuit -> bonne fin
        return base_url('/Salle2/Etapeb');
    }
}