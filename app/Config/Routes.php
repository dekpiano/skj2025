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
$routes->get('SelectSystem', 'User\ConLogin::selectSystem');
$routes->post('/Admin/News/uploadImage', 'Admin\ConAdminNews::uploadImage');
$routes->get('/Admin/News/uploadImage', 'Admin\ConAdminNews::uploadImage');
$routes->get('About/(:any)', 'User\ConAboutSchool::AboutDetail/$1');
$routes->get('Board', 'User\ConBoard::index');
$routes->get('botany', 'User\ConBotany::index');
$routes->get('botany/plants', 'User\ConBotany::plants');
$routes->get('botany/detail/(:num)', 'User\ConBotany::detail/$1');
$routes->get('botany/news', 'User\ConBotany::news');
$routes->get('botany/newsdetail/(:num)', 'User\ConBotany::newsDetail/$1');
$routes->get('botany/login', 'User\ConBotanyLogin::index');
$routes->post('botany/login/auth', 'User\ConBotanyLogin::auth');
$routes->get('botany/logout', 'User\ConBotanyLogin::logout');
$routes->get('botany/createuser', 'User\ConBotanyLogin::create_default_user');

// Uppercase aliases
$routes->get('Botany', 'User\ConBotany::index');
$routes->get('Botany/Plants', 'User\ConBotany::plants');
$routes->get('Botany/Detail/(:num)', 'User\ConBotany::detail/$1');
$routes->get('Botany/News', 'User\ConBotany::news');
$routes->get('Botany/NewsDetail/(:num)', 'User\ConBotany::newsDetail/$1');
$routes->get('Botany/Login', 'User\ConBotanyLogin::index');
$routes->post('Botany/Login/Auth', 'User\ConBotanyLogin::auth');
$routes->get('Botany/Logout', 'User\ConBotanyLogin::logout');


$routes->match(['GET', 'POST'],'News', 'User\ConNews::NewsMain');
$routes->get('News/Detail/(:any)', 'User\ConNews::NewsDetail/$1');
$routes->match(['GET', 'POST'],'News/loadMoreNews', 'User\ConNews::loadMoreNews');
$routes->match(['GET', 'POST'],'CountReadNews','User\ConNews::NewsCountRead');
$routes->get('news-suggestions', 'User\ConNews::newsSuggestions');
$routes->get('pr', 'User\ConNews::pr');

$routes->get('Personnal/Executive', 'User\ConPersonnal::PersonnalMain/Management/ผู้บริหารสถานศึกษา');
$routes->get('Personnal/(:any)/(:any)','User\ConPersonnal::PersonnalMain/$1/$2');
$routes->get('Personnal/(:any)','User\ConPersonnal::PersonnalMain/$1');

$routes->get('Contact', 'User\ConContact::index');
$routes->get('PageGroup', 'User\ConHome::PageGroup');
$routes->get('guidance', 'User\ConGuidance::index');
$routes->get('Course', 'User\ConCourse::index');
$routes->get('Yearbook', 'User\ConYearbook::index');
$routes->get('Email', 'User\ConEmail::index');
$routes->get('Procurements', 'User\ConProcurements::index');
// Login admin
$routes->match(['GET', 'POST'], 'Login/LoginAdmin', 'User\ConLogin::LoginAdmin');
// Login admin for Google
$routes->match(['GET', 'POST'], 'SkjMain/googleLogin', 'User\ConLogin::googleLogin');
$routes->get('SkjMain/googleCallback', 'User\ConLogin::googleCallback');
// Logout
$routes->get('logout', 'User\ConLogin::LogoutAdmin');

$routes->group('Admin', ['filter' => 'permission', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('Dashboard', 'ConAdminDashboard::index');

    //Admin News
    $routes->get('News','ConAdminNews::NewsMain', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/AddNews', 'ConAdminNews::NewsAdd', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/Add/NewsFacebook', 'ConAdminNews::NewsAddFacebook', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/EditNews', 'ConAdminNews::NewsEdit', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/UpdateNews', 'ConAdminNews::NewsUpdate', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/DeleteNews', 'ConAdminNews::NewsDelete', ['filter' => 'permission:Admin']);
    $routes->match(['POST'], 'News/deleteImage', 'ConAdminNews::deleteImage', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/View/Facebook', 'ConAdminNews::ViewNewsFormFacebook', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/Select/Facebook', 'ConAdminNews::SelectNewsFormFacebook', ['filter' => 'permission:Admin']);
    $routes->match(['POST'], 'News/Album/Get', 'ConAdminNews::NewsAlbumGet', ['filter' => 'permission:Admin']);
    $routes->match(['POST'], 'News/Album/Delete', 'ConAdminNews::NewsAlbumDelete', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'News/CleanUnusedImages', 'ConAdminNews::CleanUnusedImages', ['filter' => 'permission:Admin']);
    
    // Admin Banner
    $routes->get('Banner','ConAdminBanner::BannerMain', ['filter' => 'permission:Admin']);
    $routes->post('Banner/BannerOnoff','ConAdminBanner::BannerOnoff', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Banner/Addbanner', 'ConAdminBanner::AddBanner', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Banner/EditBanner', 'ConAdminBanner::EditBanner', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Banner/Updatebanner', 'ConAdminBanner::Updatebanner', ['filter' => 'permission:Admin']);
    $routes->post('Banner/DeleteBanner', 'ConAdminBanner::DeleteBanner', ['filter' => 'permission:Admin']);
    $routes->post('Banner/CleanupImages', 'ConAdminBanner::CleanupImages', ['filter' => 'permission:Admin']);

    // Admin Spotlight
    $routes->get('Spotlight', 'ConAdminSpotlight::index', ['filter' => 'permission:Admin']);
    $routes->post('Spotlight/SpotlightOnoff', 'ConAdminSpotlight::SpotlightOnoff', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Spotlight/AddSpotlight', 'ConAdminSpotlight::AddSpotlight', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Spotlight/EditSpotlight', 'ConAdminSpotlight::EditSpotlight', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'Spotlight/UpdateSpotlight', 'ConAdminSpotlight::UpdateSpotlight', ['filter' => 'permission:Admin']);
    $routes->post('Spotlight/DeleteSpotlight', 'ConAdminSpotlight::DeleteSpotlight', ['filter' => 'permission:Admin']);

    //Admin About
    $routes->match(['GET', 'POST'], 'AboutSchool/Detail/(:any)', 'ConAdminAboutSchool::AboutSchoolDetail/$1', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'AboutSchool/Edit/(:any)', 'ConAdminAboutSchool::AboutSchoolEdit/$1', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'AboutSchool/Update/(:any)', 'ConAdminAboutSchool::AboutSchoolUpdate/$1', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'AboutSchool/Add', 'ConAdminAboutSchool::AboutSchoolAdd', ['filter' => 'permission:Admin']);

    // Admin Roles
    $routes->get('roles', 'RoleController::index', ['filter' => 'permission:Super Admin']);
    $routes->post('roles/addUser', 'RoleController::addUser', ['filter' => 'permission:Super Admin']);
    $routes->get('roles/deleteUser/(:num)', 'RoleController::deleteUser/$1', ['filter' => 'permission:Super Admin']);

    // Admin Logs
    $routes->get('Logs', 'AdminLogs::index', ['filter' => 'permission:Super Admin']);
    $routes->get('Logs/Clean', 'AdminLogs::deleteOldLogs', ['filter' => 'permission:Super Admin']);
    $routes->get('Logs/Export', 'AdminLogs::export', ['filter' => 'permission:Super Admin']);

    // Admin Settings
    $routes->get('Settings', 'ConAdminSettings::index', ['filter' => 'permission:Admin']);
    $routes->post('Settings/Update', 'ConAdminSettings::updateSetting', ['filter' => 'permission:Admin']);
    
    // Admin Settings (Festival Toggle - keeping compatibility or moving)
    $routes->post('toggleFestival', 'ConAdminSettings::toggleFestival', ['filter' => 'permission:Admin']);

    // Admin Welcome Modal
    $routes->get('WelcomeModal', 'ConAdminWelcomeModal::index', ['filter' => 'permission:Admin']);
    $routes->match(['GET', 'POST'], 'WelcomeModal/Update', 'ConAdminWelcomeModal::updateSetting', ['filter' => 'permission:Admin']);

    // Admin Student List
    $routes->get('Student', 'ConAdminStudent::index', ['filter' => 'permission:Admin']);
});

$routes->group('Admin/Botany', ['filter' => 'botany_auth', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'ConAdminBotany::BotanyMain');
    $routes->get('List', 'ConAdminBotany::BotanyList');
    $routes->post('BotanyOnoff', 'ConAdminBotany::BotanyOnoff');
    $routes->post('Add', 'ConAdminBotany::BotanyAdd');
    $routes->post('Edit', 'ConAdminBotany::BotanyEdit');
    $routes->post('Update', 'ConAdminBotany::BotanyUpdate');
    $routes->post('Delete', 'ConAdminBotany::BotanyDelete');

    // News
    $routes->get('News', 'ConAdminBotany::NewsList');
    $routes->post('NewsOnoff', 'ConAdminBotany::NewsOnoff');
    $routes->post('NewsAdd', 'ConAdminBotany::NewsAdd');
    $routes->post('NewsEdit', 'ConAdminBotany::NewsEdit');
    $routes->post('NewsUpdate', 'ConAdminBotany::NewsUpdate');
    $routes->post('NewsDelete', 'ConAdminBotany::NewsDelete');
    $routes->post('NewsDeleteImage', 'ConAdminBotany::NewsDeleteImage');
});

// Also keep lowercase for compatibility
$routes->group('admin/botany', ['filter' => 'botany_auth', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'ConAdminBotany::BotanyMain');
    $routes->get('list', 'ConAdminBotany::BotanyList');
    $routes->post('botanyonoff', 'ConAdminBotany::BotanyOnoff');
    $routes->post('add', 'ConAdminBotany::BotanyAdd');
    $routes->post('edit', 'ConAdminBotany::BotanyEdit');
    $routes->post('update', 'ConAdminBotany::BotanyUpdate');
    $routes->post('delete', 'ConAdminBotany::BotanyDelete');
    $routes->get('news', 'ConAdminBotany::NewsList');
    $routes->post('newsonoff', 'ConAdminBotany::NewsOnoff');
    $routes->post('newsadd', 'ConAdminBotany::NewsAdd');
    $routes->post('newsedit', 'ConAdminBotany::NewsEdit');
    $routes->post('newsupdate', 'ConAdminBotany::NewsUpdate');
    $routes->post('newsdelete', 'ConAdminBotany::NewsDelete');
    $routes->post('newsdeleteimage', 'ConAdminBotany::NewsDeleteImage');
});

$routes->group('Manager', ['filter' => 'permission:Manager,ผู้บริหาร,ผู้บริหารสถานศึกษา', 'namespace' => 'App\Controllers\Manager'], function ($routes) {
    $routes->get('Dashboard', 'ConManagerDashboard::index');
    $routes->get('Personnel', 'ConManagerPersonnel::index');
    $routes->get('Personnel/Overview', 'ConManagerPersonnel::overview');
    $routes->get('Academic/student', 'ConManagerAcademic::index');
    $routes->get('Academic/Teacher', 'ConManagerAcademic::teacherIndex');
    $routes->get('Personnel/Detail/(:any)', 'ConManagerPersonnel::getPersonnelDetail/$1');
    $routes->get('Personnel/AttendanceAnalysis', 'ConManagerPersonnel::getAttendanceAnalysis');
    $routes->get('Academic/Analysis', 'ConManagerAcademic::getAcademicAnalysis');
    $routes->get('Academic/StudentAnalysis', 'ConManagerAcademic::getStudentAnalysis');
    $routes->get('Academic/TeacherAnalysis', 'ConManagerAcademic::getTeacherAnalysis');
    $routes->get('General', 'ConManagerGeneral::index');
    $routes->get('General/Analysis', 'ConManagerGeneral::getAnalysis');
    
    // Evaluation 
    $routes->get('Evaluation', 'ConManagerEvaluation::index');
    $routes->get('Evaluation/Submit', 'ConManagerEvaluation::submitForm');
    $routes->post('Evaluation/Save', 'ConManagerEvaluation::saveEvaluation');
    $routes->post('Evaluation/UploadChunk', 'ConManagerEvaluation::uploadChunk');
    $routes->get('Evaluation/Delete/(:num)', 'ConManagerEvaluation::deleteEvaluation/$1');
    $routes->post('Evaluation/UpdateStatus', 'ConManagerEvaluation::updateStatus');

    // Executive Attendance
    $routes->get('ManagerAttendance', 'ConManagerAttendance::index');
    $routes->post('ManagerAttendance/checkin', 'ConManagerAttendance::checkInsert');
    $routes->post('ManagerAttendance/checkout', 'ConManagerAttendance::checkOut');
    $routes->get('ManagerAttendance/History', 'ConManagerAttendance::history');
    $routes->get('ManagerAttendance/Report', 'ConManagerAttendance::monthlyReport');
});
// 

$routes->group('Support', ['filter' => 'permission:Support,ฝ่ายสนับสนุน,บุคลากรฝ่ายสนับสนุน', 'namespace' => 'App\Controllers\Support'], function ($routes) {
    $routes->get('Dashboard', 'ConSupportAttendance::dashboard');
    $routes->get('SupportAttendance', 'ConSupportAttendance::index');
    $routes->post('SupportAttendance/checkin', 'ConSupportAttendance::checkInsert');
    $routes->post('SupportAttendance/checkout', 'ConSupportAttendance::checkOut');
    $routes->get('SupportAttendance/History', 'ConSupportAttendance::history');
    $routes->get('SupportAttendance/FingerprintHistory', 'ConSupportAttendance::fingerprintHistory');
    $routes->get('SupportAttendance/Report', 'ConSupportAttendance::monthlyReport');
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
