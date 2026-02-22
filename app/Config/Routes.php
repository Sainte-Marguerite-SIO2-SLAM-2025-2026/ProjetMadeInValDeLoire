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
        $routes->get('/', 'VpnController::index');
        $routes->get('create', 'VpnController::Create');
        $routes->post('store', 'VpnController::Store');
        $routes->get('edit/(:num)', 'VpnController::Edit/$1');
        $routes->post('update/(:num)', 'VpnController::Update/$1');
        $routes->get('delete/(:num)', 'VpnController::Delete/$1');
    });

    // Gestion WiFi
    $routes->group('wifi', function ($routes) {
        $routes->get('/', 'WifiController::index');
        $routes->get('create', 'WifiController::Create');
        $routes->post('store', 'WifiController::Store');
        $routes->get('edit/(:num)', 'WifiController::Edit/$1');
        $routes->post('update/(:num)', 'WifiController::Update/$1');
        $routes->get('delete/(:num)', 'WifiController::Delete/$1');
    });

    // Gestion Propositions VPN
    $routes->group('proposer-vpn', function ($routes) {
        $routes->get('/', 'ProposerVpnController::index');
        $routes->get('create', 'ProposerVpnController::Create');
        $routes->post('store', 'ProposerVpnController::Store');
        $routes->get('edit/(:num)/(:num)', 'ProposerVpnController::Edit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'ProposerVpnController::Update/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'ProposerVpnController::Delete/$1/$2');
    });

    // Gestion Propositions WiFi
    $routes->group('proposer-wifi', function ($routes) {
        $routes->get('/', 'ProposerWifiController::index');
        $routes->get('create', 'ProposerWifiController::Create');
        $routes->post('store', 'ProposerWifiController::Store');
        $routes->get('edit/(:num)/(:num)', 'ProposerWifiController::Edit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'ProposerWifiController::Update/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'ProposerWifiController::Delete/$1/$2');
    });

    // Gestion Activité
    $routes->group('activite', function ($routes) {
        $routes->get('/', 'ActiviteController::index');
        $routes->get('create', 'ActiviteController::Create');
        $routes->post('store', 'ActiviteController::Store');
        $routes->get('edit/(:num)', 'ActiviteController::Edit/$1');
        $routes->post('update/(:num)', 'ActiviteController::Update/$1');
        $routes->get('delete/(:num)', 'ActiviteController::Delete/$1');
    });

    // Gestion Type
    $routes->group('type', function ($routes) {
        $routes->get('/', 'TypeController::index');
        $routes->get('create', 'TypeController::Create');
        $routes->post('store', 'TypeController::Store');
        $routes->get('edit/(:num)', 'TypeController::Edit/$1');
        $routes->post('update/(:num)', 'TypeController::Update/$1');
        $routes->get('delete/(:num)', 'TypeController::Delete/$1');
    });

    // Gestion Salle
    $routes->group('salle', function ($routes) {
        $routes->get('/', 'SalleController::index');
        $routes->get('create', 'SalleController::Create');
        $routes->post('store', 'SalleController::Store');
        $routes->get('edit/(:num)', 'SalleController::Edit/$1');
        $routes->post('update/(:num)', 'SalleController::Update/$1');
        $routes->get('delete/(:num)', 'SalleController::Delete/$1');
    });

    // Gestion Indice
    $routes->group('indice', function ($routes) {
        $routes->get('/', 'IndiceController::index');
        $routes->get('create', 'IndiceController::Create');
        $routes->post('store', 'IndiceController::Store');
        $routes->get('edit/(:num)', 'IndiceController::Edit/$1');
        $routes->post('update/(:num)', 'IndiceController::Update/$1');
        $routes->get('delete/(:num)', 'IndiceController::Delete/$1');
    });

    // Gestion Explication
    $routes->group('explication', function ($routes) {
        $routes->get('/', 'ExplicationController::index');
        $routes->get('create', 'ExplicationController::Create');
        $routes->post('store', 'ExplicationController::Store');
        $routes->get('edit/(:num)', 'ExplicationController::Edit/$1');
        $routes->post('update/(:num)', 'ExplicationController::Update/$1');
        $routes->get('delete/(:num)', 'ExplicationController::Delete/$1');
    });

    // Gestion Avoir Indice
    $routes->group('avoir-indice', function ($routes) {
        $routes->get('/', 'AvoirIndiceController::index');
        $routes->get('create', 'AvoirIndiceController::Create');
        $routes->post('store', 'AvoirIndiceController::Store');
        $routes->get('edit/(:num)', 'AvoirIndiceController::Edit/$1');
        $routes->post('update/(:num)', 'AvoirIndiceController::Update/$1');
        $routes->get('delete/(:num)', 'AvoirIndiceController::Delete/$1');
    });

    // Gestion Activité Message
    $routes->group('activite-message', function ($routes) {
        $routes->get('/', 'ActiviteMessageController::index');
        $routes->get('create', 'ActiviteMessageController::Create');
        $routes->post('store', 'ActiviteMessageController::Store');
        $routes->get('edit/(:num)', 'ActiviteMessageController::Edit/$1');
        $routes->post('update/(:num)', 'ActiviteMessageController::Update/$1');
        $routes->get('delete/(:num)', 'ActiviteMessageController::Delete/$1');
    });
});

/*
 * ROUTES POUR L'ADMINISTRATION SALLE 4
 */
$routes->group('/gingembre/salle_4', ['namespace' => 'App\Controllers\admin\salle_4'], function ($routes) {

    // Dashboard Salle 4
    $routes->get('/', 'AdminSalle4Controller::index');

    // Gestion des Cartes
    $routes->group('carte', function ($routes) {
        $routes->get('/', 'AdminSalle4Controller::carteList');
        $routes->get('create', 'AdminSalle4Controller::carteCreate');
        $routes->post('store', 'AdminSalle4Controller::carteStore');
        $routes->get('edit/(:num)', 'AdminSalle4Controller::carteEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle4Controller::carteUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle4Controller::carteDelete/$1');
    });

    // Gestion des Questions
    $routes->group('question', function ($routes) {
        $routes->get('/', 'AdminSalle4Controller::questionList');
        $routes->get('create', 'AdminSalle4Controller::questionCreate');
        $routes->post('store', 'AdminSalle4Controller::questionStore');
        $routes->get('edit/(:num)', 'AdminSalle4Controller::questionEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle4Controller::questionUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle4Controller::questionDelete/$1');
    });

    // Gestion des Activités
    $routes->group('activite', function ($routes) {
        $routes->get('/', 'AdminSalle4Controller::activiteList');
        $routes->get('create', 'AdminSalle4Controller::activiteCreate');
        $routes->post('store', 'AdminSalle4Controller::activiteStore');
        $routes->get('edit/(:num)', 'AdminSalle4Controller::activiteEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle4Controller::activiteUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle4Controller::activiteDelete/$1');
    });

    // Gestion des Explications
    $routes->group('explication', function ($routes) {
        $routes->get('/', 'AdminSalle4Controller::explicationList');
        $routes->get('create', 'AdminSalle4Controller::explicationCreate');
        $routes->post('store', 'AdminSalle4Controller::explicationStore');
        $routes->get('edit/(:num)', 'AdminSalle4Controller::explicationEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle4Controller::explicationUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle4Controller::explicationDelete/$1');
    });

    // Gestion des Indices
    $routes->group('indice', function ($routes) {
        $routes->get('/', 'AdminSalle4Controller::indiceList');
        $routes->get('create', 'AdminSalle4Controller::indiceCreate');
        $routes->post('store', 'AdminSalle4Controller::indiceStore');
        $routes->get('edit/(:num)', 'AdminSalle4Controller::indiceEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle4Controller::indiceUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle4Controller::indiceDelete/$1');
    });
});

/*
 * ROUTES POUR L'ADMINISTRATION SALLE 5
 */
$routes->group('/gingembre/salle_5', ['namespace' => 'App\Controllers\admin\salle_5'], function ($routes) {

    // Dashboard Salle 5
    $routes->get('/', 'AdminSalle5Controller::index');

    // Gestion des Objets
    $routes->group('objet', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::objetList');
        $routes->get('create', 'AdminSalle5Controller::objetCreate');
        $routes->post('store', 'AdminSalle5Controller::objetStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::objetEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::objetUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::objetDelete/$1');
    });

    $routes->group('objet_declencheur', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::objetDeclencheurList');
        $routes->get('create', 'AdminSalle5Controller::objetDeclencheurCreate');
        $routes->post('store', 'AdminSalle5Controller::objetDeclencheurStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::objetDeclencheurEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::objetDeclencheurUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::objetDeclencheurDelete/$1');
    });

    // Gestion des objets d'activité
    $routes->group('objet_activite', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::objetActiviteList');
        $routes->get('create', 'AdminSalle5Controller::objetActiviteCreate');
        $routes->post('store', 'AdminSalle5Controller::objetActiviteStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle5Controller::objetActiviteEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle5Controller::objetActiviteUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle5Controller::objetActiviteDelete/$1/$2');
    });

    // Gestion des questions
    $routes->group('question', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::questionList');
        $routes->get('create', 'AdminSalle5Controller::questionCreate');
        $routes->post('store', 'AdminSalle5Controller::questionStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::questionEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::questionUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::questionDelete/$1');
    });

    // Gestion des réponses
    $routes->group('reponse', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::reponseList');
        $routes->get('create', 'AdminSalle5Controller::reponseCreate');
        $routes->post('store', 'AdminSalle5Controller::reponseStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::reponseEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::reponseUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::reponseDelete/$1');
    });

    // Gestion des objets réponses
    $routes->group('avoir_rep', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::avoirRepList');
        $routes->get('create', 'AdminSalle5Controller::avoirRepCreate');
        $routes->post('store', 'AdminSalle5Controller::avoirRepStore');
        $routes->get('edit/(:num)/(:num)', 'AdminSalle5Controller::avoirRepEdit/$1/$2');
        $routes->post('update/(:num)/(:num)', 'AdminSalle5Controller::avoirRepUpdate/$1/$2');
        $routes->get('delete/(:num)/(:num)', 'AdminSalle5Controller::avoirRepDelete/$1/$2');
    });

    // Gestion des Activités
    $routes->group('activite', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::activiteList');
        $routes->get('create', 'AdminSalle5Controller::activiteCreate');
        $routes->post('store', 'AdminSalle5Controller::activiteStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::activiteEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::activiteUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::activiteDelete/$1');
    });

    // Gestion des Explications
    $routes->group('explication', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::explicationList');
        $routes->get('create', 'AdminSalle5Controller::explicationCreate');
        $routes->post('store', 'AdminSalle5Controller::explicationStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::explicationEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::explicationUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::explicationDelete/$1');
    });

    // Gestion des Indices
    $routes->group('indice', function ($routes) {
        $routes->get('/', 'AdminSalle5Controller::indiceList');
        $routes->get('create', 'AdminSalle5Controller::indiceCreate');
        $routes->post('store', 'AdminSalle5Controller::indiceStore');
        $routes->get('edit/(:num)', 'AdminSalle5Controller::indiceEdit/$1');
        $routes->post('update/(:num)', 'AdminSalle5Controller::indiceUpdate/$1');
        $routes->get('delete/(:num)', 'AdminSalle5Controller::indiceDelete/$1');
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
$routes->get('/Salle3/mails/create', 'salle_3\MailController::create');
$routes->post('/Salle3/store', 'salle_3\MailController::store');
$routes->get('Salle3/mails', 'salle_3\MailController::index');

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
