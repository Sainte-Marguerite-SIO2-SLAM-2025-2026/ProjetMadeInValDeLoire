<?php

namespace App\Controllers\admin\salle_1;

use App\Controllers\BaseController;
use App\Models\admin\salle_1\AdminSalle1ErreurModel;

class AdminSalle1Controller extends BaseController
{
    protected $activiteModel;
    protected $erreurModel;

    public function __construct()
    {
        $this->activiteModel = new AdminSalle1ActiviteModel();
        $this->erreurModel = new AdminSalle1ErreurModel();

        // Vérifier si l'utilisateur est admin (ajoutez votre logique d'authentification)
        // if (!session()->get('is_admin')) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException();
        // }
    }

    /**
     * Page principale d'administration
     */
    public function index()
    {
        $data = [
            'title' => 'Administration Salle 1',
            'activites' => $this->activiteModel->getAllActivites(),
            'total_activites' => $this->activiteModel->countActivites(),
            'total_erreurs' => $this->erreurModel->countErreurs(),
        ];

        return view('admin/salle_1/AccueilAdminSalle1', $data);
    }

    // ==================== ACTIVITÉS ====================

    /**
     * Récupérer toutes les activités (AJAX)
     */
    public function getActivites()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $activites = $this->activiteModel->getAllActivites();

            return $this->response->setJSON([
                'success' => true,
                'data' => $activites
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getActivites: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la récupération des activités'
            ])->setStatusCode(500);
        }
    }

    /**
     * Récupérer une activité spécifique
     */
    public function getActivite($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID manquant'
            ])->setStatusCode(400);
        }

        try {
            $activite = $this->activiteModel->getActivite($id);

            if (!$activite) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Activité non trouvée'
                ])->setStatusCode(404);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $activite
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur serveur'
            ])->setStatusCode(500);
        }
    }

    /**
     * Ajouter une activité
     */
    public function addActivite()
    {
        // Règles de validation
        $rules = [
            'libelle' => [
                'rules' => 'required|min_length[3]|max_length[1000]',
                'errors' => [
                    'required' => 'Le libellé est obligatoire',
                    'min_length' => 'Le libellé doit contenir au moins 3 caractères',
                    'max_length' => 'Le libellé ne peut pas dépasser 1000 caractères'
                ]
            ],
            'difficulte_numero' => [
                'rules' => 'required|integer|in_list[1,2,3]',
                'errors' => [
                    'required' => 'La difficulté est obligatoire',
                    'integer' => 'La difficulté doit être un nombre',
                    'in_list' => 'La difficulté doit être 1, 2 ou 3'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        try {
            $data = [
                'libelle' => trim($this->request->getPost('libelle')),
                'difficulte_numero' => (int)$this->request->getPost('difficulte_numero')
            ];

            $id = $this->activiteModel->addActivite($data);

            if ($id) {
                log_message('info', "Activité ajoutée avec succès (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Activité ajoutée avec succès',
                    'id' => $id,
                    'data' => $this->activiteModel->getActivite($id)
                ]);
            } else {
                throw new \Exception('Échec de l\'insertion');
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur addActivite: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Modifier une activité
     */
    public function updateActivite($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID manquant'
            ])->setStatusCode(400);
        }

        // Vérifier si l'activité existe
        if (!$this->activiteModel->getActivite($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Activité non trouvée'
            ])->setStatusCode(404);
        }

        $rules = [
            'libelle' => 'required|min_length[3]|max_length[1000]',
            'difficulte_numero' => 'required|integer|in_list[1,2,3]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        try {
            $data = [
                'libelle' => trim($this->request->getPost('libelle')),
                'difficulte_numero' => (int)$this->request->getPost('difficulte_numero')
            ];

            $result = $this->activiteModel->updateActivite($id, $data);

            if ($result) {
                log_message('info', "Activité modifiée (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Activité modifiée avec succès',
                    'data' => $this->activiteModel->getActivite($id)
                ]);
            } else {
                throw new \Exception('Échec de la modification');
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur updateActivite: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Supprimer une activité
     */
    public function deleteActivite($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID manquant'
            ])->setStatusCode(400);
        }

        try {
            // Vérifier si l'activité existe
            $activite = $this->activiteModel->getActivite($id);
            if (!$activite) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Activité non trouvée'
                ])->setStatusCode(404);
            }

            // Supprimer l'activité (les erreurs et indices seront supprimés en cascade dans le modèle)
            $result = $this->activiteModel->deleteActivite($id);

            if ($result) {
                log_message('info', "Activité supprimée (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Activité supprimée avec succès'
                ]);
            } else {
                throw new \Exception('Échec de la suppression');
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur deleteActivite: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    // ==================== ERREURS ====================

    /**
     * Récupérer toutes les erreurs ou les erreurs d'une activité
     */
    public function getErreurs()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $activiteId = $this->request->getGet('activite_id');

            if ($activiteId) {
                $erreurs = $this->erreurModel->getErreursByActivite($activiteId);
            } else {
                $erreurs = $this->erreurModel->getAllErreurs();
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $erreurs
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getErreurs: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la récupération des erreurs'
            ])->setStatusCode(500);
        }
    }

    /**
     * Ajouter une erreur
     */
    public function addErreur()
    {
        $rules = [
            'activite_numero' => [
                'rules' => 'required|integer|is_not_unique[activites_salle1.activite_numero]',
                'errors' => [
                    'required' => 'L\'activité est obligatoire',
                    'integer' => 'L\'activité doit être un nombre',
                    'is_not_unique' => 'L\'activité sélectionnée n\'existe pas'
                ]
            ],
            'mot_incorrect' => [
                'rules' => 'required|min_length[1]|max_length[255]',
                'errors' => [
                    'required' => 'Le mot incorrect est obligatoire',
                    'min_length' => 'Le mot incorrect doit contenir au moins 1 caractère',
                    'max_length' => 'Le mot incorrect ne peut pas dépasser 255 caractères'
                ]
            ],
            'explication' => [
                'rules' => 'required|min_length[3]|max_length[1000]',
                'errors' => [
                    'required' => 'L\'explication est obligatoire',
                    'min_length' => 'L\'explication doit contenir au moins 3 caractères',
                    'max_length' => 'L\'explication ne peut pas dépasser 1000 caractères'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        try {
            $data = [
                'activite_numero' => (int)$this->request->getPost('activite_numero'),
                'mot_incorrect' => trim($this->request->getPost('mot_incorrect')),
                'explication' => trim($this->request->getPost('explication'))
            ];

            $id = $this->erreurModel->addErreur($data);

            if ($id) {
                log_message('info', "Erreur ajoutée (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Erreur ajoutée avec succès',
                    'id' => $id
                ]);
            } else {
                throw new \Exception('Échec de l\'insertion');
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur addErreur: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Modifier une erreur
     */
    public function updateErreur($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID manquant'
            ])->setStatusCode(400);
        }

        $rules = [
            'activite_numero' => 'required|integer|is_not_unique[activites_salle1.activite_numero]',
            'mot_incorrect' => 'required|min_length[1]|max_length[255]',
            'explication' => 'required|min_length[3]|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        try {
            $data = [
                'activite_numero' => (int)$this->request->getPost('activite_numero'),
                'mot_incorrect' => trim($this->request->getPost('mot_incorrect')),
                'explication' => trim($this->request->getPost('explication'))
            ];

            $result = $this->erreurModel->updateErreur($id, $data);

            if ($result) {
                log_message('info', "Erreur modifiée (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Erreur modifiée avec succès'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur non trouvée'
                ])->setStatusCode(404);
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur updateErreur: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Supprimer une erreur
     */
    public function deleteErreur($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID manquant'
            ])->setStatusCode(400);
        }

        try {
            $result = $this->erreurModel->deleteErreur($id);

            if ($result) {
                log_message('info', "Erreur supprimée (ID: {$id})");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Erreur supprimée avec succès'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erreur non trouvée'
                ])->setStatusCode(404);
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur deleteErreur: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    // ==================== STATISTIQUES ====================

    /**
     * Récupérer les statistiques complètes
     */
    public function getStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            $activites = $this->activiteModel->getAllActivites();

            // Enrichir chaque activité avec ses statistiques
            foreach ($activites as &$activite) {
                $activite['nb_erreurs'] = count($this->erreurModel->getErreursByActivite($activite['activite_numero']));
                $activite['nb_indices'] = count($this->indiceModel->getIndicesByActivite($activite['activite_numero']));
            }

            $stats = [
                'total_activites' => $this->activiteModel->countActivites(),
                'total_erreurs' => $this->erreurModel->countErreurs(),
                'total_indices' => $this->indiceModel->countIndices(),
                'activites' => $activites
            ];

            return $this->response->setJSON([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getStats: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques'
            ])->setStatusCode(500);
        }
    }
}