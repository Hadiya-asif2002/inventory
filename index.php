<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/database.php';

use Routes\Router;
$router = new Router();

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
   [
      'url' => '/inventory-items',
      'target' => ['Controllers\InventoryController', 'create']
   ],
   [
      'url' => '/inventory-items/item',
      'target' => ['Controllers\InventoryController', 'update']
   ],
    [
      'url' => '/employees/employee/inventory-items',
      'target' => ['Controllers\AssignInventoryController', 'create']
    ],
    [
      'url' => '/employees/employee/inventory-items/item',
      'target' => ['Controllers\AssignInventoryController', 'update']
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
   [
      'url' => '/inventory-items',
      'target' => ['Controllers\InventoryController', 'index']
   ],
   [
      'url' => '/employees/employee/inventory-items',
      'target' => ['Controllers\AssignInventoryController', 'index']
   ]

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
   [
      'url' => '/inventory-items/item',
      'target' => ['Controllers\InventoryController', 'delete']
   ],
   [
      'url' => '/employees/employee/inventory-items/item',
      'target' => ['Controllers\AssignInventoryController', 'delete']
   ]
];


$router->addRoutes('POST', $postRoutes);
$router->addRoutes('GET', $getRoutes);
$router->addRoutes('DELETE', $deleteRoutes);
$router->matchRoute();
