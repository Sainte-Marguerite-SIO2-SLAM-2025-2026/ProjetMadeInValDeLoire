<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes communes
$routes->get('/MentionLegale', 'commun\CommunController::MentionLegale');


/*
 * ROUTES POUR L'ADMINISTRATION SALLE 6
 */

// ========== ROUTES ADMINISTRATION SALLE 6 ==========

$routes->group('/gingembre/salle_6', ['namespace' => 'App\Controllers\admin\salle_6'], function ($routes) {

    // Dashboard Salle 6
    $routes->get('/accueil', 'AdminSalle6Controller::index');

    // === GESTION vpn ===
    $routes->group('vpn', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::vpnList');
        $routes->get('create', 'AdminSalle6Controller::vpnCreate');
        $routes->post('store', 'AdminSalle6Controller::vpnStore');
        $routes->get('edit/(:num)', 'AdminSalle6Controller::vpnEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle6Controller::vpnUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle6Controller::vpnDelete/$1');
    });

    // === GESTION WIFI ===
    $routes->group('wifi', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::wifiList');
        $routes->get('create', 'AdminSalle6Controller::wifiCreate');
        $routes->post('store', 'AdminSalle6Controller::wifiStore');
        $routes->get('edit/(:num)', 'AdminSalle6Controller::wifiEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle6Controller::wifiUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle6Controller::wifiDelete/$1');
    });

    // === GESTION PROPOSITIONS vpn ===
    $routes->group('proposer-vpn', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::proposerVpnList');
        $routes->get('create', 'AdminSalle6Controller::proposerVpnCreate');
        $routes->post('store', 'AdminSalle6Controller::proposerVpnStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnDelete/$1/$2');
    });

    // === GESTION PROPOSITIONS WIFI ===
    $routes->group('proposer-wifi', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::proposerWifiList');
        $routes->get('create', 'AdminSalle6Controller::proposerWifiCreate');
        $routes->post('store', 'AdminSalle6Controller::proposerWifiStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiDelete/$1/$2');
    });

});

// Routes admin
$routes->get('/gingembre', 'admin\AdminController::index');
$routes->post('/gingembre/loginCheck', 'admin\AdminController::login');
$routes->get('/gingembre/logout', 'admin\AdminController::logout');
$routes->get('/gingembre/accueil', 'admin\AdminController::accueil');
$routes->get('/gingembre/salle_(:num)', 'admin\AdminController::salle/$1');
$routes->get('/gingembre/create-user', 'admin\AdminController::createUser');
$routes->get('gingembre/quiz', 'admin\AdminController::quiz');
$routes->get('gingembre/mascotte', 'admin\AdminController::mascotte');

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
    $routes->get('/', 'Quiz\QuizControlleur::index');
    $routes->match(['get', 'post'],'demarrer/(:segment)', 'Quiz\QuizControlleur::choix/$1');
    $routes->get('choix/(:segment)', 'Quiz\QuizControlleur::demarrer/$1');
    $routes->get('question/(:segment)', 'Quiz\QuizControlleur::question/$1');
    $routes->post('repondre/(:segment)', 'Quiz\QuizControlleur::repondre/$1');
    $routes->get('resultats/(:segment)', 'Quiz\QuizControlleur::resultats/$1');

});

// Routes pour la salle 1
$routes->get('/Salle1', 'accueil\AccueilController::Salle1');
$routes->get('Salle1/accesMessage', 'salle_1\Salle1Controller::accesMessage');
$routes->get('Salle1/Code', 'salle_1\Salle1Controller::accesCode');
$routes->get('Salle1/Backend', 'salle_1\Salle1Controller::getBackend');


// Routes pour la salle 2
$routes->get('Salle2', 'accueil\AccueilController::Salle2');
$routes->get('Salle2/Introduction', 'salle_2\Salle2Controller::Introduction');
$routes->get('Salle2/Aide', 'salle_2\Salle2Controller::Aide');
$routes->get('Salle2/Etape1', 'salle_2\Salle2Controller::Etape1');
$routes->get('Salle2/Etape1a', 'salle_2\Salle2Controller::Etape1a');
$routes->post('Etape1a', 'salle_2\Salle2Controller::validerEtape1a');
$routes->get('Salle2/Etape2', 'salle_2\Salle2Controller::Etape2');
$routes->match(['get', 'post'], '/Salle2/Etape2', 'salle_2\Salle2Controller::Etape2');
$routes->get('Salle2/Etape2a', 'salle_2\Salle2Controller::Etape2a');
$routes->match(['get', 'post'], '/Salle2/etape2a', 'salle_2\Salle2Controller::Etape2a');
$routes->get('Salle2/Etape3', 'salle_2\Salle2Controller::Etape3');
$routes->match(['get', 'post'], '/Salle2/Etape3', 'salle_2\Salle2Controller::Etape3');
$routes->get('Salle2/Etape4', 'salle_2\Salle2Controller::Etape4');
$routes->post('Salle2/Etape4', 'salle_2\Salle2Controller::validerEtape4');
$routes->get('Salle2/Etape4/password-random', 'salle_2\Salle2Controller::passwordRandom');
$routes->get('Salle2/Etape5', 'salle_2\Salle2Controller::Etape5');
$routes->get('Salle2/Etapef', 'salle_2\Salle2Controller::Etapef');
$routes->get('Salle2/Etapeb', 'salle_2\Salle2Controller::Etapeb');


// Routes pour la salle 3
$routes->get('/Salle3', 'accueil\AccueilController::Salle3');
$routes->get('/Salle3/Enigme', 'salle_3\Salle3Controller::index');

// Routes pour la salle 4
$routes->get('/Salle4', 'salle_4\Salle4Controller::index');
$routes->get('/pageFrise', 'salle_4\Salle4Controller::pageFrise');
$routes->post('/verifierOrdre', 'salle_4\Salle4Controller::verifierOrdre');
$routes->get('/quizFin', 'salle_4\Salle4Controller::quizFinal');
$routes->post('/verifierReponseQuiz', 'salle_4\Salle4Controller::verifierReponseQuiz');
$routes->get('/resetQuiz', 'accueil\AccueilController::index');
$routes->get('/resetSalle4', 'salle_4\Salle4Controller::resetSalle');


// Routes pour la salle 5
$routes->get('/enigme/(:num)', 'salle_5\Salle5Controller::enigme/$1');
$routes->post('/validerEnigme', 'salle_5\Salle5Controller::validerEnigme');
$routes->get('/resetSalle5', 'salle_5\Salle5Controller::resetSalle');
$routes->get('/finSalle5', 'salle_5\Salle5Controller::finSalle');

// Routes admin pour la salle 5
$routes->post('/admin/supprimerEnigme/(:num)', 'admin\AdminController::supprimerEnigme/$1');
$routes->post('/admin/supprimerObjet/(:num)', 'admin\AdminController::supprimerObjet/$1');
$routes->post('/admin/supprimerObjetDeclencheur/(:num)', 'admin\AdminController::supprimerObjetDeclencheur/$1');



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
// Routes vpn
$routes->get('/Salle6/vpn', 'salle_6\VpnController::Index');
$routes->post('/vpn/validerCarte', 'salle_6\VpnController::validerCarte');
$routes->get('/Salle6/vpn/debug', 'salle_6\VpnController::debug');
$routes->post('/Salle6/CompleteVpn', 'salle_6\Salle6Controller::CompleteVpn');
