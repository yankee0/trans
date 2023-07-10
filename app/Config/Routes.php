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
$routes->get('/(:segment)/livraisons/details/(:segment)', 'FactLiv::showInvoice/$2');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->group('admin', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'Admin::index');
        $routes->post('modifier_mdp', 'Utilisateurs::modifier_mdp');

        //gestion des utilisateurs
        $routes->group('utilisateurs', function ($routes) {
            $routes->get('/', 'Utilisateurs::list');
            $routes->post('/', 'Utilisateurs::add');
            $routes->add('del', 'Utilisateurs::delete');
            $routes->post('edit', 'Utilisateurs::edit');
            $routes->get('search', 'Utilisateurs::search');
        });

        //gestion des zones
        $routes->group('zones', function ($routes) {
            $routes->get('/', 'Zones::list');
            $routes->post('/', 'Zones::add');
            $routes->add('del', 'Zones::delete');
            $routes->post('edit', 'Zones::edit');
            $routes->get('search', 'Zones::search');
        });

        //gestion des chauffeurs
        $routes->group('chauffeurs', function ($routes) {
            $routes->get('/', 'Chauffeurs::list');
            $routes->post('/', 'Chauffeurs::add');
            $routes->add('del', 'Chauffeurs::delete');
            $routes->post('edit', 'Chauffeurs::edit');
            $routes->get('search', 'Chauffeurs::search');
        });

        //gestion des camions
        $routes->group('camions', function ($routes) {
            $routes->get('/', 'Camions::list');
            $routes->post('/', 'Camions::add');
            $routes->add('del', 'Camions::delete');
            $routes->post('edit', 'Camions::edit');
            $routes->get('search', 'Camions::search');
        });

        //gestion des remorques
        $routes->group('remorques', function ($routes) {
            $routes->get('/', 'Remorques::list');
            $routes->post('/', 'Remorques::add');
            $routes->add('del', 'Remorques::delete');
            $routes->post('edit', 'Remorques::edit');
            $routes->get('search', 'Remorques::search');
        });

        //gestion des livraisons
        $routes->group('livraisons', function ($routes) {
            $routes->get('/', 'Livraisons::index');
            $routes->get('infos/(:segment)', 'Livraisons::info/$1');
            $routes->post('/', 'Livraisons::save');
            $routes->post('abord', 'Livraisons::abord');
            $routes->get('drop/(:segment)', 'Livraisons::drop/$1');
            $routes->get('up/(:segment)', 'Livraisons::up/$1');
            $routes->get('preget','Livraisons::preget');
            $routes->post('preget','Livraisons::checkPreget');
            $routes->post('preget/(:segment)','Livraisons::handlePG/$1');
        });

        //recherche operation
        $routes->get('search', 'Ops::search');
    });

    $routes->group('flotte', ['filter' => 'flotte'], function ($routes) {
        $routes->get('/', 'Chauffeurs::list');
        $routes->post('modifier_mdp', 'Utilisateurs::modifier_mdp');

        //gestion des chauffeurs
        $routes->group('chauffeurs', function ($routes) {
            $routes->get('/', 'Chauffeurs::list');
            $routes->post('/', 'Chauffeurs::add');
            $routes->add('del', 'Chauffeurs::delete');
            $routes->post('edit', 'Chauffeurs::edit');
            $routes->get('search', 'Chauffeurs::search');
        });

        //gestion des camions
        $routes->group('camions', function ($routes) {
            $routes->get('/', 'Camions::list');
            $routes->post('/', 'Camions::add');
            $routes->add('del', 'Camions::delete');
            $routes->post('edit', 'Camions::edit');
            $routes->get('search', 'Camions::search');
        });

        //gestion des remorques
        $routes->group('remorques', function ($routes) {
            $routes->get('/', 'Remorques::list');
            $routes->post('/', 'Remorques::add');
            $routes->add('del', 'Remorques::delete');
            $routes->post('edit', 'Remorques::edit');
            $routes->get('search', 'Remorques::search');
        });
    });

    $routes->group('facturation', ['filter' => 'facturation'], function ($routes) {
        $routes->get('/', 'Facturations::index');
        $routes->post('modifier_mdp', 'Utilisateurs::modifier_mdp');

        //gestion des clients
        $routes->group('clients', function ($routes) {
            $routes->get('/', 'Clients::list');
            $routes->post('/', 'Clients::add');
            $routes->add('del', 'Clients::delete');
            $routes->post('edit', 'Clients::edit');
            $routes->get('search', 'Clients::search');
        });

        //gestion des facturations de livraisons
        $routes->group('livraisons', function ($routes) {
            $routes->get('/', 'FactLiv::list');
            $routes->post('/', 'FactLiv::add');
            $routes->add('del/(:segment)', 'FactLiv::delete/$1');
            $routes->post('edit', 'FactLiv::edit');
            $routes->get('search', 'FactLiv::search');
            $routes->group('edit', function ($routes) {
                $routes->post('addzone', 'FactLiv::addZone');
                $routes->get('(:segment)', 'FactLiv::showEdit/$1');
                $routes->post('entete/(:segment)', 'FactLiv::editFactLiveHeader/$1');
                $routes->get('zones/(:num)/(:num)', 'FactLiv::deleteZone/$1/$2');
                $routes->post('zones/new', 'FactLiv::changeZone');
                $routes->post('adresse/(:num)', 'FactLiv::editAddress/$1');
                $routes->post('price/(:num)', 'FactLiv::editPrice/$1');
                $routes->get('delete/container/(:num)', 'FactLiv::deleteContainer/$1');
                $routes->post('container/(:num)', 'FactLiv::editContainer/$1');
                $routes->post('container/add', 'FactLiv::addContainer');
            });
            $routes->post('annuler/(:segment)', 'FactLiv::abord/$1');
        });

        //gestion des zones
        $routes->group('zones', function ($routes) {
            $routes->get('/', 'Zones::list');
            $routes->post('/', 'Zones::add');
            $routes->add('del', 'Zones::delete');
            $routes->post('edit', 'Zones::edit');
            $routes->get('search', 'Zones::search');
        });
    });

    $routes->group('finance', ['filter' => 'finance'], function ($routes) {
        $routes->get('/', 'Finance::index');
        $routes->post('modifier_mdp', 'Utilisateurs::modifier_mdp');

        //gestion des clients
        $routes->group('clients', function ($routes) {
            $routes->get('/', 'Clients::list');
            $routes->post('/', 'Clients::add');
            $routes->add('del', 'Clients::delete');
            $routes->post('edit', 'Clients::edit');
            $routes->get('search', 'Clients::search');
        });

        //livraisons
        $routes->group('livraisons', function($routes)
        {
            $routes->get('/','Finance::showLivs');
            $routes->post('reglement/(:num)','Finance::managePay/$1');
        });
    });

    $routes->group('ops', ['filter' => 'ops'], function ($routes) {
        $routes->get('/', 'Ops::index');
        $routes->post('modifier_mdp', 'Utilisateurs::modifier_mdp');
        $routes->get('search', 'Ops::search');

        //gestion des chauffeurs
        $routes->group('chauffeurs', function ($routes) {
            $routes->get('/', 'Chauffeurs::list');
            $routes->post('/', 'Chauffeurs::add');
            $routes->add('del', 'Chauffeurs::delete');
            $routes->post('edit', 'Chauffeurs::edit');
            $routes->get('search', 'Chauffeurs::search');
        });

        //gestion des camions
        $routes->group('camions', function ($routes) {
            $routes->get('/', 'Camions::list');
            $routes->post('/', 'Camions::add');
            $routes->add('del', 'Camions::delete');
            $routes->post('edit', 'Camions::edit');
            $routes->get('search', 'Camions::search');
        });

        //gestion des remorques
        $routes->group('remorques', function ($routes) {
            $routes->get('/', 'Remorques::list');
            $routes->post('/', 'Remorques::add');
            $routes->add('del', 'Remorques::delete');
            $routes->post('edit', 'Remorques::edit');
            $routes->get('search', 'Remorques::search');
        });

        //gestion des zones
        $routes->group('zones', function ($routes) {
            $routes->get('/', 'Zones::list');
            $routes->post('/', 'Zones::add');
            $routes->add('del', 'Zones::delete');
            $routes->post('edit', 'Zones::edit');
            $routes->get('search', 'Zones::search');
        });

        //gestion des livraisons
        $routes->group('livraisons', function ($routes) {
            $routes->get('/', 'Livraisons::index');
            $routes->get('infos/(:segment)', 'Livraisons::info/$1');
            $routes->post('/', 'Livraisons::save');
            $routes->post('abord', 'Livraisons::abord');
            $routes->get('drop/(:segment)', 'Livraisons::drop/$1');
            $routes->get('up/(:segment)', 'Livraisons::up/$1');
            $routes->get('preget','Livraisons::preget');
            $routes->post('preget','Livraisons::checkPreget');
            $routes->post('preget/(:segment)','Livraisons::handlePG/$1');
        });

    });
});

//-------------------Routes API
$routes->group('api', ['filter' => 'api-auth'], function ($routes) {

    $routes->group('graph', function ($routes) {
        $routes->add('bar_fact_liv', 'Api\Graph::bar_fact_liv');
        $routes->add('pie_fact_liv', 'Api\Graph::pie_fact_liv');
        $routes->add('pie_stat_liv', 'Api\Graph::pie_stat_liv');
        $routes->add('bar_stat_liv', 'Api\Graph::bar_stat_liv');
    });

    $routes->group('utilisateurs', function ($routes) {
        $routes->get('/', 'Api\Utilisateurs::get');
    });

    $routes->group('zones', function ($routes) {
        $routes->get('/', 'Api\Zones::get');
    });

    $routes->group('chauffeurs', function ($routes) {
        $routes->get('/', 'Api\Chauffeurs::get');
    });

    $routes->group('camions', function ($routes) {
        $routes->get('/', 'Api\Camions::get');
    });

    $routes->group('remorques', function ($routes) {
        $routes->get('/', 'Api\Remorques::get');
    });

    $routes->group('clients', function ($routes) {
        $routes->get('/', 'Api\Clients::get');
    });

    $routes->group('livraisons', function ($routes) {
        $routes->get('/', 'Api\Livraisons::get');
    });

    $routes->group('utils', function ($routes) {
        $routes->post('checkData', 'Api\Utils::checkDoubleContainer');
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
