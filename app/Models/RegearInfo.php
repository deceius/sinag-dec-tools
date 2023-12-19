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
        'allowed_gears',
        'equipment',
        'is_oc',
        'is_scout',
        'status',
        'remarks'
    ];

}
