<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_overtime extends Model
{
    use HasFactory;

    protected $table = "employee_overtime";

    protected $guarded = [];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function overtimes()
    {
        return $this->belongsTo(Overtime::class, 'overtime_id', 'id');
    }
}
