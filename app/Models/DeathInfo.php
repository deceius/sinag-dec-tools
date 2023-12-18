<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathInfo extends Model
{
    protected $fillable = [
        'id',
        'character_id',
        'name',
        'guild',
        'equipment',
        'killer_name',
        'killer_guild',
        'killer_equipment',
        'killer_guild',
        'death_fame',
        'allowed_gears',
        'timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime:Y-m-d H:i',
    ];



}
