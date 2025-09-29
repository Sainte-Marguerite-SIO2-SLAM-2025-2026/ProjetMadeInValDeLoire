<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Route pour la Salle principale
$routes->get('/', 'accueil\AccueilController::index');

// Routes pour chaque vue
$routes->get('/Salle1', 'accueil\AccueilController::Salle1');
$routes->get('/Salle2', 'accueil\AccueilController::Salle2');
$routes->get('/Salle3', 'accueil\AccueilController::Salle3');
$routes->get('/Salle4', 'accueil\AccueilController::Salle4');
$routes->get('/Salle5', 'accueil\AccueilController::Salle5');
$routes->get('/Salle6', 'accueil\AccueilController::Salle6');
