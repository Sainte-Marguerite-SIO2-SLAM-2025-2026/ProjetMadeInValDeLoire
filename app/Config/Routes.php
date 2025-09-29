<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Route pour la Salle principale
$routes->get('/', 'AccueilController::index');

// Routes pour chaque vue
$routes->get('/Salle1', 'AccueilController::Salle1');
$routes->get('/Salle2', 'AccueilController::Salle2');
$routes->get('/Salle3', 'AccueilController::Salle3');
$routes->get('/Salle4', 'AccueilController::Salle4');
$routes->get('/Salle5', 'AccueilController::Salle5');
$routes->get('/Salle6', 'AccueilController::Salle6');
