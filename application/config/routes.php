<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';

$route['signup'] = 'login/signup';
$route['registerSelf'] = 'login/registerSelf';
$route['registerSelfAction'] = 'login/registerSelfAction';

$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['getUsersData'] = 'user/getUsersData';
$route['getUserLots'] = 'user/getUserLots';
$route['getLotsData'] = 'user/getLotsData';
$route['getAllMyLots'] = 'user/getAllMyLots';
$route['getEstatesData'] = 'user/getEstatesData';
$route['getSearchedUserData'] = 'user/getSearchedUserData';
$route['getSelectedLotData'] = 'user/getSelectedLotData';
$route['userLists'] = 'user/userLists';
$route['assignLotToUser'] = 'user/assignLotToUser';
$route['deleteLotfromUser'] = "user/deleteLotfromUser";
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['construction'] = "user/construction";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
//update by Ashish Patil Human Pixel
$route['add-ticket']="/TicketManagement/CreateTicketInDesk";
$route['list-ticket']="TicketManagement";
$route['news']="News";

//$route['adminDashboard']="user/adminDashboard/";
