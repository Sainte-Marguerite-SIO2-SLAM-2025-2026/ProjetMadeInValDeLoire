<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Accueil (porte avec Commencer/Quitter)
$routes->get('/', 'Accueil::index');

//Introduction
$routes->get('/introduction', 'Introduction::index');

//Introduction
$routes->get('/aide', 'Introduction::aide');

//Etape 1 Accueil
$routes->get('/etape1', 'Etape::Etape1');

//Etape 1 Code
$routes->get('/etape1a', 'Etape::Etape1a');

//Etape 2 Code
$routes->get('/etape2', 'Etape::Etape2');

//Etape 2 Code
$routes->get('/etape2a', 'Etape::Etape2a');

//Etape 3 Code
$routes->get('/etape3', 'Etape::Etape3');

//Etape 4 Code
$routes->get('/etape4', 'Etape::Etape4');

//Etape 5 Code
$routes->get('/etape5', 'Etape::Etape5');

//Etape 6 Code
$routes->get('/etape6', 'Etape::Etape6');


$routes->get('etape1/salle3', 'Etape1::salle3');
$routes->post('etape1/salle3', 'Etape1::salle3');