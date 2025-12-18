<?php

namespace App\Models\salle_2;

use CodeIgniter\Model;
class Salle2Model extends Model
{
    protected $table = 'indice';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $returnType = 'array';


    public function getIntroduction()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('explication');

        $query = $builder->select('libelle')
            ->whereIn('numero', [12, 13, 14])
            ->orderBy('RAND()')
            ->get(1);

        return $query->getRow();
    }


    public function getIndice($numero)
    {
        return $this->db->table('explication')
            ->select('libelle')
            ->where('numero', $numero)
            ->get()
            ->getRow();
    }

    public function getIndiceMascotte($numero)
    {
        return $this->db->table('indice')
            ->select('libelle')
            ->where('numero', $numero)
            ->get()
            ->getRow();
    }

    public function getMotDePasse1a(): array
    {
        $builder = $this->db->table('mot_de_passe');

        $query = $builder->select('motPasse')
            ->distinct()
            ->whereIn('motPasse', ['789546','321456','912364'])
            ->get();

        $results = $query->getResult();

        $motsDePasse = [];
        foreach ($results as $row) {
            $mot = preg_replace('/\D+/', '', (string)$row->motPasse); // ne garde que les chiffres
            $mot = mb_substr($mot, 0, 6); // coupe à 6 caractères si nécessaire
            $motsDePasse[] = $mot;
        }

        return $motsDePasse;
    }

    /**
     * Retourne $limit libellés distincts aléatoires
     */
    public function getDistinctLibelles(int $limit = 3)
    {
        return $this->select('libelle')
            ->distinct()
            ->whereIn('libelle', ['4897', '1123', '9875', '8745'])
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Vérifie si le code est correct en le comparant à la table mot_de_passe.motPasse
     */
    public function checkCode(string $code): bool
    {
        $codeDigits = preg_replace('/\D+/', '', $code);
        $codeDigits = mb_substr($codeDigits, 0, 6);

        if (mb_strlen($codeDigits) !== 6) {
            return false; // sécurité : on exige 6 chiffres
        }

        $db = \Config\Database::connect();
        $builder = $db->table('mot_de_passe');

        // 3) Récupérer TOUS les mots de passe
        $rows = $builder->select('motPasse')->get()->getResultArray();

        if (!$rows) {
            return false;
        }

        foreach ($rows as $row) {
            // Normalisation du mot de passe en base
            $dbCode = preg_replace('/\D+/', '', $row['motPasse'] ?? '');
            $dbCode = mb_substr($dbCode, 0, 6);

            if ($dbCode === $codeDigits) {
                return true;
            }
        }

        return false;
    }

    public function getRandomPassword(): ?string
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mot_de_passe');

        $builder->select('motPasse');
        $builder->where("motPasse REGEXP '[A-Za-z]'");
        $builder->where("motPasse REGEXP '[0-9]'");
        $builder->orderBy('RAND()', '', false);
        $builder->limit(1);

        $row = $builder->get()->getRowArray();
        return $row['motPasse'] ?? null;
    }
    public function checkPhoneCode(string $code): bool
    {
        $builder = $this->db->table('mot_de_passe');

        $builder->where('motPasse', trim($code));

        $builder->whereIn('numero', [96, 97]);

        return $builder->countAllResults() > 0;
    }
}