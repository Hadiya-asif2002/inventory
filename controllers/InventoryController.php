<?php
namespace Controllers;
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Helpers\Helpers;
class InventoryController
{

    public static function index()
    {
        $inventory = Capsule::table('inventory_items')->get();
        $inventory = json_decode(json_encode($inventory), true);
        return Helpers::sendJsonResponse(200, 'Inventory items retrieved successfully.', $inventory);
    }

    public static function create($data)
    {
        $items = Capsule::table('inventory_items')->insert($data);
        return Helpers::sendJsonResponse(200, 'Inventory added successfully', $items);
    }

    public static function update($data)
    {
        $isUpdated = Capsule::table('inventory_items')->where('id', '=', $data['id'])->update($data);
        if ($isUpdated) {
            return Helpers::sendJsonResponse(200, 'Item updated successfully', $isUpdated);

        } else {
            return Helpers::sendJsonResponse(400, 'Invalid Data');
        }
    }

    public static function delete($data)
    {

        $deleted = Capsule::table('inventory_items')->where('id', '=', $data['id'])->delete();
        if ($deleted) {
            return Helpers::sendJsonResponse(200, 'Item deleted successfully.');
        } else {
            return Helpers::sendJsonResponse(404, 'Item not found.');
        }
    }
}
