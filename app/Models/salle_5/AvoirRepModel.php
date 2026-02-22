<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class AvoirRepModel extends Model
{
    protected $table = 'avoir_rep';
    protected $primaryKey = ['objet_id', 'activite_numero'];
    protected $returnType = 'object';
    protected $allowedFields = ['objet_id', 'activite_numero'];

    /**
     * Vérifier si une réponse est correcte (équivalent verifierZone)
     */
    public function verifierZone($activite_numero, $reponse)
    {
        // retrouver l'objet correspondant à la réponse cliquée
        $objet = $this->db->table('objets')
            ->where('reponse', $reponse)
            ->get()
            ->getRow();

        if (!$objet) {
            return [
                'valid' => false,
                'message' => 'Objet introuvable'
            ];
        }

        // vérifier si cet objet est une bonne réponse pour l'activité
        $bonneRep = $this->db->table('avoir_rep')
            ->where('activite_numero', $activite_numero)
            ->where('objet_id', $objet->id)
            ->countAllResults();

        return [
            'valid' => $bonneRep > 0,
            'objet' => $objet
        ];
    }

    /**
     * Compter le nombre de bonnes réponses attendues pour une activité
     * (équivalent countBonnesReponses)
     */
    public function countBonnesReponses($activite_numero)
    {
        return $this->db->table('avoir_rep')
            ->where('activite_numero', $activite_numero)
            ->countAllResults();
    }

    /**
     * Récupérer toutes les bonnes réponses d'une activité (optionnel)
     */
    public function getBonnesReponsesByActivite($activite_numero)
    {
        return $this->db->table('objets')
            ->select('objet.reponse')
            ->join('avoir_rep', 'avoir_rep.objet_id = objets.id')
            ->where('avoir_rep.activite_numero', $activite_numero)
            ->get()
            ->getResult();
    }
}