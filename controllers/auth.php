<?php
namespace Controllers;

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as Capsule;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


use \Carbon\Carbon;
use Mail\Mail;
use Helpers\Helpers;
$key = parse_ini_file('.env')['JWT_KEY'];
define('JWT_KEY', $key);
class Auth
{

    public static function login($data)
    {

        $user = Capsule::table('users')->where('email', '=', $data['email'])->first();
        $user = json_decode(json_encode($user), true);
        if (!$user) {
            return false;
        }
        if (password_verify($data['password'], $user['password'])) {
            $key = 'example_key';
            $expiresAt = time() + 3600;
            $payload = [
                'iss' => 'http://example.org',
                'aud' => 'http://example.com',
                'iat' => time(),
                'nbf' => time(),
                'expires' => $expiresAt,
                'id' => $user['id'],
                'email' => $user['email']
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            $authHeader = ['Authorization: Bearer ' . $jwt];
            setcookie('Authorization', $jwt, time() + 3600);
            return Helpers::sendJsonResponse(200, 'Logged in successfully.', [], $authHeader);
        }
        return Helpers::sendJsonResponse(400, 'Invalid Credentials.');

    }
    public static function logout()
    {
        if (isset($_COOKIE['Authorization'])) {
            setcookie('Authorization', '', time() - 3600);
        }
        return Helpers::sendJsonResponse(200, 'Logged out successfully.');

    }



    public static function resetPassword($data)
    {
        if (isset($_COOKIE['Authorization'])) {
            $token = $_COOKIE['Authorization'];
            $decoded = JWT::decode($token, new Key(JWT_KEY, 'HS256'));
            $oldPassword = $data['oldPassword'];
            $newPassword = $data['newPassword'];

            if ($newPassword == $data['passwordConfirmation']) {
                $user = Capsule::table('users')->where([['id', '=', $decoded->id], ['email', '=', $decoded->email]])->first();
                if ($user && password_verify($oldPassword, $user->password)) {
                    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    Capsule::table('users')->where( 'id','=', $decoded->id)->update(['password'=>$newPassword]);
                    $message = 'Password reset successfully.';
                } else {
                    $message = 'Old password is invalid.';
                }
            } else {
                $message = 'Passwords donot match';
            }
            return Helpers::sendJsonResponse(200, $message);
        }

    }



    public static function submitForgotPasswordForm($data)
    {

        $token = bin2hex(random_bytes(25));
        $expiresAt = Carbon::now()->addMinutes(1440);
        $email = $data['email'];

        Capsule::table('users')->where('email', '=', $email)->update(['expires_at' => $expiresAt, 'forgot_password_token' => $token]);
        $user = Capsule::table('users')->where('email', '=', $email)->first();
        if ($user) {
            $url = 'https://localhost/inventory/reset-password?' . 'email=' . $email . '&token=' . $token;
            Mail::sendMail($user->username, $url);
            return Helpers::sendJsonResponse(200, 'Reset password link sent.', $data);  //improve the status codes
        }
        return Helpers::sendJsonResponse(400, 'Bad request', []);  //improve the status codes

    }
    public static function submitForgotPassword($data)
    {
        if ($data['password'] != $data['passwordconfirmation']) {
            return;
        }
        $email = $data['email'];
        $token = $data['token'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = Capsule::table('users')->where('forgot_password_token', '=', $token)->first();
        if ($user && $user->expires_at > Carbon::now()) {
            Capsule::table('users')->where('email', '=', $email)->update(['password' => $password]);
            self::login($data);
            return Helpers::sendJsonResponse(200, 'Password updated successfully', []);  //improve the status codes

        } else {
            return Helpers::sendJsonResponse(400, 'Bad request', []);  //improve the status codes

        }

    }


}