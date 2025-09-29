<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Route pour la Salle principale
$routes->get('/', 'Home::index');

// Routes pour chaque vue
$routes->get('/Salle1', 'Home::Salle1');
$routes->get('/Salle2', 'Home::Salle2');
$routes->get('/Salle3', 'Home::Salle3');
$routes->get('/Salle4', 'Home::Salle4');
$routes->get('/Salle5', 'Home::Salle5');
$routes->get('/Salle6', 'Home::Salle6');
