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
use App\Controllers\Pages;
use App\Controllers\Hotels;
use App\Controllers\ThingsToDo;
use App\Controllers\Rentals;
use App\Controllers\Restaurants;
use App\Controllers\Stories;
use App\Controllers\More;
use App\Controllers\Guides;
use App\Controllers\Users;
use App\Controllers\Flights;
use App\Controllers\Chatbot;

$routes->get('/', [Pages::class, 'index']);

$routes->get('template/(:segment)', [Template::class, 'view']);

// Travel Guides
$routes->match(['get', 'post'], 'guides/trip-date', [Guides::class, 'plan_trip_date']);
$routes->match(['get', 'post'], 'guides/create/(:segment)/(:segment)/(:segment)', [Guides::class, 'create'], ['filter' => 'authGuard']);
$routes->match(['get', 'post'], 'guides/view/(:segment)', [Guides::class, 'view']);
$routes->match(['get', 'post'], 'guides/update/(:segment)', [Guides::class, 'update']);
$routes->match(['get', 'post'], 'guides', [Guides::class, 'index']);
$routes->match(['get', 'post'], 'guides/delete/(:segment)', [Guides::class, 'delete']);
$routes->match(['get', 'post'], 'guides/search/', [Guides::class, 'index']);
$routes->match(['get', 'post'], 'guides/search/(:segment)', [Guides::class, 'index']);

// Chat Bot
$routes->get('chatbot', [Chatbot::class, 'index']);

// Hotels
$routes->match(['get', 'post'], 'hotels/create-review/(:segment)/(:segment)', [Hotels::class, 'create'], ['filter' => 'authGuard']);
$routes->match(['get', 'post'], 'hotels/dashboard', [Hotels::class, 'dashboard'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'hotels/delete-review/(:segment)', [Hotels::class, 'delete_review']);
$routes->match(['get', 'post'], 'hotels/dashboard/edit-hotel/(:segment)', [Hotels::class, 'edit_hotel'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'hotels/dashboard/create-hotel', [Hotels::class, 'create_hotel'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'hotels/dashboard/delete-hotel/(:segment)', [Hotels::class, 'delete_hotel'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'hotels/(:segment)', [Hotels::class, 'search']);
$routes->match(['get', 'post'], 'hotels/search-name/(:segment)/(:segment)', [Hotels::class, 'search_name']);
$routes->get('hotels/view/(:segment)/(:segment)', [Hotels::class, 'view']);
$routes->match(['get', 'post'], 'hotels', [Hotels::class, 'index']);

// Attractions
$routes->match(['get', 'post'], 'things-to-do/create-review/(:segment)/(:segment)', [ThingsToDo::class, 'create'], ['filter' => 'authGuard']);
$routes->match(['get', 'post'], 'things-to-do/dashboard', [ThingsToDo::class, 'dashboard'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'things-to-do/delete-review/(:segment)', [ThingsToDo::class, 'delete_review']);
$routes->match(['get', 'post'], 'things-to-do/dashboard/create-thing-to-do', [ThingsToDo::class, 'create_thing_to_do'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'things-to-do/dashboard/edit-thing-to-do/(:segment)', [ThingsToDo::class, 'edit_thing_to_do'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'things-to-do/dashboard/delete-thing-to-do/(:segment)', [ThingsToDo::class, 'delete_thing_to_do'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'things-to-do/(:segment)', [ThingsToDo::class, 'search']);
$routes->match(['get', 'post'], 'things-to-do/search-name/(:segment)/(:segment)', [ThingsToDo::class, 'search_name']);
$routes->get('things-to-do/view/(:segment)/(:segment)', [ThingsToDo::class, 'view']);
$routes->match(['get', 'post'], 'things-to-do', [ThingsToDo::class, 'index']);

$routes->get('rentals', [Rentals::class, 'index']);

// Restaurants
$routes->match(['get', 'post'], 'restaurants/create-review/(:segment)/(:segment)', [Restaurants::class, 'create'], ['filter' => 'authGuard']);
$routes->match(['get', 'post'], 'restaurants/dashboard', [Restaurants::class, 'dashboard'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'restaurants/delete-review/(:segment)', [Restaurants::class, 'delete_review']);
$routes->match(['get', 'post'], 'restaurants/dashboard/edit-restaurant/(:segment)', [Restaurants::class, 'edit_restaurant'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'restaurants/dashboard/create-restaurant', [Restaurants::class, 'create_restaurant'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'restaurants/dashboard/delete-restaurant/(:segment)', [Restaurants::class, 'delete_restaurant'], ['filter' => 'authGuard:admin']);
$routes->match(['get', 'post'], 'restaurants/(:segment)', [Restaurants::class, 'search']);
$routes->match(['get', 'post'], 'restaurants/search-name/(:segment)/(:segment)', [Restaurants::class, 'search_name']);
$routes->get('restaurants/view/(:segment)/(:segment)', [Restaurants::class, 'view']);
$routes->match(['get', 'post'], 'restaurants', [Restaurants::class, 'index']);

// User authentication
$routes->match(['get', 'post'], 'signin', [Users::class, 'signin']);
$routes->match(['get', 'post'], 'signup', [Users::class, 'signup']);
$routes->match(['get', 'post'], 'signup/2fa', [Users::class, 'signup_2fa']);
$routes->match(['get', 'post'], 'signin/2fa', [Users::class, 'signin_2fa']);
$routes->get('logout', [Users::class, 'logout'], ['filter' => 'authGuard']);
$routes->get('reviews', [Users::class, 'reviews'], ['filter' => 'authGuard']);
$routes->get('trips', [Users::class, 'trips'], ['filter' => 'authGuard']);

// Flights
// $routes->get('flights/(:segment)', [Flights::class, 'search']);
$routes->get('flights', [Flights::class, 'index']);
$routes->match(['get', 'post'], 'flight-cost', [Flights::class, 'search']);

// Test routes
$routes->get('stories', [Stories::class, 'index']);
$routes->get('more', [More::class, 'index']);
$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);

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
