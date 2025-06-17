<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Helpers\Helpers;
use \PDOException;

class EmployeeController
{
    public static function index()
    {
        $employees = Capsule::table('employees')->get();
        $employees = json_decode(json_encode($employees), true);
        return Helpers::sendJsonResponse(200, 'employees retrieved successfully.', $employees);
    }

    public static function create($data)
    {
        $departmentId = Capsule::table('departments')->where('id', '=', $data['department_id'])->value('id');
        if ($departmentId) {
            try {
                $employee = Capsule::table('employees')->insert($data);
            } catch (PDOException $e) {
                return Helpers::sendJsonResponse(500, $e->getMessage());
            }
            return Helpers::sendJsonResponse(201, 'Employee created successfully.', $employee);
        }
    }



    public static function update($data)
    {
        try {
            $departmentId = Capsule::table('departments')->where('id', '=', $data['department_id'])->value('id');
            if ($departmentId) {
                $employee = Capsule::table('employees')->where('id', '=', $data['id'])->update($data);
                return Helpers::sendJsonResponse(200, 'employee updated successfully', $employee);
            } else {
                $message = 'Department does not exists.';
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        return Helpers::sendJsonResponse(400, $message);

    }



    public static function createAndUpdate($data) {
        if(isset($data['id'])) {
            return self::update($data);
        } else {
            return self::create($data);
        }
    }


    
    public static function delete($data)
    {

        $deleted = Capsule::table('employees')->where('id', '=', $data['id'])->delete();
        if ($deleted) {
            return Helpers::sendJsonResponse(200, 'Employee deleted successfully.');
        } else {
            return Helpers::sendJsonResponse(404, 'Employee not found.');
        }
    }
}
