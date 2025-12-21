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
$routes->group('/gingembre/salle_6', ['namespace' => 'App\Controllers\admin\salle_6'], function ($routes) {

    // Accueil Admin Salle 6 (Dashboard)
    $routes->get('accueil', 'AdminSalle6Controller::index');

    // Gestion VPN
    $routes->group('vpn', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::vpnList');
        $routes->get('create', 'AdminSalle6Controller::vpnCreate');
        $routes->post('store', 'AdminSalle6Controller::vpnStore');
        $routes->get('edit/(:num)', 'AdminSalle6Controller::vpnEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle6Controller::vpnUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle6Controller::vpnDelete/$1');
    });

    // Gestion WiFi
    $routes->group('wifi', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::wifiList');
        $routes->get('create', 'AdminSalle6Controller::wifiCreate');
        $routes->post('store', 'AdminSalle6Controller::wifiStore');
        $routes->get('edit/(:num)', 'AdminSalle6Controller::wifiEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle6Controller::wifiUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle6Controller::wifiDelete/$1');
    });

    // Gestion Propositions VPN
    $routes->group('proposer-vpn', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::proposerVpnList');
        $routes->get('create', 'AdminSalle6Controller::proposerVpnCreate');
        $routes->post('store', 'AdminSalle6Controller::proposerVpnStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle6Controller::proposerVpnDelete/$1/$2');
    });

    // Gestion Propositions WiFi
    $routes->group('proposer-wifi', function ($routes) {
        $routes->get('/', 'AdminSalle6Controller::proposerWifiList');
        $routes->get('create', 'AdminSalle6Controller::proposerWifiCreate');
        $routes->post('store', 'AdminSalle6Controller::proposerWifiStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle6Controller::proposerWifiDelete/$1/$2');
    });

    // Gestion Activité
    $routes->group('activite', function ($routes) {
        $routes->get('/', 'ActiviteController::index');
        $routes->get('create', 'ActiviteController::create');
        $routes->post('store', 'ActiviteController::store');
        $routes->get('edit/(:num)', 'ActiviteController::edit/$1');
        $routes->post('update/(:num)', 'ActiviteController::update/$1');
        $routes->get('delete/(:num)', 'ActiviteController::delete/$1');
    });

    // Gestion Type
    $routes->group('type', function ($routes) {
        $routes->get('/', 'TypeController::index');
        $routes->get('create', 'TypeController::create');
        $routes->post('store', 'TypeController::store');
        $routes->get('edit/(:num)', 'TypeController::edit/$1');
        $routes->post('update/(:num)', 'TypeController::update/$1');
        $routes->get('delete/(:num)', 'TypeController::delete/$1');
    });

    // Gestion Salle
    $routes->group('salle', function ($routes) {
        $routes->get('/', 'SalleController::index');
        $routes->get('create', 'SalleController::create');
        $routes->post('store', 'SalleController::store');
        $routes->get('edit/(:num)', 'SalleController::edit/$1');
        $routes->post('update/(:num)', 'SalleController::update/$1');
        $routes->get('delete/(:num)', 'SalleController::delete/$1');
    });

    // Gestion Indice
    $routes->group('indice', function ($routes) {
        $routes->get('/', 'IndiceController::index');
        $routes->get('create', 'IndiceController::create');
        $routes->post('store', 'IndiceController::store');
        $routes->get('edit/(:num)', 'IndiceController::edit/$1');
        $routes->post('update/(:num)', 'IndiceController::update/$1');
        $routes->get('delete/(:num)', 'IndiceController::delete/$1');
    });

    // Gestion Explication
    $routes->group('explication', function ($routes) {
        $routes->get('/', 'ExplicationController::index');
        $routes->get('create', 'ExplicationController::create');
        $routes->post('store', 'ExplicationController::store');
        $routes->get('edit/(:num)', 'ExplicationController::edit/$1');
        $routes->post('update/(:num)', 'ExplicationController::update/$1');
        $routes->get('delete/(:num)', 'ExplicationController::delete/$1');
    });

    // Gestion Avoir Indice
    $routes->group('avoir-indice', function ($routes) {
        $routes->get('/', 'AvoirIndiceController::index');
        $routes->get('create', 'AvoirIndiceController::create');
        $routes->post('store', 'AvoirIndiceController::store');
        $routes->get('edit/(:num)', 'AvoirIndiceController::edit/$1');
        $routes->post('update/(:num)', 'AvoirIndiceController::update/$1');
        $routes->get('delete/(:num)', 'AvoirIndiceController::delete/$1');
    });

    // Gestion Activité Message
    $routes->group('activite-message', function ($routes) {
        $routes->get('/', 'ActiviteMessageController::index');
        $routes->get('create', 'ActiviteMessageController::create');
        $routes->post('store', 'ActiviteMessageController::store');
        $routes->get('edit/(:num)', 'ActiviteMessageController::edit/$1');
        $routes->post('update/(:num)', 'ActiviteMessageController::update/$1');
        $routes->get('delete/(:num)', 'ActiviteMessageController::delete/$1');
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

// Admin Salle 2
$routes->get('gingembre/deleteElement/(:segment)/(:num)', 'salle_2\Salle2AdminController::deleteElement/$1/$2');
$routes->post('gingembre/saveGeneric', 'salle_2\Salle2AdminController::saveGeneric');
$routes->get('gingembre/salle/(:num)', 'admin\AdminController::salle/$1');
$routes->match(['get','post'], 'gingembre/saveGeneric', 'salle_2\Salle2AdminController::saveGeneric');

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


$routes->group('Salle2', function($routes) {
    $routes->get('/', 'accueil\AccueilController::Salle2');
    $routes->get('Introduction', 'salle_2\Salle2Controller::Introduction');
    $routes->get('Aide', 'salle_2\Salle2Controller::Aide');
    $routes->get('Etape1', 'salle_2\Salle2Controller::Etape1');
    $routes->get('Etape1a', 'salle_2\Salle2Controller::Etape1a');
    $routes->post('Etape1a', 'salle_2\Salle2Controller::validerEtape1a');
    $routes->match(['get', 'post'], 'Etape2', 'salle_2\Salle2Controller::Etape2');
    $routes->match(['get', 'post'], 'Etape2a', 'salle_2\Salle2Controller::Etape2a');
    $routes->match(['get', 'post'], 'Etape3', 'salle_2\Salle2Controller::Etape3');
    $routes->get('Etape4', 'salle_2\Salle2Controller::Etape4');
    $routes->post('Etape4', 'salle_2\Salle2Controller::validerEtape4');
    $routes->get('Etape4/password-random', 'salle_2\Salle2Controller::passwordRandom');
    $routes->match(['get', 'post'], 'Etape5', 'salle_2\Salle2Controller::Etape5');
    $routes->get('Etapef', 'salle_2\Salle2Controller::Etapef');
    $routes->get('Etapeb', 'salle_2\Salle2Controller::Etapeb');
});


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
$routes->post('verifierCarte402', 'salle_4\Salle4Controller::verifierCarte402');
$routes->get('resetActivite402', 'salle_4\Salle4Controller::resetActivite402');


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
