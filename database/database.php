<?php
require_once dirname(__FILE__,2) . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as Capsule;



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

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
