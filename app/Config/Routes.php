<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// routes default
$routes->get('/', 'Home::index');
// $routes->get('/coba', 'Coba::index');

// atau pake add
// $routes->add('/testing', 'Coba::index');

// $routes->get('/fungsi-anonymous', function () {
//     echo 'Hello World!';
// });

//utk mengirim data
// $routes->get('/coba/(:any)', 'Coba::tentang/$1');
$routes->get('/coba/(:any)/(:alpha)/(:num)', 'Coba::tentang/$1/$2/$3');
$routes->get('coba/index', 'Coba::index');
$routes->get('coba/tentang', 'Coba::tentang');

//folder admin file users
$routes->get('/users', 'Admin\Users::index');

// Eps 4 (View)
$routes->get('/', 'Pages::index');

//routes detail
$routes->get('/komikku/tambah', 'Komikku::create');
$routes->get('/komikku/edit/(:segment)', 'Komikku::edit/$1');
$routes->delete('/komikku/(:num)', 'Komikku::delete/$1');

$routes->get('/komikku/(:any)', 'Komikku::detail/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
