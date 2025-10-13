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
$routes->get('/pageTest', 'salle_4\Salle4Controller::pageTest');
$routes->get('/Salle4', 'salle_4\Salle4Controller::index');


// Routes pour la salle 5
$routes->get('/Salle5', 'accueil\AccueilController::Salle5');

// Routes pour la salle 6
$routes->get('/Salle6', 'accueil\AccueilController::Salle6');


