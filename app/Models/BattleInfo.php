<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'battle_id',

        'killer_character_id',
        'killer_name',
        'killer_guild',
        'killer_guild_id',
        'killer_equipment',

        'victim_character_id',
        'victim_name',
        'victim_equipment',
        'victim_guild',
        'victim_guild_id',

        'kill_fame',
        'timestamp',
    ];



    protected $casts = [
        'timestamp' => 'datetime:Y-m-d H:i',
    ];
}
