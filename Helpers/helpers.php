<?php
namespace  Helpers;
class  Helpers{

 
    
    public static function sendJsonResponse($statusCode, $message='', $data=array(),array $headers=[]) {

        $response= [
            'status'=> $statusCode,
            'message'=> $message,
        ];
        if($statusCode >=200 && $statusCode < 399){
            $response['data']=$data;
        }else{
            $response['errors']=$data;
        }
         if($headers) {
            foreach($headers as $header) {
                header($header);
            }
        }
        http_response_code(200);
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($response);
        }
    public static function createUpdateTable($tableName, $data) {
        if(isset($data['id'])){
            Capsule::table($tableName)
                ->where('id', $data['id'])
                ->update($data);
        }
        else{
            Capsule::table($tableName)
                ->insert($data);
        }
    }
}
