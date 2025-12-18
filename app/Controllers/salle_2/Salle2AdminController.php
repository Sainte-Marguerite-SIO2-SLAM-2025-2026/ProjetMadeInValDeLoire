<?php

namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\Salle2Admin;

class Salle2AdminController extends BaseController
{
    public function salle_2()
    {
        $model = new Salle2Admin();

        // On récupère tout d'un coup
        $data = $model->getAllElements();

        // On ajoute les stats
        $data['stats'] = $model->getStats();

        // Petit calcul total pour le fun
        $data['stats']['total'] = array_sum($data['stats']);

        return view('admin/salle_2', $data);
    }

    public function saveGeneric()
    {
        $model = new Salle2Admin();

        // On récupère tout le POST
        $postData = $this->request->getPost();

        // Sécurité : on vérifie que le type existe
        $type = $postData['type_element'] ?? 'explication';

        // On envoie tout au modèle qui va trier
        $model->saveElement($type, $postData);

        return redirect()->to('gingembre/salle_2#section-' . $type);
    }

    public function deleteElement($type, $id)
    {
        $model = new Salle2Admin();
        $model->deleteElement($type, $id);

        return redirect()->to('gingembre/salle_2#section-' . $type);
    }
}
