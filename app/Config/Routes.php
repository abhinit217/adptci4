<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setAutoRoute(true);
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Landing');
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
$routes->get('/', 'Landing::index');
$routes->add('contact', 'Contact::index');
$routes->post('contact/create', 'Contact::create');
$routes->add('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->add('login', 'Login::index');
$routes->post('login/logout', 'Login::logout');

//$routes->add('reporting', 'Reporting::index');
$routes->post('reporting/get_user_data_popup_modal', 'Reporting::get_user_data_popup_modal');
$routes->post('reporting/get_indicators_list', 'Reporting::get_indicators_list');
$routes->post('reporting/get_indicators_details', 'Reporting::get_indicators_details');
$routes->post('reporting/get_countys', 'Reporting::get_countys');
$routes->post('reporting/upload_get_dimensions', 'Reporting::upload_get_dimensions');
$routes->post('reporting/upload_get_subdimensions', 'Reporting::upload_get_subdimensions');
$routes->post('reporting/insert_bulk_indicatordata', 'Reporting::insert_bulk_indicatordata');


//$routes->get('abhinit', 'Abhinit::index');

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
