<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes communes
$routes->get('/MentionLegale', 'commun\CommunController::MentionLegale');

// Route pour la page d'accueil
$routes->get('/', 'accueil\AccueilController::index');

// Routes pour la salle 1
$routes->get('/Salle1', 'accueil\AccueilController::Salle1');

// Routes pour la salle 2
$routes->get('/Salle2', 'accueil\AccueilController::Salle2');

// Routes pour la salle 3
$routes->get('/Salle3', 'accueil\AccueilController::Salle3');

// Routes pour la salle 4
$routes->get('/Salle4', 'accueil\AccueilController::Salle4');
$routes->get('/pageFrise', 'salle_4\Salle4Controller::pageFrise');
$routes->get('/quizFin', 'salle_4\Salle4Controller::quizFinal');
$routes->get('/Salle4', 'salle_4\Salle4Controller::index');


// Routes pour la salle 5
$routes->get('/enigmeRetour', 'accueil\AccueilController::Salle5');
$routes->get('/Salle5', 'accueil\AccueilController::Salle5');
$routes->get('/enigme/(:num)', 'salle_5\Salle5Controller::enigme/$1');
$routes->post('/validerEnigme', 'salle_5\Salle5Controller::validerEnigme');
$routes->get('/resetSalle5', 'salle_5\Salle5Controller::resetSalle');
$routes->get('/finSalle5', 'salle_5\Salle5Controller::finSalle');

// Routes pour la salle 6
$routes->get('/Salle6', 'salle_6\Salle6Controller::Index');
$routes->get('/Salle6/Wifi', 'salle_6\WifiController::Index');
$routes->get('/Salle6/VPN', 'salle_6\Salle6Controller::Vpn');
$routes->get('/Salle6/wifi', 'salle_6\WifiController::index');
$routes->post('/wifi/validerCarte', 'salle_6\WifiController::validerCarte');
$routes->get('/Salle6/wifi/resultat', 'salle_6\WifiController::Resultat');
$routes->get('/Salle6/VPN/pleinEcran', 'salle_6\Salle6Controller::Vpn');



