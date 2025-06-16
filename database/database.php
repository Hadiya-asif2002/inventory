<?php
namespace Database;
require_once dirname(__FILE__,2) . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as Capsule;
use \Exception;


$env = parse_ini_file(".env");
$serverName = $env['SERVERNAME'];
$username = $env['USERNAME'];
$password = $env['PASSWORD'];
$database = $env['DATABASE'];

$capsule = new Capsule;
try{
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $serverName,
    'database' => $database,
    'username' => $username,
    'password' => $password,

]);

}
catch (Exception $e) { 
    var_dump($e);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
