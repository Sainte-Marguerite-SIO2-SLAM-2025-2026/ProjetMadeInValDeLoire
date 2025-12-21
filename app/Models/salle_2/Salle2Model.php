<?php

namespace App\Models\salle_2;

use CodeIgniter\Model;

/**
 * Modèle Salle 2
 * - Accès aux libellés d’explication/indice
 * - Vérifications de codes et mots de passe
 * - Sélections aléatoires pour l’introduction et l’étape téléphone
 */
class Salle2Model extends Model
{
    protected $table         = 'indice';
    protected $primaryKey    = 'numero';
    protected $allowedFields = ['numero', 'libelle'];
    protected $returnType    = 'array';

    /**
     * Retourne un libellé d’introduction aléatoire parmi explication.numero ∈ {12,13,14}.
     * @return object|null Ligne unique avec propriété 'libelle'
     */
    public function getIntroduction()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('explication');

        $query = $builder
            ->select('libelle')
            ->whereIn('numero', [12, 13, 14])
            ->orderBy('RAND()')
            ->get(1);

        return $query->getRow();
    }

    /**
     * Retourne le libellé d’explication pour un numéro donné.
     * @param int $numero
     * @return object|null Ligne unique avec propriété 'libelle'
     */
    public function getIndice($numero)
    {
        return $this->db->table('explication')
            ->select('libelle')
            ->where('numero', $numero)
            ->get()
            ->getRow();
    }

    /**
     * Retourne le libellé d’indice (mascotte) pour un numéro donné.
     * @param int $numero
     * @return object|null Ligne unique avec propriété 'libelle'
     */
    public function getIndiceMascotte($numero)
    {
        return $this->db->table('indice')
            ->select('libelle')
            ->where('numero', $numero)
            ->get()
            ->getRow();
    }

    /**
     * Liste des mots de passe valides pour l’étape 1a:
     * - Prend mot_de_passe.motPasse où valeur = 'Etape1a'
     * - Ne conserve que les chiffres
     * - Tronque à 6 caractères
     * @return array Liste de strings (6 chiffres)
     */
    public function getMotDePasse1a(): array
    {
        $builder = $this->db->table('mot_de_passe');

        $query = $builder
            ->select('motPasse')
            ->distinct()
            ->whereIn('valeur', ['Etape1a'])
            ->get();

        $results     = $query->getResult();
        $motsDePasse = [];

        foreach ($results as $row) {
            $mot = preg_replace('/\D+/', '', (string) $row->motPasse);
            $mot = mb_substr($mot, 0, 6);
            $motsDePasse[] = $mot;
        }

        return $motsDePasse;
    }

    /**
     * Retourne $limit libellés distincts choisis aléatoirement parmi un ensemble prédéfini.
     * @param int $limit
     * @return array[] Chaque entrée contient 'libelle'
     */
    public function getDistinctLibelles(int $limit = 3): array
    {
        return $this->db->table('mot_de_passe')
            ->select('motPasse')
            ->distinct()
            ->whereIn('valeur', ['Etape2-Introduction'])
            ->orderBy('RAND()', '', false)
            ->limit($limit)
            ->get()
            ->getResultArray();
    }


    /**
     * Vérifie qu’un code à 6 chiffres correspond à un mot de passe enregistré:
     * - Normalise la saisie et les valeurs en base (chiffres uniquement, longueur 6)
     * - Compare en exact
     * @param string $code
     * @return bool
     */
    public function checkCode(string $code): bool
    {
        $codeDigits = preg_replace('/\D+/', '', $code);
        $codeDigits = mb_substr($codeDigits, 0, 6);

        if (mb_strlen($codeDigits) !== 6) {
            return false;
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('mot_de_passe');

        $rows = $builder->select('motPasse')->get()->getResultArray();
        if (!$rows) {
            return false;
        }

        foreach ($rows as $row) {
            $dbCode = preg_replace('/\D+/', '', $row['motPasse'] ?? '');
            $dbCode = mb_substr($dbCode, 0, 6);

            if ($dbCode === $codeDigits) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retourne un mot de passe aléatoire contenant au moins une lettre et un chiffre.
     * @return string|null
     */
    public function getRandomPassword(): ?string
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('mot_de_passe');

        $builder->select('motPasse');
        $builder->where("motPasse REGEXP '[A-Za-z]'");
        $builder->where("motPasse REGEXP '[0-9]'");
        $builder->orderBy('RAND()', '', false);
        $builder->limit(1);

        $row = $builder->get()->getRowArray();

        return $row['motPasse'] ?? null;
    }

    /**
     * Vérifie le code du téléphone (Étape 4):
     * - Correspondance exacte sur mot_de_passe.motPasse
     * - Filtré sur valeur = 'Etape4-Accept'
     * @param string $code
     * @return bool
     */
    public function checkPhoneCode(string $code): bool
    {
        $builder = $this->db->table('mot_de_passe');

        $builder->where('motPasse', trim($code));
        $builder->whereIn('valeur', ['Etape4-Accept']);

        return $builder->countAllResults() > 0;
    }
}