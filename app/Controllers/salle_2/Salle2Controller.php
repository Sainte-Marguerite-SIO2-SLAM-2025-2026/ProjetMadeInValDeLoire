<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\salle_2\Salle2Model;

class Salle2Controller extends BaseController
{

    public function Introduction()
    {
        $model = new Salle2Model();
        $introduction =$model->getIntroduction();
        $data = [
            'introduction' => $introduction,

        ];

        return view('salle_2/IntroductionSalle2',$data);

    }

    public function Aide()
    {
        $model = new Salle2Model();
        $introduction =$model->getIntroduction();
        $data = [
            'introduction' => $introduction,

        ];

        return view('salle_2/AideSalle2',$data);
    }

    public function Etape1()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(2);
        $mascotte_i = $model->getIndiceMascotte(10);
        $data = [
            'libelles' => $indice
            ,'mascotte_i' => $mascotte_i
        ];
        echo view('salle_2/etape1Salle2', $data);
        echo view('commun/footer.php');
    }




    /* Etape 1a */
    public function Etape1a()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(2);
        $mascotte_i = $model->getIndiceMascotte(11);
        $mdp = $model->getMotDePasse1a();


        // Si POST, on valide
        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape1a();
        }

        // GET : affichage initial
        $data = [
            'libelles' => $indice,
            'mascotte_i' => $mascotte_i,
            'mdp' => $mdp,
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '',
            'placeholder_message' => session()->getFlashdata('placeholder_message') ?? null,
            'error' => session()->getFlashdata('error') ?? null,
            'success' => session()->getFlashdata('success') ?? false,
            'success_message' => session()->getFlashdata('success_message') ?? null,
            'next_url' => session()->getFlashdata('next_url') ?? base_url('/Salle2/Etape2'),
        ];

        echo view('salle_2/etape1aSalle2', $data);
        echo view('commun/footer.php');
    }

    public function validerEtape1a()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(2);
        $mascotte_i = $model->getIndiceMascotte(11);
        $mdp = $model->getMotDePasse1a();

        // Mot de passe saisi par l'utilisateur
        $motDePasseSaisi = preg_replace('/\D+/', '', (string)$this->request->getPost('mot_de_passe'));
        $motDePasseSaisi = mb_substr($motDePasseSaisi, 0, 6);

        // Tous les mots de passe valides
        $motsDePasseValides = $model->getMotDePasse1a();

        if (in_array($motDePasseSaisi, $motsDePasseValides, true)) {
            // Code correct
            $data = [
                'libelles' => $indice,
                'mascotte_i' => $mascotte_i,
                'mdp' => $mdp,
                'title' => 'Code de la Porte | Salle Mot de Passe',
                'mot_de_passe' => '',
                'placeholder_message' => null,
                'error' => null,
                'success' => true,
                'success_message' => "Bravo ! Le code est correct. La porte est maintenant déverrouillée.",
                'next_url' => base_url('/Salle2/Etape2'),
            ];

            return view('salle_2/etape1aSalle2', $data);
        }

        // Code incorrect
        $data = [
            'libelles' => $indice,
            'mascotte_i' => $mascotte_i,
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '',
            'placeholder_message' => 'Code incorrect. Réessayez.',
            'error' => 'Code incorrect. Réessayez.',
            'success' => false,
        ];

        echo view('salle_2/etape1aSalle2', $data);
        echo view('commun/footer.php');
    }

    /* Etape 2 */
    public function Etape2()
    {
        $model = new Salle2Model();
        $libelles = $model->getDistinctLibelles(4); // récupérer 3 libelles pour la view
        $indices = $model->getIndice(4);
        $mascotte_i = $model->getIndiceMascotte(12);

        // Données par défaut
        $data = [
            'libelles' => $libelles,
            'indices' => $indices,
            'mascotte_i' => $mascotte_i,
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

        return view('salle_2/etape2Salle2', $data);
    }

    public function etape2a()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(5);
        $data = [
            'libelles' => $indice
        ];
        echo view('salle_2/etape2aSalle2', $data)
            . view('commun/footer.php');
    }


    /* Etape 3 */
    public function Etape3()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(6);
        $mascotte_i = $model->getIndiceMascotte(13);

        $data = [
            'libelles'        => $indice,
            'mascotte_i'        => $mascotte_i,
            'title'           => 'Mallette | Salle Mot de Passe',
            'success'         => false,
            'success_message' => null,
            'error'           => '',
            'code'            => '',
            'next_url'        => base_url('/Salle2/Etape4'),
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $pwd = trim((string) $this->request->getPost('code'));

            if (!$this->isStrongPwd($pwd)) {
                $data['error'] = 'Mot de passe non conforme (12+ caractères, 1 maj, 1 min, 1 chiffre, 1 spécial, pas de séquences simples).';
                $data['code']  = '';
            } else {
                $data['success'] = true;
                $data['success_message'] = 'Bravo ! Le mot de passe est conforme. La mallette est maintenant ouverte.';
                $data['code'] = '';
            }
        }

        return view('salle_2/Etape3Salle2', $data);
    }

    /**
     * Version simple: règles de base + quelques rejets évidents.
     */
    private function isStrongPwd(string $pwd): bool
    {
        // Règles minimales
        if ($pwd === '') return false;
        if (mb_strlen($pwd) < 12) return false;
        if (!preg_match('/[A-Z]/', $pwd)) return false;        // au moins 1 maj
        if (!preg_match('/[a-z]/', $pwd)) return false;        // au moins 1 min
        if (!preg_match('/\d/', $pwd)) return false;           // au moins 1 chiffre
        if (!preg_match('/[^A-Za-z0-9]/', $pwd)) return false; // au moins 1 spécial

        return true;
    }

    /* Etape 4 */
    public function Etape4()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(7);
        $mascotte_i = $model->getIndiceMascotte(14);

        if ($this->request->getMethod() === 'post') {
            return $this->validerEtape4();
        }

        $data = [
            'libelles' => $indice,
            'mascotte_i' => $mascotte_i,
            'title' => 'Téléphone | Salle Mot de Passe',
            'code' => '',
            'error' => '',
            'success' => false,
            'success_message' => null,
            'next_url' => site_url('Salle2/Etape5'), // a modif ??
        ];

        return view('salle_2/Etape4Salle2', $data);
    }

    public function validerEtape4()
    {
        $model = new Salle2Model();
        $indice = $model->getIndice(7);
        $mascotte_i = $model->getIndiceMascotte(14);
        $code = trim((string) $this->request->getPost('code'));

        $validPasswords = [
            'Karvion42-b',
            'Zorliam87ax!@',
            'Farytek31z-31'
        ];

        if (in_array($code, $validPasswords, true)) {
            $data = [
                'libelles' => $indice,
                'mascotte_i' => $mascotte_i,
                'title' => 'Téléphone | Salle Mot de Passe',
                'code' => '',
                'error' => null,
                'success' => true,
                'success_message' => "Bravo ! Le code est correct. Le Téléphone est maintenant déverrouillée.",
                'next_url' => site_url('Salle2/Etape5'),
            ];
        } else {
            $data = [
                'libelles' => $indice,
                'mascotte_i' => $mascotte_i,
                'title' => 'Téléphone | Salle Mot de Passe',
                'code' => '',
                'error' => "Mot de passe incorrect ",
                'success' => false,
                'success_message' => null,
                'next_url' => site_url('Salle2/Etape5'),
            ];
        }

        return view('salle_2/Etape4Salle2', $data);
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
        $mascotte_i = $model->getIndiceMascotte(15);
        $data = [
            'libelles' => $indice,
            'mascotte_i'=> $mascotte_i,
        ];
        echo view('salle_2/etape5Salle2', $data)
            . view('commun/footer.php');

    }

    public function Etapeb()
    {
        return view('salle_2/EtapeBonneSalle2');
    }
    public function Etapef()
    {
        return view('salle_2/EtapeFausseSalle2');
    }


}