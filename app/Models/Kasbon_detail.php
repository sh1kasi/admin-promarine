<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon_detail extends Model
{
    use HasFactory;

    protected $table = 'kasbon_details';

    public function kasbon_details()
    {
        return $this->belongsTo(User::class, 'kasbon_id', 'id');
    }

}



