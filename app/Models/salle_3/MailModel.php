<?php
namespace App\Models\salle_3;

use CodeIgniter\Model;

class MailModel extends Model
{
    protected $table = 'mail';
    protected $DBGroup = 'admin';
    protected $primaryKey = 'numero';
    protected $allowedFields = ['expediteur', 'objet', 'contenu', 'difficulte', 'phishing'];
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'expediteur' => 'required|max_length[50]',
        'objet'      => 'required|max_length[100]',
        'contenu'    => 'required',
        'difficulte' => 'permit_empty|integer',
        'phishing'   => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'expediteur' => [
            'required' => 'L\'expéditeur est obligatoire',
        ],
        'objet' => [
            'required' => 'L\'objet est obligatoire',
        ],
        'phishing' => [
            'in_list' => 'Le type doit être 0 (légitime) ou 1 (frauduleux)',
        ],
    ];
}