<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\salle_2\Salle2Model;

class Salle2Controller extends BaseController
{

    public function Introduction()
    {
        return view('salle_2\Introduction_view');

    }

    public function Aide()
    {
        return view('salle_2\Aide_view');
    }

    public function Etape1()
    {
        return view('salle_2\Etape1_S3_View')
            . view('commun\footer.php');
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
            'next_url' => session()->getFlashdata('next_url') ?? base_url('/Etape1b'),
        ];
        echo view('salle_2\etape1a_s3_view', $data);
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
                'next_url' => base_url('/Etape1b'),
            ];

            // On renvoie la vue directement pour afficher l’overlay de succès
            return view('salle_2\etape1a_s3_view', $data);
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
        echo view('salle_2\etape1a_s3_view', $data);
        echo view('commun\footer.php');

    }

    /* Etape 1b */
    public function Etape1b()
    {
        // Vérifie si c'est un POST
        if (strtolower($this->request->getMethod()) === 'post') {
            return $this->validerEtape1b();
        }

        // Affichage initial (GET)
        return view('salle_2\etape1b_s3_view', [
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '',
            'error' => null,
            'success' => false,
            'success_message' => null,
            'next_url' => base_url('/Etape2'),
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
        $next_url = base_url('/Etape2');

        if (strlen($motDePasse) < 6) {
            $error = 'Le code doit contenir 6 chiffres.';
        } elseif ($motDePasse === '489677' || $motDePasse === '111111'|| $motDePasse === '123456') {
            $error = 'Interdit : Ancien code.';
        } elseif (count(array_unique(str_split($motDePasse))) < 6) {
            $error = 'Chaque chiffre doit être différent.';
        } else {
            $success = true;
            $success_message = 'Bravo ! Le code est mis a jour. La porte est maintenant sécurisé.';
        }

        return view('salle_2\etape1b_s3_view', [
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
        $libelles = $model->getDistinctLibelles(3); // récupérer 3 libelles pour la view

        // Données par défaut
        $data = [
            'libelles' => $libelles,
            'success' => false,
            'success_message' => null,
            'error' => null,
            'code' => '',
            'next_url' => base_url('/Etape2a'), // ou la page suivante souhaitée
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

        return view('salle_2\etape2_s3_view', $data);
    }

    public function etape2a()
    {
        return
            view('salle_2\Etape2a_S3_View', [
                'title'   => 'Etape 2 | Salle Mot de Passe',
                'message' => session()->getFlashdata('message'),
                'error'   => session()->getFlashdata('error'),
            ])
            . view('commun\footer');
    }


    /* Etape 3 */
    public function Etape3()
    {
        // Données par défaut
        $data = [
            'title'           => 'Mallette | Salle Mot de Passe',
            'success'         => false,
            'success_message' => null,
            'error'           => '',
            'code'            => '',
            'next_url'        => base_url('/Etape4'),
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $pwd = (string) $this->request->getPost('code');
            $pwd = trim($pwd);

            $errors = [];

            if ($pwd === '') {
                $errors[] = 'Le mot de passe est requis.';
            }

            $len = mb_strlen($pwd);
            if ($len < 16) {
                $errors[] = 'Au moins 16 caractères.';
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
                $data['error'] = 'Mot de passe non conforme (16+ caractères, 1 maj, 1 min, 1 chiffre, 1 spécial).';
            } else {
                // Aucun mot de passe fixé: tout mot de passe complexe est accepté
                $data['success'] = true;
                $data['success_message'] = 'Bravo ! Le mot de passe est conforme. La mallette est maintenant ouverte.';
            }

            // Toujours vider l’input après validation (succès ou erreur)
            $data['code'] = '';
        }

        return view('salle_2\Etape3_S3_View', $data);
    }

    /* Etape 4 */
    public function Etape4()
    {

        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape4();
        }

        $data = [
            'title' => 'Téléphone | Salle Mot de Passe',
            'code' => '',
            'error' => '',
            'success' => false,
            'success_message' => null,
            'next_url' => site_url('Etape5'),
        ];

        return view('salle_2\Etape4_S3_View', $data);
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
                'next_url' => site_url('Etape5'),
            ];
        } else {
            $data = [
                'title' => 'Téléphone | Salle Mot de Passe',
                'code' => '',
                'error' => "Mot de passe incorrect ",
                'success' => false,
                'success_message' => null,
                'next_url' => site_url('Etape5'),
            ];
        }

        return view('salle_2\Etape4_S3_View', $data);
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
        return view('salle_2\Etape5_S3_View')
            . view('commun\footer.php');
    }

    public function Etapef()
    {
        return view('salle_2\Etape_Final_view');
    }


}