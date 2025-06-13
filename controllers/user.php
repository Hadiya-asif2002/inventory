<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;

require_once dirname(__FILE__,2) . '/vendor/autoload.php';
class User {


    public static function index() {
        $users = Capsule::table('users')->get();
        $users = json_decode(json_encode($users), true);
        return $users;
    }

    public static function create($data) {
        $userExists = Capsule::table('users')->where('email','=',$data['email'])->value('email');
        if(!$userExists) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $user = Capsule::table('users')->insert($data);
            
            return $user;
        }
        return false;
    }
    public static function update($data) {

    }
    public static function delete($data) {
        $userExists = Capsule::table('users')->where('email','=',$data['email'])->value('email');
        if($userExists) {
            Capsule::table('users')->where('email','=', $data['email'])->delete();
        }
    }

}