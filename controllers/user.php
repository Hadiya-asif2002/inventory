<?php
namespace Controllers;

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';


use \Illuminate\Database\Capsule\Manager as Capsule;
use Helpers\Helpers;
class User
{


    public static function index()
    {
        $users = Capsule::table('users')->get();
        $users = json_decode(json_encode($users), true);
        Helpers::sendJsonResponse(200, 'List of users', $users);
    }

    public static function create($data)
    {
        $userExists = Capsule::table('users')->where('email', '=', $data['email'])->value('email');
        if (!$userExists) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $user = Capsule::table('users')->insert($data);
            Helpers::sendJsonResponse(200, 'User created successfully', $user);
        }
        Helpers::sendJsonResponse(200, 'Account already exists');

    }



    public static function delete($data)
    {
        $userExists = Capsule::table('users')->where('email', '=', $data['email'])->value('email');
        if ($userExists) {
            Capsule::table('users')->where('email', '=', $data['email'])->delete();
            Helpers::sendJsonResponse(200, 'User deleted successfully');
        }
            Helpers::sendJsonResponse(400, 'User not found');
    }

}
