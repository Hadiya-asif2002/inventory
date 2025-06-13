<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;
use Helpers\Helpers;
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
        $departmentId = Capsule::table('departments')->where('name', '=', $data['department_name'])->value('id');
        if ($departmentId) {
            try {
                unset($data['department_name']);
                $data['department_id'] = $departmentId;
                $employee = Capsule::table('employees')->insert($data);
            } catch (PDOException $e) {
                return Helpers::sendJsonResponse(400, 'Department does not exists.');
            }
            return Helpers::sendJsonResponse(201, 'Employee created successfully.', $employee);
        }
    }

    public static function update($data)
    {
        try {
            $departmentId = Capsule::table('departments')->where('name', '=', $data['department_name'])->value('id');
            if ($departmentId) {
                if (isset($data['new_name'])) {
                    $data['name'] = $data['new_name'];
                    unset($data['new_name']);// that's why we use dto to only get the columns used in our db;
                }
                unset($data['department_name']);
                $data['department_id'] = $departmentId;
                unset($data['id']);
                $employee = Capsule::table('employees')->where('name', '=', $data['name'])->update($data);
                return Helpers::sendJsonResponse(200, 'employee updated successfully', $employee);
            } else {
                $message = 'Department does not exists.';
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        return Helpers::sendJsonResponse(400, $message);

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
