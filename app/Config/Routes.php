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

        //gestion des camions
        $routes->group('camions', function ($routes) {
            $routes->get('/', 'camions::list');
            $routes->post('/', 'camions::add');
            $routes->add('del', 'camions::delete');
            $routes->post('edit', 'camions::edit');
            $routes->get('search', 'camions::search');
        });

        //gestion des remorques
        $routes->group('remorques', function ($routes) {
            $routes->get('/', 'remorques::list');
            $routes->post('/', 'remorques::add');
            $routes->add('del', 'remorques::delete');
            $routes->post('edit', 'remorques::edit');
            $routes->get('search', 'remorques::search');
        });
    });

    $routes->group('flotte', ['filter' => 'flotte'], function ($routes) {
        $routes->get('/', 'chauffeurs::list');
        $routes->post('modifier_mdp', 'utilisateurs::modifier_mdp');

        //gestion des chauffeurs
        $routes->group('chauffeurs', function ($routes) {
            $routes->get('/', 'chauffeurs::list');
            $routes->post('/', 'chauffeurs::add');
            $routes->add('del', 'chauffeurs::delete');
            $routes->post('edit', 'chauffeurs::edit');
            $routes->get('search', 'chauffeurs::search');
        });

        //gestion des camions
        $routes->group('camions', function ($routes) {
            $routes->get('/', 'camions::list');
            $routes->post('/', 'camions::add');
            $routes->add('del', 'camions::delete');
            $routes->post('edit', 'camions::edit');
            $routes->get('search', 'camions::search');
        });

        //gestion des remorques
        $routes->group('remorques', function ($routes) {
            $routes->get('/', 'remorques::list');
            $routes->post('/', 'remorques::add');
            $routes->add('del', 'remorques::delete');
            $routes->post('edit', 'remorques::edit');
            $routes->get('search', 'remorques::search');
        });
    });

    $routes->group('facturation', ['filter' => 'facturation'], function ($routes) {
        $routes->get('/', 'facturations::index');
        $routes->post('modifier_mdp', 'utilisateurs::modifier_mdp');

        //gestion des clients
        $routes->group('clients', function ($routes) {
            $routes->get('/', 'clients::list');
            $routes->post('/', 'clients::add');
            $routes->add('del', 'clients::delete');
            $routes->post('edit', 'clients::edit');
            $routes->get('search', 'clients::search');
        });

        //gestion des facturations de livraisons
        $routes->group('livraisons', function ($routes) {
            $routes->get('/', 'factLiv::list');
            $routes->get('details/(:segment)', 'factLiv::showInvoice/$1');
            $routes->get('edit/', '');
            $routes->group('edit', function($routes)
            {
                $routes->post('addzone','factLiv::addZone');
                $routes->get('(:segment)','factLiv::showEdit/$1');
                $routes->post('entete/(:segment)','factLiv::editFactLiveHeader/$1');
                $routes->get('zones/(:num)/(:num)','factLiv::deleteZone/$1/$2');
                $routes->post('zones/new','factLiv::changeZone');
                $routes->post('adresse/(:num)','factLiv::editAddress/$1');
                $routes->post('price/(:num)','factLiv::editPrice/$1');
                $routes->get('delete/container/(:num)','factLiv::deleteContainer/$1');
                $routes->post('container/(:num)','factLiv::editContainer/$1');
                $routes->post('container/add','factLiv::addContainer');
            });
            $routes->post('/', 'factLiv::add');
            $routes->add('del/(:segment)', 'factLiv::delete/$1');
            $routes->post('edit', 'factLiv::edit');
            $routes->get('search', 'factLiv::search');
        });

        //gestion des zones
        $routes->group('zones', function ($routes) {
            $routes->get('/', 'zones::list');
            $routes->post('/', 'zones::add');
            $routes->add('del', 'zones::delete');
            $routes->post('edit', 'zones::edit');
            $routes->get('search', 'zones::search');
        });
    });

    $routes->group('finance', ['filter' => 'finance'], function ($routes) {
        $routes->get('/', 'finance::index');
        $routes->post('modifier_mdp', 'utilisateurs::modifier_mdp');

        
    });
});

//-------------------Routes API
$routes->group('api', ['filter' => 'api-auth'], function ($routes) {
    // $routes->group('api', function ($routes) {
        
    $routes->group('graph', function ($routes) {
        $routes->add('bar_fact_liv', 'api\graph::bar_fact_liv');
        $routes->add('pie_fact_liv', 'api\graph::pie_fact_liv');
    });

    $routes->group('utilisateurs', function ($routes) {
        $routes->get('/', 'api\utilisateurs::get');
    });

    $routes->group('zones', function ($routes) {
        $routes->get('/', 'api\zones::get');
    });

    $routes->group('chauffeurs', function ($routes) {
        $routes->get('/', 'api\chauffeurs::get');
    });

    $routes->group('camions', function ($routes) {
        $routes->get('/', 'api\camions::get');
    });

    $routes->group('remorques', function ($routes) {
        $routes->get('/', 'api\remorques::get');
    });

    $routes->group('clients', function ($routes) {
        $routes->get('/', 'api\clients::get');
    });

    $routes->group('utils', function ($routes) {
        $routes->post('checkData', 'api\utils::checkDoubleContainer');
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
