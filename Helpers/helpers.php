<?php
namespace Helpers;
class Helpers{
    public static function sendHttpResponse($message, $statusCode) {
    http_response_code($statusCode); // Set the HTTP status code
    header('Content-Type: text/html; charset=UTF-8'); // Set the Content-Type header
    echo $message; // Output the content
    }
 
    public static function sendJsonResponse($statusCode, $message='', $data=array(),array $headers=[]) {
        if($headers) {
            foreach($headers as $header) {
                header($header);
            }
        }
        $response= [
            'status'=> $statusCode,
            'message'=> $message,
            'data'=>$data
        ];
        http_response_code(200);
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($response);
        }
    
}