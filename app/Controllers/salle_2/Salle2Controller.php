<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\salle_2\Salle2Model;

class Salle2Controller extends BaseController
{

    public function Introduction()
    {
        $model = new Salle2Model();
        $libelles = $model->getMotDePasse1();
        $introduction =$model->getIntroduction();
        $data = [
            'libelles' => $libelles,
            'introduction' => $introduction,

        ];

        return view('salle_2\IntroductionSalle2',$data);

    }

    public function Aide()
    {
        $model = new Salle2Model();
        $libelles = $model->getMotDePasse1();
        $data = [
            'libelles' => $libelles
        ];
        return view('salle_2\AideSalle2',$data);
    }

    public function Etape1()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(2);
        $data = [
            'libelles' => $indice
        ];
        echo view('salle_2\etape1Salle2', $data);
        echo view('commun\footer.php');
    }




    /* Etape 1a */
    public function Etape1a()
    {
        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape1a();
        }

        // Affichage initial (GET)
        $data = [
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '', // champ vide par défaut
            'placeholder_message' => session()->getFlashdata('placeholder_message') ?? null,
            'error' => session()->getFlashdata('error') ?? null,

            // Champs succès potentiels (si tu viens d'un PRG, par ex.)
            'success' => session()->getFlashdata('success') ?? false,
            'success_message' => session()->getFlashdata('success_message') ?? null,
            'next_url' => session()->getFlashdata('next_url') ?? base_url('/Salle2/Etape1b'),
        ];
        echo view('salle_2\etape1aSalle2', $data);
        echo view('commun\footer.php');
    }

    public function validerEtape1a()
    {
        $motDePasse = (string)$this->request->getPost('mot_de_passe');

        // Nettoyage (chiffres uniquement, 6 max)
        $motDePasse = preg_replace('/\D+/', '', $motDePasse);
        $motDePasse = mb_substr($motDePasse, 0, 6);

        if ($motDePasse === '489677') {
            // Code correct -> on affiche un message centré + bouton "Passer à la salle suivante"
            $data = [
                'title' => 'Code de la Porte | Salle Mot de Passe',
                'mot_de_passe' => '',
                'placeholder_message' => null,
                'error' => null,
                'success' => true,
                'success_message' => "Bravo ! Le code est correct. La porte est maintenant déverrouillée.",
                'next_url' => base_url('/Salle2/Etape1b'),
            ];

            // On renvoie la vue directement pour afficher l’overlay de succès
            return view('salle_2\etape1aSalle2', $data);
        }

        // Code incorrect -> reset auto + message dans le placeholder (et aussi dans $error pour compat)
        $data = [
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '', // reset du champ pour que le placeholder soit visible
            'placeholder_message' => 'Code incorrect. Réessayez.',
            'error' => 'Code incorrect. Réessayez.',
            'success' => false,
        ];

        // On renvoie directement la vue (pas de withInput pour ne pas réinsérer l'ancienne valeur)
        echo view('salle_2\etape1aSalle2', $data);
        echo view('commun\footer.php');

    }

    /* Etape 1b */
    public function Etape1b()
    {
        $model = new Salle2Model();
        $libelles = $model->getIndice(3); // Renommé pour correspondre à la vue

        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape1b();
        }

        return view('salle_2/etape1bSalle2', [
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '',
            'error' => null,
            'success' => false,
            'success_message' => null,
            'next_url' => base_url('/Salle2/Etape2'),
            'libelles' => $libelles,
        ]);
    }


    public function validerEtape1b()
    {
        $motDePasse = (string) $this->request->getPost('mot_de_passe');
        $motDePasse = preg_replace('/\D+/', '', $motDePasse);
        $motDePasse = substr($motDePasse, 0, 6);

        $error = null;
        $success = false;
        $success_message = null;
        $next_url = base_url('/Salle2/Etape2');

        // Fonction pour détecter une année plausible
        $isBirthYear = function($year) {
            return $year >= 1900 && $year <= 2024;
        };

        // Extraction des tranches d'année possibles
        $year1 = intval(substr($motDePasse, 0, 4)); // XXXX--
        $year2 = intval(substr($motDePasse, 2, 4)); // --XXXX
        $year3 = intval(substr($motDePasse, 1, 4)); // -XXXX-

        if (strlen($motDePasse) < 6) {
            $error = 'Le code doit contenir 6 chiffres.';
        } elseif ($motDePasse === '489677' || $motDePasse === '111111' || $motDePasse === '123456') {
            $error = 'Interdit : Ancien code.';
        } elseif (count(array_unique(str_split($motDePasse))) < 6) {
            $error = 'Chaque chiffre doit être différent.';
        }
        // contrôle DATE
        elseif ($isBirthYear($year1) || $isBirthYear($year2) || $isBirthYear($year3)) {
            $error = 'Interdit : Le code ressemble à une date de naissance.';
        }
        else {
            $success = true;
            $success_message = 'Bravo ! Le code est mis à jour. La porte est maintenant sécurisée.';
        }

        return view('salle_2\etape1bSalle2', [
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => $motDePasse,
            'error' => $error,
            'success' => $success,
            'success_message' => $success_message,
            'next_url' => $next_url,
        ]);
    }


    /* Etape 2 */
    public function Etape2()
    {
        $model = new Salle2Model();
        $libelles = $model->getDistinctLibelles(4); // récupérer 3 libelles pour la view
        $indices = $model->getIndice(4);



        // Données par défaut
        $data = [
            'libelles' => $libelles,
            'indices' => $indices,
            'success' => false,
            'success_message' => null,
            'error' => null,
            'code' => '',
            'next_url' => base_url('/Salle2/Etape2a'), // ou la page suivante souhaitée
            'title' => 'Coffre Fort | Salle Mot de Passe',
        ];

        // POST ?
        if (strtolower($this->request->getMethod()) === 'post') {
            // Normalisation: 6 chiffres max
            $code = (string) $this->request->getPost('code');
            $code = preg_replace('/\D+/', '', $code);
            $code = mb_substr($code, 0, 6);

            if (mb_strlen($code) < 6) {
                $data['error'] = "Le code doit contenir 6 chiffres.";
            } else {
                if ($model->checkCode($code)) {
                    $data['success'] = true;
                    $data['success_message'] = "Bravo ! Le code est correct. Le coffre est maintenant déverrouillée.";
                } else {
                    $data['error'] = "Mot de passe incorrect";
                }
            }

            $data['code'] = $code;
        }

        return view('salle_2\etape2Salle2', $data);
    }

    public function etape2a()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(5);
        $data = [
            'libelles' => $indice
        ];
        echo view('salle_2\etape2aSalle2', $data)
            . view('commun\footer.php');
    }


    /* Etape 3 */
    public function Etape3()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(6);
        // Données par défaut
        $data = [
            'libelles' => $indice,
            'title'           => 'Mallette | Salle Mot de Passe',
            'success'         => false,
            'success_message' => null,
            'error'           => '',
            'code'            => '',
            'next_url'        => base_url('/Salle2/Etape4'),
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $pwd = (string) $this->request->getPost('code');
            $pwd = trim($pwd);

            $errors = [];

            if ($pwd === '') {
                $errors[] = 'Le mot de passe est requis.';
            }

            $len = mb_strlen($pwd);
            if ($len < 12) {
                $errors[] = 'Au moins 12 caractères.';
            }

            if (!preg_match('/[A-Z]/u', $pwd)) {
                $errors[] = 'Au moins une majuscule.';
            }
            if (!preg_match('/[a-z]/u', $pwd)) {
                $errors[] = 'Au moins une minuscule.';
            }
            if (!preg_match('/\d/u', $pwd)) {
                $errors[] = 'Au moins un chiffre.';
            }
            if (!preg_match('/[^A-Za-z0-9]/u', $pwd)) {
                $errors[] = 'Au moins un caractère spécial.';
            }

            if (!empty($errors)) {
                // Message unique et concis au milieu
                $data['error'] = 'Mot de passe non conforme (12+ caractères, 1 maj, 1 min, 1 chiffre, 1 spécial).';
            } else {
                // Aucun mot de passe fixé: tout mot de passe complexe est accepté
                $data['success'] = true;
                $data['success_message'] = 'Bravo ! Le mot de passe est conforme. La mallette est maintenant ouverte.';
            }

            // Toujours vider l’input après validation (succès ou erreur)
            $data['code'] = '';
        }

        return view('salle_2\Etape3Salle2', $data);
    }

    /* Etape 4 */
    public function Etape4()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(7);

        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape4();
        }

        $data = [
            'libelles' => $indice,
            'title' => 'Téléphone | Salle Mot de Passe',
            'code' => '',
            'error' => '',
            'success' => false,
            'success_message' => null,
            'next_url' => site_url('/Salle2/Etape5'), // a modif ??
        ];

        return view('salle_2\Etape4Salle2', $data);
    }

    public function validerEtape4()
    {
        $code = trim((string) $this->request->getPost('code'));

        $validPasswords = [
            'Karvion42-b',
            'Zorliam87ax!@',
            'Farytek31z-31'
        ];

        if (in_array($code, $validPasswords, true)) {
            $data = [
                'title' => 'Téléphone | Salle Mot de Passe',
                'code' => '',
                'error' => null,
                'success' => true,
                'success_message' => "Bravo ! Le code est correct. Le Téléphone est maintenant déverrouillée.",
                'next_url' => site_url('/Salle2/Etape5'),
            ];
        } else {
            $data = [
                'title' => 'Téléphone | Salle Mot de Passe',
                'code' => '',
                'error' => "Mot de passe incorrect ",
                'success' => false,
                'success_message' => null,
                'next_url' => site_url('/Salle2/Etape5'),
            ];
        }

        return view('salle_2\Etape4Salle2', $data);
    }

    public function passwordRandom()
    {
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['status' => 'error', 'message' => 'Requête invalide']);
        }

        $model = new Salle2Model();
        $password = $model->getRandomPassword(); // récupère depuis la base

        if (!$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Aucun mot de passe trouvé en base']);
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'password' => $password
        ]);
    }

    public function Etape5()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(8);
        $data = [
            'libelles' => $indice
        ];
        echo view('salle_2\etape5Salle2', $data)
            . view('commun\footer.php');

    }

    public function Etapeb()
    {
        return view('salle_2\EtapeBonneSalle2');
    }
    public function Etapef()
    {
        return view('salle_2\EtapeFausseSalle2');
    }


}