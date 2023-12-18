<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegearInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'death_id',
        'equipment',
        'is_oc_regear',
        'status'
    ];

}
