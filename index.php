<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/database/database.php';

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
      'url' => '/reset-password',
      'target' => ['Controllers\Auth', 'resetPassword']
   ]

];
$getRoutes = [
   [
      'url' => '/',
      'target'=>['Controllers\Home','home']
   ],
   [
      'url' => '/login',
      'target'=>['Controllers\authFrontend','viewLogin']
   ],
   [
      'url' => '/register',
      'target'=>['Controllers\authFrontend','viewRegister']
   ],
   [
      'url' => '/forgot-password',
      'target'=>['Controllers\authFrontend','viewForgotPassword']
   ],
   [
      'url' => '/submit-forgot-password',
      'target'=>['Controllers\authFrontend','viewSubmitForgotPassword']
   ],


];


$router->addRoutes('POST', $postRoutes);
$router->addRoutes('GET', $getRoutes);

$router->matchRoute();