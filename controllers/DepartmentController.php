<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Helpers\Helpers;
use \PDOException;

class DepartmentController
{

    public static function index()
    {
        $departments = Capsule::table('departments')->get();
        $departments = json_decode(json_encode($departments), true);
        return Helpers::sendJsonResponse(200, 'Departments retrieved successfully.', $departments);
    }

    public static function create($data)
    {
        $departmentExists = Capsule::table('departments')->where('name', '=', $data['name'])->value('name');
        if (!$departmentExists) {
            $department = Capsule::table('departments')->insert($data);
             return Helpers::sendJsonResponse(201, 'Department created successfully.', $department);
        }
        else{
        return Helpers::sendJsonResponse(400, 'Department already exists.');

        }
    }

    public static function update($data)
    {

        $department = Capsule::table('departments')->where('id', '=', $data['id'])->update(['name' => $data['name']]);
        if ($department) {
            return Helpers::sendJsonResponse(200, 'Department updated successfully.', $department);
        } else {
            return Helpers::sendJsonResponse(400,'Department not found.');
        }
    }

    
    
    public static function createAndUpdate($data)
    {
        if(isset($data['id'])) {
            self::update($data);
        }
        else{
            self::create($data);
        }
    }

    public static function delete($data)
    {
      
        $deleted = Capsule::table('departments')->where('id', '=', $data['id'])->delete();
        if ($deleted) {
            return Helpers::sendJsonResponse(200, 'Department deleted successfully.');
        } else {
            return Helpers::sendJsonResponse(404, 'Department not found.');
        }
    }
}
