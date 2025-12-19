<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\commun\MascotteModel;
use App\Models\salle_2\Salle2Model;

class Salle2Controller extends BaseController
{
    protected $mascotte;

    private function commonData() {
        $model = new Salle2Model();
        $this->mascotte = new MascotteModel();
        return [
            'model' => $model,
            'mascotte' => $this->mascotte->getMascottes()
        ];
    }

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
            'mascotte' => $common['mascotte'],
        ];

        return view('salle_2/IntroductionSalle2', $data);
    }

    public function Aide()
    {
        $common = $this->commonData();
        $data = [
            'introduction' => $common['model']->getIntroduction(),
            'mascotte' => $common['mascotte'],
        ];
        return view('salle_2/AideSalle2', $data);
    }

    public function Etape1()
    {
        $common = $this->commonData();
        session()->remove('nuit_chemin');

        $data = [
            'libelles' => $common['model']->getIndice(2),
            'mascotte_i' => $common['model']->getIndiceMascotte(10),
            'mascotte' => $common['mascotte']
        ];
        return view('salle_2/etape1Salle2', $data) . view('commun/footer.php');
    }

    public function Etape1a()
    {
        $common = $this->commonData();

        $data = [
            'libelles' => $common['model']->getIndice(2),
            'mascotte_i' => $common['model']->getIndiceMascotte(11),
            'mascotte' => $common['mascotte'],
            'mdp' => $common['model']->getMotDePasse1a(),
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => '',
            'placeholder_message' => null,
            'error' => null,
            'success' => false,
            'success_message' => null,
            'next_url' => base_url('/Salle2/Etape2'),
        ];

        return view('salle_2/etape1aSalle2', $data) . view('commun/footer.php');
    }

    public function validerEtape1a()
    {
        $common = $this->commonData();
        $model = $common['model'];

        $motDePasseSaisi = preg_replace('/\D+/', '', (string)$this->request->getPost('mot_de_passe'));
        $motDePasseSaisi = mb_substr($motDePasseSaisi, 0, 6);
        $motsDePasseValides = $model->getMotDePasse1a();

        $data = [
            'libelles' => $model->getIndice(2),
            'mascotte_i' => $model->getIndiceMascotte(11),
            'mascotte' => $common['mascotte'],
            'mdp' => $motsDePasseValides,
            'title' => 'Code de la Porte | Salle Mot de Passe',
            'mot_de_passe' => $motDePasseSaisi,
        ];

        if (in_array($motDePasseSaisi, $motsDePasseValides, true)) {
            session()->remove('echecs_Etape1a');

            $data['placeholder_message'] = null;
            $data['error'] = null;
            $data['success'] = true;
            $data['success_message'] = "Bravo ! Le code est correct.";

            $data['next_url'] = $this->getNextUrl('Etape1a');
        } else {
            if ($this->checkMaxFailures('Etape1a')) {
                return redirect()->to('Salle2/Etapef');
            }

            $data['placeholder_message'] = 'Code incorrect. Réessayez.';
            $data['error'] = 'Code incorrect. Réessayez.';
            $data['success'] = false;
            $data['success_message'] = null;
            $data['next_url'] = base_url('/Salle2/Etape2');
        }

        return view('salle_2/etape1aSalle2', $data) . view('commun/footer.php');
    }

    public function Etape2()
    {
        $common = $this->commonData();
        $model = $common['model'];

        $data = [
            'libelles' => $model->getDistinctLibelles(4),
            'indices' => $model->getIndice(4),
            'mascotte_i' => $model->getIndiceMascotte(12),
            'mascotte' => $common['mascotte'],
            'success' => false,
            'success_message' => null,
            'error' => null,
            'code' => '',
            'title' => 'Coffre Fort | Salle Mot de Passe',
            'next_url' => '#',
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $code = preg_replace('/\D+/', '', (string)$this->request->getPost('code'));
            $code = mb_substr($code, 0, 6);
            $data['code'] = $code;

            if (mb_strlen($code) < 6) {
                $data['error'] = "Le code doit contenir 6 chiffres.";
            } else {
                if ($model->checkCode($code)) {
                    session()->remove('echecs_Etape2');
                    $data['success'] = true;
                    $data['success_message'] = "Bravo ! Le code est correct.";
                    $data['next_url'] = $this->getNextUrl('Etape2');
                } else {
                    if ($this->checkMaxFailures('Etape2')) {
                        return redirect()->to('Salle2/Etapef');
                    }
                    $data['error'] = "Mot de passe incorrect";
                }
            }
        }

        return view('salle_2/etape2Salle2', $data);
    }

    public function etape2a()
    {
        if (session()->get('mode') !== 'jour') {
            return redirect()->to('Salle2/Etape5');
        }

        $common = $this->commonData();
        $data = [
            'libelles' => $common['model']->getIndice(5),
            'mascotte' => $common['mascotte']
        ];
        return view('salle_2/etape2aSalle2', $data) . view('commun/footer.php');
    }

    public function Etape3()
    {
        $common = $this->commonData();
        $model = $common['model'];

        $data = [
            'libelles' => $model->getIndice(6),
            'mascotte_i' => $model->getIndiceMascotte(13),
            'mascotte' => $common['mascotte'],
            'title' => 'Mallette | Salle Mot de Passe',
            'success' => false,
            'success_message' => null,
            'error' => '',
            'code' => '',
            'next_url' => '#'
        ];

        if (strtolower($this->request->getMethod()) === 'post') {
            $pwd = trim((string) $this->request->getPost('code'));

            if (!$this->isStrongPwd($pwd)) {
                $data['error'] = 'Mot de passe non conforme (12+ char, Maj, min, chiffre, spécial).';
                $data['code'] = $pwd;
            } else {
                session()->remove('echecs_Etape3');
                $data['success'] = true;
                $data['success_message'] = 'Bravo ! La mallette est ouverte.';
                $data['code'] = '';
                $data['next_url'] = $this->getNextUrl('Etape3');
            }
        }

        return view('salle_2/Etape3Salle2', $data);
    }

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

    public function Etape4()
    {
        $common = $this->commonData();
        $data = [
            'libelles' => $common['model']->getIndice(7),
            'mascotte_i' => $common['model']->getIndiceMascotte(14),
            'mascotte' => $common['mascotte'],
            'title' => 'Téléphone | Salle Mot de Passe',
            'code' => '',
            'error' => '',
            'success' => false,
            'success_message' => null,
            'next_url' => '#',
        ];
        return view('salle_2/Etape4Salle2', $data);
    }

    public function validerEtape4()
    {
        $common = $this->commonData();
        $model = $common['model'];
        $code = trim((string) $this->request->getPost('code'));

        $data = [
            'libelles' => $model->getIndice(7),
            'mascotte_i' => $model->getIndiceMascotte(14),
            'mascotte' => $common['mascotte'],
            'title' => 'Téléphone | Salle Mot de Passe',
            'code' => $code,
        ];

        if ($model->checkPhoneCode($code)) {
            session()->remove('echecs_Etape4');
            $data['error'] = null;
            $data['success'] = true;
            $data['success_message'] = "Bravo ! Le téléphone est déverrouillé.";
            $data['next_url'] = $this->getNextUrl('Etape4');
        } else {
            if ($this->checkMaxFailures('Etape4')) {
                return redirect()->to('Salle2/Etapef');
            }
            $data['error'] = "Mot de passe incorrect.";
            $data['success'] = false;
            $data['success_message'] = null;
            $data['next_url'] = '#';
        }

        return view('salle_2/Etape4Salle2', $data);
    }

    public function passwordRandom()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['status'=>'error']);
        }
        $model = new Salle2Model();
        $password = $model->getRandomPassword();
        return $this->response->setJSON(['status' => 'ok', 'password' => $password]);
    }

    public function Etape5()
    {
        $common = $this->commonData();
        $model = $common['model'];

        $data = [
            'libelles' => $model->getIndice(8),
            'mascotte_i'=> $model->getIndiceMascotte(15),
            'mascotte' => $common['mascotte'],
            'error' => null,
            'success' => false,
            'next_url' => '#'
        ];

        if ($this->request->getMethod() === 'post') {

            $estValide = $this->request->getPost('resultat_jeu') === '1';

            if ($estValide) {
                session()->remove('echecs_Etape5');
                session()->remove('nuit_chemin');
                return redirect()->to('Salle2/Etapeb');
            } else {
                if ($this->checkMaxFailures('Etape5')) {
                    return redirect()->to('Salle2/Etapef');
                }
                $data['error'] = "Classement incorrect.";
            }
        }

        return view('salle_2/etape5Salle2', $data) . view('commun/footer.php');
    }

    public function Etapeb() {
        $common = $this->commonData();
        return view('salle_2/EtapeBonneSalle2', ['mascotte' => $common['mascotte']]);
    }

    public function Etapef() {
        $common = $this->commonData();
        session()->remove('nuit_chemin');
        return view('salle_2/EtapeFausseSalle2', ['mascotte' => $common['mascotte']]);
    }

    private function checkMaxFailures(string $step): bool
    {
        if (session()->get('mode') !== 'nuit') {
            return false;
        }

        $key = 'echecs_' . $step;
        $count = session()->get($key) ?? 0;
        $count++;
        session()->set($key, $count);

        if ($count >= 3) {
            session()->remove($key);
            return true;
        }

        return false;
    }

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

        if ($currentStep === 'Etape1a' || empty($chemin)) {

            $candidats = ['Etape2', 'Etape3', 'Etape4'];

            shuffle($candidats);

            $nombreEtapes = rand(2, 3);

            $selection = array_slice($candidats, 0, $nombreEtapes);

            $chemin = array_merge(['Etape1a'], $selection, ['Etape5']);

            session()->set('nuit_chemin', $chemin);
        }

        $positionActuelle = array_search($currentStep, $chemin);

        if ($positionActuelle !== false && isset($chemin[$positionActuelle + 1])) {
            $prochaineEtape = $chemin[$positionActuelle + 1];
            return base_url('/Salle2/' . $prochaineEtape);
        }

        if ($currentStep === 'Etape5') {
            return base_url('/Salle2/Etapeb');
        }

        return base_url('/Salle2/Etape5');
    }
}