<?php

namespace App\Controllers\admin\salle_1;

use App\Controllers\BaseController;
use App\Models\admin\salle_1\Salle1Admin;
use CodeIgniter\HTTP\RedirectResponse;

class Salle1AdminController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | PAGE ADMIN
    |--------------------------------------------------------------------------
    */

    public function salle_1(): string|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | SECURITE ADMIN
        |--------------------------------------------------------------------------
        */

        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }

        /*
        |--------------------------------------------------------------------------
        | MODEL
        |--------------------------------------------------------------------------
        */

        $adminModel = new Salle1Admin();

        /*
        |--------------------------------------------------------------------------
        | RECUPERATION DES DONNEES
        |--------------------------------------------------------------------------
        */

        $activites = $adminModel
            ->getTousMessageSalle1();

        $erreurs = $adminModel
            ->getTousErreursAvecExplications(1);

        $auteurs = $adminModel
            ->getTousLesAuteurs();

        /*
        |--------------------------------------------------------------------------
        | DATA ENVOYEES A LA VUE
        |--------------------------------------------------------------------------
        */

        $data = [

            'activites' => $activites,

            'erreurs' => $erreurs,

            'auteurs' => $auteurs

        ];

        /*
        |--------------------------------------------------------------------------
        | DEBUG
        |--------------------------------------------------------------------------
        | Décommente pour vérifier les données
        |--------------------------------------------------------------------------
        */

        //dd($data);

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin/salle_1/AccueilAdminSalle1',
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AJOUT / MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function saveGeneric(): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | SECURITE
        |--------------------------------------------------------------------------
        */

        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }

        /*
        |--------------------------------------------------------------------------
        | DB
        |--------------------------------------------------------------------------
        */

        $db = \Config\Database::connect();

        $type = trim(
            (string)$this->request->getPost('type')
        );

        /*
        |--------------------------------------------------------------------------
        | ACTIVITE
        |--------------------------------------------------------------------------
        */

        if ($type === 'activite')
        {
            $numero = $this->request->getPost('numero');

            $data = [

                'libelle' => trim(
                    (string)$this->request->getPost('libelle')
                ),

                'salle_numero' => 1

            ];

            /*
            |--------------------------------------------------------------------------
            | UPDATE
            |--------------------------------------------------------------------------
            */

            if (!empty($numero))
            {
                $db->table('activite')

                    ->where('numero', $numero)

                    ->update($data);
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT
            |--------------------------------------------------------------------------
            */

            else
            {
                $db->table('activite')

                    ->insert($data);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ERREUR
        |--------------------------------------------------------------------------
        */

        elseif ($type === 'erreur')
        {
            $numero = $this->request->getPost('numero');

            $data = [

                'mot_incorrect' => trim(
                    (string)$this->request->getPost('mot_incorrect')
                ),

                'explication' => trim(
                    (string)$this->request->getPost('explication')
                )

            ];

            if (!empty($numero))
            {
                $db->table('erreur')

                    ->where('numero', $numero)

                    ->update($data);
            }
            else
            {
                $db->table('erreur')

                    ->insert($data);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | INDICE
        |--------------------------------------------------------------------------
        */

        elseif ($type === 'auteur')
        {
            $numero = $this->request->getPost('numero');

            $nom = trim((string) $this->request->getPost('nom'));
            $prenom = trim((string) $this->request->getPost('prenom'));
            $fonction = trim((string) $this->request->getPost('fonction'));

            if ($nom === '' || $prenom === '' || $fonction === '')
            {
                return redirect()->back()->with('error', 'Tous les champs sont obligatoires');
            }

            $data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'fonction_role' => $fonction
            ];

            $table = $db->table('auteur');

            if (!empty($numero))
            {
                $table->where('numero', $numero)
                    ->update($data);
            }
            else
            {
                $table->insert($data);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */

        return redirect()->to(
            base_url('gingembre/salle_1')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION
    |--------------------------------------------------------------------------
    */

    public function deleteElement(
        string $type,
        int $numero
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | SECURITE
        |--------------------------------------------------------------------------
        */

        if (session()->get('admin_id') == null)
        {
            return redirect()->to('/gingembre');
        }

        /*
        |--------------------------------------------------------------------------
        | DB
        |--------------------------------------------------------------------------
        */

        $db = \Config\Database::connect();

        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        switch ($type)
        {
            case 'activite':

                $db->table('activite')

                    ->where('numero', $numero)

                    ->delete();

                break;

            case 'erreur':

                $db->table('erreur')

                    ->where('numero', $numero)

                    ->delete();

                break;

            case 'indice':

                $db->table('indice')

                    ->where('numero', $numero)

                    ->delete();

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */

        return redirect()->to(
            base_url('gingembre/salle_1')
        );
    }
}