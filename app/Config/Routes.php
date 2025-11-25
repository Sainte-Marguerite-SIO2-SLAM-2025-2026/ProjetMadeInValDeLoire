<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes communes
$routes->get('/MentionLegale', 'commun/CommunController::MentionLegale');

// Route pour la page d'accueil
$routes->get('/', 'HomeControlleur::index');
$routes->get('/manoirJour', 'HomeControlleur::pagejour');

$routes->match(['GET','POST'],'/reset', 'HomeControlleur::reset');
$routes->get('/resetSalleJour', 'HomeControlleur::resetSalleJour');
$routes->get('/salle/salle_(:num)', 'HomeControlleur::salle/$1');
$routes->match(['GET','POST'],'/valider/(:num)', 'HomeControlleur::valider/$1');
$routes->match(['GET','POST'],'/validerJour/(:num)', 'HomeControlleur::validerJour/$1');
$routes->match(['GET','POST'],'/echouerJour/(:num)', 'HomeControlleur::echouerJour/$1');

// Routes pour le quiz
$routes->group('quiz', function($routes) {
    $routes->get('/', 'QuizControlleur::index');
    $routes->match(['get', 'post'],'demarrer/(:segment)', 'QuizControlleur::choix/$1');
    $routes->get('choix/(:segment)', 'QuizControlleur::demarrer/$1');
    $routes->get('question/(:segment)', 'QuizControlleur::question/$1');
    $routes->post('repondre/(:segment)', 'QuizControlleur::repondre/$1');
    $routes->get('resultats/(:segment)', 'QuizControlleur::resultats/$1');

});

// Routes pour la salle 1
$routes->get('/Salle1', 'accueil/AccueilController::Salle1');
$routes->get('Salle1/accesMessage', 'salle_1/Salle1Controller::accesMessage');
$routes->get('Salle1/Code', 'salle_1/Salle1Controller::accesCode');


// Routes pour la salle 2
$routes->get('/Salle2', 'accueil/AccueilController::Salle2');
$routes->get('/Salle2-introduction', 'salle_2/Salle2Controller::Introduction');
$routes->get('/Salle2-Aide', 'salle_2/Salle2Controller::Aide');
$routes->get('/Etape1', 'salle_2/Salle2Controller::Etape1');
$routes->get('/Etape1a', 'salle_2/Salle2Controller::Etape1a');
$routes->post('Etape1a', 'salle_2/Salle2Controller::validerEtape1a');
$routes->match(['get', 'post'], '/Etape1b', 'salle_2/Salle2Controller::Etape1b');
$routes->get('/Etape2', 'salle_2/Salle2Controller::Etape2');
$routes->match(['get', 'post'], '/Etape2', 'salle_2/Salle2Controller::Etape2');
$routes->get('/Etape2a', 'salle_2/Salle2Controller::Etape2a');
$routes->match(['get', 'post'], '/etape2a', 'salle_2/Salle2Controller::Etape2a');
$routes->get('/Etape3', 'salle_2/Salle2Controller::Etape3');
$routes->match(['get', 'post'], '/Etape3', 'salle_2/Salle2Controller::Etape3');
$routes->get('Etape4', 'salle_2/Salle2Controller::Etape4');
$routes->post('Etape4', 'salle_2/Salle2Controller::validerEtape4');
$routes->get('Etape4/password-random', 'salle_2/Salle2Controller::passwordRandom');
$routes->get('/Etape5', 'salle_2/Salle2Controller::Etape5');
$routes->get('/Etapef', 'salle_2/Salle2Controller::Etapef');

// Routes pour la salle 3
$routes->get('/Salle3', 'accueil/AccueilController::Salle3');
$routes->get('/Salle3/Enigme', 'salle_3/Salle3Controller::index');

// Routes pour la salle 4
$routes->get('/Salle4', 'salle_4/Salle4Controller::index');
$routes->get('/pageFrise', 'salle_4/Salle4Controller::pageFrise');
$routes->post('/verifierOrdre', 'salle_4/Salle4Controller::verifierOrdre');
$routes->get('/quizFin', 'salle_4/Salle4Controller::quizFinal');
$routes->post('/verifierReponseQuiz', 'salle_4/Salle4Controller::verifierReponseQuiz');
$routes->get('/resetQuiz', 'accueil/AccueilController::index');
$routes->get('/resetSalle4', 'salle_4/Salle4Controller::resetSalle');


// Routes pour la salle 5
//$routes->get('/enigmeRetour', 'accueil/AccueilController::Salle5');
//$routes->get('/Salle5', 'accueil/AccueilController::Salle5');
$routes->get('/enigme/(:num)', 'salle_5/Salle5Controller::enigme/$1');
$routes->post('/validerEnigme', 'salle_5/Salle5Controller::validerEnigme');
$routes->get('/resetSalle5', 'salle_5/Salle5Controller::resetSalle');
$routes->get('/finSalle5', 'salle_5/Salle5Controller::finSalle');

// Routes pour la salle 6
$routes->get('/Salle6', 'salle_6/Salle6Controller::Index');
$routes->get('/Salle6/Enigme', 'salle_6/Salle6Controller::Enigme');
$routes->get('/Salle6/Explication', 'salle_6/Salle6Controller::Explication');
$routes->get('/Salle6/Quitter', 'salle_6/Salle6Controller::QuitterSalle');
$routes->get('/Salle6/RevenirAccueil', 'salle_6/Salle6Controller::QuitterSalleBtnAccueil');
// Routes WiFi
$routes->get('/Salle6/Wifi', 'salle_6/WifiController::index');
$routes->post('/wifi/validerCarte', 'salle_6/WifiController::validerCarte');
$routes->post('/Salle6/wifi/resultat', 'salle_6/WifiController::Resultat');
$routes->post('Salle6/CompleteWifi', 'salle_6/Salle6Controller::CompleteWifi');
// Routes VPN
$routes->get('/Salle6/VPN', 'salle_6/VpnController::Index');
$routes->post('/vpn/validerCarte', 'salle_6/VpnController::validerCarte');
$routes->get('/Salle6/vpn/debug', 'salle_6/VpnController::debug');
$routes->post('/Salle6/CompleteVpn', 'salle_6/Salle6Controller::CompleteVpn');





