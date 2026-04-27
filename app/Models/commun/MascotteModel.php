<?php

namespace App\Models\commun;

use CodeIgniter\Model;

class MascotteModel extends Model
{
    protected $table = 'mascotte';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['image', 'humeur'];

    /**
     * Retourne toutes les mascottes
     * @return array
     */
    public function getMascottes()
    {
        $mascottes = $this->findAll();
        return array_column($mascottes, 'image', 'humeur');
    }

    /**
     * Retourne l'image de la mascotte correspondante à l'humeur mise en paramètre
     * @param $humeur l'humeur de la mascotte
     * @return string
     */
    public function getMascotteByHumeur($humeur) : string
    {
        $row = $this->where('humeur', $humeur)->first();

        return $row['image'];

    }
}