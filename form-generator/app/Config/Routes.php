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
$routes->setDefaultController('Home');
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

use App\Controllers\Users;
use App\Controllers\Forms;
use App\Controllers\FormSubmissions;
use App\Controllers\FormsAPI;
$routes->get('/', [Users::class, 'index']);

$routes->get('api/forms', [FormsAPI::class, 'getForms']);
$routes->post('api/forms', [FormsAPI::class, 'postForm']);
$routes->put('api/forms/(:segment)', [FormsAPI::class, 'updateForm']);
$routes->post('api/forms/(:segment)', [FormsAPI::class, 'updateForm']);
$routes->patch('api/forms/(:segment)', [FormsAPI::class, 'updateForm']);
$routes->delete('api/forms/(:segment)', [FormsAPI::class, 'deleteForm']);


$routes->get('api/forms/submissions/(:segment)', [FormsAPI::class, 'getFormSubmissions']);
$routes->post('api/forms/submissions/(:segment)', [FormsAPI::class, 'postFormSubmission']);
$routes->delete('api/forms/submissions/(:segment)/(:segment)', [FormsAPI::class, 'deleteFormSubmission']);


$routes->get('api/forms/history/(:segment)', [FormsAPI::class, 'getFormHistory']);
$routes->delete('api/forms/history/(:segment)', [FormsAPI::class, 'deleteFormHistory']);


$routes->match(['get', 'post'], 'users/form', [Users::class, 'add']);

$routes->get('form', [Users::class, 'form']);
$routes->get('new', [Users::class, 'newform']);

$routes->match(['get', 'post'], 'custom-form', [Forms::class, 'custom_form']);
$routes->match(['get', 'post'], 'forms/(:segment)', [Forms::class, 'view']);
$routes->match(['get', 'post'], 'forms/(:num)/(:num)', [Forms::class, 'view']);
$routes->match(['get', 'post'], 'forms/revert/(:segment)/(:segment)', [Forms::class, 'revert']);
$routes->match(['get', 'post'], 'forms/edit/(:segment)', [Forms::class, 'edit']);
$routes->get('forms/delete-confirmation/(:segment)', [Forms::class, 'delete_confirmation']);
$routes->match(['get', 'post'], 'forms/delete/(:segment)', [Forms::class, 'delete']);
$routes->get('forms/print/(:segment)', [Forms::class, 'print']);
$routes->match(['get', 'post'], 'report-form', [Forms::class, 'report_form']);

$routes->get('form-submissions/(:num)', [FormSubmissions::class, 'index']);
$routes->get('form-submissions/(:num)/(:num)', [FormSubmissions::class, 'index']);
$routes->match(['get', 'post'], 'form-submissions/view/(:num)', [FormSubmissions::class, 'view']);
$routes->match(['get', 'post'], 'form-submissions/edit/(:num)', [FormSubmissions::class, 'edit']);
$routes->match(['get', 'post'], 'form-submissions/delete/(:num)', [FormSubmissions::class, 'delete']);
$routes->get('form-submissions/print/(:num)', [FormSubmissions::class, 'print']);

$routes->match(['get', 'post'], '1040/', [Forms::class, 'finance_form']);


$routes->get('dashboard', [Users::class, 'index']);
$routes->get('create-form-entry/(:segment)', [Users::class, 'create_form_entry']);

$routes->get('templates', [Users::class, 'templates']);

service('auth')->routes($routes);


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
