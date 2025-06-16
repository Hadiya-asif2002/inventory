<?php

namespace Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class AssignedInventory extends Eloquent
{
   protected $table = 'assigned_inventory';
   public function  employee() {
    return $this->belongsTo('Models\Employee', 'employee_id', 'id');
   }
   public function item() {
    return $this->belongsTo('Models\InventoryItem', 'item_id', 'id');
   }
 }
