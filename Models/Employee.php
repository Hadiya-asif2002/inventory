<?php

namespace Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Employee extends Eloquent
{
    protected $table = 'employees';

    // Define the relationship with the Department model
    public function department()
    {
        return $this->belongsTo('Models\Department', 'department_id');
    }

    // Define the relationship with the AssignedInventory model
    public function assignedInventory()
    {
        return $this->hasMany('Models\AssignedInventory');
    }
}