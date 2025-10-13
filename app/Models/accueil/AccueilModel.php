<?php
namespace App\Models\accueil;

use CodeIgniter\Model;
class AccueilModel extends Model
{
    protected array $mails;
    public function getMail()
    {
        $mails = [
            [
                'id' => 1,
                'expediteur' => 'microhard@gmail.com',
                'objet' => 'Mise à jour de votre compte',
                'contenu1' => 'De nouvelles informations obligatoires doivent être mises à jour sur votre compte.',
                'contenu2' => 'Veuillez-vous rendre sur votre espace compte utilisateur en cliquant sur ce lien : http://microhard.fr/account/',
                'type' => 'phishing'
            ],
            [
                'id' => 2,
                'expediteur' => 'matheo.legrand@gmail.com',
                'objet' => 'Mise à jour de vos coordonnées bancaires',
                'contenu1' => 'On vous demande de mettre à jour vos informations pour payer le plus vite possible svp',
                'contenu2' => 'Cliquez sur ce lien le plus vite possible : http://malveillancemax.fr/',
                'type' => 'phishing'
            ],
            [
                'id' => 3,
                'expediteur' => 'phishing@gmail.com',
                'objet' => 'Mot passe',
                'contenu1' => 'votre mot passe va expirer bientot',
                'contenu2' => 'renouveler le en cliquant sur le lien la : http://comptefake.com/compte/motpasse/',
                'type' => 'phishing'
            ],
            [
                'id' => 4,
                'expediteur' => 'contact@microsoft.com',
                'objet' => 'Nouveautés',
                'contenu1' => 'De nouveaux logiciels sont disponibles pour dynamiser vos ressources !',
                'contenu2' => 'Vous pouvez consulter ces nouveaux produits ici : https://microsoft.com/products/',
                'type' => 'légitime'
            ],
            [
                'id' => 5,
                'expediteur' => 'contact@mcdonalds.fr',
                'objet' => 'Votre programme de fidélité évolue !',
                'contenu1' => 'Nous vous informons que votre programme de fidélité a été mis à jour !',
                'contenu2' => "Plus d'information sur votre nouveau programme ici : https://mcdonalds.fr/fidelite/",
                'type' => 'légitime'
            ],
            [
                'id' => 6,
                'expediteur' => 'no-reply@accounts.google.com',
                'objet' => 'Alerte de sécurité',
                'contenu1' => 'Nous avons détecté une nouvelle connexion à votre compte Google depuis un Windows.',
                'contenu2' => "Consultez l'activité liée à la sécurité de votre compte ici : https://myaccount.google.com/notifications",
                'type' => 'légitime'
            ]
        ];
        shuffle($mails);
        return $mails;
    }

}