<?php
namespace App\Controllers\salle_2;

use App\Controllers\BaseController;
use App\Models\admin\salle_2\Salle2Admin;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Contrôleur d’administration de la Salle 2.
 * - Liste et statistiques des contenus (explications, indices, mots de passe)
 * - Création/modification générique d’un élément avec validations
 * - Suppression d’un élément par type/numéro
 */
class Salle2AdminController extends BaseController
{
    /**
     * Affiche la page d’administration de la Salle 2 avec données et stats.
     * Charge les trois jeux de données via le modèle et expose un résumé simple.
     */
    public function salle_2()
    {
        $model = new Salle2Admin();

        // Récupération des datasets depuis le modèle
        $data = [
            'explications' => $model->getExplications(),
            'indices'      => $model->getIndices(),
            'mdps'         => $model->getMdps(),
        ];

        // Petites statistiques pour l’interface (comptages et total)
        $data['stats'] = [
            'explications' => count($data['explications']),
            'indices'      => count($data['indices']),
            'mdps'         => count($data['mdps']),
        ];
        $data['stats']['total'] = array_sum($data['stats']);

        return view('admin/salle_2', $data);
    }

    /**
     * Création/Mise à jour générique d’un élément (explication/indice/mdp).
     * Valide:
     * - Session admin
     * - Type autorisé
     * - Bornes max sur le numéro (explication<=100, indice<=300)
     * - Unicité du numéro dans sa table (doublon refusé)
     * Puis délègue la persistance au modèle.
     */
    public function saveGeneric()
    {
        // Accès réservé aux administrateurs
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        $model = new Salle2Admin();

        // Lecture et normalisation des champs du formulaire
        $ancienNumero  = trim((string) $this->request->getPost('id'));           // Numéro existant (si modification)
        $type          = trim((string) $this->request->getPost('type_element')); // explication | indice | mdp
        $nouveauNumero = (int) $this->request->getPost('numero');                // Numéro cible
        $description   = trim((string) $this->request->getPost('description'));
        $valeur        = trim((string) $this->request->getPost('valeur'));

        // Type strictement contrôlé
        $allowedTypes = ['explication', 'indice', 'mdp'];
        if (!in_array($type, $allowedTypes, true)) {
            return redirect()->back()->with('error', 'Type d\'élément invalide.');
        }

        // Règles de bornes: explication <= 100, indice <= 300
        if ($type === 'explication' && $nouveauNumero > 100) {
            return view('admin/salle_2/ErreurAdminSalle2.php', [
                'message' => "Erreur de validation",
                'details' => "Pour une 'Explication', le numéro ne doit pas dépasser 100. (Reçu : $nouveauNumero)"
            ]);
        }
        if ($type === 'indice' && $nouveauNumero > 300) {
            return view('admin/salle_2/ErreurAdminSalle2.php', [
                'message' => "Erreur de validation",
                'details' => "Pour un 'Indice', le numéro ne doit pas dépasser 300. (Reçu : $nouveauNumero)"
            ]);
        }

        // Résolution de la table SQL cible en fonction du type
        $table = '';
        if ($type === 'explication') $table = 'explication';
        elseif ($type === 'indice') $table = 'indice';
        elseif ($type === 'mdp') $table = 'mot_de_passe';

        // Vérification d’un éventuel doublon de numéro dans la table cible
        $db = \Config\Database::connect();
        $exists = $db->table($table)->where('numero', $nouveauNumero)->countAllResults();

        $isDuplicate = false;
        if (empty($ancienNumero)) {
            // Ajout: le numéro ne doit pas déjà exister
            if ($exists > 0) {
                $isDuplicate = true;
            }
        } else {
            // Modification: un autre enregistrement ne doit pas occuper ce numéro
            if ($exists > 0 && $nouveauNumero != $ancienNumero) {
                $isDuplicate = true;
            }
        }

        if ($isDuplicate) {
            return view('admin/salle_2/ErreurAdminSalle2.php', [
                'message' => "Identifiant dupliqué",
                'details' => "Le numéro $nouveauNumero est déjà utilisé dans la table '$type'. Veuillez en choisir un autre."
            ]);
        }

        // Données prêtes pour la persistance via le modèle
        $dataToSave = [
            'numero'      => $nouveauNumero,
            'description' => $description,
            'valeur'      => $valeur,
        ];

        // Délégation au modèle: création ou mise à jour en fonction de $ancienNumero
        $ok = $model->saveElement($type, $dataToSave, $ancienNumero ?: null);

        // Redirections avec feedback vers l’ancre de la section concernée
        if (!$ok) {
            return redirect()->to(base_url('gingembre/salle/2') . '#section-' . $type)
                ->with('error', 'Échec de l\'enregistrement.');
        }

        return redirect()->to(base_url('gingembre/salle/2') . '#section-' . $type)
            ->with('success', 'Enregistré avec succès.');
    }

    /**
     * Suppression d’un élément par type et numéro.
     * Valide la session admin et le type, puis délègue la suppression au modèle.
     */
    public function deleteElement($type, $numero) : RedirectResponse
    {
        if (session()->get('admin_id') == null) {
            return redirect()->to('/gingembre');
        }

        // Type strictement contrôlé
        $allowedTypes = ['explication', 'indice', 'mdp'];
        if (!in_array($type, $allowedTypes, true)) {
            return redirect()->back()->with('error', 'Type d\'élément invalide.');
        }

        $model = new Salle2Admin();
        $ok = $model->deleteElement($type, (int) $numero);

        $redirectUrl = base_url('gingembre/salle/2') . '#section-' . $type;

        if (!$ok) {
            return redirect()->to($redirectUrl)->with('error', 'Échec de la suppression.');
        }

        return redirect()->to($redirectUrl)->with('success', 'Supprimé avec succès.');
    }
}