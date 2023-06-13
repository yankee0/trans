<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->post('/', 'Auth::login');
$routes->get('/deconnexion', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->group('admin', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'admin::index');
        $routes->post('modifier_mdp', 'utilisateurs::modifier_mdp');

        //gestion des utilisateurs
        $routes->group('utilisateurs', function ($routes) {
            $routes->get('/', 'utilisateurs::list');
            $routes->post('/', 'utilisateurs::add');
            $routes->add('del', 'utilisateurs::delete');
            $routes->post('edit', 'utilisateurs::edit');
            $routes->get('search', 'utilisateurs::search');
        });

        //gestion des zones
        $routes->group('zones', function ($routes) {
            $routes->get('/', 'zones::list');
            $routes->post('/', 'zones::add');
            $routes->add('del', 'zones::delete');
            $routes->post('edit', 'zones::edit');
            $routes->get('search', 'zones::search');
        });

        //gestion des chauffeurs
        $routes->group('chauffeurs', function ($routes) {
            $routes->get('/', 'chauffeurs::list');
            $routes->post('/', 'chauffeurs::add');
            $routes->add('del', 'chauffeurs::delete');
            $routes->post('edit', 'chauffeurs::edit');
            $routes->get('search', 'chauffeurs::search');
        });
    });
});

//-------------------Routes API
$routes->group('api',['filter' => 'api-auth'], function($routes)
{
    $routes->group('utilisateurs', function($routes)
    {
        $routes->get('/','api\utilisateurs::get');
    });

    $routes->group('zones', function($routes)
    {
        $routes->get('/','api\zones::get');
    });

    $routes->group('chauffeurs', function($routes)
    {
        $routes->get('/','api\chauffeurs::get');
    });
});

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
