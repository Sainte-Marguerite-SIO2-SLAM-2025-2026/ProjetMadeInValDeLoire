<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes communes
$routes->get('/MentionLegale', 'commun\CommunController::MentionLegale');

// Route pour la page d'accueil
$routes->get('/', 'HomeControlleur::index');
$routes->get('/manoirJour', 'HomeControlleur::pagejour');

$routes->get('/reset', 'HomeControlleur::reset');
$routes->get('/resetSalleJour', 'HomeControlleur::resetSalleJour');
$routes->get('/salle/salle_(:num)', 'HomeControlleur::salle/$1');
$routes->match(['GET','POST'],'/valider/(:num)', 'HomeControlleur::valider/$1');                //tempo a voir avec la prof
$routes->match(['GET','POST'],'/validerJour/(:num)', 'HomeControlleur::validerJour/$1');        //tempo a voir avec la prof
$routes->match(['GET','POST'],'/echouerJour/(:num)', 'HomeControlleur::echouerJour/$1');        //tempo a voir avec la prof

// Routes pour la salle 1
$routes->get('/Salle1', 'accueil\AccueilController::Salle1');
$routes->get('Salle1/accesMessage', 'salle_1\Salle1Controller::accesMessage');
$routes->get('Salle1/Code', 'salle_1\Salle1Controller::accesCode');

// Routes pour la salle 2
$routes->get('/Salle2', 'accueil\AccueilController::Salle2');
$routes->get('/Salle2/Enigme', 'salle_2\Salle2Controller::index');
$routes->get('/indice/(:num)', 'salle_2\Salle2Controller::getIndice/$1');

// Routes pour la salle 3
$routes->get('/Salle3', 'accueil\AccueilController::Salle3');

// Routes pour la salle 4
$routes->get('/Salle4', 'accueil\AccueilController::Salle4');
$routes->get('/pageFrise', 'salle_4\Salle4Controller::pageFrise');
$routes->post('/verifierOrdre', 'salle_4\Salle4Controller::verifierOrdre');
$routes->get('/quizFin', 'salle_4\Salle4Controller::quizFinal');
$routes->post('/verifierReponseQuiz', 'salle_4\Salle4Controller::verifierReponseQuiz');
$routes->get('/resetQuiz', 'accueil\AccueilController::index');
$routes->get('/resetSalle4', 'salle_4\Salle4Controller::resetSalle');


// Routes pour la salle 5
$routes->get('/enigmeRetour', 'accueil\AccueilController::Salle5');
$routes->get('/Salle5', 'accueil\AccueilController::Salle5');
$routes->get('/enigme/(:num)', 'salle_5\Salle5Controller::enigme/$1');
$routes->post('/validerEnigme', 'salle_5\Salle5Controller::validerEnigme');
$routes->get('/resetSalle5', 'salle_5\Salle5Controller::resetSalle');
$routes->get('/finSalle5', 'salle_5\Salle5Controller::finSalle');

// Routes pour la salle 6
$routes->get('/Salle6', 'salle_6\Salle6Controller::Index');
$routes->get('/Salle6/Enigme', 'salle_6\Salle6Controller::Enigme');
$routes->get('/Salle6/Explication', 'salle_6\Salle6Controller::Explication');
$routes->get('/Salle6/Quitter', 'salle_6\Salle6Controller::QuitterSalle');
$routes->get('/Salle6/RevenirAccueil', 'salle_6\Salle6Controller::QuitterSalleBtnAccueil');
// Routes WiFi
$routes->get('/Salle6/Wifi', 'salle_6\WifiController::index');
$routes->post('/wifi/validerCarte', 'salle_6\WifiController::validerCarte');
$routes->post('/Salle6/wifi/resultat', 'salle_6\WifiController::Resultat');
$routes->post('Salle6/CompleteWifi', 'salle_6\Salle6Controller::CompleteWifi');
// Routes VPN
$routes->get('/Salle6/VPN', 'salle_6\VpnController::Index');
$routes->post('/vpn/validerCarte', 'salle_6\VpnController::validerCarte');
$routes->get('/Salle6/vpn/debug', 'salle_6\VpnController::debug');
$routes->post('/Salle6/CompleteVpn', 'salle_6\Salle6Controller::CompleteVpn');





