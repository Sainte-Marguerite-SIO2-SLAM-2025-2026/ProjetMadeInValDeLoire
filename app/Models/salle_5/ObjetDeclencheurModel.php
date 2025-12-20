<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ObjetDeclencheurModel extends Model
{
    protected $table = 'objet_declencheur_enigme';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'width', 'height', 'zone_path', 'clip_path_name',
        'visible_si_selectionnee', 'visible_si_non_reussie', 'numero_activite'
    ];

    public function getObjetsDeclencheurs()
        {
           return $this->findAll();
        }

    /**
     * Récupère uniquement les objets pertinents pour une salle
     * selon les activités sélectionnées et réussies.
     */
    public function getObjetsPourSalle($activites_selectionnees, $activites_reussies)
    {
        $objets = $this->findAll();

        $resultat = [];

        foreach ($objets as $obj) {

            $afficher = true;

            // visible seulement si l'activité est sélectionnée
            if ($obj['visible_si_selectionnee']) {
                if (!in_array($obj['numero_activite'], $activites_selectionnees)) {
                    $afficher = false;
                }
            }

            // visible seulement si non réussie
            if ($obj['visible_si_non_reussie']) {
                if (in_array($obj['numero_activite'], $activites_reussies)) {
                    $afficher = false;
                }
            }

            if ($afficher) {
                $resultat[] = $obj;
            }
        }

        return $resultat;
    }

    public function deleteObjetDeclencheur($id)
    {
        return $this->where('id', $id)->delete();
    }
}