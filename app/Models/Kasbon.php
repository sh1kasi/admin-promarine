<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $table = 'kasbons';
    protected $guarded = [];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
