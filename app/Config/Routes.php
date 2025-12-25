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
$routes->setDefaultController('ConHome');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
 $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Maintenance Mode: Uncomment to enable, comment out to disable.
// $routes->get('/', 'ConMaintenance::index');
// $routes->get('(:any)', 'ConMaintenance::index');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User\ConHome::index');
$routes->post('/Admin/News/uploadImage', 'Admin\ConAdminNews::uploadImage');
$routes->get('/Admin/News/uploadImage', 'Admin\ConAdminNews::uploadImage');
$routes->get('About/(:any)', 'User\ConAboutSchool::AboutDetail/$1');

$routes->match(['get', 'post'],'News', 'User\ConNews::NewsMain');
$routes->get('News/Detail/(:any)', 'User\ConNews::NewsDetail/$1');
$routes->match(['get', 'post'],'News/loadMoreNews', 'User\ConNews::loadMoreNews');
$routes->match(['get', 'post'],'CountReadNews','User\ConNews::NewsCountRead');
$routes->get('news-suggestions', 'User\ConNews::newsSuggestions');
$routes->get('pr', 'User\ConNews::pr');

$routes->get('Personnal/(:any)/(:any)','User\ConPersonnal::PersonnalMain/$1/$2');

$routes->get('Contact', 'User\ConContact::index');
$routes->get('PageGroup', 'User\ConHome::PageGroup');
$routes->get('guidance', 'User\ConGuidance::index');
$routes->get('Course', 'User\ConCourse::index');
$routes->get('Yearbook', 'User\ConYearbook::index');
$routes->get('Email', 'User\ConEmail::index');
$routes->get('Procurements', 'User\ConProcurements::index');
// Login admin
$routes->match(['get', 'post'], 'Login/LoginAdmin', 'User\ConLogin::LoginAdmin');
// Login admin for Google
$routes->get('SkjMain/googleLogin', 'User\ConLogin::googleLogin');
$routes->get('SkjMain/googleCallback', 'User\ConLogin::googleCallback');
// Logout
$routes->get('logout', 'User\ConLogin::LogoutAdmin');

$routes->group('Admin', ['filter' => 'permission', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('Dashboard', 'ConAdminDashboard::index');

    //Admin News
    $routes->get('News','ConAdminNews::NewsMain', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/AddNews', 'ConAdminNews::NewsAdd', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/Add/NewsFeacbook', 'ConAdminNews::NewsAddFeacbook', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/EditNews', 'ConAdminNews::NewsEdit', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/UpdateNews', 'ConAdminNews::NewsUpdate', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/DeleteNews', 'ConAdminNews::NewsDelete', ['filter' => 'permission:Admin']);
    $routes->match(['post'], 'News/deleteImage', 'ConAdminNews::deleteImage', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/View/Facebook', 'ConAdminNews::ViewNewsFormFacebook', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'News/Select/Facebook', 'ConAdminNews::SelectNewsFormFacebook', ['filter' => 'permission:Admin']);
    
    // Admin Banner
    // TEMPORARY DEBUG ROUTE
    $routes->get('Banner/Updatebanner', function() { die('Reached Updatebanner GET route!'); });
    // END TEMPORARY DEBUG ROUTE
    $routes->get('Banner','ConAdminBanner::BannerMain', ['filter' => 'permission:Admin']);
    $routes->post('Banner/BannerOnoff','ConAdminBanner::BannerOnoff', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'Banner/Addbanner', 'ConAdminBanner::AddBanner', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'Banner/EditBanner', 'ConAdminBanner::EditBanner', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'Banner/Updatebanner', 'ConAdminBanner::Updatebanner', ['filter' => 'permission:Admin']);
    $routes->post('Banner/DeleteBanner', 'ConAdminBanner::DeleteBanner', ['filter' => 'permission:Admin']);

    //Admin About
    $routes->match(['get', 'post'], 'AboutSchool/Detail/(:any)', 'ConAdminAboutSchool::AboutSchoolDetail/$1', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'AboutSchool/Edit/(:any)', 'ConAdminAboutSchool::AboutSchoolEdit/$1', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'AboutSchool/Update/(:any)', 'ConAdminAboutSchool::AboutSchoolUpdate/$1', ['filter' => 'permission:Admin']);
    $routes->match(['get', 'post'], 'AboutSchool/Add', 'ConAdminAboutSchool::AboutSchoolAdd', ['filter' => 'permission:Admin']);

    // Admin Roles
    $routes->get('roles', 'RoleController::index', ['filter' => 'permission:Super Admin']);
    $routes->post('roles/addUser', 'RoleController::addUser', ['filter' => 'permission:Super Admin']);
    $routes->get('roles/deleteUser/(:num)', 'RoleController::deleteUser/$1', ['filter' => 'permission:Super Admin']);

    // Admin Logs
    $routes->get('Logs', 'AdminLogs::index', ['filter' => 'permission:Super Admin']);
    $routes->get('Logs/Clean', 'AdminLogs::deleteOldLogs', ['filter' => 'permission:Super Admin']);
});
// 

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
