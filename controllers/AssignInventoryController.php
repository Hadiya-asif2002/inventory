<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;
use Helpers\Helpers;
// use \PDOException;
// use Models\AssignedInventory;
class AssignInventoryController
{

    public static function index()
    {
        $data = Capsule::table('assigned_inventory as inventory')
        ->select('*',
        'i_items.name as item_name','i_items.id as item_id', 'i_items.value as item_value', 'i_items.category as item_category', 'i_items.subcategory as item_subcategory', 
        'employees.name as employee_name', 'employees.id as employee_id', 'employees.department_id as employee_department_id'        )
        // i want my assigned id, employee id, item id to be correct rest i am  not interested in them
        ->join('employees', 'inventory.employee_id','=','employees.id')
        ->join('inventory_items as i_items','inventory.item_id','=','i_items.id')->groupBy('inventory.id')->get();
        $data = json_decode( json_encode($data), true);
        // $data = AssignedInventory::with(['employee','item'])->get();
        Helpers::sendJsonResponse(200, 'Inventory items retrieved successfully.', $data);
    }

    public static function create($data)
    {
        $items = Capsule::table('assigned_inventory')->insert($data); // return the created item
        Helpers::sendJsonResponse(200, 'Item assigned successfully', $items);
    }


    public static function update($data)
    {
        $isUpdated = Capsule::table('assigned_inventory')->where('id', '=', $data['id'])->update($data);
        if ($isUpdated) {
            Helpers::sendJsonResponse(200, 'Item updated successfully', $isUpdated);

        } else {
            Helpers::sendJsonResponse(400, 'Invalid Data');
        }
    }

    public static function delete($data)
    {
        $deleted = Capsule::table('assigned_inventory')->where('id', '=', $data['id'])->delete();
        if ($deleted) {
            Helpers::sendJsonResponse(200, 'Item deleted successfully.');
        } else {
            Helpers::sendJsonResponse(404, 'Item not found.');
        }
    }
}
