<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/database.php';
use Routes\Router;
$router = new Router();
// how to group routes by controller name and method i guess we don't need to group by method and controller name
// laravel routes  calls the static ::get method to add the get route and ::post method to add the post route
// routes = [
//          'controllername'=>[
//                    url,
//                    target
//         ]
// on home page create on api to load all departments and employees and assigned inventory instead of three different apis
// to improve the code structure
$postRoutes = [
   [
      'url' => '/login',
      'target' => ['Controllers\Auth', 'login']
   ],
   [
      'url' => 'logout',
      'target' => ['Controllers\Auth', 'logout']
   ],
   [
      'url' => '/register',
      'target' => ['Controllers\User', 'create']
   ],
   [
      'url' => '/forgot-password',
      'target' => ['Controllers\Auth', 'submitForgotPasswordForm']
   ],
   [
      'url' => '/set-forgot-password',
      'target' => ['Controllers\Auth', 'submitForgotPassword']
   ],
   [
      'url' => '/reset-password',
      'target' => ['Controllers\Auth', 'resetPassword']
   ],
   [
      'url' => '/departments',
      'target' => ['Controllers\DepartmentController', 'create']
   ],
   [
      'url' => '/departments/department',
      'target' => ['Controllers\DepartmentController', 'update']
   ],
   [
      'url' => '/employees',
      'target' => ['Controllers\EmployeeController', 'create']
   ],
   [
      'url' => '/employees/employee',
      'target' => ['Controllers\EmployeeController', 'update']
   ],
];
$getRoutes = [
   [
      'url' => '/',
      'target' => ['Controllers\Home', 'home']
   ],
   [
      'url' => '/login',
      'target' => ['Controllers\authFrontend', 'viewLogin']
   ],
   [
      'url' => '/register',
      'target' => ['Controllers\authFrontend', 'viewRegister']
   ],
   [
      'url' => '/forgot-password',
      'target' => ['Controllers\authFrontend', 'viewForgotPassword']
   ],
   [
      'url' => '/submit-forgot-password',
      'target' => ['Controllers\authFrontend', 'viewSubmitForgotPassword']
   ],
   [
      'url' => '/departments',
      'target' => ['Controllers\DepartmentController', 'index']
   ],
   [
      'url' => '/employees',
      'target' => ['Controllers\EmployeeController', 'index']
   ],

];
$deleteRoutes = [
   [
      'url' => '/departments/department',
      'target' => ['Controllers\DepartmentController', 'delete']
   ],
   [
      'url' => '/employees/employee',
      'target' => ['Controllers\EmployeeController', 'delete']
   ],
];

$router->addRoutes('POST', $postRoutes);
$router->addRoutes('GET', $getRoutes);
$router->addRoutes('DELETE', $deleteRoutes);
$router->matchRoute();
