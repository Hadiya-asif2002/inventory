<?php

namespace Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class InventoryItem extends Eloquent
{
    public function assignedInventory()
    {
        return $this->hasMany('Models\AssignedInventory');
    }
}